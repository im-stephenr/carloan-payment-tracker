<?php

namespace App\Http\Controllers;

use App\Models\CarLoanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CarLoanDetailController extends Controller
{
    private $brands = array(
                        "Toyota" => array(
                            "Vios", "Corolla Altis", "Camry", "Wigo", "Rush", "Fortuner", "Hilux", "Innova", "Raize", "Veloz", "Land Cruiser"
                        ),
                        "Honda" => array(
                            "Civic", "CR-V", "HR-V", "City", "Brio", "BR-V", "Jazz", "Accord", "Pilot"
                        ),
                        "Suzuki" => array(
                            "Swift", "Dzire", "Ertiga", "XL7", "Jimny", "Celerio", "S-Presso", "Vitara"
                        ),
                        "Ford" => array(
                            "Ranger", "Everest", "Territory", "Mustang", "Explorer", "F-150"
                        ),
                        "Tesla" => array(
                            "Model 3", "Model Y", "Model S", "Model X", "Cybertruck"
                        ),
                        "Nissan" => array(
                            "Navara", "Terra", "Almera", "Kicks e-POWER", "Patrol Royale", "Leaf", "GT-R"
                        ),
                        "Mitsubishi" => array(
                            "Mirage G4", "Xpander", "Montero Sport", "Strada", "L300", "Outlander PHEV"
                        ),
                        "MG" => array(
                            "ZS", "HS", "5", "GT", "RX5", "ZS EV"
                        ),
                        "Hyundai" => array(
                            "Accent", "Creta", "Tucson", "Santa Fe", "Stargazer", "Palisade", "Elantra", "Kona"
                        ),
                        "Mazda" => array(
                            "Mazda3", "CX-5", "CX-30", "CX-9", "MX-5", "BT-50"
                        ),
                        "Isuzu" => array(
                            "D-Max", "mu-X", "Traviz", "Crosswind"
                        ),
                        "GAC" => array(
                            "GS3", "GS4", "GS8", "GN8", "Empow"
                        ),
                        "Kia" => array(
                            "Picanto", "Seltos", "Carnival", "Stonic", "Sorento", "K2500"
                        ),
                        "Changan" => array(
                            "CS35 Plus", "CS55 Plus", "CS75 Plus", "Alsvin", "UNI-T", "UNI-K"
                        ),
                        "GWM" => array(
                            "Haval H6", "Haval Jolion", "Cannon", "Ora Good Cat"
                        ),
                        "Peugeot" => array(
                            "2008", "3008", "5008", "Traveller Premium"
                        ),
                        "BYD" => array(
                            "Dolphin", "Atto 3", "Han", "Tang"
                        ),
                        "Audi" => array(
                            "A3", "A4", "A6", "Q3", "Q5", "Q7", "E-Tron"
                        ),
                        "BMW" => array(
                            "3 Series", "5 Series", "X1", "X3", "X5", "Z4", "iX"
                        ),
                        "Chery" => array(
                            "Tiggo 2 Pro", "Tiggo 5X", "Tiggo 7 Pro", "Tiggo 8 Pro"
                        ),
                        "Chevorlet" => array(
                            "Colorado", "Trailblazer", "Tracker", "Malibu", "Camaro", "Corvette"
                        ),
                        "Ferrari" => array(
                            "Roma", "Portofino", "F8 Tributo", "SF90 Stradale", "296 GTB"
                        ),
                        "Foton" => array(
                            "Gratour", "Thunder", "Tornado", "Toplander"
                        ),
                        "Geely" => array(
                            "Coolray", "Okavango", "Azkarra", "Emgrand", "GX3 Pro"
                        ),
                        "Jeep" => array(
                            "Wrangler", "Gladiator", "Grand Cherokee", "Renegade", "Compass"
                        ),
                        "Jetour" => array(
                            "X70", "X70 Plus", "Dashing", "Ice Cream EV"
                        ),
                        "Lamborghini" => array(
                            "Huracan", "Aventador", "Urus", "Revuelto"
                        )
                    );
    private $carTypes = array(
                        "Sedan",
                        "Hatchback",
                        "SUV",
                        "Crossover",
                        "Coupe",
                        "Convertible",
                        "Wagon",
                        "Pickup Truck",
                        "Minivan",
                        "Van",
                        "Sports Car",
                        "Roadster",
                        "Luxury Car",
                        "Electric Vehicle"
                    );
    
    public function index(CarLoanDetail $carLoanDetail)
    {
        // Check if user has Car loan data
       $checkExist = $carLoanDetail->where('user_id', Auth::id())->exists();
       if($checkExist){
        return redirect()->intended('/');
       }

        $data['brands'] = $this->brands;
        $data["carTypes"] = $this->carTypes;


       return Inertia::render('CarLoanRegister', $data);
    }

   
    public function create(Request $request, CarLoanDetail $carLoanDetail)
    {
        // Remove commas
        $request->merge([
            'car_srp' => str_replace(',', '', $request->input('car_srp')),
            'paid_down_payment' => str_replace(',', '', $request->input('paid_down_payment')),
            'monthly_payment_amount' => str_replace(',', '', $request->input('monthly_payment_amount'))
        ]);

        $incomingFields = $request->validate([
            'brand' => ['required', 'min:3'],
            'model' => ['required', 'min:3'],
            'variant' => ['required', 'min:1'],
            'color' => ['required', 'min:2'],
            'type' => ['required', 'min:2'],
            'car_nickname' => ['nullable'],
            'purchase_date' => ['required', Rule::date()->format('Y-m-d')],
            'paid_down_payment' => ['required', 'numeric', 'min:0'],
            'monthly_payment_amount' => ['required', 'numeric', 'min:0'],
            'car_srp' => ['required', 'numeric', 'min:0'],
            'dealer' => ['required', 'min:3'],
            'branch' => ['required', 'min:3'],
            'agent_name' => ['required', 'min:3'],
            'agent_num' => ['required', 'integer'],
            'payment_deadline_day' => ['required','integer'],
            'term_years' => ['required', 'integer'],
        ]);
        $incomingFields["user_id"] = Auth::id();

        $carLoanDetail->create($incomingFields);
        return redirect()->intended('/');
    }

 

    /**
     * Display the specified resource.
     */
    public function show(CarLoanDetail $carLoanDetail)
    {
        $checkExist = CarLoanDetail::where('user_id', Auth::id())->exists();
        if(!$checkExist){
            return redirect()->intended('car-loan-register');
            exit;
        }
        $data['brands'] = $this->brands;
        $data["carTypes"] = $this->carTypes;
        $data['carLoanDetails'] = $carLoanDetail->where('user_id', Auth::id())->get()->first();
        $data['carLoanDetails']["paid_down_payment"] = number_format($data['carLoanDetails']["paid_down_payment"],2);
        $data['carLoanDetails']["car_srp"] = number_format($data['carLoanDetails']["car_srp"],2);
        $data['carLoanDetails']["monthly_payment_amount"] = number_format($data['carLoanDetails']["monthly_payment_amount"],2);
        return Inertia::render('CarLoanDetails', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CarLoanDetail $carLoanDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarLoanDetail $carLoanDetail)
    {
        // Remove commas
        $request->merge([
            'car_srp' => str_replace(',', '', $request->input('car_srp')),
            'paid_down_payment' => str_replace(',', '', $request->input('paid_down_payment')),
            'monthly_payment_amount' => str_replace(',', '', $request->input('monthly_payment_amount'))
        ]);

        $incomingFields = $request->validate([
            'id' => ['required'],
            'brand' => ['required', 'min:3'],
            'model' => ['required', 'min:3'],
            'variant' => ['required', 'min:1'],
            'color' => ['required', 'min:2'],
            'type' => ['required', 'min:2'],
            'car_nickname' => ['nullable'],
            'purchase_date' => ['required', Rule::date()->format('Y-m-d')],
            'paid_down_payment' => ['required', 'numeric', 'min:0'],
            'monthly_payment_amount' => ['required', 'numeric', 'min:0'],
            'car_srp' => ['required', 'numeric', 'min:0'],
            'dealer' => ['required', 'min:3'],
            'branch' => ['required', 'min:3'],
            'agent_name' => ['required', 'min:3'],
            'agent_num' => ['required', 'integer'],
            'payment_deadline_day' => ['required','integer'],
            'term_years' => ['required', 'integer'],
        ]);



       $carLoanDetail->where('id', $incomingFields['id'])->update($incomingFields);

       return redirect()->intended('/car-loan-details');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarLoanDetail $carLoanDetail)
    {
        //
    }
}
