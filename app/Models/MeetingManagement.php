<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingManagement extends Model
{
    use HasFactory;
     protected $table = 'meeting_management';
    protected $casts = ['data' => 'array'];
}
