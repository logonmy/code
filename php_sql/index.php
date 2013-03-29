<?php
include('connect.php');

$sql = "SELECT * FROM _tmp_bookmarks LIMIT 10";
$result = mysqli_query($conn, $sql);
if(!empty($result)) {
   while($row = mysqli_fetch_assoc($result)) {
       printf("%s", $row['BmID']);
   } 
   mysqli_free_result($result);
}
mysqli_close($conn);
