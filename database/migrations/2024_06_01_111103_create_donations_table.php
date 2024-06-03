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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('donation_code')->unique();
            $table->string('donor_name')->nullable();
            $table->string('donor_email')->nullable();
            $table->string('donation_type')->nullable();
            $table->decimal('amount', 20, 2)->default(0);
            $table->string('note')->nullable();
            $table->string('status')->default(\App\Enums\DonationStatusEnum::PENDING->value);
            $table->string('snap_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
