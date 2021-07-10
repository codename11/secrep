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
        
        $validation = Validator::make(
            $request->all(),
            [
                'type' => 'max:255',
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
                        "request" => $request->all(),
                        "workOrganization" => $workOrganization->with("vehicles")->get(),
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
