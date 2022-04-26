<?php

use App\BusinessLogic\Money\USD;
use App\Entity\ApiKey;
use App\Entity\CoinbaseProfile;
use App\Entity\EmailTemplate;
use App\Entity\EncryptionProfile;
use App\Entity\Group;
use App\Entity\PaypalProfile;
use App\Entity\Permission;
use App\Entity\Product;
use App\Entity\Role;
use App\Entity\SealCode;
use App\Entity\User;
use App\Service\Crypto\Aes\AesService;
use Faker\Generator;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Generate faker
        $faker = app(Generator::class);

    	//Owner / Admin
    	$owner = User::where('username', 'admin')->first();
        $user = User::where('username', '<>', 'admin')->firstOrFail();

        /**
         * Profiles
         */

        //Create paypal profile.
        $paypal_profile = new PaypalProfile;
        $paypal_profile->paypal_email = 'seller_paypal_email@email.com';
        $paypal_profile->enabled = true;
        $owner->paypal_profile()->save($paypal_profile);

        //Create coinbase profile.
        $coinbase_profile = new CoinbaseProfile;
        $coinbase_profile->api_key = 'bGs2B04ngSgmng14';
        $coinbase_profile->api_secret = 'yWeWXiPwUQOl6EBSluifrI1Rc9gH71fv';
        $coinbase_profile->enabled = true;
        $owner->coinbase_profile()->save($coinbase_profile);


        /**
         * Create and assign Products
         */
    	$product1 = new Product;
        $product1->setCryptoProvider(AesService::fromUser($owner));
        $product1->id = '88a7c796-cb30-4cd5-b536-88f3b4f6fb67';
    	$product1->name = 'Net Seal 3';
        $product1->price = USD::fromPennies(10);
        $product1->enabled = true;
        $product1->encrypted_key = str_random(100);
    	$owner->products()->save($product1);

    	$product2 = new Product;
        $product2->setCryptoProvider(AesService::fromUser($owner));
    	$product2->name = 'NanoCore 2';
        $product2->price = USD::fromPennies(20);
        $product2->enabled = true;
        $product2->encrypted_key = str_random(100);
    	$owner->products()->save($product2);

        $product3 = new Product;
        $product3->setCryptoProvider(AesService::fromUser($user));
        $product3->name = 'RandomProduct 1';
        $product3->price = USD::fromPennies(50);
        $product3->enabled = true;
        $product3->encrypted_key = str_random(100);
        $user->products()->save($product3);

        /**
         * Create email templates for products
         */
        $email_template1 = new EmailTemplate;
        $email_template1->title = 'My random name, kappa';
        $email_template1->email_content = sprintf('Thank you for purchasing %s, here is your code : %s', $product1->name, '<code>');
        $product1->email_template()->save($email_template1);

        $email_template2 = new EmailTemplate;
        $email_template2->title = 'Some other template title';
        $email_template2->email_content = sprintf('Thank you for purchasing my cool product %s, here is your code : %s', $product2->name, '<code>');
        $product2->email_template()->save($email_template2);


        //Seed codes for email template 1
        $codes1 = factory(App\Entity\SealCode::class, 5)
               ->make()
               ->each(function($c) use($email_template1) {
                    $email_template1->seal_codes()->save($c);
                });

        //Seed codes for email template 2
        $codes2 = factory(App\Entity\SealCode::class, 10)
               ->make()
               ->each(function($c) use($email_template2) {
                    $email_template2->seal_codes()->save($c);
                });
    }

    private function getPrivateKey()
    {
        return '-----BEGIN RSA PRIVATE KEY-----
MIIEowIBAAKCAQEAoX6RwiqsDB6MSY1U8GWQdCRptiiqbeSIwwSMZcYJSCJ/ZE62
F65X3y1641iQtu+iLaIsOLqHoJoYuOIlxPP40JGmMoQ1/X9PXCCgYokxudzQ2ij/
cRpLeiSNxKLEaHyNEfPdeFIJUku2WoFWTpcjPaqMWAtkUonjT9BEZQpT28rhcuR/
sw3AKo8CmdQxW+YE7E/8u0cQQRVYpVG2DzUHRlCL/+Evz6tTmGavctbPjdBDMaY/
Ipr9XDnIsTgzfFuYIBMrCMHXYdGMGBGNzJP6gsGgvfhxXzvq3+HGbWsmusjQ8GmU
9JceB8Iesv6eFcZbfkgJ9K/3wuTdW5N4qLLr8wIDAQABAoIBAHfVKWdArsWXbVWu
r9ZqJtRnqKFob3531BuRpnRmjMCgCJNv7KKJ1d5fKw7Dyy5Thq4B5np5vuYnMi0O
ciRBPOHXEdHuVPmznDmqZBh54RIfjkIzpchRUKxjr2a3uLInqa4mnLIJfa05TSi/
TEGo2JeLk/RJD7pHYwr4aafoD+3I4aPiznWa+c34a3kVHYrObnHJjtQsZtRQe20A
Nm89yCEMcHzDJTmgzLyqW+rUgg3WbpMvoyB56erpvEHheBmia8iZdiYceJHD6/IW
kDkqdcYWwYfzVW7vC+82l6+nE9pNY2VlyJogIKRowvNM4iUEo9ksu8MEVyqh/T9s
RzL7GNECgYEA00R8IoY/wgZxJrAxIBhxFLDj6rsB7NOxjYrxbq6oLXuSDbYwxbcg
NOBC1UwHQhkHToqYaw0NJ6oMThy6GzRSrg0Le44aNL2RIGtGQdE1CwpSDScakz0s
tCzzdPT8DinTnXLIk+hm8nJR0a0v/ThxRtNKR4n+aJiSXmREfC59M0cCgYEAw7Aw
nSTWaytGWsB6YdE7wx3ONqxUntlSJiVBAG24XkcqrQcpXZ2UyIEfetILMRaIDlKw
LQycIV7Qoe1P8CbLLaweO8itmfRRclmYa+qNooPQeN1EHO8cDciuFEnEiYTgB6rE
0m2P7upy4jtjMCsSDUclh/bGRI4txfPAneoa3/UCgYEAyEFtTShlvRtwG9T868hf
P9agY7pZi8vpzBn82gZSQbKU8cxVlMQNkjFVCGuloaCpzWgQK8DWTFeijFQskGbb
TEHvNXGwI3fg3ZLxqKeOmOVyeycqyJA/FJZbOuyREzfQb7kCqTishHmaVp7ME0Fy
FklnakJCVZDxhOmUBQXoBTcCgYAdB3QOu7o7J65GJCuDe0B8T12Z6rKa5e4zzm74
G06wXapNBLT0OD4sCEudMq+KVqdUSJvt8uLuaFxWyReErpyRZ+kMQVbPcdjrN7NO
vvrH0voIE/rYt/fXa5+3TsIjDF0XhhOwi6RAcvMb8Gdka98/rQA6TTdYUCcmKGS4
iFP4SQKBgAjJtYLro4YPYen8okVEO8ipqKWiM3HC9v+D3iF6oOVMj6Kt8glxrC+N
+R07WOg0DEwhJa+IY8krEzA+wcTdPah6kWqBH+aGCnsbZcLfLOmHxd/LdZKXgdQO
uIVCr8UPCUpXKAyLUESKUDIAhc8zgmce/9VT+ROqnPzR4826TBtc
-----END RSA PRIVATE KEY-----';
    }

    private function getPublicKey()
    {
        return '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAoX6RwiqsDB6MSY1U8GWQ
dCRptiiqbeSIwwSMZcYJSCJ/ZE62F65X3y1641iQtu+iLaIsOLqHoJoYuOIlxPP4
0JGmMoQ1/X9PXCCgYokxudzQ2ij/cRpLeiSNxKLEaHyNEfPdeFIJUku2WoFWTpcj
PaqMWAtkUonjT9BEZQpT28rhcuR/sw3AKo8CmdQxW+YE7E/8u0cQQRVYpVG2DzUH
RlCL/+Evz6tTmGavctbPjdBDMaY/Ipr9XDnIsTgzfFuYIBMrCMHXYdGMGBGNzJP6
gsGgvfhxXzvq3+HGbWsmusjQ8GmU9JceB8Iesv6eFcZbfkgJ9K/3wuTdW5N4qLLr
8wIDAQAB
-----END PUBLIC KEY-----';
    }

}
