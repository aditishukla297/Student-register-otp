<?php

require "config.php";

header("Content-Type: application/json");

$phone = $_POST["phone"] ?? "";

if (empty($phone)) {
    echo json_encode([
        "success" => false,
        "message" => "Phone number is required"
    ]);
    exit;
}

$phone = trim($phone);

if (preg_match('/^[6-9][0-9]{9}$/', $phone)) {
    $phone = "+91" . $phone;
}

$url = "https://verify.twilio.com/v2/Services/"
     . TWILIO_VERIFY_SERVICE_SID
     . "/Verifications";

$data = [
    "To" => $phone,
    "Channel" => "sms"
];

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt(
    $ch,
    CURLOPT_USERPWD,
    TWILIO_ACCOUNT_SID . ":" . TWILIO_AUTH_TOKEN
);

$response = curl_exec($ch);

if ($response === false) {

    echo json_encode([
        "success" => false,
        "message" => "cURL error: " . curl_error($ch)
    ]);

    curl_close($ch);
    exit;
}

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

$result = json_decode($response, true);

echo json_encode([
    "success" => $httpCode >= 200 && $httpCode < 300,
    "http_code" => $httpCode,
    "twilio_response" => $result
]);

?>