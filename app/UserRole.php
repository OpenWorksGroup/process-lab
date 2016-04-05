<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    /**
     * A user can have many roles
     *
     * @return $userRoles
     */
    
    public function scopeGetRoles($query, $userId)
    {
        return $query->where('user_id', $userId);
    } 
}
