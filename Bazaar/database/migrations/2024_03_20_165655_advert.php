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
        Schema::create('adverts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->mediumText('description')->nullable();
            $table->boolean('is_rental')->default(0);
            $table->timestamps();
        });

        Schema::table('adverts', function (Blueprint $table) {
            $table->foreignId('owner_id')
                ->constrained('users');

            // Foreign key constraint for the current borrower of the post
            $table->foreignId('current_borrower_id')
                ->nullable()
                ->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::table('adverts', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['owner_id']);
            $table->dropColumn('owner_id');
            $table->dropForeign(['current_borrower_id']);
            $table->dropColumn('current_borrower_id');
        });

        // Drop the 'adverts' table
        Schema::dropIfExists('adverts');
    }
};
