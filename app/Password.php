<?php

namespace App;

use Carbon\Carbon;
use App\Models\Traits\HasDocumentation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * The Password model.
 *
 * @property  int     $id
 * @property  string  $email
 * @property  string  $code
 * @property  Carbon  $expires_at
 *
 * @method  static  Builder   notExpired()
 *
 * @author  Gleb Karpushkin  <rugleb@gmail.com>
 *
 * @package App
 */
class Password extends Model
{
    const CODE_LENGTH = 4;
    const CODE_MAX_LENGTH = Password::CODE_LENGTH;
    const EMAIL_MAX_LENGTH = User::EMAIL_MAX_LENGTH;

    use HasDocumentation;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'passwords';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'expires_at',
    ];

    /**
     * Scope a query to only include not expired codes.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeNotExpired(Builder $query): Builder
    {
        return $query->where('expires_at', '>', Carbon::now());
    }
}
