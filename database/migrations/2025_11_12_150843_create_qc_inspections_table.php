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
        Schema::create('qc_inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_id')->constrained()->onDelete('cascade');
            $table->foreignId('inspector_id')->constrained('users')->onDelete('cascade');
            $table->unsignedInteger('passed_quantity')->default(0);
            $table->unsignedInteger('failed_quantity')->default(0);
            $table->enum('result', ['lolos', 'gagal', 'partial']);
            $table->enum('damage_type', ['kerusakan_fisik', 'dimensi_tidak_sesuai', 'cacat_permukaan', 'lainnya'])->nullable();
            $table->text('notes')->nullable();
            $table->text('recommendation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qc_inspections');
    }
};
