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
?>