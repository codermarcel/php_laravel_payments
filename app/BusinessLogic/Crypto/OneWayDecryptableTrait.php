<?php

namespace App\BusinessLogic\Crypto;

use App\Contracts\Money\CurrencyInterface;
use App\Exceptions\ServerException\CryptoException;
use App\Service\Crypto\Aes\AesService;
use App\Service\Crypto\Rsa\RsaService;

trait OneWayDecryptableTrait
{
    use EncryptionProviderTrait;

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (in_array($key, $this->encryptable))
        {
            if ($value instanceof CurrencyInterface)
            {
                $value = $value->toSmallestUnit();
            }

            $value = $this->getCryptoProvider()->decrypt($value); //decrypt only when the key is in the encryptable attributes.
        }

        return $value;
    }
}