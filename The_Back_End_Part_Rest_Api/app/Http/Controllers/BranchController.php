<?php

namespace App\Http\Controllers;


use App\Models\Branch;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreOrUpdateBranchRequest;
use App\Models\Tournament;

class BranchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        
        $this->middleware('permission:Add Branch',['only'=>'update']);
        $this->middleware('permission:Delete Branch',['only'=>'destroy']);
        $this->middleware('permission:Update Branch',['only'=>'store']);
        $this->middleware('permission:View Branches',['only'=>'index']);
    }

    public function index()
    {
        $branches = Branch::with('users','tournaments','games')->get();
        return response()->json($branches);   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrUpdateBranchRequest $request)
    {
        $credentials = [
            'name' => $request->input('name'),
            'sport_id' => $request->input('sport_id'),
        ];
        
        if ($request->input('icon')) {
            $base64_string = $request->input('icon');
            $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64_string));
    
            $filename = uniqid() . '.jpg';

            Storage::put('public/images/' . $filename, $image_data);
            $url = asset('storage/images/'.$filename);
            $credentials['icon'] = $url;
        }

        $branch = Branch::create($credentials);
        
        return response()->json([
            'message' => 'Branch added successfully'
        ]);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        return response()->json($branch);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreOrUpdateBranchRequest $request, Branch $branch)
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

        $branch->update($credentials);
        
        return response()->json([
            'message' => 'Branch updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();
        return response()->json([
            'message' => 'Branch deleted successfully'
        ]);
    }
}
