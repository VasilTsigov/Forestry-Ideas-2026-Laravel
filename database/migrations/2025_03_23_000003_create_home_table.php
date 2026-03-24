<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home', function (Blueprint $table) {
            $table->smallIncrements('homeID');
            $table->text('homeText');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home');
    }
};
