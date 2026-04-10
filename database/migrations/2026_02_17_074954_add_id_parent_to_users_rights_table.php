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
        Schema::table('users_rights', function (Blueprint $table) {
            $table->bigInteger('id_parent')->unsigned()->after('id')->default(null)->comment('Riferimento a utente padre delegante, se presente');

            $table->foreign('id_parent')
              ->references('id_user')
              ->on('type_user')
              ->onDelete('cascade'); 
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_rights', function (Blueprint $table) {
            $table->dropForeign(['id_parent']);
            $table->dropColumn('id_parent');
        });
    }
};
