<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('journal', function (Blueprint $table) {
            $table->string('journalNr', 50)->change();
        });

        DB::table('journal')
            ->where('journalNr', 'Special Is')
            ->update(['journalNr' => 'Special Issue']);
    }

    public function down(): void
    {
        Schema::table('journal', function (Blueprint $table) {
            $table->string('journalNr', 10)->change();
        });
    }
};
