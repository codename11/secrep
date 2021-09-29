<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\DateHelper;
use App\Vehicle;
use App\Rules\Vehicles;
use App\Rules\isObject;
use App\Rules\Models;

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
    public function show(Request $request)
    {

        /*$dates = new \stdClass();

        $start_date = new DateHelper($request->start_date);
        $dates->start_date = $start_date->checkIfDate();

        $end_date = new DateHelper($request->end_date);
        $dates->end_date = $end_date->checkIfDate();*/

        $validation = Validator::make(
            $request->all(),
            [
                'start_date' => 'required|date_format:d/m/Y',
                "end_date" => 'required|date_format:d/m/Y',
                "models" => "array",
                "models.*" => [new Models],
                "optional_parameters" => "array",
                "optional_parameters.*" => "array",
                "optional_parameters.*.*" => "string"
            ]
        );
        $errors = $validation->errors();
        //Mozda je bolje da se dozvoli pretraga samo jednog modela sa datumima.
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

                    $d1 = new DateHelper($request->start_date);
                    $d2 = new DateHelper($request->end_date);

                    $start_date = $d1->checkIfDate();
                    $end_date = $d2->checkIfDate();

                    $dates = new \stdClass();
                    $dates->start_date = $start_date;
                    $dates->end_date = $end_date;

                    $models = $request->models;
                    $response = array(
                        "message" => "bravo",
                        "dates" => $dates
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
