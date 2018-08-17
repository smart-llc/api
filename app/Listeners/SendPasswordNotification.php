<?php

namespace App\Listeners;

use App\Mail\PasswordMail;
use App\Events\PasswordCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * The Password notification.
 *
 * @author  Gleb Karpushkin  <rugleb@gmail.com>
 *
 * @package App\Listeners
 */
class SendPasswordNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PasswordCreated  $event
     * @return void
     */
    public function handle(PasswordCreated $event)
    {
        $mail = new PasswordMail($event->password);

        Mail::to($event->password->email)->send($mail);
    }
}
