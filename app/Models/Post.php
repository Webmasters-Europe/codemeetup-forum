<?php

namespace App\Models;

use App\Models\Upload;
use App\Service\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['title', 'content'];

    protected $dates = ['deleted_at'];

    protected $appends = ['replyCount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reply()
    {
        return $this->hasMany(PostReply::class)->whereNull('parent_id');
    }

    public function getReplyCountAttribute()
    {
        $replies = $this->reply()->where('parent_id', null);

        return $replies->count();
    }

    public function uploads()
    {
        return $this->hasMany(Upload::class);
    }
}
