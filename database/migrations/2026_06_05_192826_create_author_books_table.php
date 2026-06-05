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
    //Un autor puede tener múltiples libros
	//Un libro puede tener múltiples autores

        Schema::create('author_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('book_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->integer('author_order');
            $table->timestamps();

            $table->unique(['author_id', 'book_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('author_books');
    }
};
