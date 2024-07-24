<?php

namespace App\Http\Controllers;
use App\Models\Hypothesis;
use PDF;

use App\Http\Controllers\Controller;
use App\Models\HypothesisAuditTrial;
use App\Models\User;
use App\Models\RoleGroup;
use App\Models\Hypothesis_grid;

use Illuminate\Http\Request;  
use App\Models\RecordNumber;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class HypoController extends Controller
{
    
    public function index()
    {
        $old_record = Hypothesis::select('id', 'record_number')->get();
        $record_number = (RecordNumber::first()->value('counter')) + 1;
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
    
        return response()->view('frontend.newform.hypothesis', compact('record_number'));
        
    }

    public function store(Request $request)
    {
        if (!$request->short_description) {
            toastr()->error("Short description is required");
            return response()->redirect()->back()->withInput();
        }

        // $record = RecordNumber::first();
        // $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        // $record->update();


        $hypothesis = new Hypothesis();
        $hypothesis->form_type = "Hypothesis";
        $hypothesis->record_number = ((RecordNumber::first()->value('counter')) + 1);
        $hypothesis->initiator_id = Auth::user()->id;

        #------------------data-fields---------------
        $hypothesis->parent_oos_no = $request->parent_oos_no;
        $hypothesis->parent_oot_no = $request->parent_oot_no;
        $hypothesis->parent_date_opened = $request->parent_date_opened;
        $hypothesis->parent_short_description = $request->parent_short_description;
        $hypothesis->parent_target_closure_date = $request->parent_target_closure_date;
        $hypothesis->parent_product_material_name = $request->parent_product_material_name;
        $hypothesis->record_number = $request->record_number;
        $hypothesis->division_code = $request->division_code;
        $hypothesis->initiator = $request->initiator;
        $hypothesis->initiation_date = $request->initiation_date;
        $hypothesis->date_opened = $request->date_opened;
        $hypothesis->target_closure_date = $request->target_closure_date;
        $hypothesis->short_description = $request->short_description;
        $hypothesis->description = $request->description;
        $hypothesis->qc_approver = $request->qc_approver;
        $hypothesis->assignee = $request->assignee;
        $hypothesis->qc_comments = $request->qc_comments;
        $hypothesis->aqa_approver = $request->aqa_approver;
        $hypothesis->hyp_exp_comments = $request->hyp_exp_comments;
        $hypothesis->hypothesis_attachment = $request->hypothesis_attachment;
        $hypothesis->aqa_review_comments = $request->aqa_review_comments;
        $hypothesis->aqa_review_attachment = $request->aqa_review_attachment;
        $hypothesis->summary_of_hypothesis = $request->summary_of_hypothesis;
        $hypothesis->delay_justification = $request->delay_justification;
        $hypothesis->hypo_execution_attachment = $request->hypo_execution_attachment;
        $hypothesis->hypo_exp_qc_review_comments = $request->hypo_exp_qc_review_comments;
        $hypothesis->qc_review_attachment = $request->qc_review_attachment;
        $hypothesis->hypo_exp_aqa_review_comments = $request->hypo_exp_aqa_review_comments;
        $hypothesis->hypo_exp_aqa_review_attachment = $request->hypo_exp_aqa_review_attachment;
        $hypothesis->submit_by = $request->submit_by;
        $hypothesis->submit_on = $request->submit_on;
        $hypothesis->hypo_proposed_by = $request->hypo_proposed_by;
        $hypothesis->hypo_proposed_on = $request->hypo_proposed_on;
        $hypothesis->hypothesis_proposed_by = $request->hypothesis_proposed_by;
        $hypothesis->hypothesis_proposed_on = $request->hypothesis_proposed_on;
        $hypothesis->aqa_review_compelet_by = $request->aqa_review_compelet_by;
        $hypothesis->aqa_review_compelet_on = $request->aqa_review_compelet_on;
        $hypothesis->hypo_execution_done_by = $request->hypo_execution_done_by;
        $hypothesis->hypo_execution_done_on = $request->hypo_execution_done_on;
        $hypothesis->qc_review_done_by = $request->qc_review_done_by;
        $hypothesis->qc_review_done_on = $request->qc_review_done_on;
        $hypothesis->exp_aqa_review_by = $request->exp_aqa_review_by;
        $hypothesis->exp_aqa_review_on = $request->exp_aqa_review_on;
        $hypothesis->cancel_by = $request->cancel_by;
        $hypothesis->cancel_on = $request->cancel_on;
        $hypothesis->status ='Opened';
        $hypothesis->stage = '1';

        if (!empty ($request->hypothesis_attachment)) {
            $files = [];
            if ($request->hasfile('hypothesis_attachment')) {
                foreach ($request->file('hypothesis_attachment') as $file) {
                    $name = $request->name . 'hypothesis_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $hypothesis->hypothesis_attachment = json_encode($files);
        
        }

        if (!empty($request->aqa_review_attachment)) {
            $files = [];
            if ($request->hasfile('aqa_review_attachment')) {
                foreach ($request->file('aqa_review_attachment') as $file) {
                    $name = $request->name . 'aqa_review_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $hypothesis->aqa_review_attachment = json_encode($files);
        }

        if (!empty($request->hypo_execution_attachment)) {
            $files = [];
            if ($request->hasfile('hypo_execution_attachment')) {
                foreach ($request->file('hypo_execution_attachment') as $file) {
                    $name = $request->name . 'hypo_execution_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $hypothesis->hypo_execution_attachment = json_encode($files);
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
            $hypothesis->qc_review_attachment = json_encode($files);
        }

        if (!empty($request->hypo_exp_aqa_review_attachment)) {
            $files = [];
            if ($request->hasfile('hypo_exp_aqa_review_attachment')) {
                foreach ($request->file('hypo_exp_aqa_review_attachment') as $file) {
                    $name = $request->name . 'hypo_exp_aqa_review_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $hypothesis->hypo_exp_aqa_review_attachment = json_encode($files);
        }

        $hypothesis->save();

//============================gride======================
        $grid_data=$hypothesis->id;

        $info_product_material1=Hypothesis_grid::where(['hypothesis_id'=>$grid_data, 'identifier'=> '(Parent) Product/Material information'])->firstOrNew();
        $info_product_material1->hypothesis_id = $grid_data;
        $info_product_material1->identifier = '(Parent) Product/Material information';
        $info_product_material1->data =$request->parent_info_on_product_material;
        $info_product_material1->save();     
        
// Hypothesis Testing grid 2------------------------------

        $grid_data = $hypothesis->id;
        $hypo_parent_oos_Details = Hypothesis_grid::where(['hypothesis_id' => $grid_data, 'identifier' => '(Parent) OOS Details'])->firstOrNew();
        $hypo_parent_oos_Details->hypothesis_id = $grid_data;
        $hypo_parent_oos_Details->identifier = '(Parent) OOS Details';
        $hypo_parent_oos_Details->data = $request->parent_oos_details;
        $hypo_parent_oos_Details->save();

// Hypothesis Testing grid 3------------------------------

        $grid_data = $hypothesis->id;
        $hypo_parent_oot_Details = Hypothesis_grid::where(['hypothesis_id' => $grid_data, 'identifier' => '(Parent) OOT Results '])->firstOrNew();
        $hypo_parent_oot_Details->hypothesis_id = $grid_data;
        $hypo_parent_oot_Details->identifier = '(Parent) OOT Results ';
        $hypo_parent_oot_Details->data = $request->parent_oot_results;
        $hypo_parent_oot_Details->save();

// Hypothesis Testing grid 4------------------------------

        $grid_data = $hypothesis->id;
        $stability_study = Hypothesis_grid::where(['hypothesis_id' => $grid_data, 'identifier' => '(Parent) Details of Stability Study'])->firstOrNew();
        $stability_study->hypothesis_id = $grid_data;
        $stability_study->identifier = '(Parent) Details of Stability Study';
        $stability_study->data = $request->parent_details_of_stability_study;
        $stability_study->save();
// Hypothesis Testing grid 5------------------------------

        $grid_data = $hypothesis->id;
        $Experiment_details = Hypothesis_grid::where(['hypothesis_id' => $grid_data, 'identifier' => 'Experiment details'])->firstOrNew();
        $Experiment_details->hypothesis_id = $grid_data;
        $Experiment_details->identifier = 'Experiment details';
        $Experiment_details->data = $request->experiment_details;
        $Experiment_details->save();

// Hypothesis Testing grid 6------------------------------

$grid_data = $hypothesis->id;
$Experiment_results = Hypothesis_grid::where(['hypothesis_id' => $grid_data, 'identifier' => 'Experiment results'])->firstOrNew();
$Experiment_results->hypothesis_id = $grid_data;
$Experiment_results->identifier = 'Experiment results';
$Experiment_results->data = $request->experiment_results;
$Experiment_results->save();

// Hypothesis Testing grid 7------------------------------

// $grid_data = $hypothesis->id;
// $Experiment_results = Hypothesis_grid::where(['hypothesis_id' => $grid_data, 'identifier' => 'Experiment results'])->firstOrNew();
// $Experiment_results->hypothesis_id = $grid_data;
// $Experiment_results->identifier = 'Experiment results';
// $Experiment_results->data = $request->experiment_results;
// $Experiment_results->save();






//=======================audit-trail store=========================//

        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();
        
    if(!empty($hypothesis->division_code)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = 'Division Code';
        $history->previous = "Null";
        $history->current = $hypothesis->division_code;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="Initiator";
        $history->change_to ="Opened";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->parent_oos_no)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = '(Parent) OOS No.';
        $history->previous = "Null";
        $history->current = $hypothesis->parent_oos_no;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="Initiator";
        $history->change_to ="Opened";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->parent_oot_no)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = '(Parent) OOT No.';
        $history->previous = "Null";
        $history->current = $hypothesis->parent_oot_no;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="Initiator";
        $history->change_to ="Opened";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->parent_date_opened)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = '(Parent) Date Opened';
        $history->previous = "Null";
        $history->current = $hypothesis->parent_date_opened;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="Initiator";
        $history->change_to ="Opened";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->parent_short_description)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = '(Parent) Short Description';
        $history->previous = "Null";
        $history->current = $hypothesis->parent_short_description;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="Initiator";
        $history->change_to ="Opened";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->parent_target_closure_date)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = '(Parent) Target Closure Date';
        $history->previous = "Null";
        $history->current = $hypothesis->parent_target_closure_date;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="Initiator";
        $history->change_to ="Opened";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->parent_product_material_name)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = '(Parent)Product/Material Name';
        $history->previous = "Null";
        $history->current = $hypothesis->parent_product_material_name;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="Initiator";
        $history->change_to ="Opened";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->record_number)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = 'Record Number';
        $history->previous = "Null";
        $history->current = $hypothesis->record_number;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="Initiator";
        $history->change_to ="Opened";
        $history->action_name ="Submit";        
        $history->save();
        }
    
    if(!empty($hypothesis->initiator)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = 'Initiator';
        $history->previous = "Null";
        $history->current = $hypothesis->division_id;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="Initiator";
        $history->change_to ="Opened";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->intiation_date)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = 'Date of Initiation';
        $history->previous = "Null";
        $history->current = $hypothesis->division_id;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="Initiator";
        $history->change_to ="Opened";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->date_opened)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = 'Date Opened';
        $history->previous = "Null";
        $history->current = $hypothesis->division_id;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="Initiator";
        $history->change_to ="Opened";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->target_closure_date)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = 'Target Closure Date';
        $history->previous = "Null";
        $history->current = $hypothesis->division_id;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="Initiator";
        $history->change_to ="Opened";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->short_description)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = 'Short Description';
        $history->previous = "Null";
        $history->current = $hypothesis->division_id;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="Initiator";
        $history->change_to ="Opened";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->description)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = 'Description';
        $history->previous = "Null";
        $history->current = $hypothesis->division_id;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="Initiator";
        $history->change_to ="Opened";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->qc_approver)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = 'QC Approver';
        $history->previous = "Null";
        $history->current = $hypothesis->division_id;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="Initiator";
        $history->change_to ="Opened";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->qc_comments)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = 'QC Comments';
        $history->previous = "Null";
        $history->current = $hypothesis->division_id;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="QC Approver";
        $history->change_to ="Under Hypothesis QC Proposal";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->assignee)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = 'Assignee';
        $history->previous = "Null";
        $history->current = $hypothesis->division_id;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="QC Approver";
        $history->change_to ="Under Hypothesis QC Proposal";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->aqa_approver)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = 'AQA Approver';
        $history->previous = "Null";
        $history->current = $hypothesis->division_id;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="AQA Approver";
        $history->change_to ="Under Hypothesis QC Proposal";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->hyp_exp_comments)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = 'Hyp./Exp. Comments';
        $history->previous = "Null";
        $history->current = $hypothesis->division_id;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="QC Approver";
        $history->change_to ="Under Hypothesis QC Proposal";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->hypothesis_attachment)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = 'Hypothesis Attachment';
        $history->previous = "Null";
        $history->current = $hypothesis->division_id;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="Assignee";
        $history->change_to ="Under Hypothesis QC Proposal";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->aqa_review_comments)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = 'AQA Review Comments';
        $history->previous = "Null";
        $history->current = $hypothesis->division_id;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="AQA Approver";
        $history->change_to ="Under Hypothesis AQA Review";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->aqa_review_attachment)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = 'AQA Review Attachment';
        $history->previous = "Null";
        $history->current = $hypothesis->division_id;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="AQA Approver";
        $history->change_to ="Under Hypothesis AQA Review";
        $history->action_name ="Submit";        
        $history->save();
        }
    
    if(!empty($hypothesis->summary_of_hypothesis)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = 'Summary of Hypothesis';
        $history->previous = "Null";
        $history->current = $hypothesis->division_id;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="Assigne";
        $history->change_to ="Under Hypothesis Execution";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->delay_justification)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = 'Delay Justification';
        $history->previous = "Null";
        $history->current = $hypothesis->division_id;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="assignee";
        $history->change_to ="Under Hypothesis Execution";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->hypo_execution_attachment)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = 'Hypo.Execution Attachment';
        $history->previous = "Null";
        $history->current = $hypothesis->division_id;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="assignee";
        $history->change_to ="Under Hypothesis Execution";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->hypo_exp_qc_review_comments)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = 'Hypo/Exp QC Review Comments';
        $history->previous = "Null";
        $history->current = $hypothesis->division_id;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="QC Approver";
        $history->change_to ="Under Hypothesis Execution QC Review";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->qc_review_attachment)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = 'QC Review Attachment';
        $history->previous = "Null";
        $history->current = $hypothesis->division_id;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="QC Approver";
        $history->change_to ="Under Hypothesis Execution QC Review";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->hypo_exp_aqa_review_comments)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = 'Hypo/Exp AQA Review comments';
        $history->previous = "Null";
        $history->current = $hypothesis->division_id;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="AQA Approver";
        $history->change_to ="Under Hypothesis Execution AQA Review";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($hypothesis->hypo_exp_aqa_review_attachment)){
        $history = new HypothesisAuditTrial();
        $history->hypothesis_id = $hypothesis->id;
        $history->activity_type = 'Hypo/Exp AQA Review Attachment';
        $history->previous = "Null";
        $history->current = $hypothesis->division_id;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $hypothesis->status;
        $history->change_from ="AQA Approver";
        $history->change_to ="Under Hypothesis Execution AQA Review";
        $history->action_name ="Submit";        
        $history->save();
        }
      
        toastr()->success("Record is created Successfully");
        return redirect(url('rcms/qms-dashboard'));

    }
