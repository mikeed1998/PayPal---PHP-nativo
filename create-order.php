<?php
$clientId = 'AWEtyNBvno544P-NSEkHfKjJJ_U87MnUlBdV42v6nAui-cOs3qtzi5XPdNcknMGsXX9VRvCcQzGO1B78';
$clientSecret = 'EC7blwy8XZLEl3I6HiTc1st70bVb7F2BYAGLc470Z80-kgzZgkJHCXhVsEJR6_n3baL0WOCk0sCLRaWb';

$token = getAccessToken($clientId, $clientSecret);

$cart = json_decode(file_get_contents('php://input'))->cart;
$order = createOrder($token, $cart);

echo json_encode($order);

function getAccessToken($clientId, $clientSecret) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSLVERSION, 6); // TLS 1.2
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_USERPWD, $clientId.":".$clientSecret);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

    $result = curl_exec($ch);
    $json = json_decode($result);
    curl_close($ch);

    return $json->access_token;
}

function createOrder($token, $cart) {
    $url = "https://api.sandbox.paypal.com/v2/checkout/orders";

    $headers = [
        "Content-Type: application/json",
        "Authorization: Bearer $token"
    ];

    // Calcular el valor total del carrito
    $totalValue = 0;
    foreach ($cart as $item) {
        $totalValue += $item->price * $item->quantity;
    }

    $data = [
        "intent" => "CAPTURE",
        "purchase_units" => [[
            "amount" => [
                "currency_code" => "MXN",
                "value" => number_format($totalValue, 2, '.', '') // formato adecuado
            ]
        ]]
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $result = curl_exec($ch);
    $json = json_decode($result);
    curl_close($ch);

    return $json;
}
?>
