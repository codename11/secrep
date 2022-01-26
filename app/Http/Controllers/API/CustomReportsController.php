<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\DateHelper;
use App\Vehicle;
use App\User;
use App\Rules\Vehicles;
use App\Delivery;
use App\Employee;

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

        //Only admins should be able to access these reports.
        if(auth()->user()->role->name != "admin"){
            abort(403);
        }

        $response = array(
            "ModelsWithRelationships" => [
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
            ],
        );
        
        return response()->json($response);

    }

    public function vehicles(Request $request)
    {
        if(auth()->user()->role->name != "admin"){
            abort(403);
        }

        $validation = Validator::make(
            $request->all(),
            [
                'start_date' => 'date_format:d/m/Y',
                "end_date" => 'date_format:d/m/Y',
                "vehicle_id" => "numeric|gt:0",
                "vehicle" => "array"
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

                    $d1 = $request->start_date ? new DateHelper($request->start_date) : null;
                    $d2 = $request->end_date ? new DateHelper($request->end_date) : null;

                    $start_date = $d1 != null ? $d1->checkIfDate() : null;
                    $end_date = $d2 != null ? $d2->checkIfDate() : null;

                    $dates = new \stdClass();
                    $dates->start_date = $start_date;
                    $dates->end_date = $end_date;

                    /*$myModels = (new CustomReportsController())->getModels();*/

                    if($request->vehicle_id && Vehicle::find($request->vehicle_id)){
                        
                        $vehicles = Vehicle::with("complements.deliveries.employees", ...$request->vehicle)
                        ->when($dates->start_date, function ($query, $date) {
                            $query->where('updated_at', '>=', $date);
                        })
                        ->when($dates->end_date, function ($query, $date) {
                            $query->where('updated_at', '<=', $date);
                        })->find($request->vehicle_id);

                    }
                    else{

                        $vehicles = Vehicle::with("complements.deliveries.employees", ...$request->vehicle)
                        ->when($dates->start_date, function ($query, $date) {
                            $query->where('updated_at', '>=', $date);
                        })
                        ->when($dates->end_date, function ($query, $date) {
                            $query->where('updated_at', '<=', $date);
                        })->get();

                    }
                        
                    $response = array(
                        "message" => "bravo",
                        "vehicles" => $vehicles
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
    public function deliveries(Request $request)
    {

        if(auth()->user()->role->name != "admin"){
            abort(403);
        }

        $validation = Validator::make(
            $request->all(),
            [
                'start_date' => 'date_format:d/m/Y',
                "end_date" => 'date_format:d/m/Y',
                "delivery_id" => "numeric|gt:0",
                "delivery" => "array"
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

                    $d1 = $request->start_date ? new DateHelper($request->start_date) : null;
                    $d2 = $request->end_date ? new DateHelper($request->end_date) : null;

                    $start_date = $d1 != null ? $d1->checkIfDate() : null;
                    $end_date = $d2 != null ? $d2->checkIfDate() : null;

                    $dates = new \stdClass();
                    $dates->start_date = $start_date;
                    $dates->end_date = $end_date;

                    if($request->delivery_id && Delivery::find($request->delivery_id)){

                        //Izgleda da se ovde ne dupliraju podaci iz relationship-a.
                        $deliveries = Delivery::with("operator.work_organization", "operator.enteredBy", ...$request->delivery)
                        ->when($dates->start_date, function ($query, $date) {
                            $query->where('updated_at', '>=', $date);
                        })
                        ->when($dates->end_date, function ($query, $date) {
                            $query->where('updated_at', '<=', $date);
                        })->find($request->delivery_id);

                        $response = array(
                            "message" => "Bravo",
                            "deliveries" => $deliveries
                
                        );
                        return response()->json($response);

                    }
                    else{

                        //Izgleda da se ovde ne dupliraju podaci iz relationship-a.
                        $deliveries = Delivery::with("operator.work_organization", "operator.enteredBy", ...$request->delivery)
                        ->when($dates->start_date, function ($query, $date) {
                            $query->where('updated_at', '>=', $date);
                        })
                        ->when($dates->end_date, function ($query, $date) {
                            $query->where('updated_at', '<=', $date);
                        })->get();

                        $response = array(
                            "message" => "Bravo",
                            "deliveries" => $deliveries
                
                        );
                        return response()->json($response);

                    }
    
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

    public function employees(Request $request)
    {

        if(auth()->user()->role->name != "admin"){
            abort(403);
        }

        $validation = Validator::make(
            $request->all(),
            [
                'start_date' => 'date_format:d/m/Y',
                "end_date" => 'date_format:d/m/Y',
                "employee_id" => "numeric|gt:0",
                "employee" => "array"
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

                    $d1 = $request->start_date ? new DateHelper($request->start_date) : null;
                    $d2 = $request->end_date ? new DateHelper($request->end_date) : null;

                    $start_date = $d1 != null ? $d1->checkIfDate() : null;
                    $end_date = $d2 != null ? $d2->checkIfDate() : null;

                    $dates = new \stdClass();
                    $dates->start_date = $start_date;
                    $dates->end_date = $end_date;

                    if($request->employee_id && Employee::find($request->employee_id)){

                        //Izgleda da se ovde ne dupliraju podaci iz relationship-a.
                        $employees = Employee::with(...$request->employee)
                        ->when($dates->start_date, function ($query, $date) {
                            $query->where('updated_at', '>=', $date);
                        })
                        ->when($dates->end_date, function ($query, $date) {
                            $query->where('updated_at', '<=', $date);
                        })->find($request->employee_id);

                        $response = array(
                            "message" => "Bravo",
                            "employees" => $employees
                
                        );
                        return response()->json($response);

                    }
                    else{

                        //Izgleda da se ovde ne dupliraju podaci iz relationship-a.
                        $employees = Employee::with(...$request->employee)
                        ->when($dates->start_date, function ($query, $date) {
                            $query->where('updated_at', '>=', $date);
                        })
                        ->when($dates->end_date, function ($query, $date) {
                            $query->where('updated_at', '<=', $date);
                        })->get();

                        $response = array(
                            "message" => "Bravo",
                            "employees" => $employees
                
                        );
                        return response()->json($response);

                    }
    
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

    public function users(Request $request)
    {

        if(auth()->user()->role->name != "admin"){
            abort(403);
        }

        $validation = Validator::make(
            $request->all(),
            [
                'start_date' => 'date_format:d/m/Y',
                "end_date" => 'date_format:d/m/Y',
                "user_id" => "numeric|gt:0",
                "user" => "array"
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

                    $d1 = $request->start_date ? new DateHelper($request->start_date) : null;
                    $d2 = $request->end_date ? new DateHelper($request->end_date) : null;

                    $start_date = $d1 != null ? $d1->checkIfDate() : null;
                    $end_date = $d2 != null ? $d2->checkIfDate() : null;

                    $dates = new \stdClass();
                    $dates->start_date = $start_date;
                    $dates->end_date = $end_date;

                    if($request->user_id && User::find($request->user_id)){

                        //Izgleda da se ovde ne dupliraju podaci iz relationship-a.
                        $employees = Employee::with("complement.deliveries", ...$request->user)
                        ->when($dates->start_date, function ($query, $date) {
                            $query->where('updated_at', '>=', $date);
                        })
                        ->when($dates->end_date, function ($query, $date) {
                            $query->where('updated_at', '<=', $date);
                        })->find($request->user_id);

                        $response = array(
                            "message" => "Bravo",
                            "users" => $users
                
                        );
                        return response()->json($response);

                    }
                    else{

                        //Izgleda da se ovde ne dupliraju podaci iz relationship-a.
                        $users = User::with("complement.deliveries", ...$request->user)
                        ->when($dates->start_date, function ($query, $date) {
                            $query->where('updated_at', '>=', $date);
                        })
                        ->when($dates->end_date, function ($query, $date) {
                            $query->where('updated_at', '<=', $date);
                        })->get();

                        $response = array(
                            "message" => "Bravo",
                            "users" => $users
                
                        );
                        return response()->json($response);

                    }
    
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
