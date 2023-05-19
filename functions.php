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

function connect($sql){
    $ip = '127.0.0.1';
    $username = 'root';
    $pwd = '';
    $database = 'mangalog';
    $connection = new mysqli($ip, $username, $pwd, $database);

    if($connection->connect_error) {
        die('C/errore: ' . $connection->connect_error);
    }

    $result = $connection->query($sql);

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

function is_jwt_valid($jwt, $secret = 'MangaLog') {
	$tokenParts = explode('.', $jwt);
	$header = base64_decode($tokenParts[0]);
	$payload = base64_decode($tokenParts[1]);
	$signature_provided = $tokenParts[2];

	$expiration = json_decode($payload)->exp;
	$is_token_expired = ($expiration - time()) < 0;

	$base64_url_header = base64url_encode($header);
	$base64_url_payload = base64url_encode($payload);
	$signature = hash_hmac('SHA256', $base64_url_header . "." . $base64_url_payload, $secret, true);
	$base64_url_signature = base64url_encode($signature);

	$is_signature_valid = ($base64_url_signature === $signature_provided);
	
	if ($is_token_expired || !$is_signature_valid) {
		return FALSE;
	} else {
		return TRUE;
	}
}

function get_jwt_payload($jwt) {
    $tokenParts = explode('.', $jwt);
    $payload = base64_decode($tokenParts[1]);
    return json_decode($payload, true);
}

function get_jwt_id($jwt) {
    $payload = get_jwt_payload($jwt);
    return $payload['id'];
}

function get_jwt_username($jwt) {
    $payload = get_jwt_payload($jwt);
    return $payload['username'];
}

//don't know if this is needed
/*
function base64url_decode($str) {
    return base64_decode(strtr($str, '-_', '+/').str_repeat('=', 3 - ( 3 + strlen($str)) % 4));
}
*/

?>