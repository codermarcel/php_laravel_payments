<?php

namespace App\Providers;

use App\Contracts\Mail\MailInterface;
use App\Contracts\Services\Password\PasswordServiceInterface;
use App\Service\Mailer\DummyMailer;
use App\Service\Password\Bcrypt;
use GuzzleHttp\ClientInterface;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'user' => User::class,
            'apikey' => ApiKey::class,
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MailInterface::class, DummyMailer::class);
        $this->app->bind(PasswordServiceInterface::class, Bcrypt::class);
//        $this->app->bind(TransactionBuilder::class, DummyTransactionB::class);
//        $this->app->bind(TransactionSearcher::class, DummyTransactionSearcher::class);

        $this->app->bind(ClientInterface::class, function ($app) {
            $sslVerify = ! app()->environment(['local', 'test', 'testing']);
            return new Client(['verify' => $sslVerify]);
        });
    }
}
