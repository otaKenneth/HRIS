// var h = window.outerHeight + 2;

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
    // $('#sidebar,#page-content').height(`${h}px`);
    $("#sidebar-toggler").click(function () {
        $("#sidebar").toggleClass('d-none');
        $("#sidebar").toggleClass('sidebar-sm');
    })

    $("#close-sidebar").click(function () {
        if ($("#sidebar-toggler:visible").length > 0) {
            $("#sidebar").toggleClass('d-none');
            $("#sidebar").toggleClass('sidebar-sm');
        }
    })

    $(".sidebar-dropdown > a").click(function () {
        $(this).next(".sidebar-submenu").slideUp(200);
        
        if ($(this).parent().hasClass("active")) {
            $(this).parent().removeClass("active");
            $(this).parent().removeClass("active");
        } else {
            $(this).parent().removeClass("active");
            $(this).next(".sidebar-submenu").slideDown(200);
            $(this).parent().addClass("active");
        }
    });

});