<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('landing_page_id')
                ->nullable()
                ->constrained('landing_pages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['landing_page_id']);
            $table->dropColumn('landing_page_id');
        });
    }

};
