<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecordNumber;
use App\Models\User;
use App\Models\AdditionalTesting;
use App\Models\AdditionalTestingAuditTrail;
use App\Models\AdditionalTestingGrid;
use App\Models\RoleGroup;
use Carbon\Carbon;
use Helpers;
use PDF;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;




class AdditionalTestingController extends Controller
{
    // ****************************STORE*********************************

    public function store(Request $request)
    {

        // if (!$request->short_description) {
        //     toastr()->error("Short description is required");
        //     return response()->redirect()->back()->withInput();
        // }

        $additionaltesting = new AdditionalTesting();
        $additionaltesting->form_type = "Additional Testing";
        $additionaltesting->record = ((RecordNumber::first()->value('counter')) + 1);
        $additionaltesting->initiator = Auth::user()->id;

        # -------------new-----------
        $additionaltesting->root_parent_oos_number = $request->root_parent_oos_number;
        $additionaltesting->root_parent_oot_number = $request->root_parent_oot_number;
        $additionaltesting->parent_date_opened = $request->parent_date_opened;
        $additionaltesting->parent_short_description = $request->parent_short_description;
        $additionaltesting->parent_target_closure_date = $request->parent_target_closure_date;
        $additionaltesting->parent_product_mat_name = $request->parent_product_mat_name;
        $additionaltesting->root_parent_prod_mat_name = $request->root_parent_prod_mat_name;

        $additionaltesting->record_number = $request->record_number;
        $additionaltesting->division_code = $request->division_code;
        $additionaltesting->division_id = $request->division_id;
        // $additionaltesting->initiator = $request->initiator;

        $additionaltesting->gi_target_closure_date = $request->gi_target_closure_date;
        $additionaltesting->short_description = $request->short_description;
        $additionaltesting->qc_approver = $request->qc_approver;
        $additionaltesting->intiation_date = $request->intiation_date;

        // $additionaltesting->record = $request->record;
        // $additionaltesting->form_type = $request->form_type;
        // $additionaltesting->status = $request->status;
        // $additionaltesting->stage = $request->stage;

        $additionaltesting->cq_approver_comments = $request->cq_approver_comments;
        $additionaltesting->resampling_required = $request->resampling_required;
        $additionaltesting->resampling_reference = $request->resampling_reference;
        $additionaltesting->assignee = $request->assignee;
        $additionaltesting->aqa_approver = $request->aqa_approver;
        $additionaltesting->cq_approver = $request->cq_approver;
        $additionaltesting->cq_approval_comment = $request->cq_approval_comment;
        $additionaltesting->add_testing_execution_comment = $request->add_testing_execution_comment;
        $additionaltesting->delay_justifictaion = $request->delay_justifictaion;
        $additionaltesting->qc_comments_on_addl_testing = $request->qc_comments_on_addl_testing;
        $additionaltesting->summary_of_exp_hyp = $request->summary_of_exp_hyp;


        if (!empty($request->add_test_attachment)) {
            $files = [];
            if ($request->hasfile('add_test_attachment')) {
                foreach ($request->file('add_test_attachment') as $file) {
                    $name = $request->name . 'add_test_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $additionaltesting->add_test_attachment = json_encode($files);
        }
        //dd($request->Initial_attachment);
        if (!empty($request->cq_approval_attachment)) {
            $files = [];
            if ($request->hasfile('cq_approval_attachment')) {
                foreach ($request->file('cq_approval_attachment') as $file) {
                    $name = $request->name . 'cq_approval_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $additionaltesting->cq_approval_attachment = json_encode($files);
        }

        if (!empty($request->add_test_exe_attachment)) {
            $files = [];
            if ($request->hasfile('add_test_exe_attachment')) {
                foreach ($request->file('add_test_exe_attachment') as $file) {
                    $name = $request->name . 'add_test_exe_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $additionaltesting->add_test_exe_attachment = json_encode($files);
        }
        if (!empty($request->qc_review_attachment)) {
            $files = [];
            if ($request->hasfile('qc_review_attachment')) {
                foreach ($request->file('qc_review_attachment') as $file) {
                    $name = $request->name . 'qc_review_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $additionaltesting->qc_review_attachment = json_encode($files);
        }


        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();
        $additionaltesting->status = 'Opened';
        $additionaltesting->stage = 1;
        $additionaltesting->save();
        // dd($additionaltesting->id);


        // Grid 1

        // Additional Testing grid 1------------------------------

        $grid_data = $additionaltesting->id;
        $info_product_material1 = AdditionalTestingGrid::where(['additional_testing_id' => $grid_data, 'identifier' => 'parent info product material1'])->firstOrNew();
        $info_product_material1->additional_testing_id = $grid_data;
        $info_product_material1->identifier = 'Parent info on Product Material1';
        $info_product_material1->data = $request->parent_info_on_product_material;
        $info_product_material1->save();

        // Additional Testing grid 2------------------------------

        $grid_data = $additionaltesting->id;
        $info_product_material2 = AdditionalTestingGrid::where(['additional_testing_id' => $grid_data, 'identifier' => 'parent info product material2'])->firstOrNew();
        $info_product_material2->additional_testing_id = $grid_data;
        $info_product_material2->identifier = 'Parent Info on Product Material2';
        $info_product_material2->data = $request->parent_info_on_product_material1;
        $info_product_material2->save();


        // Additional Testing grid 3------------------------------

        $grid_data = $additionaltesting->id;
        $root_parent_oos_Details = AdditionalTestingGrid::where(['additional_testing_id' => $grid_data, 'identifier' => 'Root Parent OOS Details'])->firstOrNew();
        $root_parent_oos_Details->additional_testing_id = $grid_data;
        $root_parent_oos_Details->identifier = 'Root Parent OOS Details';
        $root_parent_oos_Details->data = $request->root_parent_oos_details;
        $root_parent_oos_Details->save();

        // Additional Testing grid 4------------------------------

        $grid_data = $additionaltesting->id;
        $parent_oot_results = AdditionalTestingGrid::where(['additional_testing_id' => $grid_data, 'identifier' => 'Parent OOT Results'])->firstOrNew();
        $parent_oot_results->additional_testing_id = $grid_data;
        $parent_oot_results->identifier = 'Parent OOT Results';
        $parent_oot_results->data = $request->parent_oot_results;
        $parent_oot_results->save();

        // Additional Testing grid 5------------------------------

        $grid_data = $additionaltesting->id;
        $parent_details_of_stability_study = AdditionalTestingGrid::where(['additional_testing_id' => $grid_data, 'identifier' => 'parent Details of Stability Study'])->firstOrNew();
        $parent_details_of_stability_study->additional_testing_id = $grid_data;
        $parent_details_of_stability_study->identifier = 'Parent Details of Stability Study';
        $parent_details_of_stability_study->data = $request->parent_details_of_stability_study;
        $parent_details_of_stability_study->save();


        // *-----------------------------:ARRAY:----------------------------

        $CombinedData = [
            'root_parent_oos_number' => '(Root Parent) OOS No.',
            'root_parent_oot_number' => '(Root Parent) OOT No.',
            'parent_date_opened' => '(Parent) Date Opened',
            'parent_short_description' => '(Parent) Short Description*',
            'parent_target_closure_date' => '(Parent) Target Closure Date',
            'parent_product_mat_name' => '(Parent)Product / Material Name',
            'root_parent_prod_mat_name' => '(Root Parent)Product / Material Name',
            'division_code' => 'Site/Division Code',
            'division_id' => 'division_id',
            'initiator' => 'Initiator',
            'gi_target_closure_date' => 'Target Closure Date',
            'short_description' => 'Short Description*',
            'qc_approver' => 'QC Approver',
            'intiation_date' => 'Initiation Date',
            'cq_approver_comments' => 'CQ Approver Comments',
            'resampling_required' => 'Resampling Required',
            'resampling_reference' => 'Resample Reference',
            'assignee' => 'Assignee',
            'aqa_approver' => 'AQA Apporover',
            'cq_approver' => 'CQ Apporver',
            'cq_approval_comment' => 'CQ Approval Comment',
            'add_testing_execution_comment' => 'Comments (if any)',
            'delay_justifictaion' => 'Delay Justification',
            'qc_comments_on_addl_testing' => 'QC Comments on Addl. Testing',
            'summary_of_exp_hyp' => 'Summary of Exp./Hyp.'
        ];
        foreach ($CombinedData as $key => $value) {
            if (!empty($additionaltesting->$key)) {
                $history = new AdditionalTestingAuditTrail();
                $history->additional_testing_id = $additionaltesting->id;
                $history->activity_type = $value;
                $history->previous = "Null";
                $history->current = $additionaltesting->$key;
                $history->comment = "Not Applicable";
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $additionaltesting->status;
                $history->action_name = 'Submit';
                $history->save();
            }
        }



        toastr()->success("Record is created Successfully");
        return redirect(url('rcms/qms-dashboard'));
    }

    // ****************************UPDATE*********************************

    public function update(Request $request, $id)
    {
        // dd($request->all());
        // Retrieve the existing record
        $lastAdditionalTest = AdditionalTesting::find($id);
        $additionaltesting = AdditionalTesting::find($id);
        // if (!$additionaltesting) {
        //     // Handle the case where the record is not found
        //     toastr()->error('Record not found');
        //     return back();
        // }


        $additionaltesting->root_parent_oos_number = $request->root_parent_oos_number;
        $additionaltesting->root_parent_oot_number = $request->root_parent_oot_number;
        $additionaltesting->parent_date_opened = $request->parent_date_opened;
        $additionaltesting->parent_short_description = $request->parent_short_description;
        $additionaltesting->parent_target_closure_date = $request->parent_target_closure_date;
        $additionaltesting->parent_product_mat_name = $request->parent_product_mat_name;
        $additionaltesting->root_parent_prod_mat_name = $request->root_parent_prod_mat_name;

        $additionaltesting->record_number = $request->record_number;
        $additionaltesting->division_code = $request->division_code;
        $additionaltesting->division_id = $request->division_id;
        $additionaltesting->initiator = $request->initiator;

        $additionaltesting->gi_target_closure_date = $request->gi_target_closure_date;
        $additionaltesting->short_description = $request->short_description;
        $additionaltesting->qc_approver = $request->qc_approver;
        $additionaltesting->intiation_date = $request->intiation_date;

        // $additionaltesting->record = $request->record;
        // $additionaltesting->form_type = $request->form_type;
        // $additionaltesting->status = $request->status;
        // $additionaltesting->stage = $request->stage;

        $additionaltesting->cq_approver_comments = $request->cq_approver_comments;
        $additionaltesting->resampling_required = $request->resampling_required;
        $additionaltesting->resampling_reference = $request->resampling_reference;
        $additionaltesting->assignee = $request->assignee;
        $additionaltesting->aqa_approver = $request->aqa_approver;
        $additionaltesting->cq_approver = $request->cq_approver;
        $additionaltesting->cq_approval_comment = $request->cq_approval_comment;
        $additionaltesting->add_testing_execution_comment = $request->add_testing_execution_comment;
        $additionaltesting->delay_justifictaion = $request->delay_justifictaion;
        $additionaltesting->qc_comments_on_addl_testing = $request->qc_comments_on_addl_testing;
        $additionaltesting->summary_of_exp_hyp = $request->summary_of_exp_hyp;


        if (!empty($request->add_test_attachment)) {
            $files = [];
            if ($request->hasfile('add_test_attachment')) {
                foreach ($request->file('add_test_attachment') as $file) {
                    $name = $request->name . 'add_test_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $additionaltesting->add_test_attachment = json_encode($files);
        }
        //dd($request->Initial_attachment);
        if (!empty($request->cq_approval_attachment)) {
            $files = [];
            if ($request->hasfile('cq_approval_attachment')) {
                foreach ($request->file('cq_approval_attachment') as $file) {
                    $name = $request->name . 'cq_approval_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $additionaltesting->cq_approval_attachment = json_encode($files);
        }

        if (!empty($request->add_test_exe_attachment)) {
            $files = [];
            if ($request->hasfile('add_test_exe_attachment')) {
                foreach ($request->file('add_test_exe_attachment') as $file) {
                    $name = $request->name . 'add_test_exe_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $additionaltesting->add_test_exe_attachment = json_encode($files);
        }
        if (!empty($request->qc_review_attachment)) {
            $files = [];
            if ($request->hasfile('qc_review_attachment')) {
                foreach ($request->file('qc_review_attachment') as $file) {
                    $name = $request->name . 'qc_review_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $additionaltesting->qc_review_attachment = json_encode($files);
        }
        $additionaltesting->update();


        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();
        $additionaltesting->status = 'Opened';
        $additionaltesting->stage = 1;
        // $additionaltesting->save();
        // dd($additionaltesting->id);


        // Update grids
        // Additional Testing grid 1------------------------------

        $grid_data = $additionaltesting->id;
        $info_product_material1 = AdditionalTestingGrid::where(['additional_testing_id' => $grid_data, 'identifier' => 'parent info product material1'])->firstOrNew();
        $info_product_material1->additional_testing_id = $grid_data;
        $info_product_material1->identifier = 'Parent info on Product Material1';
        $info_product_material1->data = $request->parent_info_on_product_material;
        $info_product_material1->save();

        // Additional Testing grid 2------------------------------

        $grid_data = $additionaltesting->id;
        $info_product_material2 = AdditionalTestingGrid::where(['additional_testing_id' => $grid_data, 'identifier' => 'parent info product material2'])->firstOrNew();
        $info_product_material2->additional_testing_id = $grid_data;
        $info_product_material2->identifier = 'Parent Info on Product Material2';
        $info_product_material2->data = $request->parent_info_on_product_material1;
        $info_product_material2->save();


        // Additional Testing grid 3------------------------------

        $grid_data = $additionaltesting->id;
        $root_parent_oos_Details = AdditionalTestingGrid::where(['additional_testing_id' => $grid_data, 'identifier' => 'Root Parent OOS Details'])->firstOrNew();
        $root_parent_oos_Details->additional_testing_id = $grid_data;
        $root_parent_oos_Details->identifier = 'Root Parent OOS Details';
        $root_parent_oos_Details->data = $request->root_parent_oos_details;
        $root_parent_oos_Details->save();

        // Additional Testing grid 4------------------------------

        $grid_data = $additionaltesting->id;
        $parent_oot_results = AdditionalTestingGrid::where(['additional_testing_id' => $grid_data, 'identifier' => 'Parent OOT Results'])->firstOrNew();
        $parent_oot_results->additional_testing_id = $grid_data;
        $parent_oot_results->identifier = 'Parent OOT Results';
        $parent_oot_results->data = $request->parent_oot_results;
        $parent_oot_results->save();

        // Additional Testing grid 5------------------------------

        $grid_data = $additionaltesting->id;
        $parent_details_of_stability_study = AdditionalTestingGrid::where(['additional_testing_id' => $grid_data, 'identifier' => 'parent Details of Stability Study'])->firstOrNew();
        $parent_details_of_stability_study->additional_testing_id = $grid_data;
        $parent_details_of_stability_study->identifier = 'Parent Details of Stability Study';
        $parent_details_of_stability_study->data = $request->parent_details_of_stability_study;
        $parent_details_of_stability_study->save();


        // Update audit trail
        $combinedfields = [
            'root_parent_oos_number' => '(Root Parent) OOS No.',
            'root_parent_oot_number' => '(Root Parent) OOT No.',
            'parent_date_opened' => '(Parent) Date Opened',
            'parent_short_description' => '(Parent) Short Description*',
            'parent_target_closure_date' => '(Parent) Target Closure Date',
            'parent_product_mat_name' => '(Parent)Product / Material Name',
            'root_parent_prod_mat_name' => '(Root Parent)Product / Material Name',
            'site_division_code' => 'Site/Division Code',
            'division_id' => 'division_id',
            'initiator' => 'Initiator',
            'gi_target_closure_date' => 'Target Closure Date',
            'short_description' => 'Short Description*',
            'qc_approver' => 'QC Approver',
            'intiation_date' => 'Initiation Date ',
            'cq_approver_comments' => 'CQ Approver Comments',
            'resampling_required' => 'Resampling Required?',
            'resampling_reference' => 'Resample Reference',
            'assignee' => 'Assignee',
            'aqa_approver' => 'AQA Apporover',
            'cq_approver' => 'CQ Apporver',
            'cq_approval_comment' => 'CQ Approval Comment',
            'add_testing_execution_comment' => 'Comments (if any)',
            'delay_justifictaion' => 'Delay Justification',
            'qc_comments_on_addl_testing' => 'QC Comments on Addl. Testing',
            'summary_of_exp_hyp' => 'Summary of Exp./Hyp.'
        ];

        foreach ($combinedfields as $key => $value) {
            if ($lastAdditionalTest->$key != $additionaltesting->$key || !empty($request->comment)) {
                $history = new AdditionalTestingAuditTrail();
                $history->additional_testing_id = $additionaltesting->id;
                $history->activity_type = $value;
                $history->change_to = "Not Applicable";
                $history->change_from = $lastAdditionalTest->status;
                $history->previous = $lastAdditionalTest->$key;
                $history->current = $additionaltesting->$key;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastAdditionalTest->status;
                $history->action_name = 'Update';
                $history->save();
            }
        }

        toastr()->success('Record is Updated Successfully');
        return back();
    }

    // ****************************edit*********************************

    // public function devshow($id)
    // {
    //     $old_record = Deviation::select('id', 'division_id', 'record')->get();
    //     // $data = Deviation::find($id);
    //     // $data1 = DeviationCft::where('deviation_id', $id)->first();
    //     // $data->record = str_pad($data->record, 4, '0', STR_PAD_LEFT);
    //     // $data->assign_to_name = User::where('id', $data->assign_id)->value('name');
    //     // $grid_data1 = DeviationGrid::where('deviation_id', $id)->where('type', "Deviation")->first();
    //     // $data->initiator_name = User::where('id', $data->initiator_id)->value('name');
    //     $pre = Deviation::all();
    //     $divisionName = DB::table('q_m_s_divisions')->where('id', $data->division_id)->value('name');

    //     return view('frontend.forms.deviation_view', compact('data', 'old_record', 'pre', 'data1', 'divisionName'));
    // }



    public function edit($id)
    {
        $additionaltesting = AdditionalTesting::find($id);
        $additionaltesting->record = str_pad($additionaltesting->record, 4, '0', STR_PAD_LEFT);
        $old_record = AdditionalTesting::select('id', 'division_id', 'record')->get();
        $additionaltesting->assign_to_name = User::where('id', $additionaltesting->assign_id)->value('name');
        $additionaltesting->initiator_name = User::where('id', $additionaltesting->initiator_id)->value('name');
        $pre = AdditionalTesting::all();
        $divisionName = DB::table('q_m_s_divisions')->where('id', $additionaltesting->division_id)->value('name');


        // dd($additionaltesting);
        $gridDatas01 = AdditionalTestingGrid::where(['additional_testing_id' => $id, 'identifier' => 'Parent info on Product Material1'])->first();
        $gridDatas02 = AdditionalTestingGrid::where(['additional_testing_id' => $id, 'identifier' => 'Parent Info on Product Material2'])->first();
        $gridDatas03 = AdditionalTestingGrid::where(['additional_testing_id' => $id, 'identifier' => 'Root Parent OOS Details'])->first();
        $gridDatas04 = AdditionalTestingGrid::where(['additional_testing_id' => $id, 'identifier' => 'Parent OOT Results'])->first();
        $gridDatas05 = AdditionalTestingGrid::where(['additional_testing_id' => $id, 'identifier' => 'Parent Details of Stability Study'])->first();
        return view('frontend.additional-testing.additional_testing_view', compact('additionaltesting', 'gridDatas01', 'gridDatas02', 'gridDatas03', 'gridDatas04', 'gridDatas05','pre','old_record','divisionName'));
    }



public function send_stage(Request $request, $id)
{
    if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
        $changestage = AdditionalTesting::find($id);
        $lastDocument = AdditionalTesting::find($id);
        if ($changestage->stage == 1) {
            $changestage->stage = "2";
            $changestage->status = "Under Add.Test Proposal";
            $changestage->additional_test_proposal_completed_by = Auth::user()->name;
            $changestage->additional_test_proposal_completed_on = Carbon::now()->format('d-M-Y');
            $changestage->additional_test_proposal_completed_comment = $request->comment;
                            $history = new AdditionalTestingAuditTrail();
                            $history->additional_testing_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->current = $changestage->additional_test_proposal_completed_by;
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
            $changestage->status = "Under CQ Approval";
            $changestage->cq_approved_by= Auth::user()->name;
            $changestage->cq_approved_on = Carbon::now()->format('d-M-Y');
            $changestage->cq_approved_comment = $request->comment;
                $history = new AdditionalTestingAuditTrail();
                $history->additional_testing_id = $id;
                $history->activity_type = 'Activity Log';
                $history->current = $changestage->cq_approved_by;
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
            $changestage->status = "Under Add. Testing Execution";
            $changestage->additional_test_exe_by= Auth::user()->name;
            $changestage->additional_test_exe_on = Carbon::now()->format('d-M-Y');
            $changestage->additional_test_exe_comment = $request->comment;
                $history = new AdditionalTestingAuditTrail();
                $history->additional_testing_id = $id;
                $history->activity_type = 'Activity Log';
                $history->current = $changestage->additional_test_exe_by;
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
            $changestage->status = "Check Resampling";
            $changestage->resampling_checked_by= Auth::user()->name;
            $changestage->resampling_checked_on = Carbon::now()->format('d-M-Y');
            $changestage->resampling_checked_comment = $request->comment;
                $history = new AdditionalTestingAuditTrail();
                $history->additional_testing_id = $id;
                $history->activity_type = 'Activity Log';
                $history->current = $changestage->resampling_checked_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = "5";
                $history->save();
            $changestage->update();
            toastr()->success('Document Sent');
            return back();
        }
        if ($changestage->stage == 5) {
            $changestage->stage = "6";
            $changestage->status = "Under Add. Testing Execution QC Review";
            $changestage->additional_test_qc_by= Auth::user()->name;
            $changestage->additional_test_qc_on = Carbon::now()->format('d-M-Y');
            $changestage->additional_test_qc_comment = $request->comment;
                $history = new AdditionalTestingAuditTrail();
                $history->additional_testing_id = $id;
                $history->activity_type = 'Activity Log';
                $history->current = $changestage->additional_test_qc_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = "6";
                $history->save();
            $changestage->update();
            toastr()->success('Document Sent');
            return back();
        }
        if ($changestage->stage == 6) {
            $changestage->stage = "7";
            $changestage->status = "Under Add. Testing Execution AQA Review";
            $changestage->aqa_review_completed_by= Auth::user()->name;
            $changestage->aqa_review_completed_on = Carbon::now()->format('d-M-Y');
            $changestage->aqa_review_completed_comment = $request->comment;
                $history = new AdditionalTestingAuditTrail();
                $history->additional_testing_id = $id;
                $history->activity_type = 'Activity Log';
                $history->current = $changestage->aqa_review_completed_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = "7";
                $history->save();
            $changestage->update();
            toastr()->success('Document Sent');
            return back();
        }
        if ($changestage->stage == 7) {
            $changestage->stage = "8";
            $changestage->status = "Close-Done";
            $changestage->completed_by_close_done= Auth::user()->name;
            $changestage->completed_on_close_done = Carbon::now()->format('d-M-Y');
            $changestage->comment_close_done = $request->comment;

            $history = new AdditionalTestingAuditTrail();
            $history->additional_testing_id = $id;
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
        $changestage = AdditionalTesting::find($id);
        $lastDocument = AdditionalTesting::find($id);
        if ($changestage->stage == 2) {
            $changestage->stage = "1";
            $changestage->status = "Opened";
            $changestage->opened_by = Auth::user()->name;
            $changestage->opened_on = Carbon::now()->format('d-M-Y');
            $changestage->opened_comment = $request->comment;
            // $changestage->completed_by_opened = Auth::user()->name;
            // $changestage->completed_on_opened = Carbon::now()->format('d-M-Y');
            // $changestage->comment_opened = $request->comment;
                        $history = new AdditionalTestingAuditTrail();
                        $history->additional_testing_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->current = $changestage->opened_by;
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
            $changestage->status = "Under Add.Test Proposal";
            $changestage->additional_test_proposal_completed_by = Auth::user()->name;
            $changestage->additional_test_proposal_completed_on = Carbon::now()->format('d-M-Y');
            $changestage->additional_test_proposal_completed_comment = $request->comment;
                            $history = new AdditionalTestingAuditTrail();
                            $history->additional_testing_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->current = $changestage->additional_test_proposal_completed_by;
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
        if ($changestage->stage == 6) {
            $changestage->stage = "4";
            $changestage->status = "Under Add. Testing Execution";
            $changestage->additional_test_exe_by= Auth::user()->name;
            $changestage->additional_test_exe_on = Carbon::now()->format('d-M-Y');
            $changestage->additional_test_exe_comment = $request->comment;
                $history = new AdditionalTestingAuditTrail();
                $history->additional_testing_id = $id;
                $history->activity_type = 'Activity Log';
                $history->current = $changestage->additional_test_exe_by;
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
        if ($changestage->stage == 7) {
            $changestage->stage = "6";
            $changestage->status = "Under Add. Testing Execution QC Review";
            $changestage->additional_test_qc_by= Auth::user()->name;
            $changestage->additional_test_qc_on = Carbon::now()->format('d-M-Y');
            $changestage->additional_test_qc_comment = $request->comment;
                $history = new AdditionalTestingAuditTrail();
                $history->additional_testing_id = $id;
                $history->activity_type = 'Activity Log';
                $history->current = $changestage->additional_test_qc_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = "6";
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

public function send_stageto4(Request $request, $id)
{

    if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
        $changestage = AdditionalTesting::find($id);
        $lastDocument = AdditionalTesting::find($id);

        if ($changestage->stage == 7) {
            $changestage->stage = "4";
            $changestage->status = "Under Add. Testing Execution";
            $changestage->additional_test_exe_by= Auth::user()->name;
            $changestage->additional_test_exe_on = Carbon::now()->format('d-M-Y');
            $changestage->additional_test_exe_comment = $request->comment;
                $history = new AdditionalTestingAuditTrail();
                $history->additional_testing_id = $id;
                $history->activity_type = 'Activity Log';
                $history->current = $changestage->additional_test_exe_by;
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

    } else {
        toastr()->error('E-signature Not match');
        return back();
    }
}


public function cancel_stages(Request $request, $id)
{
    if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
        $data = AdditionalTesting::find($id);
        $lastDocument = AdditionalTesting::find($id);
        $data->stage = "0";
        $data->status = "Closed-Cancelled";
        $data->completed_by_close_done = Auth::user()->name;
        $data->completed_on_close_done = Carbon::now()->format('d-M-Y');
        $data->comment_close_done = $request->comment;

                $history = new AdditionalTestingAuditTrail();
                $history->additional_testing_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous ="";
                $history->current = $data->completed_by_close_done;
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
    $audit = AdditionalTestingAuditTrail::where('additional_testing_id', $id)->orderByDesc('id')->paginate(5);
    $today = Carbon::now()->format('d-m-y');
    $document = AdditionalTesting::where('id', $id)->first();
    $document->initiator = User::where('id', $document->initiator_id)->value('name');
    return view('frontend.additional-testing.additionalT_Audit_Trail', compact('audit', 'document', 'today'));
}
public function auditDetails($id)
{
    $detail = AdditionalTestingAuditTrail::find($id);
    $detail_data = AdditionalTestingAuditTrail::where('activity_type', $detail->activity_type)->where('additional_testing_id', $detail->id)->latest()->get();
    $doc = AdditionalTesting::where('id', $detail->additional_testing_id)->first();
    $doc->origiator_name = User::find($doc->initiator_id);
    return view('frontend.additional-testing.additionalT_innerAudit', compact('detail', 'doc', 'detail_data'));
}
    public static function auditReport($id)
  {
    $doc = AdditionalTesting::find($id);
    if (!empty($doc)) {
        $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        $data = AdditionalTestingAuditTrail::where('additional_testing_id', $id)->get();
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.additional-testing.additionalT_auditReport', compact('data', 'doc'))
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
    $data = AdditionalTesting::find($id);
    $analystinterview = AdditionalTesting::findOrFail($id);
    $gridDatas01 = AdditionalTestingGrid::where(['additional_testing_id'=> $id,'identifier'=>'Parent Info on Product Material1'])->first();
    $gridDatas02 = AdditionalTestingGrid::where(['additional_testing_id'=> $id,'identifier'=>'Parent Info on Product Material2'])->first();
    $gridDatas03 = AdditionalTestingGrid::where(['additional_testing_id'=> $id,'identifier'=>'Root Parent OOS Details'])->first();
    $gridDatas04 = AdditionalTestingGrid::where(['additional_testing_id'=> $id,'identifier'=>'Parent OOT Results'])->first();
    $gridDatas05 = AdditionalTestingGrid::where(['additional_testing_id'=> $id,'identifier'=>'Parent Details of Stability Study'])->first();
    // return $gridDatas06->data[0]['mpp_Q1'];
    if (!empty($data)) {
        $data->originator = User::where('id', $data->initiator_id)->value('name');
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.additional-testing.additionalT_singleReport', compact('data','gridDatas01','gridDatas02','gridDatas03','gridDatas04','gridDatas05'))
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

public function store_audit_review(Request $request, $id)
{
        $history = new audit_reviewers_detail();
        $history->additional_testing_id = $id;
        $history->user_id = Auth::user()->id;
        $history->type = $request->type;
        $history->reviewer_comment = $request->reviewer_comment;
        $history->reviewer_comment_by = Auth::user()->name;
        $history->reviewer_comment_on = Carbon::now()->toDateString();
        $history->save();

    return redirect()->back();
}

}
