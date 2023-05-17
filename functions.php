<?php

use LDAP\Result;

function apiCall(string $url): array {
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response_json = curl_exec($ch);
    $result = json_decode($response_json, true);

    curl_close($ch);

    if ($result === null) {
        $result = array('status' => 'error');
    }

    return $result;
}

function generate_jwt($headers, $payload, $secret = 'MangaLog') {
	$headers_encoded = base64url_encode(json_encode($headers));
	
	$payload_encoded = base64url_encode(json_encode($payload));
	
	$signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $secret, true);
	$signature_encoded = base64url_encode($signature);
	
	$jwt = "$headers_encoded.$payload_encoded.$signature_encoded";
	
	return $jwt;
}

function base64url_encode($str) {
    return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
}

//don't know if this is needed
function base64url_decode($str) {
    return base64_decode(strtr($str, '-_', '+/').str_repeat('=', 3 - ( 3 + strlen($str)) % 4));
}

?>