<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <script src="https://cdn.bootcdn.net/ajax/libs/jquery/1.10.0/jquery.min.js"></script>

    <!-- Load the PayPal JS SDK with your PayPal Client ID-->
    <script src="https://www.paypal.com/sdk/js?client-id=Aazn7_VG1BOA70bOveQN0PrbS2Jlk2G00kJSa882iyOFp9UkyUEuWb1nDV9UcPvnQNAsls5G3JW2TWHi"></script>

    <!-- Load the Braintree components -->
    <script src="https://js.braintreegateway.com/web/3.68.0/js/client.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.68.0/js/paypal-checkout.min.js"></script>

</head>
<body>
<div id="paypal-button"></div>
<script>
    // Create a client.
    braintree.client.create({
        authorization: '{{$clientToken}}'
    }, function (clientErr, clientInstance) {

        // Stop if there was a problem creating the client.
        // This could happen if there is a network error or if the authorization
        // is invalid.
        if (clientErr) {
            console.error('Error creating client:', clientErr);
            return;
        }

        // Create a PayPal Checkout component.
        braintree.paypalCheckout.create({
            client: clientInstance
        }, function (paypalCheckoutErr, paypalCheckoutInstance) {

            // Stop if there was a problem creating PayPal Checkout.
            // This could happen if there was a network error or if it's incorrectly
            // configured.
            if (paypalCheckoutErr) {
                console.error('Error creating PayPal Checkout:', paypalCheckoutErr);
                return;
            }

            // Load the PayPal JS SDK
            paypalCheckoutInstance.loadPayPalSDK({
                currency: 'USD',
                intent: 'capture'
            }, function () {
                paypal.Buttons({
                    fundingSource: paypal.FUNDING.PAYPAL,

                    createOrder: function () {
                        return paypalCheckoutInstance.createPayment({
                            flow: 'checkout', // Required
                            amount: 0.01, // Required
                            currency: 'USD', // Required, must match the currency passed in with loadPayPalSDK

                            intent: 'capture', // Must match the intent passed in with loadPayPalSDK

                            enableShippingAddress: true,
                            shippingAddressEditable: false,
                            shippingAddressOverride: {
                                recipientName: 'Scruff McGruff',
                                line1: '1234 Main St.',
                                line2: 'Unit 1',
                                city: 'Chicago',
                                countryCode: 'US',
                                postalCode: '60652',
                                state: 'IL',
                                phone: '123.456.7890'
                            }
                        });
                    },

                    onApprove: function (data, actions) {
                        console.log({data,actions})
                        return paypalCheckoutInstance.tokenizePayment(data, function (err, payload) {
                            console.log(err,payload)

                            // Submit `payload.nonce` to your server

                            $.ajax({
                                type: 'POST',
                                url: '/paypal_submit',
                                data: {
                                    'payload': JSON.stringify(payload),
                                }
                            }).done(function(result) {
                                if (result.success) {
                                    alert("支付成功")
                                } else {
                                    alert(result.msg)
                                }
                            });
                        });
                    },

                    onCancel: function (data) {
                        console.log('PayPal payment cancelled', JSON.stringify(data, 0, 2));
//                        PayPal payment cancelled {
//                            "orderID": "EC-94T49809H2272234W"
//                        }
                    },

                    onError: function (err) {
                        console.error('PayPal error', err);
                    }
                }).render('#paypal-button').then(function () {
                    console.log("mjczz")
                    // The PayPal button will be rendered in an html element with the ID
                    // `paypal-button`. This function will be called when the PayPal button
                    // is set up and ready to be used
                });

            });

        });

    });



</script>
</body>
</html>

