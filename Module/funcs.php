<?php
    function out($str){
        echo utf8_decode($str);
    }
    function convCN($str){
        return utf8_decode($str);
    }
    /** 
    * create_table  
    * 函数的含义说明 
    * 
    * @access public 
    * @param string $pre_name 表前缀
    * @return void
    */
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
            $arr=array("res"=>$result,"text"=>mysqli_error());
            $jsonStr =json_encode($arr);
            return $jsonStr;
        }

    }
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
        $arr=array("res"=>$result,"text"=>mysqli_error());
        $jsonStr =json_encode($arr);
        return $jsonStr;
    }

    function updateJson($Json)
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
    // function delProductOrBrandById($key,$id,$IsEcho){
    //     switch ($key) {
    //         case 'product':
    //             $tname= $GLOBALS["t_products"];
    //             $sql="DELETE FROM `".$tname."` WHERE `PID`=".$id;
    //             break;
    //         case 'brand':
    //             $tname= $GLOBALS["t_brands"];
    //             $sql="DELETE FROM `".$tname."` WHERE `BrandID`=".$id;
    //             break;
    //         default:
    //             return false;
    //             break;
    //     }
    //     $result = mysql_query($sql,$GLOBALS["con"]);
    //     $arr=array("status"=>$result,"text"=>mysql_error());
    //     $jsonStr =json_encode($arr);
    //     if($IsEcho!=false)
    //         echo $jsonStr;
    //     return $jsonStr;
    // }
?>