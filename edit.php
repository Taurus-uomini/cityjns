<?php
    include("db.php");
    include("check_login.php");
    if(isset($_POST['hasval']))
    {
        $rid=isset($_POST['rid'])?$_POST['rid']:null;
        $people=isset($_POST['people'])?$_POST['people']:null;
        $detial=isset($_POST['detial'])?$_POST['detial']:null;
        $date=isset($_POST['date'])?$_POST['date']:null;
        if($people==null||$detial==null||$date==null)
        {
            echo "<script>alert('有未填项！');window.location.href='edit.php?rid=".$rid."';</script>";
        }
        else if($rid==null)
        {
            echo "<script>alert('无效访问！');window.location.href='edit.php?rid=".$rid."';</script>";
        }
        else
        {
            $name=intval($name);
            if($mysqli->query("update record set breakpeople='".$people."',detial='".$detial."',date='".$date."' where rid=".$rid))
            {
                echo "<script>alert('修改成功！');window.location.href='edit.php?rid=".$rid."';</script>";
            }
            else
            {
                echo "<script>alert('修改失败！');window.location.href='edit.php?rid=".$rid."';</script>";
            }
        }
        $mysqli->close();
    }
    else
    {
        $rid=isset($_GET['rid'])?$_GET['rid']:null;
        $recordrow=null;
        if($rid!=null)
        {
            $result=$mysqli->query("select r.rid rid,p.projectname projectname,r.breakpeople breakpeople,r.detial detial,r.date date from record r join project p on r.projectid=p.projectid where r.rid=".$rid);
            $recordrow=$result->fetch_array(MYSQLI_ASSOC);
        }
        
    }
?>
<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <title>修改记录</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/flat-ui.min.css">
        <link href="css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">
        <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
        <script src="js/flat-ui.min.js"></script>
        <script src="js/application.js"></script>
        <script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
        <script type="text/javascript" src="js/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
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
            function addZeor(tm)
            {
                if(tm<10)
                {
                    return '0'+tm;
                }
                else
                {
                    return tm;
                }
            }
            function getNow(today)
            {
                var now='';
                now+=today.getFullYear()+'-'+addZeor(today.getMonth()+1)+'-'+addZeor(today.getDate())+' '+addZeor(today.getHours())+':'+addZeor(today.getMinutes());
                return now;
            }
            $(document).ready(function()
            {
                $("#date").val("<?php echo $recordrow['date']; ?>");
                $("#date").datetimepicker(
                    {
                        format:'yyyy-mm-dd hh:ii',
                        minuteStep:1,
                        autoclose:true,
                        todayBtn:true,
                        todayHighlight:true,
                        language:'zh-CN'
                    }
                );
                $("#btn_delete_record").click(function()
                {
                    var rid=$("#rid").val();
                    $.post("ajax_delete_record.php", 
                    { 
                        "rid": rid 
                    },
                    function(data)
                    {
                        if(data.ret==1)
                        {
                               window.location.href="show.php";
                        }
                        else
                        {
                            alert("删除失败！");
                        }
                    }, "json");
                });
            });
        </script>
    </head>
    <body>
        <?php include_once("head.php"); ?>
        <div class="panel panel-default main">
            <div class="panel-heading">
                <h3 class="panel-title">记录修改表单</h3>
            </div>
            <div class="panel-body">
                <?php
                    if($recordrow!=null)
                    {
                 ?>
                <form class="form-horizontal" method="post">
                    <fieldset>
                    <div class="control-group text_input">
                        <label class="control-label" for="name">记录项目名</label>
                        <div class="controls">
                            <select data-toggle="select" id="name" name="name" disabled  class="form-control select select-inverse">
                                    <option value=""><?php echo $recordrow['projectname']; ?></option>
                            </select>
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="control-group text_input">
                        <label class="control-label" for="people">记录保持人</label>
                        <div class="controls">
                            <input type="text" id="people" name="people" value="<?php echo $recordrow['breakpeople']; ?>" placeholder="记录保持人" class="form-control">
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="control-group text_input">
                        <label class="control-label">记录详细信息</label>
                        <div class="controls">
                            <div class="textarea">
                                <textarea class="form-control" name="detial"><?php echo $recordrow['detial']; ?> </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="control-group text_input">
                        <label class="control-label" for="date">记录创造日期</label>
                        <div class="controls">
                            <input type="text" id="date" name="date" readonly />
                        </div>
                    </div>
                    <div class="control-group text_input">
                        <div class="controls">
                            <input type="hidden" name="hasval" value="1" />
                            <input type="hidden" name="rid" id="rid" value="<?php echo $recordrow['rid']; ?>" />
                            <button type="submit" class="btn btn-primary btn-submit">修改</button>
                            <button type="button" id="btn_delete_record" class="btn btn-warning btn-submit">删除</button>
                        </div>
                    </div>
                    </fieldset>
                </form>
                <?php
                    }
                ?>
            </div>
        </div>
        <?php include_once("footer.php"); ?>
    </body>
</html>