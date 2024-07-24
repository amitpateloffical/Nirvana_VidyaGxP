<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecordNumber;
use App\Models\Product_Validation;
use App\Models\ProductionValidationTrail;
use App\Models\RoleGroup;
use Illuminate\Support\Facades\Hash;
use Helpers;
use Illuminate\Support\Facades\Mail;

// use App\Http\Controllers\newForm\User;

use App\Models\User;
use Illuminate\Support\Facades\App;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Product_ValidationController extends Controller
{

    public function index()
    {
       // $old_record = Product_Validation::select('id', 'division_id', 'record_number')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');



        // $registrations = MedicalDeviceRegistration::all();
        return view('frontend.New_forms.first_product_validation',compact('record_number','due_date'));
    }

    public function ProductionValidationCreate(Request $request)
    {


        //dd($request);
        // $request->validate([
        //     'record_number' => 'required|string|max:255',
        //     'date_of_initiation' => 'required|date',
        //     'assign_to' => 'required|string|max:255',
        //     'due_date_gi' => 'required|date',
        //     'short_description' => 'nullable|string',
        //     'registration_type_gi' => 'required|string|max:255',
        //     'file_attachment_gi' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // example for file validation
        //     'parent_record_number' => 'nullable|string|max:255',
        //     'local_record_number' => 'nullable|string|max:255',
        //     'zone_departments' => 'nullable|string|max:255',
        //     'country_number' => 'nullable|string|max:255',
        //     'regulatory_departments' => 'nullable|string|max:255',
        //     'registration_number' => 'nullable|string|max:255',
        //     'risk_based_departments' => 'nullable|string|max:255',
        //     'device_approval_departments' => 'nullable|string|max:255',
        //     'marketing_auth_number' => 'nullable|string|max:255',
        //     'manufacturer_number' => 'nullable|string|max:255',
        //     'audit_agenda_grid' => 'nullable|string|max:255',
        //     'manufacturing_description' => 'nullable|string|max:255',
        //     'dossier_number' => 'nullable|string|max:255',
        //     'dossier_departments' => 'nullable|string|max:255',
        //     'description' => 'nullable|string',
        //     'planned_submission_date' => 'nullable|date',
        //     'actual_submission_date' => 'nullable|date',
        //     'actual_approval_date' => 'nullable|date',
        //     'actual_rejection_date' => 'nullable|date',
        //     'renewal_departments' => 'nullable|string|max:255',
        //     'next_renewal_date' => 'nullable|date',
        // ]);

        $data = new Product_Validation();

        // $old_record = Product_Validation::select('id', 'division_id', 'record_number')->get();
        $data->record = ((RecordNumber::first()->value('counter')) + 1);

        if (!empty($request->attachment)) {
            $files = [];
            if ($request->hasfile('attachment')) {
                foreach ($request->file('attachment') as $file) {
                    $name = $request->name . 'attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $data->attachment = json_encode($files);
        }


        // dd($request->all());
       $data->initiator_id = Auth::user()->id;
       // $data->division_id = 7;
    //  $data->stage = $request->stage;
    //     $data->status = $request->status;
       $data->acknowledge_by = $request->acknowledge_by;
        $data->acknowledge_on = $request->acknowledge_on;

        $data->Schedule_Send_Sample_by = $request->Schedule_Send_Sample_by;
        $data->Schedule_Send_Sample_on = $request->Schedule_Send_Sample_on;

       $data->Reject_Sample_by = $request->Reject_Sample_by;
       $data->Reject_Sample_on = $request->Reject_Sample_on;

       $data->Send_For_Analysis_by = $request->Send_For_Analysis_by;
        $data->Send_For_Analysis_on = $request->Send_For_Analysis_on;

       $data->Recall_Product_by = $request->Recall_Product_by;
       $data->Recall_Product_on = $request->Recall_Product_on;

       $data->Approve_Sample_by = $request->Approve_Sample_by;
        $data->Approve_Sample_on = $request->Approve_Sample_on;

       $data->Create_Recall_by = $request->Create_Recall_by;
       $data->Create_Recall_on = $request->Create_Recall_on;

       $data->Recall_Closed_by = $request->Recall_Closed_by;
        $data->Recall_Closed_on = $request->Recall_Close_on;

       $data->Analyzee_by = $request->Analyzee_by;
       $data->Analyze_on = $request->Analyze_on;


       $data->Release_by = $request->Release_by;
        $data->Release_on = $request->Release_on;




       $data->type = "Product Validation";

       // $data->record = $request->record;
        $data->date_of_initiation = $request->date_of_initiation;
        $data->initiator_id = $request->initiator_id;


        $data->product = $request->product;
        $data->assign_to = $request->assign_to;
        $data->due_date = $request->due_date;
        $data->short_description = $request->short_description;
        $data->product_type = $request->product_type;
        $data->priority_level = $request->priority_level;
        // $data->file_attachment_gi = $request->file_attachment_gi;
        $data->discription = $request->discription;
        $data->comments = $request->comments;
        $data->file_attachment = $request->file_attachment;
        $data->related_url = $request->related_url;
        $data->related_record = $request->related_record;
       // $data->quality_follow_up_summary = $request->quality_follow_up_summary;

       //=========================================================Validation Information=====================================================================================
       $data->start_date = $request->start_date;
       $data->sample_details = $request->sample_details;
       $data->validation_summary = $request->validation_summary;
       $data->externail_lab = $request->externail_lab;
       $data->lab_commnets = $request->lab_commnets;
       $data->product_release = $request->product_release;
       $data->product_recelldetails = $request->product_recelldetails;



       if (!empty($request->inv_attachment)) {
        $files = [];
        if ($request->hasfile('inv_attachment')) {
            foreach ($request->file('inv_attachment') as $file) {
                $name = $request->name . 'inv_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $data->inv_attachment = json_encode($files);
    }





        if (!empty($request->Audit_file)) {
            $files = [];
            if ($request->hasfile('Audit_file')) {
                foreach ($request->file('Audit_file') as $file) {
                    $name = $request->name . 'Audit_file' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $data->file_attachment = json_encode($files);
        }

        if (!empty ($request->file_attachment_gi)) {
            $files = [];

            if ($request->hasfile('file_attachment_gi')) {
                foreach ($request->file('file_attachment_gi') as $file) {
                    $name = time() . '_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload'), $name);
                    $files[] = $name;
                }
            }

            $data->file_attachment_gi = json_encode($files);
        }
        $data->status = 'Opened';
        $data->stage = 1;
        // dd($data);
        $data->save();
        //dd($data);

        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();

                //  if (!empty($request->division_id)) {
                //   $history = new ProductionValidationTrail();
                //  $history->root_id = $data->id;
                //      $history->activity_type = 'Division Id';
                //      $history->previous = "Null";
                //     $history->current = $data->division_id;
                //     $history->comment = "Not Applicable";
                //     $history->user_id = Auth::user()->id;
                //     $history->user_name = Auth::user()->name;
                //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                //     $history->origin_state = $data->status;
                //     $history->change_from ="Initiation";
                //     $history->change_to ="Opened";
                //     $history->action_name = "Create";
                //     $history->save();
                //     }

                    if (!empty($data->short_description)) {
                        // dd($request->short_description);
                        $history = new ProductionValidationTrail();
                        $history->root_id = $data->id;
                        $history->activity_type = 'Short Discription';
                        $history->previous = "Null";
                        $history->current = $data->short_description;
                        $history->comment = "Not Applicable";
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $data->status;
                         $history->change_from ="Initiation";
                         $history->change_to ="Opened";
                        $history->action_name = "Create";
                        $history->save();
                    }


        if (!empty($data->record_number)) {
            $history = new ProductionValidationTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'Record Number';
            $history->previous = "Null";
            $history->current = $data->record_number;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
        }


        if (!empty($data->assign_to)) {
            $history = new ProductionValidationTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'Assign To';
            $history->previous = "Null";
            $history->current = $data->assign_to;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
        }




        if (!empty($data->due_date)) {
            $history = new ProductionValidationTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'Due Date';
            $history->previous = "Null";
            $history->current = $data->due_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
        }



        if (!empty($data->product_type)) {
            $history = new ProductionValidationTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'Product Type';
            $history->previous = "Null";
            $history->current = $data->product_type;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
        }




        if (!empty($data->discription)) {
            $history = new ProductionValidationTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'Discription';
            $history->previous = "Null";
            $history->current = $data->discription;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
        }
        if (!empty($data->comments)) {
           $history = new ProductionValidationTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'Comments';
            $history->previous = "Null";
            $history->current = $data->comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
         }
        if (!empty($data->scheduled_start_date)) {
            $history = new ProductionValidationTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'Scheduled Start Date';
            $history->previous = "Null";
            $history->current = $data->scheduled_start_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
         }

        if (!empty($data->scheduled_end_date)) {
            $history = new ProductionValidationTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'Scheduled End Date';
            $history->previous = "Null";
            $history->current = $data->scheduled_end_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
         }
         if (!empty($data->file_attachment)) {
            $history = new ProductionValidationTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'File Attechment ';
            $history->previous = "Null";
            $history->current = $data->file_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
         }
        if (!empty($data->related_url)) {
            $history = new ProductionValidationTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'Related URl';
            $history->previous = "Null";
            $history->current = $data->related_url;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
        // }
        if (!empty($data->related_record)) {
            $history = new ProductionValidationTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'Related Record';
            $history->previous = "Null";
            $history->current = $data->related_record;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
         }

        if (!empty($data->product)) {
            $history = new ProductionValidationTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'Product';
            $history->previous = "Null";
            $history->current = $data->product;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
        }
        if (!empty($data->priority_level)) {
            $history = new ProductionValidationTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'Priority Level';
            $history->previous = "Null";
            $history->current = $data->priority_level;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
         }
         if (!empty($data->intiation_date)) {
            $history = new ProductionValidationTrail();
            $history->root_id = $data->id;
            $history->activity_type = ' Intitiation Date';
            $history->previous = "Null";
            $history->current = $data->intiation_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
        }

        // if (!empty($data->quality_follow_up_summary)) {
        //     $history = new ProductionValidationTrail();
        //     $history->root_id = $data->id;
        //     $history->activity_type = 'Initiator';
        //     $history->previous = "Null";
        //     $history->current = $data->quality_follow_up_summary;
        //     $history->comment = "Not Applicable";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $data->status;
        //      $history->change_from ="Initiation";
        //      $history->change_to ="Opened";
        //     $history->action_name = "Create";
        //     $history->save();
        //  }



    }

    toastr()->success(" First Production Validation is created succusfully");
    return redirect(url('rcms/qms-dashboard'));
    // toastr()->success(" First Production Validation is created succusfully");
    // return redirect(url('rcms/qms-dashboard'));

    }


    public function renewal_forword_close(Request $request, $id){
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)){
            $data = Product_Validation::find($id);
            $lastData =  Product_Validation::find($id);


        if ($data->stage == 3){
            $data->stage = "5";
            $data->status = "Pending Product Release";

            $data->Reject_Sample_by = Auth::user()->name;
            $data->Reject_Sample_on = Carbon::now()->format('d-M-Y');

            $data->Send_For_Analysis_by = Auth::user()->name;
            $data->Send_For_Analysis_on = Carbon::now()->format('d-M-Y');

            $data->Approve_Sample_by = Auth::user()->name;
            $data->Approve_Sample_on = Carbon::now()->format('d-M-Y');

            $data->Recall_Product_by = Auth::user()->name;
            $data->Recall_Product_on = Carbon::now()->format('d-M-Y');

         //  $data->closed_not_approved_comment = $request->comment;
         $history = new ProductionValidationTrail();
         $history->root_id = $id;
         $history->activity_type = 'Activity Log';
         $history->action = 'Submit';
         $history->previous = $lastData->Approve_Sample_by;
         $history->current = $data->Approve_Sample_by;
         $history->comment = $request->comment;
         $history->user_id = Auth::user()->id;
         $history->user_name = Auth::user()->name;
         $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
         $history->origin_state = $lastData->status;
         $history->change_to = 'Pending Product Release';
         $history->change_from = $lastData->status;
         $history->action_name = 'Not Applicable';
            $history->stage= "Submit";
     $history->action_name = "Submit";
     $history->save();

                //     $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $capa->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //             if ($email !== null) {

                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $capa],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Submitted By ".Auth::user()->name);
                //                 }
                //             );
                //             }
                //     }
                // }
            $data->update();
            toastr()->success('Document Sent');
            return back();
        }

        if ($data->stage == 7){
            $data->stage = "8";
            $data->status = "Closed - Recalled";
            $data->Start_Production_by = Auth::user()->name;
            $data->Start_Production_on = Carbon::now()->format('d-M-Y');

        //    $data->closed_not_approved_comment = $request->comment;
        $history = new ProductionValidationTrail();
        $history->root_id = $id;
        $history->activity_type = 'Activity Log';
        $history->action = 'Submit';
        $history->previous = $lastData->Start_Production_by;
        $history->current = $data->Start_Production_by;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastData->status;
        $history->change_to = 'Closed - Recalled';
        $history->change_from = $lastData->status;
        $history->action_name = 'Not Applicable';
           $history->stage= "Submit";
    $history->action_name = "Submit";
    $history->save();
                //     $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $capa->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //             if ($email !== null) {

                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $capa],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Submitted By ".Auth::user()->name);
                //                 }
                //             );
                //             }
                //     }
                // }
            $data->update();
            toastr()->success('Document Sent');
            return back();
        }

        else{
            toastr()->error('E-signature Not match');
            return back();
        }
    }
}
public function renewal_forword2_close(Request $request, $id){
    if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)){
        $data = Product_Validation::find($id);
        $lastData =  Product_Validation::find($id);


    if ($data->stage == "3"){
        $data->stage = "4";
        $data->status = "Product Recalled";


           $data->Reject_Sample_by = Auth::user()->name;
        $data->Reject_Sample_on = Carbon::now()->format('d-M-Y');

        $data->Send_For_Analysis_by = Auth::user()->name;
        $data->Send_For_Analysis_on = Carbon::now()->format('d-M-Y');

        $data->Approve_Sample_by = Auth::user()->name;
        $data->Approve_Sample_on = Carbon::now()->format('d-M-Y');

        $data->Recall_Product_by = Auth::user()->name;
        $data->Recall_Product_on = Carbon::now()->format('d-M-Y');

        $history = new ProductionValidationTrail();
        $history->root_id = $id;
        $history->activity_type = 'Activity Log';
        $history->action = 'Submit';
        $history->previous = $lastData->Recall_Product_by;
        $history->current = $data->Recall_Product_by;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastData->status;
        $history->change_to = 'Product Recalled';
        $history->change_from = $lastData->status;
        $history->action_name = 'Not Applicable';
           $history->stage= "Submit";
    $history->action_name = "Submit";
    $history->save();
            //     $list = Helpers::getHodUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $capa->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //             if ($email !== null) {

            //             Mail::send(
            //                 'mail.view-mail',
            //                 ['data' => $capa],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document is Submitted By ".Auth::user()->name);
            //                 }
            //             );
            //             }
            //     }
            // }
        $data->update();
        toastr()->success('Document Sent');
        return back();
    }





    if ($data->stage == "4"){
        $data->stage = "8";
        $data->status = "Product Released";
        $data->Recall_Closed_by = Auth::user()->name;
        $data->Recall_Closed_on = Carbon::now()->format('d-M-Y');

      //$data->closed_not_approved_comment = $request->comment;

      $history = new ProductionValidationTrail();
      $history->root_id = $id;
      $history->activity_type = 'Activity Log';
      $history->action = 'Submit';
      $history->previous = $lastData->Recall_Closed_by;
      $history->current = $data->Recall_Closed_by;
      $history->comment = $request->comment;
      $history->user_id = Auth::user()->id;
      $history->user_name = Auth::user()->name;
      $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
      $history->origin_state = $lastData->status;
      $history->change_to = 'Product Released';
      $history->change_from = $lastData->status;
      $history->action_name = 'Not Applicable';
         $history->stage= "Submit";
  $history->action_name = "Submit";
  $history->save();
            //     $list = Helpers::getHodUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $capa->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //             if ($email !== null) {

            //             Mail::send(
            //                 'mail.view-mail',
            //                 ['data' => $capa],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document is Submitted By ".Auth::user()->name);
            //                 }
            //             );
            //             }
            //     }
            // }
        $data->update();
        toastr()->success('Document Sent');
        return back();
    }


    if ($data->stage == "5"){
        $data->stage = "6";
        $data->status = "Product Released";
        $data->Release_by = Auth::user()->name;
        $data->Release_on = Carbon::now()->format('d-M-Y');

    //  $data->closed_not_approved_comment = $request->comment;
      $history = new ProductionValidationTrail();
      $history->root_id = $id;
      $history->activity_type = 'Activity Log';
      $history->action = 'Submit';
      $history->previous = $lastData->Release_by;
      $history->current = $data->Release_by;
      $history->comment = $request->comment;
      $history->user_id = Auth::user()->id;
      $history->user_name = Auth::user()->name;
      $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
      $history->origin_state = $lastData->status;
      $history->change_to = 'Product Released';
      $history->change_from = $lastData->status;
      $history->action_name = 'Not Applicable';
         $history->stage= "Submit";
  $history->action_name = "Submit";
  $history->save();
            //     $list = Helpers::getHodUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $capa->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //             if ($email !== null) {

            //             Mail::send(
            //                 'mail.view-mail',
            //                 ['data' => $capa],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document is Submitted By ".Auth::user()->name);
            //                 }
            //             );
            //             }
            //     }
            // }
        $data->update();
        toastr()->success('Document Sent');
        return back();
    }
    if ($data->stage == 6){
        $data->stage = "7";
        $data->status = "Product Released";
        $data->Analyzee_by = Auth::user()->name;
        $data->Analyzee_by = Carbon::now()->format('d-M-Y');

      // $data->closed_not_approved_comment = $request->comment;
      $history = new ProductionValidationTrail();
      $history->root_id = $id;
      $history->activity_type = 'Activity Log';
      $history->action = 'Submit';
      $history->previous = $lastData->Analyzee_by;
      $history->current = $data->Analyzee_by;
      $history->comment = $request->comment;
      $history->user_id = Auth::user()->id;
      $history->user_name = Auth::user()->name;
      $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
      $history->origin_state = $lastData->status;
      $history->change_to = 'Product Released';
      $history->change_from = $lastData->status;
      $history->action_name = 'Not Applicable';
         $history->stage= "Submit";
  $history->action_name = "Submit";
  $history->save();
            //     $list = Helpers::getHodUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $capa->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //             if ($email !== null) {

            //             Mail::send(
            //                 'mail.view-mail',
            //                 ['data' => $capa],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document is Submitted By ".Auth::user()->name);
            //                 }
            //             );
            //             }
            //     }
            // }
        $data->update();
        toastr()->success('Document Sent');
        return back();
    }
  if ($data->stage == 6){
        $data->stage = "7";
        $data->status = "Product Released";
        $data->Analyzee_by = Auth::user()->name;
        $data->Analyzee_by = Carbon::now()->format('d-M-Y');

     // $data->closed_not_approved_comment = $request->comment;
      $history = new ProductionValidationTrail();
      $history->root_id = $id;
      $history->activity_type = 'Activity Log';
      $history->action = 'Submit';
      $history->previous = $lastData->Analyzee_by;
      $history->current = $data->Analyzee_by;
      $history->comment = $request->comment;
      $history->user_id = Auth::user()->id;
      $history->user_name = Auth::user()->name;
      $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
      $history->origin_state = $lastData->status;
      $history->change_to = 'Product Released';
      $history->change_from = $lastData->status;
      $history->action_name = 'Not Applicable';
         $history->stage= "Submit";
  $history->action_name = "Submit";
  $history->save();
            //     $list = Helpers::getHodUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $capa->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //             if ($email !== null) {

            //             Mail::send(
            //                 'mail.view-mail',
            //                 ['data' => $capa],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document is Submitted By ".Auth::user()->name);
            //                 }
            //             );
            //             }
            //     }
            // }
        $data->update();
        toastr()->success('Document Sent');
        return back();
    }

    if ($data->stage == 7){
        $data->stage = "9";
        $data->status = "close-Done";
        $data->Start_Production_by = Auth::user()->name;
        $data->Start_Production_on = Carbon::now()->format('d-M-Y');

     // $data->closed_not_approved_comment = $request->comment;
     $history = new ProductionValidationTrail();
     $history->root_id = $id;
     $history->activity_type = 'Activity Log';
     $history->action = 'Submit';
     $history->previous = $lastData->Start_Production_by;
     $history->current = $data->Start_Production_by;
     $history->comment = $request->comment;
     $history->user_id = Auth::user()->id;
     $history->user_name = Auth::user()->name;
     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
     $history->origin_state = $lastData->status;
     $history->change_to = 'close-Done';
     $history->change_from = $lastData->status;
     $history->action_name = 'Not Applicable';
        $history->stage= "Submit";
 $history->action_name = "Submit";
 $history->save();
            //     $list = Helpers::getHodUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $capa->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //             if ($email !== null) {

            //             Mail::send(
            //                 'mail.view-mail',
            //                 ['data' => $capa],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document is Submitted By ".Auth::user()->name);
            //                 }
            //             );
            //             }
            //     }
            // }
        $data->update();
        toastr()->success('Document Sent');
        return back();
    }
    else{
        toastr()->error('E-signature Not match');
        return back();
    }
    }
}


