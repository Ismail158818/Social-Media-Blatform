<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'group_id',
        'status',
        'image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function Reports()
    {
        return $this->hasMany(Report::class);
    }
    public function usersRatings()
    {
        return $this->belongsToMany(User::class, 'ratings')->withPivot('type')->withTimestamps();
    }
    public function authedRating()
    {
        return $this->belongsToMany(User::class, 'ratings')->where('user_id', auth()->id())->withPivot('type')->withTimestamps();
    }
    public function getAuthedRatingAttribute()
    {
        return $this->authedRating()->first();
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
