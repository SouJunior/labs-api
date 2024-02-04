<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSquadsTable extends Migration
{
    public function up(): void
    {
        Schema::create('squads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->uuid('product_uuid')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('active')->nullable()->default(1);
            $table->datetimes();

            $table->index('uuid');

            $table->foreign('product_uuid')->references('uuid')->on('products')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('squads');
    }
}
