<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Customer_Product_Document;
use App\Http\Resources\CustomerProductDocumentResource;

class CustomerProductDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Customer_Product_Document::latest()->get();
        return response()->json([CustomerProductDocumentResource::collection($data), 'Customers product document fetched.']);
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
            'customer_product_status_id' => 'nullable|numeric|exists:customer_product_status,id',
            'document_name' => 'nullable|string|max:255',
            'document_name_enycript' => 'nullable|string'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $customer_product_document = Customer_Product_Document::create([
            'customer_product_status_id' => $request->customer_product_status_id,
            'document_name' => $request->document_name,
            'document_name_enycript' => $request->document_name_enycript
        ]);
        
        return response()->json(['Customer product document created successfully.', new CustomerProductDocumentResource($customer_product_document)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer_product_document = Customer_Product_Document::find($id);
        if (is_null($customer_product_document)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new CustomerProductDocumentResource($customer_product_document)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer_Product_Document $customer_product_document)
    {
        $validator = Validator::make($request->all(),[
            'customer_product_status_id' => 'nullable|numeric|exists:customer_product_status,id',
            'document_name' => 'nullable|string|max:255',
            'document_name_enycript' => 'nullable|string'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $customer_product_document->customer_product_status_id = $request->customer_product_status_id;
        $customer_product_document->document_name = $request->document_name;
        $customer_product_document->document_name_enycript = isset($request->document_name_enycript)?$request->document_name_enycript:0;
        $customer_product_document->save();
        
        return response()->json(['Customer product document updated successfully.', new CustomerProductDocumentResource($customer_product_document)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer_Product_Document $customer_product_document)
    {
        $customer_product_document->delete();

        return response()->json('Customer product document deleted successfully');
    }
}
