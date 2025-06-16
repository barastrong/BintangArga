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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('sellers')->onDelete('cascade');
            $table->foreignId('size_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('total_price', 12, 2);
            $table->string('status')->default('pending'); // hanya satu nilai default
            $table->enum('status_pengiriman', ['pending', 'picked_up', 'shipping', 'delivered'])
                  ->default('pending');
            $table->string('payment_method');
            $table->string('payment_status')->default('unpaid'); // satu default
            $table->string('shipping_address');
            $table->string('phone_number');
            $table->string('description')->nullable(); // sebaiknya bisa nullable
            $table->enum('status_pembelian', ['beli', 'keranjang'])->default('beli');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
