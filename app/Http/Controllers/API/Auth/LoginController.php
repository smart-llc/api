<?php

namespace App\Http\Controllers\API\Auth;

use App\User;
use App\Password;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Laravel\Passport\PersonalAccessTokenResult as Token;

/**
 * The API login controller.
 *
 * @author  Gleb Karpushkin  <rugleb@gmail.com>
 *
 * @package App\Http\Controllers\API\Auth
 */
class LoginController extends Controller
{
    /**
     * Personal access token name.
     */
    const TOKEN_NAME = 'SMART-AS API TOKEN';

    /**
     * Authorizes a user through mail-code pair.
     *
     * @param  LoginRequest  $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->only('email', 'code');

        if ($token = $this->tryAuthorize($data)) {
            return response()->json(compact('token'), JsonResponse::HTTP_CREATED);
        }

        $message = 'Your activation code is invalid or expired.';
        return response()->json(compact('message'), JsonResponse::HTTP_FORBIDDEN);
    }

    /**
     * Trying to authorize the user.
     *
     * @param  array  $data
     * @return bool|Token
     */
    protected function tryAuthorize(array $data)
    {
        $password = Password::notExpired()->where($data)->first();

        if (! $password instanceof Password) {
            return false;
        }

        $this->disablePasswords($password->email);

        return $this->createToken($password->email)->accessToken;
    }

    /**
     * Disable passwords by email.
     *
     * @param  string  $email
     * @return void
     */
    protected function disablePasswords(string $email): void
    {
        Password::query()->where(['email' => $email])->delete();
    }

    /**
     * Create new personal access token.
     *
     * @param  string  $email
     * @return Token
     */
    protected function createToken(string $email): Token
    {
        return $this->getUser($email)->createToken(
            $this->getTokenName()
        );
    }

    /**
     * Return token name.
     *
     * @return string
     */
    protected function getTokenName(): string
    {
        return static::TOKEN_NAME;
    }

    /**
     * Return User model instance.
     *
     * @param  string  $email
     * @return User
     */
    protected function getUser(string $email): User
    {
        return User::firstOrCreate([
            'email' => $email,
        ]);
    }
}
