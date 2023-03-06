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
        Schema::table('activities', function (Blueprint $table) {
            $table->string('parent_organization_id')
                ->nullable()
                ->after('id');
            $table->string('child_organization_id')
                ->nullable()
                ->after('parent_organization_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('parent_organization_id');
            $table->dropColumn('child_organization_id');
        });
    }
};
