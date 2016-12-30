<?php
if(session_status()!=2){
    session_start();
}
if($_SESSION["IsLogin"]!=true) {
    header("Location: /login.html");
}
?>
<?php
    echo "Hello Dashboard";
?>