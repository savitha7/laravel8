<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Step;
use App\Http\Resources\StepResource;

class StepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Step::latest()->get();
        return response()->json([StepResource::collection($data), 'Step fetched.']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'step_name' => 'required|string|max:255'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $step = Step::create([
            'step_name' => $request->step_name
         ]);
        
        return response()->json(['Step created successfully.', new StepResource($step)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $step = Step::find($id);
        if (is_null($step)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new StepResource($step)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Step $step)
    {
        $validator = Validator::make($request->all(),[
            'step_name' => 'required|string|max:255'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $step->step_name = $request->step_name;
        $step->save();
        
        return response()->json(['Step updated successfully.', new StepResource($step)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Step $step)
    {
        $step->delete();

        return response()->json('Step deleted successfully');
    }
}
