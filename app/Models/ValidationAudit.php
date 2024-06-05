<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidationAudit extends Model
{
    use HasFactory;

    protected $table = 'validation_audit_trails';

}
