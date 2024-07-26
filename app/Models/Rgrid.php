<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rgrid extends Model
{
    use HasFactory;
    protected $table = 'rgrids';

    protected $fillable = ['renewal_id','data','identifir'];

    protected $casts = ['data' => 'array'];

}
