<?php
    function out($str){
        echo utf8_decode($str);
    }
    function convCN($str){
        return utf8_decode($str);
    }
    //创建表
    function create_table($pre_name){
        $sql = "CREATE TABLE IF NOT EXISTS `hos_users` (
                `ID` int(11) NOT NULL AUTO_INCREMENT,
                `Username` text,
                `Password` text,
                `Email` text,
                PRIMARY KEY (`ID`)
                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3";
        // mysqli_query($sql);
        $GLOBALS["con"]->query($sql);
    }
    //登录验证
    function doLogin($uname,$pwd){
        $tname = $GLOBALS["users"];
        $sql = "SELECT * FROM `$tname` where Username='$uname' and Password='$pwd'";
        $result = $GLOBALS["con"]->query($sql);
        $p = array();
        if ($result->num_rows > 0) {
            $res =true;
            $i = 0;
            while($row = $result->fetch_assoc()) {
                $p[$i]=$row;
                $i++;
            }
        } else {
            $res=false;
        }
        $GLOBALS["con"]->close();
        return json_encode(array("res"=>$res,"data"=>$p));
    }
    // 注册用户
    function regUser($Username,$Password,$Email,$Nickname/*,$Json*/){
        $tname = $GLOBALS["users"];
        $sql = "SELECT * FROM `$tname` where Username='$Username'";
        $result = $GLOBALS["con"]->query($sql);
        if ($result->num_rows > 0) {
            $arr=array("res"=>false,"text"=>"用户名已存在");
            return json_encode($arr);
        }
        else{
            $tname= $GLOBALS["users"];
            $sql = "INSERT INTO `$tname`(`ID`, `Username`, `Password` , `Email` , `Nickname`,`Json`) VALUES (NULL,'$Username', '$Password', '$Email' ,'$Nickname','')";
            $result = $GLOBALS["con"]->query($sql);
            $arr=array("res"=>$result,"text"=>mysqli_error($GLOBALS["con"]));
            $jsonStr =json_encode($arr);
            return $jsonStr;
        }
    }
    // 更新用户资料
    function updateUser($UID,$Username,$Password,$Email,$Nickname/*,$Json*/){
        $tname= $GLOBALS["users"];
        $sql = "UPDATE `$tname` 
                SET `Username`='$Username',
                `Password`='$Password',
                `Email`='$Email',
                `Nickname`='$Nickname'
                WHERE `ID`= $UID";
        $result = $GLOBALS["con"]->query($sql);
        if($result==true){
            $_SESSION["Username"]=$Username;//记录用户名
            $_SESSION["Password"]=$Password;//记录密码
            $_SESSION["Email"]=$Email;//记录邮箱
            $_SESSION["Nickname"]=$Nickname;//记录昵称
            // $_SESSION["Json"]=$Json;
        }
        $arr=array("res"=>$result,"text"=>mysqli_error($GLOBALS["con"]));
        $jsonStr =json_encode($arr);
        return $jsonStr;
    }
    // 更新应用信息
    function updateApp($Json)
    {
        $UID = $_SESSION["UID"];
        $tname = $GLOBALS["users"];
        $sql = "UPDATE `$tname` SET `Json`='$Json' WHERE `ID`= $UID";
        $result = $GLOBALS["con"]->query($sql);
        if($result==true){
            $_SESSION["Json"]=urldecode($Json);//url解码
        }
        $arr=array("res"=>$result,"text"=>mysqli_error($GLOBALS["con"]));
        $jsonStr =json_encode($arr);
        return $jsonStr;
    }
    // 更新系统设置
    function updateSystemsetting($Json)
    {
        $UID = $_SESSION["UID"];
        $tname = $GLOBALS["users"];
        $sql = "UPDATE `$tname` SET `Systemsetting`='$Json' WHERE `ID`= $UID";
        $result = $GLOBALS["con"]->query($sql);
        if($result==true){
            $_SESSION["Systemsetting"]=urldecode($Json);//url解码
        }
        $arr=array("res"=>$result,"text"=>mysqli_error($GLOBALS["con"]));
        $jsonStr =json_encode($arr);
        return $jsonStr;
    }
?>