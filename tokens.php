<?php

// token.php
// This script requests an OAuth access token from Daraja.
// It uses your Consumer Key and Consumer Secret.
// The response comes back as JSON.

$consumerKey = "YOUR_CONSUMER_KEY";
$consumerSecret = "YOUR_CONSUMER_SECRET";

// Daraja OAuth endpoint for sandbox access token generation.
$url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";

// Daraja expects HTTP Basic Auth.
// That means: base64_encode("consumerKey:consumerSecret").
$credentials = base64_encode($consumerKey . ":" . $consumerSecret);

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Basic " . $credentials
]);

// Tell cURL to return the response as text instead of printing it automatically.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

// Handle transport-level errors clearly.
if ($response === false) {
    die("cURL Error: " . curl_error($ch));
}

curl_close($ch);

// Convert the JSON string into a PHP object.
$result = json_decode($response);

// Print the token if it exists.
if (isset($result->access_token)) {
    echo "Access Token: " . $result->access_token;
} else {
    echo "Token request failed. Full response:
";
    print_r($result);
}

