<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariationGrid extends Model
{
    use HasFactory;
    protected $table = 'variation_grids';

    protected $casts = [
        'data' => 'array'
    ];
}
