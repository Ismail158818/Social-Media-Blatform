<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * The users that belong to the role.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get role by name
     */
    public static function getByName($name)
    {
        return static::where('name', $name)->first();
    }

    /**
     * Check if role exists
     */
    public static function exists($name)
    {
        return static::where('name', $name)->exists();
    }

    /**
     * Get all available roles
     */
    public static function getAvailableRoles()
    {
        return [
            'superAdmin' => 'Super Administrator',
            'admin' => 'Administrator',
            'coach' => 'Coach',
            'trainee' => 'Trainee'
        ];
    }
}
