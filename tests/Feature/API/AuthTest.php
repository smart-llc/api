<?php

namespace Tests\Feature\API;

use App\User;
use App\Password;
use Tests\TestCase;
use App\Mail\PasswordMail;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * The API Auth test case.
 *
 * @author  Gleb Karpushkin  <rugleb@gmail.com>
 *
 * @package Tests\Feature\API
 */
class AuthTest extends TestCase
{
    /**
     * Testing API Auth pipeline.
     *
     * @return void
     */
    public function testAuth()
    {
        Mail::fake();

        /**
         * @var User $user
         */
        $user = factory(User::class)->make();

        $response = $this->postJson('api/auth', $user->toArray());

        $response->assertStatus(Response::HTTP_OK);

        /**
         * @var Password $password
         */
        $password = new Password();

        Mail::assertQueued(PasswordMail::class, function (PasswordMail $mail) use ($user, & $password) {
            $password = $mail->password;
            return $mail->to($user->email);
        });

        $response = $this->postJson('api/login', $password->toArray());

        $response->assertStatus(Response::HTTP_OK);

        $token = $response->decodeResponseJson('token');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->getJson('api/user');

        $response->assertStatus(Response::HTTP_OK);

    }
}
