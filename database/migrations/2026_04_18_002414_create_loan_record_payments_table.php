<?php

use App\Models\LoanRecord;
use App\Models\OnlinePaymentMethod;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected const PAYMENT_STATUS = ["PENDING", "APPROVED", "DECLINED"];
    protected const PAYMENT_METHOD = ["PHYSICAL", "ONLINE"];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loan_record_payments', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->id();
            $table->foreignIdFor(LoanRecord::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'processed_by')->nullable()->constrained("users")->cascadeOnDelete();
            $table->longText('transaction_number');
            $table->bigInteger('amount');
            $table->dateTime('payment_date');
            $table->dateTime('processed_at')->nullable();
            $table->longText('decline_remarks')->nullable();
            $table->enum('status', self::PAYMENT_STATUS)->default(self::PAYMENT_STATUS[0]);
            $table->enum('method', self::PAYMENT_METHOD)->default(self::PAYMENT_METHOD[0]);
            $table->foreignIdFor(OnlinePaymentMethod::class)->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_record_payments');
    }
};
