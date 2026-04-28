<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Mengisi data awal untuk tabel about_company
        DB::table('about_company')->insert([
            'logo' => 'default-logo.png',
            'profile_image' => 'default-profile.png',
            'video_thumbnail' => 'default-thumb.png',
            'company_name' => 'SPJ Jtrust',
            'profile_description' => 'Deskripsi profil perusahaan untuk keperluan testing.',
            'visi' => 'Visi Testing',
            'misi' => json_encode(['Misi 1', 'Misi 2']), // Data harus format JSON untuk kolom misi
            'address' => 'Jl. Sudirman No. 1, Jakarta',
            'email' => 'admin@spjjtrust.com',
            'phone' => '021-1234567',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tambahkan seeder lain di sini jika ada tabel lain yang wajib ada isinya
    }
}