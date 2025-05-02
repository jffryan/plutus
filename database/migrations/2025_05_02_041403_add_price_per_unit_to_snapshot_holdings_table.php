<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('snapshot_holdings', function (Blueprint $table) {
            $table->decimal('price_per_unit', 20, 4)->nullable()->after('value');
        });
    }

    public function down(): void
    {
        Schema::table('snapshot_holdings', function (Blueprint $table) {
            $table->dropColumn('price_per_unit');
        });
    }
};
