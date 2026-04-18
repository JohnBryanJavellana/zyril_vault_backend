<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected const AUDIT_TYPE = [
        "LOGIN",
        "UPDATE_CONTACT_INFO",
        "UPDATE_HOME_LOCATION",
        "CREATE_LOAN_RECORD",
        "UPDATE_LOAN_RECORD",
        "CREATE_LOAN_RECORD_PAYMENT",
        "UPDATE_LOAN_RECORD_PAYMENT",
        "UPDATE_LOAN_RECORD_ONLINE_PAYMENT"
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('audit_trails', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->longText('actions');
            $table->enum('type', self::AUDIT_TYPE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_trails');
    }
};
