<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('annonces', function (Blueprint $table) {
            $table->enum('transmission', ['manuelle', 'automatique'])->default('manuelle')->after('carburant');
            $table->integer('puissance')->default(0)->after('transmission');
        });
    }

    public function down(): void
    {
        Schema::table('annonces', function (Blueprint $table) {
            $table->dropColumn(['transmission', 'puissance']);
        });
    }
};
