<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EhsEventGrid extends Model
{
    use HasFactory;
    protected $table = 'ehs_event_grids';

    protected $fillable = ['ci_id' , 'identifier','data'];

    protected $casts = ['data'=>'array'];
}
