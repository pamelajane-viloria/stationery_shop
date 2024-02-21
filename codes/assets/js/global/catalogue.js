$(document).ready(function() {
    $.get('/Products/index_html', function(data) {
        $('#product-list').html(data);
    });

    $('#search_input').on('input', function() {
        let search_term = $(this).val().trim();
        $.get('/Products/search_by_name', { search: search_term }, function(data) {
            $('#product-list').html(data);
        });
    });

    $('#category-list button').on('click', async function(event) {
        event.preventDefault();
        const tokenResponse = await $.ajax({
            url: '/Products/get_csrf_token',
            dataType: 'json'
        });
        const categoryName = $(this).data('categoryName');
        const csrfToken = tokenResponse.csrf_token;
        $.post('/Products/filter_products', { category_name: categoryName, csrf_token: csrfToken }, function(response) {
            $('#product-list').html(response);
            $('#product-count').text(response.product_count);
        });
        $(this).parent().parent().children().children().removeClass('active');
        $(this).addClass('active');
    });
});