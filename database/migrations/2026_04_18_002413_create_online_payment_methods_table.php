<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected const GATEWAY = ["GCASH", "GOTYME", "BANK"];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('online_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->longText('reference_id');
            $table->longText('evidence');
            $table->enum('status', self::GATEWAY);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('online_payment_methods');
    }
};
