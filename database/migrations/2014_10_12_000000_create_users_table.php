<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected const USER_SUFFIX = ['JR.', 'SR.', 'II', 'III', 'IV', 'V'];
    protected const USER_GENDER = ['MALE', 'FEMALE'];
    protected const USER_ROLE   = ['SUPERADMIN', 'ADMINISTRATOR', 'COLLECTOR', 'MEMBER'];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('lname');
            $table->enum('suffix', self::USER_SUFFIX)->nullable();
            $table->enum('gender', self::USER_GENDER);
            $table->enum('role', self::USER_ROLE);
            $table->date('birthday');
            $table->string('avatar', 255)->default('default-avatar.png');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
