<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListingImage extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['src'];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    public function getSrcAttribute(): string
    {
        return asset("storage/{$this->filename}");
    }
}
