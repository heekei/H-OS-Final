<?php
session_start();
if(@$_SESSION["IsLogin"]!==true){
	//重定向浏览器   
	header("Location: /login.html");
	//确保重定向后，后续代码不会被执行   
	exit;
}
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <title>H-OS在线操作系统</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/context.bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/context.js"></script>
    <script src="js/index.js"></script>
</head>

<body>
    <div class="wraper">
        <nav class="navbar navbar-default navbar-static-top" style="margin-bottom: 0;">
            <div class="navbar-header">
                <a class="navbar-brand" href="javascript:void(0);">H-OS在线操作系统</a>
            </div>
            <div class="hd-user">
                <div class="avatar"><img src="images/avatar.jpg" alt=""></div>
                <div class="uname">
                    <a class="uname-name" href="#"><?php echo urldecode($_SESSION["Nickname"])?></a>
                    <span class="caret"></span>
                </div>
                <span class="logout icon-power-off icon-2x"></span>
            </div>
            <div class="side-nav nav-pills">
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="#Dashboard"><i class="icon-dashboard icon-large"></i>控制台</a></li>
                    <li><a href="#AppManager"><i class="icon-tasks icon-large"></i>应用管理</a></li>
                    <li><a href="#Setting"><i class="icon-cog icon-large"></i>系统设置</a></li>
                    <li><a href="#Profile"><i class="icon-user icon-large"></i>个人资料</a></li>
                </ul>
            </div>
        </nav>
        <div class="main">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#">应用管理</a><i class="icon-remove"></i></li>
            </ul>
            <div class="tab-pages">
                <div class="tab-page active">
                    <?php 
                        require "View/AppManager.php"
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>