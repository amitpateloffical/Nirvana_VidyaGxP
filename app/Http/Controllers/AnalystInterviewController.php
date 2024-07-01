<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AnalystInterview;
use App\Models\AnalystInterviewAuditTrail;
use App\Models\AnalystInterviewGrid;
use Illuminate\Http\Request;
use App\Models\RecordNumber;
use App\Models\RoleGroup;
use App\Models\User;
use Carbon\Carbon;
use Helpers;
use PDF;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;


class AnalystInterviewController extends Controller
{

          public function store(Request $request)
    {
        if (!$request->short_description) {
            toastr()->error("Short description is required");
            return response()->redirect()->back()->withInput();
        }


        $analystinterview = new AnalystInterview();
        $analystinterview->form_type = "Analyst Interview";
        $analystinterview->record = ((RecordNumber::first()->value('counter')) + 1);
        $analystinterview->initiator_id= Auth::user()->id;

        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();

        $analystinterview->root_parent_oos_number = $request->root_parent_oos_number;
        $analystinterview->root_parent_oot_number = $request->root_parent_oot_number;
        $analystinterview->parent_date_opened = $request->parent_date_opened;
        $analystinterview->parent_short_description = $request->parent_short_description;
        $analystinterview->parent_target_closure_date = $request->parent_target_closure_date;
        $analystinterview->parent_product_mat_name = $request->parent_product_mat_name;
        $analystinterview->parent_analyst_name = $request->parent_analyst_name;

        $analystinterview->record = $request->record;
        $analystinterview->division_id =  7;

        $analystinterview->division_code = $request->division_code;
        $analystinterview->initiator_id = $request->initiator_id;
        $analystinterview->intiation_date = $request->intiation_date;
        $analystinterview->target_closure_date_gi = $request->target_closure_date_gi;
        $analystinterview->short_description = $request->short_description;
        $analystinterview->assignee = $request->assignee;

        $analystinterview->record_number = $request->record_number;
        $analystinterview->description = $request->description;

        // Tab 2
        $analystinterview->analyst_qualification_date = $request->analyst_qualification_date;
        $analystinterview->interviewer_assessment = $request->interviewer_assessment;
        $analystinterview->recommendations = $request->recommendations;
        $analystinterview->delay_justification = $request->delay_justification;
        $analystinterview->any_other_comments = $request->any_other_comments;

        $analystinterview->form_type = $request->form_type;
        $analystinterview->status = $request->status;
        $analystinterview->stage = $request->stage;

        if (!empty ($request->file_attchment_if_any)) {
            $files = [];
            if ($request->hasfile('file_attchment_if_any')) {
                foreach ($request->file('file_attchment_if_any') as $file) {
                    $name = $request->name . 'file_attchment_if_any' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $analystinterview->file_attchment_if_any = json_encode($files);
        }

        $analystinterview->status = 'Opened';
        $analystinterview->stage = 1;

        $analystinterview->save();

        // Verification grid 1------------------------------

        $grid_data = $analystinterview->id;
        $info_product_material = AnalystInterviewGrid::where(['analystinterview_id'=>$grid_data,'identifier'=>'parent info product material'])->firstOrNew();
        $info_product_material->analystinterview_id = $grid_data;
        $info_product_material->identifier = 'Parent Info on Product Material1';
        $info_product_material->data = $request->parent_info_on_product_material1;
        $info_product_material->save();
        // $grid_data = $verification->id;
        // $info_product_material2 = VerificationGrid::where(['analystinterview_id'=>$grid_data,'identifier'=>'parent info product material2'])->firstOrNew();
        // $info_product_material2->analystinterview_id = $grid_data;
        // $info_product_material2->identifier = 'Parent Info on Product Material2';
        // $info_product_material2->data = $request->parent_info_no_product_material1;
        // $info_product_material2->save();

         //  grid 2-----------------------------

         $grid_data1 = $analystinterview->id;
         $oos_details = AnalystInterviewGrid::where(['analystinterview_id'=>$grid_data1,'identifier'=>'parent oos detail'])->firstOrNew();
         $oos_details->analystinterview_id = $grid_data1;
         $oos_details->identifier = 'Parent OOS Details';
         $oos_details->data = $request->root_parent_oos_details;
         $oos_details->save();

        // grid 3

        $grid_data2 = $analystinterview->id;
        $oot_results = AnalystInterviewGrid::where(['analystinterview_id'=>$grid_data2,'identifier'=>'parent oot result'])->firstOrNew();
        $oot_results->analystinterview_id = $grid_data2;
        $oot_results->identifier = 'Parent OOT Results';
        $oot_results->data = $request->parent_oot_results;
        $oot_results->save();

        //grid 4

        $grid_data3 = $analystinterview->id;
        $parent_stability_study = AnalystInterviewGrid::where(['analystinterview_id'=>$grid_data3,'identifier'=>'parent stability study'])->firstOrNew();
        $parent_stability_study->analystinterview_id = $grid_data3;
        $parent_stability_study->identifier = 'Parent Stability Study';
        $parent_stability_study->data = $request->parent_details_of_stability_study;
        $parent_stability_study->save();

           //Question 1

           $grid_data4 = $analystinterview->id;
           $precautionary_me = AnalystInterviewGrid::where(['analystinterview_id'=>$grid_data4,'identifier'=>'precautionary measures'])->firstOrNew();
           $precautionary_me->analystinterview_id = $grid_data4;
           $precautionary_me->identifier = 'Precautionary Measures';
           $precautionary_me->data = $request->precautionary_measures;
           $precautionary_me->save();

            //Question 2

            $grid_data5 = $analystinterview->id;
            $mpp = AnalystInterviewGrid::where(['analystinterview_id'=>$grid_data5,'identifier'=>'mobile phase preparation'])->firstOrNew();
            $mpp->analystinterview_id = $grid_data5;
            $mpp->identifier = 'Mobile Phase Preparation';
            $mpp->data = $request->mobile_phase_preparation;
            $mpp->save();

             //Question 3

           $grid_data6 = $analystinterview->id;
           $rws = AnalystInterviewGrid::where(['analystinterview_id'=>$grid_data6,'identifier'=>'reference working standard'])->firstOrNew();
           $rws->analystinterview_id = $grid_data6;
           $rws->identifier = 'Reference Working Standards';
           $rws->data = $request->reference_working_standards;
           $rws->save();

            //Question 4

            $grid_data7 = $analystinterview->id;
            $hos = AnalystInterviewGrid::where(['analystinterview_id'=>$grid_data7,'identifier'=>'handling of samples'])->firstOrNew();
            $hos->analystinterview_id = $grid_data7;
            $hos->identifier = 'Handling of Samples';
            $hos->data = $request->handling_of_samples;
            $hos->save();

             //Question 5

           $grid_data8 = $analystinterview->id;
           $ish = AnalystInterviewGrid::where(['analystinterview_id'=>$grid_data8,'identifier'=>'instrument setup and handling'])->firstOrNew();
           $ish->analystinterview_id = $grid_data8;
           $ish->identifier = 'Instrument Setup & Handling';
           $ish->data = $request->instrument_setup_handling;
           $ish->save();

        // Audit Trail===========================================================

        if (!empty($analystinterview->short_description)) {
            $history = new AnalystInterviewAuditTrail();
            $history->analystinterview_id = $analystinterview->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Null";
            $history->current = $analystinterview->short_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;//dont know kaha se aayi ye id
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $analystinterview->status;
            $history->action_name = 'Submit';
            $history->save();
            }

        $combinedfields = [

        'root_parent_oos_number'=>'(Parent) OOS No',
        'root_parent_oot_number'=>'(Parent) OOT No.',
        'parent_date_opened'=>'(Parent)Date Opened',
        'parent_short_description'=>'(Parent) Short Description',
        'parent_target_closure_date'=>'(Parent) Target Closure Date',
        'parent_product_mat_name'=>'(Parent) Product/Material Name',
        'parent_analyst_name'=>'(Parent) Analyst Name',
        'record'=>'Record Number',
        'division_code'=>'Site/Location Code',
        'initiator_id'=>'Initiator ',
        'intiation_date'=>'Initiation Date',
        'target_closure_date_gi'=>'Target Closure Date',
        'assignee'=>'Assignee',
        'description'=>'Description',
        'analyst_qualification_date'=>'Analyst Qualification Date',
        'interviewer_assessment'=>'Interviewer Assessment',
        'recommendations'=>'Recommendations',
        'delay_justification'=>'Delay Justification',
        'any_other_comments'=>'Any Other Comments',

];
                    foreach ($combinedfields as $key => $value){
                if (!empty($analystinterview->$key)) {
                    $history = new AnalystInterviewAuditTrail();
                    $history->analystinterview_id = $analystinterview->id;
                    $history->activity_type = $value;
                    $history->previous = "Null";
                    $history->current = $analystinterview->$key;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $analystinterview->status;
                    $history->action_name = 'Submit';
                    $history->save();
                    }
                }

        toastr()->success("Record is created Successfully");
        return redirect(url('rcms/qms-dashboard'));
    }


    public function update(Request $request, $id)
    {
        // if (!$request->short_description) {
        //     toastr()->error("Short description is required");
        //     return redirect()->back();
        // }
        // $lastDeviation = deviation::find($id);
        //$deviation->parent_id = $request->parent_id;
        //$deviation->parent_type = $request->parent_type;
        //$deviation->division_id = $request->division_id;
        //$deviation->text = $request->text;

        $lastAnalystinterview = AnalystInterview::find($id);

        $analystinterview = AnalystInterview::find($id);
        $analystinterview->root_parent_oos_number = $request->root_parent_oos_number;
        $analystinterview->root_parent_oot_number = $request->root_parent_oot_number;
        $analystinterview->parent_date_opened = $request->parent_date_opened;
        $analystinterview->parent_short_description = $request->parent_short_description;
        $analystinterview->parent_target_closure_date = $request->parent_target_closure_date;
        $analystinterview->parent_product_mat_name = $request->parent_product_mat_name;
        $analystinterview->parent_analyst_name = $request->parent_analyst_name;

        $analystinterview->record = $request->record;
        $analystinterview->division_id =  7;

        $analystinterview->division_code = $request->division_code;
        $analystinterview->initiator_id = $request->initiator_id;
        $analystinterview->intiation_date = $request->intiation_date;
        $analystinterview->target_closure_date_gi = $request->target_closure_date_gi;
        $analystinterview->short_description = $request->short_description;
        $analystinterview->assignee = $request->assignee;

        $analystinterview->record_number = $request->record_number;
        $analystinterview->description = $request->description;

        // Tab 2
        $analystinterview->analyst_qualification_date = $request->analyst_qualification_date;
        $analystinterview->interviewer_assessment = $request->interviewer_assessment;
        $analystinterview->recommendations = $request->recommendations;
        $analystinterview->delay_justification = $request->delay_justification;
        $analystinterview->any_other_comments = $request->any_other_comments;

        $analystinterview->form_type = $request->form_type;
        $analystinterview->status = $request->status;
        $analystinterview->stage = $request->stage;

        if (!empty ($request->file_attchment_if_any)) {
            $files = [];
            if ($request->hasfile('file_attchment_if_any')) {
                foreach ($request->file('file_attchment_if_any') as $file) {
                    $name = $request->name . 'file_attchment_if_any' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $analystinterview->file_attchment_if_any = json_encode($files);
        }

        $analystinterview->status = 'Opened';
        $analystinterview->stage = 1;

// ------------------================Update Grid ================================//
//grid 1

                $grid_data = $analystinterview->id;
                $info_product_material = AnalystInterviewGrid::where(['analystinterview_id'=>$grid_data,'identifier'=>'parent info product material'])->firstOrNew();
                $info_product_material->analystinterview_id = $grid_data;
                $info_product_material->identifier = 'Parent Info on Product Material1';
                $info_product_material->data = $request->parent_info_on_product_material1;
                $info_product_material->save();
                // $grid_data = $verification->id;
                // $info_product_material2 = VerificationGrid::where(['analystinterview_id'=>$grid_data,'identifier'=>'parent info product material2'])->firstOrNew();
                // $info_product_material2->analystinterview_id = $grid_data;
                // $info_product_material2->identifier = 'Parent Info on Product Material2';
                // $info_product_material2->data = $request->parent_info_no_product_material1;
                // $info_product_material2->save();

                //  grid 2-----------------------------

                $grid_data1 = $analystinterview->id;
                $oos_details = AnalystInterviewGrid::where(['analystinterview_id'=>$grid_data1,'identifier'=>'parent oos detail'])->firstOrNew();
                $oos_details->analystinterview_id = $grid_data1;
                $oos_details->identifier = 'Parent OOS Details';
                $oos_details->data = $request->root_parent_oos_details;
                $oos_details->save();

                // grid 3

                $grid_data2 = $analystinterview->id;
                $oot_results = AnalystInterviewGrid::where(['analystinterview_id'=>$grid_data2,'identifier'=>'parent oot result'])->firstOrNew();
                $oot_results->analystinterview_id = $grid_data2;
                $oot_results->identifier = 'Parent OOT Results';
                $oot_results->data = $request->parent_oot_results;
                $oot_results->save();

                //grid 4

                $grid_data3 = $analystinterview->id;
                $parent_stability_study = AnalystInterviewGrid::where(['analystinterview_id'=>$grid_data3,'identifier'=>'parent stability study'])->firstOrNew();
                $parent_stability_study->analystinterview_id = $grid_data3;
                $parent_stability_study->identifier = 'Parent Stability Study';
                $parent_stability_study->data = $request->parent_details_of_stability_study;
                $parent_stability_study->save();

                //Question 1

                $grid_data4 = $analystinterview->id;
                $precautionary_me = AnalystInterviewGrid::where(['analystinterview_id'=>$grid_data4,'identifier'=>'precautionary measures'])->firstOrNew();
                $precautionary_me->analystinterview_id = $grid_data4;
                $precautionary_me->identifier = 'Precautionary Measures';
                $precautionary_me->data = $request->precautionary_measures;
                $precautionary_me->save();

                    //Question 2

                    $grid_data5 = $analystinterview->id;
                    $mpp = AnalystInterviewGrid::where(['analystinterview_id'=>$grid_data5,'identifier'=>'mobile phase preparation'])->firstOrNew();
                    $mpp->analystinterview_id = $grid_data5;
                    $mpp->identifier = 'Mobile Phase Preparation';
                    $mpp->data = $request->mobile_phase_preparation;
                    $mpp->save();

                    //Question 3

                $grid_data6 = $analystinterview->id;
                $rws = AnalystInterviewGrid::where(['analystinterview_id'=>$grid_data6,'identifier'=>'reference working standard'])->firstOrNew();
                $rws->analystinterview_id = $grid_data6;
                $rws->identifier = 'Reference Working Standards';
                $rws->data = $request->reference_working_standards;
                $rws->save();

                    //Question 4

                    $grid_data7 = $analystinterview->id;
                    $hos = AnalystInterviewGrid::where(['analystinterview_id'=>$grid_data7,'identifier'=>'handling of samples'])->firstOrNew();
                    $hos->analystinterview_id = $grid_data7;
                    $hos->identifier = 'Handling of Samples';
                    $hos->data = $request->handling_of_samples;
                    $hos->save();

                    //Question 5

                $grid_data8 = $analystinterview->id;
                $ish = AnalystInterviewGrid::where(['analystinterview_id'=>$grid_data8,'identifier'=>'instrument setup and handling'])->firstOrNew();
                $ish->analystinterview_id = $grid_data8;
                $ish->identifier = 'Instrument Setup & Handling';
                $ish->data = $request->instrument_setup_handling;
                $ish->save();

    $analystinterview->update();


    //================ Update of audit trail
    $combinedfields = [

        'root_parent_oos_number'=>'(Parent) OOS No',
        'root_parent_oot_number'=>'(Parent) OOT No.',
        'parent_date_opened'=>'(Parent)Date Opened',
        'parent_short_description'=>'(Parent) Short Description',
        'parent_target_closure_date'=>'(Parent) Target Closure Date',
        'parent_product_mat_name'=>'(Parent) Product/Material Name',
        'parent_analyst_name'=>'(Parent) Analyst Name',
        'record'=>'Record Number',
        'short_description'=>'Short Description',
        'division_code'=>'Site/Location Code',
        'initiator_id'=>'Initiator ',
        'intiation_date'=>'Initiation Date',
        'target_closure_date_gi'=>'Target Closure Date',
        'assignee'=>'Assignee',
        'description'=>'Description',
        'analyst_qualification_date'=>'Analyst Qualification Date',
        'interviewer_assessment'=>'Interviewer Assessment',
        'recommendations'=>'Recommendations',
        'delay_justification'=>'Delay Justification',
        'any_other_comments'=>'Any Other Comments',

];
    foreach ($combinedfields as $key => $value){
    if ($lastAnalystinterview->$key != $analystinterview->$key || !empty ($request->comment)) {
        // if (!empty($verification->$key)) {
            $history = new AnalystInterviewAuditTrail();
            $history->analystinterview_id = $id;
            $history->activity_type = $value;
            $history->previous = $lastAnalystinterview->$key;
               $history->change_to = "Not Applicable";
                $history->change_from = $lastAnalystinterview->status;
            $history->current = $analystinterview->$key;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastAnalystinterview->status;
            $history->action_name = 'Update';
            $history->save();
            // }
        }
    }

    toastr()->success('Record is Updated Successfully');
    return back();

}

    public function edit($id) {
    $analystinterview = AnalystInterview::findOrFail($id);

    $analystinterview = AnalystInterview::find($id);
    $analystinterview->record = str_pad($analystinterview->record, 4, '0', STR_PAD_LEFT);
    $old_record = AnalystInterview::select('id', 'division_id', 'record')->get();
    $analystinterview->assign_to_name = User::where('id', $analystinterview->assign_id)->value('name');
    $analystinterview->initiator_name = User::where('id', $analystinterview->initiator_id)->value('name');
    $pre = AnalystInterview::all();
    $divisionName = DB::table('q_m_s_divisions')->where('id', $analystinterview->division_id)->value('name');


    $gridDatas01 = AnalystInterviewGrid::where(['analystinterview_id'=> $id,'identifier'=>'Parent Info on Product Material1'])->first();
    $gridDatas02 = AnalystInterviewGrid::where(['analystinterview_id'=> $id,'identifier'=>'Parent OOS Details'])->first();
    $gridDatas03 = AnalystInterviewGrid::where(['analystinterview_id'=> $id,'identifier'=>'Parent OOT Results'])->first();
    $gridDatas04 = AnalystInterviewGrid::where(['analystinterview_id'=> $id,'identifier'=>'Parent Stability Study'])->first();
    $gridDatas05 = AnalystInterviewGrid::where(['analystinterview_id'=> $id,'identifier'=>'Precautionary Measures'])->first();
    $gridDatas06 = AnalystInterviewGrid::where(['analystinterview_id'=> $id,'identifier'=>'Mobile Phase Preparation'])->first();
    $gridDatas07 = AnalystInterviewGrid::where(['analystinterview_id'=> $id,'identifier'=>'Reference Working Standards'])->first();
    $gridDatas08 = AnalystInterviewGrid::where(['analystinterview_id'=> $id,'identifier'=>'Handling of Samples'])->first();
    $gridDatas09 = AnalystInterviewGrid::where(['analystinterview_id'=> $id,'identifier'=>'Instrument Setup & Handling'])->first();


    return view('analystInterview.analystInterview_view', compact('analystinterview', 'gridDatas01', 'gridDatas02', 'gridDatas03', 'gridDatas04', 'gridDatas05', 'gridDatas06', 'gridDatas07', 'gridDatas08', 'gridDatas09','divisionName','old_record','pre'));
}


public function send_stage(Request $request, $id)
{
    if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
        $changestage = AnalystInterview::find($id);
        $lastDocument = AnalystInterview::find($id);
        if ($changestage->stage == 1) {
            $changestage->stage = "2";
            $changestage->status = "Interview Under Progress";
            $changestage->interview_under_progress_done_by = Auth::user()->name;
            $changestage->interview_under_progress_done_on = Carbon::now()->format('d-M-Y');
            $changestage->comment_interview_under_progress_done = $request->comment;
                            $history = new AnalystInterviewAuditTrail();
                            $history->analystinterview_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->action = 'Submit';
                            $history->current = $changestage->interview_under_progress_done_by;
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = $lastDocument->status;
                            $history->change_from = $lastDocument->status;
                            $history->change_to = "Interview Under Progress";

                            $history->stage = "2";
                            $history->save();
                            $list = Helpers::getLeadAuditeeUserList();
                            foreach ($list as $u) {
                                if($u->q_m_s_divisions_id == $changestage->division_id){
                                    $email = Helpers::getInitiatorEmail($u->user_id);
                                     if ($email !== null) {

                                      Mail::send(
                                          'mail.view-mail',
                                           ['data' => $changestage],
                                        function ($message) use ($email) {
                                            $message->to($email)
                                                ->subject("Document sent ".Auth::user()->name);
                                        }
                                      );
                                    }
                             }
                          }
            $changestage->update();
            toastr()->success('Document Sent');
            return back();
        }

        if ($changestage->stage == 2) {
            $changestage->stage = "3";
            $changestage->status = "Close-Done";
            $changestage->canceled_by= Auth::user()->name;
            $changestage->canceled_on = Carbon::now()->format('d-M-Y');
            $changestage->comment_canceled = $request->comment;

            $history = new AnalystInterviewAuditTrail();
            $history->analystinterview_id = $id;
            $history->activity_type = 'Activity Log';
            $history->action = 'Interview Complete';//button name which is sending to next stage
            $history->current = $changestage->canceled_by;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Close-Done";
            $history->change_from = $lastDocument->status;
            $history->stage = "Close-Done";
            $history->save();
            $changestage->update();
            toastr()->success('Document Sent');
            return back();
        }
    } else {
        toastr()->error('E-signature Not match');
        return back();
    }
}
// ========== requestmoreinfo_back_stage ==============
public function requestmoreinfo_back_stage(Request $request, $id)
{

    if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
        $changestage = AnalystInterview::find($id);
        $lastDocument = AnalystInterview::find($id);
        if ($changestage->stage == 2) {
            $changestage->stage = "1";
            $changestage->status = "Open";
            $changestage->submitted_by = Auth::user()->name;
            $changestage->submitted_on = Carbon::now()->format('d-M-Y');
            $changestage->comment_submitted = $request->comment;
            // $changestage->completed_by_opened = Auth::user()->name;
            // $changestage->completed_on_opened = Carbon::now()->format('d-M-Y');
            // $changestage->comment_opened = $request->comment;
                        $history = new AnalystInterviewAuditTrail();
                        $history->analystinterview_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->action = 'More Info From Open';
                        $history->current = $changestage->submitted_by;
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;

                        $history->change_from = $lastDocument->status;
                        $history->change_to = "Open";

                        $history->stage = "1";
                        $history->save();
            $changestage->update();
            toastr()->success('Document Sent');
            return back();
        }

    } else {
        toastr()->error('E-signature Not match');
        return back();
    }
}



public function cancel_stage(Request $request, $id)
{
    if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
        $data = AnalystInterview::find($id);
        $lastDocument = AnalystInterview::find($id);
        $data->stage = "0";
        $data->status = "Closed-Cancelled";
        $data->canceled_by = Auth::user()->name;
        $data->canceled_on = Carbon::now()->format('d-M-Y');
        $data->comment_canceled = $request->comment;

                $history = new AnalystInterviewAuditTrail();
                $history->analystinterview_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous ="";
                $history->action = 'Cancel';

                $history->current = $data->canceled_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state =  $data->status;
                $history->change_from = $lastDocument->status;
                $history->change_to = "Closed-Cancelled";

                $history->stage = 'Cancelled';
                $history->save();
        $data->update();
        toastr()->success('Document Sent');
        return back();
    } else {
        toastr()->error('E-signature Not match');
        return back();
    }
}

public function AuditTrial($id)
{
    $audit = AnalystInterviewAuditTrail::where('analystinterview_id', $id)->orderByDesc('id')->paginate(5);
    $today = Carbon::now()->format('d-m-y');
    $document = AnalystInterview::where('id', $id)->first();
    $document->initiator = User::where('id', $document->initiator_id)->value('name');
    return view('analystInterview.analystInterview_Audit_Trail', compact('audit', 'document', 'today'));
}

public function store_audit_review(Request $request, $id)
{
        $history = new audit_reviewers_detail();
        $history->analystinterview_id = $id;
        $history->user_id = Auth::user()->id;
        $history->type = $request->type;
        $history->reviewer_comment = $request->reviewer_comment;
        $history->reviewer_comment_by = Auth::user()->name;
        $history->reviewer_comment_on = Carbon::now()->toDateString();
        $history->save();

    return redirect()->back();
}
public function auditDetails($id)
{

    $detail = AnalystInterviewAuditTrail::find($id);

    $detail_data = AnalystInterviewAuditTrail::where('activity_type', $detail->activity_type)->where('analystinterview_id', $detail->id)->latest()->get();

    $doc = AnalystInterview::where('id', $detail->analystinterview_id)->first();


    $doc->origiator_name = User::find($doc->initiator_id);

    return view('analystInterview.analystInterview_InnerAudit', compact('detail', 'doc', 'detail_data'));
}

    public static function auditReport($id)
  {
    $doc = AnalystInterview::find($id);
    if (!empty($doc)) {
        $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        $data = AnalystInterviewAuditTrail::where('analystinterview_id', $id)->get();
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('analystInterview.analystInterview_AuditReport', compact('data', 'doc'))
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
        return $pdf->stream('Verification-Audit' . $id . '.pdf');
    }
}

public static function singleReport($id)
{
    $data = AnalystInterview::find($id);
    $analystinterview = AnalystInterview::findOrFail($id);
    $gridDatas01 = AnalystInterviewGrid::where(['analystinterview_id'=> $id,'identifier'=>'Parent Info on Product Material1'])->first();
    $gridDatas02 = AnalystInterviewGrid::where(['analystinterview_id'=> $id,'identifier'=>'Parent OOS Details'])->first();
    $gridDatas03 = AnalystInterviewGrid::where(['analystinterview_id'=> $id,'identifier'=>'Parent OOT Results'])->first();
    $gridDatas04 = AnalystInterviewGrid::where(['analystinterview_id'=> $id,'identifier'=>'Parent Stability Study'])->first();
    $gridDatas05 = AnalystInterviewGrid::where(['analystinterview_id'=> $id,'identifier'=>'Precautionary Measures'])->first();
    $gridDatas06 = AnalystInterviewGrid::where(['analystinterview_id'=> $id,'identifier'=>'Mobile Phase Preparation'])->first();
    $gridDatas07 = AnalystInterviewGrid::where(['analystinterview_id'=> $id,'identifier'=>'Reference Working Standards'])->first();
    $gridDatas08 = AnalystInterviewGrid::where(['analystinterview_id'=> $id,'identifier'=>'Handling of Samples'])->first();
    $gridDatas09 = AnalystInterviewGrid::where(['analystinterview_id'=> $id,'identifier'=>'Instrument Setup & Handling'])->first();
    // return $gridDatas06->data[0]['mpp_Q1'];
    if (!empty($data)) {
        $data->originator = User::where('id', $data->initiator_id)->value('name');
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('analystInterview.analystInterview_SingleReport', compact('data','gridDatas01','gridDatas02','gridDatas03','gridDatas04','gridDatas05','gridDatas06','gridDatas07','gridDatas08','gridDatas09'))
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
        return $pdf->stream('Verification Cemical' . $id . '.pdf');
    }
}


}
