<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class module extends Model
{
    use HasFactory;
    // la protection de la base de donnee

    protected $table = 'module';
    protected $primaryKey = 'id';
    protected $fillable = ['libelleModule', 'MH_total', 'MH_Presentiel', 'MH_Distentiel', 'niveau', 'semestre'];

    // la relation entre models

    public function Filieres()
    {
        return $this->belongsToMany(filiere::class, 'filieres_modules')->wherePivot('filiere_id');
    }
    public function Absences()
    {
        return $this->hasMany(absence::class, 'id_absence', 'id');
    }
    public function Retards()
    {
        return $this->hasMany(retard::class, 'id_retard', 'id');
    }
}
