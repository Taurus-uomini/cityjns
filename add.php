<?php
    include("db.php");
    include("check_login.php");
    if(isset($_POST['hasval']))
    {
        $name=isset($_POST['name'])?$_POST['name']:null;
        $people=isset($_POST['people'])?$_POST['people']:null;
        $detial=isset($_POST['detial'])?$_POST['detial']:null;
        $date=isset($_POST['date'])?$_POST['date']:null;
        if($name==null||$people==null||$detial==null||$date==null)
        {
            echo "<script>alert('有未填项！');window.location.href='add.php';</script>";
        }
        else
        {
            $name=intval($name);
            if($mysqli->query("insert into record(projectid,breakpeople,detial,date) values(".$name.",'".$people."','".$detial."','".$date."')"))
            {
                echo "<script>alert('添加成功！');window.location.href='add.php';</script>";
            }
            else
            {
                echo "<script>alert('添加失败！');window.location.href='add.php';</script>";
            }
        }
        $mysqli->close();
    }
    else
    {
        $result=$mysqli->query("select projectid,projectname from project");
        $rows=array();
        for($row=array();$row=$result->fetch_array(MYSQLI_ASSOC);)
        {
            $rows[]=$row;
        }
    }
?>
<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <title>增加记录</title>
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
                var today=new Date();
                var now=getNow(today);
                $("#date").val(now);
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
                $("#btn_add_project").click(function()
                {
                    $('#add_project').modal('show');
                });
                $("#btn_save_project").click(function()
                {
                    var projectname=$("#projectname").val();
                    if(projectname!=null&&projectname!="")
                    {
                        $.post("ajax_add_project.php", 
                        { 
                            "projectname": projectname 
                        },
                        function(data)
                        {
                            if(data.ret==1)
                            {
                                $("#name").append("<option value='"+data.projectid+"'>"+data.name+"</option>");
                                $('#add_project').modal('hide');
                                $("#projectname").val("");
                            }
                            else if(data.ret==2)
                            {
                                alert("项目名已存在！");
                            }
                            else if(data.ret==3)
                            {
                                alert("项目名称不能为空！");
                            }
                            else
                            {
                                alert("添加失败！");
                            }
                        }, "json");
                    }
                    else
                    {
                        alert("项目名称不能为空！");
                    }
                });
            });
        </script>
    </head>
    <body>
        <?php include_once("head.php"); ?>
        <div class="panel panel-default main">
            <div class="panel-heading">
                <h3 class="panel-title">记录提交表单</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" method="post">
                    <fieldset>
                    <div class="control-group text_input">
                        <label class="control-label" for="name">记录项目名</label>
                        <div class="controls">
                            <select data-toggle="select" id="name" name="name" class="form-control select select-inverse">
                                <?php 
                                    foreach ($rows as $key => $value) 
                                    {   
                                ?>
                                    <option value="<?php echo $value['projectid']; ?>"><?php echo $value['projectname']; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                            <button title="增加项目" data-placement="top" data-toggle="tooltip" type="button" class="btn btn-inverse btn-addselect" id="btn_add_project">+</button>
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="control-group text_input">
                        <label class="control-label" for="people">记录保持人</label>
                        <div class="controls">
                            <input type="text" id="people" name="people" placeholder="记录保持人" class="form-control">
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="control-group text_input">
                        <label class="control-label">记录详细信息</label>
                        <div class="controls">
                            <div class="textarea">
                                <textarea class="form-control" name="detial"> </textarea>
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
                            <button type="submit" class="btn btn-primary btn-submit">提交</button>
                        </div>
                    </div>
                    </fieldset>
                </form>
                <div class="modal fade bs-example-modal-sm" id="add_project" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">增加项目</h4>
                            </div>
                            <div class="modal-body">
                                <input type="text" name="projectname" id="projectname" placeholder="项目名称" />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                <button type="button" class="btn btn-primary" id="btn_save_project">保存</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once("footer.php"); ?>
    </body>
</html>