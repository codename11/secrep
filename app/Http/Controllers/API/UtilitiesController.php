<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UtilitiesController extends Controller
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
       
        $validation = Validator::make(
            $request->all(),
            [
                "user_id" => "required|numeric",
                "per_page" => "required|numeric"
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

                    $user_id = $request->user_id;
                    
                    $ifExists = Utility::where("user_id", $user_id)->first();
                    
                    $utility = $ifExists ? $ifExists : Utility::take(1)->first();
                    
                    $this->authorize('create', $utility);

                    if($ifExists===null){
                        $per_page = new Utility;
                        $per_page->per_page = $request->per_page;
                        $per_page->user_id = $user_id;
                        $per_page->save();

                        $response = array(
                            "message" => "bravo"
                        );
                        
                        return response()->json($response);
                    }
                    else{

                        $response = array(
                            "message" => "You already have defined per page.. You can update it though..."
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
     * @param  \App\Utility  $utility
     * @return \Illuminate\Http\Response
     */
    public function show(Utility $utility)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Utility  $utility
     * @return \Illuminate\Http\Response
     */
    public function edit(Utility $utility)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Utility  $utility
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Utility $utility)
    {
        $validation = Validator::make(
            $request->all(),
            [
                "user_id" => "required|numeric",
                "per_page_id" => "required|numeric",
                "per_page" => "required|numeric"
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

                    $user_id = $request->user_id;
                    $per_page_id = $request->per_page_id;
                    $per_page = Utility::where("user_id", $user_id)->find($per_page_id);
                    if($per_page){

                        $per_page->per_page = $request->per_page;
                        $per_page->user_id = $user_id;
                        $per_page->save();

                        $response = array(
                            "message" => "bravo",
                            "per_page" => $per_page,
                        );
                        
                        return response()->json($response);

                    }
                    else{

                        $response = array(
                            "message" => "This isnt yours per page to modify."
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Utility  $utility
     * @return \Illuminate\Http\Response
     */
    public function destroy(Utility $utility)
    {
        //
    }
}
