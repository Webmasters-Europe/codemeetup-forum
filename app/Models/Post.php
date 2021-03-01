<?php

namespace App\Models;

use App\Traits\SelfReferenceTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    use SelfReferenceTrait;

    protected $fillable = ['title', 'content', 'user_id', 'category_id'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
