<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retro extends Model
{
    protected $fillable = ['name', 'promotion_id'];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
}
