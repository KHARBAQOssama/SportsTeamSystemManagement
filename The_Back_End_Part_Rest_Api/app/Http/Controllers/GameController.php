<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreOrUpdateGame;
use App\Http\Requests\StoreOrUpdateGameRequest;
use App\Models\Tournament;

class GameController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index','nextGame']]);
    }

    public function index()
    {
        $tournaments = Tournament::all();
        foreach ($tournaments as $tournament) {
            TournamentController::tournamentStandings($tournament); 
        }
        $ourTeam = Team::ourTeam();
        $played = Game::with(['homeTeam', 'awayTeam','tournament','branch'])
                ->where('played',1)
                ->where(function($query) use ($ourTeam){
                    $query->orWhere('home', $ourTeam->id)
                        ->orWhere('away', $ourTeam->id);
                })
                ->orderByDesc('date')
                ->orderByDesc('start_time')
                ->get();
        $notPlayed = Game::with(['homeTeam', 'awayTeam','tournament','branch'])->where('played',0)
                ->where(function($query) use ($ourTeam){
                    $query->orWhere('home', $ourTeam->id)
                        ->orWhere('away', $ourTeam->id);
                })
                ->orderBy('date')
                ->orderBy('start_time')
                ->get();
        // $notPlayed = Game::with(['homeTeam', 'awayTeam','tournament','branch'])->where('played',0)->get();
        return response()->json([
            'played'=>$played,
            'notPlayed'=>$notPlayed,
        ]);
    }

    public function getGamesInBranch(){
        $games = collect();
        foreach (JWTAuth::user()->branch->tournaments as $tournament) {
            $games = $games->merge($tournament->games()->where(function ($query) {
                $query->where('home', 1)->orWhere('away', 1);
            })->get());
        }
        return response()->json([$games]);
    }

    public function nextGame(){
        
        $team = Team::where('name', 'Olympic Club Youssoufia')->first();

        $game = Game::with('homeTeam','awayTeam','tournament')
        ->where('played','0')
        ->where(function ($query) use ($team) {
            $query->where('home', $team->id)
                  ->orWhere('away', $team->id);
        })
        ->orderBy('date')
        ->orderBy('start_time')
        ->first();

        return response()->json($game);
    }
    /**
     * Store a newly created resource in storage.
     */

    public function destroy(Game $game)
    {
        $game->delete();
        return response()->json(['message'=>'game has been deleted successfully']);
    }
}
