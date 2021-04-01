<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $withCount = ['posts', 'postReplies'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'reply_email_notification',
        'password',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function socialAuths()
    {
        return $this->hasMany(SocialAuth::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function postReplies()
    {
        return $this->hasMany(PostReply::class);
    }

    public function scopeGlobalSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('name', 'like', $term)
                ->orWhere('username', 'like', $term)
                ->orWhere('email', 'like', $term);
        });
    }

    public function scopeSingleFieldSearch($query, $term, $field)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term, $field) {
            $query->where($field, 'like', $term);
        });
    }
}
