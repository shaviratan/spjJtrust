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
        Schema::create('union_structure', function (Blueprint $table) {
            $table->id();
            
            // Informasi Posisi & Nama
            $table->string('position_title');
            $table->string('full_name');
            $table->string('region_name')->nullable();
            $table->string('term_period')->nullable(); // Contoh: 2024-2029
            
            /** * Self-referencing ID
             * parent_id akan null jika dia adalah posisi paling atas (Root)
             */
            $table->unsignedBigInteger('parent_id')->nullable();
            
            // Kolom Custom Logging (Sesuai $fillable di model)
            $table->string('created_by')->nullable();
            $table->dateTime('created_date')->nullable();
            $table->string('created_ip')->nullable();
            
            $table->string('updated_by')->nullable();
            $table->dateTime('updated_date')->nullable();
            $table->string('updated_ip')->nullable();

            // Opsional: Jika ingin foreign key agar data konsisten
            // $table->foreign('parent_id')->references('id')->on('union_structure')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('union_structure');
    }
};