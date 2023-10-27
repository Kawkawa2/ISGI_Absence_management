<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nature_sanction extends Model
{
    use HasFactory;
    protected $table = 'nature_sanction';
    protected $primaryKey = 'id';
    protected $fillable = ['libelleSanc', 'points_Reduits', 'sanction', 'autorite_decision'];
    // public function Absence()
    // {
    //     return $this->belongsTo(absence::class, 'abs_jstf_sanc');
    // }
}
