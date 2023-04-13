<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Product::all());
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
        ];

        $product_id = Product::create($credentials)->id;

        foreach($request->input('images') as $image){

            $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
    
            $filename = uniqid() . '.jpg';

            Storage::put('public/images/' . $filename, $image_data);
            // $url = asset('storage/images/'.$filename);
            // $credentials['image_url'] = $url;
            
            $credentials = [
                'image_url' => asset('storage/images/'.$filename),
                'product_id' => $product_id
            ];

            Image::create($credentials);
        }

        return response()->json(['success' => 'product has been added successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json($product)
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
