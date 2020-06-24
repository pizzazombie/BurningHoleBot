<?php
$ch = curl_init();

// // 2. указываем параметры, включая url
// curl_setopt($ch, CURLOPT_URL, "http://nplus1.ru/rss/");
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_HEADER, 0);

// // 3. получаем HTML в качестве результата
// $output = curl_exec($ch);
// if ($output === FALSE) {
//     // Тут-то мы о ней и скажем
//     echo 'cURL Error: какая-то проблема: ' . curl_error($ch);
//     return;
// }
// else{
//     echo $output;
// }
// // 4. закрываем соединение
// curl_close($ch);
$xml = simplexml_load_file('http://nplus1.ru/rss/');
echo $xml
?>