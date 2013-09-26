<?php
	if(empty($_POST['time'])) exit();
    set_time_limit(0);
    $i=0;
    while(true) {
       usleep(500000); 
       $i++;

       $rand = rand(1, 999);
       if($rand<=15) {
          $arr = array('success' => "1", 'name' => 'xiaoci', 'text' => $rand); 
          echo json_encode($arr);
          exit();
       }
    }
