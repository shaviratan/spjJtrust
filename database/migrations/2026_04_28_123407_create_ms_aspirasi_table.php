<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ms_aspirasi', function (Blueprint $table) {
            $table->id();
            // Menggunakan NIK sebagai relasi (asumsi tipe data string/char sesuai standar KTP)
            $table->string('nik'); 
            
            $table->string('type'); // Contoh: Pengaduan, Saran, dll.
            $table->string('category', 100);
            $table->string('subject', 255);
            $table->text('description');
            $table->string('attachment')->nullable(); // Menyimpan nama file
            
            // Status pengaduan (misal: pending, diproses, selesai)
            $table->string('status')->default('pending');
            
            // Kolom Tambahan berdasarkan Controller
            $table->text('admin_response')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->string('created_ip')->nullable();
            
            // Tracking Update oleh Admin
            $table->string('updated_by')->nullable();
            $table->string('updated_ip')->nullable();
            
            $table->timestamps();

            // Indexing untuk performa query
            $table->index('nik');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ms_aspirasi');
    }
};