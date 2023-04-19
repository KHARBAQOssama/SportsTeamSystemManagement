<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Game;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreOrUpdateTournamentRequest;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $query = Tournament::query();
        if ($request->has('sport')) {
            $sport = $request->input('sport');
            $query->where('sport_id', $sport);
        }

        if ($request->has('by_search')) {
            $search = $request->input('by_search');
            $query->where('name','LIKE','%'.$search.'%');
        }

        $tournaments = $query->with(['sport','games'])->get();
        return response()->json($tournaments);
    }


    private function generateGames($teams){
        $rounds = [];
        $games = [];
        for($i = 0;$i <count($teams)-1;$i++){
            $rounds[$i+1] = [];
            for($j = $i+1;$j <count($teams);$j++){
                $games[] = [$teams[$i]['id'],$teams[$j]['id']];
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

    private function storeGame($home,$away,$round,$date,$tournament,$seats_number){
        $fans = fake()->boolean();
        $credentials = [
            'home' => $home,
            'away' => $away,
            'round' => $round,
            'fans' => $fans,
            'date' => $date,
            'game_place' => Team::find($home)->stadium,
            'start_time' => fake()->numberBetween(12,22).':00:00',
            'referee' => fake()->name(),
            'referee1' => fake()->name(),
            'referee2' => fake()->name(),
            'referee3' => fake()->name(),
            'tournament_id' => $tournament,
            // 'sport_id' => 1,
            'sport_id' => JWTAuth::user()->sport->id,
            'ticket_price' => $fans ? fake()->numberBetween(0,120) : null,
        ];

        if($fans){
            $credentials['seats_number'] =  $seats_number;
            $credentials['seats_available'] =  $seats_number;   
        }

        $game = Game::create($credentials);

        return $game;
    }


    public function store(StoreOrUpdateTournamentRequest $request)
    {
        $credentials = [
            'name' => $request->input('name'),
            'sport_id' => JWTAuth::user()->sport->id,
            // 'sport_id' => 1,
            'win_points' => $request->input('win_points'),
            'loss_points' => $request->input('loss_points'),
            'draw_points' => $request->input('draw_points'),
            'start_date' => $request->input('start_date'),
            'created_by' => JWTAuth::user()->id,
            // 'created_by' => 1,
            'updated_by' => JWTAuth::user()->id,
            // 'updated_by' => 1,
        ];

        if ($request->input('image')) {
            $base64_string = $request->input('image');
            $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64_string));
    
            $filename = uniqid() . '.jpg';

            Storage::put('public/images/' . $filename, $image_data);
            $url = asset('storage/images/'.$filename);
            $credentials['image_url'] = $url;
        }

        $tournament_id = Tournament::create($credentials)->id;

        $numbers = [4,8,16,32,64];
        $teams = $request->input('teams');

        if(!in_array(count($teams),$numbers)){
            return response()->json([
                'error' => 'teams number should be 4, 8, 16, 32, or 64',
            ]);
        }

        foreach ($teams as $team) {
            DB::table('standings')->insert([
                'tournament_id' => $tournament_id,
                'team_id' => $team['id'],
            ]);
        }

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
                    $game[0],
                    $game[1],
                    $round,
                    $home_date,
                    $tournament_id,
                    $seats_number
                );

                $away_game = $this->storeGame(
                    $game[1],
                    $game[0],
                    $round+count($rounds),
                    $away_date,
                    $tournament_id,
                    $seats_number
                );
            }
            $home_date = $start_date->addDays($def);
        }

        $tournament = Tournament::find($tournament_id);

        return response()->json([
            $tournament,
        ]);
    }

    public function getTournamentGames($id){
        $teamId = Team::ourTeam()->id;
        $tournament = Tournament::with(['games' => function($query) use ($teamId) {
            $query->where('home', $teamId)
                  ->orWhere('away', $teamId)
                  ->orderBy('date', 'asc')
                  ->orderBy('start_time', 'asc');
        }])->find($id);

        return response()->json([
            $tournament,
        ]);
    }

    public function tournamentStandings($id){
        $games = Game::where('tournament_id', $id)->get();

        foreach ($games as $game) {
            $now = now();
            $gameDateTime = Carbon::createFromFormat('Y-m-d H:i:s', "{$game->date} {$game->start_time}");

            if ($now >= $gameDateTime && !$game->played) {
                $homeScore = rand(0, 5);
                $awayScore = rand(0, 5);

                $homeStanding = DB::table('standings')
                                ->where('tournament_id',$game->tournament_id)
                                ->where('team_id',$game->home)
                                ->first();
                $awayStanding = DB::table('standings')
                                ->where('tournament_id',$game->tournament_id)
                                ->where('team_id',$game->away)
                                ->first();

                $game->home_score = $homeScore;
                $game->away_score = $awayScore;
                $game->played = true;
                $game->save();

                $homeStanding->play++;
                $homeStanding->score += $homeScore;
                $homeStanding->receive += $awayScore;
                $homeStanding->def = $homeStanding->score - $homeStanding->receive;
                
                $awayStanding->play++;
                $awayStanding->score += $awayScore;
                $awayStanding->receive += $homeScore;
                $awayStanding->def = $awayStanding->score - $awayStanding->receive;
                
                $tournament = Tournament::find($id);
                $drawPoints = $tournament->draw_points;
                $lossPoints = $tournament->loss_points;
                $winPoints = $tournament->win_points;

                if($homeScore == $awayScore){

                    $homeStanding->draw++;
                    $homeStanding->points += $drawPoints;
                    $awayStanding->draw++;
                    $awayStanding->points += $drawPoints;

                }else if($homeScore > $awayScore){

                    $homeStanding->win++;
                    $homeStanding->points += $winPoints;
                    $awayStanding->lose++;
                    $awayStanding->points += $lossPoints;

                }else{

                    $awayStanding->win++;
                    $awayStanding->points += $winPoints;
                    $homeStanding->lose++;
                    $homeStanding->points += $lossPoints;

                }

                DB::table('standings')
                    ->where('id',$homeStanding->id)
                    ->update(get_object_vars($homeStanding));
                DB::table('standings')
                    ->where('id',$awayStanding->id)
                    ->update(get_object_vars($awayStanding));

            }

        }

        $standing = DB::table('standings')
                    ->where('tournament_id', $id)
                    ->orderByDesc('points')
                    ->orderByDesc('def')
                    ->get();
        
        return response()->json($standing);
        
    }

    public function update(Request $request,Tournament $tournament){
        return response()->json($request);
        $credentials = [
            'name'=> $request->input('name'),
        ];
        if($request->input('image') != $tournament->image_url){
                $base64_string = $request->input('image');
                $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64_string));
                $filename = uniqid() . '.jpg';
                Storage::put('public/images/' . $filename, $image_data);
                $url = asset('storage/images/'.$filename);
                $credentials['image_url'] = $url;
        }

        $tournament->update($credentials);

        return response()->json([
            'message' => 'tournament updated',
        ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(Tournament $tournament)
    {
        return response()->json([$tournament]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tournament $tournament)
    {
        if(!$tournament){
            return response()->json(['message' => 'tournament not found']);
        }

        $tournament->delete();

        return response()->json(['message' => 'tournament has been deleted successfully']);
    }
}
