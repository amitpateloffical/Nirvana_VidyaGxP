<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeriousGrid extends Model
{
    use HasFactory;

    protected $table = 'serious_grids';
    protected $casts = ['data' => 'array'];

}
