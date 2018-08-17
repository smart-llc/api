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
 * The API Auth controller test case.
 *
 * @author  Gleb Karpushkin  <rugleb@gmail.com>
 *
 * @package Tests\Feature\API
 */
class AuthControllerTest extends TestCase
{
    /**
     * @var User $user
     */
    protected $user;

    /**
     * @var Password $password
     */
    protected $password;

    /**
     * Set up testing environment.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->password = null;
        $this->user = factory(User::class)->make();

        // Before running the test, make sure that the user
        // with this name does not exist in our database.
        $this->assertDatabaseMissing($this->user->getTable(), $this->user->only('email'));
    }

    /**
     * Testing Auth pipeline.
     *
     * @return void
     */
    public function testAuthPipeline()
    {
        Mail::fake();

        // First, the user must enter his email and send it to API.
        $response = $this->postJson('api/auth', $this->user->toArray());

        // In response, API should put the task in the queue
        // and send letter with a confirmation code.
        $response->assertStatus(Response::HTTP_ACCEPTED);

        Mail::assertQueued(PasswordMail::class, function (PasswordMail $mail) {
            // Make sure that the sent letter contains the
            // confirmation code (created password).
            $this->password = $mail->password;
            // And the letter went to the entered email address.
            return $mail->to($this->user->email);
        });

        // Also, necessary to verify that the confirmation code
        // for this had to be the only one in the database.
        $passwords = Password::query()->where($this->user->only('email'))->get();

        $this->assertEquals(1, $passwords->count());
        $this->assertTrue($this->password->is($passwords->first()));

        // Next, we will try to send an e-mail and confirmation
        // code to the authorization API route.
        $response = $this->postJson('api/login', $this->password->toArray());

        // In response, we must obtain an authorization token.
        $response
            ->assertJsonStructure(['token'])
            ->assertStatus(Response::HTTP_CREATED);

        // Finally, we will try to access the protected
        // resource using the received token.
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $response->decodeResponseJson('token')
        ])->getJson('api/user');

        $response->assertStatus(Response::HTTP_OK);

        // Make sure that we deactivated all created passwords
        // for authorization through this email.
        $passwords = Password::query()->where($this->user->only('email'))->get();

        $this->assertEquals(0, $passwords->count());
    }

    /**
     * Tear down testing environment.
     *
     * @return void
     */
    public function tearDown()
    {
        // We finish the test by checking that the user
        // was one and already deleted.
        $deleted = User::query()->where($this->user->only('email'))->delete();

        $this->assertEquals(1, $deleted);
        $this->assertDatabaseMissing($this->user->getTable(), $this->user->only('email'));

        parent::tearDown();
    }

}
