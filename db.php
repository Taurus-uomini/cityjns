<?php
    Session_start();
    $mysqli=new mysqli("localhost","root","","cityjns");
    if($mysqli->connect_errno)
    {
        echo $mysqli->connect_error;
    }
    $mysqli->set_charset("utf8");
?>