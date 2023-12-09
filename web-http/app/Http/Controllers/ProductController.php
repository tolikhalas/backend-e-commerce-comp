<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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
}
