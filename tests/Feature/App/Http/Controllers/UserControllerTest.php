<?php

namespace Tests\Feature\API;

use App\User;
use Tests\TestCase;
use Illuminate\Http\Response;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * The User controller test case.
 *
 * @author  Gleb Karpushkin  <rugleb@gmail.com>
 *
 * @package Tests\Feature\API
 */
class UserControllerTest extends TestCase
{
    /**
     * @var User $user
     */
    protected $user;

    /**
     * Set up testing environment.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->assertDatabaseHas($this->user->getTable(), $this->user->only('email'));
    }

    /**
     * Testing GET: /api/user route.
     *
     * @return void
     * @throws \Exception
     */
    public function testGetMethod()
    {
        // When requesting an unauthorized user, API must return 401 HTTP code.
        $this->getJson('api/user')->assertStatus(Response::HTTP_UNAUTHORIZED);

        // Authorize the user.
        Passport::actingAs($this->user);

        // Need to verify that this route can return user's data.
        $response = $this->getJson('api/user');

        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'data' => [
                    'id', 'email', 'name', 'created_at', 'updated_at',
                ]
            ]);
    }

    /**
     * Testing PUT: /api/user route.
     *
     * @return void
     * @throws \Exception
     */
    public function testPutMethod()
    {
        // When requesting an unauthorized user, API must return 401 HTTP code.
        $this->putJson('api/user')->assertStatus(Response::HTTP_UNAUTHORIZED);

        // Now we will request resource with the token.
        Passport::actingAs($this->user);

        // We need to verify that this route can change user's data.
        // Try changing User name property.
        $response = $this->putJson('api/user', [
            'name' => 'test',
            'foo'  => 'bar',
        ]);

        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'data' => [
                    'id', 'email', 'name', 'created_at', 'updated_at',
                ],
            ]);

        // Verify that the user name has really changed.
        $founded = User::query()->where($this->user->only('email'))->first();

        $this->assertEquals('test', $founded->name);
        $this->assertEquals($this->user->id, $founded->id);
        $this->assertEquals($this->user->email, $founded->email);
    }

    /**
     * Testing DELETE: /api/user route.
     *
     * @return void
     * @throws \Exception
     */
    public function testDeleteMethod()
    {
        // When requesting an unauthorized user, API must return 401 HTTP code.
        $this->deleteJson('api/user')->assertStatus(Response::HTTP_UNAUTHORIZED);

        // Now we will request resource with the token.
        Passport::actingAs($this->user);

        // Need to verify that this route can remove the user.
        $this->deleteJson('api/user')->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseMissing($this->user->getTable(), $this->user->only('id'));
        $this->assertDatabaseMissing($this->user->getTable(), $this->user->only('email'));
    }

    /**
     * Tear down testing environment.
     *
     * @return void
     * @throws \Exception
     */
    public function tearDown()
    {
        parent::tearDown();

        $this->user->delete();
    }
}
