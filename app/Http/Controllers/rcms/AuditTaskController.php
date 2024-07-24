<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AuditTask;
use App\Models\RecordNumber;
use App\Models\AuditTaskAuditTrial;
use App\Models\RoleGroup;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use PDF;
use Helpers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;



class AuditTaskController extends Controller
{
    public function index(){

        
        $old_record = AuditTask::select('id', 'division_id', 'record')->get();
        $record = ((RecordNumber::first()->value('counter')) + 1);
        $record = str_pad($record, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $closure_of_task = $formattedDate->format('Y-m-d');

        return view('frontend.auditTask.audit_task_new',compact('old_record','closure_of_task','record'));
    }

    public function Store(Request $request){

        $data = new AuditTask();
        $data->form_type = "AuditTask";
        $data->record            = ((RecordNumber::first()->value('counter')) + 1);
        $data->open_date         = $request->open_date;
         $data->division_id = $request->division_id;
        $data->audit_nu          = $request->audit_nu;
        $data->audit_report_nu       = $request->audit_report_nu;
        $data->final_responce_on     = $request->final_responce_on;
        $data->name_contract_testing     = $request->name_contract_testing;
        $data->tcd_capa_implimention = $request->tcd_capa_implimention;
        $data->initiator_id          = Auth::user()->id;
        $data->date_opened           = $request->date_opened;
        $data->short_description     = $request->short_description;
        $data->classification        = $request->classification;
        $data->closure_of_task       = $request->closure_of_task;
        $data->assignee              = $request->assignee;
        $data->observation           = $request->observation;
        $data->complience_details    = $request->complience_details;
        $data->identified_reasons    = $request->identified_reasons;
        $data->capa_respond          = $request->capa_respond;
        $data->timeline_by_auditee   = $request->timeline_by_auditee;
        $data->compliance_details    = $request->compliance_details;
        $data->date_of_implemetation = $request->date_of_implemetation;
        $data->verification_comments = $request->verification_comments;
        $data->dealy_justification_for_implementation = $request->dealy_justification_for_implementation;
        $data->delay_just_closure    = $request->delay_just_closure;
        $data->followup_task         = $request->followup_task;
        // $data ->followup_task = $request->followup_task=="Followup Task" ? null: $request->followup_task;
        // $data ->ref_of_followup = $request->ref_of_followup=="Ref of Followup" ? null: $request->ref_of_followup;
        $data->ref_of_followup       = $request->ref_of_followup;

        if (!empty($request->audit_task_attach) && $request->file('audit_task_attach')) {
            $files = [];
            foreach ($request->file('audit_task_attach') as $file) {
                $name = $request->name . 'audit_task_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] =  $name; // Store the file path
            }
            // Save the file paths in the database
            $data->audit_task_attach = json_encode($files);
        } 


        if (!empty($request->exe_attechment) && $request->file('exe_attechment')) {
            $files = [];
            foreach ($request->file('exe_attechment') as $file) {
                $name = $request->name . 'exe_attechment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] =  $name; // Store the file path
            }
            // Save the file paths in the database
            $data->exe_attechment    = json_encode($files);
        } 
       
        if (!empty($request->verification_attechment) && $request->file('verification_attechment')) {
            $files = [];
            foreach ($request->file('verification_attechment') as $file) {
                $name = $request->name . 'verification_attechment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] =  $name; // Store the file path
            }
            // Save the file paths in the database
            $data->verification_attechment = json_encode($files);
        } 
        
        $data->status = 'Opened';                 
        $data->stage = 1;
        $data->save();

        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter'))+1);
        $record->update();
            if (!empty($data->division_code)) {
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Division Code';
            $history->previous = "Null";
            $history->current = $data->division_code;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }  
           if (!empty($data->date_opened)) {
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Date Opened';
            $history->previous = "Null";
            $history->current = $data->date_opened;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }  
        if (!empty($data->short_description)) {
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Null";
            $history->current = $data->short_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }  

          if (!empty($data->classification)) {
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Classification';
            $history->previous = "Null";
            $history->current = $data->classification;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }  
         if (!empty($data->closure_of_task)) {
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Closure of Task';
            $history->previous = "Null";
            $history->current = $data->closure_of_task;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }  
        
        if (!empty($data->assignee)) {
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Assignee';
            $history->previous = "Null";
            $history->current = $data->assignee;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }  

        if (!empty($data->observation)) {
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Observation';
            $history->previous = "Null";
            $history->current = $data->observation;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }  

        if (!empty($data->complience_details)) {
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Complience Details';
            $history->previous = "Null";
            $history->current = $data->complience_details;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }  
       if (!empty($data->identified_reasons)) {
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Identified Reasons';
            $history->previous = "Null";
            $history->current = $data->identified_reasons;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }  

        if (!empty($data->capa_respond)) {
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Capa Respond';
            $history->previous = "Null";
            $history->current = $data->capa_respond;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }  


          if (!empty($data->timeline_by_auditee)) {
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Timeline by Auditee';
            $history->previous = "Null";
            $history->current = $data->timeline_by_auditee;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }  

         if (!empty($data->audit_task_attach)) {
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Audit task Attach';
            $history->previous = "Null";
            $history->current = $data->audit_task_attach;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }  

        if (!empty($data->compliance_details)) {
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Compliance Details';
            $history->previous = "Null";
            $history->current = $data->compliance_details;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }  

        if (!empty($data->date_of_implemetation)) {
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Date of Implemetation';
            $history->previous = "Null";
            $history->current = $data->date_of_implemetation;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }  

        if (!empty($data->verification_comments)) {
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Verification Comments';
            $history->previous = "Null";
            $history->current = $data->verification_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }  
        if (!empty($data->dealy_justification_for_implementation)) {
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Dealy Justification for Implementation';
            $history->previous = "Null";
            $history->current = $data->dealy_justification_for_implementation;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }  
        if (!empty($data->delay_just_closure)) {
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Delay just Closure';
            $history->previous = "Null";
            $history->current = $data->delay_just_closure;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }  

        if (!empty($data->followup_task)) {
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Followup Task';
            $history->previous = "Null";
            $history->current = $data->followup_task;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }  

        if (!empty($data->ref_of_followup)) {
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Ref of Followup';
            $history->previous = "Null";
            $history->current = $data->ref_of_followup;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }  

        if (!empty($data->exe_attechment)) {
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Exe Attechment';
            $history->previous = "Null";
            $history->current = $data->exe_attechment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }  
        if (!empty($data->verification_attechment)) {
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = '\Verification Attechment';
            $history->previous = "Null";
            $history->current = $data->verification_attechment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }  
        toastr()->success("Record is created Successfully");
        return redirect(url('rcms/qms-dashboard'));

        // dd($data);        
    }

    public function AuditTaskShow($id){

        $dataas = AuditTask::where('id',$id)->first();  
        $old_record = AuditTask::select('id', 'division_id', 'record')->get();
        $record = ((RecordNumber::first()->value('counter')) + 1);
        $record = str_pad($record, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $closure_of_task = $formattedDate->format('Y-m-d');

    
        return view('frontend.auditTask.audit_task_view',compact('dataas','closure_of_task','old_record','record'));
    }

    public function update(Request $request,$id){

        $data = AuditTask::find($id);
        $lastDocument = AuditTask::find($id);
        $lastdata = AuditTask::find($id);
        $lastDocumentRecord = AuditTask::find($data->id);
        $lastDocumentStatus = $lastDocumentRecord ? $lastDocumentRecord->status : null;

        $data->open_date  = $request->open_date;
        $data->division_id = $request->division_id;
        $data->audit_nu = $request->audit_nu;
        $data->record = $data->record;
        $data->audit_report_nu = $request->audit_report_nu;
        $data->final_responce_on = $request->final_responce_on;
        $data->name_contract_testing = $request->name_contract_testing;
        $data->tcd_capa_implimention = $request->tcd_capa_implimention;
        // $data->initiator_id          = $request->initiator_id;
        $data->date_opened = $request->date_opened;
        $data->short_description = $request->short_description;
        $data->classification = $request->classification;
        $data->closure_of_task = $request->closure_of_task;
        $data->assignee = $request->assignee;
        $data->observation = $request->observation;
        $data->complience_details = $request->complience_details;
        $data->identified_reasons = $request->identified_reasons;
        $data->capa_respond = $request->capa_respond;
        $data->timeline_by_auditee = $request->timeline_by_auditee;
        $data->compliance_details = $request->compliance_details;
        $data->date_of_implemetation = $request->date_of_implemetation;
        $data->verification_comments = $request->verification_comments;
        $data->dealy_justification_for_implementation = $request->dealy_justification_for_implementation;
        $data->delay_just_closure =$request->delay_just_closure;
        $data->followup_task = $request->followup_task;
        $data->ref_of_followup = $request->ref_of_followup;
        // $data ->followup_task = $request->followup_task=="Select Followup Task" ? null: $request->followup_task;
        // $data ->ref_of_followup = $request->ref_of_followup=="Select Ref of Followup" ? null: $request->ref_of_followup;
        
        if (!empty($request->audit_task_attach) && $request->file('audit_task_attach')) {
            $files = [];
            foreach ($request->file('audit_task_attach') as $file) {
                $name = $request->name . 'audit_task_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] =  $name; // Store the file path
            }
            // Save the file paths in the database
            $data->audit_task_attach = json_encode($files);
        } 

        if (!empty($request->exe_attechment) && $request->file('exe_attechment')) {
            $files = [];
            foreach ($request->file('exe_attechment') as $file) {
                $name = $request->name . 'exe_attechment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] =  $name; // Store the file path
            }
            // Save the file paths in the database
            $data->exe_attechment    = json_encode($files);
        }

        if (!empty($request->verification_attechment) && $request->file('verification_attechment')) {
            $files = [];
            foreach ($request->file('verification_attechment') as $file) {
                $name = $request->name . 'verification_attechment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] =  $name; // Store the file path
            }
            // Save the file paths in the database
            $data->verification_attechment = json_encode($files);
        }

        $data->update();

           if($lastDocument->division_code !=$data->division_code || !empty($request->division_code_comment)) {
            $lastDocumentAuditTrail = AuditTaskAuditTrial::where('audit_tasks_id', $data->id)
                            ->where('activity_type', 'Division Code')
                            ->exists();
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Division Code';
            $history->previous =  $lastDocument->division_code;
            $history->current = $data->division_code;
            $history->comment = $request->division_code_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
        
           if($lastDocument->date_opened !=$data->date_opened || !empty($request->date_opened_comment)) {
            $lastDocumentAuditTrail = AuditTaskAuditTrial::where('audit_tasks_id', $data->id)
                            ->where('activity_type', 'Date Opened')
                            ->exists();
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Date Opened';
            $history->previous =  $lastDocument->date_opened;
            $history->current = $data->date_opened;
            $history->comment = $request->date_opened_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
        
     
           if($lastDocument->short_description !=$data->short_description || !empty($request->short_description_comment)) {
            $lastDocumentAuditTrail = AuditTaskAuditTrial::where('audit_tasks_id', $data->id)
                            ->where('activity_type', 'Short Description')
                            ->exists();
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Short Description';
            $history->previous =  $lastDocument->short_description;
            $history->current = $data->short_description;
            $history->comment = $request->short_description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }

           if($lastDocument->classification !=$data->classification || !empty($request->classification_comment)) {
            $lastDocumentAuditTrail = AuditTaskAuditTrial::where('audit_tasks_id', $data->id)
                            ->where('activity_type', 'Classification')
                            ->exists();
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Classification';
            $history->previous =  $lastDocument->classification;
            $history->current = $data->classification;
            $history->comment = $request->classification_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
        if($lastDocument->closure_of_task !=$data->closure_of_task || !empty($request->closure_of_task_comment)) {
            $lastDocumentAuditTrail = AuditTaskAuditTrial::where('audit_tasks_id', $data->id)
                            ->where('activity_type', 'Closure of Task')
                            ->exists();
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Closure of Task';
            $history->previous =  $lastDocument->closure_of_task;
            $history->current = $data->closure_of_task;
            $history->comment = $request->closure_of_task_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
        
             if($lastDocument->assignee !=$data->assignee || !empty($request->assignee_comment)) {
            $lastDocumentAuditTrail = AuditTaskAuditTrial::where('audit_tasks_id', $data->id)
                            ->where('activity_type', 'Assignee')
                            ->exists();
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Assignee';
            $history->previous =  $lastDocument->assignee;
            $history->current = $data->assignee;
            $history->comment = $request->assignee_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
            if($lastDocument->observation !=$data->observation || !empty($request->observation_comment)) {
            $lastDocumentAuditTrail = AuditTaskAuditTrial::where('audit_tasks_id', $data->id)
                            ->where('activity_type', 'Observation')
                            ->exists();
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Observation';
            $history->previous =  $lastDocument->observation;
            $history->current = $data->observation;
            $history->comment = $request->observation_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }

        
            if($lastDocument->complience_details !=$data->complience_details || !empty($request->complience_details_comment)) {
            $lastDocumentAuditTrail = AuditTaskAuditTrial::where('audit_tasks_id', $data->id)
                            ->where('activity_type', 'Complience Details')
                            ->exists();
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Complience Details';
            $history->previous =  $lastDocument->complience_details;
            $history->current = $data->complience_details;
            $history->comment = $request->complience_details_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
            if($lastDocument->identified_reasons !=$data->identified_reasons || !empty($request->identified_reasons_comment)) {
            $lastDocumentAuditTrail = AuditTaskAuditTrial::where('audit_tasks_id', $data->id)
                            ->where('activity_type', 'Identified Reasons')
                            ->exists();
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Identified Reasons';
            $history->previous =  $lastDocument->identified_reasons;
            $history->current = $data->identified_reasons;
            $history->comment = $request->identified_reasons_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }

            if($lastDocument->capa_respond !=$data->capa_respond || !empty($request->capa_respond_comment)) {
            $lastDocumentAuditTrail = AuditTaskAuditTrial::where('audit_tasks_id', $data->id)
                            ->where('activity_type', 'Capa Respond')
                            ->exists();
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Capa Respond';
            $history->previous =  $lastDocument->capa_respond;
            $history->current = $data->capa_respond;
            $history->comment = $request->capa_respond_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }


            if($lastDocument->timeline_by_auditee !=$data->timeline_by_auditee || !empty($request->timeline_by_auditee_comment)) {
            $lastDocumentAuditTrail = AuditTaskAuditTrial::where('audit_tasks_id', $data->id)
                            ->where('activity_type', 'Timeline by Auditee')
                            ->exists();
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Timeline by Auditee';
            $history->previous =  $lastDocument->timeline_by_auditee;
            $history->current = $data->timeline_by_auditee;
            $history->comment = $request->timeline_by_auditee_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
            if($lastDocument->audit_task_attach !=$data->audit_task_attach || !empty($request->audit_task_attach_comment)) {
            $lastDocumentAuditTrail = AuditTaskAuditTrial::where('audit_tasks_id', $data->id)
                            ->where('activity_type', 'Audit Task Attach')
                            ->exists();
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Audit Task Attach';
            $history->previous =  $lastDocument->audit_task_attach;
            $history->current = $data->audit_task_attach;
            $history->comment = $request->audit_task_attach_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
            if($lastDocument->compliance_details !=$data->compliance_details || !empty($request->compliance_details_comment)) {
            $lastDocumentAuditTrail = AuditTaskAuditTrial::where('audit_tasks_id', $data->id)
                            ->where('activity_type', 'Compliance Details')
                            ->exists();
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Compliance Details';
            $history->previous =  $lastDocument->compliance_details;
            $history->current = $data->compliance_details;
            $history->comment = $request->compliance_details_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
         }
            if($lastDocument->date_of_implemetation !=$data->date_of_implemetation || !empty($request->date_of_implemetation_comment)) {
            $lastDocumentAuditTrail = AuditTaskAuditTrial::where('audit_tasks_id', $data->id)
                            ->where('activity_type', 'Date of Implemetation')
                            ->exists();
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Date of Implemetation';
            $history->previous =  $lastDocument->date_of_implemetation;
            $history->current = $data->date_of_implemetation;
            $history->comment = $request->date_of_implemetation_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }

            if($lastDocument->verification_comments !=$data->verification_comments || !empty($request->verification_comments_comment)) {
            $lastDocumentAuditTrail = AuditTaskAuditTrial::where('audit_tasks_id', $data->id)
                            ->where('activity_type', 'Verification Comments')
                            ->exists();
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Verification Comments';
            $history->previous =  $lastDocument->verification_comments;
            $history->current = $data->verification_comments;
            $history->comment = $request->verification_comments_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
            if($lastDocument->dealy_justification_for_implementation !=$data->dealy_justification_for_implementation || !empty($request->dealy_justification_for_implementation_comment)) {
            $lastDocumentAuditTrail = AuditTaskAuditTrial::where('audit_tasks_id', $data->id)
                            ->where('activity_type', 'Dealy Justification for Implementation')
                            ->exists();
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Dealy Justification for Implementation';
            $history->previous =  $lastDocument->dealy_justification_for_implementation;
            $history->current = $data->dealy_justification_for_implementation;
            $history->comment = $request->dealy_justification_for_implementation_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }

            if($lastDocument->delay_just_closure !=$data->delay_just_closure || !empty($request->delay_just_closure_comment)) {
            $lastDocumentAuditTrail = AuditTaskAuditTrial::where('audit_tasks_id', $data->id)
                            ->where('activity_type', 'Delay just Closure')
                            ->exists();
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Delay just Closure';
            $history->previous =  $lastDocument->delay_just_closure;
            $history->current = $data->delay_just_closure;
            $history->comment = $request->delay_just_closure_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }

            if($lastDocument->followup_task !=$data->followup_task || !empty($request->followup_task_comment)) {
            $lastDocumentAuditTrail = AuditTaskAuditTrial::where('audit_tasks_id', $data->id)
                            ->where('activity_type', 'Followup Task')
                            ->exists();
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Followup Task';
            $history->previous =  $lastDocument->followup_task;
            $history->current = $data->followup_task;
            $history->comment = $request->followup_task_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }

            if($lastDocument->ref_of_followup !=$data->ref_of_followup || !empty($request->ref_of_followup_comment)) {
            $lastDocumentAuditTrail = AuditTaskAuditTrial::where('audit_tasks_id', $data->id)
                            ->where('activity_type', 'Ref of Followup')
                            ->exists();
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Ref of Followup';
            $history->previous =  $lastDocument->ref_of_followup;
            $history->current = $data->ref_of_followup;
            $history->comment = $request->ref_of_followup_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }

            if($lastDocument->exe_attechment !=$data->exe_attechment || !empty($request->exe_attechment_comment)) {
            $lastDocumentAuditTrail = AuditTaskAuditTrial::where('audit_tasks_id', $data->id)
                            ->where('activity_type', 'Exe Attechment')
                            ->exists();
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Exe Attechment';
            $history->previous =  $lastDocument->exe_attechment;
            $history->current = $data->exe_attechment;
            $history->comment = $request->exe_attechment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
            if($lastDocument->verification_attechment !=$data->verification_attechment || !empty($request->verification_attechment_comment)) {
            $lastDocumentAuditTrail = AuditTaskAuditTrial::where('audit_tasks_id', $data->id)
                            ->where('activity_type', 'Verification Attechment')
                            ->exists();
            $history = new AuditTaskAuditTrial();
            $history->audit_tasks_id = $data->id;
            $history->activity_type = 'Verification Attechment';
            $history->previous =  $lastDocument->verification_attechment;
            $history->current = $data->verification_attechment;
            $history->comment = $request->verification_attechment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
        toastr()->success('Record is Update Successfully');
        return back();


    }

    public function auditStage(Request $request, $id)
    {
    if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = AuditTask::find($id);
            $lastDocument =  AuditTask::find($id);
            $data =  AuditTask::find($id);

            if ($changeControl->stage == 1) {
                $changeControl->stage = "2";
                $changeControl->	submited_by = Auth::user()->name;
                $changeControl->submited_on = Carbon::now()->format('d-M-Y');
                $changeControl->submit_comment  = $request->comment;
                $changeControl->status = "Compliance Verification";
                $history = new AuditTaskAuditTrial();
                $history->audit_tasks_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action ='Submit';
                $history->previous = $lastDocument->	submited_by;
                $history->current = $changeControl->	submited_by;
                $history->submit_comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='Submit';
                $history->change_to= "Compliance Verification";
                $history->change_from= "Opened";
                $history->action_name ='Not Applicable';

                $history->save();
                $list = Helpers::getHodUserList();
                    foreach ($list as $u) {
                      
                        if($u->q_m_s_divisions_id == $changeControl->division_id){
                            $email = Helpers::getInitiatorEmail($u->user_id);
                             if ($email !== null) {
                            try{
                              Mail::send(
                                  'mail.view-mail',
                                   ['data' => $changeControl],
                                function ($message) use ($email) {
                                    $message->to($email)
                                        ->subject("Document is Submitted By ".Auth::user()->name);
                                }
                              );
                            }
                             catch(\Exception $e){
                            //log error
                        }}
                     } 
                  }

                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }
        if ($changeControl->stage == 2) {
                $changeControl->stage = "3";
                $changeControl->status = "Closed - Done";
                $changeControl->com_verification_by = Auth::user()->name;
                $changeControl->com_verification_on = Carbon::now()->format('d-M-Y');
                $changeControl->come_verification_comment  = $request->comment;
                $history = new AuditTaskAuditTrial();
                $history->audit_tasks_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action ='Compliance Verification Complete';
                $history->previous = $lastDocument->com_verification_by;
                $history->current = $changeControl->com_verification_by;
                $history->come_verification_comment = $request->comment;
                $history->comments = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='Compliance Verification Complete';
                $history->change_to= "Closed - Done";
                $history->change_from= "Compliance Verification ";
                $history->action_name ='Not Applicable';
                
                $history->save();
                $list = Helpers::getHodUserList();
                    foreach ($list as $u) {
                        if($u->q_m_s_divisions_id ==$changeControl->division_id){
                            $email = Helpers::getInitiatorEmail($u->user_id);
                             if ($email !== null) {
                             try{
                              Mail::send(
                                  'mail.view-mail',
                                   ['data' => $changeControl],
                                function ($message) use ($email) {
                                    $message->to($email)
                                        ->subject("Document is send By ".Auth::user()->name);
                                }
                              );
                            }
                             catch(\Exception $e){
                            //log error
                        }}
                     } 
                  }
                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }


    public function auditCancle(Request $request, $id)
    {
      
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $lab2 = AuditTask::find($id);
              $changeControl = AuditTask::find($id);
            $lastDocument =  AuditTask::find($id);
            $data =  AuditTask::find($id);

            if ($lab2->stage == 1) {
                $lab2->stage = "0";
                $lab2->status = "Closed-Cancelled";
                $lab2->cancellation_by = Auth::user()->name;
                $lab2->cancellation_on = Carbon::now()->format('d-M-Y');
                $lab2->cancellation_comment  = $request->comment;
                $history = new AuditTaskAuditTrial();
                $history->audit_tasks_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action ='Cancel';
                $history->previous = $lastDocument->cancellation_by;
                $history->current = $changeControl->cancellation_by;
                $history->cancellation_comment = $request->comment;
                $history->comments = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='Cancel';
                $history->change_to= "Closed Done";
                $history->change_from= "Opened";
                $history->action_name ='Not Applicable';



                $lab2->update();
                toastr()->success('Document Sent');
                return back();
            }
        }}
    public function auditReject(Request $request, $id)
    {
         if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $lab2 = AuditTask::find($id);
              $changeControl = AuditTask::find($id);
            $lastDocument =  AuditTask::find($id);
            $data =  AuditTask::find($id);

            if ($lab2->stage == 2) {
                $lab2->stage = "1";
                $lab2->status = "Opened";
                $lab2->	open_by = Auth::user()->name;
                $lab2->open_on = Carbon::now()->format('d-M-Y'); 
                $lab2->open_comment  = $request->comment;
                $history = new AuditTaskAuditTrial();
                $history->audit_tasks_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action_name ='More Info request';
                $history->previous = $lastDocument->open_by;
                $history->current = $changeControl->open_by;
                $history->open_comment = $request->comment;
                $history->comments = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='More Info request';
                $history->change_to= "Opened";
                $history->change_from= "Compliance Verification";
                $history->action_name ='Not Applicable';



                $lab2->update();
                toastr()->success('Document Sent');
                return back();
            }
        }}

   


       public function AuditTaskAuditTrial($id)
    {
        $data= AuditTask::find($id);
        $audit = AuditTaskAuditTrial::where('audit_tasks_id', $id)->orderByDesc('id')->get();
        $today = Carbon::now()->format('d-m-y');
        $document = AuditTask::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');

        return view('frontend.auditTask.audittaskaudit-trial', compact('audit', 'document', 'today','data'));
    }
     public function audittaskauditReport($id)
    {  
        $doc = AuditTask::find($id);
        $audit = AuditTaskAuditTrial::where('audit_tasks_id', $id)->orderByDesc('id')->get();
        $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        $data = AuditTaskAuditTrial::where('audit_tasks_id', $doc->id)->orderByDesc('id')->get();
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.auditTask.audittaskauditReport', compact('data','audit', 'doc'))
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
     public function auditSingleReport($id){


        $data = AuditTask::find($id);
        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.auditTask.single_report', compact('data'))
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
            return $pdf->stream('Lab-Incident' . $id . '.pdf');

    }

}
public function Followupchild(){
 return view ('frontend.new_forms.qualityFollowUp');   
}
    
}
