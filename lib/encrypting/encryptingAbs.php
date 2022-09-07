<?php

namespace Lib\Encrypting;

use Lib\Encrypting\Exceptions;

abstract class EncryptingAbs
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
    protected function __construct()
    {
        $this->loadingArrayConfigByKey(static::CONFIG_KEY);
    }

    /**
     * Method get params from configuration file
     *
     * @param string $key
     *
     * @throws Exceptions\EncryptingException
     */
    private function loadingArrayConfigByKey(string $key)
    {
        $allOptions = require __DIR__ . '\config.php';
        if (empty($allOptions[$key]) || !is_array($allOptions[$key])) {
            throw new Exceptions\EncryptingException('Error read file  configurations! ' .
                __CLASS__ . ' ' . __METHOD__ . " line " . __LINE__);
        }
        $this->options = $allOptions[$key];
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

    /**
     * Method encryption data
     *
     * @param string $data
     *
     * @return mixed
     */
    abstract public function encryptionData(string $data);

    /**
     * Method decryption data
     *
     * @param string $data
     *
     * @return mixed
     */
    abstract public function decryptionData(string $data);
}