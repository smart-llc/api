<?php

namespace Tests\Unit\Factories;

use App\Password;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Password factory test case.
 *
 * @author  Gleb Karpushkin  <rugleb@gmail.com>
 *
 * @package Tests\Unit\Factories
 */
class PasswordFactoryTest extends TestCase
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
         * @var  Password  $password
         */
        $password = factory(Password::class)->make();

        $this->assertTrue($password instanceof Password);
        $this->assertEquals(
            $password->email,
            filter_var($password->email, FILTER_VALIDATE_EMAIL)
        );
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
         * The User instance.
         *
         * @var  Password  $password
         */
        $password = factory(Password::class)->create();

        $this->assertDatabaseHas($password->getTable(), $password->toArray());

        $this->assertEquals(strlen($password->code), 4);
        $this->assertTrue($password->expires_at instanceof Carbon);

        $this->assertTrue($password->delete());
    }

}
