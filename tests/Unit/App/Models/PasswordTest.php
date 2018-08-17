<?php

namespace Tests\Unit\App\Models;

use App\Password;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * The Password model test case.
 *
 * @author  Gleb Karpushkin  <rugleb@gmail.com>
 *
 * @package Tests\Unit\App\Models
 */
class PasswordTest extends TestCase
{
    /**
     * Testing not expired scope method.
     *
     * @return void
     * @throws \Exception
     */
    public function testNotExpiredScope()
    {
        /**
         * The Password model instance.
         *
         * @var  Password  $password
         */
        $password = factory(Password::class)->create();

        $founded = Password::notExpired()->orderByDesc('id')->first();

        $this->assertTrue($password->is($founded));
        $this->assertTrue($password->delete());

        foreach (Password::notExpired()->get() as $password) {
            $this->assertGreaterThan(Carbon::now(), $password->expires_at);
        }
    }
}
