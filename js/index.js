$(function () {
    $(".main").css("min-height", $(window).height() - $(".navbar-static-top").outerHeight(true))
    $(".tab-page").css("min-height", $(window).height() - $(".navbar-static-top").outerHeight(true) - 43)
})
// 退出登录
$(function () {
    $(".logout").on("click", function () {
        $.post("Module/auth.php", {
            logout:true
        },
            function (data, textStatus, jqXHR) {
                if (data.res == true) {
                    window.location.href = "/login.html"
                }
            },
            "json"
        );
    })
})
// 标签页
$(function () {
    $(".nav-tabs").on("click", "li", function (e) {
        e.preventDefault();
        var i = $(this).index();
        activeTab(i)
    })

    $(".nav-tabs").on("click", ".icon-remove", function () {
        var li = $(this).closest("li");
        var i = li.index();
        var tabpages = $(this).closest(".nav-tabs").siblings(".tab-pages").children(".tab-page");
        li.remove();
        tabpages.eq(i).remove();
    })
    // 拖拽
    var srcElm, tarElm;
    $(".nav-tabs").on("dragstart", "li", function (e) {
        srcElm = $(this);
    });
    $(".nav-tabs").on("dragenter", "li", function (e) {
        tarElm = $(this);
    });
    $(".nav-tabs").on("dragend", "li", function (e) {
        var srcI = srcElm.index();
        var tarI = tarElm.index();
        var tabpages = srcElm.closest(".nav-tabs").siblings(".tab-pages").children(".tab-page");
        srcElm.insertBefore(tarElm)
        tabpages.eq(srcI).insertBefore(tabpages.eq(tarI))
    });
})
function iframeBind(target/*, tabCtrl*/) {
    // target.onload = function () {
    //     console.log($(tabCtrl))
    // }
    //iframe容器高度适应
    $(".tab-page").css("min-height", $(window).height() - $(".navbar-static-top").outerHeight(true) - 43)
    // iframe高度自适应
    $(target).height($(window).height() - $(".navbar-static-top").outerHeight(true) - 43)
}
// 设置活跃tab
function activeTab(index) {
    var i = index;
    $(".nav-tabs li").removeClass("active").eq(i).addClass("active");
    var tabpages = $(".tab-pages").children(".tab-page");
    tabpages.removeClass("active").eq(i).addClass("active")
}
// 创建新标签页
function createNewTab(url = "about:blank", title = "新标签页") {
    // 标签
    var li = document.createElement("li"); li.setAttribute("role", "presentation")
    var a = document.createElement("a"); a.href = '#'; a.innerHTML = title;
    var i = document.createElement("i"); i.className = 'icon-remove';
    li.appendChild(a);
    li.appendChild(i);
    $(".nav-tabs").append(li);
    //标签页
    var tabpage = document.createElement("div");
    tabpage.className = "tab-page"
    var iframe = document.createElement("iframe");
    iframe.src = (url ? url : 'about:blank');
    iframe.security = 'restricted';
    iframe.sandbox = 'allow-same-origin allow-forms allow-scripts';
    iframeBind(iframe, li);
    tabpage.appendChild(iframe);
    $(".tab-pages").append(tabpage);
    var i = $(".tab-pages").children(".tab-page").length - 1;
    activeTab(i);
}
$(function () {
    // 左侧导航栏
    $(".side-nav").on("click", "li a", function (e) {
        e.preventDefault();
        var path = "View/";
        var url = $(this).attr('href').replace("#", "");

        createNewTab(path + url + ".html", $(this)[0].innerText);
    })
})


