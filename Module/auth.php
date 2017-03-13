<?php
//输出header
header("Content-type: application/json ;charset=utf-8");
//开启 session
session_start();
//注销登录
if($_POST["method"]=="logout"){
    $_SESSION["IsLogin"]=false;
    unset($_SESSION["UID"]);
    unset($_SESSION["Username"]);
    unset($_SESSION["Password"]);
    unset($_SESSION["Email"]);
    unset($_SESSION["Nickname"]);
    unset($_SESSION["Json"]);
    echo json_encode(array("res"=>true));
    exit;
}
//引入配置文件
require "config.php";
//连接数据库
$con =new mysqli($server_URL,$user_name,$pwd,$db_name);
//如果连接数据库失败，返回错误。
if ($con->connect_error){
    die('Could not connect: ' . mysqli_error($con));
}
//引入数据库操作函数
require "funcs.php";
//创建数据表，
create_table($pre_name);

//登录
if($_POST["method"]=="login"){
    $IsLogin = doLogin($_POST["username"],$_POST["password"]);//jsonString
    $arr = json_decode($IsLogin,true);//jsonString -> array
    $_SESSION["IsLogin"]=$arr["res"];//记录登录状态
    if($arr["res"]===true){
        $_SESSION["UID"] = $arr["data"][0]["ID"];//记录ID
        $_SESSION["Username"]=$arr["data"][0]["Username"];//记录用户名
        $_SESSION["Password"]=$arr["data"][0]["Password"];//记录密码
        $_SESSION["Email"]=$arr["data"][0]["Email"];//记录邮箱
        $_SESSION["Nickname"]=$arr["data"][0]["Nickname"];//记录昵称
        $_SESSION["Json"]=urldecode($arr["data"][0]["Json"]);//记录Json
        echo json_encode(array("res"=>$arr["res"],"Nickname"=>$arr["data"][0]["Nickname"]));
    }
    else{
        echo json_encode(array("res"=>$arr["res"]));
    }
}
//注册
if($_POST["method"]=="reg"){
    $resReg = regUser(
                    $_POST["username"]?$_POST["username"]:$_SESSION["Username"],
                    $_POST["password"]?$_POST["password"]:$_SESSION["Password"],
                    $_POST["email"]?$_POST["email"]:$_SESSION["Email"],
                    $_POST["nickname"]?$_POST["nickname"]:$_SESSION["Nickname"]
                );
    echo $resReg;
}
// 更新信息
if($_POST["method"]=="update"){
    $resUpdate = updateUser($_SESSION["UID"],
                    $_POST["username"]?$_POST["username"]:$_SESSION["Username"],
                    $_POST["password"]?$_POST["password"]:$_SESSION["Password"],
                    $_POST["email"]?$_POST["email"]:$_SESSION["Email"],
                    $_POST["nickname"]?$_POST["nickname"]:$_SESSION["Nickname"]
                );
    echo $resUpdate;
}
//更新应用数据
if($_POST["method"]=="updateApps"){
    // $AppArr = array(
    //             "app_id"=>intval($_POST["app_id"]),
    //             "name"=>$_POST["app_name"],
    //             "title"=>$_POST["app_title"],
    //             "url"=>$_POST["app_url"],
    //             "icon"=>$_POST["app_icon"]
    //         );
    // $AppJson = json_encode($AppArr);
    $AppJson = json_encode($_POST["appjson"]);
    // $serverJsonStr = $_SESSION["Json"];//服务器端json字符串
    // $clientJsonArr = json_decode($serverJsonStr,true);//服务器端json字符串转换为数组
    // array_push($clientJsonArr["apps"],$AppArr);//插入新数据
    // $clientJsonStr = json_encode($clientJsonArr);
    $resUpdateJson = updateApp(urlencode($AppJson));//url转码
    echo $resUpdateJson;
}
//更新系统设置
if($_POST["method"]=="updateSetting"){
    
}
?>