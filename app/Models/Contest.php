<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contest extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'win',
        'history',
        'user_id',
        'place_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function place()
    {
        return $this->belongsTo(Place::class)->withTrashed();
    }
    public function characters()
    {
        return $this->belongsToMany(Character::class,)->withPivot('hero_hp','enemy_hp')->withTimestamps()->withTrashed();
    }
}
