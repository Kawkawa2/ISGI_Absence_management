<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class section extends Model
{
    use HasFactory;
    // la protection de la base de donnee

    protected $table = 'section';
    protected $fillable = ['id', 'codeSection', 'nomSection', 'nbStagaire', 'Annee', 'id_Filiere'];

    //les relations entre les models

    public function Stagaires()
    {
        return $this->hasMany(Stagaire::class);
    }
    public function ArchiveStagaires()
    {
        return $this->hasMany(archive_stagaire::class);
    }
    public function Filiere()
    {
        return $this->belongsTo(filiere::class);
    }
}
