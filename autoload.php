<?php

function encryptingClassLoader(string $className)
{
    $path = str_replace('\\', '/',$className);
    include $path . '.php';
}

spl_autoload_register('encryptingClassLoader');

