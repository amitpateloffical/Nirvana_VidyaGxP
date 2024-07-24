<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\MeetingManagement;
use App\Models\MeetingManagementAuditTrial;
use App\Models\RecordNumber;
use App\Models\RoleGroup;
use App\Models\MeetingManagementGrid;
use App\Models\User;
use Carbon\Carbon;
use PDF;
use Helpers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class MeetingManagementController extends Controller
{
     public function index(){
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
    return view('frontend.New_forms.meeting-management', compact('due_date','record_number'));
   }
    public function store(Request $request){
            if (!$request->short_description) {
            toastr()->info("Short Description is required");
            return redirect()->back()->withInput();
        }
    $data = new MeetingManagement();
    
  
    $data->form_type = "MeetingManagement";
    $data->record =((RecordNumber::first()->value('counter')) + 1);
    $data ->initiator = Auth::user()->id;
    $data->division_id = $request->division_id;
    $data ->intiation_date = $request->intiation_date;
    $data ->short_description = $request->short_description;
    $data ->assigned_to = $request->assigned_to;
    $data ->due_date = $request->due_date;
    $data ->initiator_group = $request->initiator_group;
    $data ->initiator_group_code = $request->initiator_group_code;
    $data ->type= $request->type;
    $data ->priority_level = $request->priority_level;
    $data ->start_date = $request->start_date;
    $data ->end_date = $request->end_date;
    $data ->attendees = $request->attendees;
    $data ->description = $request->description;
      if (!empty($request->Attached_File)) {
            $files = [];
            if ($request->hasfile('Attached_File')) {
                foreach ($request->file('Attached_File') as $file) {
                    $name = $request->name . 'Attached_File' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $data->Attached_File = json_encode($files);
        }

    $data ->operations = $request->operations;
    $data ->Requirements_for_Products = $request->Requirements_for_Products;
    $data ->Design_and_Development = $request->Design_and_Development;
    $data ->Control_of_Externally = $request->Control_of_Externally;
    $data ->Production_and_Service= $request->Production_and_Service;
    $data ->Release_of_Products = $request->Release_of_Products;
    $data ->Control_of_Non = $request->Control_of_Non;
    $data ->Risk_Opportunities = $request->Risk_Opportunities;
    $data ->External_Supplier_Performance = $request->External_Supplier_Performance;
    $data ->Customer_Satisfaction_Level = $request->Customer_Satisfaction_Level;
    $data ->Budget_Estimates = $request->Budget_Estimates;
    $data ->Completion_of_Previous_Tasks = $request->Completion_of_Previous_Tasks;
    $data ->Production = $request->Production;
    $data ->Plans= $request->Plans;
    $data ->Forecast = $request->Forecast;
    $data ->Any_Additional_Support_Required = $request->Any_Additional_Support_Required;
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
    $data ->Date_Due = $request->Date_Due;
    $data ->Summary_Recommendation = $request->Summary_Recommendation;
    $data ->Conclusion= $request->Conclusion;
        if (!empty($request->file_Attachment)) {
            $files = [];
            if ($request->hasfile('file_Attachment')) {
                foreach ($request->file('file_Attachment') as $file) {
                    $name = $request->name . 'file_Attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $data->file_Attachment = json_encode($files);
        }
    $data ->Due_Date_Extension_Justification = $request->Due_Date_Extension_Justification;
     $data->status = "Opened";
    $data->stage = 1;

    $data->save();
      $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();
     
          if(!empty($data->short_description)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
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
         if (!empty($data->assigned_to)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Assigned To';
            $history->previous = "Null";
            $history->current = $data->assigned_to;
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
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Date Due';
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

        if (!empty($data->Initiation_group)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Initiation group';
            $history->previous = "Null";
            $history->current = $data->Initiation_group;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Initiation_group_code)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Initiation group code';
            $history->previous = "Null";
            $history->current = $data->Initiation_group_code;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->type)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Type';
            $history->previous = "Null";
            $history->current = $data->type;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->priority_level)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Priority Level';
            $history->previous = "Null";
            $history->current = $data->priority_level;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->start_date)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Start_Date';
            $history->previous = "Null";
            $history->current = $data->start_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
          if(!empty($data->end_date)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'End_Date';
            $history->previous = "Null";
            $history->current = $data->end_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->attendees)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Attendees ';
            $history->previous = "Null";
            $history->current = $data->attendees;
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
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
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

      
        if (!empty($data->Attached_File)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Attached File';
            $history->previous = "Null";
            $history->current = $data->Attached_File;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->operations)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Operations';
            $history->previous = "Null";
            $history->current = $data->operations;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
         if(!empty($data->Requirements_for_Products)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Requirements for Products';
            $history->previous = "Null";
            $history->current = $data->Requirements_for_Products;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
          if (!empty($data->Design_and_Development)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Design and Development';
            $history->previous = "Null";
            $history->current = $data->Design_and_Development;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
          if(!empty($data->Control_of_Externally)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Control of Externally';
            $history->previous = "Null";
            $history->current = $data->Control_of_Externally;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Production_and_Service)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Production and Service';
            $history->previous = "Null";
            $history->current = $data->Production_and_Service;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
         if (!empty($data->Release_of_Products)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Release of Products';
            $history->previous = "Null";
            $history->current = $data->Release_of_Products;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
            if (!empty($data->Control_of_Non)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Control of Non';
            $history->previous = "Null";
            $history->current = $data->Control_of_Non;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Risk_Opportunities)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Risk Opportunities';
            $history->previous = "Null";
            $history->current = $data->Risk_Opportunities;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->External_Supplier_Performance)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'External Supplier Performance';
            $history->previous = "Null";
            $history->current = $data->External_Supplier_Performance;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Customer_Satisfaction_Level)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Customer Satisfactio Level';
            $history->previous = "Null";
            $history->current = $data->Customer_Satisfaction_Level;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Budget_Estimates)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Budget Estimates';
            $history->previous = "Null";
            $history->current = $data->Budget_Estimates;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Completion_of_Previous_Tasks)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Completion of Previous Tasks';
            $history->previous = "Null";
            $history->current = $data->Completion_of_Previous_Tasks;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
          if(!empty($data->Production)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Production';
            $history->previous = "Null";
            $history->current = $data->Production;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
         if (!empty($data->Plans)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Plans';
            $history->previous = "Null";
            $history->current = $data->Plans;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Forecast)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Forecast';
            $history->previous = "Null";
            $history->current = $data->Forecast;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Any_Additional_Support_Required)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Any Additional Support Required';
            $history->previous = "Null";
            $history->current = $data->Any_Additional_Support_Required;
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
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'file attach';
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

        if (!empty($data->Date_Due)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Date Due';
            $history->previous = "Null";
            $history->current = $data->Date_Due;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Summary_Recommendation)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Summary Recommendation';
            $history->previous = "Null";
            $history->current = $data->Summary_Recommendation;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
          if(!empty($data->Conclusion)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Conclusion';
            $history->previous = "Null";
            $history->current = $data->Conclusion;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
         if (!empty($data->file_attachment)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'file attachment';
            $history->previous = "Null";
            $history->current = $data->file_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Due_Date_Extension_Justification)) {
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Due_Date_Extension_Justification';
            $history->previous = "Null";
            $history->current = $data->Due_Date_Extension_Justification;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

       
        
//===================GRID 1============================================================================
        $meetingmanagemengt_id = $data->id;
        
        $newDataMeetingManagement = MeetingManagementGrid::where(['ci_id' => $meetingmanagemengt_id, 'identifier' => 'agenda' ])->firstOrCreate();
        $newDataMeetingManagement->ci_id = $meetingmanagemengt_id;
        $newDataMeetingManagement->identifier = 'agenda';
        $newDataMeetingManagement->data = $request->agenda;
        // $history->change_to= "Opened";
        // $history->change_from= "Initiator";
        // $history->action_name="Create";
        $newDataMeetingManagement->save();
        // dd($newDataMeetingManagement);
//==================================================================================================
//===================GRID 2============================================================================
        $meetingmanagemengt_id = $data->id;
        $newDataMeetingManagement = MeetingManagementGrid::where(['ci_id' => $meetingmanagemengt_id, 'identifier' => 'Management_Review_Participants' ])->firstOrCreate();
        $newDataMeetingManagement->ci_id = $meetingmanagemengt_id;
        $newDataMeetingManagement->identifier = 'Management_Review_Participants';
        $newDataMeetingManagement->data = $request->Management_Review_Participants;
        // $history->change_to= "Opened";
        // $history->change_from= "Initiator";
        // $history->action_name="Create";
        $newDataMeetingManagement->save();
//==================================================================================================
//===================GRID 3============================================================================
        $meetingmanagemengt_id = $data->id;
        $newDataMeetingManagement = MeetingManagementGrid::where(['ci_id' => $meetingmanagemengt_id, 'identifier' => 'performance_evaluation' ])->firstOrCreate();
        $newDataMeetingManagement->ci_id = $meetingmanagemengt_id;
        $newDataMeetingManagement->identifier = 'performance_evaluation';
        $newDataMeetingManagement->data = $request->performance_evaluation;
        // $history->change_to= "Opened";
        // $history->change_from= "Initiator";
        // $history->action_name="Create";
        $newDataMeetingManagement->save();
//==================================================================================================
//===================GRID 4============================================================================
        $meetingmanagemengt_id = $data->id;
        $newDataMeetingManagement = MeetingManagementGrid::where(['ci_id' => $meetingmanagemengt_id, 'identifier' => 'action_Item_Details' ])->firstOrCreate();
        $newDataMeetingManagement->ci_id = $meetingmanagemengt_id;
        $newDataMeetingManagement->identifier = 'action_Item_Details';
        $newDataMeetingManagement->data = $request->action_Item_Details;
        // $history->change_to= "Opened";
        // $history->change_from= "Initiator";
        // $history->action_name="Create";
        $newDataMeetingManagement->save();
//==================================================================================================
//===================GRID 5============================================================================
        $meetingmanagemengt_id = $data->id;
        $newDataMeetingManagement = MeetingManagementGrid::where(['ci_id' => $meetingmanagemengt_id, 'identifier' => 'capa_Details' ])->firstOrCreate();
        $newDataMeetingManagement->ci_id = $meetingmanagemengt_id;
        $newDataMeetingManagement->identifier = 'capa_Details';
        $newDataMeetingManagement->data = $request->capa_Details;
        // $history->change_to= "Opened";
        // $history->change_from= "Initiator";
        // $history->action_name="Create";
        $newDataMeetingManagement->save();
//==================================================================================================
    toastr()->success('Record is created Successfully');

        return redirect('rcms/qms-dashboard');
   }
      public function show($id){

    $data = MeetingManagement::find($id);
        $data->record = str_pad($data->record, 4, '0', STR_PAD_LEFT);
        $data->assign_to_name = User::where('id', $data->assign_id)->value('name');
        $data->initiator_name = User::where('id', $data->initiator_id)->value('name');
         $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        $meetingmanagement_id = $data->id;
        $grid_Data = MeetingManagementGrid::where(['ci_id' => $meetingmanagement_id, 'identifier' => 'agenda' ])->first();
        $grid_Data1 = MeetingManagementGrid::where(['ci_id' => $meetingmanagement_id, 'identifier' => 'Management_Review_Participants' ])->first();
        $grid_Data2 = MeetingManagementGrid::where(['ci_id' => $meetingmanagement_id, 'identifier' => 'performance_evaluation' ])->first();
        $grid_Data3 = MeetingManagementGrid::where(['ci_id' => $meetingmanagement_id, 'identifier' => 'action_Item_Details' ])->first();
        $grid_Data4 = MeetingManagementGrid::where(['ci_id' => $meetingmanagement_id, 'identifier' => 'capa_Details' ])->first();
        // dd($grid_Data);
        
        // return dd($grid_Data->data);
    return view('frontend.meeting-management.view',compact('data','meetingmanagement_id','due_date','grid_Data','grid_Data1','grid_Data2','grid_Data3','grid_Data4'));
   }
     public function update(Request $request, $id){    

    $data = MeetingManagement::find($id);
    $lastDocument = MeetingManagement::find($id);
    $lastdata = MeetingManagement::find($id);
    $lastDocumentRecord = MeetingManagement::find($data->id);
    $lastDocumentStatus = $lastDocumentRecord ? $lastDocumentRecord->status : null;
    
    
   //  $data->Form_Type = "client-inquiry";
    // $data->record = ((RecordNumber::first()->value('counter')) + 1);
    $data ->initiator = Auth::user()->id;
    $data->division_id = $request->division_id;
    $data ->intiation_date = $request->intiation_date;
    $data ->short_description = $request->short_description;
    $data ->assigned_to = $request->assigned_to;
    $data ->operations = $request->due_date;
    $data ->initiator_group = $request->initiator_group;
    $data ->initiator_group_code = $request->initiator_group_code;
    $data ->type= $request->type;
    $data ->priority_level = $request->priority_level;
    $data ->start_date = $request->start_date;
    $data ->end_date = $request->end_date;
    $data ->attendees = $request->attendees;
    $data ->description = $request->description;
     if (!empty($request->Attached_File)) {
            $files = [];
            if ($request->hasfile('Attached_File')) {
                foreach ($request->file('Attached_File') as $file) {
                    $name = $request->name . 'Attached_File' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $data->Attached_File = json_encode($files);
        }
    $data ->operations = $request->operations;
    $data ->Requirements_for_Products = $request->Requirements_for_Products;
    $data ->Design_and_Development = $request->Design_and_Development;
    $data ->Control_of_Externally = $request->Control_of_Externally;
    $data ->Production_and_Service= $request->Production_and_Service;
    $data ->Release_of_Products = $request->Release_of_Products;
    $data ->Control_of_Non = $request->Control_of_Non;
    $data ->Risk_Opportunities = $request->Risk_Opportunities;
    $data ->External_Supplier_Performance = $request->External_Supplier_Performance;
    $data ->Customer_Satisfaction_Level = $request->Customer_Satisfaction_Level;
    $data ->Budget_Estimates = $request->Budget_Estimates;
    $data ->Completion_of_Previous_Tasks = $request->Completion_of_Previous_Tasks;
    $data ->Production = $request->Production;
    $data ->Plans= $request->Plans;
    $data ->Forecast = $request->Forecast;
    $data ->Any_Additional_Support_Required = $request->Any_Additional_Support_Required;
         if (!empty($request->file_Attachment)) {
            $files = [];
            if ($request->hasfile('file_attach')) {
                foreach ($request->file('file_attach') as $file) {
                    $name = $request->name . 'file_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $data->Attached_File = json_encode($files);
        }
        $data->update();
    $data ->start_date_checkdate = $request->start_date_checkdate;
    $data ->Summary_Recommendation = $request->Summary_Recommendation;
    $data ->Conclusion= $request->Conclusion;
              if (!empty($request->file_Attachment)) {
            $files = [];
            if ($request->hasfile('file_Attachment')) {
                foreach ($request->file('file_Attachment') as $file) {
                    $name = $request->name . 'file_Attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $data->file_Attachment = json_encode($files);
        }
         $data ->Due_Date_Extension_Justification = $request->Due_Date_Extension_Justification;
        $data->update();
    $data ->Due_Date_Extension_Justification = $request->Due_Date_Extension_Justification;
        if($lastDocument->short_description !=$data->short_description || !empty($request->short_description_comment)) {
            $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Short Description')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
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
           if($lastDocument->assigned_to !=$data->assigned_to || !empty($request->assigned_to_comment)) {
             $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Assigned To')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Assigned To';
            $history->previous =  $lastDocument->assigned_to;
            $history->current = $data->assigned_to;
            $history->comment = $request->assigned_to_comment;
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
             $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Due Date')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Due Date';
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
           if($lastDocument->initiator_group !=$data->initiator_group || !empty($request->initiator_group_comment)) {
             $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Initiator Group')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Initiator Group';
            $history->previous =  $lastDocument->initiator_group;
            $history->current = $data->initiator_group;
            $history->comment = $request->initiator_group_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
           if($lastDocument->initiator_group_code !=$data->initiator_group_code || !empty($request->initiator_group_code_comment)) {
             $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Initiator group code')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Initiator group code';
            $history->previous =  $lastDocument->initiator_group_code;
            $history->current = $data->initiator_group_code;
            $history->comment = $request->initiator_group_code_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
           if($lastDocument->type !=$data->type || !empty($request->type_comment)) {
             $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Type')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Type';
            $history->previous =  $lastDocument->type;
            $history->current = $data->type;
            $history->comment = $request->type_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
              if($lastDocument->priority_level !=$data->priority_level || !empty($request->priority_level_comment)) {
                 $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Priority level')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Priority level';
            $history->previous =  $lastDocument->priority_level;
            $history->current = $data->priority_level;
            $history->comment = $request->priority_level_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }

              if($lastDocument->start_date !=$data->start_date || !empty($request->start_date_comment)) {
            $history = new MeetingManagementAuditTrial();
             $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Start Date')
                            ->exists();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Start Date';
            $history->previous =  $lastDocument->start_date;
            $history->current = $data->start_date;
            $history->comment = $request->start_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
              if($lastDocument->end_date !=$data->end_date || !empty($request->end_date_comment)) {
                 $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'End Date')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'End Date';
            $history->previous =  $lastDocument->end_date;
            $history->current = $data->end_date;
            $history->comment = $request->end_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
              if($lastDocument->attendees !=$data->attendees || !empty($request->attendees_comment)) {
                 $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Attendees')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Attendees';
            $history->previous =  $lastDocument->attendees;
            $history->current = $data->attendees;
            $history->comment = $request->attendees_comment;
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
         $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Description')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
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
            if($lastDocument->Attached_File !=$data->Attached_File || !empty($request->Attached_File_comment)) {
                 $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Attached File')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Attached File';
            $history->previous =  $lastDocument->Attached_File;
            $history->current = $data->Attached_File;
            $history->comment = $request->Attached_File_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
            if($lastDocument->operations !=$data->operations || !empty($request->operations_comment)) {
                 $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Operations')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Operations';
            $history->previous =  $lastDocument->operations;
            $history->current = $data->operations;
            $history->comment = $request->operations_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
            if($lastDocument->Requirements_for_Products !=$data->Requirements_for_Products || !empty($request->Requirements_for_Products_comment)) {
                 $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Requirements for Products')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Requirements for Products';
            $history->previous =  $lastDocument->Requirements_for_Products;
            $history->current = $data->Requirements_for_Products;
            $history->comment = $request->Requirements_for_Products_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
            if($lastDocument->Design_and_Development !=$data->Design_and_Development || !empty($request->Design_and_Development_comment)) {
                 $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Design and Development')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Design and Development';
            $history->previous =  $lastDocument->Design_and_Development;
            $history->current = $data->Design_and_Development;
            $history->comment = $request->Design_and_Development_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
            if($lastDocument->Control_of_Externally !=$data->Control_of_Externally || !empty($request->Control_of_Externally_comment)) {
                 $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Control of Externally')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Control of Externally';
            $history->previous =  $lastDocument->Control_of_Externally;
            $history->current = $data->Control_of_Externally;
            $history->comment = $request->Control_of_Externally_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
            if($lastDocument->Production_and_Service !=$data->Production_and_Service || !empty($request->Production_and_Service_comment)) {
                 $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Production and Service')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Production and Service';
            $history->previous =  $lastDocument->Production_and_Service;
            $history->current = $data->Production_and_Service;
            $history->comment = $request->Production_and_Service_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
            if($lastDocument->Release_of_Products !=$data->Release_of_Products || !empty($request->Release_of_Products_comment)) {
                 $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Release of Products')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Release of Products';
            $history->previous =  $lastDocument->Release_of_Products;
            $history->current = $data->Release_of_Products;
            $history->comment = $request->Release_of_Products_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
            if($lastDocument->Control_of_Non !=$data->Control_of_Non || !empty($request->Control_of_Non_comment)) {
                 $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Control of Non')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Control of Non';
            $history->previous =  $lastDocument->Control_of_Non;
            $history->current = $data->Control_of_Non;
            $history->comment = $request->Control_of_Non_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
           if($lastDocument->Risk_Opportunities !=$data->Risk_Opportunities || !empty($request->Risk_Opportunities_comment)) {
             $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Risk Opportunities')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Risk Opportunities';
            $history->previous =  $lastDocument->Risk_Opportunities;
            $history->current = $data->Risk_Opportunities;
            $history->comment = $request->Risk_Opportunities_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
               if($lastDocument->External_Supplier_Performance !=$data->External_Supplier_Performance || !empty($request->External_Supplier_Performance_comment)) {
                 $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'External Supplier Performance')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'External Supplier Performance';
            $history->previous =  $lastDocument->External_Supplier_Performance;
            $history->current = $data->External_Supplier_Performance;
            $history->comment = $request->External_Supplier_Performance_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
             if($lastDocument->Customer_Satisfaction_Level !=$data->Customer_Satisfaction_Level || !empty($request->Customer_Satisfaction_Level_comment)) {
                 $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Customer Satisfaction Level')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Customer Satisfaction Level';
            $history->previous =  $lastDocument->Customer_Satisfaction_Level;
            $history->current = $data->Customer_Satisfaction_Level;
            $history->comment = $request->Customer_Satisfaction_Level_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
            if($lastDocument->Budget_Estimates !=$data->Budget_Estimates || !empty($request->Budget_Estimates_comment)) {
                 $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Budget Estimates')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Budget Estimates';
            $history->previous =  $lastDocument->Budget_Estimates;
            $history->current = $data->Budget_Estimates;
            $history->comment = $request->Budget_Estimates_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
         if($lastDocument->Completion_of_Previous_Tasks !=$data->Completion_of_Previous_Tasks || !empty($request->Completion_of_Previous_Tasks_comment)) {
             $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Completion of Previous Tasks')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Completion of Previous Tasks';
            $history->previous =  $lastDocument->Completion_of_Previous_Tasks;
            $history->current = $data->Completion_of_Previous_Tasks;
            $history->comment = $request->Completion_of_Previous_Tasks_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
         if($lastDocument->Production !=$data->Production || !empty($request->Production_comment)) {
            $history = new MeetingManagementAuditTrial();
             $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Production')
                            ->exists();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Production';
            $history->previous =  $lastDocument->Production;
            $history->current = $data->Production;
            $history->comment = $request->Production_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
            if($lastDocument->Plans !=$data->Plans || !empty($request->Plans_comment)) {
                 $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Plans')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Plans';
            $history->previous =  $lastDocument->Plans;
            $history->current = $data->Plans;
            $history->comment = $request->Plans_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
           if($lastDocument->Forecast !=$data->Forecast || !empty($request->Forecast_comment)) {
             $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Forecast')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Forecast';
            $history->previous =  $lastDocument->Forecast;
            $history->current = $data->Forecast;
            $history->comment = $request->Forecast_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
            if($lastDocument->Any_Additional_Support_Required !=$data->Any_Additional_Support_Required || !empty($request->Any_Additional_Support_Required_comment)) {
                 $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Any Additional Support Required')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Any Additional Support Required';
            $history->previous =  $lastDocument->Any_Additional_Support_Required;
            $history->current = $data->Any_Additional_Support_Required;
            $history->comment = $request->attendees_comment;
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
                 $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'File Attachment')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'File Attachment';
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
          if($lastDocument->Date_Due !=$data->Date_Due || !empty($request->Date_Due_comment)) {
             $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Date Due')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Date Due';
            $history->previous =  $lastDocument->Date_Due;
            $history->current = $data->Date_Due;
            $history->comment = $request->Date_Due_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
          if($lastDocument->Summary_Recommendation !=$data->Summary_Recommendation || !empty($request->Summary_Recommendation_comment)) {
             $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Summary Recommendation')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Summary Recommendation';
            $history->previous =  $lastDocument->Summary_Recommendation;
            $history->current = $data->Summary_Recommendation;
            $history->comment = $request->Summary_Recommendation_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
          if($lastDocument->Conclusion !=$data->Conclusion || !empty($request->Conclusion_comment)) {
             $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Conclusion')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Conclusion';
            $history->previous =  $lastDocument->Conclusion;
            $history->current = $data->Conclusion;
            $history->comment = $request->Conclusion_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
            if($lastDocument->file_attachment !=$data->file_attachment || !empty($request->file_attachment_comment)) {
                 $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'File Attachment')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'File Attachment';
            $history->previous =  $lastDocument->file_attachment;
            $history->current = $data->file_attachment;
            $history->comment = $request->file_attachment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
          if($lastDocument->Due_Date_Extension_Justification !=$data->Due_Date_Extension_Justification || !empty($request->Due_Date_Extension_Justification_comment)) {
             $lastDocumentAuditTrail = MeetingManagementAuditTrial::where('meetingmanagement_id', $data->id)
                            ->where('activity_type', 'Due Date Extension Justification')
                            ->exists();
            $history = new MeetingManagementAuditTrial();
            $history->meetingmanagement_id = $data->id;
            $history->activity_type = 'Due Date Extension Justification';
            $history->previous =  $lastDocument->Due_Date_Extension_Justification;
            $history->current = $data->Due_Date_Extension_Justification;
            $history->comment = $request->Due_Date_Extension_Justification_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
    //===================GRID 1============================================================================
        $meetingmanagemengt_id = $data->id;
        
        $newDataMeetingManagement = MeetingManagementGrid::where(['ci_id' => $meetingmanagemengt_id, 'identifier' => 'agenda' ])->firstOrCreate();
        $newDataMeetingManagement->ci_id = $meetingmanagemengt_id;
        $newDataMeetingManagement->identifier = 'agenda';
        $newDataMeetingManagement->data = $request->agenda;
        $newDataMeetingManagement->save();
//==================================================================================================
//===================GRID 2============================================================================
        $meetingmanagemengt_id = $data->id;
        $newDataMeetingManagement = MeetingManagementGrid::where(['ci_id' => $meetingmanagemengt_id, 'identifier' => 'Management_Review_Participants' ])->firstOrCreate();
        $newDataMeetingManagement->ci_id = $meetingmanagemengt_id;
        $newDataMeetingManagement->identifier = 'Management_Review_Participants';
        $newDataMeetingManagement->data = $request->Management_Review_Participants;
        // $history->change_to= "Opened";
        // $history->change_from= "Initiator";
        // $history->action_name="Create";
        $newDataMeetingManagement->save();
//==================================================================================================
//===================GRID 3============================================================================
        $meetingmanagemengt_id = $data->id;
        $newDataMeetingManagement = MeetingManagementGrid::where(['ci_id' => $meetingmanagemengt_id, 'identifier' => 'performance_evaluation' ])->firstOrCreate();
        $newDataMeetingManagement->ci_id = $meetingmanagemengt_id;
        $newDataMeetingManagement->identifier = 'performance_evaluation';
        $newDataMeetingManagement->data = $request->performance_evaluation;
        // $history->change_to= "Opened";
        // $history->change_from= "Initiator";
        // $history->action_name="Create";
        $newDataMeetingManagement->save();
//==================================================================================================
//===================GRID 4============================================================================
        $meetingmanagemengt_id = $data->id;
        $newDataMeetingManagement = MeetingManagementGrid::where(['ci_id' => $meetingmanagemengt_id, 'identifier' => 'action_Item_Details' ])->firstOrCreate();
        $newDataMeetingManagement->ci_id = $meetingmanagemengt_id;
        $newDataMeetingManagement->identifier = 'action_Item_Details';
        $newDataMeetingManagement->data = $request->action_Item_Details;
        // $history->change_to= "Opened";
        // $history->change_from= "Initiator";
        // $history->action_name="Create";
        $newDataMeetingManagement->save();
//==================================================================================================
//===================GRID 5============================================================================
        $meetingmanagemengt_id = $data->id;
        $newDataMeetingManagement = MeetingManagementGrid::where(['ci_id' => $meetingmanagemengt_id, 'identifier' => 'capa_Details' ])->firstOrCreate();
        $newDataMeetingManagement->ci_id = $meetingmanagemengt_id;
        $newDataMeetingManagement->identifier = 'capa_Details';
        $newDataMeetingManagement->data = $request->capa_Details;
        // $history->change_to= "Opened";
        // $history->change_from= "Initiator";
        // $history->action_name="Create";
    
        $newDataMeetingManagement->save();


        toastr()->success('Record is created Successfully');

        return back();
   }
   public function StageChange(Request $request, $id){
if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = MeetingManagement::find($id);
            $lastDocument =  MeetingManagement::find($id);
            $data =  MeetingManagement::find($id);

            if ($changeControl->stage == 1) {
                $changeControl->stage = "2";
                $changeControl->Submitted_By = Auth::user()->name;
                $changeControl->Submitted_on = Carbon::now()->format('d-M-Y');
                $changeControl->Submitted_comment  = $request->comment;
                $changeControl->status = "In Progress";
                $history = new MeetingManagementAuditTrial();
                $history->meetingmanagement_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action ='Auto Submit';
                $history->previous = $lastDocument->Submitted_By;
                $history->current = $changeControl->Submitted_By;
                $history->Submitted_comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='Auto Submit';
                $history->change_to= "In Progress";
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
                        }
                    }
                     } 
                  }

                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }
        if ($changeControl->stage == 2) {
                $changeControl->stage = "3";
                $changeControl->status = "Closed - Done";
                $changeControl->completed_by = Auth::user()->name;
                $changeControl->completed_on = Carbon::now()->format('d-M-Y');
                $changeControl->completed_comment  = $request->comment;
                $history = new MeetingManagementAuditTrial();
                $history->meetingmanagement_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action ='Completed';
                $history->previous = $lastDocument->completed_by;
                $history->current = $changeControl->completed_by;
                $history->completed_comment = $request->comment;
                $history->comments = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='Completed';
                $history->change_to= "Closed - Done";
                $history->change_from= "In Progress";
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
                        }
                    }
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
      public function MeetingManagementAuditTrial($id)
    {
        $data= MeetingManagement::find($id);
        $audit = MeetingManagementAuditTrial::where('meetingmanagement_id', $id)->orderByDesc('id')->get();
        $today = Carbon::now()->format('d-m-y');
        $document = MeetingManagement::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');

        return view('frontend.meeting-management.meetingaudit-trial', compact('audit', 'document', 'today','data'));
    }
       public function meetingauditReport($id)
    {
        $doc = MeetingManagement::find($id);
        $audit = MeetingManagementAuditTrial::where('meetingmanagement_id', $id)->orderByDesc('id')->get();
        $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        $data = MeetingManagementAuditTrial::where('meetingmanagement_id', $doc->id)->orderByDesc('id')->get();
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.meeting-management.meetingauditReport', compact('data','audit' ,'doc'))
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
     public function SingleReport($id){


        $data = MeetingManagement::find($id);
        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
             $meetingmanagement_id = $data->id;
             $grid_Data = MeetingManagementGrid::where(['ci_id' => $meetingmanagement_id, 'identifier' => 'agenda' ])->first();
              $grid_Data1 = MeetingManagementGrid::where(['ci_id' => $meetingmanagement_id, 'identifier' => 'Management_Review_Participants' ])->first();
              $grid_Data2 = MeetingManagementGrid::where(['ci_id' => $meetingmanagement_id, 'identifier' => 'performance_evaluation' ])->first();
              $grid_Data3 = MeetingManagementGrid::where(['ci_id' => $meetingmanagement_id, 'identifier' => 'action_Item_Details' ])->first();
              $grid_Data4 = MeetingManagementGrid::where(['ci_id' => $meetingmanagement_id, 'identifier' => 'capa_Details' ])->first();
            $pdf = PDF::loadview('frontend.meeting-management.meetingsingleReport', compact('data','grid_Data','grid_Data1','grid_Data2','grid_Data3','grid_Data4'))
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
