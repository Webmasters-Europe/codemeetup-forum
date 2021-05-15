<?php

namespace App\Models;

use App\Models\Upload;
use App\Service\Searchable;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, Searchable, SoftDeletes, SoftCascadeTrait;

    protected $fillable = ['title', 'content'];

    protected $dates = ['deleted_at'];

    protected $softCascade = ['reply', 'uploads'];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reply()
    {
        return $this->hasMany(PostReply::class)->whereNull('parent_id');
    }

    public function uploads()
    {
        return $this->hasMany(Upload::class);
    }
}
