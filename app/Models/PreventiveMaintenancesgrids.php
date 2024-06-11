<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreventiveMaintenancesgrids extends Model
{
    use HasFactory;
    protected $table = 'preventive_maintenances_grids';
    protected $fillable = [
        'dosier_documents_id',
        'identifier',
        'data'
    ];
    protected $casts = [
        'data' => 'array'
    ];
}
