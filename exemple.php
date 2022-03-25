<?php

include 'lib/encrypting/autoload.php';

//Хэширование
//$hashOb = new \Lib\Encrypting\HashLibs\SimpleHash();
//$hashOb->setOptionsParam('binary_system', true);

//$hash = $hashOb->getHash('мышь');

//$hash2 = $hashOb->getHash('мышь');
//$hashOb->comparisonHashes($hash, $hash2);

$encrypting = new \Lib\Encrypting\OpenSSLSymmetric();
$encrypting->setOptionsParam();
$options = $encrypting->getOptions();
$crypt = $encrypting->encryptionData('очень пьяная мышь');

$encryptingDec = new \Lib\Encrypting\OpenSSLSymmetric();
$result = $encryptingDec->decryptionData($crypt);
var_dump($result);


