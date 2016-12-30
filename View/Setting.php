<?php
session_start();
if($_SESSION["IsLogin"]!==true) {
    header("Location: /login.html");
}
?>
<?php
echo "系统设置页面"
?>