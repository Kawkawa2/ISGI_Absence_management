<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class justification extends Model
{
    use HasFactory;
    protected $table = 'justification';
    protected $primaryKey = 'id';
    protected $fillable = ['libelleJsf'];

}
