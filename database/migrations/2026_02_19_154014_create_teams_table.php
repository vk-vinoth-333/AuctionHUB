<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->nullable()->constrained('tournaments')->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->string('short_name', 20)->nullable();
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();

            $table->bigInteger('available_points')->default(60000);
            $table->integer('player_count')->default(0);
            $table->string('pool')->nullable();

            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
