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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            $table->text('name')->nullable();
            $table->text('job')->nullable();
            $table->string('picture')->default('default.png');

            $table->longText('description')->nullable();

            $table->boolean('status')->default(0);
            $table->integer('index')->default(0);
            $table->index('index');
            
            $table->foreignId('admin_id')->constrained();

            $table->longText('links')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
