<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AnalystInterviewAuditTrail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'analyst_interview_audit_trails';
}
