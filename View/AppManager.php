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
                    // window.AppList =[];
                    $.get("API/get.php",function(data){
                        if(!data.res){
                            $(".AppsList").html("")
                            var JsonObj = JSON.parse(data||"{\"apps\":[]}");
                            window.AppList = JsonObj.apps;  
                            context.init({preventDoubleContext: false});
                            for(var i = 0;i<JsonObj.apps.length;i++){
                                $(".AppsList").append("<li data-id='"+JsonObj.apps[i].app_id+"' >"+
                                        "<a href='" + JsonObj.apps[i].url +"'>"+
                                            "<img src='"+ JsonObj.apps[i].icon +"' />"+
                                            "<span>"+ JsonObj.apps[i].title +"</span>"+
                                        "</a>"+
                                    "</li>")
                            }
                            context.attach('.AppsList li', {
                                id:"AppsListContextMenu",
                                data:[
                                    /*{
                                        header:"菜单"
                                    },*/
                                    {
                                        icon: 'icon-edit',
                                        text: '编辑',
                                        className:"edddd",
                                        action: function(e, selector) { 
                                            console.log(selector.data("id")); 
                                        }
                                    },
                                    {
                                        icon: 'icon-remove',
                                        text: '删除',
                                        action: function(e, selector) { 
                                            AppList.filter(function (element, index, src) {
                                                // console.log(element, index)
                                                if (selector.data("id") == element.app_id) {
                                                    src.splice(index, 1);
                                                    $.post("Module/auth.php", {
                                                        method: "updateApps",
                                                        appjson: {
                                                            apps: window.AppList
                                                        }
                                                    },
                                                    function (data, textStatus, jqXHR) {
                                                        if (data.res == true) {
                                                            $.get("View/AppManager.php", function (data) {
                                                                $(".AppsList").closest(".tab-page").html(data);
                                                            })
                                                        }
                                                    },
                                                    "json"
                                                    );
                                                }
                                                return src;
                                            }, this);
                                        }
                                    }
                                    
                                ]
                            });
                        }
                    });
                    $("#addNewApp-form").on("submit",function(e){
                        e.preventDefault();
                        var reg =  RegExp(/^http[s]?:\/\//g);
                        if(!reg.test($("#app_url").val())){
                            var url = "http://"+$("#app_url").val();
                        }
                        else{
                            url = $("#app_url").val();
                        }
                        var data = {
                            "app_id":$("#app_id").val(),
                            "name":$("#app_name").val(),
                            "title":$("#app_title").val(),
                            "url":url,
                            "icon":$("#app_icon").val()==""?url+"/favicon.ico":$("#app_icon").val()
                        };
                        window.AppList.push(data);
                        $.post("Module/auth.php", {
                            method:"updateApps",
                            appjson:{
                                apps:window.AppList
                            }
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
<ul class="AppsList"></ul>