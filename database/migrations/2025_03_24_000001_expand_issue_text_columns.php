<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('issue', function (Blueprint $table) {
            $table->text('issueTitle')->nullable()->change();
            $table->mediumText('issueSummary')->nullable()->change();
            $table->text('issueAutor')->nullable()->change();
            $table->text('issueFrom')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('issue', function (Blueprint $table) {
            $table->string('issueTitle', 500)->nullable()->change();
            $table->string('issueSummary', 3000)->nullable()->change();
            $table->string('issueAutor', 500)->nullable()->change();
            $table->string('issueFrom', 500)->nullable()->change();
        });
    }
};
