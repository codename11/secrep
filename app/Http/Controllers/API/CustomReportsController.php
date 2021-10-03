<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\DateHelper;
use App\Vehicle;
use App\User;
use App\Rules\Vehicles;
use App\Rules\isObject;
use App\Rules\Models;

class CustomReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getModels(){

        return [
            "Complement" => [
                "deliveries", 
                "user", 
                "type", 
                "workOrganization"
            ], 
            "Delivery_details" => [
                "delivery",
                "enteredBy",
            ], 
            "Delivery" => [
                "operator",
                "enteredBy",
                "complement"
            ], 
            "Employee" => [
                "work_organization",
                "enteredBy",
                "deliveries"
            ], 
            "Role" => [
                "users"
            ], 
            "Special_Permission" => [
                "user",
                "vehicles",
                "employees"
            ], 
            "User" => [
                "role",
                "vehicles",
                "deliveries",
                "complement",
                "delivery_details",
                "special_permissions",
                "employees"
            ], 
            "Vehicle" => [
                "deliveries",
                "user",
                "type",
                "workOrganization"
            ], 
            "VehiclePivot" => [
                "vehicles"
            ], 
            "WorkOrganization" => [
                "vehicles",
                "employees",
                "user"
            ]
        ];

    }
    public function vehicles(Request $request)
    {
        
        $validation = Validator::make(
            $request->all(),
            [
                'start_date' => 'required|date_format:d/m/Y',
                "end_date" => 'required|date_format:d/m/Y',
                "models" => "array",
                "models.*" => "array",
                "optional_parameters" => "array",
                "optional_parameters.*" => "array",
                "optional_parameters.*.*" => "string"
            ]
        );
        $errors = $validation->errors();
        
        if($request->ajax()){

            if($validation->fails()){

                $response = array(
                    "message" => "Failed",
                    "errors" => $errors,
    
                );
                return response()->json($response);

            }
            else{

                if($request->isMethod("get")){

                    $d1 = new DateHelper($request->start_date);
                    $d2 = new DateHelper($request->end_date);

                    $start_date = $d1->checkIfDate();
                    $end_date = $d2->checkIfDate();

                    $dates = new \stdClass();
                    $dates->start_date = $start_date;
                    $dates->end_date = $end_date;

                    $models = $request->models;
                    $myModels = (new CustomReportsController())->getModels();

                    $keys = [];
                    $values = [];
                    foreach ($models[0]["Vehicle"] as $key => $value) {
                        array_push($keys, $key);
                        array_push($values, $value);
                    }
                    //Vehicle::whereBetween("updated_at", [$dates->start_date, $dates->end_date])->with("deliveries", "user", "type", "workOrganization", 1, 1, 1, 1)->get(),
                    $response = array(
                        "message" => "bravo",
                        "vehicles" => Vehicle::whereBetween("updated_at", [$dates->start_date, $dates->end_date])->with("deliveries", "user", "type", "workOrganization")->get(),
                        //"test" => User::find("1")->vehicles
                        "keys" => $keys,
                        "values" => $values
                    );
                    
                    return response()->json($response);

                }
                else{

                    $response = array(
                        "message" => "Method isn't GET.",
                    );
                    
                    return response()->json($response);

                }

            }

        }
        else{

            $response = array(
                "message" => "Request isn't Ajax.",
            );
            
            return response()->json($response);

        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
