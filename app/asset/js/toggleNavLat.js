/* Faire apparaitre les btn des formations en catalogue */
$(document).ready(function() {
    $(".toggleNavLat").click(function() {
        $(".nav-lateral").fadeIn();
    });

    $("#sidebarClose").click(function() {
        $(".nav-lateral").fadeOut();
    });

    $(window).resize(function() {
        if ($(window).width() > 768) {
            $(".nav-lateral").css('display', 'block');
        }
        if ($(window).width() < 768) {
            $(".nav-lateral").css('display', 'none');
        }
    });
});