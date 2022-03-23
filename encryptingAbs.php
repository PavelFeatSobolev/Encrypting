<?php

namespace Lib\Encrypting;

use Lib\Encrypting\Interfaces\EncryptingInterface;
use Lib\Encrypting\Exceptions;

abstract class EncryptingAbs implements EncryptingInterface
{
    protected array $options;
    protected const CONFIG_KEY = '';

    /**
     * Method read options from file config
     *
     * @return array
     *
     * @throws Exceptions\EncryptingException
     */
    public function __construct()
    {
        $this->options = $this->loadingArrayConfigByKey(static::CONFIG_KEY);
    }

    protected function loadingArrayConfigByKey(string $key): array
    {
        $allOptions = require __DIR__ . '\config.php';
        if (empty($allOptions[$key]) || !is_array($allOptions[$key])) {
            throw new Exceptions\EncryptingException('Error read file  configurations ' .
                __CLASS__ . ' ' . __METHOD__ . " line " . __LINE__);
        }

        return $allOptions[$key];
    }

    /**
     * Method get array options
     *
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Method set options param from array
     *
     * @param $key
     * @param $value
     *
     * @return bool
     */
    public function setOptionsParam($key, $value): bool
    {
        if (isset($this->options[$key]) && !empty($value)) {
            $this->options[$key] = $value;

            return true;
        }
        return false;
    }
}