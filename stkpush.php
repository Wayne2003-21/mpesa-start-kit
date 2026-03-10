<?php

// stkpush.php
// This script sends an STK Push request to the Daraja sandbox.
// A phone matching the PartyA / PhoneNumber value receives a payment prompt.

$accessToken = "PASTE_ACCESS_TOKEN_HERE";
$shortcode   = "174379";
$passkey     = "YOUR_PASSKEY";
$timestamp   = date("YmdHis");
$password    = base64_encode($shortcode . $passkey . $timestamp);

$url = "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";

$data = [
    // Business shortcode used for the STK request.
    "BusinessShortCode" => $shortcode,

    // Generated password from shortcode + passkey + timestamp.
    "Password" => $password,

    // Current timestamp in the required format.
    "Timestamp" => $timestamp,

    // Typical transaction type for PayBill online flow.
    "TransactionType" => "CustomerPayBillOnline",

    // Amount the customer will be asked to pay.
    "Amount" => 1,

    // Customer phone number in international format.
    "PartyA" => "254712345678",

    // Usually the same shortcode for sandbox examples.
    "PartyB" => $shortcode,

    // The same customer phone number receiving the prompt.
    "PhoneNumber" => "254712345678",

    // Publicly reachable endpoint that receives the callback result.
    "CallBackURL" => "https://your-domain.com/callback.php",

    // Reference visible in the request context.
    "AccountReference" => "Order001",

    // Simple description of the transaction.
    "TransactionDesc" => "Test payment"
];

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer " . $accessToken,
    "Content-Type: application/json"
]);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if ($response === false) {
    die("cURL Error: " . curl_error($ch));
}

curl_close($ch);

// Print the raw JSON response from Daraja.
echo $response;
