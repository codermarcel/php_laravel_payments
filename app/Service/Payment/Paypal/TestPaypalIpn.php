<?php 

namespace App\Service\Payment\Paypal;

class TestPaypalIpn
{
	public function setSandbox($sandbox = true)
	{
		//
	}

    public function isVerified(array $all)
    {
        return true;
    }
}