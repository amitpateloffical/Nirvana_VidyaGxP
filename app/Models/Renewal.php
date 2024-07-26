<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Renewal extends Model
{
    use HasFactory;


    protected $fillable = [
        'manufacturer',
        'trade_name',
        'initiator',
        'date_of_initiation',
        'short_description',
        'assign_to',
        'due_date',
        'documents',
        'Attached Files', 
        'dossier_parts',
        'related_dossier_documents',
        'registration_status',
        'registration_number',
        'planned_submission_date',
        'actual_submission_date',
        'planned_approval_date',
        'actual_approval_date',
        'actual_withdrawn_date',
        'actual_rejection_date',
        'comments',
        'root_parent_trade_name',
        'parent_local_trade_name',
        'renewal_rule',
    ];
}



