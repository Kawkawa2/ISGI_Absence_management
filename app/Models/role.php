<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    use HasFactory;

    // la protection de la base de donnee

    protected $table = 'role';
    protected $primaryKey = 'id';
    protected $fillable = ['role'];

    // les relations entre models

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
