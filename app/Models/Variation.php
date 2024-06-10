<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    use HasFactory;

    public function variation_grid()
    {
        return $this->hasMany(VariationGrid::class, 'variation_id');
    }
}
