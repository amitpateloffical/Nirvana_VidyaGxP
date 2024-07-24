<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicalSiteGrids extends Model
{
    use HasFactory;
    protected $table ='clinical_site_grids';
    protected $fillable = [
        'mc_id',
        'identifiers',
        'data'
        ];
        protected $casts = [
            'data' => 'array'
            // 'aainfo_product_name' => 'array',
               ];
    

}
