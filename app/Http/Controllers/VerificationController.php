<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\audit_reviewers_detail;
use App\Models\Verification;
use Illuminate\Http\Request;
use App\Models\RecordNumber;
use App\Models\VerificationAuditTrail;
use App\Models\RoleGroup;
use App\Models\VerificationGrid;
use App\Models\User;
use Carbon\Carbon;
use Error;
use Helpers;
use PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;


class VerificationController extends Controller
{

    public function store(Request $request)
    {
        // if (!$request->short_description) {
        //     toastr()->error("Short description is required");
        //     return response()->redirect()->back()->withInput();
        // }


        $verification = new Verification();
        $verification->form_type = "Verification";
        $verification->record = ((RecordNumber::first()->value('counter')) + 1);
        $verification->initiator_id= Auth::user()->id;

        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();

            $verification->parent_oos_no = $request->parent_oos_no;
            $verification->parent_oot_no = $request->parent_oot_no;
            $verification->parent_date_opened = $request->parent_date_opened;
            $verification->parent_short_description = $request->parent_short_description;
            $verification->parent_target_closure_date = $request->parent_target_closure_date;
            $verification->parent_product_material_name = $request->parent_product_material_name;

            // General information section
            $verification->record = $request->record;
            $verification->division_id = $request->division_id;
            $verification->division_code = $request->division_code;
            $verification->initiator_id = $request->initiator_id;
            $verification->intiation_date = $request->intiation_date;
            $verification->target_closure_date_gi = $request->target_closure_date_gi;
            $verification->short_description = $request->short_description;
            $verification->assignee = $request->assignee;
            $verification->supervisor = $request->supervisor;
            $verification->aqa_reviewer = $request->aqa_reviewer;
            $verification->recommended_actions = $request->recommended_actions;
            $verification->specify_if_any_action = $request->specify_if_any_action;
            $verification->justification_for_actions = $request->justification_for_actions;

            // Tab 2
            $verification->results_of_recommended_actions = $request->results_of_recommended_actions;
            $verification->date_of_completion = $request->date_of_completion;
            $verification->delay_justification = $request->delay_justification;

            // Tab 3
            $verification->supervisor_observation = $request->supervisor_observation;

            // Tab 4
            $verification->aqa_comments2 = $request->aqa_comments2;

            $verification->form_type = $request->form_type;
            $verification->record_number = $request->record_number;
            $verification->status = $request->status;
            $verification->stage = $request->stage;
            $verification->submitted_by = $request->submitted_by;
            $verification->submitted_on = $request->submitted_on;
            $verification->cancelled_by = $request->cancelled_by;
            $verification->cancelled_on = $request->cancelled_on;



        if (!empty ($request->execution_attachment)) {
            $files = [];
            if ($request->hasfile('execution_attachment')) {
                foreach ($request->file('execution_attachment') as $file) {
                    $name = $request->name . 'execution_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $verification->execution_attachment = json_encode($files);
        }
        if (!empty ($request->verification_attachment)) {
            $files = [];
            if ($request->hasfile('verification_attachment')) {
                foreach ($request->file('verification_attachment') as $file) {
                    $name = $request->name . 'verification_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $verification->verification_attachment = json_encode($files);
        }

        if (!empty ($request->aqa_attachment)) {
            $files = [];
            if ($request->hasfile('aqa_attachment')) {
                foreach ($request->file('aqa_attachment') as $file) {
                    $name = $request->name . 'aqa_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $verification->aqa_attachment = json_encode($files);
        }
        $verification->status = 'Opened';
        $verification->stage = 1;




        $verification->save();

        // Verification grid 1------------------------------

        $grid_data = $verification->id;
        $info_product_material = VerificationGrid::where(['verification_id'=>$grid_data,'identifier'=>'parent info product material2'])->firstOrNew();
        $info_product_material->verification_id = $grid_data;
        $info_product_material->identifier = 'Parent Info on Product Material1';
        $info_product_material->data = $request->parent_info_no_product_material;
        $info_product_material->save();

        // Verification grid 2-----------------------------

        $grid_data = $verification->id;
        $info_product_material2 = VerificationGrid::where(['verification_id'=>$grid_data,'identifier'=>'parent info product material2'])->firstOrNew();
        $info_product_material2->verification_id = $grid_data;
        $info_product_material2->identifier = 'Parent Info on Product Material2';
        $info_product_material2->data = $request->parent_info_no_product_material1;
        $info_product_material2->save();

         // Verification grid 3-----------------------------

         $grid_data = $verification->id;
         $oos_details = VerificationGrid::where(['verification_id'=>$grid_data,'identifier'=>'parent oos detail'])->firstOrNew();
         $oos_details->verification_id = $grid_data;
         $oos_details->identifier = 'Parent OOS Details';
         $oos_details->data = $request->parent_oos_details;
         $oos_details->save();

        // grid 4

        $grid_data = $verification->id;
        $oot_results = VerificationGrid::where(['verification_id'=>$grid_data,'identifier'=>'parent oot result'])->firstOrNew();
        $oot_results->verification_id = $grid_data;
        $oot_results->identifier = 'Parent OOT Results';
        $oot_results->data = $request->OOT_Results;
        $oot_results->save();

        //grid 5

        $grid_data = $verification->id;
        $parent_stability_study = VerificationGrid::where(['verification_id'=>$grid_data,'identifier'=>'parent stability study'])->firstOrNew();
        $parent_stability_study->verification_id = $grid_data;
        $parent_stability_study->identifier = 'Parent Stability Study';
        $parent_stability_study->data = $request->parent_details_of_stability_study;
        $parent_stability_study->save();


        // Audit Trail===========================================================

        if (!empty($verification->short_description)) {
            $history = new VerificationAuditTrail();
            $history->verification_id = $verification->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Null";
            $history->current = $verification->short_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;//dont know kaha se aayi ye id
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $verification->status;
            $history->action_name = 'Submit';
            $history->save();
            }

$combinedfields = [
    'parent_oos_no'=>'(Parent) OOS No',
    'parent_oot_no'=>'(Parent) OOT No.',
    'parent_date_opened'=>'(Parent)Date Opened',
    'parent_short_description'=>'(Parent) Short Description',
    'parent_target_closure_date'=>'(Parent) Target Closure Date',
    'parent_product_material_name'=>'(Parent) Product/Material Name',
    'record'=>'Record Number',
    'division_code'=>'Site/Location Code',
    'initiator_id'=>'Initiator ',
    'date_opened_gi'=>'Date Opened',
    'target_closure_date_gi'=>'Target Closure Date',
    'assignee'=>'Assignee',
    'supervisor'=>' Supervisor',
    'aqa_reviewer'=>'AQA Reviewer',
    'recommended_actions'=>'Recommended Actions',
    'specify_if_any_action'=>'Specify If Any Other Action',
    'justification_for_actions'=>'Justification For Actions',
    'results_of_recommended_actions'=>'Results Of Recommended Actions',
    'date_of_completion'=>'Date Of Completion',
    'delay_justification'=>'Delay Justification',
    'supervisor_observation'=>'Supervisor Observations',
    'aqa_comments2'=>'AQA Comments',
];

                    foreach ($combinedfields as $key => $value){
                if (!empty($verification->$key)) {
                    $history = new VerificationAuditTrail();
                    $history->verification_id = $verification->id;
                    $history->activity_type = $value;
                    $history->previous = "Null";
                    $history->current = $verification->$key;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $verification->status;
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

        $lastVerification = Verification::find($id);

        $verification = Verification::find($id);
            $verification->parent_oos_no = $request->parent_oos_no;
            $verification->parent_oot_no = $request->parent_oot_no;
            $verification->parent_date_opened = $request->parent_date_opened;
            $verification->parent_short_description = $request->parent_short_description;
            $verification->parent_target_closure_date = $request->parent_target_closure_date;
            $verification->parent_product_material_name = $request->parent_product_material_name;

            // General information section
            $verification->record = $request->record;
            $verification->division_id = $request->division_id;
            $verification->division_code = $request->division_code;
            $verification->initiator_id = $request->initiator_id;
            $verification->intiation_date = $request->intiation_date;
            $verification->target_closure_date_gi = $request->target_closure_date_gi;
            $verification->short_description = $request->short_description;
            $verification->assignee = $request->assignee;
            $verification->supervisor = $request->supervisor;
            $verification->aqa_reviewer = $request->aqa_reviewer;
            $verification->recommended_actions = $request->recommended_actions;
            $verification->specify_if_any_action = $request->specify_if_any_action;
            $verification->justification_for_actions = $request->justification_for_actions;

            // Tab 2
            $verification->results_of_recommended_actions = $request->results_of_recommended_actions;
            $verification->date_of_completion = $request->date_of_completion;
            $verification->execution_attachment = $request->execution_attachment;

            // Tab 3
            $verification->supervisor_observation = $request->supervisor_observation;

            // Tab 4
            $verification->aqa_comments2 = $request->aqa_comments2;

            $verification->form_type = $request->form_type;
            $verification->record_number = $request->record_number;
            $verification->status = $request->status;
            $verification->stage = $request->stage;
            $verification->submitted_by = $request->submitted_by;
            $verification->submitted_on = $request->submitted_on;
            $verification->cancelled_by = $request->cancelled_by;
            $verification->cancelled_on = $request->cancelled_on;



        if (!empty ($request->execution_attachment)) {
            $files = [];
            if ($request->hasfile('execution_attachment')) {
                foreach ($request->file('execution_attachment') as $file) {
                    $name = $request->name . 'execution_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $verification->execution_attachment = json_encode($files);
        }
        if (!empty ($request->verification_attachment)) {
            $files = [];
            if ($request->hasfile('verification_attachment')) {
                foreach ($request->file('verification_attachment') as $file) {
                    $name = $request->name . 'verification_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $verification->verification_attachment = json_encode($files);
        }

        if (!empty ($request->aqa_attachment)) {
            $files = [];
            if ($request->hasfile('aqa_attachment')) {
                foreach ($request->file('aqa_attachment') as $file) {
                    $name = $request->name . 'aqa_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $verification->aqa_attachment = json_encode($files);
        }
//------------------================Update Grid ================================//
//grid 1

                $grid_data = $verification->id;
                $info_product_material = VerificationGrid::where(['verification_id'=>$grid_data,'identifier'=>'parent info product material2'])->firstOrNew();
                $info_product_material->verification_id = $grid_data;
                $info_product_material->identifier = 'Parent Info on Product Material1';
                $info_product_material->data = $request->parent_info_no_product_material;
                $info_product_material->update();

                // Verification grid 2-----------------------------

                $grid_data = $verification->id;
                $info_product_material2 = VerificationGrid::where(['verification_id'=>$grid_data,'identifier'=>'parent info product material2'])->firstOrNew();
                $info_product_material2->verification_id = $grid_data;
                $info_product_material2->identifier = 'Parent Info on Product Material2';
                $info_product_material2->data = $request->parent_info_no_product_material1;
                $info_product_material2->update();

                 // Verification grid 3-----------------------------

                 $grid_data = $verification->id;
                 $oos_details = VerificationGrid::where(['verification_id'=>$grid_data,'identifier'=>'parent oos detail'])->firstOrNew();
                 $oos_details->verification_id = $grid_data;
                 $oos_details->identifier = 'Parent OOS Details';
                 $oos_details->data = $request->parent_oos_details;
                 $oos_details->update();

                //v grid 4

                $grid_data = $verification->id;
                $oot_results = VerificationGrid::where(['verification_id'=>$grid_data,'identifier'=>'parent oot result'])->firstOrNew();
                $oot_results->verification_id = $grid_data;
                $oot_results->identifier = 'Parent OOT Results';
                $oot_results->data = $request->OOT_Results;
                $oot_results->save();

                //grid 5

                $grid_data = $verification->id;
                $parent_stability_study = VerificationGrid::where(['verification_id'=>$grid_data,'identifier'=>'parent stability study'])->firstOrNew();
                $parent_stability_study->verification_id = $grid_data;
                $parent_stability_study->identifier = 'Parent Stability Study';
                $parent_stability_study->data = $request->parent_details_of_stability_study;
                $parent_stability_study->save();


    $verification->update();


    //================ Update of audit trail

$combinedfields = [
    'parent_oos_no'=>'(Parent) OOS No',
    'parent_oot_no'=>'(Parent) OOT No.',
    'parent_date_opened'=>'(Parent)Date Opened',
    'parent_short_description'=>'(Parent) Short Description',
    'parent_target_closure_date'=>'(Parent) Target Closure Date',
    'parent_product_material_name'=>'(Parent) Product/Material Name',
    'record'=>'Record Number',
    'division_code'=>'Site/Location Code',
    'initiator_id'=>'Initiator ',
    'date_opened_gi'=>'Date Opened',
    'target_closure_date_gi'=>'Target Closure Date',
    'assignee'=>'Assignee',
    'supervisor'=>' Supervisor',
    'aqa_reviewer'=>'AQA Reviewer',
    'recommended_actions'=>'Recommended Actions',
    'specify_if_any_action'=>'Specify If Any Other Action',
    'justification_for_actions'=>'Justification For Actions',
    'results_of_recommended_actions'=>'Results Of Recommended Actions',
    'date_of_completion'=>'Date Of Completion',
    'delay_justification'=>'Delay Justification',
    'supervisor_observation'=>'Supervisor Observations',
    'aqa_comments2'=>'AQA Comments',
];

    foreach ($combinedfields as $key => $value){
    if ($lastVerification->$key != $verification->$key || !empty ($request->comment)) {
        // if (!empty($verification->$key)) {
            $history = new VerificationAuditTrail();
            $history->verification_id = $id;
            $history->activity_type = $value;
            $history->previous = $lastVerification->$key;
            $history->change_to = "Not Applicable";
            $history->change_from = $lastVerification->status;
            $history->current = $verification->$key;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastVerification->status;
            $history->action_name = 'Update';
            $history->save();
            // }
        }
    }

    toastr()->success('Record is Updated Successfully');
    return redirect(url('rcms/qms-dashboard'));
}

     public function edit($id) {
    $verification = Verification::findOrFail($id);

    $verification = Verification::find($id);
    $verification->record = str_pad($verification->record, 4, '0', STR_PAD_LEFT);
    $old_record = Verification::select('id', 'division_id', 'record')->get();
    $verification->assign_to_name = User::where('id', $verification->assign_id)->value('name');
    $verification->initiator_name = User::where('id', $verification->initiator_id)->value('name');
    $pre = Verification::all();
    $divisionName = DB::table('q_m_s_divisions')->where('id', $verification->division_id)->value('name');


    $gridDatas01 = VerificationGrid::where(['verification_id'=> $id,'identifier'=>'Parent Info on Product Material1'])->first();
    $gridDatas02 = VerificationGrid::where(['verification_id'=> $id,'identifier'=>'Parent Info on Product Material2'])->first();
    $gridDatas03 = VerificationGrid::where(['verification_id'=> $id,'identifier'=>'Parent OOS Details'])->first();
    $gridDatas04 = VerificationGrid::where(['verification_id'=> $id,'identifier'=>'Parent OOT Results'])->first();
    $gridDatas05 = VerificationGrid::where(['verification_id'=> $id,'identifier'=>'Parent Stability Study'])->first();

    return view('frontend.verification.verification_view', compact('verification', 'gridDatas01', 'gridDatas02', 'gridDatas03', 'gridDatas04', 'gridDatas05','pre','divisionName','old_record'));
}

public function send_stage(Request $request, $id)
{
    if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
        $changestage = Verification::find($id);
        $lastDocument = Verification::find($id);
        if ($changestage->stage == 1) {
            $changestage->stage = "2";
            $changestage->status = "Analysis Completed";
            $changestage->analysis_completed_by = Auth::user()->name;
            $changestage->analysis_completed_on = Carbon::now()->format('d-M-Y');
            $changestage->comment_analysis_completed = $request->comment;
                            $history = new VerificationAuditTrail();
                            $history->verification_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->current = $changestage->analysis_completed_by;
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = $lastDocument->status;
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
            $changestage->status = "QC Verification Complete";
            $changestage->qc_verification_completed_by= Auth::user()->name;
            $changestage->qc_verification_completed_on = Carbon::now()->format('d-M-Y');
            $changestage->comment_qc_verification_completed = $request->comment;
                $history = new VerificationAuditTrail();
                $history->verification_id = $id;
                $history->activity_type = 'Activity Log';
                $history->current = $changestage->qc_verification_completed_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = "3";
                $history->save();
            $changestage->update();
            toastr()->success('Document Sent');
            return back();
        }
        if ($changestage->stage == 3) {
            $changestage->stage = "4";
            $changestage->status = "AQA Verification Complete";
            $changestage->aqa_verification_completed_by= Auth::user()->name;
            $changestage->aqa_verification_completed_on = Carbon::now()->format('d-M-Y');
            $changestage->comment_aqa_verification_completed = $request->comment;
                $history = new VerificationAuditTrail();
                $history->verification_id = $id;
                $history->activity_type = 'Activity Log';
                $history->current = $changestage->aqa_verification_completed_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = "4";
                $history->save();
            $changestage->update();
            toastr()->success('Document Sent');
            return back();
        }
        if ($changestage->stage == 4) {
            $changestage->stage = "5";
            $changestage->status = "Close-Done";
            $changestage->completed_by_close_done= Auth::user()->name;
            $changestage->completed_on_close_done = Carbon::now()->format('d-M-Y');
            $changestage->comment_close_done = $request->comment;

            $history = new VerificationAuditTrail();
            $history->verification_id = $id;
            $history->activity_type = 'Activity Log';
            $history->current = $changestage->completed_by_close_done;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
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
        $changestage = Verification::find($id);
        $lastDocument = Verification::find($id);
        if ($changestage->stage == 2) {
            $changestage->stage = "1";
            $changestage->status = "Open";
            $changestage->analysis_completed_by = Auth::user()->name;
            $changestage->analysis_completed_on = Carbon::now()->format('d-M-Y');
            $changestage->comment_analysis_completed = $request->comment;
            // $changestage->completed_by_opened = Auth::user()->name;
            // $changestage->completed_on_opened = Carbon::now()->format('d-M-Y');
            // $changestage->comment_opened = $request->comment;
                        $history = new VerificationAuditTrail();
                        $history->verification_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->current = $changestage->analysis_completed_by;
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastDocument->status;
                        $history->stage = "1";
                        $history->save();
            $changestage->update();
            toastr()->success('Document Sent');
            return back();
        }

        if ($changestage->stage == 3) {
            $changestage->stage = "2";
            $changestage->status = "Analysis Completed";
            $changestage->analysis_completed_by = Auth::user()->name;
            $changestage->analysis_completed_on = Carbon::now()->format('d-M-Y');
            $changestage->comment_analysis_completed = $request->comment;
                            $history = new VerificationAuditTrail();
                            $history->verification_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->current = $changestage->analysis_completed_by;
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = $lastDocument->status;
                            $history->stage = "2";
                            $history->save();
            $changestage->update();
            toastr()->success('Document Sent');
            return back();
        }
        if ($changestage->stage == 4) {
            $changestage->stage = "3";
            $changestage->status = "QC Verification Complete";
            $changestage->qc_verification_completed_by= Auth::user()->name;
            $changestage->qc_verification_completed_on = Carbon::now()->format('d-M-Y');
            $changestage->comment_qc_verification_completed = $request->comment;
                $history = new VerificationAuditTrail();
                $history->verification_id = $id;
                $history->activity_type = 'Activity Log';
                $history->current = $changestage->qc_verification_completed_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = "3";
                $history->save();
            $changestage->update();
            toastr()->success('Document Sent');
            return back();
        }
        if ($changestage->stage == 4) {
            $changestage->stage = "2";
            $changestage->status = "Analysis Completed";
            $changestage->analysis_completed_by = Auth::user()->name;
            $changestage->analysis_completed_on = Carbon::now()->format('d-M-Y');
            $changestage->comment_analysis_completed = $request->comment;
                            $history = new VerificationAuditTrail();
                            $history->verification_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->current = $changestage->analysis_completed_by;
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = $lastDocument->status;
                            $history->stage = "2";
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

public function Vsend_stage2(Request $request, $id)
{

    if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
        $changestage = Verification::find($id);
        $lastDocument = Verification::find($id);

        if ($changestage->stage == 4) {
            $changestage->stage = "2";
            $changestage->status = "Analysis Completed";
            $changestage->analysis_completed_by = Auth::user()->name;
            $changestage->analysis_completed_on = Carbon::now()->format('d-M-Y');
            $changestage->comment_analysis_completed = $request->comment;
                            $history = new VerificationAuditTrail();
                            $history->verification_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->current = $changestage->analysis_completed_by;
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = $lastDocument->status;
                            $history->stage = "2";
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
        $data = Verification::find($id);
        $lastDocument = Verification::find($id);
        $data->stage = "0";
        $data->status = "Closed-Cancelled";
        $data->cancelled_by = Auth::user()->name;
        $data->cancelled_on = Carbon::now()->format('d-M-Y');
        $data->comment_cancle = $request->comment;

                $history = new VerificationAuditTrail();
                $history->verification_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous ="";
                $history->current = $data->cancelled_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state =  $data->status;
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
    $audit = VerificationAuditTrail::where('verification_id', $id)->orderByDesc('id')->paginate(5);
    $today = Carbon::now()->format('d-m-y');
    $document = Verification::where('id', $id)->first();
    $document->initiator = User::where('id', $document->initiator_id)->value('name');


    return view('frontend.verification.verification_Audit_Trail', compact('audit', 'document', 'today'));

}


public function store_audit_review(Request $request, $id)
{
        $history = new audit_reviewers_detail();
        $history->verification_id = $id;
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
    $detail = VerificationAuditTrail::find($id);
    $detail_data = VerificationAuditTrail::where('activity_type', $detail->activity_type)->where('verification_id', $detail->id)->latest()->get();
    $doc = Verification::where('id', $detail->verification_id)->first();
    $doc->origiator_name = User::find($doc->initiator_id);
    return view('frontend.verification.verification_InnerAudit', compact('detail', 'doc', 'detail_data'));
}

    public static function auditReport($id)
  {
    $doc = Verification::find($id);
    if (!empty($doc)) {
        $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        $data = VerificationAuditTrail::where('verification_id', $id)->get();
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.verification.verification_AuditReport', compact('data', 'doc'))
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
    $data = Verification::find($id);
    $verification = Verification::findOrFail($id);
    $gridDatas01 = VerificationGrid::where(['verification_id'=> $id,'identifier'=>'Parent Info on Product Material1'])->first();
    $gridDatas02 = VerificationGrid::where(['verification_id'=> $id,'identifier'=>'Parent Info on Product Material2'])->first();
    $gridDatas03 = VerificationGrid::where(['verification_id'=> $id,'identifier'=>'Parent OOS Details'])->first();
    $gridDatas04 = VerificationGrid::where(['verification_id'=> $id,'identifier'=>'Parent OOT Results'])->first();
    $gridDatas05 = VerificationGrid::where(['verification_id'=> $id,'identifier'=>'Parent Stability Study'])->first();

    if (!empty($data)) {
        $data->originator = User::where('id', $data->initiator_id)->value('name');
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.verification.verification_SingleReport', compact('data','gridDatas01','gridDatas02','gridDatas03','gridDatas04','gridDatas05'))
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




