<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id','magazine_id','start_date','end_date','status'
    ];

    public function user()
    {
        return $this->beLongsTo(User::class);
    }
    public function magazine()
    {
        return $this->beLongsTo(Magazine::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
