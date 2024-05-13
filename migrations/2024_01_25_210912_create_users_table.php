<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->string('name', 60);
            $table->string('email', 60)->unique();
            $table->string('password');
            $table->string('cidade', 32);
            $table->string('estado', 20);
            $table->string('discord',30)->nullable();
            $table->string('linkedin',60)->nullable();
            $table->string('permission',20)->nullable();
            $table->integer('active')->nullable()->default(1);
            $table->rememberToken();
            $table->timestamps();

            $table->index('uuid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
