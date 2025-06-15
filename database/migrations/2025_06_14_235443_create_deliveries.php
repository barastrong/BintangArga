<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('delivery_serial')->unique();
            $table->string('nama');
            $table->string('no_telepon');
            $table->string('email')->unique();
            $table->text('foto_profile')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
};