<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoteHistory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vote_set_id',
        'user_id',
    ];

    /**
     * Get the vote set that owns the vote item.
     */
    public function title()
    {
        return $this->belongsTo(VoteSet::class);
    }
}
