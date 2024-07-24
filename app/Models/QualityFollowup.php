<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityFollowup extends Model
{
    use HasFactory;

    protected $table = 'quality_followups';

    protected $fillable = [
        'due_date',
        'scheduled_start_date',
'scheduled_end_date'
    ];

    protected $casts = [
        'due_date' => 'date',
        'scheduled_start_date'=> 'date',
        'scheduled_end_date'=> 'date',

    ];






}
