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
        Schema::create('retros', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignId('promotion_id')->nullable()->constrained('promotions')->onDelete('set null');
            $table->foreignId('creator_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('retros', function (Blueprint $table) {
            $table->dropForeign(['creator_id']);
            $table->dropColumn('creator_id');
        });

        Schema::dropIfExists('retros');
    }
};
