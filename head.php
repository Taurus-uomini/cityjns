<?php
    $uid=isset($_SESSION['uid'])?$_SESSION['uid']:null;
    if($uid!=null)
    {
        $uid=intval($uid);
        $result=$mysqli->query("select * from users where uid=".$uid);
        $userrow=$result->fetch_array(MYSQLI_ASSOC);
    }
    else
    {
        $userrow=null;
    }
?>
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    </button>
                    <a class="navbar-brand" href="index.php">城院吉尼斯</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="index.php">主页</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php
                            if($userrow==null)
                            {
                        ?>
                            <li><a href="login.php">管理员登录</a></li>
                        <?php
                            }
                            else
                            {
                        ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $userrow['username']; ?><span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="show.php">查看记录</a></li>
                                    <li><a href="add.php">增加记录</a></li>
                                    <li><a href="logout.php">注销</a></li>
                                </ul>
                            </li>
                        <?php
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>