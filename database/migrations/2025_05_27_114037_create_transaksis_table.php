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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('mitra_id')->nullable()->constrained('mitras')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUlid('inventari_id')->nullable()->constrained('inventaries')->nullOnDelete();
            $table->unsignedBigInteger('jumlah');
            $table->unsignedBigInteger('total_harga');
            $table->date('tgl_transaksi');
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
