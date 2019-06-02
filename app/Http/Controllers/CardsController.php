<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Card;
use App\Http\Resources\Card as CardResource;

class CardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get cards
        $cards = Card::orderBy('created_at', 'desc')->paginate(10);

        // Return collection of cards as a resource
        return CardResource::collection($cards);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $card = $request->isMethod('put') ? Card::findOrFail($request->card_id) : new Card;

        $card->id = $request->input('card_id');
        $card->name = $request->input('name');
        $card->op = $request->input('op');

        if($card->save()) {
            return new CardResource($card);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get card
        $card = Card::findOrFail($id);

        // Return single card as a resource
        return new CardResource($card);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get card
        $card = Card::findOrFail($id);

        if ($card->delete()) {
            return new CardResource($card);
        }
    }
}
