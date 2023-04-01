<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrUpdateGame;
use App\Http\Requests\StoreOrUpdateGameRequest;
use App\Models\Game;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([Game::All()]);
    }

    public function getGamesInSport(){
        // $games = JWTAuth::user()->sport->tournaments;
        $games = collect();
        foreach (JWTAuth::user()->sport->tournaments as $tournament) {
            $games = $games->merge($tournament->games()->where(function ($query) {
                $query->where('home', 1)->orWhere('away', 1);
            })->get());
        }
        return response()->json([$games]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrUpdateGameRequest $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        //
    }
}
