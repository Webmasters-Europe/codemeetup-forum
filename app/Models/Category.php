<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SoftCascadeTrait;

    protected $fillable = ['name', 'description'];

    protected $withCount = ['posts', 'postsTrashed'];

    protected $softCascade = ['posts'];

    public function posts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function postsTrashed()
    {
        return $this->hasMany(Post::class)->onlyTrashed();
    }

    public function scopeSearch($query, $term): void
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('name', 'like', $term)
            ->orWhere('description', 'like', $term);
        });
    }

    public function scopeSearchName($query, $term): void
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('name', 'like', $term);
        });
    }

    public function scopeSearchDescription($query, $term): void
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('description', 'like', $term);
        });
    }

    public function latestPost()
    {
        return $this->posts()->latest()->first();
    }
}
