<?php

namespace App\Providers;

use App\Events\PasswordCreated;
use App\Listeners\SendPasswordNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * The Event service provider.
 *
 * @author  Gleb Karpushkin  <rugleb@gmail.com>
 *
 * @package App\Providers
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        PasswordCreated::class => [
            SendPasswordNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
