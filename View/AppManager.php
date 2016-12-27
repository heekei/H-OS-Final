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
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary">添加</button>
            </div>
            </div>
        </div>
    </div>
</div>
<?php
    $file=fopen("data.json","r") or exit("无法打开文件!");
    while (!feof($file))
    {
        $data .= fgets($file);
    }
    fclose($file);
    $dataArr = json_decode($data,true);
    $json = json_encode($dataArr);
    echo "<ul class=\"AppsList\">";
    foreach ($dataArr["apps"] as $key => $value) {
        $li = "<li>".
                    "<a href=\"".$value["url"] ."\">".
                        "<img src=\"".$value["icon"]."\" />".
                        "<span>".$value["title"]."</span>".
                    "</a>".
                "</li>";
        echo $li;
    }
    echo "</ul>";
?>