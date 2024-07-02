<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\RoleGroup;
use App\Models\RecordNumber;
use App\Models\SupplierHistory;
use App\Models\User;
use App\Models\SupplierAuditTrial;
use Carbon\Carbon;
use Helpers;
use PDF;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class SupplierController extends Controller
{
    public function supplier()
    {   
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view("frontend.supplierObservation.supplier-observation", compact('due_date', 'record_number'));
    }

    public function supplier_store(Request $request)
    {
        if (!$request->short_description) {
            toastr()->error("Short description is required");
              return redirect()->back();
         }


         $supplier = new Supplier();
         $supplier->form_type_new = "Supplier-Observation";
         $supplier->originator_id = Auth::user()->name;
         $supplier->record = ((RecordNumber::first()->value('counter')) + 1);
         $supplier->initiator_id = Auth::user()->id;
         $supplier->intiation_date = $request->intiation_date;
         $supplier->short_description =($request->short_description);
         $supplier->assigned_to = $request->assigned_to;
         $supplier->assign_to = $request->assign_to;
         $supplier->due_date = $request->due_date;
         $supplier->criticality = $request->criticality;
         $supplier->priority_level = $request->priority_level;
         $supplier->auditee = $request->auditee;
         $supplier->contact_person = $request->contact_person;
         $supplier->descriptions = $request->descriptions;

         if (!empty($request->attached_file)){
            $files = [];
            if ($request->hasfile('attached_file')){
                foreach ($request->file('attached_file') as $file){
                    $name = $request->name . 'attached_file' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/',$name);
                    $files[] = $name;
                }
            }
            $supplier->attached_file = json_encode($files);
         }

         if (!empty($request->attached_picture)){
            $files = [];
            if ($request->hasfile('attached_picture')){
                foreach ($request->file('attached_picture') as $file){
                    $name = $request->name . 'attached_picture' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/',$name);
                    $files[] = $name;
                }
            }
            $supplier->attached_picture = json_encode($files);
         }

         $supplier->manufacturer = $request->manufacturer;
         $supplier->type = $request->type;
         $supplier->product = $request->product;
         
         $supplier->proposed_actions = $request->proposed_actions;
         $supplier->comments = $request->comments;
         $supplier->impact = $request->impact;
         $supplier->impact_analysis = $request->impact_analysis;
         $supplier->severity_rate = $request->severity_rate;
         $supplier->occurence = $request->occurence;
         $supplier->detection = $request->detection;
         $supplier->rpn = $request->rpn;
         
         $supplier->status = 'Opened';
         $supplier->stage = 1;
         $supplier->save();

         
         $record = RecordNumber::first();
         $record->counter = ((RecordNumber::first()->value('counter')) + 1);
         $record->update(); 


        if (!empty($supplier->originator_id)) {
            $history = new SupplierAuditTrial();
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Initiated By';
            $history->previous = "Null";
            $history->current = $supplier->originator_id;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($supplier->short_description)) {
            $history = new SupplierAuditTrial();
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Null";
            $history->current = $supplier->short_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($supplier->criticality)) {
            $history = new SupplierAuditTrial();
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Criticality';
            $history->previous = "Null";
            $history->current = $supplier->criticality;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($supplier->priority_level)) {
            $history = new SupplierAuditTrial();
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Priority Level';
            $history->previous = "Null";
            $history->current = $supplier->priority_level;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($supplier->auditee)) {
            $history = new SupplierAuditTrial();
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Auditee';
            $history->previous = "Null";
            $history->current = $supplier->auditee;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($supplier->contact_person)) {
            $history = new SupplierAuditTrial();
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Contact Person';
            $history->previous = "Null";
            $history->current = $supplier->contact_person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($supplier->due_date)) {
            $history = new SupplierAuditTrial();
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Due Date';
            $history->previous = "Null";
            $history->current = $supplier->due_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($supplier->assigned_to)) {
            $history = new SupplierAuditTrial();
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Assigned To';
            $history->previous = "Null";
            $history->current = $supplier->assigned_to;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($supplier->descriptions)) {
            $history = new SupplierAuditTrial();
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Descriptions';
            $history->previous = "Null";
            $history->current = $supplier->descriptions;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($supplier->attached_file)) {
            $history = new SupplierAuditTrial();
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Attached File';
            $history->previous = "Null";
            $history->current = $supplier->attached_file;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($supplier->attached_picture)) {
            $history = new SupplierAuditTrial();
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Attached Picture';
            $history->previous = "Null";
            $history->current = $supplier->attached_picture;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($supplier->Manufacturer)) {
            $history = new SupplierAuditTrial();
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Manufacturer';
            $history->previous = "Null";
            $history->current = $supplier->manufacturer;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($supplier->type)) {
            $history = new SupplierAuditTrial();
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Type';
            $history->previous = "Null";
            $history->current = $supplier->type;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($supplier->product)) {
            $history = new SupplierAuditTrial();
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Product';
            $history->previous = "Null";
            $history->current = $supplier->product;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($supplier->proposed_actions)) {
            $history = new SupplierAuditTrial();
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Proposed Actions';
            $history->previous = "Null";
            $history->current = $supplier->proposed_actions;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($supplier->comments)) {
            $history = new SupplierAuditTrial();
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Comments';
            $history->previous = "Null";
            $history->current = $supplier->comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($supplier->impact)) {
            $history = new SupplierAuditTrial();
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Impact';
            $history->previous = "Null";
            $history->current = $supplier->impact;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($supplier->impact_analysis)) {
            $history = new SupplierAuditTrial();
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Impact Analysis';
            $history->previous = "Null";
            $history->current = $supplier->impact_analysis;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($supplier->severity_rate)) {
            $history = new SupplierAuditTrial();
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Severity Rate';
            $history->previous = "Null";
            $history->current = $supplier->severity_rate;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($supplier->occurence)) {
            $history = new SupplierAuditTrial();
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Occurence';
            $history->previous = "Null";
            $history->current = $supplier->occurence;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($supplier->detection)) {
            $history = new SupplierAuditTrial();
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Detection';
            $history->previous = "Null";
            $history->current = $supplier->detection;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($supplier->rpn)) {
            $history = new SupplierAuditTrial();
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'RPN';
            $history->previous = "Null";
            $history->current = $supplier->rpn;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

         toastr()->success("Record is created Successfully");
         return redirect(url('rcms/qms-dashboard'));

    }

    public function supplier_update(Request $request, $id)
    {

        if (!$request->short_description) {
            toastr()->error("Short description is required");
              return redirect()->back();
         }
         
        $lastData =  Supplier::find($id);
        $supplier =  Supplier::find($id);

        $supplier->intiation_date = $request->intiation_date;
        $supplier->short_description =($request->short_description);
        $supplier->assigned_to = $request->assigned_to;
        $supplier->due_date = $request->due_date;
        $supplier->criticality = $request->criticality;
        $supplier->priority_level = $request->priority_level;
        $supplier->auditee = $request->auditee;
        $supplier->assign_to = $request->assign_to;
        $supplier->contact_person = $request->contact_person;
        $supplier->descriptions = $request->descriptions;

         if (!empty($request->attached_file)){
            $files = [];
            if ($request->hasfile('attached_file')){
                foreach ($request->file('attached_file') as $file){
                    $name = $request->name . 'attached_file' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/',$name);
                    $files[] = $name;
                }
            }
            $supplier->attached_file = json_encode($files);
         }

         if (!empty($request->attached_picture)){
            $files = [];
            if ($request->hasfile('attached_picture')){
                foreach ($request->file('attached_picture') as $file){
                    $name = $request->name . 'attached_picture' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/',$name);
                    $files[] = $name;
                }
            }
            $supplier->attached_picture = json_encode($files);
         }

         $supplier->manufacturer = $request->manufacturer;
         $supplier->type = $request->type;
         $supplier->product = $request->product;
         $supplier->proposed_actions = $request->proposed_actions;
         $supplier->comments = $request->comments;
         $supplier->impact = $request->impact;
         $supplier->impact_analysis = $request->impact_analysis;
         $supplier->severity_rate = $request->severity_rate;
         $supplier->occurence = $request->occurence;
         $supplier->detection = $request->detection;
         $supplier->rpn = $request->rpn;
         $supplier->update();

         if ($lastData->originator_id != $supplier->originator_id || !empty($request->comment)) {
            // return 'history';
            $history = new SupplierAuditTrail();
            $history->supplier_id = $id;
            $history->activity_type = 'Initiated By';
            $history->previous = $lastData->originator_id;
            $history->current = $supplier->originator_id;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->short_description != $supplier->short_description || !empty($request->comment)) {
            // return 'history';
            $history = new SupplierAuditTrial();
            $history->supplier_id = $id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastData->short_description;
            $history->current = $supplier->short_description;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->criticality != $supplier->criticality || !empty($request->comment)) {
            // return 'history';
            $history = new SupplierAuditTrial();
            $history->supplier_id = $id;
            $history->activity_type = 'Criticality';
            $history->previous = $lastData->criticality;
            $history->current = $supplier->criticality;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->priority_level != $supplier->priority_level || !empty($request->comment)) {
            // return 'history';
            $history = new SupplierAuditTrial();
            $history->supplier_id = $id;
            $history->activity_type = 'Priority Level';
            $history->previous = $lastData->priority_level;
            $history->current = $supplier->priority_level;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->auditee != $supplier->auditee || !empty($request->comment)) {
            // return 'history';
            $history = new SupplierAuditTrial();
            $history->supplier_id = $id;
            $history->activity_type = 'Auditee';
            $history->previous = $lastData->auditee;
            $history->current = $supplier->auditee;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->contact_person != $supplier->contact_person || !empty($request->comment)) {
            // return 'history';
            $history = new SupplierAuditTrial();
            $history->supplier_id = $id;
            $history->activity_type = 'Contact Person';
            $history->previous = $lastData->contact_person;
            $history->current = $supplier->contact_person;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->due_date != $supplier->due_date || !empty($request->comment)) {
            // return 'history';
            $history = new SupplierAuditTrial();
            $history->supplier_id = $id;
            $history->activity_type = 'Due Date';
            $history->previous = $lastData->due_date;
            $history->current = $supplier->due_date;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->assigned_to != $supplier->assigned_to || !empty($request->comment)) {
            // return 'history';
            $history = new SupplierAuditTrial();
            $history->supplier_id = $id;
            $history->activity_type = 'Assigned To';
            $history->previous = $lastData->assigned_to;
            $history->current = $supplier->assigned_to;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->descriptions != $supplier->descriptions || !empty($request->comment)) {
            // return 'history';
            $history = new SupplierAuditTrial();
            $history->supplier_id = $id;
            $history->activity_type = 'Descriptions';
            $history->previous = $lastData->descriptions;
            $history->current = $supplier->descriptions;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->attached_file != $supplier->attached_file || !empty($request->comment)) {
            // return 'history';
            $history = new SupplierAuditTrial();
            $history->supplier_id = $id;
            $history->activity_type = 'Attached File';
            $history->previous = $lastData->attached_file;
            $history->current = $supplier->attached_file;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->attached_picture != $supplier->attached_picture || !empty($request->comment)) {
            // return 'history';
            $history = new SupplierAuditTrial();
            $history->supplier_id = $id;
            $history->activity_type = 'Attached Picture';
            $history->previous = $lastData->attached_picture;
            $history->current = $supplier->attached_picture;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->Manufacturer != $supplier->Manufacturer || !empty($request->comment)) {
            // return 'history';
            $history = new SupplierAuditTrial();
            $history->supplier_id = $id;
            $history->activity_type = 'Manufacturer';
            $history->previous = $lastData->Manufacturer;
            $history->current = $supplier->Manufacturer;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->type != $supplier->type || !empty($request->comment)) {
            // return 'history';
            $history = new SupplierAuditTrial();
            $history->supplier_id = $id;
            $history->activity_type = 'Type';
            $history->previous = $lastData->type;
            $history->current = $supplier->type;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->product != $supplier->product || !empty($request->comment)) {
            // return 'history';
            $history = new SupplierAuditTrial();
            $history->supplier_id = $id;
            $history->activity_type = 'Product';
            $history->previous = $lastData->product;
            $history->current = $supplier->product;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->proposed_actions != $supplier->proposed_actions || !empty($request->comment)) {
            // return 'history';
            $history = new SupplierAuditTrial();
            $history->supplier_id = $id;
            $history->activity_type = 'Proposed Actions';
            $history->previous = $lastData->proposed_actions;
            $history->current = $supplier->proposed_actions;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->comments != $supplier->comments || !empty($request->comment)) {
            // return 'history';
            $history = new SupplierAuditTrial();
            $history->supplier_id = $id;
            $history->activity_type = 'Comments';
            $history->previous = $lastData->comments;
            $history->current = $supplier->comments;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->impact != $supplier->impact || !empty($request->comment)) {
            // return 'history';
            $history = new SupplierAuditTrial();
            $history->supplier_id = $id;
            $history->activity_type = 'Impact';
            $history->previous = $lastData->impact;
            $history->current = $supplier->impact;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->impact_analysis != $supplier->impact_analysis || !empty($request->comment)) {
            // return 'history';
            $history = new SupplierAuditTrial();
            $history->supplier_id = $id;
            $history->activity_type = 'Impact Analysis';
            $history->previous = $lastData->impact_analysis;
            $history->current = $supplier->impact_analysis;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->severity_rate != $supplier->severity_rate || !empty($request->comment)) {
            // return 'history';
            $history = new SupplierAuditTrial();
            $history->supplier_id = $id;
            $history->activity_type = 'Severity Rate';
            $history->previous = $lastData->severity_rate;
            $history->current = $supplier->severity_rate;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->occurence != $supplier->occurence || !empty($request->comment)) {
            // return 'history';
            $history = new SupplierAuditTrial();
            $history->supplier_id = $id;
            $history->activity_type = 'Occurence';
            $history->previous = $lastData->occurence;
            $history->current = $supplier->occurence;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->detection != $supplier->detection || !empty($request->comment)) {
            // return 'history';
            $history = new SupplierAuditTrial();
            $history->supplier_id = $id;
            $history->activity_type = 'Detection';
            $history->previous = $lastData->detection;
            $history->current = $supplier->detection;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->rpn != $supplier->rpn || !empty($request->comment)) {
            // return 'history';
            $history = new SupplierAuditTrial();
            $history->supplier_id = $id;
            $history->activity_type = 'RPN';
            $history->previous = $lastData->rpn;
            $history->current = $supplier->rpn;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        toastr()->success("Record is update Successfully");
        return back();

    }

    public function supplier_show($id)
    {
        $data = Supplier::find($id);
        if(empty($data)) {
            toastr()->error('Invalid ID.');
            return back();
        }
        $data->record = str_pad($data->record, 4, '0', STR_PAD_LEFT);
        $data->assign_to_name = User::where('id', $data->assigned_to)->value('name');
        $data->initiator_name = User::where('id', $data->initiator_id)->value('name');
        return view('frontend.supplierObservation.supplier_observation_view', compact('data'));
    }

    public function supplier_send_stage(Request $request, $id)
    {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $supplier = Supplier::find($id);
            $lastDocument =  Supplier::find($id);

            if ($supplier->stage == 1) {
                $supplier->stage = "2";
                $supplier->status = 'Pending Response/CAPA Plan';
                $supplier->report_issued_by = Auth::user()->name;
                $supplier->report_issued_on = Carbon::now()->format('d-M-Y');
                $supplier->report_issued_comment = $request->comment;
                $history = new SupplierAuditTrial();
                $history->supplier_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $supplier->report_issued_by;
                $history->comment = $request->comment;
                $history->action = 'Report Issued';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Pending Response/CAPA Plan";
                $history->change_from = $lastDocument->status;
                $history->stage='Report Issued';
                $history->action_name = 'Not Applicable';

                $history->save();
                $supplier->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($supplier->stage == 2) {
                $supplier->stage = "3";
                $supplier->status = 'Work in Progress';
                $supplier->approval_received_by = Auth::user()->name;
                $supplier->approval_received_on = Carbon::now()->format('d-M-Y');
                $supplier->approval_received_comment = $request->comment;
                $history = new SupplierAuditTrial();
                $history->supplier_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $supplier->report_issued_by;
                $history->comment = $request->comment;
                $history->action = 'Approval received';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Work in Progress";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Approval received';
                $history->action_name = 'Not Applicable';

                $history->save();
                $supplier->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($supplier->stage == 3) {
                $supplier->stage = "4";
                $supplier->status = 'Pending Approval';
                $supplier->all_capa_closed_by = Auth::user()->name;
                $supplier->all_capa_closed_on = Carbon::now()->format('d-M-Y');
                $supplier->all_capa_closed_comment = $request->comment;
                $history = new SupplierAuditTrial();
                $history->supplier_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $supplier->report_issued_by;
                $history->comment = $request->comment;
                $history->action = 'All CAPA Closed';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Pending Approval";
                $history->change_from = $lastDocument->status;
                $history->stage='All CAPA Closed';
                $history->action_name = 'Not Applicable';

                $history->save();
                $supplier->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($supplier->stage == 4) {
                $supplier->stage = "5";
                $supplier->status = 'Closed - Done';
                $supplier->approve_by = Auth::user()->name;
                $supplier->approve_on = Carbon::now()->format('d-M-Y');
                $supplier->approve_comment = $request->comment;
                $history = new SupplierAuditTrial();
                $history->supplier_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $supplier->report_issued_by;
                $history->comment = $request->comment;
                $history->action = 'Approve';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Closed - Done";
                $history->change_from = $lastDocument->status;
                $history->stage='Approve';
                $history->action_name = 'Not Applicable';

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


    public function supplier_Cancle(Request $request, $id)
    {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $supplier = Supplier::find($id);
            $lastDocument =  Supplier::find($id);
            // $data =  Supplier::find($id);
            
            
            if ($supplier->stage == 1) {
                $supplier->stage = "0";
                $supplier->status = "Closed - Cancelled";
                $supplier->cancelled_by = Auth::user()->name;
                $supplier->cancelled_on = Carbon::now()->format('d-M-Y');
                $supplier->cancelled_comment = $request->comment;
                $supplier->update();

                $history = new SupplierAuditTrial();
                $history->supplier_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $supplier->cancelled_by;
                $history->comment = $request->comment;
                $history->action = 'Cancel';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Closed - Cancelled";
                $history->change_from = $lastDocument->status;
                $history->stage='Cancel';
                $history->action_name = 'Not Applicable';
                $history->save();

                $history = new SupplierHistory();
                $history->type = "Supplier Observation";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $supplier->stage;
                $history->status = $supplier->status;
                $history->save();
                toastr()->success('Document Sent');
                return back();
                
            } 
        }else {
            toastr()->error('E-signature Not match');
            return back();
        }

    }


    public function supplier_reject(Request $request, $id)
    {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $supplier = Supplier::find($id);

            if ($supplier->stage == 4) {
                $supplier->stage = "2";
                $supplier->status = "Pending Response/CAPA Plan";
                $supplier->reject_by = Auth::user()->name;
                $supplier->reject_on = Carbon::now()->format('d-M-Y');
                $supplier->reject_comment = $request->comment;
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


    public function supplierAuditTrail($id)
    {

        $audit = SupplierAuditTrial::where('supplier_id', $id)->orderByDESC('id')->get()->unique('activity_type');
        $today = Carbon::now()->format('d-m-y');
        $document = Supplier::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');

        return view("frontend.supplierObservation.supplier-audit-trial", compact('audit', 'document', 'today'));

    }


    public function auditDetailsSupplier($id)
    {

        $detail = SupplierAuditTrial::find($id);

        $detail_data = SupplierAuditTrial::where('activity_type', $detail->activity_type)->where('supplier_id', $detail->supplier_id)->latest()->get();

        $doc = Supplier::where('id', $detail->supplier_id)->first();

        $doc->origiator_name = User::find($doc->initiator_id);
        return view("frontend.supplierObservation.supplier-audit-trial-inner", compact('detail', 'doc', 'detail_data'));

    }


    public static function singleReport($id)
    {

        $data = Supplier::find($id);
        if (!empty($data)) {
            $data->originator_id = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.supplierObservation.singleReport', compact('data'))
                ->setOptions([
                    'defaultFont' => 'sans-serif',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isPhpEnabled' => true,
                ]);
            $pdf->setPaper('A4');
            $pdf->render();
            $canvas = $pdf->getDomPDF()->getCanvas();
            $height = $canvas->get_height();
            $width = $canvas->get_width();
            $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');
            $canvas->page_text($width / 4, $height / 2, $data->status, null, 25, [0, 0, 0], 2, 6, -20);
            return $pdf->stream('Supplier-Obs' . $id . '.pdf');
        }

    }


    public static function auditReport($id)
    {

        $doc = Supplier::find($id);
        $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        $data = SupplierAuditTrial::where('supplier_id', $doc->id)->orderByDesc('id')->get();
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.supplierObservation.auditReport', compact('data', 'doc'))
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'isPhpEnabled' => true,
            ]);
        $pdf->setPaper('A4');
        $pdf->render();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $height = $canvas->get_height();
        $width = $canvas->get_width();

        $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');

        $canvas->page_text(
            $width / 3,
            $height / 2,
            $doc->status,
            null,
            60,
            [0, 0, 0],
            2,
            6,
            -20
        );
        return $pdf->stream('SOP' . $id . '.pdf');

    }

}
