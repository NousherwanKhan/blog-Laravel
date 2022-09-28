<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeDislike extends Model
{
    use HasFactory;

    protected $fillable = [ 'like', 'dislike', 'userpost_id'];

    
    public function likepost(){
        return $this->belongsTo(Userpost::class,'userpost_id')->sum('like');
    }

    public function dislikepost(){
        return $this->belongsTo(Userpost::class,'userpost_id')->sum('dislike');
    }
}
