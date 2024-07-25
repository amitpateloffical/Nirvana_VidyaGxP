<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientInquiryGrid extends Model
{
    use HasFactory;

    protected $table = 'client_inquiry_grids';
    protected $casts = ['data' => 'array'];
}
