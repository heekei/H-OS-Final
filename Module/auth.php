<?php 
header("Content-type: application/json ;charset=utf-8");
session_start();
if($_POST["logout"]==true){
    $_SESSION["IsLogin"]=false;
    unset($_SESSION["UserName"]);
    echo json_encode(array("res"=>true));
    exit;
}
// 引入配置文件
require "config.php";
// 连接数据库
$con =new mysqli($server_URL,$user_name,$pwd,$db_name);
if ($con->connect_error){
    die('Could not connect: ' . mysqli_error());
}
else {
    mysqli_query("set character set 'utf8'");//读库 
    mysqli_query("set names 'utf8'");//写库
    mysqli_query("set character_set_client=utf8");
    mysqli_query("set character_set_results=utf8");
}
// 引入数据库操作函数
require "funcs.php";
//创建数据表，
create_table($pre_name);
$IsLogin =doLogin($_POST["username"],$_POST["password"]);
$_SESSION["IsLogin"]=$IsLogin;
if($IsLogin===true){
    $_SESSION["UserName"]=$_POST["username"];
}
echo json_encode(array("res"=>$IsLogin));
?>