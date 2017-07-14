<?php

namespace IceDev\itsdangerous;

class SignException extends RuntimeException {}
class InvalidSignatureException extends SignException {}
class InvalidSignPayloadException extends SignException {}
 
function sign_loads($data, $secret, $hash_func='sha256') {
    $decoded = base64_decode($data);
 
    if ($decoded === FALSE) {
    	throw new InvalidSignPayloadException('Malformed signed string, not a valid base64!');
    }
 
    $sign_pos = strrpos($decoded, '.');
 
    if ($sign_pos === FALSE) {
    	throw new InvalidSignPayloadException('Missing signature part.');
    }
 
    $sign_part = substr($decoded, $sign_pos+1);
    $data_part = substr($decoded, 0, $sign_pos);
 
    if (hash_hmac($hash_func, $data_part, $secret) !== $sign_part) {
        throw new InvalidSignatureException('Invalid signature!');
    }
 
    $decoded_obj = json_decode($data_part);
 
    if ($decoded_obj === NULL) {
    	throw new InvalidSignPayloadException('Failed to decode payload, not a valid JSON.');
    }
 
    return $decoded_obj;
}
 
function sign_dumps($data, $secret, $hash_func='sha256') {
	$json_data = json_encode($data);
 
	if ($json_data === FALSE) {
		throw new InvalidSignPayloadException('Failed to JSON encode, payload not appropriate for encoding.');
	}
 
    $sign_part = hash_hmac($hash_func, $json_data, $secret);
 
    return base64_encode($json_data . '.' . $sign_part);
}
