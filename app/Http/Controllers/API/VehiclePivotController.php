<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\VehiclePivot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehiclePivotController extends Controller
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
                
                $types = VehiclePivot::all();
                $this->authorize('view', $types->first());
                
                $response = array(
                    "message" => "bravo",
                    "types" => $types
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
    public function create(Request $request)
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
                'name' => 'required|max:255',
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

                    $vehiclePivot = new VehiclePivot;
                    $vehiclePivot->name = $request->name;
                    $this->authorize('create', $vehiclePivot);
                    $vehiclePivot->save();
    
                    $response = array(
                        "message" => "bravo",
                        "vehiclePivot" => $vehiclePivot->all(),
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
     * @param  \App\VehiclePivot  $vehiclePivot
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        
        $validation = Validator::make(
            $request->all(),
            [
                'id' => 'required|numeric',
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

                    $vehiclePivot = VehiclePivot::find($request->id);
                    $this->authorize('view', $vehiclePivot);

                    $response = array(
                        "message" => "bravo",
                        "vehiclePivot" => $vehiclePivot,
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
     * @param  \App\VehiclePivot  $vehiclePivot
     * @return \Illuminate\Http\Response
     */
    public function edit(VehiclePivot $vehiclePivot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VehiclePivot  $vehiclePivot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        $validation = Validator::make(
            $request->all(),
            [
                "id" => "required|numeric",
                'name' => 'max:255'
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

                    $vehiclePivot = VehiclePivot::find($request->id);
                    $vehiclePivot->name = $request->name ? $request->name : $vehiclePivot->name; 
                    $this->authorize('update', $vehiclePivot);
                    $vehiclePivot->save();
    
                    $response = array(
                        "message" => "bravo",
                        "vehiclePivot" => $vehiclePivot,
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
     * @param  \App\VehiclePivot  $vehiclePivot
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

                    $vehiclePivot = VehiclePivot::find($request->id); 
                    $this->authorize('delete', $vehiclePivot);
                    $vehiclePivot->delete();

                    $response = array(
                        "message" => "bravo",
                        "vehiclePivot" => $vehiclePivot,
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
