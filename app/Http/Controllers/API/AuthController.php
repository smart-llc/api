<?php

namespace App\Http\Controllers\API;

use App\Password;
use App\Mail\PasswordMail;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\API\PasswordRequest;

/**
 * The API Auth controller.
 *
 * @author  Gleb Karpushkin  <rugleb@gmail.com>
 *
 * @package App\Http\Controllers\API
 */
class AuthController extends Controller
{
    /**
     * Create new password and send authentication code
     * to input user's email address.
     *
     * @param  PasswordRequest $request
     * @return JsonResponse
     */
    public function index(PasswordRequest $request): JsonResponse
    {
        $email = $request->get('email');
        $password = $this->createPassword(compact('email'));

        $this->notify($email, $password);

        return response()->json([
            'message' => 'Please, check your email.',
        ]);
    }

    /**
     * Create new password model.
     *
     * @param  array  $data
     * @return Password
     */
    protected function createPassword(array $data)
    {
        return Password::create($data);
    }

    /**
     * Notify user by email.
     *
     * @param  string  $email
     * @param  Password  $password
     */
    protected function notify(string $email, Password $password)
    {
        $mail = new PasswordMail($password);

        Mail::to($email)->send($mail);
    }

}
