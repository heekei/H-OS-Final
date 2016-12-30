<?php
session_start();
if($_SESSION["IsLogin"]!==true) {
    header("Location: /login.html");
}
?>
<form id="UpdateProfile" role="form" style="padding:30px 30px;">
    <legend>个人资料</legend>

    <div class="form-group">
        <label for="">用户名</label>
        <input type="text" class="form-control" id="Username" disabled value="<?php echo $_SESSION["Username"]?>">
    </div>
    <div class="form-group">
        <label for="">密码</label>
        <input type="password" class="form-control" id="Password" value="placeholder">
    </div>
    <div class="form-group">
        <label for="">邮箱</label>
        <input type="email" class="form-control" id="Email" value="<?php echo $_SESSION["Email"]?>">
    </div>
    <div class="form-group">
        <label for="">昵称</label>
        <input type="text" class="form-control" id="Nickname" value="<?php echo $_SESSION["Nickname"]?>">
    </div>

    <button type="submit" class="btn btn-primary" >保存</button>
    <p id="status-failed" class="text-danger text-center"><i class="icon-warning-sign"></i>修改失败！</p>
    <p id="status-succeed" class="text-success text-center"><i class="icon-ok"></i>修改成功！</p>
    <script>
        $("#UpdateProfile").on("submit", function (e) {
            e.preventDefault()
            $.post("Module/auth.php", {
                method:"update",
                username:$("#Username").val(),
                password:$("#Password").val()=="placeholder"?null:$("#Password").val(),
                email:$("#Email").val(),
                nickname:$("#Nickname").val()
            },
            function (data, textStatus, jqXHR) {
                if(data.res==true){
                   $("#status-succeed").show()
                    setTimeout(function(){
                        $("#status-succeed").fadeOut()
                    },3000)
                }else{
                    $("#status-failed").show()
                    setTimeout(function(){
                        $("#status-failed").fadeOut()
                    },3000)
                }
            },
            "json"
            );
        })
    </script>
</form>
