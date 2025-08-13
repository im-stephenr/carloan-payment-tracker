<?php

namespace App\Http\Controllers;

use App\Models\CarLoanDetail;
use App\Models\PaymentDetail;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $checkExist = CarLoanDetail::where('user_id', Auth::id())->exists();
        if(!$checkExist){
            return redirect()->intended('car-loan-register');
            exit;
        }
        // Car loan Details
        $data['carLoanDetails'] = CarLoanDetail::where('user_id', Auth::id())->get()->first();
        // Other Settings
        $data["otherSettings"] = Settings::where('user_id', Auth::id())->get()->first();
        // Paid down payment
        $data['carLoanDetails']["paid_down_payment"] = number_format($data['carLoanDetails']["paid_down_payment"], 2);

        // remaining balance logic
        $monthly_payment_amount = $data['carLoanDetails']["monthly_payment_amount"]; // monthly payment amount
        $term_years = $data['carLoanDetails']["term_years"];
        $total_months = $term_years*12;
        $data["totalBalance"] = $monthly_payment_amount*$total_months; // total debt/balance

        // Total Months
        $data["totalMonths"] = $total_months;

        $data["paymentsList"] = PaymentDetail::latest()->get();
        return Inertia::render('Home', $data);
    }
}
