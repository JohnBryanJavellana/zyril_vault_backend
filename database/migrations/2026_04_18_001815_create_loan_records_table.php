<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected const LOAN_RECORD_STATUS = ["PENDING", "VERIFYING", "APPROVED", "DECLINED", "CANCELLED", "OVERDUE"];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loan_records', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'processed_by')->nullable()->constrained("users")->cascadeOnDelete();
            $table->bigInteger('amount');
            $table->date('start');
            $table->date('end');
            $table->integer('day_count');
            $table->dateTime('borrowed_at');
            $table->dateTime('processed_at')->nullable();
            $table->longText('purpose');
            $table->longText('decline_remarks')->nullable();
            $table->enum('status', self::LOAN_RECORD_STATUS)->default(self::LOAN_RECORD_STATUS[0]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_records');
    }
};
