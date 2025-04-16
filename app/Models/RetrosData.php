<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RetrosData extends Model
{
    protected $fillable = ['column_id', 'name'];

    public function column()
    {
        return $this->belongsTo(RetrosColumns::class, 'column_id');
    }
}
