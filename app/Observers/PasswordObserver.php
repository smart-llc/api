<?php

namespace App\Observers;

use App\Password;
use Carbon\Carbon;
use Illuminate\Support\Str;

/**
 * The Password model observer.
 *
 * @author  Gleb Karpushkin  <rugleb@gmail.com>
 *
 * @package App\Observers
 */
class PasswordObserver
{
    /**
     * Handle the password "created" event.
     *
     * @param  Password  $password
     * @return void
     *
     * @throws \Exception
     */
    public function creating(Password $password)
    {
        $password->code = Password::generateSecretCode();
        $password->expires_at = Carbon::now()->addDay();
    }
}
