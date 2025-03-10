$(document).ready(function(){
    $("body").on("click", ".increase_decrease_quantity", function() {
        let input = $(this).parents('form#add_to_cart_form').children().find('input.form-control');
        let input_val = parseInt(input.val());
        if($(this).attr("data-quantity-ctrl") === "1") {
            input.val(input_val + 1);
        } else {
            if(input_val !== "1") {
                input.val(input_val - 1);
            }
        };
        let total_amount = parseInt(input.val()) * parseInt(($(".amount").text()).substring(2));
        $("#add_to_cart_form").find(".total_amount").val(total_amount + ".00");
    });

    $("body").on("click", ".show_image", function() {
        let show_image_btn = $(this);
        show_image_btn.closest("ul").find(".active").removeClass("active");
        show_image_btn.closest("li").addClass("active");
        show_image_btn.closest("ul").closest("li").children().first().attr("src", show_image_btn.find("img").attr("src"));
    });

    $("body").on("submit", "#add_to_cart_form", function() {
        let form = $(this);
        $.post(form.attr("action"), form.serialize(), function(res) {
            $(".content_section").html(res);    
            $("#success_modal").modal("show");
            setTimeout(function() {
                $("#success_modal").modal("hide")
            }, 1200);
        });
        return false;
    });

    $("#add_to_cart").click(function(){
        $("<span class='added_to_cart'>Added to cart succesfully!</span>")
        .insertAfter(this)
        .fadeIn()
        .delay(1000)
        .fadeOut(function() {
            $(this).remove();
        });
        return false;
    });
});