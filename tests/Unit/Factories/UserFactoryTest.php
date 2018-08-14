<?php

namespace Tests\Unit\Factories;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * User factory test case.
 *
 * @author  Gleb Karpushkin  <rugleb@gmail.com>
 *
 * @package Tests\Unit\Factories
 */
class UserFactoryTest extends TestCase
{
    /**
     * Testing make factory method.
     *
     * @return void
     */
    public function testMakeMethod()
    {
        /**
         * The User instance.
         *
         * @var  User  $user
         */
        $user = factory(User::class)->make();

        $this->assertTrue($user instanceof User);
        $this->assertEquals($user->email, filter_var($user->email, FILTER_VALIDATE_EMAIL));
    }

    /**
     * Testing create factory method.
     *
     * @return void
     * @throws \Exception
     */
    public function testCreateMethod()
    {
        /**
         * The User model instance.
         *
         * @var  User  $user
         */
        $user = factory(User::class)->create();

        $this->assertTrue($user instanceof User);
        $this->assertTrue((bool) $user->name);
        $this->assertTrue((bool) $user->email);
        $this->assertDatabaseHas($user->getTable(), $user->toArray());

        $this->assertTrue($user->delete());
    }
}
