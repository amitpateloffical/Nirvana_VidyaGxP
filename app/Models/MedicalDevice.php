<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalDevice extends Model
{
    use HasFactory;

    protected $table= 'medical-devices';

    protected $fillable = [
        'initiator',
        'date_of_initiation',
        'short_description',
        'type',
        'other_type',
        'assign_to',
        'due_date',
        'URLs',
        'attachment',
        'trade_name',
        'manufacturer',
        'theraPeutic_area',
        'prooduct_code',
        'intended_use',




    ];
}
