<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function index()
    {
        $data = array();
        // Get user info
        $data["userInfo"] = User::where('id', Auth::id())->get()->first();
        $data["otherSettings"] = Settings::where('user_id', Auth::id())->get()->first();
        return Inertia::render('Settings', $data);
    }

    public function updateProfile(Request $request)
    {
         $imageRules = [];
          // if there's a file then create a new validation for image
        if($request->hasFile("user_photo")){
            $imageRules = ["image", "mimes:jpeg,png,jpg,gif,svg", "max:2048"];
        }

        $incomingFields = $request->validate([
            "name" => ["min:2", "max:50", "required"],
            "user_photo" => array_merge(["nullable"], $imageRules),
        ]);

        $previous_image = User::where('id', Auth::id())->value("user_photo");

         // Checking/Saving uploaded photo to photos folder under app/public/photos
        if($request->hasFile("user_photo"))
        {
            // WHEN UPLOADING A PHOTO TO THE SERVER RUN A command php artisan storage:link so it will be accessible to pages
            $incomingFields["user_photo"] = Storage::disk("public")->put("users_images", $request->user_photo);
             // Get previous image and remove it from the folder
            if($previous_image!=""){
                Storage::disk('public')->delete($previous_image);
            }
        }else{
             $incomingFields["user_photo"] = $previous_image;
        }


        $update_user = User::findOrFail(Auth::id());
        $update_user->update($incomingFields);
        return redirect()->intended('settings');

    }

    public function updatePassword(Request $request)
    {
        $incomingFields = $request->validate([
            "password_old" => ["required","min:6","max:50"],
            "password" => ["required","min:6","max:50", "confirmed"],
        ]);
        // Check if old password matches in the database
        $user = Auth::user();
        if(!Hash::check($request->password_old, $user->password)){
            return back()->withErrors(['password_old' => 'Old password is incorrect']);
        }


        $update_user = User::findOrFail(Auth::id());
        $update_user->update(["password" => $incomingFields["password"]]);

        return redirect()->intended('settings');
    }

    public function updateOtherSettings(Request $request)
    {
        $incomingFields = $request->validate([
            "hide_total_dp_flag" => ["required"],
            "hide_total_paid_flag" => ["required"],
            "hide_total_balance_flag" => ["required"],
            "hide_remaining_months_flag" => ["required"],
        ]);
        $incomingFields["user_id"] = Auth::id();
        $update = Settings::updateOrCreate(["user_id" => Auth::id()], $incomingFields);
        return redirect()->intended('settings');
    }
}
