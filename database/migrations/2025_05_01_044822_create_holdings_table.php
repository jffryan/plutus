<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('holdings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained()->onDelete('cascade');
            $table->foreignId('asset_id')->constrained()->onDelete('cascade');
            $table->decimal('target_allocation', 5, 4); // Allows values like 0.1500 for 15%
            $table->decimal('cost_basis', 20, 4);
            $table->decimal('quantity', 20, 4);
            $table->boolean('is_paper_trade')->default(false);
            $table->boolean('flag_close_this_year')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('holdings');
    }
};

