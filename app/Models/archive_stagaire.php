<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class archive_stagaire extends Model
{
    use HasFactory;
    // la protection de la base de donnee
    protected $table = 'archive_stagaire';
    protected $primaryKey = 'id';
    protected $fillable = ['nom', 'prenom', 'date_naissance', 'cin', 'genre', 'adresse', 'tele', 'email', 'photo', 'date_inscription', 'noteComportement', 'noteAssiduite', 'anneeBac', 'moyenBac', 'mentionBac', 'autreDiplome','id_Section'];

    // les relations entre les modeles

    public function Absences()
    {
        return $this->hasMany(absence::class);
    }

    public function Retards()
    {
        return $this->hasMany(retard::class);
    }
    public function Section()
    {
        return $this->belongsTo(section::class);
    }

}
