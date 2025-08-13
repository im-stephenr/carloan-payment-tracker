<?php

namespace App\Http\Controllers;

use App\Models\CarLoanDetail;
use App\Models\PaymentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CarLoanDetail $carLoanDetail)
    {
        //Check if car loan exist
        $checkExist = $carLoanDetail->where("user_id", Auth::id())->exists();
        if(!$checkExist){
            return redirect()->intended('/');
        }

        $years = array();
        $data["months"] = array(
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December",
        );
        for($years = date('Y'); $years<= date('Y', strtotime("+5 years")); $years++){
            $data["years"][] = $years;
        }
         // Get Monthly Payment amount
        $data["monthlyAmount"] = $carLoanDetail->where("user_id", Auth::id())->value("monthly_payment_amount");

       $data["paymentsList"] = PaymentDetail::latest()->get();
        return Inertia::render('Payments', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, PaymentDetail $paymentDetail)
    {
        $imageRules = [];
        // if there's a file then create a new validation for image
        if($request->hasFile("receipt_image")){
            $imageRules = ["image", "mimes:jpeg,png,jpg,gif,svg", "max:2048"];
        }
        $incomingFields = $request->validate([
            'amount_paid' => ["required"],
            'month_due' => ["required"],
            'year' => ["required"],
            'paid_date' => ["required"],
            'receipt_image' => array_merge(["nullable"], $imageRules),
            'payment_method' => ["required"],
        ]);

        // Fetch CarLoanDetail ID
        $carLoanDetailID = CarLoanDetail::where("user_id", Auth::id())->value("id");
        $incomingFields["car_loan_details_id"] = $carLoanDetailID;

        // Checking/Saving uploaded photo to photos folder under app/public/photos
        if($request->hasFile("receipt_image"))
        {
            // WHEN UPLOADING A PHOTO TO THE SERVER RUN A command php artisan storage:link so it will be accessible to pages
            $incomingFields["receipt_image"] = Storage::disk("public")->put("receipts_images", $request->receipt_image);
        }else{
             $incomingFields["receipt_image"] = "";
        }

        $paymentDetail->create($incomingFields);
        return redirect("payments");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $imageRules = [];
        // if there's a file then create a new validation for image
        if($request->hasFile("receipt_image")){
            $imageRules = ["image", "mimes:jpeg,png,jpg,gif,svg", "max:2048"];
        }
        $incomingFields = $request->validate([
            'id' => ["required"],
            'amount_paid' => ["required"],
            'month_due' => ["required"],
            'year' => ["required"],
            'paid_date' => ["required"],
            'receipt_image' => array_merge(["nullable"], $imageRules), 
            'payment_method' => ["required"],
        ]);

        $previous_image = PaymentDetail::where('id', $id)->value("receipt_image");


        if($request->hasFile("receipt_image")){
             $incomingFields["receipt_image"] = Storage::disk("public")->put("receipts_images", $request->receipt_image);

             // Get previous image and remove it from the folder
            $image = PaymentDetail::where('id', $id)->value("receipt_image");
            if($image!=""){
                Storage::disk('public')->delete($image);
            }
        }else{
            // Check if there's an image already exit in table
            $incomingFields["receipt_image"] = $previous_image;
        }


        $payment = PaymentDetail::findOrFail($id);
        $payment->update($incomingFields);
        return redirect()->intended("payments");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get image
        $image = PaymentDetail::where('id', $id)->value("receipt_image");
        if($image!=""){
            Storage::disk('public')->delete($image);
        }
        $payment = PaymentDetail::findOrFail($id);
        $payment->delete();

        return redirect()->intended('payments');
    }
}
