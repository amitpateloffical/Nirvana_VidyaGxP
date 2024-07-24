<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReccomendedActionGrid extends Model
{
    use HasFactory;

protected $fillable = ['root_id','data','identifir'];
protected $casts = ['data'=>'array'];




}
