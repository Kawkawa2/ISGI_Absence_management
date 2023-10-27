<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class filieres_modules extends Model
{
    use HasFactory;
    // la protection de la base de donnee

    protected $table = 'filieres_modules';
    protected $primaryKey = 'id';
    protected $fillable = ['filiere_id', 'module_id'];
}
