<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class abs_jstf_sanc extends Model
{
    use HasFactory;
    protected $table = 'abs_jstf_sancs';

    public function absence()
    {
        return $this->belongsTo(Absence::class);
    }

    public function justification()
    {
        return $this->belongsTo(Justification::class);
    }

    public function natureSanction()
    {
        return $this->belongsTo(NatureSanction::class);
    }
}
