<?php

namespace App\Http\Controllers\newForm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\RecordNumber;
use App\Models\User;
use App\Models\SubjectAuditTrail;
use App\Models\RoleGroup;
use PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class SubjectController extends Controller
{
    public function subject()
    {
        $openState = Subject::all();
        $old_record = Subject::select('id', 'division_id', 'record')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4 ,'0', STR_PAD_LEFT);

        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('d-M-Y');

        $user = User::all();
        return view('frontend.ctms.subject', compact("record_number", "old_record", "due_date", "user",));
    }

    public function store(Request $request)
    {

        if (!$request->short_description) {
            toastr()->error("Short description is required");
            return redirect()->back();
        }

        $openState = new Subject();

        
        $recordCounter = RecordNumber::first();
        if (!$recordCounter) {
            toastr()->error("Record number counter not found");
            return redirect()->back();
        }
    
        $newRecordNumber = $recordCounter->counter + 1;

        $recordCounter->counter = $newRecordNumber;
        $recordCounter->save();

        $formattedRecordNumber = str_pad($newRecordNumber, 4, '0', STR_PAD_LEFT);


        $openState->status = 'Opened';
        $openState->stage = '1';

        $openState->initiator_id = Auth::user()->id;
        $openState->record = $formattedRecordNumber;
        $openState->division_code = $request->division_code;
        $openState->division_id = $request->division_id;
        $openState->initiation_date = $request->initiation_date;
        $openState->assign_to = $request->assign_to;
        $openState->phase_of_study = $request->phase_of_study;
        $openState->study_Num = $request->input('study_Num');
        $openState->due_date = $request->due_date;
        $openState->short_description = $request->short_description;
        $openState->related_urls = $request->related_urls;
        $openState->Description_Batch = $request->Description_Batch;
        $openState->actual_cost = $request->actual_cost;
        $openState->currency = $request->currency;
        $openState->Comments_Batch = $request->Comments_Batch;
        $openState->subject_name  = $request->subject_name;
        $openState->subject_date  = $request->subject_date;
        $openState->gender = $request->gender;
        $openState->race = $request->race;
        $openState->screened_successfully = $request->screened_successfully;
        $openState->discontinuation = $request->discontinuation;
        $openState->Disposition_Batch = $request->Disposition_Batch;
        $openState->treatment_consent = $request->treatment_consent;
        $openState->screening_consent = $request->screening_consent;
        $openState->exception_no = $request->exception_no;
        $openState->signed_consent  = $request->signed_consent;
        $openState->time_point  = $request->time_point;
        $openState->family_history = $request->family_history;
        $openState->Baseline_assessment = $request->Baseline_assessment;
        $openState->representive = $request->representive;
        $openState->zone = $request->zone;
        $openState->country = $request->country;
        $openState->city = $request->city;
        $openState->district = $request->district;
        $openState->site = $request->site;
        $openState->building = $request->building;
        $openState->floor = $request->floor;
        $openState->room = $request->room;
        $openState->consent_form = $request->consent_form;
        $openState->date_granted = $request->date_granted;
        $openState->system_start = $request->system_start;
        $openState->consent_form_date = $request->consent_form_date;
        $openState->first_treatment = $request->first_treatment;
        $openState->date_requested = $request->date_requested;
        $openState->date_screened = $request->date_screened;
        $openState->date_signed_treatment = $request->date_signed_treatment;
        $openState->date_effective_from = $request->date_effective_from;
        $openState->date_effective_to = $request->date_effective_to;
        $openState->last_active = $request->last_active;
        $openState->last_followup = $request->last_followup;

        if (!empty($request->file_attach)) {
            $files = [];
            if ($request->hasfile('file_attach')) {
                foreach ($request->file('file_attach') as $file) {
                    $name = $request->name . 'file_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }

            $openState->file_attach = json_encode($files);
        }

        if (!empty($request->document_attach)) {
            $files = [];
            if ($request->hasfile('document_attach')) {
                foreach ($request->file('document_attach') as $file) {
                    $name = $request->name . 'document_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }

            $openState->document_attach = json_encode($files);
        }

        $openState->save();

        if (!empty($request->short_description)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Null";
            $history->current = $openState->short_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->phase_of_study)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Phase Of Study';
            $history->previous = "Null";
            $history->current = $openState->phase_of_study;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->study_Num)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Study Num';
            $history->previous = "Null";
            $history->current = $openState->study_Num;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->assign_to)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Assigned To';
            $history->previous = "Null";
            $history->current = $openState->assign_to;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->file_attach)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Attached Files';
            $history->previous = "Null";
            $history->current = json_encode($openState->file_attach);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->related_urls)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Related URLs';
            $history->previous = "Null";
            $history->current = $openState->related_urls;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->Description_Batch)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Description';
            $history->previous = "Null";
            $history->current = $openState->Description_Batch;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->actual_cost)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Actual Cost';
            $history->previous = "Null";
            $history->current = $openState->actual_cost;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->currency)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Currency';
            $history->previous = "Null";
            $history->current = $openState->currency;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->Comments_Batch)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Comments';
            $history->previous = "Null";
            $history->current = $openState->Comments_Batch;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->document_attach)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Source Documents';
            $history->previous = "Null";
            $history->current = json_encode($openState->document_attach);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->subject_name)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Subject Name';
            $history->previous = "Null";
            $history->current = $openState->subject_name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->subject_date)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Subject Name';
            $history->previous = "Null";
            $history->current = $openState->subject_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->gender)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Gender';
            $history->previous = "Null";
            $history->current = $openState->gender;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->race)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Race';
            $history->previous = "Null";
            $history->current = $openState->race;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->screened_successfully)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'screened_successfully';
            $history->previous = "Null";
            $history->current = $openState->screened_successfully;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->discontinuation)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Reason For Discontinuation';
            $history->previous = "Null";
            $history->current = $openState->discontinuation;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->Disposition_Batch)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Comments';
            $history->previous = "Null";
            $history->current = $openState->Disposition_Batch;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->treatment_consent)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Treatment Consent Version';
            $history->previous = "Null";
            $history->current = $openState->treatment_consent;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->treatment_consent)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Treatment Consent Version';
            $history->previous = "Null";
            $history->current = $openState->treatment_consent;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->screening_consent)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Screening Consent Version';
            $history->previous = "Null";
            $history->current = $openState->screening_consent;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->exception_no)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Exception Number';
            $history->previous = "Null";
            $history->current = $openState->exception_no;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->signed_consent)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Signed Consent Form ';
            $history->previous = "Null";
            $history->current = $openState->signed_consent;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->time_point)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Time Point';
            $history->previous = "Null";
            $history->current = $openState->time_point;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->family_history)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Family History';
            $history->previous = "Null";
            $history->current = $openState->family_history;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->Baseline_assessment)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Baseline assessment';
            $history->previous = "Null";
            $history->current = $openState->Baseline_assessment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->representive)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Representive';
            $history->previous = "Null";
            $history->current = $openState->representive;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->zone)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Zone';
            $history->previous = "Null";
            $history->current = $openState->zone;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->country)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Country';
            $history->previous = "Null";
            $history->current = $openState->country;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->city)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'City';
            $history->previous = "Null";
            $history->current = $openState->city;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->district)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'State/District';
            $history->previous = "Null";
            $history->current = $openState->district;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->site)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Site Name';
            $history->previous = "Null";
            $history->current = $openState->site;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->building)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Building';
            $history->previous = "Null";
            $history->current = $openState->building;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->floor)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Floor';
            $history->previous = "Null";
            $history->current = $openState->floor;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->room)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Room';
            $history->previous = "Null";
            $history->current = $openState->room;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->consent_form)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Consent Form Signed On';
            $history->previous = "Null";
            $history->current = $openState->consent_form;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->date_granted)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Date Granted';
            $history->previous = "Null";
            $history->current = $openState->date_granted;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->system_start)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'System Start Date';
            $history->previous = "Null";
            $history->current = $openState->system_start;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->consent_form_date)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Consent Form Signed Date';
            $history->previous = "Null";
            $history->current = $openState->consent_form_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->first_treatment)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Date Of First Treatment';
            $history->previous = "Null";
            $history->current = $openState->first_treatment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->date_requested)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Date Requested';
            $history->previous = "Null";
            $history->current = $openState->date_requested;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->date_screened)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Date Screened';
            $history->previous = "Null";
            $history->current = $openState->date_screened;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->date_signed_treatment)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Date Signed Treatment Consent';
            $history->previous = "Null";
            $history->current = $openState->date_signed_treatment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->date_effective_from)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Effective From Date';
            $history->previous = "Null";
            $history->current = $openState->date_effective_from;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->date_effective_to)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Effective To Date';
            $history->previous = "Null";
            $history->current = $openState->date_effective_to;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->last_active)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = ' Last Active Treatment Date ';
            $history->previous = "Null";
            $history->current = $openState->last_active;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        if (!empty($request->last_followup)) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = ' Last Follow-up Date ';
            $history->previous = "Null";
            $history->current = $openState->last_followup;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';

            $history->save();
        }

        toastr()->success("Record is created Successfully");
        return redirect(url('rcms/qms-dashboard'));
    }


    public function edit($id)
    {
        $openState = Subject::find($id);



        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('d-M-Y');


        return view('frontend.ctms.subject_view', compact('openState', 'due_date'));
    }

    public function update(Request $request, $id)
    {

        $openState = Subject::find($id);
        $lastdocument = Subject::find($id);


        if (!$request->short_description) {
            toastr()->error("Short description is required");
            return redirect()->back();
        }

        $openState->assign_to = $request->assign_to;
        $openState->phase_of_study = $request->phase_of_study;
        $openState->study_Num = $request->input('study_Num');
        $openState->short_description = $request->short_description;
        $openState->related_urls = $request->related_urls;
        $openState->Description_Batch = $request->Description_Batch;
        $openState->actual_cost = $request->actual_cost;
        $openState->currency = $request->currency;
        $openState->Comments_Batch = $request->Comments_Batch;
        $openState->subject_name  = $request->subject_name;
        $openState->subject_date  = $request->subject_date;
        $openState->gender = $request->gender;
        $openState->race = $request->race;
        $openState->screened_successfully = $request->screened_successfully;
        $openState->discontinuation = $request->discontinuation;
        $openState->Disposition_Batch = $request->Disposition_Batch;
        $openState->treatment_consent = $request->treatment_consent;
        $openState->screening_consent = $request->screening_consent;
        $openState->exception_no = $request->exception_no;
        $openState->signed_consent  = $request->signed_consent;
        $openState->time_point  = $request->time_point;
        $openState->family_history = $request->family_history;
        $openState->Baseline_assessment = $request->Baseline_assessment;
        $openState->representive = $request->representive;
        $openState->zone = $request->zone;
        $openState->country = $request->country;
        $openState->city = $request->city;
        $openState->district = $request->district;
        $openState->site = $request->site;
        $openState->building = $request->building;
        $openState->floor = $request->floor;
        $openState->room = $request->room;
        $openState->consent_form = $request->consent_form;
        $openState->date_granted = $request->date_granted;
        $openState->system_start = $request->system_start;
        $openState->consent_form_date = $request->consent_form_date;
        $openState->first_treatment = $request->first_treatment;
        $openState->date_requested = $request->date_requested;
        $openState->date_screened = $request->date_screened;
        $openState->date_signed_treatment = $request->date_signed_treatment;
        $openState->date_effective_from = $request->date_effective_from;
        $openState->date_effective_to = $request->date_effective_to;
        $openState->last_active = $request->last_active;
        $openState->last_followup = $request->last_followup;

        if (!empty($request->file_attach)) {
            $files = [];
            if ($request->hasfile('file_attach')) {
                foreach ($request->file('file_attach') as $file) {
                    $name = $request->name . 'file_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }

            $openState->file_attach = json_encode($files);
        }

        if (!empty($request->document_attach)) {
            $files = [];
            if ($request->hasfile('document_attach')) {
                foreach ($request->file('document_attach') as $file) {
                    $name = $request->name . 'document_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }

            $openState->document_attach = json_encode($files);
        }

        $openState->save();

        if ($lastdocument->short_description != $request->short_description) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = ' Short Description';
            $history->previous = $lastdocument->short_description;
            $history->current = $request->short_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->short_description) || $lastdocument->short_description === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }
            $history->save();
        }

        if ($lastdocument->phase_of_study != $request->phase_of_study) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Phase of Study';
            $history->previous = $lastdocument->phase_of_study;
            $history->current = $request->phase_of_study;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->phase_of_study) || $lastdocument->phase_of_study === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastdocument->study_Num != $request->study_Num) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Study Num';
            $history->previous = $lastdocument->study_Num;
            $history->current = $request->study_Num;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->study_Num) || $lastdocument->study_Num === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastdocument->assign_to != $request->assign_to) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Study Num';
            $history->previous = $lastdocument->assign_to;
            $history->current = $request->assign_to;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->assign_to) || $lastdocument->assign_to === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }


            $history->save();
        }

        if ($lastdocument->file_attach != $request->file_attach) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Attached Files';
            $history->previous = json_encode($lastdocument->file_attach);
            $history->current = json_encode($openState->file_attach);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null(json_encode($lastdocument->file_attach)) ||json_encode($lastdocument->file_attach) === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastdocument->related_urls != $request->related_urls) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Related URLs';
            $history->previous = $lastdocument->related_urls;
            $history->current = $request->related_urls;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->related_urls) || $lastdocument->related_urls === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastdocument->Description_Batch != $request->Description_Batch) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Description';
            $history->previous = $lastdocument->Description_Batch;
            $history->current = $request->Description_Batch;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->Description_Batch) || $lastdocument->Description_Batch === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }
            

            $history->save();
        }

        if ($lastdocument->actual_cost != $request->actual_cost) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Actual Cost';
            $history->previous = $lastdocument->actual_cost;
            $history->current = $request->actual_cost;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->actual_cost) || $lastdocument->actual_cost === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }
            $history->save();
        }

        if ($lastdocument->currency != $request->currency) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Currency';
            $history->previous = $lastdocument->currency;
            $history->current = $request->currency;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->currency) || $lastdocument->currency === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }
            $history->save();
        }

        if ($lastdocument->Comments_Batch != $request->Comments_Batch) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Comments';
            $history->previous = $lastdocument->Comments_Batch;
            $history->current = $request->Comments_Batch;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->Comments_Batch) || $lastdocument->Comments_Batch === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }


            $history->save();
        }

        if ($lastdocument->document_attach != $request->document_attach) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Source Documents';
            $history->previous = json_encode($lastdocument->document_attach);
            $history->current = json_encode($openState->document_attach);
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null(json_encode($lastdocument->document_attach)) || json_encode($lastdocument->document_attach) === '')
            {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastdocument->subject_name != $request->subject_name) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Subject Name';
            $history->previous = $lastdocument->subject_name;
            $history->current = $request->subject_name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->subject_name) || $lastdocument->subject_name === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }


            $history->save();
        }

        if ($lastdocument->subject_date != $request->subject_date) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Subject Name';
            $history->previous = $lastdocument->subject_date;
            $history->current = $request->subject_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->subject_date) || $lastdocument->subject_date === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }


            $history->save();
        }

        if ($lastdocument->gender != $request->gender) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Gender';
            $history->previous = $lastdocument->gender;
            $history->current = $request->gender;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->gender) || $lastdocument->gender === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }


            $history->save();
        }

        if ($lastdocument->race != $request->race) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Race';
            $history->previous = $lastdocument->race;
            $history->current = $request->race;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->race) || $lastdocument->race === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }


            $history->save();
        }

        if ($lastdocument->screened_successfully != $request->screened_successfully) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Screened Successfully ';
            $history->previous = $lastdocument->screened_successfully;
            $history->current = $request->screened_successfully;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->screened_successfully) || $lastdocument->screened_successfully === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }


            $history->save();
        }

        if ($lastdocument->discontinuation != $request->discontinuation) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Reason For Discontinuation ';
            $history->previous = $lastdocument->discontinuation;
            $history->current = $request->discontinuation;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->discontinuation) || $lastdocument->discontinuation === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }


            $history->save();
        }

        if ($lastdocument->Disposition_Batch != $request->Disposition_Batch) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Comments';
            $history->previous = $lastdocument->Disposition_Batch;
            $history->current = $request->Disposition_Batch;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->Disposition_Batch) || $lastdocument->Disposition_Batch === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }
            
            $history->save();
        }

        if ($lastdocument->treatment_consent != $request->treatment_consent) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Treatment Consent Version';
            $history->previous = $lastdocument->treatment_consent;
            $history->current = $request->treatment_consent;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;

            if (is_null($lastdocument->treatment_consent) || $lastdocument->treatment_consent === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }
            

            $history->save();
        }

        if ($lastdocument->screening_consent != $request->screening_consent) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Screening Consent Version';
            $history->previous = $lastdocument->screening_consent;
            $history->current = $request->screening_consent;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->screening_consent) || $lastdocument->screening_consent === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastdocument->exception_no != $request->exception_no) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Exception Number';
            $history->previous = $lastdocument->exception_no;
            $history->current = $request->exception_no;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->exception_no) || $lastdocument->exception_no === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastdocument->signed_consent != $request->signed_consent) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Signed Consent Form';
            $history->previous = $lastdocument->signed_consent;
            $history->current = $request->signed_consent;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->signed_consent) || $lastdocument->signed_consent === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastdocument->time_point != $request->time_point) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Time Point';
            $history->previous = $lastdocument->time_point;
            $history->current = $request->time_point;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->time_point) || $lastdocument->time_point === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }



        if ($lastdocument->family_history != $request->family_history) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Family History';
            $history->previous = $lastdocument->family_history;
            $history->current = $request->family_history;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->family_history) || $lastdocument->family_history === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastdocument->Baseline_assessment != $request->Baseline_assessment) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Baseline_assessment';
            $history->previous = $lastdocument->Baseline_assessment;
            $history->current = $request->Baseline_assessment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->Baseline_assessment) || $lastdocument->Baseline_assessment === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastdocument->representive != $request->representive) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Representive';
            $history->previous = $lastdocument->representive;
            $history->current = $request->representive;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->representive) || $lastdocument->representive === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastdocument->zone != $request->zone) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Zone';
            $history->previous = $lastdocument->zone;
            $history->current = $request->zone;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->zone) || $lastdocument->zone === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastdocument->country != $request->country) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Country';
            $history->previous = $lastdocument->country;
            $history->current = $request->country;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->country) || $lastdocument->country === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastdocument->city != $request->city) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'City';
            $history->previous = $lastdocument->city;
            $history->current = $request->city;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->city) || $lastdocument->city === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastdocument->district != $request->district) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'State/District';
            $history->previous = $lastdocument->district;
            $history->current = $request->district;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->district) || $lastdocument->district === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }
            

            $history->save();
        }

        if ($lastdocument->site != $request->site) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Site Name';
            $history->previous = $lastdocument->site;
            $history->current = $request->site;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->site) || $lastdocument->site === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }



        if ($lastdocument->building != $request->building) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Building';
            $history->previous = $lastdocument->building;
            $history->current = $request->building;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->building) || $lastdocument->building === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastdocument->floor != $request->floor) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Floor';
            $history->previous = $lastdocument->floor;
            $history->current = $request->floor;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->floor) || $lastdocument->floor === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastdocument->room != $request->room) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Room';
            $history->previous = $lastdocument->room;
            $history->current = $request->room;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->room) || $lastdocument->room === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastdocument->consent_form != $request->consent_form) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Consent Form Signed On';
            $history->previous = $lastdocument->consent_form;
            $history->current = $request->consent_form;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->consent_form) || $lastdocument->consent_form === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastdocument->date_granted != $request->date_granted) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Date Granted';
            $history->previous = $lastdocument->date_granted;
            $history->current = $request->date_granted;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->date_grantede) || $lastdocument->date_granted === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastdocument->system_start != $request->system_start) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'System Start Date';
            $history->previous = $lastdocument->system_start;
            $history->current = $request->system_start;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->system_start) || $lastdocument->system_start === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastdocument->consent_form_date != $request->consent_form_date) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Consent Form Signed Date ';
            $history->previous = $lastdocument->consent_form_date;
            $history->current = $request->consent_form_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->consent_form_date) || $lastdocument->consent_form_date === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }


            $history->save();
        }

        if ($lastdocument->first_treatment != $request->first_treatment) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Date Of First Treatment ';
            $history->previous = $lastdocument->first_treatment;
            $history->current = $request->first_treatment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->first_treatment) || $lastdocument->first_treatment === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }
             $history->save();
        }

        if ($lastdocument->date_requested != $request->date_requested) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Date Requested ';
            $history->previous = $lastdocument->date_requested;
            $history->current = $request->date_requested;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->date_requested) || $lastdocument->date_requested === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastdocument->date_screened != $request->date_screened) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Date Screened';
            $history->previous = $lastdocument->date_screened;
            $history->current = $request->date_screened;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->date_screened) || $lastdocument->date_screened === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }


            $history->save();
        }

        if ($lastdocument->date_signed_treatment != $request->date_signed_treatment) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Date Signed Treatment Consent';
            $history->previous = $lastdocument->date_signed_treatment;
            $history->current = $request->date_signed_treatment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->date_signed_treatment) || $lastdocument->date_signed_treatment === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastdocument->date_effective_from != $request->date_effective_from) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Effective From Date';
            $history->previous = $lastdocument->date_effective_from;
            $history->current = $request->date_effective_from;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
             if (is_null($lastdocument->date_effective_from) || $lastdocument->date_effective_from === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastdocument->date_effective_to != $request->date_effective_to) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Effective To Date';
            $history->previous = $lastdocument->date_effective_to;
            $history->current = $request->date_effective_to;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->date_effective_to) || $lastdocument->date_effective_to === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }

            $history->save();
        }

        if ($lastdocument->last_active != $request->last_active) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Last Active Treatment Date';
            $history->previous = $lastdocument->last_active;
            $history->current = $request->last_active;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->date_effective_to) || $lastdocument->date_effective_to === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }
             $history->save();
        }

        if ($lastdocument->last_followup != $request->last_followup) {
            $history = new SubjectAuditTrail();
            $history->sub_id = $openState->id;
            $history->activity_type = 'Last Follow-up Date';
            $history->previous = $lastdocument->last_followup;
            $history->current = $request->last_followup;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Not Applicable";
            $history->change_from = $lastdocument->status;
            if (is_null($lastdocument->last_followup) || $lastdocument->last_followup === '') {
                $history->action_name = 'New';
            } else {
                $history->action_name = 'Update';
            }
            

            $history->save();
        }
        return redirect()->back();
    }

    public function subject_send_stage(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = Subject::find($id);
            if ($changeControl->stage == 1) {
                $changeControl->stage = "2";
                $changeControl->status = "Active";
                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changeControl->stage == 2) {
                $changeControl->stage = "3";
                $changeControl->status = "Closed-Done";
                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }
        }
    }

    public function subjectCancel(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = Subject::find($id);
            if ($changeControl->stage == 1) {
                $changeControl->stage = "0";
                $changeControl->status = "Closed-Cancelled";
                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }
        }
    }


    public function subject_child(Request $request, $id)
    {

        if ($request->child_type == 'violation') {
            return view('frontend.ctms.violation');
        } else {
            return view('frontend.ctms.subject_action_item');
        }
    }

    public function auditReport(Request $request, $id)
    {
        $subject = Subject::find($id);

        $audit = SubjectAuditTrail::where('sub_id', $id)->orderByDesc('id')->paginate();

        $today = Carbon::now();

        $document = Subject::where('id', $id)->first();

        $document->originator = User::where('id', $document->initiator_id)->value('name');

        return view('frontend.ctms.auditTrails-subject', compact("subject", "audit", "today", "document"));
    }

    public function subjectDetails($id){
        $detail = SubjectAuditTrail::find($id);
        $detail_data = SubjectAuditTrail::where('activity_type', $detail->activity_type)->where('sub_id', $detail->sub_id)->latest()->get();
        $doc = Subject::where('id', $detail->sub_id)->first();
        $doc->origiator_name = User::find($doc->initiator_id);
        return view('frontend.ctms.Subjectaudit-trial-details', compact('detail', 'doc', 'detail_data'));
    }

    public function subSingleReport($id){
        
            $data = Subject::find($id);
            if (!empty ($data)) {
                $data->originator = User::where('id', $data->initiator_id)->value('name');
                $pdf = App::make('dompdf.wrapper');
                $time = Carbon::now();
                $pdf = PDF::loadview('frontend.ctms.singleReportsubject', compact('data'))
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
                return $pdf->stream('Subject' . $id . '.pdf');
            }
        
    }
}