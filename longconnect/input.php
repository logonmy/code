<?php
    require('./connect.php');
	$data = !empty($_POST['data']) ? $_POST['data'] : '';
//	$redis->set('data', $data);   //字符
    $redis->lpush('msg', $data);
?>
<html>
   <head>
      <title>persist connect</title>
   </head>
   <body>
      <form action="" method="post">
         数据<input type="text" name="data"/></br>
            <input type="submit" value="发送"/>
      </form>
   </body>
</html>
