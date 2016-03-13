<?php
function encrypt($text){
    $fp=fopen('../other/key.txt','r');
    $key=fread($fp,filesize('../other/key'));
    fclose($fp);
    $iv=openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($text, 'aes-256-cbc', $key, 0, $iv);
    $encrypted = $encrypted . ':' . bin2hex($iv);
    return $encrypted;
}

function decrypt($text){
    $fp=fopen('../other/key.txt','r');
    $key=fread($fp,filesize('../other/key'));
    fclose($fp);
    $parts = explode(':', $text);
    $parts[1]=hex2bin($parts[1]);
    $encrypted = openssl_decrypt($parts[0], 'aes-256-cbc', $key, 0, $parts[1]);
    return $encrypted;
}
