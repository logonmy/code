<?php
    require('./connect.php');
   if(empty($_POST['time']))exit();    
set_time_limit(0);//无限请求超时时间    
$i=0;    
while (true){    
    //sleep(1);    
    usleep(500000);//0.5秒    
    $i++;    
    $data = $redis->get('data');
    if(!empty($data)){    
        $arr=array('success'=>"1",'name'=>'xiaocai','text'=>$data);    
        $redis->delete('data');
        echo json_encode($arr);    
        exit();    
    }    
        
    //服务器($_POST['time']*0.5)秒后告诉客服端无数据    
    if($i==$_POST['time']){    
        $arr=array('success'=>"0",'name'=>'xiaocai','text'=>$rand);    
        echo json_encode($arr);    
        exit();    
    }    
}  
