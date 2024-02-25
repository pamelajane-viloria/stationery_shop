$(document).ready(function() {

    /* To delete a product */
    $("body").on("click", ".delete_product", function() {
        $(this).closest("tr").addClass("show_delete");
        $(".popover_overlay").fadeIn();
        $("body").addClass("show_popover_overlay");
    });

    /* To cancel delete */
    $("body").on("click", ".cancel_remove", function() {
        $(this).closest("tr").removeClass("show_delete");
        $(".popover_overlay").fadeOut();
        $("body").removeClass("show_popover_overlay");
    });

    /* To trigger input file */
    $("body").on("click", ".upload_image", function() {
        $(".image_input").trigger("click");
    });

    /* To trigger image upload and display preview */
    $("body").on("change", ".image_input", function() {
        var files = $(this)[0].files;
        var imageContainer = $(this).closest('li').find('ul');
        var imageSettings = '<button type="button" class="delete_image image_settings"></button>';
      
        imageContainer.empty();
        for (var i = 0; i < files.length; i++) {
          var file = files[i];
          var reader = new FileReader();
          reader.onload = (function(file) {
            return function(e) {
              var imageElement = $('<img>');
              imageElement.attr('src', e.target.result);
              imageElement.addClass('uploaded_image');
              var liElement = $('<li></li>');
              liElement.append(imageElement);
              liElement.append(imageSettings);
      
              // Include filename in checkbox value
              var isMainInput = '<label for="main_image[]" class="image_settings"><input type="checkbox" name="main_image[]" value="' + file.name + '" data-filename="' + file.name + '">Mark as main</label>';
              liElement.append(isMainInput);
      
              imageContainer.append(liElement);
            };
          })(file);
          reader.readAsDataURL(file);
        }
    });
      
    
    // Update other checkboxes when one is checked
    $("body").on('change', 'input[name="main_image[]"]', function() {
        if ($(this).is(':checked')) {
            $(this).closest('ul').find('input[type="checkbox"]').not(this).prop('checked', false);
        }
    });    

    /* To delete an image */
    $("body").on("click", ".delete_image", function() {
        $(this).closest('li').remove();
        if ($("#image_preview").find("li").length === 0) {
            $("#image_preview").append("<li><button type='button' class='upload_image'></button></li>");
        }
    });

    /* show is_main checkbox on hover */
    $("body").on("mouseenter", "#image_preview li", function() {
        $(this).find('.image_settings').show();
    });
    
    $("body").on("mouseleave", "#image_preview li", function() {
        $(this).find('.image_settings').hide();
    });    

    // $("body").on("submit", ".add_product_form", function() {
    //     console.log("Add product form is submitted");
    //     filterProducts($(this));
    //     return false;
    // }); 

    /*  */
    // $("body").on("change", "input[name=main_image]", function() {
    //     $("input[name=image_index]").val($(this).val());
    //     $(".form_data_action").val("mark_as_main");
    // });

    $("body").on("hidden.bs.modal", function() {
        $("#add_product_modal").find("h2").text("Add a product");
        $('#product_form')[0].reset();
    });

    // $("body").on("submit", ".categories_form", function() {
    //     filterProducts(form);
    //     return false;
    // });

    $("body").on("click", ".categories_form button", function() {
        let button = $(this);
        let form = button.closest("form");

        form.find("input[name=category]").val(button.attr("data-category"));
        form.find("input[name=category_name]").val(button.attr("data-category-name"));
        button.closest("ul").find(".active").removeClass("active");
        button.addClass("active");

        filterProducts(form);

        return false;
    });

    // $("body").on("keyup", ".search_form", function() {
    //     filterProducts($(this));
    //     $(".categories_form").find(".active").removeClass("active");
    // });

    $("body").on("submit", ".delete_product_form", function() {
        filterProducts($(this));
        $("body").removeClass("show_popover_overlay");
        $(".popover_overlay").fadeOut();

        var form = $(this);
        $.post(form.attr('action'), form.serialize(), function(data) {
            $('#product-list').html(data);
        });

        return false;
    });

    $("body").on("click", ".edit_product", function() {
        var product_id = $(this).val();
        $.get('/Dashboards/get_product_data/' + product_id, function(data) {
            populateEditModal(data);
        });        
        $("#product_form").attr("action", "/Dashboards/edit_product/" + product_id);
        $("#add_product_modal").modal("show");
        $("#add_product_modal").find("h2").text("Edit product #" + $(this).val());
    });

    // $("body").on("submit", "#product_form", function() {
    //     filterProducts($(this));
    //     $("#add_product_modal").modal("hide");
    // });

    // Get products
    $.get('/Dashboards/index_html', function(data) {
        $('.products_table tbody').html(data);
    });

    // Search products
    $('#search_input').on('input', function() {
        let search_term = $(this).val().trim();
        $.get('/Dashboards/search_by_name', { search: search_term }, function(data) {
            $('.products_table tbody').html(data);
        });
    });

    // Filter Products
    $('#category-list button').on('click', async function(event) {
        event.preventDefault();
        const tokenResponse = await $.ajax({
            url: '/Products/get_csrf_token',
            dataType: 'json'
        });
        const categoryName = $(this).data('categoryName');
        const csrfToken = tokenResponse.csrf_token;
        $.post('/Dashboards/filter_products', { category_name: categoryName, csrf_token: csrfToken }, function(response) {
            $('#product-list').html(response);
            $('#product-count').text(response.product_count);
        });
        $(this).parent().parent().children().children().removeClass('active');
        $(this).addClass('active');
    });
});

function resetAddProductForm() {
    $(".add_product_form").find("textarea, input[name=product_name], input[name=price], input[name=inventory]").attr("value", "").text("");
    $('select[name=categories]').find("option").removeAttr("selected").closest("select").val("1").selectpicker('refresh');
    $(".add_product_form")[0].reset();
    $(".image_label").find("span").remove();
    $(".image_preview_list").children().remove();
    $("#add_product_modal").find("h2").text("Add a Product");
};

function filterProducts(form) {
    $.post(form.attr("action"), form.serialize(), function(res) {
        $(".product_content").html(res);
        // console.log(res);
    });
}

function populateEditModal(data) {
    var productData = JSON.parse(data);
    $("input[name=prouct_name]").val(productData.product_data.name);
    $("textarea[name=description]").val(productData.product_data.description);
    $("input[name=price]").val(productData.product_data.price);
    $("input[name=inventory]").val(productData.product_data.inventory);
}

