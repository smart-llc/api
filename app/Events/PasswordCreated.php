<?php

namespace App\Events;

use App\Password;
use Illuminate\Queue\SerializesModels;

/**
 * The New Password created event.
 *
 * @author  Gleb Karpushkin  <rugleb@gmail.com>
 *
 * @package App\Events
 */
class PasswordCreated
{
    use SerializesModels;

    /**
     * @var Password $password
     */
    public $password;

    /**
     * Create a new event instance.
     *
     * @param  Password  $password
     * @return void
     */
    public function __construct(Password $password)
    {
        $this->password = $password;
    }
}
