<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advert_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advert_id')
                ->constrained('adverts');
            $table->foreignId('user_id')
                ->constrained('users');
            $table->string('title')->nullable();
            $table->mediumText('comment')->nullable();
            $table->integer('rating');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advert_reviews', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['advert_id']);
            $table->dropForeign(['user_id']);
        });

        // Drop the 'advert_reviews' table
        Schema::dropIfExists('advert_reviews');
    }

};
