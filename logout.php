<?php
    Session_start();
    unset($_SESSION['uid']);
    echo "<script>window.location.href='login.php';</script>";
?>