$(document).ready(function() {
    $("button").click(function() {
        $(this).next('.btnManage').fadeIn();
        $(this).next('.btnManage').css("display", "flex");
    });
});