<?php

declare(strict_types=1);

use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;

class CreateMemberTable extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('role');
            $table->integer('active')->nullable()->default(1);
            $table->datetimes();

            $table->uuid('squad_uuid');
            $table->foreign('squad_uuid')->references('uuid')->on('squads');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
}
