<?php

namespace Lib\Encrypting;

use Lib\Encrypting\Exceptions;

/**
 * Class EncryptionOpenSsl works with library OpenSSL
 */
class OpenSSLSymmetric extends EncryptingAbs
{
    protected const CONFIG_KEY = 'open_ssl';

    private string $secretKey;
    private int $vectorLength;
    private string $method;

    public function __construct()
    {
        try {
            parent::__construct();

            $this->vectorLength = $this->calculateVectorEncryptingLength();
            $this->secretKey = $this->options['secret_key'];
            $this->method = $this->options['encrypting_method'];

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Method get length bytes vector or length bytes from array options
     *
     * @return int
     *
     * @throws Exceptions\EncryptingException
     */
    private function calculateVectorEncryptingLength(): int
    {
        $vectorLength = ($this->options['on_cipher_iv_length'] === true) ?
            openssl_cipher_iv_length($this->options['encrypting_method']) : intval($this->options['init_vector_bytes']);

        if (empty($vectorLength)) {
            throw new Exceptions\EncryptingException('Value vector length can`t be empty or null!' .
                __CLASS__ . ' ' . __METHOD__ . " line " . __LINE__);
        }

        return $vectorLength;
    }

    /**
     * Method encryption data
     *
     * @param string $data
     *
     * @return string
     */
    public function encryptionData(string $data): string
    {
        try {
            $initVector = $this->getInitVector();
            $options = $this->getEncryptingOptionFlag();

            $crypt = openssl_encrypt($data, $this->method, $this->secretKey, $options, $initVector);
            if (empty($crypt)) {
                throw new Exceptions\EncryptingException('Error generate open ssl cypher!' .
                    __CLASS__ . ' ' . __METHOD__ . " line " . __LINE__);
            }

            return $initVector . $crypt;

        } catch (Exceptions\EncryptingException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Method generate init vector for encrypting
     *
     * @return string
     *
     * @throws Exceptions\EncryptingException
     */
    public function getInitVector(): string
    {
        $randomBytes = random_bytes($this->vectorLength);

        if (empty($randomBytes)) {
            throw new Exceptions\EncryptingException('Error generate random bytes for init vector!' .
                __CLASS__ . ' ' . __METHOD__ . " line " . __LINE__);
        }

        $iv = mb_strcut($randomBytes, 0, $this->options['trim_vector_bytes']);
        if (empty($iv)) {
            throw new Exceptions\EncryptingException('Can`t get string init vector!' .
                __CLASS__ . ' ' . __METHOD__ . " line " . __LINE__);
        }
        return $iv;
    }

    private function getEncryptingOptionFlag(): string
    {
        return ($this->options['open_ssl_raw_data'] === true) ? OPENSSL_RAW_DATA : OPENSSL_ZERO_PADDING;
    }


    public function decryptionData(string $data): string
    {
        try {
            $salt = $this->getSaltCrypt($data);
            $cipher = $this->getCipher($data);
            $options = $this->getEncryptingOptionFlag();

            $dataResult = openssl_decrypt($cipher, $this->method, $this->secretKey, $options, $salt);

            return (!empty($dataResult)) ? $dataResult : false;

        } catch (Exceptions\EncryptingException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Method get salt from encrypting data
     *
     * @param string $crypt
     *
     * @return string
     *
     * @throws Exceptions\EncryptingException
     */
    private function getSaltCrypt(string $crypt): string
    {
        $salt = mb_strcut($crypt, 0, $this->options["trim_vector_bytes"], 'ASCII');

        if (empty($salt)) {
            throw new Exceptions\EncryptingException('Error extract salt from encrypting data!' .
                __CLASS__ . ' ' . __METHOD__ . " line " . __LINE__);
        }

        return $salt;
    }

    /**
     * Method get cipher from encrypting data
     *
     * @param string $data
     *
     * @return string
     *
     * @throws Exceptions\EncryptingException
     */
    private function getCipher(string $data): string
    {
        $cipher = mb_strcut($data, $this->options["trim_vector_bytes"], null, 'ASCII');
        if (empty($cipher)) {
            throw new Exceptions\EncryptingException('Error extract cipher from encrypting data!' .
                __CLASS__ . ' ' . __METHOD__ . " line " . __LINE__);
        }

        return $cipher;
    }
}