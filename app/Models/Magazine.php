<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Magazine extends Model
{
    use HasFactory;
    protected $fillable=[
        'name','description','release_date'

    ];

    //Relation
    public function users()
    {
        return $this->beLongsToMany(User::class,'subscriptions')
        ->withPivot('start_date','end_date','status')->withTimestamps();

    }
    //
      public function articles() {
        return $this->hasMany(Article::class);
        
}



}
