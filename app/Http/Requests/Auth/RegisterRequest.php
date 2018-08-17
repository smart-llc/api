<?php

namespace App\Http\Requests\Auth;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * The API register request.
 *
 * @author  Gleb Karpushkin  <rugleb@gmail.com>
 *
 * @package App\Http\Requests\Auth
 */
class RegisterRequest extends FormRequest
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
            'email' => 'required|string|email|max:'.User::EMAIL_MAX_LENGTH,
        ];
    }
}
