<?php
    $uid=isset($_SESSION['uid'])?$_SESSION['uid']:null;
    if($uid==null)
    {
        echo "<script>window.location.href='login.php';</script>";
    }
?>