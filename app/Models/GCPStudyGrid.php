<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GCPStudyGrid extends Model
{
    use HasFactory;

    protected $table = 'g_c_p_study_grids';
    // protected $fillable = ['useridentifier', 'data'];
    protected $casts = ['data' => 'array'];
}
