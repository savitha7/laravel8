<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Customer_Product_Status;
use App\Http\Resources\CustomerProductStatusResource;

class CustomerProductStatusController extends Controller
{
    public function index()
    {
        $data = Customer_Product_Status::latest()->get();
        return response()->json([CustomerProductStatusResource::collection($data), 'Customers Product Status fetched.']);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'product_step_id' => 'nullable|numeric|exists:product_steps,id',
            'customer_product_id' => 'nullable|numeric|exists:customer_products,id',
            'status_id' => 'nullable|numeric|exists:status,id'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $customer_product_status = CustomerProductStep::create([
            'product_step_id' => $request->product_step_id,
            'customer_product_id' => $request->customer_product_id,
            'status_id' => $request->status_id
        ]);
        
        return response()->json(['Customer Product Status created successfully.', new CustomerProductResource($customer_product_status)]);
    }

    public function show($id)
    {
        $customer_product_status = Customer_Product_Status::find($id);
        if (is_null($customer_product_status)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new CustomerProductResource($customer_product_status)]);
    }

    public function update(Request $request, Customer_Product_Status $customer_product_status)
    {
        $validator = Validator::make($request->all(),[
            'product_step_id' => 'nullable|numeric|exists:product_steps,id',
            'customer_product_id' => 'nullable|numeric|exists:customer_products,id',
            'status_id' => 'nullable|numeric|exists:status,id',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $customer_product_status->product_step_id = $request->product_step_id;
        $customer_product_status->customer_product_id = $request->customer_product_id;
        $customer_product_status->status_id = isset($request->status_id)?$request->status_id:0;
        $customer_product_status->save();
        
        return response()->json(['Customer Product status updated successfully.', new CustomerProductResource($customer_product_status)]);
    }
    public function destroy(Customer_Product_Status $customer_product_status)
    {
        $customer_product_status->delete();

        return response()->json('Customer Product Status deleted successfully');
    }
}
