<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Product;
use App\Http\Resources\ProductResource;

class ProductStepController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $stepId = [];
        if ($request->filled('step_id')) { //sequence
            $stepId = $request->step_id;
        }

        $product->steps()->sync($stepId);
        
        return response()->json(['Product step updated successfully.', new ProductResource($product)]);
    }
}
