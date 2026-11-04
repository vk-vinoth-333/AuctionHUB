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
            $table->foreignId('team_id')->nullable()->constrained('teams')->nullOnDelete();
            $table->string('name');
            $table->string('player_number')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();

            $table->bigInteger('sold_out_points')->nullable();
            $table->timestamp('sold_at')->nullable();

            $table->tinyInteger('status')->default(1);
            $table->enum('player_status', ['sold', 'unsold', 'pending'])->default('pending');
            $table->enum('payment_status', ['paid', 'not_paid'])->default('not_paid');

            $table->string('registration_source', 20)->default('admin');
            $table->enum('registration_status', ['pending', 'approved', 'rejected'])->default('approved');
            $table->string('registered_ip', 45)->nullable();

            $table->index(['tournament_id', 'phone'], 'players_tournament_phone_idx');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
