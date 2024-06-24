<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecordNumber;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\AdditionalTesting;
use App\Models\AdditionalTestingAuditTrail;
use App\Models\AdditionalTestingGrid;
use App\Models\RoleGroup;


class AdditionalTestingController extends Controller
{
    // ****************************STORE*********************************

    public function store(Request $request)
    {

        // if (!$request->short_description) {
        //     toastr()->error("Short description is required");
        //     return response()->redirect()->back()->withInput();
        // }

        $additionalTest = new AdditionalTesting();
        $additionalTest->form_type = "AdditionalTesting";
        $additionalTest->record = ((RecordNumber::first()->value('counter')) + 1);
        // $additionalTest->initiator_id = Auth::user()->id;

        # -------------new-----------
        $additionalTest->root_parent_oos_number = $request->root_parent_oos_number;
        $additionalTest->root_parent_oot_number = $request->root_parent_oot_number;
        $additionalTest->parent_date_opened = $request->parent_date_opened;
        $additionalTest->parent_short_description = $request->parent_short_description;
        $additionalTest->parent_target_closure_date = $request->parent_target_closure_date;
        $additionalTest->parent_product_mat_name = $request->parent_product_mat_name;
        $additionalTest->root_parent_prod_mat_name = $request->root_parent_prod_mat_name;
        $additionalTest->record_number = $request->record_number;
        $additionalTest->site_division_code = $request->site_division_code;
        $additionalTest->division_id = $request->division_id;
        $additionalTest->initiator = $request->initiator;
        $additionalTest->gi_target_closure_date = $request->gi_target_closure_date;
        $additionalTest->gi_short_description = $request->gi_short_description;
        $additionalTest->qc_approver = $request->qc_approver;
        $additionalTest->date_opened = $request->date_opened;
        $additionalTest->record = $request->record;
        $additionalTest->form_type = $request->form_type;
        $additionalTest->status = $request->status;
        $additionalTest->stage = $request->stage;
        $additionalTest->cq_approver_comments_rows = $request->cq_approver_comments_rows;
        $additionalTest->resampling_required = $request->resampling_required;
        $additionalTest->resampling_reference = $request->resampling_reference;
        $additionalTest->assignee = $request->assignee;
        $additionalTest->aqa_approver = $request->aqa_approver;
        $additionalTest->cq_approver = $request->cq_approver;
        $additionalTest->cq_approval_comment = $request->cq_approval_comment;
        $additionalTest->add_testing_execution_comment = $request->add_testing_execution_comment;
        $additionalTest->delay_justifictaion = $request->delay_justifictaion;
        $additionalTest->qc_comments_on_addl_testing = $request->qc_comments_on_addl_testing;
        $additionalTest->summary_of_exp_hyp = $request->summary_of_exp_hyp;


        if (!empty($request->add_test_attachment)) {
            $files = [];
            if ($request->hasfile('add_test_attachment')) {
                foreach ($request->file('add_test_attachment') as $file) {
                    $name = $request->name . 'add_test_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $additionalTest->add_test_attachment = json_encode($files);
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


            $additionalTest->cq_approval_attachment = json_encode($files);
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


            $additionalTest->add_test_exe_attachment = json_encode($files);
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


            $additionalTest->qc_review_attachment = json_encode($files);
        }


        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();
        $additionalTest->status = 'Opened';
        $additionalTest->stage = 1;
        $additionalTest->save();
        // dd($additionalTest->id);


        // Grid 1

        // Additional Testing grid 1------------------------------

        $grid_data = $additionalTest->id;
        $info_product_material1 = AdditionalTestingGrid::where(['additional_testing_id' => $grid_data, 'identifier' => 'parent info product material1'])->firstOrNew();
        $info_product_material1->additional_testing_id = $grid_data;
        $info_product_material1->identifier = 'Parent info on Product Material1';
        $info_product_material1->data = $request->parent_info_on_product_material;
        $info_product_material1->save();

        // Additional Testing grid 2------------------------------

        $grid_data = $additionalTest->id;
        $info_product_material2 = AdditionalTestingGrid::where(['additional_testing_id' => $grid_data, 'identifier' => 'parent info product material2'])->firstOrNew();
        $info_product_material2->additional_testing_id = $grid_data;
        $info_product_material2->identifier = 'Parent Info on Product Material2';
        $info_product_material2->data = $request->parent_info_on_product_material1;
        $info_product_material2->save();


        // Additional Testing grid 3------------------------------

        $grid_data = $additionalTest->id;
        $root_parent_oos_Details = AdditionalTestingGrid::where(['additional_testing_id' => $grid_data, 'identifier' => 'Root Parent OOS Details'])->firstOrNew();
        $root_parent_oos_Details->additional_testing_id = $grid_data;
        $root_parent_oos_Details->identifier = 'Root Parent OOS Details';
        $root_parent_oos_Details->data = $request->root_parent_oos_details;
        $root_parent_oos_Details->save();

        // Additional Testing grid 4------------------------------

        $grid_data = $additionalTest->id;
        $parent_oot_results = AdditionalTestingGrid::where(['additional_testing_id' => $grid_data, 'identifier' => 'Parent OOT Results'])->firstOrNew();
        $parent_oot_results->additional_testing_id = $grid_data;
        $parent_oot_results->identifier = 'Parent OOT Results';
        $parent_oot_results->data = $request->parent_oot_results;
        $parent_oot_results->save();

        // Additional Testing grid 5------------------------------

        $grid_data = $additionalTest->id;
        $parent_details_of_stability_study = AdditionalTestingGrid::where(['additional_testing_id' => $grid_data, 'identifier' => 'parent Details of Stability Study'])->firstOrNew();
        $parent_details_of_stability_study->additional_testing_id = $grid_data;
        $parent_details_of_stability_study->identifier = 'parent Details of Stability Study';
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
            // 'record_number' => 'Record Number',
            'site_division_code' => 'Site/Division Code',
            'division_id' => 'division_id',
            'initiator' => 'Initiator',
            'gi_target_closure_date' => 'Target Closure Date',
            'gi_short_description' => 'Short Description*',
            'qc_approver' => 'QC Approver',
            'date_opened' => 'Date opened',
            // 'record' => 'record',
            // 'form_type' => 'form_type',
            // 'status' => 'status',
            // 'stage' => 'stage',
            'cq_approver_comments_rows' => 'CQ Approver Comments',
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
        foreach ($CombinedData as $key => $value) {
            if (!empty($additionalTest->$key)) {
                $history = new AdditionalTestingAuditTrail();
                $history->additional_testing_id = $additionalTest->id;
                $history->activity_type = $value;
                $history->previous = "Null";
                $history->current = $additionalTest->$key;
                $history->comment = "Not Applicable";
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $additionalTest->status;
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
        // Retrieve the existing record
        $additionalTest = AdditionalTesting::find($id);
        // if (!$additionalTest) {
        //     // Handle the case where the record is not found
        //     toastr()->error('Record not found');
        //     return back();
        // }

        $lastAdditionalTest = $additionalTest->replicate();

        $additionalTest->root_parent_oos_number = $request->root_parent_oos_number;
        $additionalTest->root_parent_oot_number = $request->root_parent_oot_number;
        $additionalTest->parent_date_opened = $request->parent_date_opened;
        $additionalTest->parent_short_description = $request->parent_short_description;
        $additionalTest->parent_target_closure_date = $request->parent_target_closure_date;
        $additionalTest->parent_product_mat_name = $request->parent_product_mat_name;
        $additionalTest->root_parent_prod_mat_name = $request->root_parent_prod_mat_name;
        $additionalTest->site_division_code = $request->site_division_code;
        $additionalTest->division_id = $request->division_id;
        $additionalTest->initiator = $request->initiator;
        $additionalTest->gi_target_closure_date = $request->gi_target_closure_date;
        $additionalTest->gi_short_description = $request->gi_short_description;
        $additionalTest->qc_approver = $request->qc_approver;
        $additionalTest->date_opened = $request->date_opened;
        $additionalTest->cq_approver_comments_rows = $request->cq_approver_comments_rows;
        $additionalTest->resampling_required = $request->resampling_required;
        $additionalTest->resampling_reference = $request->resampling_reference;
        $additionalTest->assignee = $request->assignee;
        $additionalTest->aqa_approver = $request->aqa_approver;
        $additionalTest->cq_approver = $request->cq_approver;
        $additionalTest->cq_approval_comment = $request->cq_approval_comment;
        $additionalTest->add_testing_execution_comment = $request->add_testing_execution_comment;
        $additionalTest->delay_justifictaion = $request->delay_justifictaion;
        $additionalTest->qc_comments_on_addl_testing = $request->qc_comments_on_addl_testing;
        $additionalTest->summary_of_exp_hyp = $request->summary_of_exp_hyp;

        if (!empty($request->add_test_attachment)) {
            $files = [];
            if ($request->hasfile('add_test_attachment')) {
                foreach ($request->file('add_test_attachment') as $file) {
                    $name = $request->name . 'add_test_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $additionalTest->add_test_attachment = json_encode($files);
        }

        if (!empty($request->cq_approval_attachment)) {
            $files = [];
            if ($request->hasfile('cq_approval_attachment')) {
                foreach ($request->file('cq_approval_attachment') as $file) {
                    $name = $request->name . 'cq_approval_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $additionalTest->cq_approval_attachment = json_encode($files);
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
            $additionalTest->add_test_exe_attachment = json_encode($files);
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
            $additionalTest->qc_review_attachment = json_encode($files);
        }

        $additionalTest->save();

        // Update grids
        $grid_data = $additionalTest->id;

        $info_product_material1 = AdditionalTestingGrid::where(['additional_testing_id' => $grid_data, 'identifier' => 'Parent info on Product Material1'])->firstOrNew();
        $info_product_material1->data = $request->parent_info_on_product_material;
        $info_product_material1->save();

        $info_product_material2 = AdditionalTestingGrid::where(['additional_testing_id' => $grid_data, 'identifier' => 'Parent Info on Product Material2'])->firstOrNew();
        $info_product_material2->data = $request->parent_info_on_product_material1;
        $info_product_material2->save();

        $root_parent_oos_Details = AdditionalTestingGrid::where(['additional_testing_id' => $grid_data, 'identifier' => 'Root Parent OOS Details'])->firstOrNew();
        $root_parent_oos_Details->data = $request->root_parent_oos_details;
        $root_parent_oos_Details->save();

        $parent_oot_results = AdditionalTestingGrid::where(['additional_testing_id' => $grid_data, 'identifier' => 'Parent OOT Results'])->firstOrNew();
        $parent_oot_results->data = $request->parent_oot_results;
        $parent_oot_results->save();

        $parent_details_of_stability_study = AdditionalTestingGrid::where(['additional_testing_id' => $grid_data, 'identifier' => 'Parent Details of Stability Study'])->firstOrNew();
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
            'gi_short_description' => 'Short Description*',
            'qc_approver' => 'QC Approver',
            'date_opened' => 'Date opened',
            'cq_approver_comments_rows' => 'CQ Approver Comments',
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
            if ($lastAdditionalTest->$key != $additionalTest->$key || !empty($request->comment)) {
                $history = new AdditionalTestingAuditTrail();
                $history->additional_testing_id = $additionalTest->id;
                $history->activity_type = $value;
                $history->previous = $lastAdditionalTest->$key;
                $history->current = $additionalTest->$key;
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
        return view('frontend.additional-testing.additional_testing_view');
    }

    // ****************************edit*********************************

    public function edit($id)
    {
        $verification = AdditionalTesting::findOrFail($id);
        $gridDatas01 = AdditionalTestingGrid::where(['additionalTest_id' => $id, 'identifier' => 'Parent Info on Product Material1'])->first();
        $gridDatas02 = AdditionalTestingGrid::where(['additionalTest_id' => $id, 'identifier' => 'Parent Info on Product Material2'])->first();
        $gridDatas03 = AdditionalTestingGrid::where(['additionalTest_id' => $id, 'identifier' => 'Parent OOS Details'])->first();
        $gridDatas04 = AdditionalTestingGrid::where(['additionalTest_id' => $id, 'identifier' => 'Parent OOT Results'])->first();
        $gridDatas05 = AdditionalTestingGrid::where(['additionalTest_id' => $id, 'identifier' => 'Parent Stability Study'])->first();

        return view('frontend.verification.verification_view', compact('additionalTest', 'gridDatas01', 'gridDatas02', 'gridDatas03', 'gridDatas04', 'gridDatas05'));
    }
}
