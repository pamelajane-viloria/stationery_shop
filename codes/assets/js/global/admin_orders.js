$(document).ready(function() {
    $(".selectpicker").selectpicker("refresh");

    $.get('/Admin_orders/index_html', function(data) {
        $("#order_list").html(data);
        $(".selectpicker").selectpicker("refresh");
    });

    $('#search_input').on('input', function() {
        let search_term = $(this).val().trim();
        $.get('/Admin_orders/search_orders', { search: search_term }, function(data) {
            $('#order_list').html(data);
            $(".selectpicker").selectpicker("refresh");
        });
    });

    $('.profile_dropdown').on('click', function() {
        let newTop = $(this).offset().top + $(this).outerHeight();
        let newLeft = $(this).offset().left;
        
        $('.admin_dropdown').css({
            'top': newTop + 'px',
            'left': newLeft + 'px'
        });
    });

    // $('#category-list button').on('click', async function(event) {
    //     event.preventDefault();
    //     const tokenResponse = await $.ajax({
    //         url: '/Products/get_csrf_token',
    //         dataType: 'json'
    //     });
    //     const categoryName = $(this).data('categoryName');
    //     const csrfToken = tokenResponse.csrf_token;
    //     $.post('/Products/filter_products', { category_name: categoryName, csrf_token: csrfToken }, function(response) {
    //         $('#product-list').html(response);
    //         $('#product-count').text(response.product_count);
    //     });
    //     $(this).parent().parent().children().children().removeClass('active');
    //     $(this).addClass('active');
    // });

    $('.status_form button').on('click', async function(event) {
        event.preventDefault();
        const tokenResponse = await $.ajax({
            url: '/Products/get_csrf_token', // You need to adjust the URL to match your route
            dataType: 'json'
        });
        const statusName = $(this).data('statusName'); 
        const csrfToken = tokenResponse.csrf_token;
        $.post('/Admin_orders/filter_orders', { status_name: statusName, csrf_token: csrfToken }, function(response) {
            $('#order_list').html(response);
            console.log(response);
            $(".selectpicker").selectpicker("refresh");
        });
        $('.status_form button').removeClass('active');
        $(this).addClass('active');
    });
    

    /* $("body").on("click", ".switch", function() {
        window.open("/dashboard", '_blank');
    }); */

    // $("body").on("change", ".status_selectpicker", function() {
    //     $(this).closest("form").find("input[name=status_id]").val($(this).val());
    //     $(this).closest("form").trigger("submit");
    // });

    $("body").on("change", ".update_order_form", function() {
        var form = $(this);
        $.post(form.attr('action'), form.serialize(), function(data) {
            $('#order_list').html(data);
            $(".selectpicker").selectpicker("refresh");
        });
        return false;
    });

    // $("body").on("submit", ".update_status_form", function() {
    //     let form = $(this);
    //     $.post(form.attr("action"), form.serialize(), function(res) {
    //         $(".wrapper > section").html(res);
    //         $(".selectpicker").selectpicker("refresh");
    //     });

    //     return false;
    // });

    // $("body").on("click", ".status_form button", function() {
    //     let button = $(this);
    //     $(".status_form").find("input[name=status_id]").val(button.val());
    //     $(".status_form").find(".active").removeClass("active");
    //     button.addClass("active");

    // })

    // $("body").on("submit", ".status_form", function() {
    //     let form = $(this);
    //     $.post(form.attr("action"), form.serialize(), function(res) {
    //         $("tbody").html(res);
    //         $(".selectpicker").selectpicker("refresh");
    //     });
    //     return false;
    // });
});