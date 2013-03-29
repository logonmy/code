<?php
/*Connect to a MySQL server*/
$conn = mysqli_connect('localhost', 'root', '123456', 'g3db');
if(!$conn) {
   printf("cant connect to MySQL Server, Errorcode: %s", mysqli_connect_error()); 
   exit;
}


