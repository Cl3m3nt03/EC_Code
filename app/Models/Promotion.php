<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    public function groupes() {
        return $this->hasMany(Groupe::class);
    }
    
    public function users() {
        return $this->hasMany(User::class);
    }
}
