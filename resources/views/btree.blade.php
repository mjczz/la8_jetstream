<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- includes the Braintree JS client SDK -->
    <script src="https://js.braintreegateway.com/web/dropin/1.24.0/js/dropin.min.js"></script>
    <!-- includes jQuery -->
{{--    <script src="http://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>--}}
    <script src="https://cdn.bootcdn.net/ajax/libs/jquery/1.10.0/jquery.min.js"></script>
</head>
<body>
<div id="dropin-container"></div>
<button id="submit-button">支付</button>
<div id="checkout-message"></div>
<script>
    var button = document.querySelector('#submit-button')

    braintree.dropin.create({
        authorization:'{{$clientToken}}',
        container: '#dropin-container'
    }, function (createErr, instance) {
        button.addEventListener('click', function () {
            instance.requestPaymentMethod(function (err, payload) {
                console.log({err, payload})
                if (err != null) {
                    return
                }

                $('#submit-button').remove();
                // Submit payload.nonce to your server
                $.ajax({
                    type: 'POST',
                    url: '/checkout',
                    data: {'paymentMethodNonce': payload.nonce}
                }).done(function(result) {

//                    // Tear down the Drop-in UI
                    instance.teardown(function (teardownErr) {
                        if (teardownErr) {
                            console.error('Could not tear down Drop-in UI!');
                        } else {
                            console.info('Drop-in UI has been torn down!');
                            // Remove the 'Submit payment' button
                            $('#submit-button').remove();
                        }
                    });

                    if (result.success) {
                        $('#checkout-message').html('<h1>Success</h1><p>Your Drop-in UI is working! Check your <a href="https://sandbox.braintreegateway.com/login">sandbox Control Panel</a> for your test transactions.</p><p>Refresh to try another transaction.</p>');
                    } else {
                        console.log(result);
                        $('#checkout-message').html('<h1>Error</h1><p>Check your console.</p>');
                    }
                });
            })
        })
    })
</script>
</body>
</html>

