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

    protected $withCount = ['reply', 'repliesTrashed'];

    public function repliesTrashed()
    {
        return $this->hasMany(PostReply::class)->whereNull('parent_id')->onlyTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reply(): \Illuminate\Database\Query\Builder
    {
        return $this->hasMany(PostReply::class)->whereNull('parent_id');
    }

    public function uploads(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Upload::class);
    }

    public function scopeSearch($query, $term): void
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('title', 'like', $term)
                ->orWhere('content', 'like', $term);
        });
    }

    public function scopeSearchTitle($query, $term): void
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('title', 'like', $term);
        });
    }

    public function scopeSearchContent($query, $term): void
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('content', 'like', $term);
        });
    }
}
