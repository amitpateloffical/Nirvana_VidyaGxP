<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalTestingGrid extends Model
{
    use HasFactory;
    protected $table = 'additional_testing_grids';
    protected $fillable = ['additional_testing_id', 'identifier', 'data'];
    protected $casts = ['data' => 'array'];
}
