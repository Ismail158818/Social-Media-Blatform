<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utag extends Model
{
    use HasFactory;

    protected $fillable = ['tag_name','user_id'];}
