<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('title');
            
            // ✅ KOLOM YANG HILANG DITAMBAHKAN DI SINI
            $table->decimal('amount', 15, 2)->default(0); // Kolom untuk nilai uang
            $table->boolean('type')->default(0); // Kolom untuk tipe (0=Pengeluaran, 1=Pendapatan)
            // ----------------------------------------
            
            $table->text('description')->nullable();
            $table->boolean('is_finished')->default(false);
            $table->string('cover')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};