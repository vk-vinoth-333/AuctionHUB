<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->nullable()->constrained('tournaments')->cascadeOnDelete();
            $table->foreignId('team_id')->nullable()->constrained('teams')->cascadeOnDelete();
            $table->string('name');
            $table->string('player_number')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->enum('player_status', ['sold', 'unsold'])->default('unsold');
            $table->enum('payment_status', ['paid', 'not_paid'])->default('not_paid');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
