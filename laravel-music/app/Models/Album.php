<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'release_date',
        'duration',
        'track_count',
        'score',
        'photo_id',
        'user_id'
    ];

    protected $casts = [
        'release_date' => 'date',
        'score' => 'integer',
    ];

    public function artists()
    {
        return $this->belongsToMany(Artist::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
    
    public function photo(){
        return $this->belongsTo(Photo::class);
    }
}
