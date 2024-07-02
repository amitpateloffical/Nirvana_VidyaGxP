<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupplierAudit;

class SupplierAuditController extends Controller
{
    public function AuditSupplier(){
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view('frontend.New_forms.supplier_audit', compact('due_date', 'record_number'));
        
    }
    public function create(Request $request)
    {
        $data = new SupplierAudit();
        
        $data->initiator = $request->initiator;
        $data->initiator_name = $request->initiator_name;
        $data->intiation_date = $request->intiation_date;
        $data->record = $request->record;
        $data->short_description = $request->short_description;
        $data->assign_to = $request->assign_to;
        $data->due_date = $request->due_date;
        $data->audit_suppllier_as = $request->audit_suppllier_as;
        $data->auditee_supplier = $request->auditee_supplier;
        $data->contract_person = $request->contract_person;
        $data->cro_vendor = $request->cro_vendor;
        $data->priority_list = $request->priority_list;
        $data->manufacturer = $request->manufacturer;
        $data->type = $request->type;
        $data->description = $request->description;
        $data->year = $request->year;
        $data->quarter = $request->quarter;
        $data->file_attachments = $request->file_attachments;
        $data->related_url = $request->related_url;
        $data->zone = $request->zone;
        $data->country = $request->country;
        $data->city = $request->city;
        $data->state_district = $request->state_district;
        $data->scope = $request->scope;
        
        // Second tab
        $data->start_date = $request->start_date;
        $data->end_date = $request->end_date;
        $data->assigned_to = $request->assigned_to;
        $data->cro_vendor_ap = $request->cro_vendor_ap;
        $data->date_response_due = $request->date_response_due;
        $data->co_auditors = $request->co_auditors;
        $data->distribution_list = $request->distribution_list;
        $data->scope_ap = $request->scope_ap;
        $data->comments_ap = $request->comments_ap;
        
        // Third tab
        $data->actual_start_date = $request->actual_start_date;
        $data->actual_end_date = $request->actual_end_date;
        $data->executive_summary = $request->executive_summary;
        $data->audit_result = $request->audit_result;
        $data->date_of_response = $request->date_of_response;
        $data->fileattachment_as = $request->fileattachment_as;
        $data->response_summary = $request->response_summary;
        // $data->form_type = $request->form_type;

        // dd($data);
        $data->save();

        return redirect()->route('supplier_audit.index')->with('success', 'Audit created successfully.');


}
}
