<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Password;
use App\Mail\PasswordMail;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\API\LoginRequest;
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
     * OAuth Password grant token name.
     */
    const TOKEN_NAME = 'SMART-AS API TOKEN';

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

        $this->disablePasswords($request->only('email'));

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

    /**
     * Generate Password token for valid user.
     *
     * @param  LoginRequest  $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if ($password = $this->getPassword($request->only('email', 'code'))) {
            $this->disablePasswords($request->only('email'));
            return response()->json([
                'token' => $this->getUser($request->only('email'))->createToken(static::TOKEN_NAME)
            ]);
        }

        return response()->json([
            'message' => 'Activation code is not valid.'
        ], JsonResponse::HTTP_FORBIDDEN);
    }

    /**
     * Find password by input data.
     *
     * @param  array  $data
     * @return Password
     */
    protected function getPassword(array $data)
    {
        /**
         * @var Password $password
         */
        $password = Password::notExpired()->where($data)->first();

        return $password;
    }

    protected function disablePasswords(array $data)
    {
        Password::query()->where($data)->delete();
    }

    /**
     * Find user by input data.
     *
     * @param  array  $data
     * @return User
     */
    protected function getUser(array $data)
    {
        /**
         * @var User $user
         */
        $user = User::query()->firstOrCreate($data);

        return $user;
    }

}
