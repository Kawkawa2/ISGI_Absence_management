<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class filiere extends Model
{
    use HasFactory;
    // la protection de la base de donnee

    protected $table = 'filiere';
    protected $primaryKey = 'id';
    protected $fillable = ['codeFiliere', 'nomFiliere', 'option', 'typeFormation', 'niveau', 'duree'];

    //les relations entre les models

    public function Sections()
    {
        return $this->hasMany(section::class);
    }
    public function Modules()
    {
        return $this->belongsToMany(module::class, 'filieres_modules')->wherePivot('module_id');
    }
}
