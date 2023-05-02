<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTeamRequest;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return response()->json(Team::all());
    }


    public function getBySearch(Request $request){
        $searchInput = $request->input('search');
        $teams = Team::query()
            ->when($searchInput, function ($query, $searchInput) {
                return $query->where('name', 'like', $searchInput.'%')
                             ->orWhere('slag', 'like', $searchInput.'%')
                             ->orWhere('country', 'like', $searchInput.'%')
                             ->orWhere('stadium', 'like', $searchInput.'%')
                             ->orWhere('city', 'like', $searchInput.'%');
            })->get();
    
        return response()->json($teams);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamRequest $request)
    {
        $credentials = [
            'name'      => $request->input('name'),
            'slag'      => strtoupper($request->input('slag')),
            'country'   => $request->input('country'),
            'city'      => $request->input('city'),
            'stadium'   => $request->input('stadium'),
        ];

        if ($request->input('image')) {
            $base64_string = $request->input('image');
            $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64_string));
    
            $filename = uniqid() . '.jpg';

            Storage::put('public/images/' . $filename, $image_data);
            $url = asset('storage/images/'.$filename);
            $credentials['image_url'] = $url;
        }

        $team = Team::create($credentials);
        
        return response()->json([
            'message' => 'team added successfully',
            'team' => $team
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        return response()->json([
            $team,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTeamRequest $request, Team $team)
    {
        $credentials = [
            'name'      => $request->input('name'),
            'slag'      => strtoupper($request->input('slag')),
            'country'   => $request->input('country'),
            'city'      => $request->input('city'),
            'stadium'   => $request->filled('stadium') ? $request->input('stadium') : $team->stadium,
        ];

        if ($request->input('image')) {
            $base64_string = $request->input('image');
            $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64_string));
    
            $filename = uniqid() . '.jpg';

            Storage::put('public/images/' . $filename, $image_data);
            $url = asset('storage/images/'.$filename);
            $credentials['image_url'] = $url;
        }
        
        $team->update($credentials);

        return response()->json([
            'message' => 'team updated successfully'
        ]);
    }

    public function destroy(Team $team)
    {
        $team->delete();
        
        return response()->json([
            'message' => 'team deleted successfully'
        ]);
    }
}
