$(document).ready(function() {
    $(".error-alert").fadeTo(1000, 500).slideUp(500, function() {
        $(this).slideUp(500);
    });
    // fix register validation
    // $("form.signup_form").submit(function(event) {
    //     event.preventDefault();
    //     var firstName = $("input[name=first_name]").val().trim();
    //     var text = "";
    //     if (firstName === "") {
    //         text = "First Name can not be empty.";
    //     } else if (firstName.length < 2) {
    //         text = "Not a valid name";
    //     }
    //     $("input[name=first_name]").css("border", "1px solid #F84F4F").siblings('span').text(text);
    //     return false;
    // });

    // $("form.login_form").submit(function(event) {
    //     event.preventDefault();
    //     var email = $("input[name=email]").val().trim();
    //     var text = "";
    //     if (email === "") {
    //         text = "Email can not be empty.";
    //         $("input[name=email]").css("border", "1px solid #F84F4F").siblings('span').text(text);
            
    //     } else if (email.length < 2) {
    //         text = "Not a valid email.";
    //         $("input[name=email]").css("border", "1px solid #F84F4F").siblings('span').text(text);
    //     }
    // });
});
