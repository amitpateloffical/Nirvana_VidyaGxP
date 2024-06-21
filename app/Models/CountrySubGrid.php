<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountrySubGrid extends Model
{
    use HasFactory;
    protected $table = 'country_sub_grids';
    protected $casts = ['data' => 'array'];
}
