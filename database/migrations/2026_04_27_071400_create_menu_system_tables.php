<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // 1. Tabel Master Officer (Anggota)
        Schema::create('ms_officer', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('email')->unique();
            $table->string('name');
            $table->string('created_by')->nullable();
            $table->timestamp('created_date')->nullable();
            $table->string('created_ip')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamp('updated_date')->nullable();
            $table->string('updated_ip')->nullable();
        });

        // 2. Tabel Role
        Schema::create('ms_role', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('created_at')->nullable(); // Sesuai RoleController kamu
            $table->string('updated_at')->nullable();
        });

        // 3. Tabel Users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('noHP');
            $table->foreignId('role')->constrained('ms_role');
            $table->string('password');
            $table->timestamp('created_date')->nullable();
            $table->timestamp('updated_date')->nullable();
            $table->string('created_id')->nullable();
            $table->string('created_ip')->nullable();
            $table->string('updated_id')->nullable();
            $table->string('updated_ip')->nullable();
            $table->rememberToken();
        });

        // 4. Tabel Menu & SubMenu
        Schema::create('ms_menu', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon')->nullable();
            $table->string('url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('ms_sub_menu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('ms_menu')->onDelete('cascade');
            $table->string('name');
            $table->string('url');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        // 5. Tabel Access
        Schema::create('ms_access', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('ms_role')->onDelete('cascade');
            $table->foreignId('menu_id')->constrained('ms_menu')->onDelete('cascade');
            $table->foreignId('sub_menu_id')->nullable()->constrained('ms_sub_menu')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('ms_access');
        Schema::dropIfExists('ms_sub_menu');
        Schema::dropIfExists('ms_menu');
        Schema::dropIfExists('users');
        Schema::dropIfExists('ms_role');
        Schema::dropIfExists('ms_officer');
    }
};