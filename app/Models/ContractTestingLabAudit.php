<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractTestingLabAudit extends Model
{
    use HasFactory;

    protected $casts = [
        'proposal_attachments' => 'array',
        'ctl_audit_report' => 'array',
        'file_attachments_if_any' => 'array',
        'ctl_response_report' => 'array',
        'audit_closure_report' => 'array',
        'response_file_attachments' => 'array',
        'approval_attachments' => 'array',
        'audit_closure_attachments' => 'array'
      ];
}
