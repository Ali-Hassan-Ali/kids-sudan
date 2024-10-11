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
        Schema::create('creatives', function (Blueprint $table) {
            $table->id();

            $table->text('name');
            $table->string('image')->default('default.png');

            $table->date('date')->nullable();
            $table->text('links')->nullable();

            $table->boolean('status')->default(0);
            $table->integer('index')->default(0);
            $table->index('index');
            
            $table->foreignId('admin_id')->constrained();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creatives');
    }
};