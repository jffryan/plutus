<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_envelopes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_id')->constrained()->onDelete('cascade');
            $table->foreignId('envelope_category_id')->constrained()->onDelete('cascade');
            $table->decimal('expected_amount', 12, 2);
            $table->decimal('actual_amount', 12, 2)->nullable(); // set on budget closure
            $table->timestamps();

            $table->unique(['budget_id', 'envelope_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('budget_envelopes');
    }
};
