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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('payment_proof_image')->nullable();
            $table->enum('status', ['paid', 'pending', 'unpaid'])->default('unpaid');
            $table->string('paket')->nullable();
            $table->integer('package_price');
            $table->string('payment_month');
            $table->string('payment_year');
            $table->timestamps();


            $table->foreign('customer_id')->on('customers')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
