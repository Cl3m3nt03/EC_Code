<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    protected $fillable = ['nom', 'promotion_id'];

    public function promotion() {
        return $this->belongsTo(Promotion::class);
    }
    
    public function users()
{
    return $this->belongsToMany(User::class)
                ->withPivot('promotion_id')
                ->withTimestamps();
}

}
