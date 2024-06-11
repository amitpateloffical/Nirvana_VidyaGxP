<?php

namespace App\Http\Controllers\newForm;

use App\Http\Controllers\Controller;
use App\Models\RecordNumber;
use App\Models\Sanction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

class SanctionController extends Controller{
    public function index(){

        $old_record = Sanction::select('id', 'division_id', 'record')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view('frontend.New_forms.sanction.sanction', compact('old_record','record_number', 'currentDate', 'formattedDate', 'due_date'));
    }

    public function sanctionStore(Request $request)
    {

        try {
            $recordCounter = RecordNumber::first();
            $newRecordNumber = $recordCounter->counter + 1;

            $recordCounter->counter = $newRecordNumber;
            $recordCounter->save();

            $sanction = new Sanction();

            $sanction->stage = '1';
            $sanction->status = 'Opened';
            $sanction->form_type = 'Sanction';
            $sanction->parent_id = $request->parent_id;
            $sanction->parent_type = $request->parent_type;
            $sanction->record = $newRecordNumber;

            $sanction->initiator_id = Auth::user()->id;
            $sanction->user_name = Auth::user()->name;
            $sanction->initiator = $request->initiator;
            $sanction->initiation_date = $request->initiation_date;
            $sanction->short_description = $request->short_description;
            $sanction->originator = Auth::user()->name;
            $sanction->assign_to = $request->assign_to;
            $sanction->due_date = $request->due_date;

            if (!empty($request->file_attach)) {
                $files = [];
                if ($request->hasfile('file_attach')) {
                    foreach ($request->file('file_attach') as $file) {
                        $name = $request->name . 'file_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $sanction->file_attach = json_encode($files);
            }

            $sanction->sanction_type = $request->sanction_type;
            $sanction->description = $request->description;
            $sanction->authority_type = $request->authority_type;
            $sanction->authority = $request->authority;
            $sanction->fine = $request->fine;
            $sanction->currency = $request->currency;

            $sanction->save();

//===========audit trails ===========//
// if (!empty($request->manufacturer)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $national->id;
//     $validation2->activity_type = '(Root Parent) Manufacturer';
//     $validation2->previous = "Null";
//     $validation2->current = $request->manufacturer;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Opened";
//     $validation2->change_from = "Initiator";
//     $validation2->action_name = 'Create';
//     $validation2->save();
// }

// if (!empty($request->trade_name)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $national->id;
//     $validation2->activity_type = '(Root Parent) Trade Name';
//     $validation2->previous = "Null";
//     $validation2->current = $request->trade_name;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Opened";
//     $validation2->change_from = "Initiator";
//     $validation2->action_name = 'Create';
//     $validation2->save();
// }

// if (!empty($request->short_description)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $national->id;
//     $validation2->previous = "Null";
//     $validation2->current = $request->short_description;
//     $validation2->activity_type = 'Short Description';
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Opened";
//     $validation2->change_from = "Initiator";
//     $validation2->action_name = 'Create';
//     $validation2->comment = "Not Applicable";
//     $validation2->save();
// }

// if (!empty($request->initiation_date)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $national->id;
//     $validation2->activity_type = 'Initiation Date';
//     $validation2->previous = "Null";
//     $validation2->current = $request->initiation_date;
//     $validation2->comment = "Not Applicable";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Opened";
//     $validation2->change_from = "Initiator";
//     $validation2->action_name = 'Create';
//     $validation2->save();
// }

// if (!empty($request->assign_to)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $national->id;
//     $validation2->activity_type = 'Assign To';
//     $validation2->previous = "Null";
//     $validation2->current = $request->assign_to;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Opened";
//     $validation2->change_from = "Initiator";
//     $validation2->action_name = 'Create';
//     $validation2->save();
// }

// if (!empty($request->due_date)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $national->id;
//     $validation2->activity_type = 'Due Date';
//     $validation2->previous = "Null";
//     $validation2->current = $request->due_date;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Opened";
//     $validation2->change_from = "Initiator";
//     $validation2->action_name = 'Create';

//     $validation2->save();
// }

// if (!empty($request->procedure_type)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $national->id;
//     $validation2->activity_type = '(Parent) Procedure Type';
//     $validation2->previous = "Null";
//     $validation2->current = $request->procedure_type;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
//     $validation2->change_to =   "Opened";
//     $validation2->change_from = "Initiator";
//     $validation2->action_name = 'Create';

//     $validation2->save();
// }

// if (!empty($request->planned_subnission_date)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $national->id;
//     $validation2->activity_type = 'Planned Subnission Date';
//     $validation2->previous = "Null";
//     $validation2->current = $request->planned_subnission_date;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Opened";
//     $validation2->change_from = "Initiator";
//     $validation2->action_name = 'Create';

//     $validation2->save();
// }

// if (!empty($request->member_state)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $national->id;
//     $validation2->activity_type = 'Member State';
//     $validation2->previous = "Null";
//     $validation2->current = $request->member_state;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Opened";
//     $validation2->change_from = "Initiator";
//     $validation2->action_name = 'Create';
//     $validation2->save();
// }

// if (!empty($request->local_trade_name)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $national->id;
//     $validation2->activity_type = 'Local Trade Name';
//     $validation2->previous = "Null";
//     $validation2->current = $request->local_trade_name;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Opened";
//     $validation2->change_from = "Initiator";
//     $validation2->action_name = 'Create';
//     $validation2->save();
// }

// if (!empty($request->registration_number)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $national->id;
//     $validation2->activity_type = 'Registration Number';
//     $validation2->previous = "Null";
//     $validation2->current = $request->registration_number;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Opened";
//     $validation2->change_from = "Initiator";
//     $validation2->action_name = 'Create';
//     $validation2->save();
// }


// if (!empty($request->renewal_rule)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $national->id;
//     $validation2->activity_type = 'Renewal Rule';
//     $validation2->previous = "Null";
//     $validation2->current = $request->renewal_rule;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Opened";
//     $validation2->change_from = "Initiator";
//     $validation2->action_name = 'Create';
//     $validation2->save();
// }

// if (!empty($request->dossier_parts)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $national->id;
//     $validation2->activity_type = 'Dossier Parts';
//     $validation2->previous = "Null";
//     $validation2->current = $request->dossier_parts;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Opened";
//     $validation2->change_from = "Initiator";
//     $validation2->action_name = 'Create';
//     $validation2->save();
// }

// if (!empty($request->related_dossier_documents)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $national->id;
//     $validation2->activity_type = 'Related Dossier Documents';
//     $validation2->previous = "Null";
//     $validation2->current = $request->related_dossier_documents;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Opened";
//     $validation2->change_from = "Initiator";
//     $validation2->action_name = 'Create';
//     $validation2->save();
// }

// if (!empty($request->pack_size)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $national->id;
//     $validation2->activity_type = 'Pack Size';
//     $validation2->previous = "Null";
//     $validation2->current = $request->pack_size;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Opened";
//     $validation2->change_from = "Initiator";
//     $validation2->action_name = 'Create';
//     $validation2->save();
// }

// if (!empty($request->shelf_life)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $national->id;
//     $validation2->activity_type = 'Shelf Life';
//     $validation2->previous = "Null";
//     $validation2->current = $request->shelf_life;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Opened";
//     $validation2->change_from = "Initiator";
//     $validation2->action_name = 'Create';
//     $validation2->save();
// }

// if (!empty($request->psup_cycle)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $national->id;
//     $validation2->activity_type = 'PSUP Cycle';
//     $validation2->previous = "Null";
//     $validation2->current = $request->psup_cycle;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Opened";
//     $validation2->change_from = "Initiator";
//     $validation2->action_name = 'Create';
//     $validation2->save();
// }

// if (!empty($request->expiration_date)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $national->id;
//     $validation2->activity_type = 'Expiration Date';
//     $validation2->previous = "Null";
//     $validation2->current = $request->expiration_date;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Opened";
//     $validation2->change_from = "Initiator";
//     $validation2->action_name = 'Create';
//     $validation2->save();
// }
            toastr()->success("Sanction is created Successfully");
            return redirect(url('rcms/qms-dashboard'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Failed to save Sanction : ' . $e->getMessage());
        }
    }

    public function sanctionEdit($id){
       $sanction = Sanction::findOrFail($id);
       return view('frontend.New_forms.sanction.sanctionUpdate', compact('sanction'));
    }

    public function sanctionUpdate(Request $request, $id){
        try {
            // $recordCounter = RecordNumber::first();

            // $newRecordNumber = $recordCounter->counter + 1;

            // $recordCounter->counter = $newRecordNumber;
            // $recordCounter->save();
            $lastDocument = Sanction::find($id);
            $sanction = Sanction::findOrFail($id);

            $sanction->form_type = 'Sanction';
            $sanction->parent_id = $request->parent_id;
            $sanction->parent_type = $request->parent_type;
            // $sanction->record = $newRecordNumber;

            $sanction->initiator_id = Auth::user()->id;
            $sanction->user_name = Auth::user()->name;
            $sanction->initiator = $request->initiator;
            $sanction->initiation_date = $request->initiation_date;
            $sanction->short_description = $request->short_description;
            $sanction->originator = Auth::user()->name;
            $sanction->assign_to = $request->assign_to;
            $sanction->due_date = $request->due_date;

            $sanction->sanction_type = $request->sanction_type;
            $sanction->description = $request->description;
            $sanction->authority_type = $request->authority_type;
            $sanction->authority = $request->authority;
            $sanction->fine = $request->fine;
            $sanction->currency = $request->currency;

            if (!empty($request->file_attach)) {
                $files = [];
                if ($request->hasfile('file_attach')) {
                    foreach ($request->file('file_attach') as $file) {
                        $name = $request->name . 'file_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $sanction->file_attach = json_encode($files);
            }

            // $sanction->sanction_type = $request->sanction_type;
            // $sanction->description = $request->description;
            // $sanction->authority_type = $request->authority_type;
            // $sanction->authority = $request->authority;
            // $sanction->fine = $request->fine;
            // $sanction->currency = $request->currency;

            $sanction->update();

    
//===========audit trails ===========//
// if (!empty($request->manufacturer)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $sanction1->id;
//     $validation2->activity_type = '(Root Parent) Manufacturer';
//     $validation2->previous = "Null";
//     $validation2->current = $request->manufacturer;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Not Applicable";
//     $validation2->change_from = $lastDocument->status;
//     $validation2->action_name = 'Update';
//     $validation2->save();
// }

// if (!empty($request->trade_name)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $sanction1->id;
//     $validation2->activity_type = '(Root Parent) Trade Name';
//     $validation2->previous = "Null";
//     $validation2->current = $request->trade_name;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Not Applicable";
//     $validation2->change_from = $lastDocument->status;
//     $validation2->action_name = 'Update';
//     $validation2->save();
// }

// if (!empty($request->short_description)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $sanction1->id;
//     $validation2->previous = "Null";
//     $validation2->current = $request->short_description;
//     $validation2->activity_type = 'Short Description';
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Not Applicable";
//     $validation2->change_from = $lastDocument->status;
//     $validation2->action_name = 'Update';
//     $validation2->comment = "Not Applicable";
//     $validation2->save();
// }

// if (!empty($request->initiation_date)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $sanction1->id;
//     $validation2->activity_type = 'Initiation Date';
//     $validation2->previous = "Null";
//     $validation2->current = $request->initiation_date;
//     $validation2->comment = "Not Applicable";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Not Applicable";
//     $validation2->change_from = $lastDocument->status;
//     $validation2->action_name = 'Update';
//     $validation2->save();
// }

// if (!empty($request->assign_to)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $sanction1->id;
//     $validation2->activity_type = 'Assign To';
//     $validation2->previous = "Null";
//     $validation2->current = $request->assign_to;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Not Applicable";
//     $validation2->change_from = $lastDocument->status;
//     $validation2->action_name = 'Update';
//     $validation2->save();
// }

// if (!empty($request->due_date)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $sanction1->id;
//     $validation2->activity_type = 'Due Date';
//     $validation2->previous = "Null";
//     $validation2->current = $request->due_date;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Not Applicable";
//     $validation2->change_from = $lastDocument->status;
//     $validation2->action_name = 'Update';

//     $validation2->save();
// }

// if (!empty($request->procedure_type)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $sanction1->id;
//     $validation2->activity_type = '(Parent) Procedure Type';
//     $validation2->previous = "Null";
//     $validation2->current = $request->procedure_type;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
//     $validation2->change_to =   "Not Applicable";
//     $validation2->change_from = $lastDocument->status;
//     $validation2->action_name = 'Update';

//     $validation2->save();
// }

// if (!empty($request->planned_subnission_date)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $sanction1->id;
//     $validation2->activity_type = 'Planned Subnission Date';
//     $validation2->previous = "Null";
//     $validation2->current = $request->planned_subnission_date;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Not Applicable";
//     $validation2->change_from = $lastDocument->status;
//     $validation2->action_name = 'Update';

//     $validation2->save();
// }

// if (!empty($request->member_state)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $sanction1->id;
//     $validation2->activity_type = 'Member State';
//     $validation2->previous = "Null";
//     $validation2->current = $request->member_state;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Not Applicable";
//     $validation2->change_from = $lastDocument->status;
//     $validation2->action_name = 'Update';
//     $validation2->save();
// }

// if (!empty($request->local_trade_name)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $sanction1->id;
//     $validation2->activity_type = 'Local Trade Name';
//     $validation2->previous = "Null";
//     $validation2->current = $request->local_trade_name;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Not Applicable";
//     $validation2->change_from = $lastDocument->status;
//     $validation2->action_name = 'Update';
//     $validation2->save();
// }

// if (!empty($request->registration_number)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $sanction1->id;
//     $validation2->activity_type = 'Registration Number';
//     $validation2->previous = "Null";
//     $validation2->current = $request->registration_number;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Not Applicable";
//     $validation2->change_from = $lastDocument->status;
//     $validation2->action_name = 'Update';
//     $validation2->save();
// }


// if (!empty($request->renewal_rule)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $sanction1->id;
//     $validation2->activity_type = 'Renewal Rule';
//     $validation2->previous = "Null";
//     $validation2->current = $request->renewal_rule;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Not Applicable";
//     $validation2->change_from = $lastDocument->status;
//     $validation2->action_name = 'Update';
//     $validation2->save();
// }

// if (!empty($request->dossier_parts)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $sanction1->id;
//     $validation2->activity_type = 'Dossier Parts';
//     $validation2->previous = "Null";
//     $validation2->current = $request->dossier_parts;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Not Applicable";
//     $validation2->change_from = $lastDocument->status;
//     $validation2->action_name = 'Update';
//     $validation2->save();
// }

// if (!empty($request->related_dossier_documents)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $sanction1->id;
//     $validation2->activity_type = 'Related Dossier Documents';
//     $validation2->previous = "Null";
//     $validation2->current = $request->related_dossier_documents;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Not Applicable";
//     $validation2->change_from = $lastDocument->status;
//     $validation2->action_name = 'Update';
//     $validation2->save();
// }

// if (!empty($request->pack_size)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $sanction1->id;
//     $validation2->activity_type = 'Pack Size';
//     $validation2->previous = "Null";
//     $validation2->current = $request->pack_size;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Not Applicable";
//     $validation2->change_from = $lastDocument->status;
//     $validation2->action_name = 'Update';
//     $validation2->save();
// }

// if (!empty($request->shelf_life)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $sanction1->id;
//     $validation2->activity_type = 'Shelf Life';
//     $validation2->previous = "Null";
//     $validation2->current = $request->shelf_life;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Not Applicable";
//     $validation2->change_from = $lastDocument->status;
//     $validation2->action_name = 'Update';
//     $validation2->save();
// }

// if (!empty($request->psup_cycle)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $sanction1->id;
//     $validation2->activity_type = 'PSUP Cycle';
//     $validation2->previous = "Null";
//     $validation2->current = $request->psup_cycle;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Not Applicable";
//     $validation2->change_from = $lastDocument->status;
//     $validation2->action_name = 'Update';
//     $validation2->save();
// }

// if (!empty($request->expiration_date)) {
//     $validation2 = new NationalApprovalAudit();
//     $validation2->nationalApproval_id = $sanction1->id;
//     $validation2->activity_type = 'Expiration Date';
//     $validation2->previous = "Null";
//     $validation2->current = $request->expiration_date;
//     $validation2->comment = "NA";
//     $validation2->user_id = Auth::user()->id;
//     $validation2->user_name = Auth::user()->name;
//     $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

//     $validation2->change_to =   "Not Applicable";
//     $validation2->change_from = $lastDocument->status;
//     $validation2->action_name = 'Update';
//     $validation2->save();
// }



            toastr()->success("Sanction is Update Successfully");
            return redirect(url('rcms/qms-dashboard'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Failed to update Sanction : ' . $e->getMessage());
        }

    }


    public function sanctionCancel(Request $request, $id)
    {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $equipment = Sanction::find($id);

            if ($equipment->stage == 1) {
                $equipment->stage = "2";
                $equipment->status = "Closed";
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            toastr()->error('States not Defined');
            return back();
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }
}
