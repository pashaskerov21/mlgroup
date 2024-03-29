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
        Schema::create('setting_translates', function (Blueprint $table) {
            $table->id();
            $table->integer('setting_id')->default(1);
            $table->string('title')->nullable();
            $table->text('address')->nullable();
            $table->text('description')->nullable();
            $table->text('keywords')->nullable();
            $table->string('author')->nullable();
            $table->text('copyright')->nullable();
            $table->string('lang')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_translates');
    }
};
