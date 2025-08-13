<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarLoanDetail extends Model
{
    //
    protected $fillable = [
        'brand',
        'model',
        'variant',
        'color',
        'type',
        'car_nickname',
        'purchase_date',
        'paid_down_payment',
        'monthly_payment_amount',
        'car_srp',
        'dealer',
        'branch',
        'agent_name',
        'agent_num',
        'payment_deadline_day',
        'term_years',
        'user_id'
    ];

    protected $appends = ['created_at_formatted','updated_at_formatted'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at?->format("Y-m-d H:i");
    }
    
    public function getUpdatedAtFormattedAttribute()
    {
        return $this->updated_at?->format("Y-m-d H:i");
    }

  
}
