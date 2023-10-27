<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class absence extends Model
{
    use HasFactory;
    //  la protection de la base de donnee
    protected $table = 'absence';
    protected $primaryKey = 'id';
    protected $fillable = ['type', 'seance', 'typeSeance', 'dateJsf', 'nbJoursJsf', 'noteReduit', 'id_Stagaire', 'id_Formateur', 'id_Module'];

    // les relations entre les models

    public function Stagaire()
    {
        return $this->belongsTo(stagaire::class);
    }
    public function ArchiveStagaire()
    {
        return $this->belongsTo(archive_stagaire::class);
    }
    public function Formateur()
    {
        return $this->belongsTo(formateur::class);
    }
    public function Module()
    {
        return $this->belongsTo(module::class);
    }
    public function abs_jstf_sanc()
    {
        return $this->hasOne(abs_jstf_sanc::class);
    }
}
