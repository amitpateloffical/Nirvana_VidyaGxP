<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NationalApprovalGrid extends Model
{
    use HasFactory;

    protected $fillable = [
        'primary_packaging', 
        'material', 
        'pack_size', 
        'shelf_life', 
        'storage_condition', 
        'secondary_packaging', 
        'remarks'
    ];
}