//--------------------------------------------------------------------------    
    public function show($id)
    {
        // dd('dgfdd');
        $hypothesis = Hypothesis::findOrFail($id);
        // $renewal = Renewal::where(['id',$id])->first();
        
//============================grid=================================================
        // $repo = Hypothesis_grid::where(['hypothesis_id'=> $id , 'identifir'=>'(Parent) Product/Material information'])->first();

        // return view('frontend.newform.hypothesis-view',compact('repo','hypothesis'));

        
        // $hypothesis = Hypothesis_grid::find($id);
        // $hypothesis->record = str_pad($additionaltesting->record, 4, '0', STR_PAD_LEFT);
        // $old_record = Hypothesis_grid::select('id', 'division_id', 'record')->get();
        // $hypothesis->assign_to_name = User::where('id', $additionaltesting->assign_id)->value('name');
        // $hypothesis->initiator_name = User::where('id', $additionaltesting->initiator_id)->value('name');
        // $pre = AdditionalTesting::all();
        // $divisionName = DB::table('q_m_s_divisions')->where('id', $additionaltesting->division_id)->value('name');


        // dd($additionaltesting);
        $gridDatas01 = Hypothesis_grid::where(['hypothesis_id' => $id, 'identifier' => '(Parent) Product/Material information'])->first();
        $gridDatas02 = Hypothesis_grid::where(['hypothesis_id' => $id, 'identifier' => '(Parent) OOS Details'])->first();
        $gridDatas03 = Hypothesis_grid::where(['hypothesis_id' => $id, 'identifier' => '(Parent) OOT Results '])->first();
        $gridDatas04 = Hypothesis_grid::where(['hypothesis_id' => $id, 'identifier' => '(Parent) Details of Stability Study'])->first();
        $gridDatas05 = Hypothesis_grid::where(['hypothesis_id' => $id, 'identifier' => 'Experiment details'])->first();
        $gridDatas06 = Hypothesis_grid::where(['hypothesis_id' => $id, 'identifier' => 'Experiment results'])->first();
        // $gridDatas07 = Hypothesis_grid::where(['hypothesis_id' => $id, 'identifier' => 'Experiment details'])->first();
        return view('frontend.newform.hypothesis-view', compact('hypothesis', 'gridDatas01', 'gridDatas02', 'gridDatas03', 'gridDatas04', 'gridDatas05','gridDatas06'));
    }
    

