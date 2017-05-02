<?php
    include("db.php");
    if(isset($_POST['hasval']))
    {
        $username=isset($_POST['username'])?$_POST['username']:null;
        $password=isset($_POST['password'])?$_POST['password']:null;
        if($username!=null&&$password!=null)
        {
            $password=md5($password.$username);
            $result=$mysqli->query("select uid from users where username='".$username."' and password='".$password."'");
            if($result->num_rows==1)
            {
                $usersrow=$result->fetch_array(MYSQLI_ASSOC);
                $_SESSION['uid']=$usersrow['uid'];
                echo "<script>window.location.href='show.php';</script>";
            }
            else
            {
                echo "<script>alert('用户名或密码错误！');window.location.href='login.php';</script>";
            }
        }
        else
        {
            echo "<script>alert('有未填项！');window.location.href='login.php';</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <title>登录</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/flat-ui.min.css">
        <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
        <script src="js/flat-ui.min.js"></script>
        <script src="js/application.js"></script>
        <style type="text/css">
            .main
            {
                width: 60%;
                margin: 0 auto;
                margin-top: 60px;
            }
            .text_input
            {
                margin: 20px auto;
                width: 60%;
            }
            .btn-submit
            {
                margin-top: 10px;
            }
            .btn-addselect
            {
                margin-left: 10%;
            }
        </style>
        <script type="text/javascript">
            
        </script>
    </head>
    <body>
        <?php include_once("head.php"); ?>
        <div class="panel panel-default main">
            <div class="panel-heading">
                <h3 class="panel-title">登录</h3>
            </div>
            <div class="panel-body">
                <form method="POST">
                    <div class="control-group text_input">
                        <div class="controls">
                            <input type="text" name="username" placeholder="用户名" class="form-control">
                        </div>
                    </div>
                    <div class="control-group text_input">
                        <div class="controls">
                            <input type="password" name="password" placeholder="密码" class="form-control">
                        </div>
                    </div>
                    <div class="control-group text_input">
                        <div class="controls">
                            <input type="hidden" name="hasval" value="1">
                            <button type="submit" class="btn btn-primary btn-submit">登录</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php include_once("footer.php"); ?>
    </body>
</html>