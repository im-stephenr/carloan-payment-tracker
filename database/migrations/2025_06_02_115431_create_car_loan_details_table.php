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
        Schema::create('car_loan_details', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('model');
            $table->string('variant');
            $table->string('color');
            $table->string('type');
            $table->string('car_nickname')->nullable();
            $table->date('purchase_date');
            $table->decimal('paid_down_payment', total:8, places:2);
            $table->decimal('car_srp', total:8, places:2);
            $table->string('dealer');
            $table->string('branch');
            $table->string('agent_name');
            $table->string('agent_num');
            $table->string('payment_deadline_day');
            $table->string('term_years');
            $table->string('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_loan_details');
    }
};
