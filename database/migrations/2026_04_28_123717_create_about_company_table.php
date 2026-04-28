<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_company', function (Blueprint $table) {
            $table->id();
            
            // Media (Menyimpan path seperti 'uploads/compro/filename.jpg')
            $table->string('logo')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('video_thumbnail')->nullable();
            
            // Konten Profil
            $table->string('company_name')->nullable();
            $table->text('profile_description')->nullable();
            $table->text('visi')->nullable();
            $table->json('misi')->nullable(); // Sesuai casting array di model
            
            // Informasi Kontak
            $table->text('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 25)->nullable();
            $table->string('whatsapp', 25)->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_company');
    }
};