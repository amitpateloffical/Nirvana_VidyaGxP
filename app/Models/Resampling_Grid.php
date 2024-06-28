<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resampling_Grid extends Model
{
    use HasFactory;
    protected $table = 'resampling__grids';
    protected $fillable = ['resampling_id','identifier', 'data'];
    protected $casts = ['data' => 'array'];


}
    // protected $table = 'incident_investigation_report';
    // protected $fillable = ['labincident_id','useridentifier', 'data'];
    // protected $casts = ['data' => 'array'];

    // public function labincident()
    // {
    //     return $this->belongsTo(LabIncident::class,'labincident_id ');
    // }

