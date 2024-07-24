<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CTAAmendement extends Model
{
    use HasFactory;

    protected $casts = [
        'attached_files' => 'array',
      ];
}
