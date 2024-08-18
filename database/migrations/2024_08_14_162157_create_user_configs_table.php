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
        Schema::create('user_configs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable();

            $table->string('tenant',50);
            $table->string('username',250);
            $table->string('password',250);
            $table->text('token')->nullable();
            $table->timestamp('expired_at')->nullable();  
            
            $table->foreignId('created_id')->nullable();
            $table->foreignId('updated_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_configs');
    }
};
