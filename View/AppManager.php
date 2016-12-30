<?php
session_start();
if($_SESSION["IsLogin"]!==true) {
    header("Location: /login.html");
}
?>

<div class="toolbar">
    <button class="btn btn-primary" data-toggle="modal" data-target="#addNewApp"><i class="icon-plus"></i>添加应用</button>
    <!-- 添加应用 -->
    <div class="modal " id="addNewApp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">添加新应用</h4>
                </div>
                <div class="modal-body">
                    <form id="addNewApp-form" method="GET" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">应用ID</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="app_id" placeholder="应用ID" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">应用名称</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="app_name" placeholder="应用名称" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">应用标题</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="app_title" placeholder="应用标题" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">应用地址</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="app_url" placeholder="应用地址" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">应用图标</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="app_icon" placeholder="应用图标">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">添加</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!--<div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary">添加</button>
                </div>-->
                <script>
                    $("#addNewApp-form").on("submit",function(e){
                        e.preventDefault();
                        var reg =  RegExp(/^http[s]?:\/\//g);
                        if(!reg.test($("#app_url").val())){
                            var url = "http://"+$("#app_url").val();
                        }
                        else{
                            url = $("#app_url").val();
                        }
                        $.post("Module/auth.php", {
                            method:"updateApps",
                            app_id:$("#app_id").val(),
                            app_name:$("#app_name").val(),
                            app_title:$("#app_title").val(),
                            app_url:url,
                            app_icon:$("#app_icon").val()==""?url+"/favicon.ico":$("#app_icon").val()
                        },
                        function (data, textStatus, jqXHR) {
                            if(data.res==true){
                                $.get("View/AppManager.php",function(data){
                                    $(".AppsList").closest(".tab-page").html(data);
                                })
                            }
                        },
                        "json"
                        );
                    })
                </script>
            </div>
        </div>
    </div>
</div>
<?php
    $data = $_SESSION["Json"];
    $dataArr = json_decode($data,true);
    echo "<ul class=\"AppsList\">";
    foreach ($dataArr["apps"] as $key => $value) {
        $li = "<li data-id=\"".$value["app_id"]."\">
                    <a href=\"".$value["url"]."\">
                        <img src=\"".$value["icon"]."\" />
                        <span>".$value["title"]."</span>
                    </a>
                </li>";
        echo $li;
    }
    echo "</ul>";
?>