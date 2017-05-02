<?php
    include_once("db.php");
    $project=array();
    $project['name']=isset($_POST['projectname'])?$_POST['projectname']:null;
    if($project['name']!=null)
    {
        $result=$mysqli->query("select projectid from project where projectname='".$project['name']."'");
        if($result->num_rows==0)
        {
            $mysqli->query("insert into project(projectname) values('".$project['name']."')");
            $result=$mysqli->query("select projectid from project where projectname='".$project['name']."'");
            if($result)
            {
                $row=$result->fetch_array(MYSQLI_ASSOC);
                $project['projectid']=$row['projectid'];
                $project['ret']=1;
            }
            else
            {
                $project['ret']=-1;
            }
        }
        else
        {
            $project['ret']=2;
        }  
    }
    else
    {
        $project['ret']=3;
    }
    echo json_encode($project);
?>