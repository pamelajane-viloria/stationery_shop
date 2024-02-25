$(document).ready(function(){
    $("body").on("click", ".profile_btn", function() {
        $(".logout_btn").addClass("show");
        $(".popover_overlay").fadeIn();
        $("body").addClass("show_popover_overlay");
    });
    $("body").on("click", ".popover_overlay", function() {
        $(".logout_btn").removeClass("show");
        $(".popover_overlay").fadeOut();
        $("body").removeClass("show_popover_overlay");
    });
    const dropdownElementList = document.querySelectorAll('.dropdown-toggle')
    const dropdownList = [...dropdownElementList].map(dropdownToggleEl => new bootstrap.Dropdown(dropdownToggleEl))
});