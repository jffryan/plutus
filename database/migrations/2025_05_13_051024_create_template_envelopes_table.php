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
        Schema::create('template_envelopes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained('budget_templates')->onDelete('cascade');
            $table->foreignId('envelope_category_id')->constrained()->onDelete('cascade');
            $table->decimal('expected_amount', 12, 2);
            $table->timestamps();

            $table->unique(['template_id', 'envelope_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('template_envelopes');
    }
};
