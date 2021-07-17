<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Employee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class EmployeesController extends Controller
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
                            
                $employees = Employee::with("work_organization", "enteredBy", "deliveries")->get();

                $this->authorize('view', $employees->first());
                
                $response = array(
                    "message" => "bravo",
                    "employees" => $employees,
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
                'lastName' => 'required|max:255',
                'firstName' => 'required|max:255',
                'work_org_id' => 'required|numeric',
                'sec_id' => 'required|numeric',
                'avatar' => 'required|image|mimes:jpeg'
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

                    $tmp = Employee::where('lastName', '=', $request->lastName)->where('firstName', '=', $request->firstName)->with("work_organization", "enteredBy")->first();
                    
                    if($tmp === null){

                        $employee = new Employee;
                        $employee->lastName = $request->lastName;
                        $employee->firstName = $request->firstName;
                        $employee->work_org_id = $request->work_org_id;
                        $employee->sec_id = auth()->user()->id; 
                        if($request->hasFile("avatar")){
                            $filenameWithExt = $request->file("avatar")->getClientOriginalName();
                            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                            $extension = $request->file("avatar")->getClientOriginalExtension();
                            $fileNameToStore = $filename."_".time().".".$extension;
                            $path = $request->file("avatar")->storeAs("public/".$request->lastName."_".$request->firstName, $fileNameToStore);
                        }
                        else{
                            $fileNameToStore = "employee.jpg";
                        }
                        $employee->avatar = $fileNameToStore;
                        $this->authorize('create', $employee);
                        $employee->save();
        
                        $response = array(
                            "message" => "bravo",
                            "employee" => $employee->get(),
                            "imagePath" => asset("storage/".$request->lastName."_".$request->firstName."/".$fileNameToStore)
                        );
                        
                        return response()->json($response);

                    }
                    else{

                        $response = array(
                            "message" => "Employee already exists in database!",
                            "employee" => $tmp,
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
        
        if($request->ajax()){

            if($request->isMethod("get")){

                $employee = Employee::with("work_organization", "enteredBy")->find($request->id);
                $this->authorize('view', $employee);

                $employee->pathToAvatar = asset("storage/".$employee->lastName."_".$employee->firstName."/".$employee->avatar);
                
                $response = array(
                    "message" => "bravo",
                    "employee" => $employee,
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
                'lastName' => 'max:255',
                'firstName' => 'max:255',
                'work_org_id' => 'numeric',
                'sec_id' => 'numeric',
                'avatar' => 'image|mimes:jpeg'
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

                    $employee = Employee::with("work_organization", "enteredBy")->find($request->id);
                    $employee->lastName = $request->lastName ? $request->lastName : $employee->lastName; 
                    $employee->firstName = $request->firstName ? $request->firstName : $employee->firstName;
                    $employee->work_org_id = $request->work_org_id ? $request->work_org_id : $employee->work_org_id; 
                    $employee->sec_id = $request->sec_id ? $request->sec_id : $employee->sec_id;
                    $employee->avatar = $request->avatar ? $request->avatar : $employee->avatar; 
                    
                    if($request->hasFile("avatar")){
                        $filenameWithExt = $request->file("avatar")->getClientOriginalName();
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        $extension = $request->file("avatar")->getClientOriginalExtension();
                        $fileNameToStore = $filename."_".time().".".$extension;
                        $path = $request->file("avatar")->storeAs("public/".$request->lastName."_".$request->firstName, $fileNameToStore);
                    }
                    else{
                        $fileNameToStore = $employee->avatar;//Zato sto vec ima neki avatar, bilo to difolt, bilo neki izabrani.
                    }
                    $employee->avatar = $fileNameToStore;

                    $this->authorize('update', $employee);
                    $employee->save();
                    $employee->pathToAvatar = asset("storage/".$employee->lastName."_".$employee->firstName."/".$employee->avatar);

                    $response = array(
                        "message" => "bravo",
                        "employee" => $employee,
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

                    $employee = Employee::with("work_organization", "enteredBy")->find($request->id); 
                    $this->authorize('delete', $employee);
                    $employee->pathToAvatar = asset("storage/".$employee->lastName."_".$employee->firstName."/".$employee->avatar);
                    
                    if($employee->avatar!="employee.jpg"){
                        Storage::deleteDirectory("public/".$employee->lastName."_".$employee->firstName."/");
                    }
                    $employee->delete();

                    $response = array(
                        "message" => "Employee record has been deleted.",
                        "employee" => $employee,
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
