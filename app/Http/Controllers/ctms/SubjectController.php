<?php

namespace App\Http\Controllers\ctms;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\SubjectAuditTrial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\RoleGroup;




class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontend.ctms.subject.subject');
    }

//    ================================================================store=============================
    public function store(Request $request)
    {
        $subject = new Subject();
    
    $subject->record_number = $request->input('record_number');
    $subject->division_id = $request->input('division_id');
    $subject->initiator = $request->input('initiator');
    $subject->initiation_date = $request->input('initiation_date');
    $subject->short_description = $request->input('short_description');
    $subject->phase_of_study = json_encode($request->input('phase_of_study', []));
    $subject->study_num = $request->input('study_num');
    $subject->assign_to = $request->input('assign_to');
    $subject->due_date = $request->input('due_date');
    $subject->related_urls = $request->input('related_urls');
    $subject->description = $request->input('description');
    $subject->actual_cost = $request->input('actual_cost');
    $subject->currency = $request->input('currency');
    $subject->comments = $request->input('comments');
    $subject->subject_name = $request->input('subject_name');
    $subject->subject_dob = $request->input('subject_dob');
    $subject->gender = $request->input('gender');
    $subject->race = $request->input('race');
    $subject->screened_successfully = $request->input('screened_successfully');
    $subject->reason_discontinuation = $request->input('reason_discontinuation');
    $subject->treatment_consent_version = $request->input('treatment_consent_version');
    $subject->screening_consent_version = $request->input('screening_consent_version');
    $subject->exception_number = $request->input('exception_number');
    $subject->signed_consent_form = $request->input('signed_consent_form');
    $subject->time_point = $request->input('time_point');
    $subject->family_history = $request->input('family_history');
    $subject->baseline_assessment = $request->input('baseline_assessment');
    $subject->representative = $request->input('representative');
    $subject->zone = $request->input('zone');
    $subject->country = $request->input('country');
    $subject->city = $request->input('city');
    $subject->state_district = $request->input('state_district');
    $subject->site_name = $request->input('site_name');
    $subject->building = $request->input('building');
    $subject->floor = $request->input('floor');
    $subject->room = $request->input('room');
    $subject->consent_form_signed_on = $request->input('consent_form_signed_on');
    $subject->date_granted = $request->input('date_granted');
    $subject->system_start_date = $request->input('system_start_date');
    $subject->consent_form_signed_date = $request->input('consent_form_signed_date');
    $subject->date_first_treatment = $request->input('date_first_treatment');
    $subject->date_requested = $request->input('date_requested');
    $subject->date_screened = $request->input('date_screened');
    $subject->date_signed_treatment_consent = $request->input('date_signed_treatment_consent');
    $subject->effective_from_date = $request->input('effective_from_date');
    $subject->effective_to_date = $request->input('effective_to_date');
    $subject->last_active_treatment_date = $request->input('last_active_treatment_date');
    $subject->last_followup_date = $request->input('last_followup_date');
    $subject->stage = 1;
    $subject->status = 'Opened';

    // Handle file attachments
    if ($request->hasFile('Attachment')) {
        $attachments = [];
        foreach ($request->file('Attachment') as $file) {
            $path = $file->store('attachments', 'public');
            $attachments[] = $path;
        }
        $subject->attachments = json_encode($attachments);
    }

    // Handle source documents
    if ($request->hasFile('Source_Documents')) {
        $sourceDocuments = [];
        foreach ($request->file('Source_Documents') as $file) {
            $path = $file->store('source_documents', 'public');
            $sourceDocuments[] = $path;
        }
        $subject->source_documents = json_encode($sourceDocuments);
    }

    // Save the record to the database
    $subject->save();
    return "store";

    }

// ==================================================== Show==============================================
    public function show($id)
    {
        $data = Subject::findoRFail($id);
        // dd($data);
        return view('frontend.ctms.subject.subject_view',compact('data'));
    }

    // ===============================================================update===================================================
    public function update(Request $request, $id)
    {
        
    }





    // ==================================================================stage ======================================

    public function subjectStateChange(Request $request,$id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $subjectstag = Subject::find($id);
            $lastDocument =  Subject::find($id);
            $data = Subject::find($id);


           if( $subjectstag->stage == 1){
            $subjectstag->stage = "2";
            // $subjectstag->submited_by = Auth::user()->name;
            // $subjectstag->submited_on = Carbon::now()->format('d-M-Y');
            // $subjectstag->submitted_comment = $request->comment;


            $subjectstag->status = "Opened";
            $history = new SubjectAuditTrial();
            $history->subject_id = $id;
            $history->activity_type = 'Activity Log';
            $history->current = $subjectstag->submitted_by;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Opened";
            $history->change_from = $lastDocument->status;
            $history->stage='To Implementation Phase';
            $history->save();

            $subjectstag->update();

            return redirect()->back();
           }



           if( $subjectstag->stage == 2){
            $subjectstag->stage = "3";
            // $subjectstag->to_pending_by = Auth::user()->name;
            // $subjectstag->	to_Pending_on = Carbon::now()->format('d-M-Y');
            // $subjectstag->submitted_comment = $request->comment;


            $subjectstag->status = "Implementation Phase";
            $history = new SubjectAuditTrial();
            $history->subject_id = $id;
            $history->activity_type = 'Activity Log';
            $history->current = $subjectstag->submitted_by;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Implementation Phase";
            $history->change_from = $lastDocument->status;
            $history->stage='To Pending';
            $history->save();

            $subjectstag->update();

            return redirect()->back();
           }
           if( $subjectstag->stage == 3){
            $subjectstag->stage = "4";
            $subjectstag->to_In_Effect_by = Auth::user()->name;
            $subjectstag->to_In_Effect_on= Carbon::now()->format('d-M-Y');
            // $subjectstag->submitted_comment = $request->comment;


            $subjectstag->status = "Pending";
            $history = new SubjectAuditTrial();
            $history->subject_id = $id;
            $history->activity_type = 'Activity Log';
            $history->current = $subjectstag->submitted_by;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Pending";
            $history->change_from = $lastDocument->status;
            $history->stage='To In Effect';
            $history->save();

            $subjectstag->update();

            return redirect()->back();
           }

    }
    }
//   =======================================================destrioy===========================
    public function destroy($id)
    {
        //
    }
}
