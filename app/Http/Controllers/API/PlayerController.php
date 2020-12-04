<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Player;
use App\Http\Resources\PlayerResource;

class PlayerController extends Controller
{

    public function index(Request $request)
    {
        $teamId = $request->input('team_id');
        $query = Player::orderByDesc('created_at');
        if ($teamId) {
            $query->where('team_id', $teamId);
        }
        return PlayerResource::collection($query->get());
    }
        
    public function store(Request $request)
    {
        $request->validate([
            'team_id' => 'required|exists:teams,id',
            'email' => 'required|email|unique:players,email',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100'
        ]);

        $teamId = $request->input('team_id');

        $team = Team::findOrFail($teamId);

        try {
            $playerData = $request->only(['email', 'first_name', 'last_name']);
            $player = $team->players()->create($playerData);
            return response()->json([
                'data' => new PlayerResource($player)
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'team_id' => 'nullable|exists:teams,id',
            'email' => 'required|email|unique:players,email,'.$id,
            'first_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100'
        ]);

        $playerId = $request->input('id');

        $player = Player::findOrFail($playerId);

        try {
            $playerData = $request->only(['email', 'first_name', 'last_name']);
            $player->fill($playerData);
            $player->save();
            return response()->json([
                'data' => new PlayerResource($player)
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
