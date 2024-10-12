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
        Schema::create('volunteerings', function (Blueprint $table) {
            $table->id();

            $table->text('title')->nullable();
            $table->text('job')->nullable();
            $table->string('image')->default('default.png');
            $table->date('date')->nullable();

            $table->boolean('status')->default(0);
            $table->integer('index')->default(0);
            $table->index('index');
            
            $table->foreignId('admin_id')->constrained();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteerings');
    }
};
