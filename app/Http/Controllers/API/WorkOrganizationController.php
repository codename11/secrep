<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\WorkOrganization;
use App\VehiclePivot;
use Illuminate\Support\Facades\Validator;

class WorkOrganizationController extends Controller
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
                            
                $workOrganizations = WorkOrganization::with("vehicles.type")->get();

                $this->authorize('view', $workOrganizations->first());
                
                $response = array(
                    "message" => "bravo",
                    "workOrganizations" => $workOrganizations,
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

                    $workOrganization = new WorkOrganization;
                    $workOrganization->name = $request->name;
                    $workOrganization->sec_id = auth()->user()->id; 
                    $this->authorize('create', $workOrganization);
                    $workOrganization->save();
    
                    $response = array(
                        "message" => "bravo",
                        "workOrganization" => $workOrganization->with("vehicles.type")->get(),
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

                $workOrganization = WorkOrganization::with("vehicles.type")->find($request->id);
                $this->authorize('view', $workOrganization);
                $response = array(
                    "message" => "bravo",
                    "workOrganization" => $workOrganization,
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
                'name' => 'required|max:255',
                "sec_id" => "required|numeric"
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

                    $workOrganization = WorkOrganization::with("vehicles.type")->find($request->id);
                    $workOrganization->name = $request->name ? $request->name : $workOrganization->name; 
                    $workOrganization->sec_id = $request->sec_id ? $request->sec_id : $workOrganization->sec_id;
                    $this->authorize('update', $workOrganization);
                    $workOrganization->save();
    
                    $response = array(
                        "message" => "bravo",
                        "workOrganization" => $workOrganization,
                        "workOrganizations" => WorkOrganization::with("vehicles.type")->get()
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

                    $workOrganization = WorkOrganization::with("vehicles.type")->find($request->id); 
                    $this->authorize('delete', $workOrganization);
                    $workOrganization->delete();

                    $response = array(
                        "message" => "bravo",
                        "workOrganization" => $workOrganization,
                        "workOrganizations" => WorkOrganization::with("vehicles.type")->get()
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
