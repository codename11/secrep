<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Special_Permission;
use Illuminate\Support\Facades\Validator;

class Special_PermissionsController extends Controller
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
                            
                $specialPermission = Special_Permission::with("user", "vehicles.type", "vehicles.workOrganization", "employees.work_organization")->get();

                $this->authorize('view', $specialPermission->first());
                
                $response = array(
                    "message" => "bravo",
                    "specialPermission" => $specialPermission,
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
                'permission_name' => 'required|max:255',
                "permission_description" => 'required|max:255',
                "sec_id" => "required|integer"
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

                    $specialPermission = new Special_Permission;
                    $specialPermission->permission_name = $request->permission_name;
                    $specialPermission->permission_description = $request->permission_description;
                    $specialPermission->sec_id = $request->sec_id;

                    $this->authorize('create', $specialPermission);
                    $specialPermission->save();

                    $response = array(
                        "specialPermission" => $specialPermission->with("user", "vehicles")->find($specialPermission->id),
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

                    $specialPermission = Special_Permission::with("user", "vehicles")->find($request->id);
                    $this->authorize('view', $specialPermission);
                    $response = array(
                        "message" => "bravo",
                        "specialPermission" => $specialPermission,
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
                "id" => "required|numeric",
                'permission_name' => 'max:255',
                "permission_description" => 'max:255',
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

                    $specialPermission = Special_Permission::with("user", "vehicles")->find($request->id);
                    $specialPermission->permission_name = $request->permission_name ? $request->permission_name : $specialPermission->permission_name; 
                    $specialPermission->permission_description = $request->permission_description ? $request->permission_description : $specialPermission->permission_description;   
                    $this->authorize('update', $specialPermission);
                    $specialPermission->save();
    
                    $response = array(
                        "message" => "bravo",
                        "specialPermission" => $specialPermission,
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

                    $specialPermission = Special_Permission::with("user", "vehicles")->find($request->id); 
                    $this->authorize('delete', $specialPermission);
                    $specialPermission->delete();

                    $response = array(
                        "message" => "bravo",
                        "specialPermission" => $specialPermission,
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
