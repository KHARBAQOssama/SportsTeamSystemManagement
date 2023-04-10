<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

        $total_price = $game->ticket_price *  $request->input('tickets_number');

        $credentials = [
            'user_id' => JWTAuth::user()->id,
            'game_id' => $game->id,
            'tickets_number' => $request->input('tickets_number'),
            'total_price' => $total_price,
        ];

        $reservation = Reservation::create($credentials);

        return response()->json(['success'=>'you reserved a ticket(s) for the game ('.Team::find($game->home)->name.'-'.Team::find($game->away)->name.')'],201);
    }

    public function reservationDecision(Request $request,Reservation $reservation){
        $decision = $request->input('decision');
        if($decision == 'cancel'){
            $reservation->update(['status'=>'Canceled']);
        }else if($decision == 'confirm'){
            $reservation->update(['status'=>'Confirmed']);
        }

        return response()->json(['success'=>'success operation']);
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
