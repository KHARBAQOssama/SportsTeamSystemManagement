<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreOrUpdateTournamentRequest;
use App\Models\Game;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([Tournament::all()]);
    }


    private function storeTournamentTeams($request){
        $teams = $request->input('teams');

        if($request->input('new_teams')){
            for($i=0;$i<count($request->input('new_teams'));$i++){
                $path                       = $request->file('new_teams_image')[$i]->store('public/images');
                $url                        = Storage::url($path);

                $credentials = [
                    'name'      => $request->input('new_teams_name')[$i],
                    'slag'      => strtoupper($request->input('new_teams_slag')[$i]),
                    'country'   => $request->input('new_teams_country')[$i],
                    'city'      => $request->input('new_teams_city')[$i],
                    'stadium'   => $request->input('new_teams_stadium')[$i],
                    'image_url'   => $url,
                ];
        
                $team = Team::create($credentials)->id;

                $teams[] = $team;
            }
        }

        return $teams;
    }

    private function generateGames($teams){
        $rounds = [];
        $games = [];
        for($i = 0;$i <count($teams)-1;$i++){
            $rounds[$i+1] = [];
            for($j = $i+1;$j <count($teams);$j++){
                $games[] = [$teams[$i],$teams[$j]];
            }  
        }

        for($i=0;$i<count($games);$i++){
            for($k = 1;$k <=count($rounds);$k++){
                $exist = false;
                for($z=0;$z<count($rounds[$k]);$z++){
                    if(in_array($games[$i][0],$rounds[$k][$z]) || in_array($games[$i][1],$rounds[$k][$z])){
                        $exist = true;
                        break;
                    }
                }
                
                if(!$exist){
                    $rounds[$k][] = $games[$i];
                    break;
                }
            }   
        }

        return $rounds;

    }

    private function storeGame($game,$round,$date,$tournament,$seats_number){
        $credentials = [
            'home' => $game[0],
            'away' => $game[1],
            'round' => $round,
            'fans' => fake()->boolean(),
            'date' => $date,
            'start_time' => fake()->numberBetween(12,22).':00:00',
            'referee' => fake()->name(),
            'referee1' => fake()->name(),
            'referee2' => fake()->name(),
            'referee3' => fake()->name(),
            'tournament_id' => $tournament,
            'seats_number' => $seats_number,
            'seats_available' => $seats_number,
            'ticket_price' => fake()->numberBetween(0,120),
        ];

        $game = Game::create($credentials);

        return $game;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrUpdateTournamentRequest $request)
    {
        $credentials = [
            'name' => $request->input('name'),
            'sport_id' => JWTAuth::user()->sport->id,
            // 'sport_id' => 3,
            'win_points' => $request->input('win_points'),
            'loss_points' => $request->input('loss_points'),
            'draw_points' => $request->input('draw_points'),
            'start_date' => $request->input('start_date'),
            // 'created_by' => JWTAuth::user()->id,
            // 'updated_by' => JWTAuth::user()->id,
        ];

        if($request->file('image')){
            $path                       = $request->file('image')->store('public/images');
            $url                        = Storage::url($path);
            $credentials['image_url']   = $url;
        }
        
        $tournament_id = Tournament::create($credentials)->id;

        $counter = 0;

        $numbers = [4,8,16,32,64];
        if($request->input('teams')){
            $counter+=count($request->input('teams'));
        }

        if($request->input('new_teams')){

            $length = count($request->input('new_teams'));
            $counter+= $length;
            
            $request->validate([
                'new_teams_name'        => 'required|array|size:'.$length,
                'new_teams_name,*'      => 'string',
                'new_teams_slag'        => 'required|array|size:'.$length,
                'new_teams_slag,*'      => 'string',
                'new_teams_country'     => 'required|array|size:'.$length,
                'new_teams_country,*'   => 'string',
                'new_teams_city'        => 'required|array|size:'.$length,
                'new_teams_city,*'      => 'string',
            ]);
        }

        if(!in_array($counter,$numbers)){
            return response()->json([
                'error' => 'teams number should be 4, 8, 16, 32, or 64',
            ]);
        }

        $teams = $this->storeTournamentTeams($request);

        $rounds = $this->generateGames(
                    $teams,
                );

        $def = $request->input('date_def');
        $start_date = Carbon::parse($request->input('start_date'));
        
        $home_date = $start_date;
        
        foreach ($rounds as $round => $games) {

            
            $away_date = $home_date->copy()->addDays($def*count($rounds));

            foreach ($games as $game) {
                $seats_number = fake()->numberBetween(0,80000);
                $home_game = $this->storeGame(
                    $game,
                    $round,
                    $home_date,
                    $tournament_id,
                    $seats_number
                );

                $away_game = $this->storeGame(
                    $game,
                    $round+count($rounds),
                    $away_date,
                    $tournament_id,
                    $seats_number
                );
            }
            $home_date = $start_date->addDays($def);
        }

        $tournament = Tournament::with(['games' => function($query) {
            $query->orderBy('date', 'asc')
                  ->orderBy('start_time', 'asc');
        }])
        ->find($tournament_id);

        return response()->json([
            $tournament,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tournament $tournament)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreOrUpdateTournamentRequest $request, Tournament $tournament)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tournament $tournament)
    {
        //
    }
}
