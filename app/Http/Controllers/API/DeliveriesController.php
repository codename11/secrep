<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Delivery;
use Illuminate\Support\Facades\Validator;
use App\Complement;
use App\Delivery_details;

class DeliveriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if($request->ajax()){

            if($request->isMethod("get")){
                            
                $deliveries = Delivery::with("operator.work_organization", "enteredBy", "complement.vehicles.type", "complement.vehicles.workOrganization")->get();

                $this->authorize('view', $deliveries->first());
                
                $response = array(
                    "message" => "bravo",
                    "deliveries" => $deliveries,
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
        else{

            $response = array(
                "message" => "Request isn't Ajax.",
            );
            
            return response()->json($response);

        }

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
        
        $validation = Validator::make(
            $request->all(),
            [
                'load_place' => 'required|max:255',
                "unload_place" => 'required|max:255',
                "comment" => 'required|max:255',
                'time_in' => 'required|date_format:H:i',
                'time_out' => 'required|date_format:H:i',
                "vehicles" => 'required|array',
                "vehicles.*" => "required|integer",
                'operator_id' => 'required|numeric',
                'sec_id' => 'required|numeric'
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

                    $delivery = new Delivery;
                    $delivery->load_place = $request->load_place;
                    $delivery->unload_place = $request->unload_place; 
                    $delivery->comment = $request->comment;  
                    $delivery->time_in = $request->time_in; 
                    $delivery->time_out = $request->time_out;

                    $delivery->operator_id = $request->operator_id;
                    $delivery->sec_id = auth()->user()->id; 
                    $this->authorize('create', $delivery);

                    $delivery->save();

                    foreach($request->vehicles as $key => $value){

                        $complement = new Complement;
                        $complement->delivery_id = $delivery->id;
                        $complement->vehicle_id = $value;
                        $complement->sec_id = auth()->user()->id;
                        $complement->save();

                    }

                    foreach($request->delivery_notes as $key => $value){

                        $delivery_details = new Delivery_details;
                        $delivery_details->delivery_id = $delivery->id;
                        $delivery_details->delivery_note = $value;
                        $delivery->sec_id = auth()->user()->id;
                        $delivery_details->save();

                    }
    
                    $response = array(
                        "message" => "bravo",
                        "delivery" => $delivery->with("operator.work_organization", "enteredBy", "complement.vehicles.type", "complement.vehicles.workOrganization")->get(),
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
