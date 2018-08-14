<?php

namespace Tests\Feature\API;

use App\User;
use Tests\TestCase;
use App\Mail\PasswordMail;
use Illuminate\Mail\Mailable;
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

        Mail::assertQueued(PasswordMail::class, function (Mailable $mail) use ($user) {
            return $mail->to($user->email);
        });
    }
}
