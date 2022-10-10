<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Customer_Product;
use App\Http\Resources\CustomerProductResource;

class CustomerProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Customer_Product::latest()->get();
        return response()->json([CustomerProductResource::collection($data), 'Customers Product fetched.']);
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
            'customer_id' => 'required|numeric|max:255',
            'product_id' => 'required|numeric|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $customer_product = Customer_Product::create([
            'customer_id' => $request->customer_id,
            'product_id' => $request->product_id
        ]);
        
        return response()->json(['Customer created successfully.', new CustomerProductResource($customer_product)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer_product = Customer_Product::find($id);
        if (is_null($customer)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new CustomerProductResource($customer_product)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer_Product $customer_product)
    {
        $validator = Validator::make($request->all(),[
            'customer_id' => 'required|numeric|max:255',
            'product_id' => 'required|numeric|max:255'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $customer_product->customer_id = $request->customer_id;
        $customer_product->product_id = $request->product_id;
        $customer_product->final_status = isset($request->final_status)?$request->final_status:0;
        $customer_product->save();
        
        return response()->json(['Customer updated successfully.', new CustomerProductResource($customer_product)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer_Product $customer_product)
    {
        $customer_product->delete();

        return response()->json('Customer deleted successfully');
    }
}
