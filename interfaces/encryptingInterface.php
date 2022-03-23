<?php

namespace Lib\Encrypting\Interfaces;

/**
 * interface EncryptionInterface
 *
 * @package Local\Trackers
 */
interface EncryptingInterface
{
    /**
     * Method encryption data
     *
     * @param string $data
     *
     * @return mixed
     */
    public function encryptionData(string $data);


    /**
     * Method decryption data
     *
     * @param string $data
     *
     * @return mixed
     */
    public function decryptionData(string $data);
}