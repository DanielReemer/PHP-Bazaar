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
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advert_id')
                ->constrained('adverts');
            $table->foreignId('user_id')
                ->constrained('users');
            $table->boolean('purchased')->default(false);
            $table->double('money');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::table('bids', function (Blueprint $table) {
            $table->dropForeign(['advert_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('bids');
    }

};
