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
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_code');
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('venue')->nullable();
            $table->string('city')->nullable();
            $table->integer('total_teams')->default(0);
            $table->string('prize_amount')->nullable();
            $table->boolean('is_pr_free')->default(0);
            $table->string('pr_amount')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->foreignId('organizer_id')->nullable()->constrained('admin')->nullOnDelete();
            $table->string('logo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
