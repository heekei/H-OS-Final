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
        $sql = "CREATE TABLE if not exists ". $pre_name ."_users 
        (
            ID int NOT NULL AUTO_INCREMENT, 
            PRIMARY KEY(ID),
            Username text CHARACTER SET utf8 COLLATE utf8_general_ci,
            Password text CHARACTER SET utf8 COLLATE utf8_general_ci
        )";
        mysqli_query($sql);
        // $sql2 = "CREATE TABLE if not exists ". $pre_name ."_brands 
        // (
        //     BrandID int NOT NULL AUTO_INCREMENT, 
        //     PRIMARY KEY(BrandID),
        //     BrandName text CHARACTER SET utf8 COLLATE utf8_general_ci,
        //     BrandInfo text CHARACTER SET utf8 COLLATE utf8_general_ci
        // )";
        // mysql_query($sql2,$GLOBALS["con"]);
    }
    function doLogin($uname,$pwd){
        $sql = "SELECT * FROM `".$GLOBALS["users"]."` where Username='".$uname."'"." and Password='".$pwd."'";
        // $sql = "SELECT * FROM `".$GLOBALS["users"]."`";//." and Password=".$pwd;
        $result = $GLOBALS["con"]->query($sql);
        if ($result->num_rows > 0) {
            $res =true;
            // while($row = $result->fetch_assoc()) {
            //     $p[$i]=$row;
            //     $i++;
            // }
            
        } else {
            $res=false;
        }
        $GLOBALS["con"]->close();
        return $res;
    }
    // function queryProducts($id,$page,$lenOfPage,$IsEcho){
    //     $tname= $GLOBALS["t_products"];
    //     $lenOfPage=empty($lenOfPage)?30:$lenOfPage;
    //     $page=empty($page)?1:$page;
    //     if(empty($id)){
    //         if(empty($page)){
    //             $sql = "SELECT * FROM ".$tname;
    //         }
    //         else{
    //             $sql = "SELECT * FROM  `".$tname."` LIMIT ".$lenOfPage*($page - 1).",".$lenOfPage;
    //         }
    //     }
    //     else{
    //         $sql = "SELECT * FROM ".$tname." where PID=" . $id;
    //     }
    //     $result = mysql_query($sql,$GLOBALS["con"]);
    //     $p=array();
    //     $i = 0;
    //     if(!empty($result)){
    //         while($row = mysql_fetch_array($result,MYSQL_ASSOC)){
    //             $row['pName']=($row['pName']);
    //             $row['pBrand']=($row['pBrand']);
    //             $row['pInfo']=($row['pInfo']);
    //             $p[$i]=($row);
    //             $i++;
    //         }
    //     }
    //     $count=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ".$tname ,$GLOBALS["con"]),MYSQL_ASSOC);
    //     $count=$count['COUNT(*)'];
    //     $jsonStr =json_encode(array('productsList' => $p ,'count' => $count ,'pageNum'=>$page,'pages' => ceil($count/$lenOfPage)  ));
    //     if($IsEcho!=false)
    //         echo $jsonStr;
    //     return $jsonStr;
    // }
    // function queryBrands($id,$IsEcho){
    //     if(empty($id)){
    //         $sql = "select * from ".$GLOBALS["pre_name"]."_brands";
    //     }
    //     else{
    //         $sql = "select * from ".$GLOBALS["pre_name"]."_brands where BrandID=" . $id;
    //     }
    //     $result = mysql_query($sql,$GLOBALS["con"]);
    //     $p=array();
    //     $i = 0;
    //     if(!empty($result)){
    //         while($row = mysql_fetch_array($result,MYSQL_ASSOC)){
    //             $row['BrandName']=($row['BrandName']);
    //             $row['BrandInfo']=($row['BrandInfo']);
    //             $p[$i]=$row;
    //             $i++;
    //         }
    //     }
        
    //     $jsonStr = json_encode(array('brandsList' => $p));
    //     if($IsEcho!=false)
    //         echo $jsonStr;
    //     return $jsonStr;
    // }
    
    // function insertProduct($pname,$pBrandID,$pbrand,$pinfo,$IsEcho){
    //     $tname= $GLOBALS["t_products"];
    //     $pname = $pname;
    //     $pbrand = $pbrand;
    //     $pinfo = $pinfo;
    //     $sql = "INSERT INTO `".$tname."`(`PID`, `pName`, `pBrandID` , `pBrand` , `pInfo`) VALUES (NULL,\"".$pname."\", \"".$pBrandID."\", \"".$pbrand."\" ,\"".$pinfo."\")";
    //     $result = mysql_query($sql,$GLOBALS["con"]);
    //     $arr=array("status"=>$result,"text"=>mysql_error());
    //     $jsonStr =json_encode($arr);
    //     if($IsEcho!=false)
    //         echo $jsonStr;
    //     return $jsonStr;
    // }
    // function insertBrand($bname,$binfo,$IsEcho){
    //     $tname= $GLOBALS["t_brands"];
    //     $bname = $bname;
    //     $binfo = $binfo;
    //     $sql = "INSERT INTO `".$tname."`(`BrandID`,  `BrandName` ,`BrandInfo`) VALUES (NULL,\"".$bname."\", \"".$binfo."\")";
    //     $result = mysql_query($sql,$GLOBALS["con"]);
    //     $arr=array("status"=>$result,"text"=>mysql_error());
    //     $jsonStr =json_encode($arr);
    //     if($IsEcho!=false)
    //         echo $jsonStr;
    //     return $jsonStr;
    // }
    // function UpdateBrand($bid,$bname,$brandinfo,$IsEcho){
    //     $tname= $GLOBALS["t_brands"];
    //     $sql = "UPDATE `".$tname."` 
    //             SET `BrandName`=\"". $bname ."\",
    //             `BrandInfo`=\"". $brandinfo ."\"
    //             WHERE `BrandID` = ".$bid;

    //     $result = mysql_query($sql,$GLOBALS["con"]);
    //     $arr=array("status"=>$result,"text"=>mysql_error());
    //     $jsonStr =json_encode($arr);
    //     if($IsEcho!=false)
    //         echo $jsonStr;
    //     return $jsonStr;
    // }
    // function UpdateProduct($pid,$pname,$pBrandID,$pbrand,$pinfo,$IsEcho){
    //     $tname= $GLOBALS["t_products"];
    //     $sql = "UPDATE `".$tname."` 
    //             SET `pName`=\"". $pname ."\",
    //             `pBrandID`=\"". $pBrandID ."\",
    //             `pBrand`=\"". $pbrand ."\",
    //             `pInfo`=\"". $pinfo ."\"
    //             WHERE `PID` = ".$pid;

    //     $result = mysql_query($sql,$GLOBALS["con"]);
    //     $arr=array("status"=>$result,"text"=>mysql_error());
    //     $jsonStr =json_encode($arr);
    //     if($IsEcho!=false)
    //         echo $jsonStr;
    //     return $jsonStr;
    // }
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