public function renewal_forword3_close(Request $request, $id){
    if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)){
        $data = Product_Validation::find($id);
        $lastData = Product_Validation::find($id);


    if ($data->stage == "3"){
        $data->stage = "6";
        $data->status = "Pending Analysis";



        $data->Send_For_Analysis_by = Auth::user()->name;
        $data->Send_For_Analysis_on = Carbon::now()->format('d-M-Y');


        $history = new ProductionValidationTrail();
        $history->root_id = $id;
        $history->activity_type = 'Activity Log';
        $history->action = 'Submit';
        $history->previous = $lastData->send_For_Analysis_by;
        $history->current = $data->send_For_Analysis_by;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastData->status;
        $history->change_to = 'Pending Analysis';
        $history->change_from = $lastData->status;
        $history->action_name = 'Not Applicable';
           $history->stage= "Submit";
    $history->action_name = "Submit";
    $history->save();
            //     $list = Helpers::getHodUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $capa->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //             if ($email !== null) {

            //             Mail::send(
            //                 'mail.view-mail',
            //                 ['data' => $capa],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document is Submitted By ".Auth::user()->name);
            //                 }
            //             );
            //             }
            //     }
            // }
        $data->update();
        toastr()->success('Document Sent');
        return back();
    }

}
}

public function RejectStateChange(Request $request, $id)
{
    if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
        $data = Product_Validation::find($id);


        if ($data->stage == 3) {
            $data->stage = "2";
            $data->status = "Pending Scheduling & Sample";
           $data->Reject_Sample_by = Auth::user()->name;
           $data->Reject_Sample_on = Carbon::now()->format('d-M-Y');
            $data->update();
            toastr()->success('Document Sent');
            return back();
        }




    } else {
        toastr()->error('E-signature Not match');
        return back();
    }
}


