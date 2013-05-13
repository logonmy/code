<?php

class Digest extends Controller {

    function index()
    {
	    session_start();
	   
	    $realm = 'My Realm';
	    $logged = false;
	    //user => password
	    $users = array('admin' => '1234', 'user2' => 'psw2'); // ...
	
	   
	    // We need to test which server authentication variable to use
	    // because the PHP ISAPI module in IIS acts different from CGI
	    if(isset($_SERVER['PHP_AUTH_DIGEST']))
	    {
	        $auth_data = $_SERVER['PHP_AUTH_DIGEST'];
	    }
	    elseif(isset($_SERVER['HTTP_AUTHORIZATION']))
	    {
	        $auth_data = $_SERVER['HTTP_AUTHORIZATION'];
	    }
	    else
	    {
	    	$auth_data = "";
	    }
	    
	    /* The $_SESSION['error_prompted'] variabile is used to ask
	       the password again if none given or if the user enters
	       a wrong auth. informations. */
	    if (
	        ($auth_data == "") ||
	        (isset($_SESSION['error_prompted']) && $_SESSION['error_prompted']==true)
	       )
	    {
	        $uniqid = uniqid(""); // Empty argument for backward compatibility
	        $_SESSION['error_prompted'] = false;
	        header('HTTP/1.1 401 Unauthorized');
	        header('WWW-Authenticate: Digest realm="'.$realm.
	               '" qop="auth" nonce="'.$uniqid.'" opaque="'.md5($realm).'"');
	    
	        die("You're not allowed to access this page.");
	    }
	    else
	    {
	        // We need to retrieve authentication informations from the $auth_data variable
	            
	            preg_match_all('@(username|nonce|uri|nc|cnonce|qop|response)'.
	                    '=[\'"]?([^\'",]+)@', $auth_data, $t);
	    		$digest = array_combine($t[1], $t[2]); 
	            
	            // Sometimes ISAPI uses qop="auth", and sometimes it uses qop=auth
	            $digest['qop'] = str_replace("\"", "", $digest['qop']);
	       
	        if (!isset($users[$digest['username']]))
	        {
	            
	            $_SESSION['error_prompted'] = true;
	            die('Username not valid! ');
	        }
	        else
	        {    
	            // This is the valid response expected
	            $A1 = md5($digest['username'] . ':' . $realm . ':' . $users[$digest['username']]);
	            $A2 = md5($_SERVER['REQUEST_METHOD'].':'.$digest['uri']);
	            $valid_response = md5($A1.':'.$digest['nonce'].':'.$digest['nc'].':'.
	                                  $digest['cnonce'].':'.$digest['qop'].':'.$A2);
	            
	            if ($digest['response'] != $valid_response)
	            {
	                $error_message = 'Wrong Credentials!';
	                $_SESSION['error_prompted'] = true;
	            }
	            else
	            {
	                // Ok, valid user/password
	                echo 'You are logged in as: ' . $digest['username'];
	                $logged = true;
	            }
	        }
	    }
      
    }

}

?>