<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('news', function (Blueprint $table) {
        $table->id();
        $table->string('judul');
        $table->string('slug')->unique();
        $table->text('isi');
        $table->string('gambar')->nullable();
        $table->string('status')->default('draft');
        $table->boolean('is_important')->default(false);
        // Audit & Custom Timestamps
        $table->string('created_by')->nullable();
        $table->string('updated_by')->nullable();
        $table->string('created_ip')->nullable();
        $table->string('updated_ip')->nullable();
        $table->timestamp('created_date')->nullable();
        $table->timestamp('updated_date')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
