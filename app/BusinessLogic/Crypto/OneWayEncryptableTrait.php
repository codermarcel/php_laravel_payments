<?php

namespace App\BusinessLogic\Crypto;

use App\Exceptions\ServerException\CryptoException;
use App\Service\Crypto\Rsa\RsaService;

trait OneWayEncryptableTrait
{
    use EncryptionProviderTrait;
    
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encryptable))
        {
            $value = $this->getCryptoProvider()->encrypt($value); //encrypt only when the key is in the encryptable attributes.
        }

        return parent::setAttribute($key, $value);
    }
}