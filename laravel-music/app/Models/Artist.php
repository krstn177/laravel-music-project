<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Photo;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_band',
        'members',
        'photo_id',
    ];

    protected $casts = [
        'is_band' => 'boolean',
        'members' => 'array',
    ];

    public function albums()
    {
        return $this->belongsToMany(Album::class);
    }

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }
}
