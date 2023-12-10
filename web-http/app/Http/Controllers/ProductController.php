<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // Fetch all products
    public function index() {
        $products = Product::all();
        if ($products->isEmpty()) {
            $data = [
                "status" => 404,
                "message" => "No product records"
            ];
            return response()->json($data, 404);
        } else {
            $data = [
                "status" => 200,
                "products" => $products,
            ];
            return response()->json($data, 200);
        }
    }

    public function show($id) {
        $product = Product::find($id);

        if ($product) {
            $data = [
                "status"=> 200,
                "product"=> $product,
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                "status"=> 404,
                "message"=> "There is no product with id: $id"
            ];
            return response()->json($data, 404);
        }
    }

    public function store(Request $request) {
        // Base validation
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:255",
            'brand' => "required|string|max:255",
            'model_name' => "required|string|max:255",
            'is_available' => "required|boolean",
            'quanity' => "required|numeric|min:0",
            'rate' => "required|min:1.00|max:5.00",
        ]);

        if ( $validator->fails() ) {
            return response()->json(["status"=> 406,"message"=> $validator->errors()],406);
        }

        $product = Product::create([
            "name" => $request->name,
            "brand" => $request->brand,
            "model_name" => $request->model_name,
            "is_available" => $request->is_available,
            "quanity" => $request->quanity,
            "rate" => $request->rate,
        ]);

        if ($product) {
            $data = [
                "status" => 200,
                "message" => "$product->name successfully created",
                "product" => $product,
            ];
            return response()->json($data, 200);
        } else {
            return response()->json(["status"=> 500,"message"=> "Somethind went wrong during creating $request->name"],500);
        }

    }

    public function update(Request $request, int $id) {

        $product = Product::find($id);

        if ($product) {
            $validator = Validator::make($request->all(), [
                "name" => "required|string|max:255",
                'brand' => "required|string|max:255",
                'model_name' => "required|string|max:255",
                'is_available' => "required|boolean",
                'quanity' => "required|numeric|min:0",
                'rate' => "required|min:1.00|max:5.00",
            ]);
    
            if ( $validator->fails() ) {
                return response()->json(["status"=> 406,"message"=> $validator->errors()],406);
            }
           
            $product->update([
                "name" => $request->name,
                "brand" => $request->brand,
                "model_name" => $request->model_name,
                "is_available" => $request->is_available,
                "quanity" => $request->quanity,
                "rate" => $request->rate,
            ]);

            $data = [
                "status"=> 200,
                "message"=> "Product with id $product->id updated successfully",
                "product" => $product
            ];

            return response()->json($data, 200);
            
        } else {
            $data = [
                "status"=> 404,
                "message"=> "There is no product with id: $id"
            ];
            return response()->json($data, 404);
        }
    }

    public function destroy(int $id) {
        $product = Product::find($id);

        if ($product) {
            $product->delete();

            $data = [
                "status"=> 200,
                "message"=> "Product $product->name is successfully deleted"
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                "status"=> 404,
                "message"=> "There is no product with id: $id"
            ];
            return response()->json($data, 404);
        }

    }
}
