<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class formateur extends Model
{
    use HasFactory;

    // la protection de la base de donnee 
    protected $table = 'formateur';
    protected $primaryKey = 'id';
    protected $fillable = ['nom', 'prenom', 'email', 'cin', 'tele', 'adresse', 'photo'];

    // les relations entre models

    public function Absences()
    {
        return $this->hasMany(Absence::class);
    }
    public function Retards()
    {
        return $this->hasMany(retard::class);
    }
}
