<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'voter',
        'vote',
    ];

    /**
     * Get the vote item that owns the vote.
     */
    public function item()
    {
        return $this->belongsTo(VoteItem::class);
    }
}
