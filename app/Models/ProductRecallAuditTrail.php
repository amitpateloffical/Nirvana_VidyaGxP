<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRecallAuditTrail extends Model
{
    use HasFactory;
    protected $table = "product_recall_audit_trails";
}
