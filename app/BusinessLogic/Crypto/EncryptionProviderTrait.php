<?php

namespace App\BusinessLogic\Crypto;

use App\Exceptions\ServerException\CryptoException;
use App\Service\Crypto\Rsa\RsaService;

trait EncryptionProviderTrait
{
    private function getCryptoProvider()
    {
    	$value = $this->cryptoProvider;

    	if ( ! empty($value))
    	{
    		return $value;
    	}

    	throw CryptoException::noCryptoProvider();
    }
}