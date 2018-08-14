<?php

namespace App\Http\Requests\API;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * The Password Request.
 *
 * @author  Gleb Karpushkin  <rugleb@gmail.com>
 *
 * @package App\Http\Requests\API
 */
class PasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|string|email|max:' . User::EMAIL_MAX_LENGTH,
        ];
    }
}