//--------------------------------------------------------------------------------------------
    public function update(Request $request, $id)
    {
        $lastDocument= Hypothesis::findOrFail($id);
        $hypothesis = Hypothesis::findOrFail($id);

        $hypothesis->parent_oos_no = $request->parent_oos_no;
        $hypothesis->parent_oot_no = $request->parent_oot_no;
        $hypothesis->parent_date_opened = $request->parent_date_opened;
        $hypothesis->parent_short_description = $request->parent_short_description;
        $hypothesis->parent_target_closure_date = $request->parent_target_closure_date;
        $hypothesis->parent_product_material_name = $request->parent_product_material_name;
        $hypothesis->record_number = $request->record_number;
        $hypothesis->division_code = $request->division_code;
        $hypothesis->initiator = $request->initiator;
        $hypothesis->initiation_date = $request->initiation_date;
        $hypothesis->date_opened = $request->date_opened;
        $hypothesis->target_closure_date = $request->target_closure_date;
        $hypothesis->short_description = $request->short_description;
        $hypothesis->description = $request->description;
        $hypothesis->qc_approver = $request->qc_approver;
        $hypothesis->assignee = $request->assignee;
        $hypothesis->qc_comments = $request->qc_comments;
        $hypothesis->aqa_approver = $request->aqa_approver;
        $hypothesis->hyp_exp_comments = $request->hyp_exp_comments;
        $hypothesis->hypothesis_attachment = $request->hypothesis_attachment;
        $hypothesis->aqa_review_comments = $request->aqa_review_comments;
        $hypothesis->aqa_review_attachment = $request->aqa_review_attachment;
        $hypothesis->summary_of_hypothesis = $request->summary_of_hypothesis;
        $hypothesis->delay_justification = $request->delay_justification;
        $hypothesis->hypo_execution_attachment = $request->hypo_execution_attachment;
        $hypothesis->hypo_exp_qc_review_comments = $request->hypo_exp_qc_review_comments;
        $hypothesis->qc_review_attachment = $request->qc_review_attachment;
        $hypothesis->hypo_exp_aqa_review_comments = $request->hypo_exp_aqa_review_comments;
        $hypothesis->hypo_exp_aqa_review_attachment = $request->hypo_exp_aqa_review_attachment;
        $hypothesis->submit_by = $request->submit_by;
        $hypothesis->hypo_proposed_by = $request->hypo_proposed_by;
        $hypothesis->hypo_proposed_on = $request->hypo_proposed_on;
        $hypothesis->hypothesis_proposed_by = $request->hypothesis_proposed_by;
        $hypothesis->hypothesis_proposed_on = $request->hypothesis_proposed_on;
        $hypothesis->aqa_review_compelet_by = $request->aqa_review_compelet_by;
        $hypothesis->aqa_review_compelet_on = $request->aqa_review_compelet_on;
        $hypothesis->hypo_execution_done_by = $request->hypo_execution_done_by;
        $hypothesis->hypo_execution_done_on = $request->hypo_execution_done_on;
        $hypothesis->qc_review_done_by = $request->qc_review_done_by;
        $hypothesis->qc_review_done_on = $request->qc_review_done_on;
        $hypothesis->exp_aqa_review_by = $request->exp_aqa_review_by;
        $hypothesis->exp_aqa_review_on = $request->exp_aqa_review_on;
        $hypothesis->cancel_by = $request->cancel_by;
        $hypothesis->cancel_on = $request->cancel_on;

        if ($request->hasFile('hypothesis_attachment')) {
            // Delete existing files (if any)
            // Implement this logic based on your requirements
            // For example:
            // Storage::delete($renewal->Attached_Files);

            // Upload new files
            $newFiles = [];
            foreach ($request->file('hypothesis_attachment') as $file) {
                $path = $file->store('uploads'); // Adjust the storage path as needed
                $newFiles[] = $path;
            }

                // Update the database record with new file information
            $hypothesis->hypothesis_attachment = json_encode($newFiles);
            
            }

        if ($request->hasFile('aqa_review_attachment')) {
            // Delete existing files (if any)
            // Implement this logic based on your requirements
            // For example:
            // Storage::delete($renewal->Attached_Files);

            // Upload new files
            $newFiles = [];
            foreach ($request->file('aqa_review_attachment') as $file) {
                $path = $file->store('uploads'); // Adjust the storage path as needed
                $newFiles[] = $path;
            }
    
                // Update the database record with new file information
            $hypothesis->aqa_review_attachment = json_encode($newFiles);
                
            }
        if ($request->hasFile('hypo_execution_attachment')) {
            // Delete existing files (if any)
            // Implement this logic based on your requirements
            // For example:
            // Storage::delete($renewal->Attached_Files);

            // Upload new files
            $newFiles = [];
            foreach ($request->file('hypo_execution_attachment') as $file) {
                $path = $file->store('uploads'); // Adjust the storage path as needed
                $newFiles[] = $path;
            }

                // Update the database record with new file information
            $hypothesis->hypo_execution_attachment = json_encode($newFiles);
            
            }
        if ($request->hasFile('qc_review_attachment')) {
            // Delete existing files (if any)
            // Implement this logic based on your requirements
            // For example:
            // Storage::delete($renewal->Attached_Files);

            // Upload new files
            $newFiles = [];
            foreach ($request->file('qc_review_attachment') as $file) {
                $path = $file->store('uploads'); // Adjust the storage path as needed
                $newFiles[] = $path;
            }

                // Update the database record with new file information
            $hypothesis->qc_review_attachment = json_encode($newFiles);
            
            }
        if ($request->hasFile('qc_review_attachment')) {
            // Delete existing files (if any)
            // Implement this logic based on your requirements
            // For example:
            // Storage::delete($renewal->Attached_Files);

            // Upload new files
            $newFiles = [];
            foreach ($request->file('qc_review_attachment') as $file) {
                $path = $file->store('uploads'); // Adjust the storage path as needed
                $newFiles[] = $path;
            }

                // Update the database record with new file information
            $hypothesis->qc_review_attachment = json_encode($newFiles);
            
            }
        if ($request->hasFile('hypo_exp_aqa_review_attachment')) {
            // Delete existing files (if any)
            // Implement this logic based on your requirements
            // For example:
            // Storage::delete($renewal->Attached_Files);

            // Upload new files
            $newFiles = [];
            foreach ($request->file('hypo_exp_aqa_review_attachment') as $file) {
                $path = $file->store('uploads'); // Adjust the storage path as needed
                $newFiles[] = $path;
            }

                // Update the database record with new file information
            $hypothesis->hypo_exp_aqa_review_attachment = json_encode($newFiles);
            
            }
            $hypothesis->update();

        if ($lastDocument->division_code != $hypothesis->division_code || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = 'Division Code';
            $history->previous = $lastDocument->division_code;
            $history->current = $hypothesis->division_code;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->parent_oos_no != $hypothesis->parent_oos_no || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = '(Parent) OOS No.';
            $history->previous = $lastDocument->parent_oos_no;
            $history->current = $hypothesis->parent_oos_no;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->parent_oot_no != $hypothesis->parent_oot_no || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = '(Parent) OOT No.';
            $history->previous = $lastDocument->parent_oot_no;
            $history->current = $hypothesis->parent_oot_no;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->parent_date_opened != $hypothesis->parent_date_opened || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = '(Parent) Date Opened';
            $history->previous = $lastDocument->parent_date_opened;
            $history->current = $hypothesis->parent_date_opened;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->parent_short_description != $hypothesis->parent_short_description || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = '(Parent) Short Description';
            $history->previous = $lastDocument->parent_short_description;
            $history->current = $hypothesis->parent_short_description;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->parent_target_closure_date != $hypothesis->parent_target_closure_date || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = '(Parent) Target Closure Date';
            $history->previous = $lastDocument->parent_target_closure_date;
            $history->current = $hypothesis->parent_target_closure_date;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->parent_product_material_name != $hypothesis->parent_product_material_name || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = '(Parent)Product/Material Name';
            $history->previous = $lastDocument->parent_product_material_name;
            $history->current = $hypothesis->parent_product_material_name;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->record_number != $hypothesis->record_number || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = 'Record Number';
            $history->previous = $lastDocument->record_number;
            $history->current = $hypothesis->record_number;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->division_id != $hypothesis->division_id || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = 'Division Code';
            $history->previous = $lastDocument->division_id;
            $history->current = $hypothesis->division_id;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->intiation_date != $hypothesis->intiation_date || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = 'Date of Initiation';
            $history->previous = $lastDocument->intiation_date;
            $history->current = $hypothesis->intiation_date;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->date_opened != $hypothesis->date_opened || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = 'Date Opened';
            $history->previous = $lastDocument->date_opened;
            $history->current = $hypothesis->date_opened;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->target_closure_date != $hypothesis->target_closure_date || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = 'Target Closure Date';
            $history->previous = $lastDocument->target_closure_date;
            $history->current = $hypothesis->target_closure_date;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->short_description != $hypothesis->short_description || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastDocument->short_description;
            $history->current = $hypothesis->short_description;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->description != $hypothesis->description || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = 'Description';
            $history->previous = $lastDocument->description;
            $history->current = $hypothesis->description;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->qc_approver != $hypothesis->qc_approver || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = 'QC Approver';
            $history->previous = $lastDocument->qc_approver;
            $history->current = $hypothesis->qc_approver;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->qc_comments != $hypothesis->qc_comments || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = 'QC Comments';
            $history->previous = $lastDocument->qc_comments;
            $history->current = $hypothesis->qc_comments;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->assignee != $hypothesis->assignee || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = 'Assignee';
            $history->previous = $lastDocument->assignee;
            $history->current = $hypothesis->assignee;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->aqa_approver != $hypothesis->aqa_approver || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = 'AQA Approver';
            $history->previous = $lastDocument->aqa_approver;
            $history->current = $hypothesis->aqa_approver;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->hyp_exp_comments != $hypothesis->hyp_exp_comments || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = 'Hyp./Exp. Comments';
            $history->previous = $lastDocument->hyp_exp_comments;
            $history->current = $hypothesis->hyp_exp_comments;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->hypothesis_attachment != $hypothesis->hypothesis_attachment || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = 'Hypothesis Attachment';
            $history->previous = $lastDocument->hypothesis_attachment;
            $history->current = $hypothesis->hypothesis_attachment;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->aqa_review_comments != $hypothesis->aqa_review_comments || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = 'AQA Review Comments';
            $history->previous = $lastDocument->aqa_review_comments;
            $history->current = $hypothesis->aqa_review_comments;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->aqa_review_attachment != $hypothesis->aqa_review_attachment || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = 'AQA Review Attachment';
            $history->previous = $lastDocument->aqa_review_attachment;
            $history->current = $hypothesis->aqa_review_attachment;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->experiment_results_body != $hypothesis->experiment_results_body || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = 'Experiment results';
            $history->previous = $lastDocument->experiment_results_body;
            $history->current = $hypothesis->experiment_results_body;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->summary_of_hypothesis != $hypothesis->summary_of_hypothesis || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = 'Summary of Hypothesis';
            $history->previous = $lastDocument->summary_of_hypothesis;
            $history->current = $hypothesis->summary_of_hypothesis;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->delay_justification != $hypothesis->delay_justification || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = 'Delay Justification';
            $history->previous = $lastDocument->delay_justification;
            $history->current = $hypothesis->delay_justification;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->hypo_execution_attachment != $hypothesis->hypo_execution_attachment || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = 'Hypo.Execution Attachment';
            $history->previous = $lastDocument->hypo_execution_attachment;
            $history->current = $hypothesis->hypo_execution_attachment;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->qc_review_attachment != $hypothesis->qc_review_attachment || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = 'QC Review Attachment';
            $history->previous = $lastDocument->qc_review_attachment;
            $history->current = $hypothesis->qc_review_attachment;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->hypo_exp_aqa_review_comments != $hypothesis->hypo_exp_aqa_review_comments || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = 'Hypo/Exp AQA Review comments';
            $history->previous = $lastDocument->hypo_exp_aqa_review_comments;
            $history->current = $hypothesis->hypo_exp_aqa_review_comments;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        if ($lastDocument->hypo_exp_aqa_review_attachment != $hypothesis->hypo_exp_aqa_review_attachment || !empty ($request->comment)) {
            // return 'history';
            $history = new HypothesisAuditTrial;
            $history->hypothesis_id = $id;
            $history->activity_type = 'Hypo/Exp AQA Review Attachment';
            $history->previous = $lastDocument->hypo_exp_aqa_review_attachment;
            $history->current = $hypothesis->hypo_exp_aqa_review_attachment;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->action_name = 'Update';
            $history->save();
            
        }
        // if ($lastDocument->hypo_exp_aqa_review_attachment != $hypothesis->hypo_exp_aqa_review_attachment || !empty ($request->comment)) {
        //     // return 'history';
        //     $history = new HypothesisAuditTrial;
        //     $history->hypothesis_id = $id;
        //     $history->activity_type = 'Hypo/Exp AQA Review Attachment';
        //     $history->previous = $lastDocument->hypo_exp_aqa_review_attachment;
        //     $history->current = $Hypothesis->hypo_exp_aqa_review_attachment;
        //     $history->comment = $request->comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->action_name = 'Update';
        //     $history->save();   
        // }
//=================================grid update========================================//  

        // Additional Testing grid 1------------------------------

        $grid_data = $hypothesis->id;
        $info_product_material1 = Hypothesis_grid::where(['hypothesis_id' => $grid_data, 'identifier' => 'parent info product material1'])->firstOrNew();
        $info_product_material1->hypothesis_id = $grid_data;
        $info_product_material1->identifier = '(Parent) Product/Material information';
        $info_product_material1->data = $request->parent_info_on_product_material;
        $info_product_material1->save();

// Additional Testing grid 2------------------------------

        $grid_data = $hypothesis->id;
        $hypo_parent_oos_Details = Hypothesis_grid::where(['hypothesis_id' => $grid_data, 'identifier' => '(Parent) OOS Details'])->firstOrNew();
        $hypo_parent_oos_Details->hypothesis_id = $grid_data;
        $hypo_parent_oos_Details->identifier = '(Parent) OOS Details ';
        $hypo_parent_oos_Details->data = $request->parent_oos_details;
        $hypo_parent_oos_Details->save();

// Hypothesis Testing grid 3------------------------------

        $grid_data = $hypothesis->id;
        $hypo_parent_oot_Details = Hypothesis_grid::where(['hypothesis_id' => $grid_data, 'identifier' => '(Parent) OOT Results Details'])->firstOrNew();
        $hypo_parent_oot_Details->hypothesis_id = $grid_data;
        $hypo_parent_oot_Details->identifier = '(Parent) OOT Results Details';
        $hypo_parent_oot_Details->data = $request->parent_oot_results;
        $hypo_parent_oot_Details->save();

// Hypothesis Testing grid 4------------------------------

        $grid_data = $hypothesis->id;
        $stability_study = Hypothesis_grid::where(['hypothesis_id' => $grid_data, 'identifier' => '(Parent) Details of Stability Study'])->firstOrNew();
        $stability_study->hypothesis_id = $grid_data;
        $stability_study->identifier = '(Parent) Details of Stability Study';
        $stability_study->data = $request->parent_details_of_stability_study;
        $stability_study->save();


// Hypothesis Testing grid 5------------------------------

        $grid_data = $hypothesis->id;
        $Experiment_details = Hypothesis_grid::where(['hypothesis_id' => $grid_data, 'identifier' => 'Experiment details'])->firstOrNew();
        $Experiment_details->hypothesis_id = $grid_data;
        $Experiment_details->identifier = 'Experiment details';
        $Experiment_details->data = $request->experiment_details;
        $Experiment_details->save();



// Hypothesis Testing grid 6------------------------------

        $grid_data = $hypothesis->id;
        $Experiment_results = Hypothesis_grid::where(['hypothesis_id' => $grid_data, 'identifier' => 'Experiment results'])->firstOrNew();
        $Experiment_results->hypothesis_id = $grid_data;
        $Experiment_results->identifier = 'Experiment results';
        $Experiment_results->data = $request->experiment_results;
        $Experiment_results->save();

// Hypothesis Testing grid 7------------------------------

        $grid_data = $hypothesis->id;
        $Experiment_results = Hypothesis_grid::where(['hypothesis_id' => $grid_data, 'identifier' => 'Experiment results'])->firstOrNew();
        $Experiment_results->hypothesis_id = $grid_data;
        $Experiment_results->identifier = 'Experiment results';
        $Experiment_results->data = $request->experiment_results;
        $Experiment_results->save();

          
    return redirect()->back()->with('success', 'Hypothesis updated successfully!');

    }
//==========================stage==================================//

    public function hypothesis_send_stage(Request $request, $id)
    {


        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $hypo = Hypothesis::find($id);
            $lastDocument =  Hypothesis::find($id);

            if ($hypo->stage == 1) {
                $hypo->stage = "2";
                $hypo->status = "Under Hypothesis QC Proposal";
                $hypo->submit_by= Auth::user()->name;
                $hypo->submit_on= Carbon::now()->format('d-M-Y');
                $history = new HypothesisAuditTrial();
                $history->hypothesis_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->acknowledge_by;
                $history->current = $hypo->acknowledge_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='Plan Proposed';

                $history->save();
            //    $list = Helpers::getQAUserList();
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
                $hypo->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($hypo->stage == 2) {
                $hypo->stage = "3";
                $hypo->status = "Under Hypothesis AQA Review";
                $hypo->aqa_review_by= Auth::user()->name;
                $hypo->aqa_review_on= Carbon::now()->format('d-M-Y');
            //     $history = new RootAuditTrial();
            //     $history->root_id = $id;
            //     $history->activity_type = 'Activity Log';
            //     $history->previous = $lastDocument->acknowledge_by;
            //     $history->current = $root->acknowledge_by;
            //     $history->comment = $request->comment;
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = $lastDocument->status;
            //     $history->stage='Plan Proposed';

            //     $history->save();
            //    $list = Helpers::getQAUserList();
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
                $hypo->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($hypo->stage == 3) {
                $hypo->stage = "4";
                $hypo->status = "Under Hypothesis Execution";
                // $hypo->aqa_review_by= Auth::user()->name;
                // $hypo->aqa_review_on= Carbon::now()->format('d-M-Y');
            //     $history = new RootAuditTrial();
            //     $history->root_id = $id;
            //     $history->activity_type = 'Activity Log';
            //     $history->previous = $lastDocument->acknowledge_by;
            //     $history->current = $root->acknowledge_by;
            //     $history->comment = $request->comment;
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = $lastDocument->status;
            //     $history->stage='Plan Proposed';

            //     $history->save();
            //    $list = Helpers::getQAUserList();
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
                $hypo->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($hypo->stage == 4) {
                $hypo->stage = "5";
                $hypo->status = "Under Hypothesis Execution QC Review";
                // $hypo->aqa_review_by= Auth::user()->name;
                // $hypo->aqa_review_on= Carbon::now()->format('d-M-Y');
            //     $history = new RootAuditTrial();
            //     $history->root_id = $id;
            //     $history->activity_type = 'Activity Log';
            //     $history->previous = $lastDocument->acknowledge_by;
            //     $history->current = $root->acknowledge_by;
            //     $history->comment = $request->comment;
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = $lastDocument->status;
            //     $history->stage='Plan Proposed';

            //     $history->save();
            //    $list = Helpers::getQAUserList();
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
                $hypo->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($hypo->stage == 5) {
                $hypo->stage = "6";
                $hypo->status = "Under Hypothesis Execution AQA Review";
                // $hypo->aqa_review_by= Auth::user()->name;
                // $hypo->aqa_review_on= Carbon::now()->format('d-M-Y');
            //     $history = new RootAuditTrial();
            //     $history->root_id = $id;
            //     $history->activity_type = 'Activity Log';
            //     $history->previous = $lastDocument->acknowledge_by;
            //     $history->current = $root->acknowledge_by;
            //     $history->comment = $request->comment;
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = $lastDocument->status;
            //     $history->stage='Plan Proposed';

            //     $history->save();
            //    $list = Helpers::getQAUserList();
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
                $hypo->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($hypo->stage == 6) {
                $hypo->stage = "7";
                $hypo->status = "Close-Done";
                // $hypo->aqa_review_by= Auth::user()->name;
                // $hypo->aqa_review_on= Carbon::now()->format('d-M-Y');
            //     $history = new RootAuditTrial();
            //     $history->root_id = $id;
            //     $history->activity_type = 'Activity Log';
            //     $history->previous = $lastDocument->acknowledge_by;
            //     $history->current = $root->acknowledge_by;
            //     $history->comment = $request->comment;
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = $lastDocument->status;
            //     $history->stage='Plan Proposed';

            //     $history->save();
            //    $list = Helpers::getQAUserList();
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
                $hypo->update();
                toastr()->success('Document Sent');
                return back();
            }

        }else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }
//===============================backword-stage===============================================//
    public function hypothesis_backword(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $hypo = Hypothesis::find($id);

            if ($hypo->stage == 2) {
                $hypo->stage = "1";
                $hypo->status = "Opened";
                $hypo->submit_by= Auth::user()->name;
                $hypo->submit_on= Carbon::now()->format('d-M-Y');
            //     $history = new RootAuditTrial();
            //     $history->root_id = $id;
            //     $history->activity_type = 'Activity Log';
            //     $history->previous = $lastDocument->acknowledge_by;
            //     $history->current = $root->acknowledge_by;
            //     $history->comment = $request->comment;
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = $lastDocument->status;
            //     $history->stage='Plan Proposed';

            //     $history->save();
            //    $list = Helpers::getQAUserList();
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
                $hypo->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($hypo->stage == 3) {
                $hypo->stage = "2";
                $hypo->status = "Under Hypothesis QC Proposal";
                // $hypo->submit_by= Auth::user()->name;
                // $hypo->submit_on= Carbon::now()->format('d-M-Y');
            //     $history = new RootAuditTrial();
            //     $history->root_id = $id;
            //     $history->activity_type = 'Activity Log';
            //     $history->previous = $lastDocument->acknowledge_by;
            //     $history->current = $root->acknowledge_by;
            //     $history->comment = $request->comment;
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = $lastDocument->status;
            //     $history->stage='Plan Proposed';

            //     $history->save();
            //    $list = Helpers::getQAUserList();
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
                $hypo->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($hypo->stage == 5) {
                $hypo->stage = "4";
                $hypo->status = "Under Hypothesis Execution";
                // $hypo->submit_by= Auth::user()->name;
                // $hypo->submit_on= Carbon::now()->format('d-M-Y');
            //     $history = new RootAuditTrial();
            //     $history->root_id = $id;
            //     $history->activity_type = 'Activity Log';
            //     $history->previous = $lastDocument->acknowledge_by;
            //     $history->current = $root->acknowledge_by;
            //     $history->comment = $request->comment;
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = $lastDocument->status;
            //     $history->stage='Plan Proposed';

            //     $history->save();
            //    $list = Helpers::getQAUserList();
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
                $hypo->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($hypo->stage == 6) {
                $hypo->stage = "4";
                $hypo->status = "Under Hypothesis Execution";
                // $hypo->submit_by= Auth::user()->name;
                // $hypo->submit_on= Carbon::now()->format('d-M-Y');
            //     $history = new RootAuditTrial();
            //     $history->root_id = $id;
            //     $history->activity_type = 'Activity Log';
            //     $history->previous = $lastDocument->acknowledge_by;
            //     $history->current = $root->acknowledge_by;
            //     $history->comment = $request->comment;
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = $lastDocument->status;
            //     $history->stage='Plan Proposed';

            //     $history->save();
            //    $list = Helpers::getQAUserList();
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
                $hypo->update();
                toastr()->success('Document Sent');
                return back();
            }
            
            else {
            toastr()->error('E-signature Not match');
            return back();
        }
        }
    }
//====================CANCEL-STAGE===========================//
    // public function hypothesis_cancel_stage(Request $request, $id ){
    //     if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)){
    //         $renewalstage = Renewal::find($id);
    //         $lastDocument = Renewal::find($id);
                
    //             if ($renewalstage->stage = "0"){
    //                 $renewalstage->status = "Closed-Cancelled";
    //                 $renewalstage->cancelled_by = Auth::user()->name;
    //                 $renewalstage->cancelled_on = Carbon::now()->format('d-M-Y');
    //                 // $renewalstage->cancelled_comment = $request->comment;
    //                 $renewalstage->update();
    //                 toastr()->success('Document Sent');
    //                 return back();
    //             }
    //             if ($renewalstage->stage == 2){
    //                 $renewalstage->stage = "0";
    //                 $renewalstage->status = "Closed-Cancelled";
    //                 $renewalstage->cancelled_by = Auth::user()->name;
    //                 $renewalstage->cancelled_on = Carbon::now()->format('d-M-Y');
    //                 // $renewalstage->cancelled_comment = $request->comment;
    //                 $renewalstage->update();
    //                 toastr()->success('Document Sent');
    //                 return back();
    //             }
    //             else {
    //                 toastr()->error('E-signature Not match');
    //                 return back();
    //             }
    //             }
    //         }
   //========================================================audittrail=============================================//

   public function hypothesisAuditTrial($id)
   {
       $audit = HypothesisAuditTrial::where('hypothesis_id', $id)->orderByDESC('id')->paginate(5);
       $today = Carbon::now()->format('d-m-y');
       $document = Hypothesis::where('id', $id)->first();
       $document->initiator = User::where('id', $document->initiator_id)->value('name');

       return view("frontend.newform.hypothesis.HypothesisAuditTrial", compact('audit', 'document', 'today'));
   }

   //=========================================audit-report===========================================================//
   public static function auditReport($id)
  {
    $doc = Hypothesis::find($id);
    if (!empty($doc)) {
        $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        $data = HypothesisAuditTrial::where('hypothesis_id', $id)->get();
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.newform.hypothesis.hypothesis-audit-report', compact('data', 'doc'))
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

   //======================================single-report===========================================//
   public static function singleReport($id)
   {
       $data = Hypothesis::find($id);
       if ($data !== null) {
           $data->originator_id = User::where('id', $data->initiator_id)->value('name');
           $pdf = App::make('dompdf.wrapper');
           $time = Carbon::now();
           $pdf = PDF::loadView('frontend.newform.hypothesis.hypothesis-single-report', compact('data'))
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
           $canvas->page_script(function($pageNumber, $pageCount, $canvas, $fontMetrics) use ($data, $width, $height) {
               $canvas->set_opacity(0.1, "Multiply");
               $text = $data->status;
               $font = $fontMetrics->get_font("sans-serif", "bold");
               $canvas->text($width / 4, $height / 2, $text, $font, 25, [0, 0, 0]);
           });
           return $pdf->stream('renewal-cause' . $id . '.pdf');
       } else {
           return response()->json(['error' => 'Record not found'], 404);
       }
   }
}
