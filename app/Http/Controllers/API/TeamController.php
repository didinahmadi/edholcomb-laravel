<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeamResource;
use Illuminate\Http\Request;
use App\Models\Team;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{

    public function index(Request $request)
    {
        return TeamResource::collection(Team::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100'
        ]);

        try {
            $team = new Team;
            $team->fill($request->all());
            $team->save();
            return response()->json([
                'data' => new TeamResource($team)
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $team = Team::findOrFail($id);
            $team->delete();
            return response()->json([
                'data' => [
                    'id' => $id
                ]
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100'
        ]);

        $team = Team::findOrFail($id);

        try {
            $team->fill($request->all());
            $team->save();
            return response()->json([
                'data' => new TeamResource($team)
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }    
}
