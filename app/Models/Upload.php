<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Upload extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;

    protected $fillable = ['filename'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
