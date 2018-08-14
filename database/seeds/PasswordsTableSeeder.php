<?php

use App\Password;
use Illuminate\Database\Seeder;

/**
 * The Passwords table seeder.
 *
 * @author  Gleb Karpushkin  <rugleb@gmail.com>
 */
class PasswordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Password::class, 10)->create();
    }
}
