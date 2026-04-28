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
    Schema::create('announcements', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('category');
        $table->text('content');
        $table->date('expires_at')->nullable();
        
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
        Schema::dropIfExists('announcements');
    }
};
