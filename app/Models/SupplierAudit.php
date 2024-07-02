<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierAudit extends Model
{
    use HasFactory;
    protected $table='supplier_audit';


    protected $fillable=[
        'initiator',
        'initiator_name',
        'intiation_date',
        'form_type',
        'record',
        'short_description',
        'assign_to',
        'due_date',
        'audit_suppllier_as',
        'auditee_supplier',
        'contract_person',
        'cro_vendor',
        'priority_list',
        'manufacturer',
        'type',
        'description',
        'year',
        'quarter',
        'file_attachments',
        'related_url',
        'zone',
        'country',
        'city',
        'state_district',
        'scope',
        // second tab

        'start_date',             // For Scheduled start Date
        'end_date',               // For Scheduled end Date
        'assigned_to',            // For Assigned To
        'cro_vendor_ap',             // For CRO/Vendor
        'date_response_due',      // For Date response due
       'co_auditors',            // For Co-Auditors
        'distribution_list',      // For Distribution List
        'scope_ap',                  // For Scope
        'comments_ap' ,
        // third tab
        'actual_start_date',       // For Actual start Date
        'actual_end_date',         // For Actual end Date
        'executive_summary',       // For Executive Summary
        'audit_result',            // For Audit Result
        'date_of_response',        // For Date of Response
        'fileattachment_as',        // For File Attachments
        'response_summary' ,        // For Response Summary

    ];
}
