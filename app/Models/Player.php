<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    public $fillable = ['team_id', 'first_name', 'last_name', 'email'];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
