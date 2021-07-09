<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Vehicle;
use Illuminate\Support\Facades\Validator;

class VehiclesController extends Controller
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

                //$vehicles = Vehicle::with("deliveries")->get();
                $vehicles = Vehicle::all();
                $this->authorize('view', $vehicles->first());
                
                $response = array(
                    "message" => "bravo",
                    "vehicles" => $vehicles,
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
                'registration' => 'required|max:255',
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

                    /*
                    if(auth()->user()->role_id == 1){



                    }
                    */
                    $vehicle = new Vehicle;
                    $vehicle->registration = $request->registration;
                    $vehicle->sec_id = auth()->user()->id;     
                    $this->authorize('create', $vehicle);
                    $vehicle->save();
    
                    $response = array(
                        "message" => "bravo",
                        "request" => $request->all(),
                        "vehicle" => $vehicle,
                        "user" => auth()->user()
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
    public function show(Request $request)
    {
        
        if($request->ajax()){

            if($request->isMethod("get")){

                //$vehicle = Vehicle::with("deliveries")->find($request->id);
                $vehicle = Vehicle::find($request->id);
                $response = array(
                    "message" => "bravo",
                    "vehicle" => $vehicle,
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
                "id" => "required|numeric",
                'registration' => 'required|max:255',
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

                if($request->isMethod("patch")){

                    /*
                    if(auth()->user()->role_id == 1){



                    }
                    */
                    $vehicle = Vehicle::find($request->id);
                    $vehicle->registration = $request->registration;    
                    $this->authorize('update', $vehicle);
                    $vehicle->save();
    
                    $response = array(
                        "message" => "bravo",
                        "request" => $request->all(),
                        "vehicle" => $vehicle,
                        "user" => auth()->user()
                    );
                    
                    return response()->json($response);
    
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

                    $vehicle = Vehicle::find($request->id); 
                    $this->authorize('update', $vehicle);
                    $vehicle->delete();

                    $response = array(
                        "message" => "bravo",
                        "request" => $request->all(),
                        "vehicle" => $vehicle,
                        "user" => auth()->user()
                    );
                    
                    return response()->json($response);
    
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

}
