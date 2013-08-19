<?php

if($_GET) {
    $keywords = $_GET['keyword'];
}else{
    $keywords = $_POST['keyword'];
}

if(empty($keywords)) {
    echo 'strive';
}else{
    echo $keywords;
}

