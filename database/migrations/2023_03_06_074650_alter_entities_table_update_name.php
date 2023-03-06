<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('entities', function($table) {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->string('full_name')
                ->nullable()
                ->change();
            $table->string('email')
                ->nullable()
                ->change();
            $table->string('status')
                ->default('active')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entities', function($table) {
            $table->string('first_name');
            $table->string('last_name');
        });
    }
};
