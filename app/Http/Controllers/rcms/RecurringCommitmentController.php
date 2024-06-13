<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RecurringCommitment;
use App\Models\RecordNumber;
use App\Models\RoleGroup;
use App\Models\RecurringCommitmentAuditTrail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RecurringCommitmentController extends Controller
{
    public function index(Request $request){
        $record_number = (RecordNumber::first()->value('counter')) + 1;
        $record_numbers = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $users = User::all();
        return View('frontend.recurring-commitment.recurring-commitment-new', compact('users', 'record_number', 'record_numbers'));
    }

    public function store(Request $request){
        $recurringCommitment = new RecurringCommitment();
        $recurringCommitment->parent_id = $request->parent_id;
        $recurringCommitment->parent_type = $request->parent_type;
        $recurringCommitment->type = "Recurring-Commitment";
        $recurringCommitment->status = "Opened";
        $recurringCommitment->record = $request->record;
        $recurringCommitment->initiator_id = Auth::user()->id;
        $recurringCommitment->assign_to = $request->assign_to;
        $recurringCommitment->initiation_date = Carbon::now();
        $recurringCommitment->due_date = Carbon::now()->addDays(30)->format('d-M-Y');
        $recurringCommitment->short_description = $request->short_description;
        $recurringCommitment->zone = $request->zone;
        $recurringCommitment->country = $request->country;
        $recurringCommitment->state = $request->state;
        $recurringCommitment->city = $request->city;
        $recurringCommitment->epa_number = $request->epa_number;
        $recurringCommitment->impact = $request->impact;
        $recurringCommitment->responsible_department = $request->responsible_department;
        $recurringCommitment->related_url = $request->related_url;


        if (!empty ($request->permit_certificate)) {
            $files = [];
            if ($request->hasfile('permit_certificate')) {
                foreach ($request->file('permit_certificate') as $file) {
                    $name = "RC" . 'permit_certificate' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $recurringCommitment->permit_certificate = json_encode($files);
        }

        if (!empty ($request->file_attachments)) {
            $files = [];
            if ($request->hasfile('file_attachments')) {
                foreach ($request->file('file_attachments') as $file) {
                    $name = "RC" . 'file_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $recurringCommitment->file_attachments = json_encode($files);
        }

        /* Commitment Information Tab Data */
        $recurringCommitment->commitment_type = $request->commitment_type;
        $recurringCommitment->commitment_frequency = $request->commitment_frequency;
        $recurringCommitment->commitment_end_date = $request->commitment_end_date;
        $recurringCommitment->next_commitment_date = $request->next_commitment_date;
        $recurringCommitment->other_involved = $request->other_involved;
        $recurringCommitment->site = $request->site;
        $recurringCommitment->site_contact = $request->site_contact;
        $recurringCommitment->description = $request->description;
        $recurringCommitment->comments = $request->comments;
        $recurringCommitment->commitment_action = $request->commitment_action;
        $recurringCommitment->commitment_notes = $request->commitment_notes;

        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();

        $recurringCommitment->save();

        /* Audit Trail Code Starts */

            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Date of Initiation';
            $history->previous = "Null";
            $history->current = Carbon::now()->format('d-M-Y');
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();

            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Initiator';
            $history->previous = "Null";
            $history->current = Auth::user()->name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();

        if (!empty ($request->assign_to)){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Assign To';
            $history->previous = "Null";
            $history->current = $recurringCommitment->assign_to;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->due_date)){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Due Date';
            $history->previous = "Null";
            $history->current = $recurringCommitment->due_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->short_description)){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Null";
            $history->current = $recurringCommitment->short_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->zone)){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Zone';
            $history->previous = "Null";
            $history->current = $recurringCommitment->zone;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->country)){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Country';
            $history->previous = "Null";
            $history->current = $recurringCommitment->country;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->state)){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'State';
            $history->previous = "Null";
            $history->current = $recurringCommitment->state;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->city)){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'City';
            $history->previous = "Null";
            $history->current = $recurringCommitment->city;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->epa_number)){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'EPA Identification Number';
            $history->previous = "Null";
            $history->current = $recurringCommitment->epa_number;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->impact)){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Impact';
            $history->previous = "Null";
            $history->current = $recurringCommitment->impact;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->responsible_department)){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Responsible Department';
            $history->previous = "Null";
            $history->current = $recurringCommitment->responsible_department;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->related_url)){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Related URL';
            $history->previous = "Null";
            $history->current = $recurringCommitment->related_url;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->commitment_type)){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Type Of Commitment';
            $history->previous = "Null";
            $history->current = $recurringCommitment->commitment_type;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->commitment_frequency)){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Commitment Frequency';
            $history->previous = "Null";
            $history->current = $recurringCommitment->commitment_frequency;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->commitment_start_date)){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Commitment Start Date';
            $history->previous = "Null";
            $history->current = $recurringCommitment->commitment_start_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->commitment_end_date)){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Commitment End Date';
            $history->previous = "Null";
            $history->current = $recurringCommitment->commitment_end_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->next_commitment_date)){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Next Commitment Date';
            $history->previous = "Null";
            $history->current = $recurringCommitment->next_commitment_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->other_involved)){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Others Involved';
            $history->previous = "Null";
            $history->current = $recurringCommitment->other_involved;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->site)){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Site';
            $history->previous = "Null";
            $history->current = $recurringCommitment->site;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->site_contact)){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Site Contact';
            $history->previous = "Null";
            $history->current = $recurringCommitment->site_contact;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->description)){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Description';
            $history->previous = "Null";
            $history->current = $recurringCommitment->description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->comments)){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Comments';
            $history->previous = "Null";
            $history->current = $recurringCommitment->comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->commitment_action)){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Commitment Action';
            $history->previous = "Null";
            $history->current = $recurringCommitment->commitment_action;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->commitment_notes)){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Commitment Note';
            $history->previous = "Null";
            $history->current = $recurringCommitment->commitment_notes;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->other_involved)){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Others Involved';
            $history->previous = "Null";
            $history->current = $recurringCommitment->other_involved;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->other_involved)){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Others Involved';
            $history->previous = "Null";
            $history->current = $recurringCommitment->other_involved;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $recurringCommitment->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        toastr()->success("Record is created Successfully");
        return redirect(url('rcms/qms-dashboard'));
    }

    public function show(Request $request, $id){
        $data = RecurringCommitment::find($id);
        $users = User::all();
        $data->initiator_name = User::where('id', $data->initiator_id)->value('name');
        return View('frontend.recurring-commitment.recurring-commitment-view', compact('data', 'users'));
    }

    public function update(Request $request, $id){
        $recurringCommitment = RecurringCommitment::find($id);
        $lastDocument = RecurringCommitment::find($id); 

        $recurringCommitment->assign_to = $request->assign_to;
        $recurringCommitment->short_description = $request->short_description;
        $recurringCommitment->zone = $request->zone;
        $recurringCommitment->country = $request->country;
        $recurringCommitment->state = $request->state;
        $recurringCommitment->city = $request->city;
        $recurringCommitment->epa_number = $request->epa_number;
        $recurringCommitment->impact = $request->impact;
        $recurringCommitment->responsible_department = $request->responsible_department;
        $recurringCommitment->related_url = $request->related_url;

        $recurringCommitment->commitment_type = $request->commitment_type;
        $recurringCommitment->commitment_frequency = $request->commitment_frequency;
        $recurringCommitment->commitment_start_date = $request->commitment_start_date;
        $recurringCommitment->commitment_end_date = $request->commitment_end_date;
        $recurringCommitment->next_commitment_date = $request->next_commitment_date;
        $recurringCommitment->other_involved = $request->other_involved;
        $recurringCommitment->site = $request->site;
        $recurringCommitment->site_contact = $request->site_contact;
        $recurringCommitment->description = $request->description;
        $recurringCommitment->comments = $request->comments;
        $recurringCommitment->commitment_action = $request->commitment_action;
        $recurringCommitment->commitment_notes = $request->commitment_notes;

        if (!empty ($request->permit_certificate)) {
            $files = [];
            if ($recurringCommitment->permit_certificate) {
                $files = is_array(json_decode($recurringCommitment->permit_certificate)) ? $recurringCommitment->permit_certificate : [];
            }
            if ($request->hasfile('permit_certificate')) {
                foreach ($request->file('permit_certificate') as $file) {
                    $name = "RC" . '-permit_certificate' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $recurringCommitment->permit_certificate = json_encode($files);
        }

        if (!empty ($request->file_attachments)) {
            $files = [];
            if ($recurringCommitment->file_attachments) {
                $files = is_array(json_decode($recurringCommitment->file_attachments)) ? $recurringCommitment->file_attachments : [];
            }
            if ($request->hasfile('file_attachments')) {
                foreach ($request->file('file_attachments') as $file) {
                    $name = "RC" . '-file_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $recurringCommitment->file_attachments = json_encode($files);
        }

        $recurringCommitment->update();

        if ($lastDocument->short_description != $productRecall->short_description){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastDocument->short_description;
            $history->current = $recurringCommitment->short_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->zone != $productRecall->zone){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Zone';
            $history->previous = $lastDocument->zone;
            $history->current = $recurringCommitment->zone;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->country != $productRecall->country){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Country';
            $history->previous = $lastDocument->country;
            $history->current = $recurringCommitment->country;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->state != $productRecall->state){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'State';
            $history->previous = $lastDocument->state;
            $history->current = $recurringCommitment->state;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->city != $productRecall->city){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'City';
            $history->previous = $lastDocument->city;
            $history->current = $recurringCommitment->city;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->epa_number != $productRecall->epa_number){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'EPA Identification Number';
            $history->previous = $lastDocument->epa_number;
            $history->current = $recurringCommitment->epa_number;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->impact != $productRecall->impact){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Impact';
            $history->previous = $lastDocument->impact;
            $history->current = $recurringCommitment->impact;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->responsible_department != $productRecall->responsible_department){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Responsible Department';
            $history->previous = $lastDocument->responsible_department;
            $history->current = $recurringCommitment->responsible_department;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->related_url != $productRecall->related_url){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Related URL';
            $history->previous = $lastDocument->related_url;
            $history->current = $recurringCommitment->related_url;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->commitment_type != $productRecall->commitment_type){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Type Of Commitment';
            $history->previous = $lastDocument->commitment_type;
            $history->current = $recurringCommitment->commitment_type;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->commitment_frequency != $productRecall->commitment_frequency){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Commitment Frequency';
            $history->previous = $lastDocument->commitment_frequency;
            $history->current = $recurringCommitment->commitment_frequency;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->commitment_start_date != $productRecall->commitment_start_date){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Commitment Start Date';
            $history->previous = $lastDocument->commitment_start_date;
            $history->current = $recurringCommitment->commitment_start_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->commitment_end_date != $productRecall->commitment_end_date){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Commitment End Date';
            $history->previous = $lastDocument->commitment_end_date;
            $history->current = $recurringCommitment->commitment_end_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->next_commitment_date != $productRecall->next_commitment_date){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Next Commitment Date';
            $history->previous = $lastDocument->next_commitment_date;
            $history->current = $recurringCommitment->next_commitment_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->other_involved != $productRecall->other_involved){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Others Involved';
            $history->previous = $lastDocument->other_involved;
            $history->current = $recurringCommitment->other_involved;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->site != $productRecall->site){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Site';
            $history->previous = $lastDocument->site;
            $history->current = $recurringCommitment->site;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->site_contact != $productRecall->site_contact){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Site Contact';
            $history->previous = $lastDocument->site_contact;
            $history->current = $recurringCommitment->site_contact;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->description != $productRecall->description){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Description';
            $history->previous = $lastDocument->description;
            $history->current = $recurringCommitment->description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->comments != $productRecall->comments){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Comments';
            $history->previous = $lastDocument->comments;
            $history->current = $recurringCommitment->comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->commitment_notes != $productRecall->commitment_notes){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Commitment Notes';
            $history->previous = $lastDocument->commitment_notes;
            $history->current = $recurringCommitment->commitment_notes;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->commitment_action != $productRecall->commitment_action){
            $history = new RecurringCommitmentAuditTrail();
            $history->recurring_commitment_id = $recurringCommitment->id;
            $history->activity_type = 'Commitment Action';
            $history->previous = $lastDocument->commitment_action;
            $history->current = $recurringCommitment->commitment_action;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        toastr()->success('Record is Update Successfully');
        return back();
    }

    public function auditTrail(Request $request, $id){
        
    }

    public function auditTrailPdf(Request $request, $id){
        
    }

    public function singleReport(Request $request, $id){
        
    }

    public function recurringCommitmentSendStage(Request $request, $id){
        
    }

    public function recurringCommitmentMoreInfo(Request $request, $id){
        
    }
}
