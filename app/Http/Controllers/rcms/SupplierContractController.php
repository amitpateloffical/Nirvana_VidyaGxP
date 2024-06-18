<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupplierContract;
use App\Models\SupplierContractGrid;
use App\Models\RoleGroup;
use App\Models\SupplierContractAuditTrail;
use App\Models\User;
use App\Models\RecordNumber;
use Helpers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SupplierContractController extends Controller
{
    public function supplierContract()
    {

        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);

        $division = QMSDivision::where('name', Helpers::getDivisionName(session()->get('division')))->first();

        if ($division) {
            $last_supplier_contract = SupplierContract::where('division_id', $division->id)->latest()->first();

            if ($last_supplier_contract) {
                $record_number = $last_supplier_contract->record_number ? str_pad($last_supplier_contract->record_number->record_number + 1, 4, '0', STR_PAD_LEFT) : '0001';
            } else {
                $record_number = '0001';
            }
        }
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view("frontend.New_forms.supplier_contract", compact('due_date', 'record_number'));

    }

    public function supplier_contract_store(Request $request)
    {
        if (!$request->short_description) {
            toastr()->error("Short description is required");
              return redirect()->back();
         }
         
         $supplier_contract = new SupplierContract();
         $supplier_contract->form_type = "Supplier-Contract";
         $supplier_contract->originator_id = Auth::user()->name;
         $supplier_contract->record = ((RecordNumber::first()->value('counter')) + 1);
         $supplier_contract->initiator_id = Auth::user()->id;
         $supplier_contract->intiation_date = $request->intiation_date;
         $supplier_contract->short_description = $request->short_description;
         $supplier_contract->assigned_to = $request->assigned_to;
         $supplier_contract->due_date = $request->due_date;
         $supplier_contract->supplier_list = $request->supplier_list;
         $supplier_contract->distribution_list = $request->distribution_list;
         $supplier_contract->description = $request->description;
         $supplier_contract->manufacturer = $request->manufacturer;
         $supplier_contract->priority_level = $request->priority_level;
         $supplier_contract->country = $request->country;
         $supplier_contract->city = $request->city;
         $supplier_contract->state_district = $request->state_district;
         $supplier_contract->type = $request->type;
         $supplier_contract->zone = $request->zone;
         $supplier_contract->other_type = $request->other_type;

         if (!empty($request->file_attachments)){
            $files = [];
            if ($request->hasfile('file_attachments')){
                foreach ($request->file('file_attachments') as $file){
                    $name = $request->name . 'file_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/',$name);
                    $files[] = $name;
                }
            }
            $supplier_contract->file_attachments = json_encode($files);
         }

         $supplier_contract->actual_start_date = $request->actual_start_date;
         $supplier_contract->actual_end_date = $request->actual_end_date;
         $supplier_contract->negotiation_team = $request->negotiation_team;
         $supplier_contract->comments = $request->comments;

         $supplier_contract->status = 'Opened';
         $supplier_contract->stage = 1;
         $supplier_contract->save();

         $data = new SupplierContractGrid();
         $data->supplier_contract_id = $supplier_contract->id;
         $data->type = "Financial Transaction";
         if (!empty($request->transaction)){
            $data->transaction = serialize($request->transaction);
         }
         if (!empty($request->transaction_type)){
            $data->transaction_type = serialize($request->transaction_type);
         }
         if (!empty($request->date)){
            $data->date = serialize($request->date);
         }
         if (!empty($request->amount)){
            $data->amount = serialize($request->amount);
         }
         if (!empty($request->currency_used)){
            $data->currency_used = serialize($request->currency_used);
         }
         if (!empty($request->remarks)){
            $data->remarks = serialize($request->remarks);
         }
         $data->save();

         
        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();

        $history = new SupplierContractAuditTrail();
        $history->supplier_contract_id = $supplier_contract->id;
        $history->activity_type = 'Assigned To';
        $history->previous = "Null";
        $history->current = $supplier_contract->assigned_to;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $supplier_contract->status;
        $history->save();


        $history = new SupplierContractAuditTrail();
        $history->supplier_contract_id = $supplier_contract->id;
        $history->activity_type = 'Short Description';
        $history->previous = "Null";
        $history->current = $supplier_contract->short_description;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $supplier_contract->status;
        $history->save();

        $history = new SupplierContractAuditTrail();
        $history->supplier_contract_id = $supplier_contract->id;
        $history->activity_type = 'Supplier List';
        $history->previous = "Null";
        $history->current = $supplier_contract->supplier_list;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $supplier_contract->status;
        $history->save();


        if (!empty($supplier_contract->due_date)) {
            $history = new SupplierContractAuditTrail();
            $history->supplier_contract_id = $supplier_contract->id;
            $history->activity_type = 'Due Date';
            $history->previous = "Null";
            $history->current = $supplier_contract->due_date;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier_contract->status;
            $history->save();
            }
         
         toastr()->success("Record is created Successfully");
         return redirect(url('rcms/qms-dashboard'));
    }

    public function supplier_contract_update(Request $request, $id)
    {
        if (!$request->short_description) {
            toastr()->error("Short description is required");
              return redirect()->back();
         }

         $supplier_contract = SupplierContract::find($id);
        //  $supplier_contract->originator_id = Auth::user()->name;
        //  $supplier_contract->initiator_id = Auth::user()->id;
         $supplier_contract->intiation_date = $request->intiation_date;
         $supplier_contract->short_description = $request->short_description;
         $supplier_contract->assigned_to = $request->assigned_to;
         $supplier_contract->due_date = $request->due_date;
         $supplier_contract->supplier_list = $request->supplier_list;
         $supplier_contract->distribution_list = $request->distribution_list;
         $supplier_contract->description = $request->description;
         $supplier_contract->manufacturer = $request->manufacturer;
         $supplier_contract->priority_level = $request->priority_level;
         $supplier_contract->country = $request->country;
         $supplier_contract->city = $request->city;
         $supplier_contract->state_district = $request->state_district;
         $supplier_contract->type = $request->type;
         $supplier_contract->zone = $request->zone;
         $supplier_contract->other_type = $request->other_type;

         if (!empty($request->file_attachments)){
            $files = [];
            if ($request->hasfile('file_attachments')){
                foreach ($request->file('file_attachments') as $file){
                    $name = $request->name . 'file_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/',$name);
                    $files[] = $name;
                }
            }
            $supplier_contract->file_attachments = json_encode($files);
         }

         $supplier_contract->actual_start_date = $request->actual_start_date;
         $supplier_contract->actual_end_date = $request->actual_end_date;
         $supplier_contract->negotiation_team = $request->negotiation_team;
         $supplier_contract->comments = $request->comments;

         $supplier_contract->status = 'Opened';
         $supplier_contract->stage = 1;
         $supplier_contract->save();

         $data = SupplierContractGrid::find($id);
        //  $data->supplier_contract_id = $supplier_contract->id;
         if (!empty($request->transaction)){
            $data->transaction = serialize($request->transaction);
         }
         if (!empty($request->transaction_type)){
            $data->transaction_type = serialize($request->transaction_type);
         }
         if (!empty($request->date)){
            $data->date = serialize($request->date);
         }
         if (!empty($request->amount)){
            $data->amount = serialize($request->amount);
         }
         if (!empty($request->currency_used)){
            $data->currency_used = serialize($request->currency_used);
         }
         if (!empty($request->remarks)){
            $data->remarks = serialize($request->remarks);
         }
         $data->update();
        $supplier_contract->update();

        toastr()->success("Record is update Successfully");
        return back();

    }

    public function supplier_contract_show($id)
    {
        $data = SupplierContract::find($id);
        if(empty($data)) {
            toastr()->error('Invalid ID.');
            return back();
        }
        $data->record = str_pad($data->record, 4, '0', STR_PAD_LEFT);
        $data->assign_to_name = User::where('id', $data->assigned_to)->value('name');
        $data->initiator_name = User::where('id', $data->initiator_id)->value('name');
        return view('frontend.supplier-contract.supplier_contract_view', compact('data'));

    }

    public function supplier_contract_send_stage(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $supplier = SupplierContract::find($id);
            $lastDocument =  SupplierContract::find($id);

            if ($supplier->stage == 1) {
                $supplier->stage = "2";
                $supplier->status = 'Qualification In Progress';
                $supplier->submit_supplier_details_by = Auth::user()->name;
                $supplier->submit_supplier_details_on = Carbon::now()->format('d-M-Y');
                $history = new SupplierContractAuditTrail();
                $history->supplier_contract_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->submit_supplier_details_by;
                $history->current = $supplier->submit_supplier_details_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='Submitted';

                $history->save();
                $supplier->update();
                toastr()->success('Document Sent');
                return back();
        }

        if ($supplier->stage == 2) {
            $supplier->stage = "3";
            $supplier->status = 'Pending Supplier Audit';
            $supplier->qualification_complete_by = Auth::user()->name;
            $supplier->qualification_complete_on = Carbon::now()->format('d-M-Y');
            $history = new SupplierContractAuditTrail();
            $history->supplier_contract_id = $id;
            $history->activity_type = 'Activity Log';
            $history->previous = $lastDocument->qualification_complete_by;
            $history->current = $supplier->qualification_complete_by;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->stage='Qualification Completed';

            $history->save();
            $supplier->update();
            toastr()->success('Document Sent');
            return back();
    }

    if ($supplier->stage == 3) {
        $supplier->stage = "4";
        $supplier->status = 'Supplier Approved';
        $supplier->audit_passed_by = Auth::user()->name;
        $supplier->audit_passed_on = Carbon::now()->format('d-M-Y');
        $history = new SupplierContractAuditTrail();
        $history->supplier_contract_id = $id;
        $history->activity_type = 'Activity Log';
        $history->previous = $lastDocument->audit_passed_by;
        $history->current = $supplier->audit_passed_by;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->stage='Audit Passed';

        $history->save();
        $supplier->update();
        toastr()->success('Document Sent');
        return back();
    }

    if ($supplier->stage == 4) {
        $supplier->stage = "6";
        $supplier->status = 'Obselete';
        $supplier->supplier_obsolete_by = Auth::user()->name;
        $supplier->supplier_obsolete_on = Carbon::now()->format('d-M-Y');
        $history = new SupplierContractAuditTrail();
        $history->supplier_contract_id = $id;
        $history->activity_type = 'Activity Log';
        $history->previous = $lastDocument->supplier_obsolete_by;
        $history->current = $supplier->supplier_obsolete_by;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->stage='Obselete';

        $history->save();
        $supplier->update();
        toastr()->success('Document Sent');
        return back();
    }

    if ($supplier->stage == 5) {
        $supplier->stage = "6";
        $supplier->status = 'Obselete';
        $supplier->supplier_obsolete_by = Auth::user()->name;
        $supplier->supplier_obsolete_on = Carbon::now()->format('d-M-Y');
        $history = new SupplierContractAuditTrail();
        $history->supplier_contract_id = $id;
        $history->activity_type = 'Activity Log';
        $history->previous = $lastDocument->supplier_obsolete_by;
        $history->current = $supplier->supplier_obsolete_by;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->stage='Obselete';

        $history->save();
        $supplier->update();
        toastr()->success('Document Sent');
        return back();
    }

    }else {
        toastr()->error('E-signature Not match');
        return back();
    }

    }

    public function supplier_contract_Cancle(Request $request, $id)
    {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $supplier = SupplierContract::find($id);
            $lastDocument =  SupplierContract::find($id);
            $data =  SupplierContract::find($id);
            
            
            if ($supplier->stage == 1) {
                $supplier->stage = "0";
                $supplier->status = "Closed - Cancelled";
                $supplier->update();
                toastr()->success('Document Sent');
                return back();
            }
            $history = new SupplierAuditTrial();
            $history->supplier_id = $id;
            $history->activity_type = 'Activity Log';
            $history->previous = $lastDocument->cancelled_by;
            $history->current = $supplier->cancelled_by;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->stage='Cancelled';
            $history->save();

            $supplier->update();
            $history = new SupplierContractHistory();
            $history->type = "Supplier Contract";
            $history->doc_id = $id;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->stage_id = $supplier->stage;
            $history->status = $supplier->status;
            $history->save();
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }

    }

    public function supplier_audit_failed(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $supplier = SupplierContract::find($id);
            $lastDocument =  SupplierContract::find($id);

            if ($supplier->stage == 3) {
                $supplier->stage = "5";
                $supplier->status = 'Pending Rejection';
                $supplier->audit_failed_by = Auth::user()->name;
                $supplier->audit_failed_on = Carbon::now()->format('d-M-Y');
                $history = new SupplierContractAuditTrail();
                $history->supplier_contract_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->audit_failed_by;
                $history->current = $supplier->audit_failed_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='Audit Failed';
        
                $history->save();
                $supplier->update();
                toastr()->success('Document Sent');
                return back();
            }
        }
        else {
            toastr()->error('E-signature Not match');
            return back();
        }


    }

    public function supplier_contract_reject(Request $request, $id)
    {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $supplier = SupplierContract::find($id);

            if ($supplier->stage == 4) {
                $supplier->stage = "3";
                $supplier->status = "Pending Supplier Audit";
                $supplier->update();

                toastr()->success('Document Sent');
                return back();
            }

            if ($supplier->stage == 5) {
                $supplier->stage = "3";
                $supplier->status = "Pending Supplier Audit";
                $supplier->update();

                toastr()->success('Document Sent');
                return back();
            }
        }
        else {
            toastr()->error('E-signature Not match');
            return back();
        }

    }

    public function supplierContractAuditTrail($id)
    {
        $audit = SupplierContractAuditTrail::where('supplier_contract_id', $id)->orderByDESC('id')->get()->unique('activity_type');
        $today = Carbon::now()->format('d-m-y');
        $document = SupplierContract::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');

        return view("frontend.supplier-contract.supplier_contract_audit_trail", compact('audit', 'document', 'today'));

    }

    public function singleReport($id)
    {

    }

    public static function auditReport($id)
    {

    }
}
