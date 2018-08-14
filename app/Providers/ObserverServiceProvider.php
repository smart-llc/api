<?php

namespace App\Providers;

use App\Observers\PasswordObserver;
use App\Observers\UserObserver;
use App\Password;
use App\User;
use Illuminate\Support\ServiceProvider;

/**
 * The Observer service provider.
 *
 * @author  Gleb Karpushkin  <rugleb@gmail.com>
 *
 * @package App\Providers
 */
class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Password::observe(PasswordObserver::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
