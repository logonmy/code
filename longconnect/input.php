<?php
	$redis = new Redis();
	$redis->connect('127.0.0.1', 6379);
	$data = $_POST['data'];
	$redis->set('data', $data);
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