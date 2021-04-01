<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostReply extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;

    protected $fillable = ['content'];

    protected $softCascade = ['reply'];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
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
