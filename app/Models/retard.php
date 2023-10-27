<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class retard extends Model
{
    use HasFactory;
    //  la protection de la base de donnee
    protected $table = 'retard';
    protected $primaryKey = 'id';
    protected $fillable = ['seance', 'typeSeance', 'id_Stagaire', 'id_Formateur', 'id_Module'];

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
   
}
