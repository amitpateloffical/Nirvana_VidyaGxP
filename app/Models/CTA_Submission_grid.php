<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CTA_Submission_grid extends Model
{
    use HasFactory;
    protected $table = 'c_t_a__submission_grids';
    protected $fillable = [
        'c_id',
        'identifer', 
        'data',
    ];
    protected $casts = [ 'data' => 'array' ];
}
