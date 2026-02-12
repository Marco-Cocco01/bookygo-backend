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
        Schema::create('users_rights', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user')->unsigned()->comment('User ID');
            $table->integer('id_module')->unsigned()->comment('Module ID');
            $table->integer('can_view')->default(0)->comment('0: No, 1: Yes');
            $table->integer('can_add')->default(0)->comment('0: No, 1: Yes');
            $table->integer('can_edit')->default(0)->comment('0: No, 1: Yes');
            $table->integer('can_delete')->default(0)->comment('0: No, 1: Yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_rights');
    }
};
