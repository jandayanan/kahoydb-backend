<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariablesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('variables', function (Blueprint $table) {
            $table->id();
            $table->string("key")
                ->comment("key of this variable as shown to the user");
            $table->string("value")
                ->comment("Value of this variable once selected.");
            $table->string("description")
                ->comment("Description of this variable as a helper")
                ->nullable();
            $table->string("type")
                ->comment("Type of this variable. Based from variable_type slug");
            $table->string("status")
                ->default("active")
                ->comment("Data status of each entry.");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variables');
    }
}
