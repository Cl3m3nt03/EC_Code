<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RetrosColumns extends Model
{
    protected $fillable = ['retro_id', 'name'];

    public function retro()
    {
        return $this->belongsTo(Retro::class);
    }

    public function data()
    {
        return $this->hasMany(RetrosData::class, 'column_id');
    }
}
