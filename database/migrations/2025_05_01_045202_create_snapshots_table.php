<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained()->onDelete('cascade');
            $table->date('snapshot_date');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['portfolio_id', 'snapshot_date']); // Prevent duplicate snapshots for a given date
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('snapshots');
    }
};
