<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupeUser extends Model
{
    use HasFactory;

    protected $table = 'groupe_user';

    protected $fillable = ['user_id', 'groupe_id', 'promotion_id'];
}