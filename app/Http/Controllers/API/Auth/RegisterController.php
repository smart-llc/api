<?php

namespace App\Http\Controllers\API\Auth;

use App\Password;
use App\Events\PasswordCreated;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;

/**
 * The API register controller.
 *
 * @author  Gleb Karpushkin  <rugleb@gmail.com
 *
 * @package App\Http\Controllers\API\Auth
 */
class RegisterController extends Controller
{
    /**
     * Creates temporary password and send it to input email.
     *
     * @param  RegisterRequest  $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $password = $this->createUniquePassword(
            $request->only('email')
        );

        event(new PasswordCreated($password));

        $message = 'Please, check your email address.';
        return response()->json(compact('message'), JsonResponse::HTTP_ACCEPTED);
    }

    /**
     * Create unique password.
     *
     * @param  array  $data
     * @return Password
     */
    protected function createUniquePassword(array $data): Password
    {
        $this->disablePreviousPasswords($data);

        return $this->createNewPassword($data);
    }

    /**
     * Disable previous passwords.
     *
     * @param  array  $data
     * @return void
     */
    protected function disablePreviousPasswords(array $data): void
    {
        Password::query()->where($data)->delete();
    }

    /**
     * Create new password.
     *
     * @param  array  $data
     * @return Password
     */
    protected function createNewPassword(array $data): Password
    {
        return Password::create($data);
    }
}
