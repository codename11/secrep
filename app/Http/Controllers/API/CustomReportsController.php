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
                'start_date' => 'date_format:d/m/Y H:i',
                "end_date" => 'date_format:d/m/Y H:i',
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

                if($request->isMethod("post")){
                    
                    $d1 = $request->start_date ? new DateHelper($request->start_date) : null;
                    $d2 = $request->end_date ? new DateHelper($request->end_date) : null;

                    $start_date = $d1 != null ? $d1->checkIfDate() : null;
                    $end_date = $d2 != null ? $d2->checkIfDate() : null;

                    $dates = new \stdClass();
                    $dates->start_date = $start_date;
                    $dates->end_date = $end_date;

                    $str1 = "";
                    $arr1 = $request->vehicle ? $request->vehicle : [];
                    $individualOrAll = false;
                    if($request->vehicle_id && Vehicle::find($request->vehicle_id)){
                        
                        if(count($arr1)>0){

                            if(in_array("complements", $arr1)){

                                $str1 = "complements.deliveries.employees";
                                unset($arr1["complements"]);
    
                                $vehicles = Vehicle::with($str1, ...$arr1)->when($dates->start_date, function ($query, $date) {
                                    $query->where('updated_at', '>=', $date);
                                })
                                ->when($dates->end_date, function ($query, $date) {
                                    $query->where('updated_at', '<=', $date);
                                })->find($request->vehicle_id)->paginate(4);
                                
                            }
                            else{

                                $vehicles = Vehicle::with(...$arr1)->when($dates->start_date, function ($query, $date) {
                                    $query->where('updated_at', '>=', $date);
                                })
                                ->when($dates->end_date, function ($query, $date) {
                                    $query->where('updated_at', '<=', $date);
                                })->find($request->vehicle_id)->paginate(4);
                                
                            }

                        }
                        
                        if(count($arr1)===0){

                            $vehicles = Vehicle::when($dates->start_date, function ($query, $date) {
                                $query->where('updated_at', '>=', $date);
                            })
                            ->when($dates->end_date, function ($query, $date) {
                                $query->where('updated_at', '<=', $date);
                            })->find($request->vehicle_id)->paginate(4);

                        }

                    }
                    else{
                        
                        if(count($arr1)>0){

                            if(in_array("complements", $arr1)){

                                $str1 = "complements.deliveries.employees";
                                unset($arr1["complements"]);
    
                                $vehicles = Vehicle::with($str1, ...$arr1)->when($dates->start_date, function ($query, $date) {
                                    $query->where('updated_at', '>=', $date);
                                })
                                ->when($dates->end_date, function ($query, $date) {
                                    $query->where('updated_at', '<=', $date);
                                })->paginate(4);

                            }
                            else{

                                $vehicles = Vehicle::with(...$arr1)->when($dates->start_date, function ($query, $date) {
                                    $query->where('updated_at', '>=', $date);
                                })
                                ->when($dates->end_date, function ($query, $date) {
                                    $query->where('updated_at', '<=', $date);
                                })->paginate(4);

                            }

                        }
                        
                        if(count($arr1)===0){

                            $vehicles = Vehicle::when($dates->start_date, function ($query, $date) {
                                $query->where('updated_at', '>=', $date);
                            })
                            ->when($dates->end_date, function ($query, $date) {
                                $query->where('updated_at', '<=', $date);
                            })->paginate(4);

                        }

                    }

                    $response = array(
                        "vehicles" => $vehicles
                    );
                    
                    return response()->json($response);

                }
                else{

                    $response = array(
                        "message" => "Method isn't POST.",
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
                'start_date' => 'date_format:d/m/Y H:i',
                "end_date" => 'date_format:d/m/Y H:i',
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

                if($request->isMethod("post")){

                    $d1 = $request->start_date ? new DateHelper($request->start_date) : null;
                    $d2 = $request->end_date ? new DateHelper($request->end_date) : null;

                    $start_date = $d1 != null ? $d1->checkIfDate() : null;
                    $end_date = $d2 != null ? $d2->checkIfDate() : null;

                    $dates = new \stdClass();
                    $dates->start_date = $start_date;
                    $dates->end_date = $end_date;

                    $str1 = "";
                    $str2 = "";
                    $arr1 = $request->delivery ? $request->delivery : [];
                    if($request->delivery_id && Delivery::find($request->delivery_id)){
                        
                        if(count($arr1)>0){

                            if(in_array("operator", $arr1)){

                                $str1 = "operator.work_organization";
                                $str2 = "operator.enteredBy";
                                unset($arr1["operator"]);
    
                                $deliveries = Delivery::with($str1, $str2, ...$arr1)
                                ->when($dates->start_date, function ($query, $date) {
                                    $query->where('updated_at', '>=', $date);
                                })
                                ->when($dates->end_date, function ($query, $date) {
                                    $query->where('updated_at', '<=', $date);
                                })->find($request->delivery_id);
    
                            }
                            else{

                                $deliveries = Delivery::with(...$arr1)
                                ->when($dates->start_date, function ($query, $date) {
                                    $query->where('updated_at', '>=', $date);
                                })
                                ->when($dates->end_date, function ($query, $date) {
                                    $query->where('updated_at', '<=', $date);
                                })->find($request->delivery_id);

                            }

                        }

                        if(count($arr1)===0){

                            $deliveries = Delivery::when($dates->start_date, function ($query, $date) {
                                $query->where('updated_at', '>=', $date);
                            })
                            ->when($dates->end_date, function ($query, $date) {
                                $query->where('updated_at', '<=', $date);
                            })->find($request->delivery_id);

                        }

                    }
                    else{

                        if(count($arr1)>0){

                            if(in_array("operator", $arr1)){

                                $str1 = "operator.work_organization";
                                $str2 = "operator.enteredBy";
                                unset($arr1["operator"]);
    
                                $deliveries = Delivery::with($str1, $str2, ...$arr1)
                                ->when($dates->start_date, function ($query, $date) {
                                    $query->where('updated_at', '>=', $date);
                                })
                                ->when($dates->end_date, function ($query, $date) {
                                    $query->where('updated_at', '<=', $date);
                                })->get();
    
                            }
                            else{

                                $deliveries = Delivery::with(...$arr1)
                                ->when($dates->start_date, function ($query, $date) {
                                    $query->where('updated_at', '>=', $date);
                                })
                                ->when($dates->end_date, function ($query, $date) {
                                    $query->where('updated_at', '<=', $date);
                                })->get();

                            }

                        }

                        if(count($arr1)===0){

                            $deliveries = Delivery::when($dates->start_date, function ($query, $date) {
                                $query->where('updated_at', '>=', $date);
                            })
                            ->when($dates->end_date, function ($query, $date) {
                                $query->where('updated_at', '<=', $date);
                            })->get();

                        }

                    }

                    $response = array(
                        "deliveries" => $deliveries
            
                    );
                    return response()->json($response);
    
                }
                else{
    
                    $response = array(
                        "message" => "Method isn't POST.",
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
                'start_date' => 'date_format:d/m/Y H:i',
                "end_date" => 'date_format:d/m/Y H:i',
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

                if($request->isMethod("post")){

                    $d1 = $request->start_date ? new DateHelper($request->start_date) : null;
                    $d2 = $request->end_date ? new DateHelper($request->end_date) : null;

                    $start_date = $d1 != null ? $d1->checkIfDate() : null;
                    $end_date = $d2 != null ? $d2->checkIfDate() : null;

                    $dates = new \stdClass();
                    $dates->start_date = $start_date;
                    $dates->end_date = $end_date;

                    $arr1 = $request->employee ? $request->employee : [];
                    if($request->employee_id && Employee::find($request->employee_id)){

                        if(count($arr1)>0){

                            $employees = Employee::with(...$arr1)
                            ->when($dates->start_date, function ($query, $date) {
                                $query->where('updated_at', '>=', $date);
                            })
                            ->when($dates->end_date, function ($query, $date) {
                                $query->where('updated_at', '<=', $date);
                            })->find($request->employee_id);

                        }
                        
                        if(count($arr1)===0){

                            $employees = Employee::when($dates->start_date, function ($query, $date) {
                                $query->where('updated_at', '>=', $date);
                            })
                            ->when($dates->end_date, function ($query, $date) {
                                $query->where('updated_at', '<=', $date);
                            })->find($request->employee_id);

                        }

                    }
                    else{

                        if(count($arr1)>0){

                            $employees = Employee::with(...$arr1)
                            ->when($dates->start_date, function ($query, $date) {
                                $query->where('updated_at', '>=', $date);
                            })
                            ->when($dates->end_date, function ($query, $date) {
                                $query->where('updated_at', '<=', $date);
                            })->get();

                        }
                        
                        if(count($arr1)===0){

                            $employees = Employee::when($dates->start_date, function ($query, $date) {
                                $query->where('updated_at', '>=', $date);
                            })
                            ->when($dates->end_date, function ($query, $date) {
                                $query->where('updated_at', '<=', $date);
                            })->get();

                        }

                    }

                    $response = array(
                        "employees" => $employees
            
                    );
                    return response()->json($response);
    
                }
                else{
    
                    $response = array(
                        "message" => "Method isn't POST.",
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
                'start_date' => 'date_format:d/m/Y H:i',
                "end_date" => 'date_format:d/m/Y H:i',
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

                if($request->isMethod("post")){

                    $d1 = $request->start_date ? new DateHelper($request->start_date) : null;
                    $d2 = $request->end_date ? new DateHelper($request->end_date) : null;

                    $start_date = $d1 != null ? $d1->checkIfDate() : null;
                    $end_date = $d2 != null ? $d2->checkIfDate() : null;

                    $dates = new \stdClass();
                    $dates->start_date = $start_date;
                    $dates->end_date = $end_date;

                    $str1 = "";
                    $arr1 = $request->user ? $request->user : [];
                    if($request->user_id && User::find($request->user_id)){

                        if(count($arr1)>0){

                            if(in_array("complement", $arr1)){

                                $str1 = "complement.deliveries";
                                unset($arr1["complement"]);

                                $users = User::with($str1, ...$arr1)
                                ->when($dates->start_date, function ($query, $date) {
                                    $query->where('updated_at', '>=', $date);
                                })
                                ->when($dates->end_date, function ($query, $date) {
                                    $query->where('updated_at', '<=', $date);
                                })->find($request->user_id);

                            }
                            else{

                                $users = User::with(...$arr1)
                                ->when($dates->start_date, function ($query, $date) {
                                    $query->where('updated_at', '>=', $date);
                                })
                                ->when($dates->end_date, function ($query, $date) {
                                    $query->where('updated_at', '<=', $date);
                                })->find($request->user_id);

                            }

                        }

                        if(count($arr1)===0){

                            $users = User::when($dates->start_date, function ($query, $date) {
                                $query->where('updated_at', '>=', $date);
                            })
                            ->when($dates->end_date, function ($query, $date) {
                                $query->where('updated_at', '<=', $date);
                            })->find($request->user_id);

                        }

                    }
                    else{

                        if(count($arr1)>0){

                            $str1 = "complement.deliveries";
                            unset($arr1["complement"]);

                            if(in_array("complement", $arr1)){

                                $users = User::with($str1, ...$arr1)
                                ->when($dates->start_date, function ($query, $date) {
                                    $query->where('updated_at', '>=', $date);
                                })
                                ->when($dates->end_date, function ($query, $date) {
                                    $query->where('updated_at', '<=', $date);
                                })->get();

                            }
                            else{

                                $users = User::with(...$arr1)
                                ->when($dates->start_date, function ($query, $date) {
                                    $query->where('updated_at', '>=', $date);
                                })
                                ->when($dates->end_date, function ($query, $date) {
                                    $query->where('updated_at', '<=', $date);
                                })->get();

                            }

                        }

                        if(count($arr1)===0){

                            $users = User::when($dates->start_date, function ($query, $date) {
                                $query->where('updated_at', '>=', $date);
                            })
                            ->when($dates->end_date, function ($query, $date) {
                                $query->where('updated_at', '<=', $date);
                            })->get();

                        }

                    }

                    $response = array(
                        "users" => $users
                    );
                    return response()->json($response);
    
                }
                else{
    
                    $response = array(
                        "message" => "Method isn't POST.",
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
