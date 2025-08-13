<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    //
    protected $fillable = [
        'hide_total_dp_flag',
        'hide_total_paid_flag',
        'hide_total_balance_flag',
        'hide_remaining_months_flag',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
