<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Userpost extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'Pending';
    const STATUS_REJECTED = 'Rejected';
    const STATUS_APPROVED = 'Approved';



    protected $fillable = [
        'post', 'description', 'image', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function scopeActive($query)
    {
        return $query->whereHas('user', function ($query) {
            $query->where('active', 1);
        });
    }

    
    public function likes(){
        return $this->hasMany(LikeDislike::class,'userpost_id')->where('like',1);
    }

    public function dislikes(){
        return $this->hasMany(LikeDislike::class,'userpost_id')->where('dislike',1);
    }
}
