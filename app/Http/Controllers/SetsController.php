<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Set;
use App\Http\Resources\Set as SetResource;
use App\Http\Resources\Card;

class SetsController extends Controller
{
    public function index() {
        $set = Set::first();

        $cards = $set->cards;
    
        return Card::collection($cards);
    }
}
