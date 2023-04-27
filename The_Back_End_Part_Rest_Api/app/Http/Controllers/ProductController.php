<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();
    
        if ($request->has('min_price')) {
            $min_price = $request->input('min_price');
            $query->where('price','<', $min_price);
        }
        if ($request->has('max_price')) {
            $max_price = $request->input('max_price');
            $query->where('price','>', $max_price);
        }

        if ($request->has('by_search')) {
            $search = $request->input('by_search');
            $query->where('title','like', '%'.$search.'%');
        }

        $products = $query->with('images')->get();

        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $credentials = [
            'title'                 => $request->input('title'),
            'short_description'     => $request->input('short_description'),
            'description'           => $request->input('description'),
            'quantity'              => $request->input('quantity'),
            'price'                 => $request->input('price'),
            'user_id'                 => JWTAuth::user()->id,
        ];

        $product_id = Product::create($credentials)->id;

        foreach($request->input('images') as $image){

            $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
    
            $filename = uniqid() . '.jpg';

            Storage::put('public/images/' . $filename, $image_data);
            
            $credentials = [
                'image_url' => asset('storage/images/'.$filename),
                'product_id' => $product_id
            ];

            Image::create($credentials);
        }

        return response()->json(['message' => 'product has been added successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        
        $credentials = [
            'title'                 => $request->input('title'),
            'short_description'     => $request->input('short_description'),
            'description'           => $request->input('description'),
            'quantity'              => $request->input('quantity'),
            'price'                 => $request->input('price'),
        ];
    // dd($credentials);
        $product->update($credentials);
    
        
        $images = $request->input('images');
        $image_ids = $request->input('image_ids');
        $new_images = $request->input('newImages');

    // Delete the images that have been removed
    Image::where('product_id', $product->id)->whereNotIn('id', $image_ids)->delete();

    // Add the new images
    foreach($new_images as $image){

        $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));

        $filename = uniqid() . '.jpg';

        Storage::put('public/images/' . $filename, $image_data);
        
        $credentials = [
            'image_url' => asset('storage/images/'.$filename),
            'product_id' => $product->id
        ];

        Image::create($credentials);
    }
        
        return response()->json('done');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['success' => 'product has been deleted successfully']);
    }
}
