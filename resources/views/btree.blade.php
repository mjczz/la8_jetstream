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
<button id="submit-button">Request payment method</button>
<div id="checkout-message"></div>
<script>
    var button = document.querySelector('#submit-button')

    braintree.dropin.create({
        authorization:'eyJ2ZXJzaW9uIjoyLCJhdXRob3JpemF0aW9uRmluZ2VycHJpbnQiOiJleUowZVhBaU9pSktWMVFpTENKaGJHY2lPaUpGVXpJMU5pSXNJbXRwWkNJNklqSXdNVGd3TkRJMk1UWXRjMkZ1WkdKdmVDSXNJbWx6Y3lJNkltaDBkSEJ6T2k4dllYQnBMbk5oYm1SaWIzZ3VZbkpoYVc1MGNtVmxaMkYwWlhkaGVTNWpiMjBpZlEuZXlKbGVIQWlPakUyTURNeE1qRTFOekVzSW1wMGFTSTZJbUZsWldVM05qUXlMVEkxWldVdE5EazNaUzFoTXpGaUxXRXdNV1ZpWWpjeE5HSTFOeUlzSW5OMVlpSTZJbTU1WjJSallqWnRPWEIwZVRkb05tSWlMQ0pwYzNNaU9pSm9kSFJ3Y3pvdkwyRndhUzV6WVc1a1ltOTRMbUp5WVdsdWRISmxaV2RoZEdWM1lYa3VZMjl0SWl3aWJXVnlZMmhoYm5RaU9uc2ljSFZpYkdsalgybGtJam9pYm5sblpHTmlObTA1Y0hSNU4yZzJZaUlzSW5abGNtbG1lVjlqWVhKa1gySjVYMlJsWm1GMWJIUWlPbVpoYkhObGZTd2ljbWxuYUhSeklqcGJJbTFoYm1GblpWOTJZWFZzZENKZExDSnpZMjl3WlNJNld5SkNjbUZwYm5SeVpXVTZWbUYxYkhRaVhTd2liM0IwYVc5dWN5STZlMzE5LkV1Y0RUZ2NZTDFSNXhzdzMtandkQ1NtdUdNd1FwVE8wMmVNTURWMVZjQ3dTSFZXZnJYZnhDc2tjRGtxeVllMlhlXzE4SWVmRWdnUVhzbTNxZWtpQ0FnIiwiY29uZmlnVXJsIjoiaHR0cHM6Ly9hcGkuc2FuZGJveC5icmFpbnRyZWVnYXRld2F5LmNvbTo0NDMvbWVyY2hhbnRzL255Z2RjYjZtOXB0eTdoNmIvY2xpZW50X2FwaS92MS9jb25maWd1cmF0aW9uIiwiZ3JhcGhRTCI6eyJ1cmwiOiJodHRwczovL3BheW1lbnRzLnNhbmRib3guYnJhaW50cmVlLWFwaS5jb20vZ3JhcGhxbCIsImRhdGUiOiIyMDE4LTA1LTA4IiwiZmVhdHVyZXMiOlsidG9rZW5pemVfY3JlZGl0X2NhcmRzIl19LCJjbGllbnRBcGlVcmwiOiJodHRwczovL2FwaS5zYW5kYm94LmJyYWludHJlZWdhdGV3YXkuY29tOjQ0My9tZXJjaGFudHMvbnlnZGNiNm05cHR5N2g2Yi9jbGllbnRfYXBpIiwiZW52aXJvbm1lbnQiOiJzYW5kYm94IiwibWVyY2hhbnRJZCI6Im55Z2RjYjZtOXB0eTdoNmIiLCJhc3NldHNVcmwiOiJodHRwczovL2Fzc2V0cy5icmFpbnRyZWVnYXRld2F5LmNvbSIsImF1dGhVcmwiOiJodHRwczovL2F1dGgudmVubW8uc2FuZGJveC5icmFpbnRyZWVnYXRld2F5LmNvbSIsInZlbm1vIjoib2ZmIiwiY2hhbGxlbmdlcyI6W10sInRocmVlRFNlY3VyZUVuYWJsZWQiOnRydWUsImFuYWx5dGljcyI6eyJ1cmwiOiJodHRwczovL29yaWdpbi1hbmFseXRpY3Mtc2FuZC5zYW5kYm94LmJyYWludHJlZS1hcGkuY29tL255Z2RjYjZtOXB0eTdoNmIifSwicGF5cGFsRW5hYmxlZCI6dHJ1ZSwicGF5cGFsIjp7ImJpbGxpbmdBZ3JlZW1lbnRzRW5hYmxlZCI6dHJ1ZSwiZW52aXJvbm1lbnROb05ldHdvcmsiOnRydWUsInVudmV0dGVkTWVyY2hhbnQiOmZhbHNlLCJhbGxvd0h0dHAiOnRydWUsImRpc3BsYXlOYW1lIjoibWpjenoiLCJjbGllbnRJZCI6bnVsbCwicHJpdmFjeVVybCI6Imh0dHA6Ly9leGFtcGxlLmNvbS9wcCIsInVzZXJBZ3JlZW1lbnRVcmwiOiJodHRwOi8vZXhhbXBsZS5jb20vdG9zIiwiYmFzZVVybCI6Imh0dHBzOi8vYXNzZXRzLmJyYWludHJlZWdhdGV3YXkuY29tIiwiYXNzZXRzVXJsIjoiaHR0cHM6Ly9jaGVja291dC5wYXlwYWwuY29tIiwiZGlyZWN0QmFzZVVybCI6bnVsbCwiZW52aXJvbm1lbnQiOiJvZmZsaW5lIiwiYnJhaW50cmVlQ2xpZW50SWQiOiJtYXN0ZXJjbGllbnQzIiwibWVyY2hhbnRBY2NvdW50SWQiOiJtamN6eiIsImN1cnJlbmN5SXNvQ29kZSI6IlVTRCJ9fQ==',
        container: '#dropin-container'
    }, function (createErr, instance) {
        button.addEventListener('click', function () {
            instance.requestPaymentMethod(function (err, payload) {
                // Submit payload.nonce to your server
                console.log({err, payload})
                $.ajax({
                    type: 'POST',
                    url: '/checkout',
                    data: {'paymentMethodNonce': payload.nonce}
                }).done(function(result) {
//                    // Tear down the Drop-in UI
//                    instance.teardown(function (teardownErr) {
//                        if (teardownErr) {
//                            console.error('Could not tear down Drop-in UI!');
//                        } else {
//                            console.info('Drop-in UI has been torn down!');
//                            // Remove the 'Submit payment' button
//                            $('#submit-button').remove();
//                        }
//                    });

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

{{--<div id="dropin-wrapper">--}}
{{--    <div id="checkout-message"></div>--}}
{{--    <div id="dropin-container"></div>--}}
{{--    <button id="submit-button">Submit payment</button>--}}
{{--</div>--}}
{{--<script>--}}
{{--    var button = document.querySelector('#submit-button');--}}

{{--    braintree.dropin.create({--}}
{{--        // Insert your tokenization key here--}}
{{--        authorization: 'eyJ2ZXJzaW9uIjoyLCJhdXRob3JpemF0aW9uRmluZ2VycHJpbnQiOiJleUowZVhBaU9pSktWMVFpTENKaGJHY2lPaUpGVXpJMU5pSXNJbXRwWkNJNklqSXdNVGd3TkRJMk1UWXRjMkZ1WkdKdmVDSXNJbWx6Y3lJNkltaDBkSEJ6T2k4dllYQnBMbk5oYm1SaWIzZ3VZbkpoYVc1MGNtVmxaMkYwWlhkaGVTNWpiMjBpZlEuZXlKbGVIQWlPakUyTURNeE1UazNNeklzSW1wMGFTSTZJbU00Tm1NME1XVTFMV05qWTJZdE5HSTFOQzA0WXpreExUUTBPR0prTVRnNE5ERTRPU0lzSW5OMVlpSTZJbTU1WjJSallqWnRPWEIwZVRkb05tSWlMQ0pwYzNNaU9pSm9kSFJ3Y3pvdkwyRndhUzV6WVc1a1ltOTRMbUp5WVdsdWRISmxaV2RoZEdWM1lYa3VZMjl0SWl3aWJXVnlZMmhoYm5RaU9uc2ljSFZpYkdsalgybGtJam9pYm5sblpHTmlObTA1Y0hSNU4yZzJZaUlzSW5abGNtbG1lVjlqWVhKa1gySjVYMlJsWm1GMWJIUWlPbVpoYkhObGZTd2ljbWxuYUhSeklqcGJJbTFoYm1GblpWOTJZWFZzZENKZExDSnpZMjl3WlNJNld5SkNjbUZwYm5SeVpXVTZWbUYxYkhRaVhTd2liM0IwYVc5dWN5STZlMzE5Lm1MUEJ5TVByTW0wRk96Y0FXRloxZEp5Vzk4am9aczE1YmhrLU1aZU1NSG14YlpuN0JuQXQ1NXd4VTU1R2VXZWJBY0drWEZ4RFNCdnhDY3g2azdUbTJRIiwiY29uZmlnVXJsIjoiaHR0cHM6Ly9hcGkuc2FuZGJveC5icmFpbnRyZWVnYXRld2F5LmNvbTo0NDMvbWVyY2hhbnRzL255Z2RjYjZtOXB0eTdoNmIvY2xpZW50X2FwaS92MS9jb25maWd1cmF0aW9uIiwiZ3JhcGhRTCI6eyJ1cmwiOiJodHRwczovL3BheW1lbnRzLnNhbmRib3guYnJhaW50cmVlLWFwaS5jb20vZ3JhcGhxbCIsImRhdGUiOiIyMDE4LTA1LTA4IiwiZmVhdHVyZXMiOlsidG9rZW5pemVfY3JlZGl0X2NhcmRzIl19LCJjbGllbnRBcGlVcmwiOiJodHRwczovL2FwaS5zYW5kYm94LmJyYWludHJlZWdhdGV3YXkuY29tOjQ0My9tZXJjaGFudHMvbnlnZGNiNm05cHR5N2g2Yi9jbGllbnRfYXBpIiwiZW52aXJvbm1lbnQiOiJzYW5kYm94IiwibWVyY2hhbnRJZCI6Im55Z2RjYjZtOXB0eTdoNmIiLCJhc3NldHNVcmwiOiJodHRwczovL2Fzc2V0cy5icmFpbnRyZWVnYXRld2F5LmNvbSIsImF1dGhVcmwiOiJodHRwczovL2F1dGgudmVubW8uc2FuZGJveC5icmFpbnRyZWVnYXRld2F5LmNvbSIsInZlbm1vIjoib2ZmIiwiY2hhbGxlbmdlcyI6W10sInRocmVlRFNlY3VyZUVuYWJsZWQiOnRydWUsImFuYWx5dGljcyI6eyJ1cmwiOiJodHRwczovL29yaWdpbi1hbmFseXRpY3Mtc2FuZC5zYW5kYm94LmJyYWludHJlZS1hcGkuY29tL255Z2RjYjZtOXB0eTdoNmIifSwicGF5cGFsRW5hYmxlZCI6dHJ1ZSwicGF5cGFsIjp7ImJpbGxpbmdBZ3JlZW1lbnRzRW5hYmxlZCI6dHJ1ZSwiZW52aXJvbm1lbnROb05ldHdvcmsiOnRydWUsInVudmV0dGVkTWVyY2hhbnQiOmZhbHNlLCJhbGxvd0h0dHAiOnRydWUsImRpc3BsYXlOYW1lIjoibWpjenoiLCJjbGllbnRJZCI6bnVsbCwicHJpdmFjeVVybCI6Imh0dHA6Ly9leGFtcGxlLmNvbS9wcCIsInVzZXJBZ3JlZW1lbnRVcmwiOiJodHRwOi8vZXhhbXBsZS5jb20vdG9zIiwiYmFzZVVybCI6Imh0dHBzOi8vYXNzZXRzLmJyYWludHJlZWdhdGV3YXkuY29tIiwiYXNzZXRzVXJsIjoiaHR0cHM6Ly9jaGVja291dC5wYXlwYWwuY29tIiwiZGlyZWN0QmFzZVVybCI6bnVsbCwiZW52aXJvbm1lbnQiOiJvZmZsaW5lIiwiYnJhaW50cmVlQ2xpZW50SWQiOiJtYXN0ZXJjbGllbnQzIiwibWVyY2hhbnRBY2NvdW50SWQiOiJtamN6eiIsImN1cnJlbmN5SXNvQ29kZSI6IlVTRCJ9fQ==',--}}
{{--        container: '#dropin-container'--}}
{{--    }, function (createErr, instance) {--}}
{{--        button.addEventListener('click', function () {--}}
{{--            instance.requestPaymentMethod(function (requestPaymentMethodErr, payload) {--}}
{{--                // When the user clicks on the 'Submit payment' button this code will send the--}}
{{--                // encrypted payment information in a variable called a payment method nonce--}}
{{--                $.ajax({--}}
{{--                    type: 'POST',--}}
{{--                    url: '/checkout',--}}
{{--                    data: {'paymentMethodNonce': payload.nonce}--}}
{{--                }).done(function(result) {--}}
{{--                    // Tear down the Drop-in UI--}}
{{--                    instance.teardown(function (teardownErr) {--}}
{{--                        if (teardownErr) {--}}
{{--                            console.error('Could not tear down Drop-in UI!');--}}
{{--                        } else {--}}
{{--                            console.info('Drop-in UI has been torn down!');--}}
{{--                            // Remove the 'Submit payment' button--}}
{{--                            $('#submit-button').remove();--}}
{{--                        }--}}
{{--                    });--}}

{{--                    if (result.success) {--}}
{{--                        $('#checkout-message').html('<h1>Success</h1><p>Your Drop-in UI is working! Check your <a href="https://sandbox.braintreegateway.com/login">sandbox Control Panel</a> for your test transactions.</p><p>Refresh to try another transaction.</p>');--}}
{{--                    } else {--}}
{{--                        console.log(result);--}}
{{--                        $('#checkout-message').html('<h1>Error</h1><p>Check your console.</p>');--}}
{{--                    }--}}
{{--                });--}}
{{--            });--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}
