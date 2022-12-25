<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Comment;
use App\Models\post;

class notification extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'post_id',
        'comment_id',
        'user_id',
    ];

    // protected $hidden = ['created_at','updated_at',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}