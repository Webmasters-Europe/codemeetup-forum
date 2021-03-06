<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostReply extends Model
{
    use HasFactory;

    protected $fillable = ['content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function reply()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function recursiveReplies()
    {
        return $this->reply()->with('recursiveReplies');
    }
}
