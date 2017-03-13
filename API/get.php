<?php 

//输出header
header("Content-type: application/json ;charset=utf-8");
//开启 session
session_start();

if($_SESSION["IsLogin"]!==true) {
    echo '{"res":"unauthorized"}';
    exit;
};
//引入配置文件
require "../Module/config.php";
//连接数据库
$con =new mysqli($server_URL,$user_name,$pwd,$db_name);
//如果连接数据库失败，返回错误。
if ($con->connect_error){
    die('Could not connect: ' . mysqli_error($con));
}
//引入数据库操作函数
require "../Module/funcs.php";

echo(get_JSON())
?>