<?php
error_reporting(0);

$error = 2;

$hex = $_GET["keyid"];
$bin = hex2bin($hex);
$keyid64 = base64_encode($bin);
$finalkeyid64 = str_replace('=', '', $keyid64);

if (empty($finalkeyid64)){
    http_response_code(503);
    header("Content-Type: application/json");
    $errorjson = array("Status"=>"503","Content"=>"Validation Failed!","Reason"=>"Did not provide Key ID | Key or Key ID | Key isn't complete.");
    echo json_encode($errorjson);
    exit;
}

$hex2 = $_GET["key"];
$bin2 = hex2bin($hex2);
$key64 = base64_encode($bin2);
$finalkey64 = str_replace('=', '', $key64);

if (empty($finalkey64)){
    http_response_code(503);
    header("Content-Type: application/json");
    $errorjson = array("Status"=>"503","Content"=>"Validation Failed!","Reason"=>"Did not provide Key | Key is missing or incomplete.");
    echo json_encode($errorjson);
    exit;
}

// Si todo está bien, se genera el JSON con los datos correctos
header("Content-Type: application/json");

$response = array(
    "keys" => array(
        array(
            "kty" => "oct",
            "k" => $finalkey64,
            "kid" => $finalkeyid64
        )
    ),
    "type" => "temporary"
);

echo json_encode($response);
?>


