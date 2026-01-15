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
        Schema::create('violations', function (Blueprint $table) {
            $table->id();
            $table->date('violation_date');
            $table->string('license_plate', 20);
            $table->string('full_name');
            $table->integer('birth_year');
            $table->text('address');
            $table->text('violation_type');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['license_plate', 'violation_date']);
            $table->index('full_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('violations');
    }
};
