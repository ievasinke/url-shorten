<?php
/*
 * Using this API - https://cleanuri.com/docs
 * Perform POST (not GET) request (file_get_contents will not work)
 * where you ask user for URL long form, and return short URL
 */

$urlToShorten = "https://www.yesnobutton.com/answer.html";
$shortenUrl = "https://cleanuri.com/api/v1/shorten";

$ask = (string)readline("Would you like to shorten a link? (y/n): ");
if ($ask === "y") {
    $urlToShorten = (string)readline("Paste your URL: ");
}

$data = ['url' => $urlToShorten];

$options = [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HEADER => false,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query($data)
];

$ch = curl_init($shortenUrl);
curl_setopt_array($ch, $options);
$content = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    $result = json_decode($content);
    if (isset($result->result_url)) {
        echo 'Shortened URL: ' . $result->result_url . PHP_EOL;
    } else {
        echo 'Error: ' . $content;
    }
}
curl_close($ch);