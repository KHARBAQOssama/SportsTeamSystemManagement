<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreOrUpdateGame;
use App\Http\Requests\StoreOrUpdateGameRequest;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Game::All());
    }

    public function getGamesInSport(){
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

    public function storeGameTeam($request,$string){
        $url = null;
        if($request->file($string.'image')){
            $path    = $request->file($string.'image')->store('public/images');
            $url     = Storage::url($path);
        }
            

            $credentials = [
                'name'      => $request->input($string.'name'),
                'slag'      => strtoupper($request->input($string.'slag')),
                'country'   => $request->input($string.'country'),
                'city'      => $request->input($string.'city'),
                'stadium'   => $request->input($string.'stadium'),
                'image_url'   => $url,
            ];
        
            $team = Team::create($credentials)->id;

            return $team;
    }

    public function store(StoreOrUpdateGameRequest $request)
    {
        $home = $request->input('home') ? $request->input('home') : null;
        $away = $request->input('away') ? $request->input('away') : null;
        if($request->input('new_home_team_name')){
            $home = $this->storeGameTeam($request,'new_home_team_');
        }
        if($request->input('new_away_team_name')){
            $away = $this->storeGameTeam($request,'new_away_team_');
        }
        $fans = 1;

        if(!$request->input('fans')){
            $fans = 0;
        }

        $seats_number = fake()->numberBetween(0,80000);
        $credentials = [
            'home' => $home,
            'away' => $away,
            'fans' => $fans,
            'seats_number' => $fans ? $seats_number : null,
            'seats_available' => $fans ? $seats_number : null,
            'date' => $request->input('date'),
            'game_place' => Team::find($home)->stadium,
            'start_time' => $request->input('start_time'),
            'referee' =>$request->input('referee') ? $request->input('referee') : null,
            'referee1' =>$request->input('referee1') ? $request->input('referee1') : null,
            'referee2' =>$request->input('referee2') ? $request->input('referee2') : null,
            'referee3' =>$request->input('referee3') ? $request->input('referee3') : null,
            'sport_id' => JWTAuth::user()->sport->id,
            // 'sport_id' => 1,
            'ticket_price' => $request->input('fans') ? $request->input('ticket_price') : null,
        ];

        $game = Game::create($credentials);

        return response()->json($game);

    }

    public function nextGame(){
        $ourTeam = Team::ourTeam()->id; 
        $game = Game::where(function($query) use ($ourTeam) {
                        $query->where('home', $ourTeam)
                            ->orWhere('away', $ourTeam);
                    })
                    ->where('played', 0)
                    ->orderBy('date', 'asc')
                    ->orderBy('start_time', 'asc')
                    ->first();

        return response()->json($game);
    }
    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        return response()->json($game);
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
        if($game->tournament){
            return response()->json(['error'=>'we can not delete a game that belongs to a tournament']);
        }

        $game->delete();

        return response()->json(['message'=>'game has been deleted successfully']);
    }
}
