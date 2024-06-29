<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CTA_Submission_grid;
use App\Models\CTASubmission;
use App\Models\CTASubmissionAuditTrail;
use App\Models\RecordNumber;
use App\Models\RoleGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use PDF;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CTASubmissionController extends Controller
{
    public function CTA_submission()
    {
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view("frontend.ctms.cta_submission", compact('due_date', 'record_number'));
    }

    public function CTA_submission_store(Request $request)
    {
        if (!$request->short_description) {
            toastr()->error("Short description is required");
            return redirect()->back();
        }

        $submission = new CTASubmission();
        $submission->record_number = $request->record_number;
        $submission->form_type = "cta_submission";
        $submission->division_code = $request->division_code;
        $submission->division_id = $request->division_id;
        $submission->record = ((RecordNumber::first()->value('counter')) + 1);
        $submission->initiator_id = Auth::user()->id;
        $submission->initiation_date = $request->initiation_date;
        $submission->short_description = $request->short_description;
        $submission->assigned_to = $request->assigned_to;
        $submission->due_date = $request->due_date;
        $submission->type = $request->type;
        $submission->other_type = $request->other_type;

        if (!empty($request->attached_files)) {
            $files = [];
            if ($request->hasfile('attached_files')) {
                foreach ($request->file('attached_files') as $file) {
                    $name = $request->name . 'attached_files' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $submission->attached_files = json_encode($files);
        }

        $submission->description = $request->description;
        $submission->zone = $request->zone;
        $submission->country = $request->country;
        $submission->city = $request->city;
        $submission->state_district = $request->state_district;
        $submission->procedure_number = $request->procedure_number;
        $submission->project_code = $request->project_code;
        $submission->authority_type = $request->authority_type;
        $submission->authority = $request->authority;
        $submission->registration_number = $request->registration_number;
        $submission->other_authority = $request->other_authority;
        $submission->year = $request->year;
        $submission->procedure_type = $request->procedure_type;
        $submission->registration_status = $request->registration_status;
        $submission->outcome = $request->outcome;
        $submission->trade_name = $request->trade_name;
        $submission->comments = $request->comments;
        $submission->manufacturer = $request->manufacturer;
        $submission->actual_submission_date = $request->actual_submission_date;
        $submission->actual_rejection_date = $request->actual_rejection_date;
        $submission->actual_withdrawn_date = $request->actual_withdrawn_date;
        $submission->inquiry_date = $request->inquiry_date;
        $submission->planned_submission_date = $request->planned_submission_date;
        $submission->planned_date_sent_to_affilate = $request->planned_date_sent_to_affilate;
        $submission->effective_date = $request->effective_date;
        $submission->additional_assignees = $request->additional_assignees;
        $submission->additional_investigators = $request->additional_investigators;
        $submission->approvers = $request->approvers;
        $submission->negotiation_team = $request->negotiation_team;
        $submission->trainer = $request->trainer;
        $submission->root_cause_description = $request->root_cause_description;
        $submission->reason_for_non_approval = $request->reason_for_non_approval;
        $submission->reason_for_withdrawal = $request->reason_for_withdrawal;
        $submission->justification_rationale = $request->justification_rationale;
        $submission->meeting_minutes = $request->meeting_minutes;
        $submission->rejection_reason = $request->rejection_reason;
        $submission->effectiveness_check_summary = $request->effectiveness_check_summary;
        $submission->decisions = $request->decisions;
        $submission->summary = $request->summary;
        $submission->documents_affected = $request->documents_affected;
        $submission->actual_time_spent = $request->actual_time_spent;
        $submission->documents = $request->documents;
        $submission->approved_by = $request->approved_by;
        $submission->approved_on = $request->approved_on;

        $submission->status = 'Opened';
        $submission->stage = 1;
        $submission->save();

        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();

        $griddata = $submission->id;

        $newData = CTA_Submission_grid::where(['c_id' => $griddata, 'identifer' => 'ProductMaterialDetails'])->firstOrCreate();
        $newData->save();

        $newData->c_id = $griddata;
        $newData->identifer = 'ProductMaterialDetails';
        $newData->data = $request->serial_number_gi;
        $newData->save();

        if (!empty($submission->short_description)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Null";
            $history->current = $submission->short_description;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($submission->assigned_to)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Assigned To';
            $history->previous = "Null";
            $history->current = $submission->assigned_to;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->due_date)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Due Date';
            $history->previous = "Null";
            $history->current = $submission->due_date;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->type)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Type';
            $history->previous = "Null";
            $history->current = $submission->type;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->description)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Description';
            $history->previous = "Null";
            $history->current = $submission->description;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->zone)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Zone';
            $history->previous = "Null";
            $history->current = $submission->zone;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->country)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Country';
            $history->previous = "Null";
            $history->current = $submission->country;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->city)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'City';
            $history->previous = "Null";
            $history->current = $submission->city;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->state_district)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'State/District';
            $history->previous = "Null";
            $history->current = $submission->state_district;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->procedure_number)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Procedure Number';
            $history->previous = "Null";
            $history->current = $submission->procedure_number;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->project_code)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'project_code';
            $history->previous = "Null";
            $history->current = $submission->project_code;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->authority_type)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Authority Type';
            $history->previous = "Null";
            $history->current = $submission->authority_type;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->authority)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Authority';
            $history->previous = "Null";
            $history->current = $submission->authority;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->registration_number)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Registration Number';
            $history->previous = "Null";
            $history->current = $submission->registration_number;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->other_authority)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Other Authority';
            $history->previous = "Null";
            $history->current = $submission->other_authority;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->year)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Year';
            $history->previous = "Null";
            $history->current = $submission->year;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->procedure_type)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Procedure Type';
            $history->previous = "Null";
            $history->current = $submission->procedure_type;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->registration_status)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Registration Status';
            $history->previous = "Null";
            $history->current = $submission->registration_status;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->outcome)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Outcome';
            $history->previous = "Null";
            $history->current = $submission->outcome;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->trade_name)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Trade Name';
            $history->previous = "Null";
            $history->current = $submission->trade_name;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->comments)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Comments';
            $history->previous = "Null";
            $history->current = $submission->comments;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->manufacturer)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Manufacturer';
            $history->previous = "Null";
            $history->current = $submission->manufacturer;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->actual_submission_date)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Actual Submission Date';
            $history->previous = "Null";
            $history->current = $submission->actual_submission_date;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->actual_rejection_date)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Actual Rejection Date';
            $history->previous = "Null";
            $history->current = $submission->actual_rejection_date;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->actual_withdrawn_date)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Actual Withdrawn Date';
            $history->previous = "Null";
            $history->current = $submission->actual_withdrawn_date;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->inquiry_date)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Inquiry Date';
            $history->previous = "Null";
            $history->current = $submission->inquiry_date;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->planned_submission_date)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Planned Submission Date';
            $history->previous = "Null";
            $history->current = $submission->planned_submission_date;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->planned_date_sent_to_affilate)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Planned Date Sent To Affilate';
            $history->previous = "Null";
            $history->current = $submission->planned_date_sent_to_affilate;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->effective_date)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Effective Date';
            $history->previous = "Null";
            $history->current = $submission->effective_date;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->additional_assignees)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Additional Assignees';
            $history->previous = "Null";
            $history->current = $submission->additional_assignees;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->additional_investigators)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Additional Investigators';
            $history->previous = "Null";
            $history->current = $submission->additional_investigators;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->approvers)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Aapprovers';
            $history->previous = "Null";
            $history->current = $submission->approvers;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->negotiation_team)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Negotiation Team';
            $history->previous = "Null";
            $history->current = $submission->negotiation_team;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->trainer)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Trainer';
            $history->previous = "Null";
            $history->current = $submission->trainer;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->root_cause_description)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Root Cause Description';
            $history->previous = "Null";
            $history->current = $submission->root_cause_description;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->reason_for_non_approval)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Reason for non approval';
            $history->previous = "Null";
            $history->current = $submission->reason_for_non_approval;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->reason_for_withdrawal)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Reason for withdrawal';
            $history->previous = "Null";
            $history->current = $submission->reason_for_withdrawal;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->justification_rationale)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Justification Rationale';
            $history->previous = "Null";
            $history->current = $submission->justification_rationale;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->meeting_minutes)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Meeting Minutes';
            $history->previous = "Null";
            $history->current = $submission->meeting_minutes;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->rejection_reason)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Rejection Reason';
            $history->previous = "Null";
            $history->current = $submission->rejection_reason;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->effectiveness_check_summary)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Effectiveness Check Summary';
            $history->previous = "Null";
            $history->current = $submission->effectiveness_check_summary;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->decisions)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Decisions';
            $history->previous = "Null";
            $history->current = $submission->decisions;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->summary)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Summary';
            $history->previous = "Null";
            $history->current = $submission->summary;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->documents_affected)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Documents Affected';
            $history->previous = "Null";
            $history->current = $submission->documents_affected;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->actual_time_spent)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Actual Time Spent';
            $history->previous = "Null";
            $history->current = $submission->actual_time_spent;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty($submission->documents)) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Documents';
            $history->previous = "Null";
            $history->current = $submission->documents;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiator';
            $history->action_name = 'Create';
            $history->save();
        }

        toastr()->success("Record is created Successfully");
        return redirect(url('rcms/qms-dashboard'));
    }

    public function CTA_submission_update(Request $request, $id)
    {
        if (!$request->short_description) {
            toastr()->error("Short description is required");
            return redirect()->back();
        }

        $lastDocument =  CTASubmission::find($id);
        $submission =  CTASubmission::find($id);
        $submission->short_description = $request->short_description;
        $submission->assigned_to = $request->assigned_to;
        $submission->due_date = $request->due_date;
        $submission->type = $request->type;
        $submission->other_type = $request->other_type;

        if (!empty($request->attached_files)) {
            $files = [];
            if ($request->hasfile('attached_files')) {
                foreach ($request->file('attached_files') as $file) {
                    $name = $request->name . 'attached_files' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $submission->attached_files = json_encode($files);
        }

        $submission->description = $request->description;
        $submission->zone = $request->zone;
        $submission->country = $request->country;
        $submission->city = $request->city;
        $submission->state_district = $request->state_district;
        $submission->procedure_number = $request->procedure_number;
        $submission->project_code = $request->project_code;
        $submission->authority_type = $request->authority_type;
        $submission->authority = $request->authority;
        $submission->registration_number = $request->registration_number;
        $submission->other_authority = $request->other_authority;
        $submission->year = $request->year;
        $submission->procedure_type = $request->procedure_type;
        $submission->registration_status = $request->registration_status;
        $submission->outcome = $request->outcome;
        $submission->trade_name = $request->trade_name;
        $submission->comments = $request->comments;
        $submission->manufacturer = $request->manufacturer;
        $submission->actual_submission_date = $request->actual_submission_date;
        $submission->actual_rejection_date = $request->actual_rejection_date;
        $submission->actual_withdrawn_date = $request->actual_withdrawn_date;
        $submission->inquiry_date = $request->inquiry_date;
        $submission->planned_submission_date = $request->planned_submission_date;
        $submission->planned_date_sent_to_affilate = $request->planned_date_sent_to_affilate;
        $submission->effective_date = $request->effective_date;
        $submission->additional_assignees = $request->additional_assignees;
        $submission->additional_investigators = $request->additional_investigators;
        $submission->approvers = $request->approvers;
        $submission->negotiation_team = $request->negotiation_team;
        $submission->trainer = $request->trainer;
        $submission->root_cause_description = $request->root_cause_description;
        $submission->reason_for_non_approval = $request->reason_for_non_approval;
        $submission->reason_for_withdrawal = $request->reason_for_withdrawal;
        $submission->justification_rationale = $request->justification_rationale;
        $submission->meeting_minutes = $request->meeting_minutes;
        $submission->rejection_reason = $request->rejection_reason;
        $submission->effectiveness_check_summary = $request->effectiveness_check_summary;
        $submission->decisions = $request->decisions;
        $submission->summary = $request->summary;
        $submission->documents_affected = $request->documents_affected;
        $submission->actual_time_spent = $request->actual_time_spent;
        $submission->documents = $request->documents;
        $submission->approved_by = $request->approved_by;
        $submission->approved_on = $request->approved_on;

        // $submission->status = 'Opened';
        // $submission->stage = 1;
        $submission->update();

        // $record = RecordNumber::first();
        // $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        // $record->update();

        // -------------------------------------

        if ($submission->short_description != $lastDocument->short_description) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastDocument->short_description;
            $history->current = $submission->short_description;
            $history->comment = $request->short_description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->assigned_to != $lastDocument->assigned_to) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Assigned To';
            $history->previous = $lastDocument->assigned_to;
            $history->current = $submission->assigned_to;
            $history->comment = $request->assigned_to_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->due_date != $lastDocument->due_date) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Due Date';
            $history->previous = $lastDocument->due_date;
            $history->current = $submission->due_date;
            $history->comment = $request->due_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->type != $lastDocument->type) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Type';
            $history->previous = $lastDocument->type;
            $history->current = $submission->type;
            $history->comment = $request->type_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->description != $lastDocument->description) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Description';
            $history->previous = $lastDocument->description;
            $history->current = $submission->description;
            $history->comment = $request->description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->zone != $lastDocument->zone) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Zone';
            $history->previous = $lastDocument->zone;
            $history->current = $submission->zone;
            $history->comment = $request->zone_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->country != $lastDocument->country) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Country';
            $history->previous = $lastDocument->country;
            $history->current = $submission->country;
            $history->comment = $request->country_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->city != $lastDocument->city) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'City';
            $history->previous = $lastDocument->city;
            $history->current = $submission->city;
            $history->comment = $request->city_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->state_district != $lastDocument->state_district) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'State/District';
            $history->previous = $lastDocument->state_district;
            $history->current = $submission->state_district;
            $history->comment = $request->state_district_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->procedure_number != $lastDocument->procedure_number) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Procedure Number';
            $history->previous = $lastDocument->procedure_number;
            $history->current = $submission->procedure_number;
            $history->comment = $request->procedure_number_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->project_code != $lastDocument->project_code) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Project Code';
            $history->previous = $lastDocument->project_code;
            $history->current = $submission->project_code;
            $history->comment = $request->project_code_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->authority_type != $lastDocument->authority_type) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Authority Type';
            $history->previous = $lastDocument->authority_type;
            $history->current = $submission->authority_type;
            $history->comment = $request->authority_type_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->authority != $lastDocument->authority) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Authority';
            $history->previous = $lastDocument->authority;
            $history->current = $submission->authority;
            $history->comment = $request->authority_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->registration_number != $lastDocument->registration_number) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Registration Number';
            $history->previous = $lastDocument->registration_number;
            $history->current = $submission->registration_number;
            $history->comment = $request->registration_number_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->other_authority != $lastDocument->other_authority) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Other Authority';
            $history->previous = $lastDocument->other_authority;
            $history->current = $submission->other_authority;
            $history->comment = $request->other_authority_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->year != $lastDocument->year) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Year';
            $history->previous = $lastDocument->year;
            $history->current = $submission->year;
            $history->comment = $request->year_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->procedure_type != $lastDocument->procedure_type) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Procedure Type';
            $history->previous = $lastDocument->procedure_type;
            $history->current = $submission->procedure_type;
            $history->comment = $request->procedure_type_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->registration_status != $lastDocument->registration_status) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Registration Status';
            $history->previous = $lastDocument->registration_status;
            $history->current = $submission->registration_status;
            $history->comment = $request->registration_status_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->outcome != $lastDocument->outcome) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastDocument->outcome;
            $history->current = $submission->outcome;
            $history->comment = $request->outcome_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->trade_name != $lastDocument->trade_name) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Trade Name';
            $history->previous = $lastDocument->trade_name;
            $history->current = $submission->trade_name;
            $history->comment = $request->trade_name_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->comments != $lastDocument->comments) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Comments';
            $history->previous = $lastDocument->comments;
            $history->current = $submission->comments;
            $history->comment = $request->comments_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->manufacturer != $lastDocument->manufacturer) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Manufacturer';
            $history->previous = $lastDocument->manufacturer;
            $history->current = $submission->manufacturer;
            $history->comment = $request->manufacturer_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->actual_submission_date != $lastDocument->actual_submission_date) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Actual Submission Date';
            $history->previous = $lastDocument->actual_submission_date;
            $history->current = $submission->actual_submission_date;
            $history->comment = $request->actual_submission_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->actual_rejection_date != $lastDocument->actual_rejection_date) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'actual_rejection_date';
            $history->previous = $lastDocument->actual_rejection_date;
            $history->current = $submission->actual_rejection_date;
            $history->comment = $request->actual_rejection_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->actual_withdrawn_date != $lastDocument->actual_withdrawn_date) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Actual Withdrawn Date';
            $history->previous = $lastDocument->actual_withdrawn_date;
            $history->current = $submission->actual_withdrawn_date;
            $history->comment = $request->actual_withdrawn_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->inquiry_date != $lastDocument->inquiry_date) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Inquiry Date';
            $history->previous = $lastDocument->inquiry_date;
            $history->current = $submission->inquiry_date;
            $history->comment = $request->inquiry_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->planned_submission_date != $lastDocument->planned_submission_date) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Planned Submission Date';
            $history->previous = $lastDocument->planned_submission_date;
            $history->current = $submission->planned_submission_date;
            $history->comment = $request->planned_submission_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->planned_date_sent_to_affilate != $lastDocument->planned_date_sent_to_affilate) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastDocument->planned_date_sent_to_affilate;
            $history->current = $submission->planned_date_sent_to_affilate;
            $history->comment = $request->planned_date_sent_to_affilate_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->effective_date != $lastDocument->effective_date) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Effective Date';
            $history->previous = $lastDocument->effective_date;
            $history->current = $submission->effective_date;
            $history->comment = $request->effective_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->additional_assignees != $lastDocument->additional_assignees) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Additional Assignees';
            $history->previous = $lastDocument->additional_assignees;
            $history->current = $submission->additional_assignees;
            $history->comment = $request->additional_assignees_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->additional_investigators != $lastDocument->additional_investigators) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Additional Investigators';
            $history->previous = $lastDocument->additional_investigators;
            $history->current = $submission->additional_investigators;
            $history->comment = $request->additional_investigators_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->approvers != $lastDocument->approvers) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Approvers';
            $history->previous = $lastDocument->approvers;
            $history->current = $submission->approvers;
            $history->comment = $request->approvers_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->negotiation_team != $lastDocument->negotiation_team) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Negotiation Team';
            $history->previous = $lastDocument->negotiation_team;
            $history->current = $submission->negotiation_team;
            $history->comment = $request->negotiation_team_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->trainer != $lastDocument->trainer) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Trainer';
            $history->previous = $lastDocument->trainer;
            $history->current = $submission->trainer;
            $history->comment = $request->trainer_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->root_cause_description != $lastDocument->root_cause_description) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Root Cause Description';
            $history->previous = $lastDocument->root_cause_description;
            $history->current = $submission->root_cause_description;
            $history->comment = $request->root_cause_description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->reason_for_non_approval != $lastDocument->reason_for_non_approval) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Reason for non approval';
            $history->previous = $lastDocument->reason_for_non_approval;
            $history->current = $submission->reason_for_non_approval;
            $history->comment = $request->reason_for_non_approval_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->reason_for_withdrawal != $lastDocument->reason_for_withdrawal) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Reason for withdrawal';
            $history->previous = $lastDocument->reason_for_withdrawal;
            $history->current = $submission->reason_for_withdrawal;
            $history->comment = $request->reason_for_withdrawal_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->justification_rationale != $lastDocument->justification_rationale) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Justification Rationale';
            $history->previous = $lastDocument->justification_rationale;
            $history->current = $submission->justification_rationale;
            $history->comment = $request->justification_rationale_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->meeting_minutes != $lastDocument->meeting_minutes) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Meeting Minutes';
            $history->previous = $lastDocument->meeting_minutes;
            $history->current = $submission->meeting_minutes;
            $history->comment = $request->meeting_minutes_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->rejection_reason != $lastDocument->rejection_reason) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Rejection Reason';
            $history->previous = $lastDocument->rejection_reason;
            $history->current = $submission->rejection_reason;
            $history->comment = $request->rejection_reason_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->effectiveness_check_summary != $lastDocument->effectiveness_check_summary) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Effectiveness Check Summary';
            $history->previous = $lastDocument->effectiveness_check_summary;
            $history->current = $submission->effectiveness_check_summary;
            $history->comment = $request->effectiveness_check_summary_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->decisions != $lastDocument->decisions) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Decisions';
            $history->previous = $lastDocument->decisions;
            $history->current = $submission->decisions;
            $history->comment = $request->decisions_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->summary != $lastDocument->summary) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Summary';
            $history->previous = $lastDocument->summary;
            $history->current = $submission->summary;
            $history->comment = $request->summary_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->documents_affected != $lastDocument->documents_affected) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Documents Affected';
            $history->previous = $lastDocument->documents_affected;
            $history->current = $submission->documents_affected;
            $history->comment = $request->documents_affected_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->actual_time_spent != $lastDocument->actual_time_spent) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Actual Time Spent';
            $history->previous = $lastDocument->actual_time_spent;
            $history->current = $submission->actual_time_spent;
            $history->comment = $request->actual_time_spent_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($submission->documents != $lastDocument->documents) {
            $history = new CTASubmissionAuditTrail();
            $history->ctas_id = $submission->id;
            $history->activity_type = 'Documents';
            $history->previous = $lastDocument->documents;
            $history->current = $submission->documents;
            $history->comment = $request->documents_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            // $history->origin_state = $submission->status;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
        }

        $griddata = $submission->id;

        $newData = CTA_Submission_grid::where(['c_id' => $griddata, 'identifer' => 'ProductMaterialDetails'])->firstOrNew();
        $newData->update();

        $newData->c_id = $griddata;
        $newData->identifer = 'ProductMaterialDetails';
        $newData->data = $request->serial_number_gi;
        $newData->update();

        toastr()->success("Record is updated Successfully");
        return redirect(url('rcms/qms-dashboard'));
    }

    public function CTA_submission_show(Request $request, $id)
    {

        $data = CTASubmission::find($id);
        if (empty($data)) {
            toastr()->error('Invalid ID.');
            return back();
        }

        $parent = CTA_Submission_grid::where(['c_id' => $id, 'identifer' => 'ProductMaterialDetails'])->first();
        $newData = $parent ? $parent->data : null;

        $data->record = str_pad($data->record, 4, '0', STR_PAD_LEFT);
        $data->assign_to_name = User::where('id', $data->assign_to)->value('name');
        $data->initiator_name = User::where('id', $data->initiator_id)->value('name');
        return view('frontend.CTA-Submission.view', compact(
            'data',
            'newData'
        ));
    }

    public function CTA_submission_send_stage(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $root = CTASubmission::find($id);
            $lastDocument =  CTASubmission::find($id);

            if ($root->stage == 1) {
                $root->stage = "3";
                $root->status = "Dossier Finalization";

                $root->submission_by = Auth::user()->name;
                $root->submission_on = Carbon::now()->format('d-M-Y');

                $root->submission_comment = $request->comment;
                $history = new CTASubmissionAuditTrail();
                $history->ctas_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->submission_by;
                $history->current = $root->submission_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = '3';
                $history->change_to = $root->status;
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Submission';
                $history->save();

                $root->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($root->stage == 3) {
                $root->stage = "5";
                $root->status = 'Submitted for Authority';

                $root->finalize_dossier_by = Auth::user()->name;
                $root->finalize_dossier_on = Carbon::now()->format('d-M-Y');
                $root->finalize_dossier_comment = $request->comment;
                $history = new CTASubmissionAuditTrail();
                $history->ctas_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->finalize_dossier_by;
                $history->current = $root->finalize_dossier_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = '5';
                $history->change_to = $root->status;
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Finalize Dossier';
                $history->save();

                $root->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($root->stage == 5) {
                $root->stage = "7";
                $root->status = 'Approved with Comments/Conditions';

                $root->approved_with_conditions_by = Auth::user()->name;
                $root->approved_with_conditions_on = Carbon::now()->format('d-M-Y');
                $root->approved_with_conditions_comment = $request->comment;
                $history = new CTASubmissionAuditTrail();
                $history->ctas_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->approved_with_conditions_by;
                $history->current = $root->approved_with_conditions_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = '7';
                $history->change_to = $root->status;
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Approved with Conditions/Comments';
                $history->save();

                $root->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($root->stage == 7) {
                $root->stage = "8";
                $root->status = 'Pending Comments';

                $root->conditions_to_fulfill_before_FPI_by = Auth::user()->name;
                $root->conditions_to_fulfill_before_FPI_on = Carbon::now()->format('d-M-Y');
                $root->conditions_to_fulfill_before_FPI_comment = $request->comment;
                $history = new CTASubmissionAuditTrail();
                $history->ctas_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->conditions_to_fulfill_before_FPI_by;
                $history->current = $root->conditions_to_fulfill_before_FPI_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = '8';
                $history->change_to = $root->status;
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Conditions to Fulfill Before FPI';
                $history->save();

                $root->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($root->stage == 8) {
                $root->stage = "9";
                $root->status = 'RA Review of Response to Comments';

                $root->submit_response_by = Auth::user()->name;
                $root->submit_response_on = Carbon::now()->format('d-M-Y');
                $root->submit_response_comment = $request->comment;
                $history = new CTASubmissionAuditTrail();
                $history->ctas_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->submit_response_by;
                $history->current = $root->submit_response_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = '9';
                $history->change_to = $root->status;
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Submit response';
                $history->save();

                $root->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($root->stage == 9) {
                $root->stage = "10";
                $root->status = 'Closed - Terminated';

                $root->early_termination_by = Auth::user()->name;
                $root->early_termination_on = Carbon::now()->format('d-M-Y');
                $root->early_termination_comment = $request->comment;
                $history = new CTASubmissionAuditTrail();
                $history->ctas_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->early_termination_by;
                $history->current = $root->early_termination_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = '10';
                $history->change_to = $root->status;
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Early Termination';
                $history->save();

                $root->update();
                toastr()->success('Document Sent');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function CTA_submission_cancel(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $root = CTASubmission::find($id);
            $lastDocument =  CTASubmission::find($id);
            $data =  CTASubmission::find($id);

            if ($root->stage == 1) {
                $root->stage = "0";
                $root->status = "Closed-Cancelled";

                $root->cancelled_by = Auth::user()->name;
                $root->cancelled_on = Carbon::now()->format('d-M-Y');
                $root->cancelled_comment = $request->comment;
                $history = new CTASubmissionAuditTrail();
                $history->ctas_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->cancelled_by;
                $history->current = $root->cancelled_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = '0';
                $history->change_to = $root->status;
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Cancel';
                $history->save();

                $root->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($root->stage == 3) {
                $root->stage = "4";
                $root->status = "Closed - Withdrawn";

                $root->withdraw_by = Auth::user()->name;
                $root->withdraw_on = Carbon::now()->format('d-M-Y');
                $root->withdraw_comment = $request->comment;
                $history = new CTASubmissionAuditTrail();
                $history->ctas_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->withdraw_by;
                $history->current = $root->withdraw_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = '4';
                $history->change_to = $root->status;
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Withdraw';
                $history->save();

                $root->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($root->stage == 5) {
                $root->stage = "6";
                $root->status = "Closed – Not Approved";

                $root->not_approved_by = Auth::user()->name;
                $root->not_approved_on = Carbon::now()->format('d-M-Y');
                $root->not_approved_comment = $request->comment;
                $history = new CTASubmissionAuditTrail();
                $history->ctas_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->not_approved_by;
                $history->current = $root->not_approved_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = '6';
                $history->change_to = $root->status;
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Not Approved';
                $history->save();

                $root->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($root->stage == 7) {
                $root->stage = "11";
                $root->status = "Closed - Approved";

                $root->approved_by = Auth::user()->name;
                $root->approved_on = Carbon::now()->format('d-M-Y');
                $root->approved_comment = $request->comment;
                $history = new CTASubmissionAuditTrail();
                $history->ctas_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->approved_by;
                $history->current = $root->approved_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = '11';
                $history->change_to = $root->status;
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Approved';
                $history->save();

                $root->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($root->stage == 9) {
                $root->stage = "8";
                $root->status = "Pending Comments";

                $root->more_comments_by = Auth::user()->name;
                $root->more_comments_on = Carbon::now()->format('d-M-Y');
                $root->more_comments = $request->comment;
                $history = new CTASubmissionAuditTrail();
                $history->ctas_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->more_comments_by;
                $history->current = $root->more_comments_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = '8';
                $history->change_to = $root->status;
                $history->change_from = $lastDocument->status;
                $history->action_name = 'More Comments';
                $history->save();

                $root->update();
                toastr()->success('Document Sent');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function CTA_submission_reject(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $ctas = CTASubmission::find($id);
            $lastDocument =  CTASubmission::find($id);

            if ($ctas->stage == 1) {
                $ctas->stage = "2";
                $ctas->status = "Closed - Notified";

                $ctas->more_comments_by = Auth::user()->name;
                $ctas->more_comments_on = Carbon::now()->format('d-M-Y');
                $ctas->more_comments = $request->comment;
                $history = new CTASubmissionAuditTrail();
                $history->ctas_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->more_comments_by;
                $history->current = $ctas->more_comments_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = '2';
                $history->change_to = $ctas->status;
                $history->change_from = $lastDocument->status;
                $history->action_name = 'More Comments';
                $history->save();

                $ctas->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($ctas->stage == 5) {
                $ctas->stage = "11";
                $ctas->status = "Closed - Approved";

                $ctas->approved_by = Auth::user()->name;
                $ctas->approved_on = Carbon::now()->format('d-M-Y');
                $ctas->approved_comment = $request->comment;
                $history = new CTASubmissionAuditTrail();
                $history->ctas_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->approved_by;
                $history->current = $ctas->approved_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = '11';
                $history->change_to = $ctas->status;
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Approved';
                $history->save();

                $ctas->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($ctas->stage == 9) {
                $ctas->stage = "11";
                $ctas->status = "Closed - Approved";

                $ctas->all_conditions_are_met_by = Auth::user()->name;
                $ctas->all_conditions_are_met_on = Carbon::now()->format('d-M-Y');
                $ctas->all_conditions_are_met_comment = $request->comment;
                $history = new CTASubmissionAuditTrail();
                $history->ctas_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->approved_by;
                $history->current = $ctas->approved_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = '11';
                $history->change_to = $ctas->status;
                $history->change_from = $lastDocument->status;
                $history->action_name = 'All Conditions/Comments are met';
                $history->save();

                $ctas->update();
                toastr()->success('Document Sent');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function auditTrail(Request $request, $id)
    {
        $audit = CTASubmissionAuditTrail::where('ctas_id', $id)->orderByDESC('id')->get()->unique('activity_type');
        $today = Carbon::now()->format('d-m-y');
        $document = CTASubmission::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');

        return view("frontend.CTA-Submission.AuditTrail", compact('audit', 'document', 'today'));
    }

    public function singleReport($id)
    {
        $data = CTASubmission::find($id);
        $parent = CTA_Submission_grid::where(['c_id' => $id, 'identifer' => 'ProductMaterialDetails'])->first();
        $newData = $parent ? $parent->data : null;
        if (!empty($data)) {
            $data->originator_id = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.CTA-Submission.single_report', compact('data', 'newData'))
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
            return $pdf->stream('CTA-Submission' . $id . '.pdf');
        }
    }

    public function auditReport($id)
    {
        $doc = CTASubmission::find($id);
        if (!empty($doc)) {
            $doc->originator_id = User::where('id', $doc->initiator_id)->value('name');
            $data = CTASubmissionAuditTrail::where('ctas_id', $id)->get();
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.CTA-Submission.AuditReport', compact('data', 'doc'))
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
            $canvas->page_text($width / 4, $height / 2, $doc->status, null, 25, [0, 0, 0], 2, 6, -20);
            return $pdf->stream('CTA-Submision-Audit-Report' . $id . '.pdf');
        }
    }

    public function auditDetails(Request $request, $id)
    {
        $detail = CTASubmissionAuditTrail::find($id);

        $detail_data = CTASubmissionAuditTrail::where('activity_type', $detail->activity_type)->where('ctas_id', $detail->ctas_id)->latest()->get();

        $doc = CTASubmission::where('id', $detail->ctas_id)->first();

        $doc->origiator_name = User::find($doc->initiator_id);
        return view("frontend.CTA-Submission.audit-trail-inner", compact('detail', 'doc', 'detail_data'));
    }
}
