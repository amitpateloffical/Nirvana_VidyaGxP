<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingManagementGrid extends Model
{
    use HasFactory;
       protected $table = 'meeting_management_grids';
       protected $casts = ['data' => 'array'];
}
