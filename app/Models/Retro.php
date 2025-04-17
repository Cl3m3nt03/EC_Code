<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retro extends Model
{
    protected $fillable = ['name', 'promotion_id', 'creator_id']; // <= ajoute creator_id

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function columns()
    {
        return $this->hasMany(RetrosColumns::class, 'retro_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
