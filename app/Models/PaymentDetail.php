<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    //
    protected $fillable = [
        'amount_paid',
        'paid_date',
        'receipt_image',
        'month_due',
        'year',
        'payment_method',
        'car_loan_details_id',
    ];

}
