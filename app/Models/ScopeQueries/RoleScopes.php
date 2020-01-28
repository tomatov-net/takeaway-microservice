<?php


namespace App\Models\ScopeQueries;


trait RoleScopes
{
    public function scopeGetIdBySlug($q, string $slug): ?int
    {
        $role = $q->where('slug', $slug)->first();
        return $role ? $role->id : null;
    }
}
