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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('legacy_id')->nullable();
            $table->string('chip_number')->nullable();
            $table->string('studbook_number')->nullable();
            $table->string('name')->nullable();
            $table->string('kennel')->nullable();
            $table->boolean('kennel_name_first')->default(false);
            $table->json('awards')->nullable();
            $table->text('note')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('breed')->nullable();
            $table->enum('sex', ['male', 'female', 'unknown'])->nullable();
            $table->string('size')->nullable();
            $table->string('hair_type')->nullable();
            $table->string('hair_color')->nullable();
            $table->unsignedBigInteger('pedigree_id')->nullable();
            $table->unsignedBigInteger('mother_id')->nullable();
            $table->unsignedBigInteger('father_id')->nullable();
            $table->timestamps();

            $table->foreign('pedigree_id')->references('id')->on('pedigrees')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('mother_id')->references('id')->on('animals')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('father_id')->references('id')->on('animals')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
