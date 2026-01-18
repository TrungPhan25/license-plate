<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Thêm cột birth_date mới
        Schema::table('violations', function (Blueprint $table) {
            $table->date('birth_date')->nullable()->after('full_name');
        });

        // Chuyển đổi dữ liệu từ birth_year sang birth_date (giả định ngày 1 tháng 1)
        DB::statement("UPDATE violations SET birth_date = CONCAT(birth_year, '-01-01') WHERE birth_year IS NOT NULL");

        // Xóa cột birth_year cũ
        Schema::table('violations', function (Blueprint $table) {
            $table->dropColumn('birth_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Thêm lại cột birth_year
        Schema::table('violations', function (Blueprint $table) {
            $table->integer('birth_year')->nullable()->after('full_name');
        });

        // Chuyển đổi dữ liệu từ birth_date sang birth_year
        DB::statement("UPDATE violations SET birth_year = YEAR(birth_date) WHERE birth_date IS NOT NULL");

        // Xóa cột birth_date
        Schema::table('violations', function (Blueprint $table) {
            $table->dropColumn('birth_date');
        });
    }
};
