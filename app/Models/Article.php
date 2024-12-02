<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Article extends Model
{
    use HasFactory;
    protected $fillable=[
        'title','content','magazine_id','publication_date'
    ];

    public function magazine()
    {
        return $this->beLongsTo(Magazine::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
