<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalystInterviewGrid extends Model
{
    use HasFactory;
    protected $table = 'analyst_interview_grids';
    protected $fillable = ['analystinterview_id','identifier', 'data'];
    protected $casts = ['data' => 'array'];
}
