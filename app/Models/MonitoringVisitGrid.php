<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringVisitGrid extends Model
{
    use HasFactory;

    protected $table = 'monitoring_visit_grids';

    protected $casts = ['data' => 'array'];
}
