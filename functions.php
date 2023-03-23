<?php

use LDAP\Result;

function apiCall($url){
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response_json = curl_exec($ch);
    $result = json_decode($response_json, true);

    curl_close($ch);

    return $result;
}
?>


