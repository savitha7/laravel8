<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Product;
use App\Models\Product_Price;
use App\Http\Resources\ProductResource;

class ProductPriceController extends Controller
{
    
	/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::find($request->product_id);

        if($product) {
	        $validator = Validator::make($request->all(),[
	            'prices.*.mrp' => 'required|numeric|gt:0',
	            'prices.*.distributor_price' => 'required|numeric|gt:0',
	            'prices.*.dealer_price' => 'required|numeric|gt:0',
	        ]);

	        if($validator->fails()){
	            return response()->json($validator->errors());       
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
        }
        return response()->json(['Product price addedd successfully.', new ProductResource($product)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product_Price $product_price)
    {
        $product = Product::find($request->product_id);

        if($product) {
	        $validator = Validator::make($request->all(),[
	            'prices.*.mrp' => 'required|numeric|gt:0',
	            'prices.*.distributor_price' => 'required|numeric|gt:0',
	            'prices.*.dealer_price' => 'required|numeric|gt:0',
	        ]);

	        if($validator->fails()){
	            return response()->json($validator->errors());       
	        }

	        $product_price->mrp = $request->mrp;
	        $product_price->distributor_price = $request->distributor_price;
	        $product_price->dealer_price = $request->dealer_price;
	        $product_price->save();        
        }
        return response()->json(['Product price updated successfully.', new ProductResource($product)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product_Price $product_price)
    {
        $product_price->delete();

        return response()->json('Product price deleted successfully');
    }
}
