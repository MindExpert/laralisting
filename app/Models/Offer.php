<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Offer extends Model
{
    protected $guarded = ['id'];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class, 'listing_id', 'id');
    }

    public function bidder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'bidder_id', 'id');
    }

    public function scopeByMe(Builder $query): Builder
    {
        return $query->where('bidder_id', Auth::user()?->id);
    }

    public function scopeExcept(Builder $query, Offer $offer): Builder
    {
        return $query->where('id', '!=', $offer->id);
    }
}
