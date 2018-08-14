<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * The User model.
 *
 * @property  int     $id
 * @property  string  $name
 * @property  string  $email
 * @property  Carbon  $created_at
 * @property  Carbon  $updated_at
 *
 * @author  Gleb Karpushkin  <rugleb@gmail.com>
 *
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];
}
