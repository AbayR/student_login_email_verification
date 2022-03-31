$(document).ready(function () {
    $(".listbtn").click(function () {
        detachBtn = $(this).remove();
        $(detachBtn).appendTo($(".list-top"));
        $(detachBtn).removeClass();
        $(detachBtn).addClass("list-top-btn");
        $(".list-top-btn").click(function () {
            $(this).remove();
        })
    });
});

