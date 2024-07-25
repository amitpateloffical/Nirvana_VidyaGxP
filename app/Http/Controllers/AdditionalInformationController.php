<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\AdditionalInformation;
use App\Models\AdditionalInformationAuditTrial;
use App\Models\RecordNumber;
use App\Models\RoleGroup; 
use App\Models\User;
use Carbon\Carbon;
use PDF;
use Helpers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class AdditionalInformationController extends Controller
{
    public function index(){
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $closure_date = $formattedDate->format('Y-m-d');
        $due_date = $formattedDate->format('Y-m-d');
    return view('frontend.New_forms.additional_information', compact('closure_date','due_date','record_number'));
   }
    public function create(Request $request){
            if (!$request->short_description) {
            toastr()->info("Short Description is required");
            return redirect()->back()->withInput();
        }
           if (!$request->Short) {
            toastr()->info("Short Description is required");
            return redirect()->back()->withInput();
        }
    $data = new AdditionalInformation();
    
  
    $data->form_type = "AdditionalInformation";
    $data->record =((RecordNumber::first()->value('counter')) + 1);
    $data ->initiator = Auth::user()->id;
    $data->division_id = $request->division_id;
    $data ->parent_date = $request->parent_date;
    $data ->market_complaint = $request->market_complaint;
    $data ->short_description = $request->short_description;
    $data ->due_date = $request->due_date;
    $data ->intiation_date = $request->intiation_date;
    $data ->closure_date = $request->closure_date;
    $data ->Short= $request->Short;
    $data ->description = $request->description;
    $data ->assigned_to = $request->assigned_to;
    $data ->initiating_department = $request->initiating_department;
      if (!empty($request->file_attach)) {
            $files = [];
            if ($request->hasfile('file_attach')) {
                foreach ($request->file('file_attach') as $file) {
                    $name = $request->name . 'file_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $data->file_attach = json_encode($files);
        }
    $data ->patient_age = $request->patient_age;
    $data ->Precription_Details = $request->Precription_Details;
    $data ->Pack_Details = $request->Pack_Details;
    $data ->Container_Opening_Date = $request->Container_Opening_Date;
    $data ->Storage_Condition= $request->Storage_Condition;
    $data ->Storage_Location = $request->Storage_Location;
    $data ->Piercing_Details = $request->Piercing_Details;
    $data ->Consuption_Details_Product = $request->Consuption_Details_Product;
    $data ->Complainant_Medication_History = $request->Complainant_Medication_History;
    $data ->Other_Medication = $request->Other_Medication;
    $data ->Other_Details = $request->Other_Details;
    $data ->Delay_Justification = $request->Delay_Justification;
 if (!empty($request->file_attachement)) {
            $files = [];
            if ($request->hasfile('file_attachement')) {
                foreach ($request->file('file_attachement') as $file) {
                    $name = $request->name . 'file_attachement' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $data->file_attachement = json_encode($files);
        }
     $data->status = "Opened";
    $data->stage = 1;
    $data->save();
      $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();
         if (!empty($data->parent_date)) {
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Parent Date';
            $history->previous = "Null";
            $history->current = $data->parent_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
         if (!empty($data->market_complaint)) {
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Market Complaint';
            $history->previous = "Null";
            $history->current = $data->market_complaint;
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
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Parent Short Description';
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

        if (!empty($data->due_date)) {
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Closure Date';
            $history->previous = "Null";
            $history->current = $data->due_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->closure_date)) {
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Closure Date';
            $history->previous = "Null";
            $history->current = $data->closure_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Short)) {
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Null";
            $history->current = $data->Short;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->description)) {
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Description';
            $history->previous = "Null";
            $history->current = $data->description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
          if(!empty($data->assignee)) {
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
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

        if (!empty($data->initiating_department)) {
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Initiating Department ';
            $history->previous = "Null";
            $history->current = $data->initiating_department;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->file_attach)) {
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Initial Attachment';
            $history->previous = "Null";
            $history->current = $data->file_attach;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

      
        if (!empty($data->patient_age)) {
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Patient Age';
            $history->previous = "Null";
            $history->current = $data->patient_age;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Precription_Details)) {
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Precription Details';
            $history->previous = "Null";
            $history->current = $data->Precription_Details;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
         if(!empty($data->Pack_Details)) {
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Pack Details';
            $history->previous = "Null";
            $history->current = $data->Pack_Details;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
          if (!empty($data->Container_Opening_Date)) {
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Container Opening Date';
            $history->previous = "Null";
            $history->current = $data->Container_Opening_Date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
          if(!empty($data->Storage_Condition)) {
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Storage Condition';
            $history->previous = "Null";
            $history->current = $data->Storage_Condition;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Storage_Location)) {
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Storage Location';
            $history->previous = "Null";
            $history->current = $data->Storage_Location;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
         if (!empty($data->Piercing_Details)) {
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Piercing Details';
            $history->previous = "Null";
            $history->current = $data->Piercing_Details;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
            if (!empty($data->Consuption_Details_Product)) {
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Consuption Details Product';
            $history->previous = "Null";
            $history->current = $data->Consuption_Details_Product;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Complainant_Medication_History)) {
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Complainant Medication History';
            $history->previous = "Null";
            $history->current = $data->Complainant_Medication_History;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Other_Medication)) {
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Other Medication';
            $history->previous = "Null";
            $history->current = $data->Other_Medication;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
           if (!empty($data->Other_Details)) {
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Other Details';
            $history->previous = "Null";
            $history->current = $data->Other_Details;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Delay_Justification)) {
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Delay Justification';
            $history->previous = "Null";
            $history->current = $data->Delay_Justification;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->file_attachement)) {
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'File Attachment';
            $history->previous = "Null";
            $history->current = $data->file_attachement;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }


            toastr()->success('Record is created Successfully');
        return redirect('rcms/qms-dashboard');
   }
     public function show($id){

        $data = AdditionalInformation::find($id);
        $data->record = str_pad($data->record, 4, '0', STR_PAD_LEFT);
        $data->assign_to_name = User::where('id', $data->assign_id)->value('name');
        $data->initiator_name = User::where('id', $data->initiator_id)->value('name');
         $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $closure_date = $formattedDate->format('Y-m-d');
        
    return view('frontend.additional-information.view',compact('data','closure_date'));
   }
      public function update(Request $request, $id){

    $data = AdditionalInformation::find($id);
    $lastDocument = AdditionalInformation::find($id);
    $lastdata = AdditionalInformation::find($id);
    $lastDocumentRecord = AdditionalInformation::find($data->id);
    $lastDocumentStatus = $lastDocumentRecord ? $lastDocumentRecord->status : null;
    
    // $data->Form_Type = "client-inquiry";
    // $data->record = ((RecordNumber::first()->value('counter')) + 1);
    $data ->initiator = Auth::user()->id;
    $data->division_id = $request->division_id;
    $data ->parent_date = $request->parent_date;
    $data ->market_complaint = $request->market_complaint;
    $data ->short_description = $request->short_description;
    $data ->due_date = $request->due_date;
    $data ->intiation_date = $request->intiation_date;
    $data ->closure_date = $request->closure_date;
    $data ->Short= $request->Short;
    $data ->description = $request->description;
    $data ->assigned_to = $request->assigned_to;
    $data ->initiating_department = $request->initiating_department;
      if (!empty($request->file_attach)) {
            $files = [];
            if ($request->hasfile('file_attach')) {
                foreach ($request->file('file_attach') as $file) {
                    $name = $request->name . 'file_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $data->file_attach = json_encode($files);
        }
    $data ->patient_age = $request->patient_age;
    $data ->Precription_Details = $request->Precription_Details;
    $data ->Pack_Details = $request->Pack_Details;
    $data ->Container_Opening_Date = $request->Container_Opening_Date;
    $data ->Storage_Condition= $request->Storage_Condition;
    $data ->Storage_Location = $request->Storage_Location;
    $data ->Piercing_Details = $request->Piercing_Details;
    $data ->Consuption_Details_Product = $request->Consuption_Details_Product;
    $data ->Complainant_Medication_History = $request->Complainant_Medication_History;
    $data ->Other_Medication = $request->Other_Medication;
    $data ->Other_Details = $request->Other_Details;
    $data ->Delay_Justification = $request->Delay_Justification;
 if (!empty($request->file_attachement)) {
            $files = [];
            if ($request->hasfile('file_attachement')) {
                foreach ($request->file('file_attachement') as $file) {
                    $name = $request->name . 'file_attachement' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $data->file_attachement = json_encode($files);
        }
             $data->update();
         if($lastDocument->parent_date !=$data->parent_date || !empty($request->parent_date_comment)) {
            $lastDocumentAuditTrail = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $data->id)
                            ->where('activity_type', 'Parent Date')
                            ->exists();
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Parent Date';
            $history->previous =  $lastDocument->parent_date;
            $history->current = $data->parent_date;
            $history->comment = $request->parent_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
         if($lastDocument->market_complaint !=$data->market_complaint || !empty($request->market_complaint_comment)) {
            $lastDocumentAuditTrail = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $data->id)
                            ->where('activity_type', 'Market Complaint')
                            ->exists();
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Market Complaint';
            $history->previous =  $lastDocument->market_complaint;
            $history->current = $data->market_complaint;
            $history->comment = $request->market_complaint_comment;
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
            $lastDocumentAuditTrail = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $data->id)
                            ->where('activity_type', 'Parent Short Description')
                            ->exists();
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = ' Parent Short Description';
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
         if($lastDocument->due_date !=$data->due_date || !empty($request->due_date_comment)) {
            $lastDocumentAuditTrail = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $data->id)
                            ->where('activity_type', 'Parent Closure Date')
                            ->exists();
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Parent Closure Date';
            $history->previous =  $lastDocument->due_date;
            $history->current = $data->due_date;
            $history->comment = $request->due_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
         if($lastDocument->closure_date !=$data->closure_date || !empty($request->closure_date_comment)) {
            $lastDocumentAuditTrail = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $data->id)
                            ->where('activity_type', 'Closure Date')
                            ->exists();
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Closure Date';
            $history->previous =  $lastDocument->closure_date;
            $history->current = $data->closure_date;
            $history->comment = $request->closure_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
         if($lastDocument->Short !=$data->Short || !empty($request->Short_comment)) {
            $lastDocumentAuditTrail = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $data->id)
                            ->where('activity_type', 'Short Description')
                            ->exists();
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Short Description';
            $history->previous =  $lastDocument->Short;
            $history->current = $data->Short;
            $history->comment = $request->Short_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
        if($lastDocument->description !=$data->description || !empty($request->description_comment)) {
            $lastDocumentAuditTrail = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $data->id)
                            ->where('activity_type', 'Description')
                            ->exists();
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Description';
            $history->previous =  $lastDocument->description;
            $history->current = $data->description;
            $history->comment = $request->description_comment;
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
            $history = new AdditionalInformationAuditTrial();
            $lastDocumentAuditTrail = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $data->id)
                            ->where('activity_type', 'Assignee')
                            ->exists();
            $history->AdditionalInformation_id = $data->id;
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
         if($lastDocument->initiating_department !=$data->initiating_department || !empty($request->initiating_department_comment)) {
            $lastDocumentAuditTrail = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $data->id)
                            ->where('activity_type', 'Initiating Department')
                            ->exists();
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Initiating Department';
            $history->previous =  $lastDocument->initiating_department;
            $history->current = $data->initiating_department;
            $history->comment = $request->initiating_department_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
        if($lastDocument->file_attach !=$data->file_attach || !empty($request->file_attach_comment)) {
            $lastDocumentAuditTrail = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $data->id)
                            ->where('activity_type', 'Initial Attachment')
                            ->exists();
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Initial Attachment';
            $history->previous =  $lastDocument->file_attach;
            $history->current = $data->file_attach;
            $history->comment = $request->file_attach_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
          if($lastDocument->patient_age !=$data->patient_age || !empty($request->patient_age_comment)) {
            $lastDocumentAuditTrail = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $data->id)
                            ->where('activity_type', 'Patient Age')
                            ->exists();
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Patient Age';
            $history->previous =  $lastDocument->patient_age;
            $history->current = $data->patient_age;
            $history->comment = $request->patient_age_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
        if($lastDocument->Precription_Details !=$data->Precription_Details || !empty($request->Precription_Details_comment)) {
            $lastDocumentAuditTrail = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $data->id)
                            ->where('activity_type', 'Precription Details')
                            ->exists();
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Precription Details';
            $history->previous =  $lastDocument->Precription_Details;
            $history->current = $data->Precription_Details;
            $history->comment = $request->Precription_Details_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
  if($lastDocument->Pack_Details !=$data->Pack_Details || !empty($request->Pack_Details_comment)) {
            $history = new AdditionalInformationAuditTrial();
            $lastDocumentAuditTrail = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $data->id)
                            ->where('activity_type', 'Pack Details')
                            ->exists();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Pack Details';
            $history->previous =  $lastDocument->Pack_Details;
            $history->current = $data->Pack_Details;
            $history->comment = $request->Pack_Details_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
    if($lastDocument->Container_Opening_Date !=$data->Container_Opening_Date || !empty($request->Container_Opening_Date_comment)) {
        $lastDocumentAuditTrail = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $data->id)
                            ->where('activity_type', 'Container Opening Date')
                            ->exists();
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Container Opening Date';
            $history->previous =  $lastDocument->Container_Opening_Date;
            $history->current = $data->Container_Opening_Date;
            $history->comment = $request->Container_Opening_Date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
         if($lastDocument->Storage_Condition !=$data->Storage_Condition || !empty($request->Storage_Condition_comment)) {
            $lastDocumentAuditTrail = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $data->id)
                            ->where('activity_type', 'Storage_Condition')
                            ->exists();
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Storage_Condition';
            $history->previous =  $lastDocument->Storage_Condition;
            $history->current = $data->Storage_Condition;
            $history->comment = $request->Storage_Condition_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
           if($lastDocument->Storage_Location !=$data->Storage_Location || !empty($request->Storage_Location_comment)) {
            $lastDocumentAuditTrail = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $data->id)
                            ->where('activity_type', 'Storage Location')
                            ->exists();
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Storage Location';
            $history->previous =  $lastDocument->Storage_Location;
            $history->current = $data->Storage_Location;
            $history->comment = $request->Storage_Location_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
  if($lastDocument->Piercing_Details !=$data->Piercing_Details || !empty($request->Piercing_Details_comment)) {
    $lastDocumentAuditTrail = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $data->id)
                            ->where('activity_type', 'Piercing Details')
                            ->exists();
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Piercing Details';
            $history->previous =  $lastDocument->Piercing_Details;
            $history->current = $data->Piercing_Details;
            $history->comment =  "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
         if($lastDocument->Consuption_Details_Product !=$data->Consuption_Details_Product || !empty($request->Consuption_Details_Product_comment)) {
            $lastDocumentAuditTrail = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $data->id)
                            ->where('activity_type', 'Consuption Details Product')
                            ->exists();
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Consuption Details Product';
            $history->previous =  $lastDocument->Consuption_Details_Product;
            $history->current = $data->Consuption_Details_Product;
            $history->comment = $request->Consuption_Details_Product_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
         if($lastDocument->Complainant_Medication_History !=$data->Complainant_Medication_History || !empty($request->Complainant_Medication_History_comment)) {
            $lastDocumentAuditTrail = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $data->id)
                            ->where('activity_type', 'Complainant Medication History')
                            ->exists();
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Complainant Medication History';
            $history->previous =  $lastDocument->Complainant_Medication_History;
            $history->current = $data->Complainant_Medication_History;
            $history->comment = $request->Complainant_Medication_History_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
         if($lastDocument->Other_Medication !=$data->Other_Medication || !empty($request->Other_Medication_comment)) {
            $lastDocumentAuditTrail = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $data->id)
                            ->where('activity_type', 'Other Medication')
                            ->exists();
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Other Medication';
            $history->previous =  $lastDocument->Other_Medication;
            $history->current = $data->Other_Medication;
            $history->comment = $request->Other_Medication_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
      if($lastDocument->Other_Details !=$data->Other_Details || !empty($request->Other_Details_comment)) {
        $lastDocumentAuditTrail = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $data->id)
                            ->where('activity_type', 'Other Details')
                            ->exists();
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Other Details';
            $history->previous =  $lastDocument->Other_Details;
            $history->current = $data->Other_Details;
            $history->comment = $request->Other_Details_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
              if($lastDocument->Delay_Justification !=$data->Delay_Justification || !empty($request->Delay_Justification_comment)) {
                $lastDocumentAuditTrail = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $data->id)
                            ->where('activity_type', 'Delay_Justification')
                            ->exists();
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'Delay_Justification';
            $history->previous =  $lastDocument->Delay_Justification;
            $history->current = $data->Delay_Justification;
            $history->comment = $request->Delay_Justification_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }

     if($lastDocument->file_attachement !=$data->file_attachement || !empty($request->file_attachement_comment)) {
        $lastDocumentAuditTrail = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $data->id)
                            ->where('activity_type', 'File Attachment')
                            ->exists();
            $history = new AdditionalInformationAuditTrial();
            $history->AdditionalInformation_id = $data->id;
            $history->activity_type = 'File Attachment';
            $history->previous =  $lastDocument->file_attachement;
            $history->current = $data->file_attachement;
            $history->comment = $request->file_attachement_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
        toastr()->success('Record is created Successfully');

        return back();
   }
     public function StageChange(Request $request, $id){
if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = AdditionalInformation::find($id);
            $lastDocument =  AdditionalInformation::find($id);
            $data =  AdditionalInformation::find($id);

            if ($changeControl->stage == 1) {
                $changeControl->stage = "2";
                $changeControl->Submitted_By = Auth::user()->name;
                $changeControl->Submitted_on = Carbon::now()->format('d-M-Y');
                $changeControl->Submitted_comment  = $request->comment;
                $changeControl->status = "Under Execution";
                $history = new AdditionalInformationAuditTrial();
                $history->AdditionalInformation_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action ='Submit';
                $history->previous = $lastDocument->Submitted_By;
                $history->current = $changeControl->Submitted_By;
                $history->Submitted_comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='Submit';
                $history->change_to= "Under Execution";
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
                $changeControl->Execution_Complete_by = Auth::user()->name;
                $changeControl->Execution_Complete_on = Carbon::now()->format('d-M-Y');
                $changeControl->Execution_Complete_comment  = $request->comment;
                $history = new AdditionalInformationAuditTrial();
                $history->AdditionalInformation_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action ='Execution Complete';
                $history->previous = $lastDocument->completed_by;
                $history->current = $changeControl->completed_by;
                $history->completed_comment = $request->comment;
                $history->comments = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='Execution Complete';
                $history->change_to= "Closed - Done";
                $history->change_from= "Under Execution";
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
    public function CancelStateChanges(Request $request, $id)
    {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $lab2 = AdditionalInformation::find($id);
              $changeControl = AdditionalInformation::find($id);
            $lastDocument =  AdditionalInformation::find($id);
            $data =  AdditionalInformation::find($id);

            if ($lab2->stage == 1) {
                $lab2->stage = "0";
                $lab2->status = "Closed-Cancelled";
                $lab2->cancel_by = Auth::user()->name;
                $lab2->cancel_on = Carbon::now()->format('d-M-Y');  
                $lab2->cancel_comment  = $request->comment;
                $history = new AdditionalInformationAuditTrial();
                $history->AdditionalInformation_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action ='Cancel';
                $history->previous = $lastDocument->completed_by;
                $history->current = $changeControl->completed_by;
                $history->completed_comment = $request->comment;
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
        public function MoreInfoStateChanges(Request $request, $id)
    {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $lab2 = AdditionalInformation::find($id);
              $changeControl = AdditionalInformation::find($id);
            $lastDocument =  AdditionalInformation::find($id);
            $data =  AdditionalInformation::find($id);

            if ($lab2->stage == 2) {
                $lab2->stage = "1";
                $lab2->status = "Opened";
                $lab2->moreinformation_by = Auth::user()->name;
                $lab2->moreinformation_on = Carbon::now()->format('d-M-Y'); 
                $lab2->moreinformation_comment  = $request->comment;
                $history = new AdditionalInformationAuditTrial();
                $history->AdditionalInformation_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action_name ='More Info request';
                $history->previous = $lastDocument->completed_by;
                $history->current = $changeControl->completed_by;
                $history->completed_comment = $request->comment;
                $history->comments = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='More Info request';
                $history->change_to= "Opened";
                $history->change_from= "Under Execution";
                $history->action_name ='Not Applicable';



                $lab2->update();
                toastr()->success('Document Sent');
                return back();
            }
        }}
        public function AdditionalInformationAuditTrial($id)
    {
        $data= AdditionalInformation::find($id);
        $audit = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $id)->orderByDesc('id')->get();
        $today = Carbon::now()->format('d-m-y');
        $document = AdditionalInformation::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');

        return view('frontend.additional-information.additionalaudit-trial', compact('audit', 'document', 'today','data'));
    }
     public function additionalauditReport($id)
    {
        $doc = AdditionalInformation::find($id);
        $audit = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $id)->orderByDesc('id')->get();
        $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        $data = AdditionalInformationAuditTrial::where('AdditionalInformation_id', $doc->id)->orderByDesc('id')->get();
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.additional-information.additionalauditReport', compact('data','audit', 'doc'))
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
     public function additionalSingleReport($id){


        $data = AdditionalInformation::find($id);
        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.additional-information.additionalsingleReport', compact('data'))
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

}
