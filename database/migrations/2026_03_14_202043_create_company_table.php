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
        Schema::create('company', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('id_type');
            $table->string('owner');
            $table->string('name');
            $table->string('piva')->nullable();
            $table->string('cf')->nullable();
            $table->string('address');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('cell');
            $table->string('iban');
            $table->integer('is_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company');
    }
};
