<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VoteSet extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'seq',
        'name',
        'status',
        'anonymous',
    ];

    /**
     * Get the vote items for the vote set.
     */
    public function items()
    {
        return $this->hasMany(VoteItem::class);
    }

    /**
     * Get the vote histories for the vote item.
     */
    public function histories()
    {
        return $this->hasMany(VoteHistory::class);
    }
}
