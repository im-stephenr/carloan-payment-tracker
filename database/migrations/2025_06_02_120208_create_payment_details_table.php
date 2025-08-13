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
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount_paid', total:8, places:2);
            $table->date('paid_date');
            $table->longText('receipt_image');
            $table->string('month_due');
            $table->integer('year');
            $table->string('payment_method');
            $table->foreignId('car_loan_details_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_details');
    }
};
