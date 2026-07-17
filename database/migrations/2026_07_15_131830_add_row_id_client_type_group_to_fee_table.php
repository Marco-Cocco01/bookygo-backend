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
        Schema::table('fee', function (Blueprint $table) {
            $table->integer('id_client_type')->after('amount');
            $table->integer('is_active')->after('id_client_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fee', function (Blueprint $table) {
            $table->dropColumn('id_client_type');
            $table->dropColumn('is_active');
        });
    }
};
