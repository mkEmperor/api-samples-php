<?php

require 'Redsms/RedsmsApiSimple.php';

echo "redsms.ru api test \n";

$login = 'you_login';
$apiKey = 'you_api_key';
$testNumber = 'you_number';

$smsApi = new \Redsms\RedsmsApiSimple($login, $apiKey);
$lastMessageUuid = '';
try {

    echo "Client info: \n";
    print_r($smsApi->clientInfo());

    echo "Send sms message: \n";
    $sendResult = $smsApi->send($testNumber, 'Hello,it is test!', 'REDSMS.RU');
    if ($messages = ($sendResult['items'] ?? [])) {
        foreach ($messages as $message) {
            echo $message['phone'].":".$message['uuid'];
            $lastMessageUuid = $message['uuid'];
        }
    }

    if ($lastMessageUuid) {
        echo "Get message info: \n";
        print_r($smsApi->messageInfo($lastMessageUuid));
        echo "wait 10 sec... \n";
        sleep(10);
        print_r($smsApi->messageInfo($lastMessageUuid));
    }

} catch (\Exception $e) {
    echo "error code ".$e->getCode()."\n";
    $errorMessage = json_decode($e->getMessage(), true);
    print_r($errorMessage);
}

echo "\n";