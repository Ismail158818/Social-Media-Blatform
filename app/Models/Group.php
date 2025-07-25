<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $fillable = ['name','description','image','status','status_show'];

    public function post()
    {
        return $this->belongsToMany(Post::class);
    }
    public function comments()
    {
        return $this->belongsToMany(Comment::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('is_admin');
    }
    public function delete_group_services($group_id)
    {
        $group = Group::findOrFail($group_id);
        $group->delete();

    }
}
