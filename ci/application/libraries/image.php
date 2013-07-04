<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Image {
    var $url = '';
    function My_image($url) {
        echo "<hr/>"; 
        echo "<font color='red'>The url is:$url"."</font>";
        echo "<hr/>";
    }

    function Re_image($name) {
        echo "The image name is $name"; 
    }

    function A_image() {
        return "AA"; 
    }
}
