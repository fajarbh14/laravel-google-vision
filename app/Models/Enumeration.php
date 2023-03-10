<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enumeration extends Model
{
    protected $table    = "enumeration";
    protected $fillable = [
        'key',
        'name',
        'sequence'
    ];
}
