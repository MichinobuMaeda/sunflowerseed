<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoteItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'seq',
        'name',
        'options',
    ];

    /**
     * Get the vote set that owns the vote item.
     */
    public function title()
    {
        return $this->belongsTo(VoteSet::class);
    }

    /**
     * Get the votes for the vote item.
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
