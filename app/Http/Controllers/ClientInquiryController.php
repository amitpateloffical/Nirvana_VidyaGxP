<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClientInquiry;
use App\Models\ClientInquiryAuditTrial;
use App\Models\RecordNumber;
use App\Models\RoleGroup;
use App\Models\ClientInquiryGrid;
use App\Models\User;
use Carbon\Carbon;
use PDF;
use Helpers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ClientInquiryController extends Controller
{
   
   public function index(){
     $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
    return view('frontend.New_forms.client_inquiry', compact('due_date', 'record_number'));
   }

   public function store(Request $request){
            if (!$request->short_description) {
            toastr()->info("Short Description is required");
            return redirect()->back()->withInput();
        }
    $data = new ClientInquiry();
    
  
    $data->form_type = "ClientInquiry";
    $data->record =((RecordNumber::first()->value('counter')) + 1);
    $data ->originator = Auth::user()->id;
    $data->division_id = $request->division_id;
    $data ->intiation_date = $request->intiation_date;
    $data ->short_description = $request->short_description;
    $data ->assigned_to = $request->assigned_to;
    $data ->due_date = $request->due_date;
    $data ->Customer_Name = $request->Customer_Name;
    $data ->Submit_By = $request->Submit_By;
    $data ->Description = $request->Description;
    $data ->zone = $request->zone;
   $data ->country = $request->country == "Select Country" ? null : $request->country;
    $data ->city = $request->city == "Select City" ? null : $request->city;
    $data ->state = $request->state=="Select State/District" ? null: $request->state;
    $data ->type= $request->type;

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
        $data->save();
    $data ->priority_level = $request->priority_level;
    $data ->Related_URLs = $request->Related_URLs;
    $data ->Product_Type = $request->Product_Type;
    $data ->Manufacturer = $request->Manufacturer;
    //  $data ->Product_name = $request->Product_name;
    // $data ->Batch_number = $request->Batch_number;
    // $data ->Expiry_date = $request->Expiry_date;
    // $data ->Manufactured_date = $request->Manufactured_date;
    // $data ->disposition = $request->disposition;
    // $data ->Comment = $request->Comment;
    $data ->serial_number = $request->serial_number;
    $data ->Supervisor = $request->Supervisor;
    $data ->Inquiry_ate = $request->Inquiry_ate;
    $data ->Inquiry_Source = $request->Inquiry_Source;
    $data ->Inquiry_method = $request->Inquiry_method;
    $data ->branch = $request->branch;
    $data ->Branch_manager = $request->Branch_manager;
    $data ->Customer_names = $request->Customer_names;
    $data ->Business_area = $request->Business_area;
    $data ->account_type = $request->account_type;
    $data ->account_number = $request->account_number;
    $data ->dispute_amount = $request->dispute_amount;
    $data ->currency = $request->currency;
    $data ->category = $request->category;
    $data ->sub_category = $request->sub_category;
    $data ->allegation_language = $request->allegation_language;
    $data ->action_taken = $request->action_taken;
    $data ->broker_id = $request->broker_id;
    $data ->related_inquiries = $request->related_inquiries;
    $data ->problem_name = $request->problem_name;
    $data ->problem_type = $request->problem_type;
    $data ->problem_code = $request->problem_code;
    $data ->comments = $request->comments;

    for ($i = 1; $i <= 5; $i++) {
        $documentNumberKey = "question_$i";
        $trainingDateKey = "response_$i";
        $remarkKey = "remark_$i";

        $question = $request->input($documentNumberKey) ?? $request->input(str_replace('_', '-', $documentNumberKey));
        $response = $request->input($trainingDateKey) ?? $request->input(str_replace('_', '-', $trainingDateKey));
        $remark = $request->input($remarkKey) ?? $request->input(str_replace('_', '-', $remarkKey));

        $data->$documentNumberKey = $question;
        $data->$trainingDateKey = $response;
        $data->$remarkKey = $remark;
    }


    $data->status = "Opened";
    $data->stage = 1;

    $data->save();
      $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();
     if(!empty($data->short_description)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Not Applicable";
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
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Assigned To';
            $history->previous = "Not Applicable";
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
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Date Due';
            $history->previous = "Not Applicable";
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

        if (!empty($data->due_date)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Customer Name';
            $history->previous = "Not Applicable";
            $history->current = $data->Customer_Name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Submit_By)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Submitted By';
            $history->previous = "Not Applicable";
            $history->current = $data->Submit_By;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Description)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Description';
            $history->previous = "Not Applicable";
            $history->current = $data->Description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->zone)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Zone';
            $history->previous = "Not Applicable";
            $history->current = $data->zone;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->country)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Country';
            $history->previous = "Not Applicable";
            $history->current = $data->country;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->city)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'City';
            $history->previous = "Not Applicable";
            $history->current = $data->city;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->state)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'State/District';
            $history->previous = "Not Applicable";
            $history->current = $data->state;
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
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Type';
            $history->previous = "Not Applicable";
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
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Priority Level';
            $history->previous = "Not Applicable";
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

        if (!empty($data->file_Attachment)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'File Attachment';
            $history->previous = "Not Applicable";
            $history->current = $data->file_Attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
                if (!empty($data->question_)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'question_';
            $history->previous = "Not Applicable";
            $history->current = $data->question_;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
                if (!empty($data->response_)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'response_';
            $history->previous = "Not Applicable";
            $history->current = $data->response_;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
                if (!empty($data->remark_)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'remark_';
            $history->previous = "Not Applicable";
            $history->current = $data->remark_;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Related_URLs)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Related URLs';
            $history->previous = "Not Applicable";
            $history->current = $data->Related_URLs;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Product_Type)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Product Type';
            $history->previous = "Not Applicable";
            $history->current = $data->Product_Type;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Manufacturer)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Manufacturer';
            $history->previous = "Not Applicable";
            $history->current = $data->Manufacturer;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Supervisor)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Supervisor';
            $history->previous = "Not Applicable";
            $history->current = $data->Supervisor;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Inquiry_ate)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Inquiry Date';
            $history->previous = "Not Applicable";
            $history->current = $data->Inquiry_ate;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Inquiry_Source)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Inquiry Source';
            $history->previous = "Not Applicable";
            $history->current = $data->Inquiry_Source;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Inquiry_method)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Inquiry Method';
            $history->previous = "Not Applicable";
            $history->current = $data->Inquiry_method;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->branch)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Branch';
            $history->previous = "Not Applicable";
            $history->current = $data->branch;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Branch_manager)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Branch Manager';
            $history->previous = "Not Applicable";
            $history->current = $data->Branch_manager;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->Customer_names)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Customer Name?';
            $history->previous = "Not Applicable";
            $history->current = $data->Customer_names;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->account_type)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Account Type';
            $history->previous = "Not Applicable";
            $history->current = $data->account_type;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
        if (!empty($data->account_number)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Account Number';
            $history->previous = "Not Applicable";
            $history->current = $data->account_number;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->dispute_amount)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Dispute Amount';
            $history->previous = "Not Applicable";
            $history->current = $data->dispute_amount;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->currency)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Currency';
            $history->previous = "Not Applicable";
            $history->current = $data->currency;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->category)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Category';
            $history->previous = "Not Applicable";
            $history->current = $data->category;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->sub_category)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Sub Category';
            $history->previous = "Not Applicable";
            $history->current = $data->sub_category;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->allegation_language)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Allegation language';
            $history->previous = "Not Applicable";
            $history->current = $data->allegation_language;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->action_taken)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Action Taken';
            $history->previous = "Not Applicable";
            $history->current = $data->action_taken;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

        if (!empty($data->broker_id)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Broker Id';
            $history->previous = "Not Applicable";
            $history->current = $data->broker_id;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
           if (!empty($data->related_inquiries)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Related Inquiries';
            $history->previous = "Not Applicable";
            $history->current = $data->related_inquiries;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
           if (!empty($data->problem_name)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Problem Name';
            $history->previous = "Not Applicable";
            $history->current = $data->problem_name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
         if (!empty($data->problem_type)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Problem Type';
            $history->previous = "Not Applicable";
            $history->current = $data->problem_type;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
         if (!empty($data->problem_code)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Problem Code';
            $history->previous = "Not Applicable";
            $history->current = $data->problem_code;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }
          if (!empty($data->comments)) {
            $history = new ClientInquiryAuditTrial();
            $history->ClientInquiry_id = $data->id;
            $history->activity_type = 'Comments';
            $history->previous = "Not Applicable";
            $history->current = $data->comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to= "Opened";
            $history->change_from= "Initiation";
            $history->action_name="Create";
            $history->save();
        }

//===================GRID============================================================================
        $clientinquiry_id = $data->id;
        $newDataClientInquiry = ClientInquiryGrid::where(['ci_id' => $clientinquiry_id, 'identifier' => 'product_material' ])->firstOrCreate();
        $newDataClientInquiry->ci_id = $clientinquiry_id;
        $newDataClientInquiry->identifier = 'product_material';
        $newDataClientInquiry->data = $request->product_material;
        $history->change_to= "Opened";
        $history->change_from= "Initiation";
        $history->action_name="Create";
        $newDataClientInquiry->save();
        // dd($newDataClientInquiry);
//==================================================================================================

    toastr()->success('Record is created Successfully');
    

        return redirect('rcms/qms-dashboard');
   }
   

   public function show($id){

    $data = ClientInquiry::find($id);
        $data->record = str_pad($data->record, 4, '0', STR_PAD_LEFT);
        $data->assign_to_name = User::where('id', $data->assign_id)->value('name');
        $data->initiator_name = User::where('id', $data->initiator_id)->value('name');
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        $clientinquiry_id = $data->id;
        $grid_Data = ClientInquiryGrid::where(['ci_id' => $clientinquiry_id, 'identifier' => 'product_material' ])->first();
        // dd($grid_Data);
        // return dd($grid_Data->data);
    return view('frontend.client-inquiry.view',compact('data','due_date','grid_Data','clientinquiry_id'));
   }

    public function update(Request $request, $id){

    $data = ClientInquiry::find($id);
     $lastDocument = ClientInquiry::find($id);
    $lastdata = ClientInquiry::find($id);
    $lastDocumentRecord = ClientInquiry::find($data->id);
$lastDocumentStatus = $lastDocumentRecord ? $lastDocumentRecord->status : null;
    
   //  $data->Form_Type = "client-inquiry";
    // $data->record = ((RecordNumber::first()->value('counter')) + 1);
    $data ->originator = Auth::user()->id;
    $data->division_id = $request->division_id;
    $data ->intiation_date = $request->intiation_date;
    $data ->short_description = $request->short_description;
    $data ->assigned_to = $request->assigned_to;
    $data ->due_date = $request->due_date;
    $data ->Customer_Name = $request->Customer_Name;
    $data ->Submit_By = $request->Submit_By;
    $data ->Description = $request->Description;
    $data ->zone = $request->zone;
    $data ->country = $request->country == "Select Country" ? null : $request->country;
    $data ->city = $request->city == "Select City" ? null : $request->city;
    $data ->state = $request->state=="Select State" ? null: $request->state;
    $data ->type = $request->type;
    $data ->priority_level = $request->priority_level;
    $data ->Related_URLs = $request->Related_URLs;
    $data ->Product_Type = $request->Product_Type;
    $data ->Manufacturer = $request->Manufacturer;
    // $data ->who_will_be1 = $request->who_will_be1;
    // $data ->who_will_be2 = $request->who_will_be2;
    // $data ->who_will_be3 = $request->who_will_be3;
    // $data ->who_will_be4 = $request->who_will_be4;
    // $data ->who_will_be5 = $request->who_will_be5;
    // $data ->Batch_number = $request->Batch_number;
    // $data ->Expiry_date = $request->Expiry_date;
    // $data ->Manufactured_date = $request->Manufactured_date;
    // $data ->disposition = $request->disposition;
    // $data ->Comment = $request->Comment;

    
    for ($i = 1; $i <= 5; $i++) {
        $documentNumberKey = "question_$i";
        $trainingDateKey = "response_$i";
        $remarkKey = "remark_$i";

        $question = $request->input($documentNumberKey) ?? $request->input(str_replace('_', '-', $documentNumberKey));
        $response = $request->input($trainingDateKey) ?? $request->input(str_replace('_', '-', $trainingDateKey));
        $remark = $request->input($remarkKey) ?? $request->input(str_replace('_', '-', $remarkKey));

        $data->$documentNumberKey = $question;
        $data->$trainingDateKey = $response;
        $data->$remarkKey = $remark;
    }
    $data ->serial_number = $request->serial_number;
    $data ->Supervisor = $request->Supervisor;
    $data ->Inquiry_ate = $request->Inquiry_ate;
    $data ->Inquiry_Source = $request->Inquiry_Source;
    $data ->Inquiry_method = $request->Inquiry_method;
    $data ->branch = $request->branch;
    $data ->Branch_manager = $request->Branch_manager;
    $data ->Customer_names = $request->Customer_names;
    $data ->Business_area = $request->Business_area;
    $data ->account_type = $request->account_type;
    $data ->account_number = $request->account_number;
    $data ->dispute_amount = $request->dispute_amount;
    $data ->currency = $request->currency;
    $data ->category = $request->category;
    $data ->sub_category = $request->sub_category;
    $data ->allegation_language = $request->allegation_language;
    $data ->action_taken = $request->action_taken;
    $data ->broker_id = $request->broker_id;
    $data ->related_inquiries = $request->related_inquiries;
    $data ->problem_name = $request->problem_name;
    $data ->problem_type = $request->problem_type;
    $data ->problem_code = $request->problem_code;
    $data ->comments = $request->comments;
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
    $data->update();
            if($lastDocument->short_description !=$data->short_description || !empty($request->short_description_comment)) {
                   $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Short Description')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
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
         if (($lastDocument != $data->assigned_to) || !empty($request->assigned_to_comment)) {
         $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Assigned To')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Assigned To';
            $history->previous = $lastDocument->assigned_to;
            $history->current = $data->assigned_to;
            $history->comment = $request->assigned_to_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocumentStatus;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastDocumentStatus;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New";  // Set action_name based on the existence of previous entries
            $history->save();
}
            if($lastDocument->due_date !=$data->due_date || !empty($request->due_date_comment)) {
            $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Due Date')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
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
            if($lastDocument->Customer_Name !=$data->Customer_Name || !empty($request->Customer_Name_comment)) {
               $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Customer Name')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Customer Name';
            $history->previous =  $lastDocument->Customer_Name;
            $history->current = $data->Customer_Name;
            $history->comment = $request->Customer_Name_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
            }
            if($lastDocument->Submit_By !=$data->Submit_By || !empty($request->Submit_By_comment)) {
                   $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Submit By')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Submit By';
            $history->previous =  $lastDocument->Submit_By;
            $history->current = $data->Submit_By;
            $history->comment = $request->Submit_By_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
            }
             if($lastDocument->Description !=$data->Description || !empty($request->Description_comment)) {
                   $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Description')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Description';
            $history->previous =  $lastDocument->Description;
            $history->current = $data->Description;
            $history->comment = $request->Description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from=$lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
             }
          if($lastDocument->zone !=$data->zone || !empty($request->zone_comment)) {
              $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Zone')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Zone';
            $history->previous =  $lastDocument->zone;
            $history->current = $data->zone;
            $history->comment = $request->zone_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status; 
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
          }
            if($lastDocument->country !=$data->country || !empty($request->country_comment)) {
                  $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Country')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Country';
            $history->previous =  $lastDocument->country;
            $history->current = $data->country;
            $history->comment = $request->country_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
            }
           if($lastDocument->city !=$data->city || !empty($request->city_comment)) {
              $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'City')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'City';
            $history->previous =  $lastDocument->city;
            $history->current = $data->city;
            $history->comment = $request->city_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from=$lastDocument->status; 
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
           }
        if($lastDocument->state !=$data->state || !empty($request->state_comment)) {
              $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'State')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'State';
            $history->previous =  $lastDocument->state;
            $history->current = $data->state;
            $history->comment = $request->state_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from=$lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
         if($lastDocument->type !=$data->type || !empty($request->type_comment)) {
              $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Type')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
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
              $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Priority level')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
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

        if($lastDocument->file_Attachment !=$data->file_Attachment || !empty($request->file_Attachment_comment)) {
              $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'File Attachment')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'File Attachment';
            $history->previous =  $lastDocument->file_Attachment;
            $history->current = $data->file_Attachment;
            $history->comment = $request->file_Attachment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from=$lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }

        if($lastDocument->question_ !=$data->question_ || !empty($request->question__comment)) {
              $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Question')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Question';
            $history->previous =  $lastDocument->question_;
            $history->current = $data->question_;
            $history->comment = $request->question__comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }
        
        if($lastDocument->response_ !=$data->response_ || !empty($request->response__comment)) {
              $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Response')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Response';
            $history->previous =  $lastDocument->response_;
            $history->current = $data->response_;
            $history->comment = $request->response__comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }

            if($lastDocument->remark_ !=$data->remark_ || !empty($request->remark__comment)) {
                 $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Remark')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Remark';
            $history->previous =  $lastDocument->remark_;
            $history->current = $data->remark_;
            $history->comment = $request->remark__comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
        }

             if($lastDocument->Related_URLs !=$data->Related_URLs || !empty($request->Related_URLs_comment)) {
                 $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Related URLs')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Related URLs';
            $history->previous =  $lastDocument->Related_URLs;
            $history->current = $data->Related_URLs;
            $history->comment = $request->Related_URLs_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
             }

         if($lastDocument->Product_Type !=$data->Product_Type || !empty($request->Product_Type_comment)) {
             $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Product Type')
                            ->exists();
            
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Product Type';
            $history->previous =  $lastDocument->Product_Type;
            $history->current = $data->Product_Type;
            $history->comment = $request->Product_Type_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
         }

          if($lastDocument->Manufacturer !=$data->Manufacturer || !empty($request->Manufacturer_comment)) {
             $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Manufacturer')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Manufacturer';
            $history->previous =  $lastDocument->Manufacturer;
            $history->current = $data->Manufacturer;
            $history->comment = $request->Manufacturer_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
          }

          if($lastDocument->Supervisor !=$data->Supervisor || !empty($request->Supervisor_comment)) {
             $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Supervisor')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Supervisor';
            $history->previous =  $lastDocument->Supervisor;
            $history->current = $data->Supervisor;
            $history->comment = $request->Supervisor_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
          }

        if($lastDocument->Inquiry_ate !=$data->Inquiry_ate || !empty($request->Inquiry_ate_comment)) {
             $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Inquiry Date')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Inquiry Date';
            $history->previous =  $lastDocument->Inquiry_ate;
            $history->current = $data->Inquiry_ate;
            $history->comment = $request->Inquiry_ate_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
          }

         if($lastDocument->Inquiry_Source !=$data->Inquiry_Source || !empty($request->Inquiry_Source_comment)) {
             $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Inquiry Source')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Inquiry Source';
            $history->previous =  $lastDocument->Inquiry_Source;
            $history->current = $data->Inquiry_Source;
            $history->comment = $request->Inquiry_Source_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
          }

         if($lastDocument->Inquiry_method !=$data->Inquiry_method || !empty($request->Inquiry_method_comment)) {
             $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Inquiry method')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Inquiry method';
            $history->previous =  $lastDocument->Inquiry_method;
            $history->current = $data->Inquiry_method;
            $history->comment = $request->Inquiry_method_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
          }

         if($lastDocument->branch !=$data->branch || !empty($request->branch_comment)) {
             $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Branch')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Branch';
            $history->previous =  $lastDocument->branch;
            $history->current = $data->branch;
            $history->comment = $request->branch_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
          }

        if($lastDocument->Branch_manager !=$data->Branch_manager || !empty($request->Branch_manager_comment)) {
             $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Branch manager')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Branch manager';
            $history->previous =  $lastDocument->Branch_manager;
            $history->current = $data->Branch_manager;
            $history->comment = $request->Branch_manager_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
          }

        if($lastDocument->Customer_names !=$data->Customer_names || !empty($request->Customer_names_comment)) {
             $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Customer names')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Customer names';
            $history->previous =  $lastDocument->Customer_names;
            $history->current = $data->Customer_names;
            $history->comment = $request->Customer_names_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
          }

       if($lastDocument->account_type !=$data->account_type || !empty($request->account_type_comment)) {
         $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Account type')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Account type';
            $history->previous =  $lastDocument->account_type;
            $history->current = $data->account_type;
            $history->comment = $request->account_type_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
          }

        if($lastDocument->account_number !=$data->account_number || !empty($request->account_number_comment)) {
             $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Account number')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Account number';
            $history->previous =  $lastDocument->account_number;
            $history->current = $data->account_number;
            $history->comment = $request->account_number_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
          }
        if($lastDocument->dispute_amount !=$data->dispute_amount || !empty($request->dispute_amount_comment)) {
             $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Dispute amount')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Dispute amount';
            $history->previous =  $lastDocument->dispute_amount;
            $history->current = $data->dispute_amount;
            $history->comment = $request->dispute_amount_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
          }

           if($lastDocument->currency !=$data->currency || !empty($request->currency_comment)) {
              $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Currency')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Currency';
            $history->previous =  $lastDocument->currency;
            $history->current = $data->currency;
            $history->comment = $request->currency_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
          }

            if($lastDocument->category !=$data->category || !empty($request->category_comment)) {
                  $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Category')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Category';
            $history->previous =  $lastDocument->category;
            $history->current = $data->category;
            $history->comment = $request->category_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
          }

            if($lastDocument->sub_category !=$data->sub_category || !empty($request->sub_category_comment)) {
                  $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Sub Category')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Sub Category';
            $history->previous =  $lastDocument->sub_category;
            $history->current = $data->sub_category;
            $history->comment = $request->sub_category_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
          }

           if($lastDocument->allegation_language !=$data->allegation_language || !empty($request->allegation_language_comment)) {
              $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Allegation Language')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Allegation Language';
            $history->previous =  $lastDocument->allegation_language;
            $history->current = $data->allegation_language;
            $history->comment = $request->allegation_language_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
          }

           if($lastDocument->action_taken !=$data->action_taken || !empty($request->action_taken_comment)) {
              $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Action Taken')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Action Taken';
            $history->previous =  $lastDocument->action_taken;
            $history->current = $data->action_taken;
            $history->comment = $request->action_taken_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
          }

            if($lastDocument->broker_id !=$data->broker_id || !empty($request->broker_id_comment)) {
                  $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Broker Id')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Broker Id';
            $history->previous =  $lastDocument->broker_id;
            $history->current = $data->broker_id;
            $history->comment = $request->broker_id_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
          }

             if($lastDocument->related_inquiries !=$data->related_inquiries || !empty($request->related_inquiries_comment)) {
                  $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Related Inquiries')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Related Inquiries';
            $history->previous =  $lastDocument->related_inquiries;
            $history->current = $data->related_inquiries;
            $history->comment = $request->related_inquiries_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
          }
                 if($lastDocument->problem_name !=$data->problem_name || !empty($request->problem_name_comment)) {
                      $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Problem Name')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Problem Name';
            $history->previous =  $lastDocument->problem_name;
            $history->current = $data->problem_name;
            $history->comment = $request->problem_name_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
          }
               if($lastDocument->problem_type !=$data->problem_type || !empty($request->problem_type_comment)) {
                  $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Problem Type')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Problem Type';
            $history->previous =  $lastDocument->problem_type;
            $history->current = $data->problem_type;
            $history->comment = $request->problem_type_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
          }
              if($lastDocument->problem_code !=$data->problem_code || !empty($request->problem_code_comment)) {
                  $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Problem Code')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Problem Code';
            $history->previous =  $lastDocument->problem_code;
            $history->current = $data->problem_code;
            $history->comment = $request->problem_code_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
          }
              if($lastDocument->comments !=$data->comments || !empty($request->comments_comment)) {
                  $lastDocumentAuditTrail = ClientInquiryAuditTrial::where('clientinquiry_id', $data->id)
                            ->where('activity_type', 'Comments')
                            ->exists();
            $history = new ClientInquiryAuditTrial();
            $history->clientinquiry_id = $data->id;
            $history->activity_type = 'Comments';
            $history->previous =  $lastDocument->comments;
            $history->current = $data->comments;
            $history->comment = $request->comments_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name=$lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();
          }
//=================================GRID=====================================================
        $clientinquiry_id = $data->id;
        $newDataClientInquiry = ClientInquiryGrid::where(['ci_id' => $clientinquiry_id, 'identifier' => 'product_material' ])->firstOrCreate();
        $newDataClientInquiry->ci_id = $clientinquiry_id;
        $newDataClientInquiry->identifier = 'product_material';
        $newDataClientInquiry->data = $request->product_material;
        $history->origin_state = $lastdata->status;
        $history->change_to= "Not Applicable";
        $history->change_from= $lastdata->status;
        $history->action_name="Update";
        $newDataClientInquiry->save();
//===============================================================================================
    toastr()->success('Record is created Successfully');

        return back();
   }

   //===============1nd Change stage====================
   public function StageChange(Request $request, $id){
if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = ClientInquiry::find($id);
            $lastDocument =  ClientInquiry::find($id);
            $data =  ClientInquiry::find($id);
              if ($changeControl->stage == 1) {
                $changeControl->stage = "2";
                $changeControl->Submitted_By = Auth::user()->name;
                $changeControl->Submitted_on = Carbon::now()->format('d-M-Y');
                $changeControl->Submited_Comment  = $request->comment;
                $changeControl->status = "Supervisor Review";
                $history = new ClientInquiryAuditTrial();
                $history->ClientInquiry_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action ='Submit for Review';
                $history->previous = $lastDocument->Submitted_By;
                $history->current = $changeControl->Submitted_By;
                $history->Submited_Comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='Submit for Review';
                $history->change_to= "Supervisor Review";
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
                $changeControl->status = "Resolution in Progress";
                $changeControl->resolution_progress_completed_by = Auth::user()->name;
                $changeControl->resolution_progress_completed_on = Carbon::now()->format('d-M-Y');
                $changeControl->simple_resol_omment  = $request->comment;
                $history = new ClientInquiryAuditTrial();
                $history->ClientInquiry_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action ='Simple Resolution';
                $history->previous = $lastDocument->resolution_progress_completed_by;
                $history->current = $changeControl->resolution_progress_completed_by;
                $history->simple_resol_omment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='Simple Resolution';
                $history->change_to= "Resolution in Progress";
                $history->change_from= "Supervisor Review";
                $history->action_name ='Not Applicable';
                $history->save();
                $list = Helpers::getQCHeadUserList();
                    foreach ($list as $u) {
                        if($u->q_m_s_divisions_id == $changeControl ->division_id){
                            $email = Helpers::getInitiatorEmail($u->user_id);
                             if ($email !== null) {
                          try{
                              Mail::send(
                                  'mail.view-mail',
                                   ['data' => $changeControl ],
                                function ($message) use ($email) {
                                    $message->to($email)
                                        ->subject("Document is Send By ".Auth::user()->name);
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
            if ($changeControl->stage == 3) {
                $changeControl->stage = "11";
                $changeControl->status = "Closed Done";
                $changeControl->cash_review_completed_by = Auth::user()->name;
                $changeControl->cash_review_completed_on = Carbon::now()->format('d-M-Y');
                $changeControl->completed_Comment  = $request->comment;
                $history = new ClientInquiryAuditTrial();
                $history->ClientInquiry_id = $id;
                $history->activity_type = 'Activity Log';         
                $history->action ='Completed';
                $history->previous = $lastDocument->cash_review_completed_by;
                $history->current = $changeControl->cash_review_completed_by;
                $history->completed_Comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='Complete';
                $history->change_to= "Closed Done";
                $history->change_from= "Resolution in Progress";
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
                                        ->subject("Case Review By ".Auth::user()->name);
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
    //===============2nd Change stage====================
    public function Stage(Request $request, $id){
if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = ClientInquiry::find($id);
            $lastDocument =  ClientInquiry::find($id);
            $data =  ClientInquiry::find($id);
            if ($changeControl->stage == 2) {
                $changeControl->stage = "4";
                $changeControl->status = "Case Review";
                $changeControl->resolution_in_progress_completed_by = Auth::user()->name;
                $changeControl->resolution_in_progress_completed_on = Carbon::now()->format('d-M-Y');
                $changeControl->resolution_progress_Comment  = $request->comment;
                $history = new ClientInquiryAuditTrial();
                $history->ClientInquiry_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action ='Legal Issue';
                $history->previous = $lastDocument->resolution_in_progress_completed_by;
                $history->current = $changeControl->resolution_in_progress_completed_by;
                $history->resolution_progress_Comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='Legal Issue';
                $history->change_to= "Case Review";
                $history->change_from= "Supervisor Review";
                $history->action_name ='Not Applicable';
                $history->save();
                $list = Helpers::getQCHeadUserList();
                    foreach ($list as $u) {
                        if($u->q_m_s_divisions_id == $changeControl ->division_id){
                            $email = Helpers::getInitiatorEmail($u->user_id);
                             if ($email !== null) {
                          try{
                              Mail::send(
                                  'mail.view-mail',
                                   ['data' => $changeControl ],
                                function ($message) use ($email) {
                                    $message->to($email)
                                        ->subject("Document is Send By ".Auth::user()->name);
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
          
            if ($changeControl->stage == 4) {
                $changeControl->stage = "6";
                $changeControl->status = "Root Cause Analysis";
                $changeControl->root_cause_completed_by = Auth::user()->name;
                $changeControl->root_cause_completed_on = Carbon::now()->format('d-M-Y');
                $changeControl->resolution_Comment  = $request->comment;
                $history = new ClientInquiryAuditTrial();
                $history->ClientInquiry_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action ='Resolution';
                $history->previous = $lastDocument->root_cause_completed_by;
                $history->current = $changeControl->root_cause_completed_by;
                $history->resolution_Comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='Resolution';
                $history->stage='Resolution in Progress';
                $history->change_to= "Root Cause Analysis";
                $history->change_from= "Case Review";
                $history->action_name ='Not Applicable';
                
                $history->save();
                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($changeControl->stage == 6) {
                $changeControl->stage = "8";
                $changeControl->status = "Pending Approval";
                $changeControl->pending_approval_completed_by = Auth::user()->name;
                $changeControl->pending_approval_completed_on = Carbon::now()->format('d-M-Y');
                $changeControl->no_analysis_Comment  = $request->comment;
                $history = new ClientInquiryAuditTrial();
                $history->ClientInquiry_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action ='No Analysis Required';
                $history->previous = $lastDocument->pending_approval_completed_by;
                $history->current = $changeControl->pending_approval_completed_by;
                $history->no_analysis_Comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='No Analysis Required';
                $history->change_to= "Pending Approval";
                $history->change_from= "Root Cause Analysis";
                $history->action_name ='Not Applicable';
                $history->save();
                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }
       //===============3nd Change stage====================
    public function CStage(Request $request, $id){
if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = ClientInquiry::find($id);
            $lastDocument =  ClientInquiry::find($id);
            $data =  ClientInquiry::find($id);
            if ($changeControl->stage == 2) {
                $changeControl->stage = "5";
                $changeControl->status = "Work in Progress";
                $changeControl->work_in_progress_completed_by = Auth::user()->name;
                $changeControl->work_in_progress_completed_on = Carbon::now()->format('d-M-Y');
                $changeControl->work_in_progress_Comment  = $request->comment;
                $history = new ClientInquiryAuditTrial();
                $history->ClientInquiry_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action ='Relations/Operational Issue';
                $history->previous = $lastDocument->work_in_progress_completed_by;
                $history->current = $changeControl->work_in_progress_completed_by;
                $history->work_in_progress_Comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='Relations/Operational Issue';
                $history->change_to= "Work in Progress";
                $history->change_from= "Supervisor Review";
                $history->action_name ='Not Applicable';
                $history->save();
                $list = Helpers::getQCHeadUserList();
                    foreach ($list as $u) {
                        if($u->q_m_s_divisions_id == $changeControl ->division_id){
                            $email = Helpers::getInitiatorEmail($u->user_id);
                             if ($email !== null) {
                          try{
                              Mail::send(
                                  'mail.view-mail',
                                   ['data' => $changeControl ],
                                function ($message) use ($email) {
                                    $message->to($email)
                                        ->subject("Document is Send By ".Auth::user()->name);
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
            if ($changeControl->stage == 5) {
                $changeControl->stage = "6";
                $changeControl->status = "Root Cause Analysis";
                $changeControl->root_cause_analysis_completed_by = Auth::user()->name;
                $changeControl->root_cause_analysis_completed_on = Carbon::now()->format('d-M-Y');
                $changeControl->resol_Comment  = $request->comment;
                $history = new ClientInquiryAuditTrial();
                $history->ClientInquiry_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action ='Resolution';
                $history->previous = $lastDocument->root_cause_analysis_completed_by;
                $history->current = $changeControl->root_cause_analysis_completed_by;
                $history->resol_Comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='Resolution';
                $history->change_to= "Root Cause Analysis";
                $history->change_from= "Work in Progress";
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
                                        ->subject("Investigation is Completed By ".Auth::user()->name);
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
            if ($changeControl->stage == 6) {
                $changeControl->stage = "7";
                $changeControl->status = "Pending Preventing Action";
                $changeControl->pending_preventing_action_completed_by = Auth::user()->name;
                $changeControl->pending_preventing_action_completed_on = Carbon::now()->format('d-M-Y');
                $changeControl->analysis_Comment  = $request->comment;
                $history = new ClientInquiryAuditTrial();
                $history->ClientInquiry_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action ='Analysis Complete';
                $history->previous = $lastDocument->pending_preventing_action_completed_by;
                $history->current = $changeControl->pending_preventing_action_completed_by;
                $history->analysis_Comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='Analysis Complete';
                $history->change_to= "Pending Preventing Action";
                $history->change_from= "Root Cause Analysis";
                $history->action_name ='Not Applicable';
                $history->save();
                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($changeControl->stage == 7) {
                $changeControl->stage = "8";
                $changeControl->status = "Pending Approval";
                $changeControl->pending_approval_completed_by = Auth::user()->name;
                $changeControl->pending_approval_completed_on = Carbon::now()->format('d-M-Y');
                $changeControl->pending_approval_Comment  = $request->comment;
                $history = new ClientInquiryAuditTrial();
                $history->ClientInquiry_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action_name ='Pending Action Completion';
                $history->previous = $lastDocument->pending_approval_completed_by;
                $history->current = $changeControl->pending_approval_completed_by;
                $history->pending_approval_Comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='Pending Action Completion';
                $history->change_to= "Pending Approval";
                $history->change_from= "Pending Preventing Action";
                $history->action_name ='Not Applicable';
                $history->save();
                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }
                    if ($changeControl->stage == 8) {
                $changeControl->stage = "9";
                $changeControl->status = "Pending Approval";
                $changeControl->approval_completed_by = Auth::user()->name;
                $changeControl->approval_completed_on = Carbon::now()->format('d-M-Y'); 
                $changeControl->approve_Comment  = $request->comment;
                $history = new ClientInquiryAuditTrial();
                $history->ClientInquiry_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action_name ='Approve';
                $history->previous = $lastDocument->pending_approval_completed_by;
                $history->current = $changeControl->pending_approval_completed_by;
                $history->approve_Comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='Approve';
                $history->change_to= "Closed Done";
                $history->change_from= "Pending Approval";
                $history->action_name ='Not Applicable';
                $history->save();  
                $list = Helpers::getQAUserList();
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
          
        // if ($changeControl->stage == 9) {
        //         $changeControl->stage = "10";
        //         $changeControl->status = "Closed - Done";
        //         $changeControl->qA_head_approval_completed_by = Auth::user()->name;
        //         $changeControl->qA_head_approval_completed_on = Carbon::now()->format('d-M-Y');
        //         $history = new ClientInquiryAuditTrial();
        //         $history->ClientInquiry_id = $id;
        //         $history->activity_type = 'Activity Log';
        //         $history->previous = $lastDocument->qA_review_completed_by;
        //         $history->current = $changeControl->qA_review_completed_by;
        //         $history->comment = $request->comment;
        //         $history->user_id = Auth::user()->id;
        //         $history->user_name = Auth::user()->name;
        //         $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //         $history->origin_state = $lastDocument->status;
        //         $history->stage='QA Head Approval Completed';
        //         $history->save();
        //         $list = Helpers::getHodUserList();
        //             foreach ($list as $u) {
        //                 if($u->q_m_s_divisions_id ==$changeControl->division_id){
        //                     $email = Helpers::getInitiatorEmail($u->user_id);
        //                      if ($email !== null) {
                          
        //                       Mail::send(
        //                           'mail.view-mail',
        //                            ['data' => $changeControl],
        //                         function ($message) use ($email) {
        //                             $message->to($email)
        //                                 ->subject("Document is send By ".Auth::user()->name);
        //                         }
        //                       );
        //                     }
        //              } 
        //           }
        //         $changeControl->update();
        //         toastr()->success('Document Sent');
        //         return back();
        //     }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

       public function RejectStateChanges(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = ClientInquiry::find($id);


            if ($changeControl->stage == 2) {
                $changeControl->stage = "1";
                $changeControl->status = "Opened";
                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changeControl->stage == 8) {
                $changeControl->stage = "6";
                $changeControl->status = "Supervisor Review";
                $changeControl->rejected_by = Auth::user()->name;
                $changeControl->rejected_on = Carbon::now()->format('d-M-Y');
                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }
                   } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

public function RejectState(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = ClientInquiry::find($id);
            // if ($changeControl->stage == 2) {
            //     $changeControl->stage = "1";
            //     $changeControl->status = "Opened";
            //     $changeControl->update();
            //     toastr()->success('Document Sent');
            //     return back();
            // }
            if ($changeControl->stage == 8) {
                $changeControl->stage = "6";
                $changeControl->status = "Supervisor Review
";
                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }
                   } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }
    public function ClientCancel(Request $request, $id)
    {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $lab2 = ClientInquiry::find($id);

            if ($lab2->stage == 1) {
                $lab2->stage = "0";
                $lab2->status = "Closed-Cancelled";
                $lab2->cancel_by = Auth::user()->name;
                $lab2->cancel_on = Carbon::now()->format('d-m-y');   
                $lab2->Cancel_comment  = $request->comment;
                $history = new ClientInquiryAuditTrial();
                $history->ClientInquiry_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action_name ='Cancel';
                $history->stage='Cancel';
                $history->change_to= "Closed Done";
                $history->change_from= "Opened";
                $history->action_name ='Not Applicable';



                $lab2->update();
                toastr()->success('Document Sent');
                return back();
            }
        }}
    //     public function auditDetailsClientInquiry($id)
    // {

    //     $detail = ClientInquiryAuditTrial::find($id);

    //     $detail_data = ClientInquiryAuditTrial::where('activity_type', $detail->activity_type)->where('ClientInquiry_id', $detail->ClientInquiry_id)->latest()->get();

    //     $doc = ClientInquiry::where('id', $detail->ClientInquiry_id)->first();

    //     $doc->origiator_name = User::find($doc->initiator_id);
    //     return view('frontend.client-inquiry.clientauditDetails ', compact('detail', 'doc', 'detail_data'));
    // }
    // public function auditReport($id)
    // {
    //     $doc = ClientInquiry::find($id);
    //     if (!empty($doc)) {
    //         $doc->originator = User::where('id', $doc->initiator_id)->value('name');
    //         $data = ClientInquiry::where('ClientInquiry_id', $id)->get();
    //         $pdf = App::make('dompdf.wrapper');
    //         $time = Carbon::now();
    //         $pdf = PDF::loadview('frontend.client-inquiry.clientauditReport', compact('data', 'doc'))
    //             ->setOptions([
    //                 'defaultFont' => 'sans-serif',
    //                 'isHtml5ParserEnabled' => true,
    //                 'isRemoteEnabled' => true,
    //                 'isPhpEnabled' => true,
    //             ]);
    //         $pdf->setPaper('A4');
    //         $pdf->render();
    //         $canvas = $pdf->getDomPDF()->getCanvas();
    //         $height = $canvas->get_height();
    //         $width = $canvas->get_width();
    //         $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');
    //         $canvas->page_text($width / 4, $height / 2, $doc->status, null, 25, [0, 0, 0], 2, 6, -20);
    //         return $pdf->stream('ClientInquiry-AuditTrial' . $id . '.pdf');
    //     }
    // }

    public function auditReport($id)
    {
        $doc = ClientInquiry::find($id);
        $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        $audit = ClientInquiryAuditTrial::where('clientInquiry_id', $id)->orderByDESC('id')->get()->unique('activity_type');
        $data = ClientInquiryAuditTrial::where('ClientInquiry_id', $doc->id)->orderByDesc('id')->get();
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.client-inquiry.clientauditReport', compact('data', 'doc','audit'))
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

    // public function ClientInquiryAuditTrial($id)
    // {
    //     $data= ClientInquirnm  y::find($id);
    //     $audit = ClientInquiryAuditTrial::where('clientInquiry_id', $id)->orderByDESC('id')->get()->unique('activity_type');
    //     $today = Carbon::now()->format('d-m-y');
    //     $document = ClientInquiry::where('id', $id)->first();
    //     $document->initiator = User::where('id', $document->initiator_id)->value('name');

    //     return view('frontend.client-inquiry.clientaudit-trial ', compact('audit', 'document', 'today','data'));
    // }
        public function ClientInquiryAuditTrial($id)
    {
        $data= ClientInquiry::find($id);
        $audit = ClientInquiryAuditTrial::where('clientInquiry_id', $id)->orderByDesc('id')->get();
        $today = Carbon::now()->format('d-m-y');
        $document = ClientInquiry::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');

        return view('frontend.client-inquiry.clientaudit-trial ', compact('audit', 'document', 'today','data'));
    }



    public function SingleReport($id){


        $data = ClientInquiry::find($id);
        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
             $clientinquiry_id = $data->id;
             $grid_Data = ClientInquiryGrid::where(['ci_id' => $clientinquiry_id, 'identifier' => 'product_material' ])->first();
            $pdf = PDF::loadview('frontend.client-inquiry.clientinquirySingleReport', compact('data','grid_Data'))
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
            return $pdf->stream('Client-Inquiry' . $id . '.pdf');

    }

}

public function Actionchild(){
 return view ('frontend.forms.action-item');   
}

}