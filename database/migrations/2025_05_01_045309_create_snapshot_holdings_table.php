<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('snapshot_holdings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('snapshot_id')->constrained()->onDelete('cascade');
            $table->foreignId('asset_id')->constrained()->onDelete('cascade');
            $table->decimal('quantity', 20, 4);
            $table->decimal('value', 20, 4);           // Total market value at snapshot
            $table->timestamps();

            $table->unique(['snapshot_id', 'asset_id']); // Prevent duplicate entries
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('snapshot_holdings');
    }
};