<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reccomended_action extends Model
{
    use HasFactory;

    protected $casts = [
        'data' => 'array',  // Assuming 'data' is a JSON field or similar
        'mfg_date' => 'date', // If 'mfg_date' is a field
    ];
}
