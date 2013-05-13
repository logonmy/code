<?php

require(APPPATH.'/libraries/REST_Controller.php');

class Example_api extends REST_Controller {

    function user_get()
    {
        if(!$this->get('id'))
        {
        	$this->responce(NULL, 404);
        }
    	
    	//$user = $this->some_model->getSomething( $this->get('id') );
        $user = array('id' => $this->get('id'), 'name' => $this->get('name'), 'email' => 'example@example.com');
        
        if($user)
        {
            $this->responce($user, 200); // 200 being the HTTP responce code
        }

        else
        {
            $this->responce(NULL, 404);
        }
    }
    
    function user_post()
    {
        //$this->some_model->deletesomething( $this->get('id') );
        $message = array('id' => $this->get('id'), 'name' => $this->post('name'), 'email' => $this->post('email'), 'message' => 'ADDED!');
        
        $this->responce($message, 200); // 200 being the HTTP responce code
    }
    
    function user_delete()
    {
        //$this->some_model->deletesomething( $this->get('id') );
        $message = array('id' => $this->get('id'), 'message' => 'DELETED!');
        
        $this->responce($message, 200); // 200 being the HTTP responce code
    }
    
    function users_get()
    {
        //$users = $this->some_model->getSomething( $this->get('limit') );
        $users = array(
			array('id' => 1, 'name' => 'Some Guy', 'email' => 'example1@example.com'),
			array('id' => 2, 'name' => 'Person Face', 'email' => 'example2@example.com'),
			array('id' => 3, 'name' => 'Scotty', 'email' => 'example3@example.com'),
		);
        
        if($users)
        {
            $this->responce($users, 200); // 200 being the HTTP responce code
        }

        else
        {
            $this->responce(NULL, 404);
        }
    }
    
}

?>