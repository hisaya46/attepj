$(function () {
    $(".hamburger").click(function () {
        $(this).toggleClass("active");

        if ($(this).hasClass("active")) {
            $(".nav").addClass("active");
        } else {
            $(".nav").removeClass("active");
        }
    });
});
