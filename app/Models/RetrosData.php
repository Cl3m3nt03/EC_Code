<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RetrosData extends Model
{
    protected $table = 'retros_data';

    protected $fillable = [
        'column_id',
        'name',
        'description',
    ];

    public function column()
    {
        return $this->belongsTo(RetrosColumns::class, 'column_id');
    }
}
