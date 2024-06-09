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
        Schema::create('linked_adverts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advert_id')
                ->constrained('adverts');
            $table->foreignId('linked_id')
                ->constrained('adverts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::table('linked_adverts', function (Blueprint $table) {
            $table->dropForeign(['advert_id']);
            $table->dropForeign(['linked_id']);
        });

        Schema::dropIfExists('linked_adverts');
    }

};
