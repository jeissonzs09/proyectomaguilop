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
Schema::table('usuario', function (Blueprint $table) {
    $table->string('two_factor_secret')->nullable();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
Schema::table('usuario', function (Blueprint $table) {
    $table->dropColumn('two_factor_secret');
});

    }
};
