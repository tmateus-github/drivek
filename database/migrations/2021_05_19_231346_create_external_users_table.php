<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable(false)->unique();
            $table->string('first_name', 32)->nullable();
            $table->string('last_name', 32)->nullable();
            $table->integer('fiscal_code')->nullable();
            $table->string('description', 255)->nullable();
            $table->timestamp('last_access_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('external_users');
    }
}
