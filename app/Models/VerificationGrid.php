<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationGrid extends Model
{
    use HasFactory;
    protected $table = 'verification_grids';
    protected $fillable = ['verification_id','identifier', 'data'];
    protected $casts = ['data' => 'array'];

}
