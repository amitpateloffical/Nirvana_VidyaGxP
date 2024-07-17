<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SupplierAudit extends Model
{
    use HasFactory;

    protected $casts = [
        'due_date' => 'datetime:Y-m-d',
        'created_at'=>'date' // Ensuring date stored in Y-m-d format
    
    ];

    // Mutuator
    public function setAuditDateFormat($value)
    {
        $this->attributes['due_date'] = Carbon::createFromFormat('Y-m-d',$value);
    }

    // Accessor
    public function getAuditDateFormat($value)
    {
        return Carbon::parse($value)->format('d-M-Y');
    }
}

