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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_organization_id')
                ->nullable();
            $table->bigInteger('entity_id');
            $table->string('organization_type')
                ->default('internal')
                ->comment("Type of organization. Defaults to 'internal', allowed values: 'lgu', 'ngo','corporate', 'civic'");
            $table->string('organization_status')->default('active');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
