<?php

namespace App\Models;

use App\Models\ScopeQueries\RoleScopes;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use RoleScopes;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
