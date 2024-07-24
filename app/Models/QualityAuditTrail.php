<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityAuditTrail extends Model
{
    use HasFactory;
    protected $table = 'quality_audit_trails';
}
