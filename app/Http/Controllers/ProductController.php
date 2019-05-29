<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function index()
    {
        // $products = auth()->user()->products;
        $products = Product::all();
 
        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }
    public function create()
    {
        return response()->json([
            'success' => true
        ]);
    }
 
    public function show($id)
    {
        // $product = auth()->user()->products()->find($id);
        $product = Product::find($id);
 
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product with id ' . $id . ' not found'
            ], 404);
        }
 
        return response()->json([
            'success' => true,
            'data' => $product->toArray()
        ], 200);
    }
 
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
 
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        
        $imageName = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move('images', $imageName);

        $product->image = 'images/'.$imageName;

        
 
        if (auth()->user()->products()->save($product)){
            return response()->json([
                'success' => true,
                'data' => $product->toArray()
            ]);
        }
        else
            return response()->json([
                'success' => false,
                'message' => 'Product could not be added'
            ], 500);
    }
 
    public function update(Request $request, $id)
    {
        $product = auth()->user()->products()->find($id);
 
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product with id ' . $id . ' not found'
            ], 400);
        }
 
        $updated = $product->fill($request->all())->save();
 
        if ($updated)
            return response()->json([
                'success' => true
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Product could not be updated'
            ], 500);
    }
 
    public function destroy($id)
    {
        $product = auth()->user()->products()->find($id);
 
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product with id ' . $id . ' not found'
            ], 400);
        }
 
        if ($product->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product could not be deleted'
            ], 500);
        }
    }
}
