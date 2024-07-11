<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayPal Integration</title>
    <script src="https://www.paypal.com/sdk/js?client-id=AWEtyNBvno544P-NSEkHfKjJJ_U87MnUlBdV42v6nAui-cOs3qtzi5XPdNcknMGsXX9VRvCcQzGO1B78&components=buttons&currency=MXN"></script>
</head>
<body>

    <div id="paypal-button-container"></div>

    <script>
        paypal.Buttons({
            async createOrder() {
                const response = await fetch("create-order.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        cart: [
                            {
                                sku: "DDS323",
                                quantity: 3,
                                price: 50.00 
                            },
                            {
                                sku: "DDS245",
                                quantity: 1,
                                price: 25.00 
                            },
                            {
                                sku: "DDS245",
                                quantity: 2,
                                price: 75.00 
                            },
                            {
                                sku: "DDS245",
                                quantity: 1,
                                price: 100.50 
                            },
                        ],
                    }),
                });

                const data = await response.json();
                return data.id;
            },
            async onApprove(data) {
                const response = await fetch("capture-order.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        orderID: data.orderID
                    })
                });

                const details = await response.json();
                window.location.assign("success.php");
                // alert(`Transaction completed by ${details.payer.name.given_name}`);
            },
            onCancel(data) {
                window.location.assign("index.php");
            },
            onError(err) {
                window.location.assign("index.php");
            }
        }).render('#paypal-button-container');
    </script>
</body>
</html>
