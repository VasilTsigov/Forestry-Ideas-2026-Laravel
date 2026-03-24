<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('magazine', function (Blueprint $table) {
            $table->integerIncrements('mgzn_id');
            $table->string('mgzn_number', 20);
            $table->string('mgzn_year', 10);
            $table->string('mgzn_volume', 10);
            $table->string('mgzn_title_bg', 100)->nullable();
            $table->string('mgzn_title_en', 100);
            $table->text('mgzn_contents_bg')->nullable();
            $table->text('mgzn_contents_en');
            $table->string('mgzn_fflename', 100);
            $table->unsignedInteger('mgzn_count')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('magazine');
    }
};
