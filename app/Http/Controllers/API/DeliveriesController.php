<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Delivery;
use Illuminate\Support\Facades\Validator;
use App\Complement;
use App\Delivery_details;
use App\Vehicle;

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

            if($request->isMethod("post")){
                            
                $deliveries = Delivery::with("operator.work_organization", "enteredBy", "complement.vehicles.type", "complement.vehicles.workOrganization", "deliveryDetails");
                $this->authorize('view', $deliveries->first());
                
                $paginated = $deliveries->paginate(2);

                $response = array(
                    "message" => "bravo",
                    "deliveries" => $paginated,
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
                'time_in' => 'required|date_format:d/m/Y H:i',
                'time_out' => 'required|date_format:d/m/Y H:i',
                "vehicles" => 'required|array',
                "delivery_notes" => 'array',
                "vehicles.*" => "required|integer",
                'operator_id' => 'required|integer',
                'sec_id' => 'required|integer'
            ]
        );
        
        $errors = $validation->errors();

        if($request->ajax()){

            if($validation->fails()){

                $response = array(
                    "message" => "Failed",
                    "errors" => $errors
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

                    $ifToManyTrucks = 0;
                    
                    for($i=0;$i<count($request->vehicles);$i++){
                        
                        $tmp1 = Vehicle::with("type")->find($request->vehicles[$i])->type->id;
                        if($tmp1 == 1){

                            $ifToManyTrucks++;

                        }

                    }
                    
                    if($ifToManyTrucks == 1){

                        for($i=0;$i<count($request->vehicles);$i++){

                            $complement = new Complement;
                            $complement->delivery_id = $delivery->id;
                            $complement->vehicle_id = $request->vehicles[$i];
                            $complement->sec_id = auth()->user()->id;
                            $complement->save();
    
                        }
    
                        for($i=0;$i<count($request->delivery_notes);$i++){
    
                            $delivery_details = new Delivery_details;
                            $delivery_details->delivery_id = $delivery->id;
                            $delivery_details->delivery_note = $request->delivery_notes[$i];
                            $delivery_details->sec_id = $request->sec_id;
                            $delivery_details->save();
    
                        }
        
                        $deliveries = Delivery::with("operator.work_organization", "enteredBy", "complement.vehicles.type", "complement.vehicles.workOrganization", "deliveryDetails");
                        $paginated = $deliveries->paginate(2);
                        $response = array(
                            "message" => "bravo",
                            "deliveries" => $paginated,
                        );
                        
                        return response()->json($response);

                    }
                    else{

                        $response = array(
                            "message" => "Your delivery complement has to many trucks! Delivery entry aborted.",
                        );
                        
                        return response()->json($response);

                    }
    
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
    public function show(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'id' => 'required|nueric'
            ]
        );
        $errors = $validation->errors();

        if($request->ajax()){

            if($validation->fails()){

                $response = array(
                    "message" => "Failed",
                    "errors" => $errors
                );
                return response()->json($response);

            }
            else{

                if($request->isMethod("get")){

                    $delivery = Delivery::with("operator.work_organization", "enteredBy", "complement.vehicles.type", "complement.vehicles.workOrganization")->find($request->id);
                    $this->authorize('view', $delivery);
                    
                    $response = array(
                        "message" => "bravo",
                        "delivery" => $delivery,
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
    public function update(Request $request)
    {
        
        $validation = Validator::make(
            $request->all(),
            [
                "id" => 'required|numeric',
                'load_place' => 'max:255',
                "unload_place" => 'max:255',
                "comment" => 'max:255',
                'time_in' => 'date_format:d/m/Y H:i',
                'time_out' => 'date_format:d/m/Y H:i',
                "vehicles" => 'array',
                "vehicles.*" => "integer",
                "delivery_notes" => 'array',
                "delivery_notes.*" => "integer",
                'operator_id' => 'numeric',
                'sec_id' => 'numeric'
            ]
        );
        
        $errors = $validation->errors();

        if($request->ajax()){

            if($validation->fails()){

                $response = array(
                    "message" => "Failed",
                    "errors" => $errors
    
                );
                return response()->json($response);

            }
            else{

                if($request->isMethod("patch")){

                    $delivery = Delivery::find($request->id);
                    $delivery->load_place = $request->load_place ? $request->load_place : $delivery->load_place;
                    $delivery->unload_place = $request->unload_place ? $request->unload_place : $delivery->unload_place; 
                    $delivery->comment = $request->comment ? $request->comment : $delivery->comment;  
                    $delivery->time_in = $request->time_in ? $request->time_in : $delivery->time_in; 
                    $delivery->time_out = $request->time_out ? $request->time_out : $delivery->time_out;

                    $delivery->operator_id = $request->operator_id ? $request->operator_id : $delivery->operator_id;
                    $delivery->sec_id = $request->sec_id; 
                    $this->authorize('update', $delivery);

                    $delivery->save();

                    $ifToManyTrucks = 0;

                    if(is_iterable($request->vehicles)){
                        for($i=0;$i<count($request->vehicles);$i++){

                            $tmp1 = Vehicle::with("type")->find($request->vehicles[$i])->type->id;
                            if($tmp1 == 1){

                                $ifToManyTrucks++;

                            }

                        }
                    }
                    
                    if($ifToManyTrucks <= 1){

                        if(is_iterable($request->vehicles)){
                            for($i=0;$i<count($request->vehicles);$i++){

                                $complement = Complement::where("vehicle_id", "=", $request->vehicles[$i])->where("delivery_id", "=", $delivery->id)->first();
                                
                                if($complement){

                                    $complement->delivery_id = $delivery->id ? $delivery->id : $complement->delivery_id;
                                    $complement->vehicle_id = $request->vehicles[$i] ? $request->vehicles[$i] : $complement->vehicle_id;
                                    $complement->sec_id = $request->sec_id;
                                    $complement->save();

                                }
                                else{

                                    $response = array(
                                        "message" => "There no such complement.",
                                    );
                                    
                                    return response()->json($response);

                                }
        
                            }
                        }

                        if(is_iterable($request->delivery_notes)){
                            for($i=0;$i<count($request->delivery_notes);$i++){
        
                                $delivery_details = Delivery_details::where("delivery_id", "=", $delivery->id)->first();

                                if($delivery_details){

                                    $delivery_details->delivery_id = $delivery->id ? $delivery->id : $delivery_details->delivery_id;
                                    $delivery_details->delivery_note = $request->delivery_notes[$i] ? $request->delivery_notes[$i] : $delivery_details->delivery_note;
                                    $delivery->sec_id = $request->sec_id;
                                    $delivery_details->save();

                                }
                                else{

                                    $response = array(
                                        "message" => "There no such delivery_details.",
                                    );
                                    
                                    return response()->json($response);

                                }
        
                            }
                        }
                        $response = array(
                            "delivery" => $delivery->with("operator.work_organization", "enteredBy", "complement.vehicles.type", "complement.vehicles.workOrganization", "deliveryDetails")->find($delivery->id)
                        );
                        
                        return response()->json($response);

                    }
                    else{

                        $response = array(
                            "message" => "Your delivery complement has to many trucks! Delivery entry aborted.",
                        );
                        
                        return response()->json($response);

                    }
    
                }
                else{

                    $response = array(
                        "message" => "Method isn't PATCH.",
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        
        $validation = Validator::make(
            $request->all(),
            [
                "id" => "required|numeric",
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

                if($request->isMethod("delete")){

                    $delivery = Delivery::with("operator.work_organization", "enteredBy", "complement.vehicles.type", "complement.vehicles.workOrganization")->find($request->id); 
                    $this->authorize('delete', $delivery);
                    $delivery->delete();

                    $deliveries = Delivery::with("operator.work_organization", "enteredBy", "complement.vehicles.type", "complement.vehicles.workOrganization");
                    $paginated = $deliveries->paginate(2);

                    $response = array(
                        "message" => "bravo",
                        "deliveries" => $paginated,
                    );
                    
                    return response()->json($response);
    
                }
                else{

                    $response = array(
                        "message" => "Method isn't DELETE.",
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

}
