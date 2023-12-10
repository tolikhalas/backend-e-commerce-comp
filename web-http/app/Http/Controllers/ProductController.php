<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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

    public function show(int $id) {
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
            'rate' => "min:1.00|max:5.00",
            'quantity' => "required|numeric|min:0",
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ( $validator->fails() ) {
            return response()->json(["status"=> 406,"message"=> $validator->errors()],406);
        }

        $product = Product::create([
            "name" => $request->name,
            "brand" => $request->brand,
            "model_name" => $request->model_name,
            "quantity" => $request->quantity,
            "rate" => $request->rate,
            "description" => $request->description,
        ]);

        if ($request->file('image')) {
            $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();
            Storage::disk('public')->put($imageName, file_get_contents($request->image));
            $product->update([
                "image" => $imageName,
            ]);
        }


        if ($product) {
            $data = [
                "status" => 201,
                "message" => "$product->name successfully created",
                "product" => $product,
            ];
            return response()->json($data, 201);
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
                'rate' => "min:1.00|max:5.00",
                'quantity' => "required|numeric|min:0",
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
    
            if ( $validator->fails() ) {
                return response()->json(["status"=> 406,"message"=> $validator->errors()],406);
            }
           
            $product->update([
                "name" => $request->name,
                "brand" => $request->brand,
                "model_name" => $request->model_name,
                "quantity" => $request->quantity,
                "rate" => $request->rate,
                "description" => $request->description,
            ]);

            if ($request->file('image')) {
                $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();
                Storage::disk('public')->put($imageName, file_get_contents($request->image));
                $product->update([
                    "image" => $imageName,
                ]);
            }

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
