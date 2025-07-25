<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportGroup extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','note','group_id'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
