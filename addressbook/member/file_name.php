<?php
    function get_name($file_name){
        $i = strpos($file_name, '.');
        $ext_name = substr($file_name, $i);
        $str = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789');
        $name = substr($str, 1,20);
        return $name.$ext_name;
    }
?>