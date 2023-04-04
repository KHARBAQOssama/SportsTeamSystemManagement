<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function store(Request $request){
        try {
            $path = $request->file('image')->store('public/images');
            $url                        = Storage::url($path);
            // $imageFullName = $request->file('image')->getClientOriginalName();
    
            // $request->file('image')->storeAs('images',$imageFullName);
    
            $data = Photo::create([
                'url' => $url
            ]);
    
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function get(){
        return response()->json(Photo::all());
    }
}
