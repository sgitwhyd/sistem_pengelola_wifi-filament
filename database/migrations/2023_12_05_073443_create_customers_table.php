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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paket_id');
            $table->unsignedBigInteger('server_id');
            $table->string('name')->unique();
            $table->string('alamat');
            $table->string('no_hp');
            $table->string('ip_address')->unique();
            $table->timestamps();

            $table->foreign('paket_id')->on('pakets')->references('id')->onDelete('cascade');
            $table->foreign('server_id')->on('servers')->references('id')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
