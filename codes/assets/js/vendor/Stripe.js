$(document).ready(function() {
    var stripe = Stripe('pk_test_51OnKmAEq3LoiSobxI4fFHkCjb7JABVhFciks3Gzcd2Z53xI9jdvUAf5QKvlX7qkyhJnAm7dr1WkgcrSbPPOaEkq7009XB5jt9H');
    var elements = stripe.elements();

    var cardElement = elements.create('card', {
        hidePostalCode: true,
    });
    cardElement.mount('#card-element');

    var form = document.getElementById('payment-form');

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        stripe.createToken(cardElement).then(function(result) {
            if (result.error) {
                console.error(result.error.message);
            } else {
                // Token created successfully, send token to your server
                var token = result.token;
                // Now, you can submit the form with the token or handle it as needed
                // For example, you can include the token in a hidden form field and then submit the form
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);
                // Now submit the form
                form.submit();
            }
        });
    });
});
