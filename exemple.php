<?php

include 'lib/encrypting/autoload.php';

//шифруем данные
$encrypting = new \Lib\Encrypting\OpenSSLSymmetric();
$crypt = $encrypting->encryptionData('Шифруемая строка');

//дешифруем
$encryptingDec = new \Lib\Encrypting\OpenSSLSymmetric();
$result = $encryptingDec->decryptionData($crypt);

var_dump($result);


