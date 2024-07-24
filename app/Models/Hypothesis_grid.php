<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hypothesis_grid extends Model
{
    use HasFactory;
    protected $table = 'hypothesis_grids';

    protected $fillable = ['hypothesis_id','data','identifier'];

    protected $casts = ['data' => 'array'];
}
