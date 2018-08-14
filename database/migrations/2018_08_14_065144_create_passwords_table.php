<?php

use App\User;
use App\Password;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * The password table migration.
 *
 * @author  Gleb Karpushkin  <rugleb@gmail.com>
 */
class CreatePasswordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passwords', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', Password::CODE_MAX_LENGTH)->index();
            $table->string('email', Password::EMAIL_MAX_LENGTH)->index();
            $table->timestamp('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passwords');
    }
}
