# Encriping module - расширяемый модуль шифрования на PHP
Создан для возможности шифровать и дешифровывать данные. В текущей версии использует библиотеку OpenSSL (с использованием симметричного шифрования). 

Пример использования:
```php
//шифруем данные
$encrypting = new \Lib\Encrypting\OpenSSLSymmetric();
$crypt = $encrypting->encryptionData('Шифруемые данные');

//дешифруем данные при получении шифра $crypt
$encryptingDec = new \Lib\Encrypting\OpenSSLSymmetric();
$result = $encryptingDec->decryptionData($crypt);

var_dump(result);

//если необходимо динамически изменить параметры конфигурации
$encrypting = new \Lib\Encrypting\OpenSSLSymmetric();
$encrypting->setOptionsParam('ключ','значение');

//или получить все параметры конфигурации текущего класса
$options = $encrypting->getOptions();
```

Так же может быть расширен за счет наследования абстрактного класса EncryptingAbs и реализацией методов интефейса (EncryptingInterface) encryptionData() и decryptionData(). 
Для использования настроек используется файл config.php c асоциативным массивом параметров. 
Для получения настроек в расширяющем классе необходимо создать новый подмасив в файле config.php с ключем нового класса "ваш_класс" и задать константу CONFIG_KEY в  новом классе. Значение константы должно быть таким же как указано в файле config.php, в нашем случае "ваш_класс". Если все сделано правильно настройки автоматически загрузятся в свойство класса $options при использовании.
