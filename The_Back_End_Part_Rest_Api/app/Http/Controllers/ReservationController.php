<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return response()->json(Reservation::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $game = Game::find($request->input('game_id'));

        if(!$game->fans){
            return response()->json(['error' =>'You can not reserve a ticket for this game'],403);
        }

        $user_id = JWTAuth::user()->id;
        if(Reservation::where('game_id',$game->id)->where('user_id',$user_id)->first()){
            return response()->json(['message'=>'Already reserved']);
        }

        $total_price = $game->ticket_price;

        $credentials = [
            'user_id' => $user_id,
            'game_id' => $game->id,
            'tickets_number' => 1,
            'total_price' => $total_price,
        ];

        $reservation = Reservation::create($credentials);
        $game->update([
            'seats_available' => $game->seats_available - 1
        ]);
        return response()->json(['message'=>'you reserved a ticket']);
    }

    public function reservationDecision(Request $request,Reservation $reservation){
        $decision = $request->input('decision');
        if($decision == 'cancel'){
            $reservation->update(['status'=>'Canceled']);
        }else if($decision == 'confirm'){
            $reservation->update(['status'=>'Confirmed']);
        }

        return response()->json(['message'=>'success operation']);
    }
    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        return response()->json($reservation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return response()->json([
            'success'=>'you have canceled you reservation for the game ('.$reservation->game->away.'-'.$reservation->game->away.')'
        ]);
    }
}
