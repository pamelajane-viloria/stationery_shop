$(document).ready(function() {
    $.get('Orders/index_html', function(data) {
        $("#cart_list").html(data);
        initOrderSummary();
    });

    $('#search_input').on('input', function() {
        let search_term = $(this).val().trim();
        $.get('/Orders/search_by_name', { search: search_term }, function(data) {
            $('#cart_list').html(data);
        });
    });

    $("body").on("click", ".remove_item", function() {
        $(this).closest("ul").closest("li").addClass("confirm_delete");
        $(".popover_overlay").fadeIn();
        submitForm($(input).parent());
        // $(".cart_items_form").find("input[name=action]").val("delete_cart_item");
        // $(".cart_items_form").find("input[name=update_cart_item_id]").val($(this).val());
    });
    $("body").on("click", ".cancel_remove", function() {
        $(this).closest("li").removeClass("confirm_delete");
        $(".popover_overlay").fadeOut();
        $(".cart_items_form").find("input[name=action]").val("update_cart");
    });
    /* prototype added delete */
    // $("body").on("click", ".remove", function() {
    //     $(this).closest('li.confirm_delete').remove();
    //     $(".popover_overlay").fadeOut();
    // });

    $("body").on("click", ".increase_decrease_quantity", function() {
        let input = $(this).closest("ul").siblings("input.form_control");
        let input_val = parseInt(input.val());

        if($(this).attr("data-quantity-ctrl") == 1) {
            input.val(input_val + 1);
        } else {
            input.val(input_val - 1);
        };
        console.log();
        let total_amount_val = input.val() * parseInt($(this).parents("ul").siblings("span.amount").text());
        let total_amount = $(this).closest("ul").siblings().parent().siblings("li").find("input.total_amount");
        $(total_amount).val(total_amount_val);
        submitForm($(input).parents("form"));
        initOrderSummary();
    });
    

    // Billing form hidden by default
    $('.billing_form').hide();
    
    // Check if the checkbox is checked by default
    if ($('#same_as_shipping').is(':checked')) {
        $('.billing_form').hide(); // Hide billing form if checked
    }

    // Handle checkbox change event
    $("body").on("change", "input[name=same_billing]", function() {
        if ($(this).is(':checked')) {
            $('.billing_form').hide(); // Hide billing form if checked
            clearBillingFields(); // Clear billing fields if checked
        } else {
            $('.billing_form').show(); // Show billing form if unchecked
        }
    });

    // Copy shipping information to billing information if checkbox is checked
    $("body").on("change", "input[name=same_billing]", function() {
        if ($(this).is(':checked')) {
            copyShippingToBilling(); // Copy shipping to billing if checked
        }
    });
    
    

    // $("body").on("submit", ".cart_items_form", function() {
    //     let form = $(this);
    //     $.post(form.attr("action"), form.serialize(), function(res) {
    //         $(".wrapper > section").html(res);
    //         $(".popover_overlay").fadeOut();
    //     });
    //     return false;
    // });

    $("body").on("submit", ".checkout_form", function() {
        let form = $(this);
        $.post(form.attr("action"), form.serialize(), function(res) {
            // $(".wrapper > section").html(res);
            $("#card_details_modal").modal("show");
        });
        return false;
    });

    $("body").on("submit", ".pay_form", function() {
        let form = $(this);
        $(this).find("button").addClass("loading");
        $.post(form.attr("action"), form.serialize(), function(res) {
            setTimeout(function(res) {
                $("#card_details_modal").find("button").removeClass("loading").addClass("success").find("span").text("Payment Successfull!");
            }, 2000, res);
            setTimeout(function(res) {
                $("#card_details_modal").modal("hide");
            }, 3000, res);
            setTimeout(function(res) {
                $(".wrapper > section").html(res);
            }, 3200, res);
        });
        return false;
    });

});

function submitForm(form) {
    $.post(form.attr("action"), form.serialize(), function(res) {
        $("#cart_list").html(res);
    });
    return false;
}

function clearBillingFields() {
    $('input[name=billing_first_name]').val('');
    $('input[name=billing_last_name]').val('');
    $('input[name=billing_address_1]').val('');
    $('input[name=billing_address_2]').val('');
    $('input[name=billing_city]').val('');
    $('input[name=billing_state]').val('');
    $('input[name=billing_zip_code]').val('');
}

function copyShippingToBilling() {
    $('input[name=billing_first_name]').val($('input[name=shipping_first_name]').val());
    $('input[name=billing_last_name]').val($('input[name=shipping_last_name]').val());
    $('input[name=billing_address_1]').val($('input[name=shipping_address_1]').val());
    $('input[name=billing_address_2]').val($('input[name=shipping_address_2]').val());
    $('input[name=billing_city]').val($('input[name=shipping_city]').val());
    $('input[name=billing_state]').val($('input[name=shipping_state]').val());
    $('input[name=billing_zip_code]').val($('input[name=shipping_zip_code]').val());    
}

function initOrderSummary() {
    let itemsAmount = 0;
    $("input.total_amount").each(function() {
        let amount = parseFloat($(this).val());
        itemsAmount += amount;
    });
    let totalAmount = itemsAmount + 45; // Shipping fee

    $('.items_amount span').text(itemsAmount);
    $('.total_amount span').text(totalAmount);
    $('input[name=total_amount]').val(totalAmount);
}