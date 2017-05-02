<?php
    include("db.php");
    include("check_login.php");
    $rid=isset($_POST['rid'])?$_POST['rid']:null;
    if($rid!=null)
    {
        $rid=intval($rid);
        if($mysqli->query("delete from record where rid=".$rid))
        {
            $return['ret']=1;
        }
        else
        {
            $return['ret']=-1;
        }
    }
    else
    {
        $return['ret']=-1;
    }
    echo json_encode($return);
?>