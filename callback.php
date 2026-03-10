<?php

// callback.php
// Daraja sends the final transaction result to this file.
// The body arrives as raw JSON through php://input.

$callbackData = file_get_contents("php://input");

// Save every callback into a log file for inspection.
// In production, you would normally store structured data in a database.
file_put_contents("logs/mpesa_callback_log.json", $callbackData . PHP_EOL, FILE_APPEND);

// Convert JSON into a PHP array for deeper processing.
$decoded = json_decode($callbackData, true);

// Optional: extract values only when the expected structure exists.
if (isset($decoded['Body']['stkCallback'])) {
    $stk = $decoded['Body']['stkCallback'];

    $resultCode = $stk['ResultCode'] ?? null;
    $resultDesc = $stk['ResultDesc'] ?? null;

    file_put_contents(
        "logs/mpesa_summary_log.txt",
        "ResultCode: " . $resultCode . " | ResultDesc: " . $resultDesc . PHP_EOL,
        FILE_APPEND
    );
}

// Respond with a simple success message.
echo "Callback received successfully";

