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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();               
            $table->enum('type', ['buy_x_get_y', 'fixed_price', 'discount_percentage']); // Lista de tipos válidos
            $table->float('discount_percentage')->nullable();
            $table->integer('buy_quantity')->nullable();    
            $table->integer('get_quantity')->nullable();    
            $table->float('fixed_price')->nullable();       
            $table->dateTime('valid_from');
            $table->dateTime('valid_until');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
