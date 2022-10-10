<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Product;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::latest()->get();
        return response()->json([ProductResource::collection($data), 'Products fetched.']);
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
            'name' => 'required|string|max:255'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $product = Product::create([
            'name' => $request->name
        ]);

        if ($request->filled('category_id')) {
            $product->categories()->attach($request->category_id);
        }

        if ($request->filled('prices')) {

            $getPrices = [];
            foreach ($request->prices as $key => $value) {
                $getPrices[$key]['mrp'] = $value->mrp;
                $getPrices[$key]['distributor_price'] = $value->distributor_price;
                $getPrices[$key]['dealer_price'] = $value->dealer_price;
            }

            $product->prices()->createMany($getPrices);
        }
        
        return response()->json(['Product created successfully.', new ProductResource($product)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new ProductResource($product)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $product->name = $request->name;
        $product->save();

        $categoryId = [];
        if ($request->filled('category_id')) {
            $categoryId = $request->category_id;
        }

        $product->categories()->sync($categoryId);
        
        return response()->json(['Product updated successfully.', new ProductResource($product)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json('Product deleted successfully');
    }

}
