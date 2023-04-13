<?php

namespace App\Http\Controllers;


use App\Models\Sport;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreOrUpdateSportRequest;

class SportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            Sport::all()
        ]);   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrUpdateSportRequest $request)
    {
        $credentials = [
            'name' => $request->input('name')
        ];
        
        if ($request->input('image')) {
            $base64_string = $request->input('image');
            $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64_string));
    
            $filename = uniqid() . '.jpg';

            Storage::put('public/images/' . $filename, $image_data);
            $url = asset('storage/images/'.$filename);
            $credentials['icon'] = $url;
        }

        $sport = Sport::create($credentials);
        
        return response()->json([
            'message' => 'sport added successfully'
        ]);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Sport $sport)
    {
        return response()->json($sport);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreOrUpdateSportRequest $request, Sport $sport)
    {
        $credentials = [
            'name' => $request->input('name')
        ];
        
        if ($request->input('image')) {
            $base64_string = $request->input('image');
            $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64_string));
    
            $filename = uniqid() . '.jpg';

            Storage::put('public/images/' . $filename, $image_data);
            $url = asset('storage/images/'.$filename);
            $credentials['icon'] = $url;
        }

        $sport->update($credentials);
        
        return response()->json([
            'message' => 'sport updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sport $sport)
    {
        $sport->delete();
        return response()->json([
            'message' => 'sport deleted successfully'
        ]);
    }

    public function getSportUsers(Sport $sport){
        return response()->json($sport->users);
    }

    public function authenticatedSportUsers(){
        $users = JWTAuth::user()->sport->users;
        return response()->json($users);
    }
}
