<?php

namespace App\Mail;

use App\Password;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * The Password mailable.
 *
 * @author  Gleb Karpushkin  <rugleb@gmail.com>
 *
 * @package App\Mail
 */
class PasswordMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * User's password.
     *
     * @var Password $password
     */
    public $password;

    /**
     * Create a new message instance.
     *
     * @param  Password  $password
     * @return void
     */
    public function __construct(Password $password)
    {
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.auth.password');
    }
}
