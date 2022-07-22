<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userType_id');
            $table->string('name', 128);
            $table->string('username', 64);
            $table->string('email', 128)->unique();
            $table->string('jmbg', 14)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 256);
            $table->string('photo', 256)->nullable();
            $table->timestamp("last_login_at")->useCurrent();
            $table->integer('login_count')->default(0);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('userType_id')
                ->references('id')
                ->on('user_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