public function RejectStateChange2(Request $request, $id)
{
    if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
        $data = Product_Validation::find($id);


        if ($data->stage == 4) {
            $data->stage = "3";
            $data->status = "Pending Scheduling & Sample";
           $data->Reject_by = Auth::user()->name;
           $data->Reject_by = Carbon::now()->format('d-M-Y');
            $data->update();
            toastr()->success('Document Sent');
            return back();
        }




    } else {
        toastr()->error('E-signature Not match');
        return back();
    }
}

















    public function ProductionShow ($id)
    {

        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        // dd($id);

        $data = Product_Validation::find($id);
        // dd($data);
        // $audit =QualityFollowup::where('parent_id', $id)->orderByDESC('id')->get()->unique('activity_type');
        $today = Carbon::now()->format('d-m-y');
        $document =Product_Validation::where('id', $id)->first();
     //   $old_record = Product_Validation::select('id', 'division_id', 'record_number')->get();
       // $record_number = ((RecordNumber::first()->value('counter')) + 1);
       // $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');

        //  $document->initiator = User::where('id', $document->initiator_id)->value('name');
        return view('frontend.ProductionValidation.view',  compact('data','due_date'));
    }

    public function production_send_stage(Request $request, $id)
    {


        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $data = Product_Validation::find($id);
            $lastData = Product_Validation::find($id);

            if ($data->stage == 1) {
                $data->stage = "2";
                $data->status = "Pending Scheduling & Sample";
                $data->acknowledge_by = Auth::user()->name;
                $data->acknowledge_on = Carbon::now()->format('d-M-Y');
                //     $history = new ProductionValidationTrail();
                //     $history->root_id = $id;
                //     $history->activity_type = 'Activity log';
                //     $history->previous = $lastData->acknowledge_by;
                //     $history->current = $data->acknowledge_by;
                //     $history->comment = $request->comment;
                //     $history->user_id = Auth::user()->id;
                //     $history->user_name = Auth::user()->name;
                //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                //     $history->origin_state = $lastData->status;
                //     // $history->origin_state = $data->status;
                //     $history->change_from =$lastData->status;
                //     $history->change_to ="Pending Scheduling & Sample";
                //     $history->action_name = "Not Applicable";
                //     $history->stage= "2";

                //    $history->action_name = "Submit";

                //     $history->save();


                $history = new ProductionValidationTrail();
                $history->root_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action = 'Submit';
                $history->previous = $lastData->acknowledge_by;
                $history->current = $data->acknowledge_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->stage = 'Submit';
                $history->change_to = 'Pending Scheduling & Sample';
                $history->change_from = $lastData->status;
                $history->action_name = 'Not Applicable';

                $history->save();


                //     $list = Helpers::getQAUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $data->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //              if ($email !== null) {


                //               Mail::send(
                //                   'mail.view-mail',
                //                    ['data' => $data],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document sent ".Auth::user()->name);
                //                 }
                //               );
                //             }
                //      }
                //   }
                $data->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($data->stage == 2) {
                $data->stage = "3";
                $data->status = 'Pending Samples Validation';

                $data->Schedule_Send_Sample_by = Auth::user()->name;
                $data->Schedule_Send_Sample_on = Carbon::now()->format('d-M-Y');



                $history = new ProductionValidationTrail();
                $history->root_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action = 'Submit';
                $history->previous = $lastData->Schedule_Send_Sample_by;
                $history->current = $data->Schedule_Send_Sample_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->stage = 'Submit';
                $history->change_to = 'Pending Samples Validation';
                $history->change_from = $lastData->status;
                $history->action_name = 'Not Applicable';

                $history->save();
                //     $list = Helpers::getQAUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $root->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //              if ($email !== null) {


                //               Mail::send(
                //                   'mail.view-mail',
                //                    ['data' => $root],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document sent ".Auth::user()->name);
                //                 }
                //               );
                //             }
                //      }
                //   }
                $data->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($data->stage == 3) {
                $data->stage = "4";
                $data->status = "Product Recalled";
                $data->acknowledge_by = Auth::user()->name;
                $data->acknowledge_on = Carbon::now()->format('d-M-Y');

                $history = new ProductionValidationTrail();
                $history->root_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action = 'Submit';
                $history->previous = $lastData->acknowledge_by;
                $history->current = $data->acknowledge_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to = 'Product Recalled';
                $history->change_from = $lastData->status;
                $history->action_name = 'Not Applicable';
                   $history->stage= "Submit";

                    $history->save();
            //     //     $list = Helpers::getQAUserList();
            //     //     foreach ($list as $u) {
            //     //         if($u->q_m_s_divisions_id == $root->division_id){
            //     //             $email = Helpers::getInitiatorEmail($u->user_id);
            //     //              if ($email !== null) {


            //     //               Mail::send(
            //     //                   'mail.view-mail',
            //     //                    ['data' => $root],
            //     //                 function ($message) use ($email) {
            //     //                     $message->to($email)
            //     //                         ->subject("Document sent ".Auth::user()->name);
            //     //                 }
            //     //               );
            //     //             }
            //     //      }
            //     //    }
                $data->update();
                toastr()->success('Document Sent');
                return back();
            }
             if ($data->stage == 4) {
                 $data->stage = "7";
                 $data->status = 'Closed - Recalled';
                 $data->acknowledge_by = Auth::user()->name;
                 $data->acknowledge_on = Carbon::now()->format('d-M-Y');
                 $history = new ProductionValidationTrail();
                $history->root_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action = 'Submit';
                $history->previous = $lastData->acknowledge_by;
                $history->current = $data->acknowledge_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to = 'Closed - Recalled';
                $history->change_from = $lastData->status;
                $history->action_name = 'Not Applicable';
                   $history->stage= "Submit";

                 $history->save();
                // $history->stage='Submit';
            //     $list = Helpers::getQAUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $root->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //              if ($email !== null) {


            //               Mail::send(
            //                   'mail.view-mail',
            //                    ['data' => $root],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document sent ".Auth::user()->name);
            //                 }
            //               );
            //             }
            //      }
            //   }
            $data->update();
            toastr()->success('Document Sent');
            return back();

            if ($data->stage == 5) {
                $data->stage = "6";
                $data->status = "QA Approve Review";
                $data->qA_review_complete_by = Auth::user()->name;
                // $data->qA_review_complete_on = Carbon::now()->format('d-M-Y');
                $history = new ProductionValidationTrail();
                $history->root_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action = 'Submit';
                $history->previous = $lastData->acknowledge_by;
                $history->current = $data->acknowledge_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to = 'QA Approve Review';
                $history->change_from = $lastData->status;
                $history->action_name = 'Not Applicable';
                   $history->stage= "Submit";

                $history->save();
            //     $list = Helpers::getQAUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $root->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //              if ($email !== null) {


            //               Mail::send(
            //                   'mail.view-mail',
            //                    ['data' => $root],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document sent ".Auth::user()->name);
            //                 }
            //               );
            //             }
            //      }
            //  }

          $data->update();
            toastr()->success('Document Sent');
         return back();
       }

        $history->origin_state = $lastData->status;
                $history->stage='';
                $history->save();
            //     $list = Helpers::getQAUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $data->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //              if ($email !== null) {


            //               Mail::send(
            //                   'mail.view-mail',
            //                    ['data' => $root],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document sent ".Auth::user()->name);
            //                 }
            //               );
            //             }
            //      }
            //   }
                $root->update();
                toastr()->success('Document Sent');
                return back();
            }
}
    }






        public function ProductionValidationfollowUpdate(Request $request, $id)
        {
            $currentDate = Carbon::now();
            $formattedDate = $currentDate->addDays(30);
            $due_date = $formattedDate->format('Y-m-d');

            $lastData =  Product_Validation::find($id);
            $data =  Product_Validation::find($id);
            $data->initiator_id = Auth::user()->id;


            $data->division_id = $request->division_id;

            // $data->stage = $request->stage;
            // $data->status = $request->status;
            $data->acknowledge_by = $request->acknowledge_by;
            $data->acknowledge_on = $request->acknowledge_on;

          //  $data->record_number = $request->record_number;
            $data->date_of_initiation = $request->date_of_initiation;
            $data->product = $request->product;
            $data->assign_to = $request->assign_to;
            $data->due_date = $request->due_date;


// dd($data->due_date);

            $data->short_description = $request->short_description;
            $data->product_type = $request->product_type;
            $data->priority_level = $request->priority_level;
            // $data->file_attachment_gi = $request->file_attachment_gi;
            $data->discription = $request->discription;
            $data->comments = $request->comments;
            $data->file_attachment = $request->file_attachment;
            $data->related_url = $request->related_url;
            $data->related_record = $request->related_record;
//===========================================================================Validation Information Update============================================================================

$data->start_date = $request->start_date;
$data->sample_details = $request->sample_details;
$data->validation_summary = $request->validation_summary;
$data->externail_lab = $request->externail_lab;
$data->lab_commnets = $request->lab_commnets;
$data->product_release = $request->product_release;
$data->product_recelldetails = $request->product_recelldetails;



            // if ($request->hasfile('attach_files1')) {
            //     $image = $request->file('attach_files1');
            //     $ext = $image->getClientOriginalExtension();
            //     $image_name = date('y-m-d') . '-' . rand() . '.' . $ext;
            //     $image->move('upload/document/', $image_name);
            //     $data->attach_files1 = $image_name;
            // }


            if (!empty($request->attachment)) {
                $files = [];
                if ($request->hasfile('attachment')) {
                    foreach ($request->file('attachment') as $file) {
                        $name = $request->name . 'attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $data->attachment = json_encode($files);
            }

            if (!empty($request->attach_files1)) {
                $files = [];
                if ($request->hasfile('attach_files1')) {
                    foreach ($request->file('attach_files1') as $file) {
                        $name = $request->name . 'attach_files1' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }

                $data->attach_files1 = json_encode($files);
            }

            if ($request->hasfile('inv_attachment')) {
                $files = [];
                foreach ($request->file('inv_attachment') as $file) {
                    $name = $request->name . 'inv_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload'), $name);
                    $files[] = $name;
                }
                $data->inv_attachment = json_encode($files);
            }
            // // $data->recomendation_capa_date_due = $request->recomendation_capa_date_due;
            // // $data->non_compliance = $request->non_compliance;
            // // $data->recommend_action = $request->recommend_action;
            // // $data->date_Response_due2 = $request->date_Response_due2;
            // // $data->capa_date_due = $request->capa_date_due11;
            // // $data->assign_to2 = $request->assign_to2;
            // // $data->cro_vendor = $request->cro_vendor;
            // // $data->comments = $request->comments;
            // // $data->impact = $request->impact;
            // // $data->impact_analysis = $request->impact_analysis;
            // // $data->severity_rate = $request->severity_rate;
            // // $data->occurrence = $request->occurrence;
            // // $data->detection = $request->detection;
            // // $data->analysisRPN = $request->analysisRPN;
            // // $data->actual_start_date = $request->actual_start_date;
            // // $data->actual_end_date = $request->actual_end_date;
            // // $data->action_taken = $request->action_taken;

            // //  $data->date_response_due1 = $request->date_Response_due22;
            // // // $data->date_response_due1 = $request->date_response_due1;
            // // $data->response_date = $request->response_date;
            // // // $data->attach_files2 = $request->attach_files2;
            // // $data->related_url = $request->related_url;
            // // $data->response_summary = $request->response_summary;

            // // // if ($request->hasfile('related_observations')) {
            // // //     $image = $request->file('related_observations');
            // // //     $ext = $image->getClientOriginalExtension();
            // // //     $image_name = date('y-m-d') . '-' . rand() . '.' . $ext;
            // // //     $image->move('upload/document/', $image_name);
            // // //     $data->related_observations = $image_name;
            // // // }
            // // if (!empty($request->related_observations)) {
            // //     $files = [];
            // //     if ($request->hasfile('related_observations')) {
            // //         foreach ($request->file('related_observations') as $file) {
            // //             $name = $request->name . 'related_observations' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
            // //             $file->move('upload/', $name);
            // //             $files[] = $name;
            // //         }
            // //     }

            // //     $data->related_observations = json_encode($files);
            // // }
            // // // if ($request->hasfile('attach_files2')) {
            // // //     $image = $request->file('attach_files2');
            // // //     $ext = $image->getClientOriginalExtension();
            // // //     $image_name = date('y-m-d') . '-' . rand() . '.' . $ext;
            // // //     $image->move('upload/document/', $image_name);
            // // //     $data->attach_files2 = $image_name;
            // // // }
            // // if (!empty($request->attach_files2)) {
            // //     $files = [];
            // //     if ($request->hasfile('attach_files2')) {
            // //         foreach ($request->file('attach_files2') as $file) {
            // //             $name = $request->name . 'attach_files2' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
            // //             $file->move('upload/', $name);
            // //             $files[] = $name;
            // //         }
            // //     }

            // //     $data->attach_files2 = json_encode($files);
            // // }

            // dd($data);
            $data->update();
            // if ($lastData->division_id != $data->initiated_by || !empty ($request->comment)) {
            //     // return 'history';
            //     $history = new ProductionValidationTrail;
            //     $history->root_id = $id;
            //     $history->activity_type = 'Division id';
            //     $history->previous = $lastData->division_id;
            //     $history->current = $data->division_id;
            //     $history->comment = $request->comment;
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = $lastData->status;
            //     $history->change_to =   "Not Applicable";
            //     $history->change_from = $lastData->status;
            //     $history->action_name = 'Update';
            //     $history->save();
            //  }

           if ($lastData->short_description != $data->short_description || ! empty($request->short_description_comment)) {
            $lastDataAudittrail  = ProductionValidationTrail::where('root_id', $data->id)
                ->where('activity_type', 'Short Description')
                ->exists();
                // return 'history';
                $history = new ProductionValidationTrail;
                $history->root_id= $id;
                $history->activity_type = 'Short Description';
                $history->previous = $lastData->short_description;
                $history->current = $data->short_description;
                $history->comment = $request->short_description_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to = 'Not Applicable';
                $history->change_from = $lastData->status;
                $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
                // $history->action = 'Submit';

                $history->save();
             }


                if ($lastData->department_code != $data->department_code || ! empty($request->department_code_comment)) {
                    $lastDataAudittrail = ProductionValidationTrail::where('root_id', $data->id)
                        ->where('activity_type', 'Department Code')
                        ->exists();
                // return 'history';
                $history = new ProductionValidationTrail;
                $history->root_id = $id;
                $history->activity_type = 'Department Code';
                $history->previous = $lastData->department_code;
                $history->current = $data->department_code;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to =   "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name =  $lastDataAudittrail ? 'Update' : 'New';
                $history->save();
             }


            //     if ($lastData->initiator_id != $data->initiator_id || ! empty($request->initiator_id_comment)) {
            //         $lastData = ProductionValidationTrail::where('root_id', $data->id)
            //             ->where('activity_type', 'Initiator Id ')
            //             ->exists();
            //     // return 'history';
            //     $history = new ProductionValidationTrail;
            //     $history->root_id = $id;
            //     $history->activity_type = 'Initiator';
            //     $history->previous = $lastData->initiator_id;
            //     $history->current = $data->initiator_id;
            //     $history->comment = $request->comment;
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = $lastData->status;
            //     $history->change_to =   "Not Applicable";
            //     $history->change_from = $lastData->status;
            //     $history->action_name = $lastData ? 'Update' : 'New';
            //     $history->save();
            //  }


            //     if ($lastData->short_description != $data->short_description || ! empty($request->short_description_comment)) {
            //         $lastDataAudittrail = ProductionValidationTrail::where('root_id', $data->id)
            //             ->where('activity_type', ' Short Description ')
            //             ->exists();
            //     // return 'history';
            //     $history = new ProductionValidationTrail;
            //     $history->root_id = $id;
            //     $history->activity_type = ' Short Description';
            //     $history->previous = $lastData->short_description;
            //     $history->current = $data->short_description;
            //     $history->comment = $request->comment;
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = $lastData->status;
            //     $history->change_to =   "Not Applicable";
            //     $history->change_from = $lastData->status;
            //     $history->action_name =$lastDataAudittrail  ? 'Update' : 'New';
            //     $history->save();
            //  }


                if ($lastData->product != $data->product || ! empty($request->product_comment)) {
                    $lastDataAudittrail = ProductionValidationTrail::where('root_id', $data->id)
                        ->where('activity_type', 'Product ')
                        ->exists();
                // return 'history';
                $history = new ProductionValidationTrail;
                $history->root_id = $id;
                $history->activity_type = 'Product';
                $history->previous = $lastData->product;
                $history->current = $data->product;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to =   "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name =  $lastDataAudittrail ? 'Update' : 'New';
                $history->save();
             }



             if ($lastData->assign_to != $data->assign_to || ! empty($request->comment)) {
                $lastDataAudittrail = ProductionValidationTrail::where('root_id', $data->id)
                    ->where('activity_type', 'Assign To ')
                    ->exists();
            // return 'history';
            $history = new ProductionValidationTrail;
            $history->root_id = $id;
            $history->activity_type = 'Assign To';
            $history->previous = $lastData->assign_to;
            $history->current = $data->assign_to;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name =  $lastDataAudittrail ? 'Update' : 'New';
            $history->save();
         }

            //     if ($lastData->assign_to != $data->assign_to || ! empty($request->comment)) {
            //         $lastData = ProductionValidationTrail::where('root_id', $data->id)
            //             ->where('activity_type', 'Assign To ')
            //             ->exists();
            //     // return 'history';
            //     $history = new ProductionValidationTrail;
            //     $history->root_id = $id;
            //     $history->activity_type = 'Assign To';
            //     $history->previous = $lastData->assign_to;
            //     $history->current = $data->assign_to;
            //     $history->comment = $request->comment;
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = $lastData->status;
            //     $history->change_to =   "Not Applicable";
            //     $history->change_from = $lastData->status;
            //     $history->action_name = $lastData ? 'Update' : 'New';
            //     $history->save();
            //  }



                if ($lastData->due_date != $data->due_date || ! empty($request->due_date_comment)) {
                    $lastDataAudittrail = ProductionValidationTrail::where('root_id', $data->id)
                        ->where('activity_type', 'Due Date ')
                        ->exists();
                // return 'history';
                $history = new ProductionValidationTrail;
                $history->root_id = $id;
                $history->activity_type = 'Due Date';
                $history->previous = $lastData->due_date;
                $history->current = $data->due_date;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to =   "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name = $lastDataAudittrail ? 'Update' : 'New';
                $history->save();
             }


                if ($lastData->product_type != $data->product_type || ! empty($request->product_type_comment)) {
                    $lastDataAudittrail = ProductionValidationTrail::where('root_id', $data->id)
                        ->where('activity_type', 'Type of Product ')
                        ->exists();
                // return 'history';
                $history = new ProductionValidationTrail;
                $history->root_id = $id;
                $history->activity_type = 'Type Of Product';
                $history->previous = $lastData->product_type;
                $history->current = $data->product_type;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to =   "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name =  $lastDataAudittrail ? 'Update' : 'New';
                $history->save();
             }

                // return 'history';
                if ($lastData->priority_level != $data->priority_level || ! empty($request->priority_level_comment)) {
                    $lastDataAudittrail = ProductionValidationTrail::where('root_id', $data->id)
                        ->where('activity_type', 'Priority Level ')
                        ->exists();
                $history = new ProductionValidationTrail;
                $history->root_id = $id;
                $history->activity_type = 'Priority Level';
                $history->previous = $lastData->priority_level;
                $history->current = $data->priority_level;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to =   "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name =  $lastDataAudittrail ? 'Update' : 'New';
                $history->save();
             }


                if ($lastData->comments != $data->comments || ! empty($request->comments)) {
                    $lastDataAudittrail = ProductionValidationTrail::where('root_id', $data->id)
                        ->where('activity_type', 'Comments ')
                        ->exists();
                // return 'history';
                $history = new ProductionValidationTrail;
                $history->root_id = $id;
                $history->activity_type = 'Comments';
                $history->previous = $lastData->comments;
                $history->current = $data->comments;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to =   "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name =  $lastDataAudittrail ? 'Update' : 'New';
                $history->save();
             }



                if ($lastData->schedule_start_date != $data->schedule_start_date || ! empty($request->schedule_start_date)) {
                    $lastDataAudittrail = ProductionValidationTrail::where('root_id', $data->id)
                        ->where('activity_type', 'Scheduled Start Date')
                        ->exists();
                // return 'history';
                $history = new ProductionValidationTrail;
                $history->root_id = $id;
                $history->activity_type = 'Scheduled Start Date';
                $history->previous = $lastData->schedule_start_date;
                $history->current = $data->schedule_start_date;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to =   "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name =  $lastDataAudittrail ? 'Update' : 'New';
                $history->save();
            }



                if ($lastData->schedule_end_date  != $data->schedule_end_date  || ! empty($request->schedule_end_date )) {
                    $lastDataAudittrail = ProductionValidationTrail::where('root_id', $data->id)
                        ->where('activity_type', 'Scheduled End Date ')
                        ->exists();
                // return 'history';
                $history = new ProductionValidationTrail;
                $history->root_id = $id;
                $history->activity_type = 'Scheduled End Date';
                $history->previous = $lastData->schedule_end_date;
                $history->current = $data->schedule_end_date;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to =   "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name =  $lastDataAudittrail ? 'Update' : 'New';
                $history->save();
            }



                if ($lastData->file_attachment != $data->file_attachment || ! empty($request->file_attachment)) {
                    $lastDataAudittrail = ProductionValidationTrail::where('root_id', $data->id)
                        ->where('activity_type', 'HOD Attachments ')
                        ->exists();

                $history = new ProductionValidationTrail;
                $history->root_id = $id;
                $history->activity_type = 'HOD Attachments';
                $history->previous = $lastData->file_attachment;
                $history->current = $data->file_attachment;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to = "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name =  $lastDataAudittrail ? 'Update' : 'New';
                $history->save();
            }





            if ($lastData->related_url != $data->related_url || ! empty($request->related_url)) {
                $lastDataAudittrail = ProductionValidationTrail::where('root_id', $data->id)
                    ->where('activity_type', 'Related URLs ')
                    ->exists();
                // return 'history';
                $history = new ProductionValidationTrail;
                $history->root_id = $id;
                $history->activity_type = 'Related URLs';
                $history->previous = $lastData->related_url;
                $history->current = $data->related_url;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to =   "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name =  $lastDataAudittrail ? 'Update' : 'New';
                $history->save();
            }


            if (!empty($request->related_record) && $lastData->related_record != $request->related_record) {
                $lastDataAudittrail = ProductionValidationTrail::where('root_id', $data->id)
                    ->where('activity_type', 'Related Record')
                    ->exists();

                $history = new ProductionValidationTrail;
                $history->root_id = $id;
                $history->activity_type = 'Related Record';
                $history->previous = $lastData->related_record;
                $history->current = $request->related_record;
                $history->comment = $request->comment ?? ''; // Use null coalescing operator to handle empty comments
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to = "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name = $lastDataAudittrail ? 'Update' : 'New';
                $history->save();
            }


                if ($lastData->Remarks != $data->Remarks || ! empty($request->Remarks)) {
                    $lastDataAudittrail = ProductionValidationTrail::where('root_id', $data->id)
                        ->where('activity_type', 'Remarks ')
                        ->exists();
                // return 'history';
                $history = new ProductionValidationTrail;
                $history->root_id = $id;
                $history->activity_type = 'Remarks';
                $history->previous = $lastData->quality_follow_up_summary;
                $history->current = $data->quality_follow_up_summary;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to =   "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name =  $lastDataAudittrail ? 'Update' : 'New';
                $history->save();
             }

            toastr()->success("First Production Validation Updated succusfully");
             return back();
        }


        public function ProductionAuditTrialDetails($id)
        {

            $audit = ProductionValidationTrail::where('root_id', $id)->orderByDESC('id')->paginate(5);
         //  dd($audit);
            $today = Carbon::now()->format('d-m-y');
            $document = Product_Validation::where('id', $id)->first();
            $document->originator = User::where('id', $document->initiator_id)->value('name');

            return view('frontend.ProductionValidation.AuditTrail', compact('audit', 'document', 'today'));
        }



        public function singleReports(Request $request, $id){

            $data = Product_Validation::find($id);
            // $data = QualityFollowup::where(['id' => $id, 'identifier' => 'details'])->first();
            if (!empty($data)) {
                // $data->data = Product_Validation::where('id', $id)->where('identifier', "details")->first();
                // $data->Instruments_Details = ErrataGrid::where('e_id', $id)->where('type', "Instruments_Details")->first();
                // $data->Material_Details = Erratagrid::where('e_id', $id)->where('type', "Material_Details")->first();
                // dd($data->all());
                $data->originator = User::where('id', $data->initiator_id)->value('name');
                $pdf = App::make('dompdf.wrapper');
                $time = Carbon::now();
                $pdf = PDF::loadview('frontend.ProductionValidation.singleReport', compact('data'))
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
                return $pdf->stream('errata' . $id . '.pdf');
            }
        }



        public function auditTrailPdf($id){
            $doc =Product_Validation::find($id);
            $doc->originator = User::where('id', $doc->initiator_id)->value('name');
            $audit = ProductionValidationTrail::Where('root_id',$id)->orderByDesc('id')->get();
            $data = ProductionValidationTrail::where('root_id', $doc->id)->orderByDesc('id')->get();
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.ProductionValidation.AuditTrail_pdf', compact('data', 'doc','audit'))
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




