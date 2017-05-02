<?php
    include("db.php");
    include("check_login.php");
    $projectid=isset($_GET['projectid'])?$_GET['projectid']:null;
    $pape=isset($_GET['pape'])?$_GET['pape']:null;
    $eachpape_num=5;
    $result=$mysqli->query("select projectid,projectname from project");
    $rows=array();
    for($row=array();$row=$result->fetch_array(MYSQLI_ASSOC);)
    {
        $rows[]=$row;
    }
    $previous_url="index.php";
    $next_url="index.php";
    if($pape!=null)
    {
        $pape=intval($pape);
        $limit="limit ".($pape*$eachpape_num).",".$eachpape_num;
        $previous_url.="?pape=".($pape-1);
        $next_url.="?pape=".($pape+1);
    }
    else
    {
        $pape=0;
        $limit="limit 0,".$eachpape_num;
        $previous_url.="?pape=0";
        $next_url.="?pape=1";
    }
    if($projectid!=null)
    {
        $projectid=intval($projectid);
        $where="where r.projectid=".$projectid;
        $previous_url.="&projectid=".$projectid;
        $next_url.="&projectid=".$projectid;
    }
    else
    {
        $where="";
    }
    $papesumr=$mysqli->query("select count(rid) sum from record r ".$where);
    $papesumr=$papesumr->fetch_array(MYSQLI_ASSOC);
    $papesum=$papesumr['sum'];
    $result=$mysqli->query("select r.rid rid,p.projectname projectname,r.breakpeople breakpeople,r.detial detial,r.date date from record r join project p on r.projectid=p.projectid ".$where." order by date desc ".$limit);
    $recordrows=array();
    for($row=array();$row=$result->fetch_array(MYSQLI_ASSOC);)
    {
        $recordrows[]=$row;
    }
?>
<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <title>查看记录</title>
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
                margin: 0 auto;
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
                <h3 class="panel-title">查看记录</h3>
            </div>
            <div class="panel-body">
                <div class="well">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            项目 <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="show.php">全部</a></li>
                            <?php
                                foreach ($rows as $key => $value) 
                                {
                            ?>
                                <li><a href="show.php?projectid=<?php echo $value['projectid']; ?>"><?php echo $value['projectname']; ?></a></li>
                            <?php
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="list-group">
                    <?php
                        foreach ($recordrows as $key => $value) 
                        {
                    ?>
                            <a href="edit.php?rid=<?php echo $value['rid'];?>" class="list-group-item">
                                <h4 class="list-group-item-heading"><?php echo $value['projectname'];?></h4>
                                <h6><?php echo $value['breakpeople'];?>&nbsp;&nbsp;<small><u><?php echo $value['date'];?></u></small></h6>
                                <p class="list-group-item-text"><?php echo $value['detial'];?></p>
                            </a>
                    <?php
                        }
                    ?>
                    
                </div>
                <div>
                    <div class="pagination pagination-success">
                        <a href="<?php echo $previous_url; ?>" class="btn btn-inverse previous <?php if($pape==null||$pape==0){echo "disabled";} ?>">上一页</a>
                        <a href="<?php echo $next_url; ?>" class="btn btn-inverse next <?php if($pape>=(ceil($papesum/$eachpape_num)-1)){echo "disabled";} ?>">下一页</a>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once("footer.php"); ?>
    </body>
</html>