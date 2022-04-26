<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Money\USD;
use App\Entity\Decorator\ProductDecorator;
use App\Entity\Invoice;
use App\Entity\User;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Service\Api\Api;
use App\Service\Crypto\Aes\AesService;
use App\Service\Crypto\Aes\DefuseAes;
use App\Service\Crypto\Rsa\RsaService;
use Closure;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ParagonIE\EasyRSA\EasyRSA;
use Ramsey\Uuid\Uuid;

class InfoController extends AbstractController
{
    private $users;
    private $cache;
    private $products;

    public function __construct(UserRepository $users, ProductRepository $products)
    {
        $this->users = $users;
        $this->cache = app(Cache::class);
        $this->products = $products;
    }

    /**
     * Get details about the product
     * The seller will link customers to this page with his product_id and raw_key
     *
     * @return \Illuminate\Http\Response
     */
    public function product(Request $request)
    {
        $product = $this->products->getbyPrimaryKey($request->product_id);
        $user = $product->user;
        $product->setCryptoProvider(AesService::fromRawKey($request->input('raw_key'), $request->input('signature'), $user));

        $accept_coinbase = $user->coinbase_profile && $user->coinbase_profile->enabled ? true : false;
        $accept_paypal = $user->paypal_profile && $user->paypal_profile->enabled ? true : false;

        $new = ProductDecorator::decorate($product);
        
        return (new Api($request))
            ->set('coinbase', $accept_coinbase)
            ->set('paypal', $accept_paypal)
            ->set('product_name', $new)
            ->build();
    }

    public function test()
    {
        $aes = new DefuseAes;
        $key = $aes->generateEncryptionKey();


        $enc = $aes->encrypt('hey there my friend', $key);
        $dec = $aes->decrypt($enc, $key);

        dd($key, $enc, $dec);


    }
}