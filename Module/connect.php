<?php 
    // switch ($type) {
    //         case 'json':
                header("Content-type: application/json ;charset=utf-8");
    //             break;
            
    //         default:
    //             header("Content-type: text/html;charset=utf-8");
    //             break;
    // }
    
    // 引入配置文件
    require "config.php";

    // 连接数据库
    $con = mysql_connect($server_URL,$user_name,$pwd);
    if (!$con){
        die('Could not connect: ' . mysql_error());
    }else 
    {
        mysql_query("set character set 'utf8'");//读库 
        mysql_query("set names 'utf8'");//写库
        mysql_query("set character_set_client=utf8");
        mysql_query("set character_set_results=utf8");
        mysql_select_db($GLOBALS["db_name"], $con);
    }
    // 引入数据库操作函数
    require "funcs.php";
    //创建数据表，
    create_table($pre_name);
    $method =strtolower($_POST["method"]?$_POST["method"]:$_GET["method"]);
    $result =strtolower($_POST["result"]?$_POST["result"]:$_GET["result"]);
    $page =strtolower($_POST["page"]?$_POST["page"]:$_GET["page"]);
    $lenofpage =strtolower($_POST["lenofpage"]?$_POST["lenofpage"]:$_GET["lenofpage"]);
    $id =strtolower($_POST["id"]?$_POST["id"]:$_GET["id"]);
    if($method=="query"){
        switch ($result) {
            case 'productslist':
                queryProducts(null,$page,$lenofpage,true);
                break;
            case 'brandslist':
                queryBrands(null,true);
                break;
            case 'product':
                queryProducts($id,null,null,true);
                break;
            case 'brand':
                queryBrands($id,true);
                break;
            default:
                echo $result;
                break;
        }
    }
    else if($method=="insert"){
        $tname =strtolower($_POST["tname"]);
        switch ($tname) {
            case 'brand':
                $brandname = $_POST["brandname"];
                $brandinfo = $_POST["brandinfo"];
                insertBrand($brandname,$brandinfo,true);
                break;
            case 'product':
                $pname = $_POST["pname"];
                $brandid = $_POST["brandid"];
                $brandname = $_POST["brandname"];
                $pinfo = $_POST["pinfo"];
                insertProduct($pname, $brandid ,$brandname,$pinfo,true);
                break;
            default:
                echo false;
                break;
        }
    }
    else if($method=="update"){
        $tname =strtolower($_POST["tname"]);
        switch ($tname) {
            case 'brand':
                $brandid = $_POST["brandid"];
                $brandname = $_POST["brandname"];
                $brandinfo = $_POST["brandinfo"];
                UpdateBrand($brandid,$brandname,$brandinfo,true);
                break;
            case 'product':
                $pid = $_POST["pid"];
                $pname = $_POST["pname"];
                $brandid = $_POST["brandid"];
                $brandname = $_POST["brandname"];
                $pinfo = $_POST["pinfo"];
                UpdateProduct($pid,$pname, $brandid ,$brandname,$pinfo,true);
                break;
            default:
                echo false;
                break;
        }
    }
    else if($method=="delete"){
        $tname =strtolower($_POST["tname"]);
        $id = $_POST["id"];
        delProductOrBrandById($tname,$id,true);
    }
    
    mysql_close($con);
?> 