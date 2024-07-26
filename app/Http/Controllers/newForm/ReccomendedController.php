<?php

namespace App\Http\Controllers\newForm;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecordNumber;
use App\Models\Reccomended_action;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use PDF;
use App\Models\RecommendedAuditTrialDetails;
use App\Models\RoleGroup;
use App\Models\ReccomendedActionGrid;
use App\Models\OOS_Details;

use Illuminate\Support\Facades\App;





class ReccomendedController extends Controller
{


    public function index()
    {
        // $old_record = Reccomended_action::select('id', 'division_id', 'record')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');



        // $registrations = MedicalDeviceRegistration::all();
        return view('frontend.OOS.recommended_action', compact('due_date'));
    }

    public function ReccomendedCreate(Request $request)
    {





        $data = new  Reccomended_action();
        $data->type = "Reccomended_action";
        $data->record = ((RecordNumber::first()->value('counter')) + 1);
        $data->initiator_id = Auth::user()->id;



        // dd($request->all());
        $data->initiator_id = Auth::user()->id;
        $data->division_id = $request->division_id;
        $data->stage = $request->stage;
        $data->status = $request->status;
        // $data->parent_oos_no = $request->parent_oos_no;
        $data->type = "Reccomended_action";

        // $data->record = $request->record;

        $data->parent_oos_no = $request->parent_oos_no;
        $data->due_date = $request->due_date;


        $data->parent_date_opened = $request->parent_date_opened;
        $data->parent_short_desecription = $request->parent_short_desecription;
        $data->target_closure_date = $request->target_closure_date;
        $data->parent_product_material_name = $request->parent_product_material_name;

        $data->date_of_initiation = $request->date_of_initiation;
        $data->division_id = $request->division_id;
        $data->assignee = $request->assignee;
        $data->aqa_approver = $request->aqa_approver;
        $data->supervisor = $request->supervisor;
        $data->recommended_action = $request->recommended_action;
        $data->ustify_recommended_actions = $request->ustify_recommended_actions;
        //=================================================tabes========================================================================

        $data->review_comments = $request->review_comments;
        $data->aqa_review_attachment = $request->aqa_review_attachment;
        $data->summary_of_recommended_actions = $request->summary_of_recommended_actions;
        $data->results_conclusion = $request->results_conclusion;
        $data->delay_justification = $request->delay_justification;
        $data->aqa_review_comments = $request->aqa_review_comments;


        $data->cancellation_request_by = $request->cancellation_request_by;
        $data->cancellation_request_on = $request->cancellation_request_on;
        $data->approver_complete_by = $request->approver_complete_by;
        $data->approver_complete_on = $request->approver_complete_on;
        $data->action_execution_complete_by = $request->action_execution_complete_by;
        $data->action_execution_complete_on = $request->action_execution_complete_on;
        $data->rec_action_execution_by = $request->rec_action_execution_by;
        $data->rec_action_execution_on = $request->rec_action_execution_on;
        $data->ction_execution_review_by = $request->ction_execution_review_by;
        $data->ction_execution_review_on = $request->ction_execution_review_on;

        //====================================Girde Code ========================================================================================

        // return redirect()->back()->with('success',' created successfully!');

        //=====================================OOS_details grid===========================================================


        // return redirect()->back()->with('success',' created successfully!');

        //$data->root_id = $request->root_id;
        //$data->activity_type = $request->activity_type;
        //$data->previous = $request->previous;
        // $data->current = $request->current;
        // $data->comment = $request->comment;
        // $data->user_id = $request->user_id;
        // $data->user_name = $request->user_name;
        // $data->origin_state = $request->origin_state;
        // $data->user_role = $request->user_role;
        // $data->change_from = $request->change_from;
        // $data->change_to = $request->change_to;
        // $data->action_name = $request->action_name;





        if (!empty($request->inv_attachment)) {
            $files = [];

            if ($request->hasfile('inv_attachment')) {
                foreach ($request->file('inv_attachment') as $file) {
                    $name = time() . '_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload'), $name);
                    $files[] = $name;
                }
            }

            $data->inv_attachment = json_encode($files);



        }



        if (!empty($request->inv_attachment_review)) {
            $files = [];

            if ($request->hasfile('inv_attachment_review')) {
                foreach ($request->file('inv_attachment_review') as $file) {
                    $name = time() . '_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload'), $name);
                    $files[] = $name;
                }
            }

            $data->inv_attachment_review = json_encode($files);



        }

        if ($request->hasfile('file_attchment_if_any1')) {
            $files = [];

            foreach ($request->file('file_attchment_if_any1') as $file) {
                $name = time() . '_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload'), $name);
                $files[] = $name;
            }

            $data->file_attchment_if_any1 = json_encode($files);
            $data->save();
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
            $data->aqa_review_attachment = json_encode($files);
        }

        if (!empty($request->execution_attchment_if_any)) {
            $files = [];

            if ($request->hasfile('execution_attchment_if_any')) {
                foreach ($request->file('execution_attchment_if_any') as $file) {
                    $name = time() . '_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload'), $name);
                    $files[] = $name;
                }
            }

            $data->execution_attchment_if_any = json_encode($files);
        }

        if (!empty($request->file_attchment_if1)) {
            $files = [];

            if ($request->hasfile('file_attchment_if1')) {
                foreach ($request->file('file_attchment_if1') as $file) {
                    $name = time() . '_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload'), $name);
                    $files[] = $name;
                }
            }

            $data->file_attchment_if1 = json_encode($files);
        }
                $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();
        $data->status = 'Opened';
        $data->stage = 1;
        $data->save();
        //  dd($data);


if (!empty($data->parent_short_desecription)) {
            $history = new RecommendedAuditTrialDetails();
            $history->root_id = $data->id;
            $history->activity_type = '(Parent) Short Desecription';
            $history->previous = "Null";
            $history->current = $data->short_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_from = "Initiation";
            $history->change_to = "Opened";
            $history->action_name = "Create";
            $history->save();
        }



        if (!empty($data->assignee)) {
            $history = new RecommendedAuditTrialDetails();
            $history->root_id = $data->id;
            $history->activity_type = 'Assignee';
            $history->previous = "Null";
            $history->current = $data->assign_to;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_from = "Initiation";
            $history->change_to = "Opened";
            $history->action_name = "Create";
            $history->save();
        }




        if (!empty($data->parent_date_opened)) {
            $history = new RecommendedAuditTrialDetails();
            $history->root_id = $data->id;
            $history->activity_type = '(Parent) Date Opened';
            $history->previous = "Null";
            $history->current = $data->parent_date_opened;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_from = "Initiation";
            $history->change_to = "Opened";
            $history->action_name = "Create";
            $history->save();
        }



        if (!empty($data->target_closure_date)) {
            $history = new RecommendedAuditTrialDetails();
            $history->root_id = $data->id;
            $history->activity_type = '(Parent) Target Closure Date';
            $history->previous = "Null";
            $history->current = $data->target_closure_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_from = "Initiation";
            $history->change_to = "Opened";
            $history->action_name = "Create";
            $history->save();
        }




        if (!empty($data->parent_product_material_name)) {
            $history = new RecommendedAuditTrialDetails();
            $history->root_id = $data->id;
            $history->activity_type = '(Parent) Product/Material Name';
            $history->previous = "Null";
            $history->current = $data->parent_product_material_name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_from = "Initiation";
            $history->change_to = "Opened";
            $history->action_name = "Create";
            $history->save();
        }
        if (!empty($data->aqa_approver)) {
            $history = new RecommendedAuditTrialDetails();
            $history->root_id = $data->id;
            $history->activity_type = 'AQA Approver';
            $history->previous = "Null";
            $history->current = $data->aqa_approver;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_from = "Initiation";
            $history->change_to = "Opened";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($data->supervisor)) {
            $history = new RecommendedAuditTrialDetails();
            $history->root_id = $data->id;
            $history->activity_type = 'Supervisor';
            $history->previous = "Null";
            $history->current = $data->supervisor;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_from = "Initiation";
            $history->change_to = "Opened";
            $history->action_name = "Create";
            $history->save();
        }
        if (!empty($data->recommended_action)) {
            $history = new RecommendedAuditTrialDetails();
            $history->root_id = $data->id;
            $history->activity_type = 'Recommended Action';
            $history->previous = "Null";
            $history->current = $data->recommended_action;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_from = "Initiation";
            $history->change_to = "Opened";
            $history->action_name = "Create";
            $history->save();
        }
        if (!empty($data->ustify_recommended_actions)) {
            $history = new RecommendedAuditTrialDetails();
            $history->root_id = $data->id;
            $history->activity_type = 'Justify-Recommended Actions';
            $history->previous = "Null";
            $history->current = $data->ustify_recommended_actions;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_from = "Initiation";
            $history->change_to = "Opened";
            $history->action_name = "Create";
            $history->save();
        }
        if (!empty($data->review_comments)) {
            $history = new RecommendedAuditTrialDetails();
            $history->root_id = $data->id;
            $history->activity_type = 'AQA Review Comments';
            $history->previous = "Null";
            $history->current = $data->review_comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_from = "Initiation";
            $history->change_to = "Opened";
            $history->action_name = "Create";
            $history->save();
        }
        if (!empty($data->aqa_review_attachment)) {
            $history = new RecommendedAuditTrialDetails();
            $history->root_id = $data->id;
            $history->activity_type = ' AQA Review Attachment';
            $history->previous = "Null";
            $history->current = $data->aqa_review_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_from = "Initiation";
            $history->change_to = "Opened";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($data->summary_of_recommended_actions)) {
            $history = new RecommendedAuditTrialDetails();
            $history->root_id = $data->id;
            $history->activity_type = 'Summary of Rec.Actions';
            $history->previous = "Null";
            $history->current = $data->summary_of_recommended_actions;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_from = "Initiation";
            $history->change_to = "Opened";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($data->results_conclusion)) {
            $history = new RecommendedAuditTrialDetails();
            $history->root_id = $data->id;
            $history->activity_type = 'Results & Conclusion';
            $history->previous = "Null";
            $history->current = $data->results_conclusion;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_from = "Initiation";
            $history->change_to = "Opened";
            $history->action_name = "Create";
            $history->save();
        }
        if (!empty($data->delay_justification)) {
            $history = new RecommendedAuditTrialDetails();
            $history->root_id = $data->id;
            $history->activity_type = 'Delay Justification';
            $history->previous = "Null";
            $history->current = $data->delay_justification;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_from = "Initiation";
            $history->change_to = "Opened";
            $history->action_name = "Create";
            $history->save();
        }
        if (!empty($data->execution_attchment_if_any)) {
            $history = new RecommendedAuditTrialDetails();
            $history->root_id = $data->id;
            $history->activity_type = 'Execution Attachment';
            $history->previous = "Null";
            $history->current = $data->execution_attchment_if_any;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_from = "Initiation";
            $history->change_to = "Opened";
            $history->action_name = "Create";
            $history->save();
        }
        if (!empty($data->file_attchment_if_any1)) {
            $history = new RecommendedAuditTrialDetails();
            $history->root_id = $data->id;
            $history->activity_type = 'File Attechment';
            $history->previous = "Null";
            $history->current = $data->file_attchment_if_any1;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
            $history->change_from = "Initiation";
            $history->change_to = "Opened";
            $history->action_name = "Create";
            $history->save();
        }




        $rgridId = $data->id;

        $rgrid = ReccomendedActionGrid::where(['root_id' => $rgridId, 'indentifir' => 'parent_info_on_product_material'])->firstOrNew();
        $rgrid->root_id = $rgridId;
        $rgrid->indentifir = 'parent_info_on_product_material';
        $rgrid->data = $request->parent_info_on_product_material;


        $rgrid->save();

        // dd($rgrid);


        $rgrids2 = $data->id;

        $rgrid = ReccomendedActionGrid::where(['root_id' => $rgrids2, 'indentifir' => 'OOS_Details'])->firstOrNew();
        $rgrid->root_id = $rgrids2;
        $rgrid->indentifir = 'OOS_Details';
        $rgrid->data = $request->parent_oos_details;
        $rgrid->save();


        $rgrids3 = $data->id;

        $rgrid = ReccomendedActionGrid::where(['root_id' => $rgrids3, 'indentifir' => 'parent_oot_results'])->firstOrNew();
        $rgrid->root_id = $rgrids3;
        $rgrid->indentifir = 'parent_oot_results';
        $rgrid->data = $request->parent_oot_results;
        $rgrid->save();


        $rgrids4 = $data->id;

        $rgrid = ReccomendedActionGrid::where(['root_id' => $rgrids4, 'indentifir' => 'Pack_Details'])->firstOrNew();
        $rgrid->root_id = $rgrids4;
        $rgrid->indentifir = 'Pack_Details';
        $rgrid->data = $request->parent_details_of_stability_study;
        $rgrid->save();

        toastr()->success("Recomended Action is created succusfully");
        return redirect(url('rcms/qms-dashboard'));
    }

    public function ReccomendationShow($id)
    {

        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');

        $data = Reccomended_action::find($id);
        //dd($data);

        $rgridId = $data->id;

        $rgrid = ReccomendedActionGrid::where(['root_id' => $rgridId, 'indentifir' => 'parent_info_on_product_material'])->first();


        $rgrids2 = $data->id;

        $secoundgrid = ReccomendedActionGrid::where(['root_id' => $rgrids2, 'indentifir' => 'OOS_Details'])->first();
        //dd(  $secoundgrid);



        $rgrids3 = $data->id;

        $thirdgrid = ReccomendedActionGrid::where(['root_id' => $rgrids3, 'indentifir' => 'parent_oot_results'])->first();


        $rgrids4 = $data->id;

        $fourthgrid = ReccomendedActionGrid::where(['root_id' => $rgrids4, 'indentifir' => 'Pack_Details'])->first();

        //dd( $thirdgrid);
        // dd($rgrid);
        // $audit =QualityFollowup::where('parent_id', $id)->orderByDESC('id')->get()->unique('activity_type');
        $today = Carbon::now()->format('d-m-y');
        //  $document = Reccomended_action::where('id', $id)->first();
        //   $old_record = Reccomended_action::select('id', 'division_id', 'record_number')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');

        //  $document->initiator = User::where('id', $document->initiator_id)->value('name');
        return view('frontend.Reccomendation_action.reccomendation_view',  compact('data', 'record_number', 'formattedDate', 'currentDate', 'due_date', 'rgrid', 'thirdgrid', 'secoundgrid', 'fourthgrid'));
    }


    public function ReccomendedUpdate(Request $request, $id)
    {
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');

        $lastData =   Reccomended_action::find($id);
        $data =   Reccomended_action::find($id);

        $data->initiator_id = Auth::user()->id;
        $data->division_id = $request->division_id;
        // $data->stage = $request->stage;
        // $data->status = $request->status;
        //  $data->parent_oos_no = $request->parent_oos_no;
        // $data->type = "Reccomended_action";

        // $data->record = $request->record;

        $data->parent_date_opened = $request->parent_date_opened;
        $data->due_date = $request->due_date;
        $data->parent_short_desecription = $request->parent_short_desecription;
        $data->target_closure_date = $request->target_closure_date;
        $data->parent_product_material_name = $request->parent_product_material_name;

        $data->date_of_initiation = $request->date_of_initiation;
        $data->division_id = $request->division_id;
        $data->assignee = $request->assignee;
        $data->aqa_approver = $request->aqa_approver;
        $data->supervisor = $request->supervisor;
        $data->recommended_action = $request->recommended_action;
        $data->ustify_recommended_actions = $request->ustify_recommended_actions;

        //=========================================Tabes========================================================================

        $data->aqa_review_comments = $request->aqa_review_comments;
        $data->review_comments = $request->review_comments;

       // $data->aqa_review_attachment = $request->aqa_review_attachment;
        $data->summary_of_recommended_actions = $request->summary_of_recommended_actions;
        $data->results_conclusion = $request->results_conclusion;
        $data->delay_justification = $request->delay_justification;


        $rgridId = $data->id;
        // dd($data->id);

        $rgrid = ReccomendedActionGrid::where(['root_id' => $rgridId, 'indentifir' => 'parent_info_on_product_material'])->firstOrNew();
        $rgrid->root_id = $rgridId;
        $rgrid->indentifir = 'parent_info_on_product_material';
        $rgrid->data = $request->parent_info_on_product_material;
        $rgrid->save();


        $rgrids2 = $data->id;

        $rgrid = ReccomendedActionGrid::where(['root_id' => $rgrids2, 'indentifir' => 'OOS_Details'])->firstOrNew();
        $rgrid->root_id = $rgrids2;
        $rgrid->indentifir = 'OOS_Details';
        $rgrid->data = $request->parent_oos_details;
        $rgrid->save();


        $rgrids3 = $data->id;

        $rgrid = ReccomendedActionGrid::where(['root_id' => $rgrids3, 'indentifir' => 'parent_oot_results'])->firstOrNew();
        $rgrid->root_id = $rgrids3;
        $rgrid->indentifir = 'parent_oot_results';
        $rgrid->data = $request->parent_oot_results;
        $rgrid->save();


        $rgrids4 = $data->id;

        $rgrid = ReccomendedActionGrid::where(['root_id' => $rgrids4, 'indentifir' => 'Pack_Details'])->firstOrNew();
        $rgrid->root_id = $rgrids4;
        $rgrid->indentifir = 'Pack_Details';
        $rgrid->data = $request->parent_details_of_stability_study;
        $rgrid->save();















        // if ($request->hasfile('attach_files1')) {
        //     $image = $request->file('attach_files1');
        //     $ext = $image->getClientOriginalExtension();
        //     $image_name = date('y-m-d') . '-' . rand() . '.' . $ext;
        //     $image->move('upload/document/', $image_name);
        //     $data->attach_files1 = $image_name;
        // }


        if (!empty($request->inv_attachment_review)) {
            $files = [];

            if ($request->hasfile('inv_attachment_review')) {
                foreach ($request->file('inv_attachment_review') as $file) {
                    $name = time() . '_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload'), $name);
                    $files[] = $name;
                }
            }

            $data->inv_attachment_review = json_encode($files);



        }


        if (!empty($request->inv_attachment)) {
            $files = [];

            if ($request->hasfile('inv_attachment')) {
                foreach ($request->file('inv_attachment') as $file) {
                    $name = time() . '_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload'), $name);
                    $files[] = $name;
                }
            }

            $data->inv_attachment = json_encode($files);
        }




            if ($request->hasFile('file_attachment')) {
                // Delete existing files (if any)
                // Implement this logic based on your requirements
                // For example:
                // Storage::delete($renewal->Attached_Files);

                // Upload new files
                $newFiles = [];
                foreach ($request->file('file_attachment') as $file) {
                    $path = $file->store('uploads'); // Adjust the storage path as needed
                    $newFiles[] = $path;
                }

                // Update the database record with new file information
                $data->file_attachment = json_encode($newFiles);
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
                $data->aqa_review_attachment = json_encode($files);
            }

            if (!empty($request->execution_attchment_if_any)) {
                $files = [];

                if ($request->hasfile('execution_attchment_if_any')) {
                    foreach ($request->file('execution_attchment_if_any') as $file) {
                        $name = time() . '_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('upload'), $name);
                        $files[] = $name;
                    }
                }

                $data->execution_attchment_if_any = json_encode($files);
            }
            if ($request->hasFile('file_attchment_if_any1')) {
                $files = [];

                foreach ($request->file('file_attchment_if_any1') as $file) {
                    // Generate a unique file name
                    $name = time() . '_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    // Move the file to the 'upload' directory
                    $file->move(public_path('upload'), $name);
                    // Add the file name to the array
                    $files[] = $name;
                }

                // Convert the array of file names to JSON and save it
                $data->file_attchment_if_any1 = json_encode($files);
                $data->save(); // Don't forget to save the changes to the database
            }





            if (!empty($request->file_attchment_if1)) {
                $files = [];

                if ($request->hasfile('file_attchment_if1')) {
                    foreach ($request->file('file_attchment_if1') as $file) {
                        $name = time() . '_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('upload'), $name);
                        $files[] = $name;
                    }
                }

                $data->file_attchment_if1 = json_encode($files);
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

            // $data->status = 'Opened';
            // $data->stage = 1;
            $data->update();


            // if ($lastData->division_id != $data->initiated_by || !empty($request->comment)) {
            //     // return 'history';
            //     $history = new RecommendedAuditTrialDetails;
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
            // }

            if ($lastData->short_description != $data->short_description || ! empty($request->short_description_comment)) {
              $lastDataAudittrail  = RecommendedAuditTrialDetails::where('root_id', $data->id)
                    ->where('activity_type', 'parent_short_desecription')
                    ->exists();                // return 'history';
                $history = new RecommendedAuditTrialDetails;
                $history->root_id = $id;
                $history->activity_type = 'parent_short_desecription';
                $history->previous = $lastData->parent_short_desecription;
                $history->current = $data->parent_short_desecription;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to =   "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
                $history->save();
            }
          // return 'history';
            //     $history = new RecommendedAuditTrialDetails;
            //     $history->root_id = $id;
            //     $history->activity_type = '(Parent) Target Closure Date';
            //     $history->previous = $lastData->target_closure_date;
            //     $history->current = $data->target_closure_date;
            //     $history->comment = $request->comment;
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = $lastData->status;
            //     $history->change_to =   "Not Applicable";
            //     $history->change_from = $lastData->status;
            //     $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
            //     $history->save();
            // }


                if ($lastData->initiator_id!= $data->initiator_id|| ! empty($request->initiator_id_comment)) {
                    $lastDataAudittrail  = RecommendedAuditTrialDetails::where('root_id', $data->id)
                        ->where('activity_type', 'Initiator')
                        ->exists();
                // return 'history';
                $history = new  RecommendedAuditTrialDetails;
                $history->root_id = $id;
                $history->activity_type = 'Initiator';
                $history->previous = $lastData->initiator_id;
                $history->current = $data->initiator_id;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to =   "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
                $history->save();
            }

            // if ($lastData->date_of_initiation != $data->date_of_initiation || !empty($request->comment)) {

            //     // return 'history';
            //     $history = new  RecommendedAuditTrialDetails;
            //     $history->root_id = $id;
            //     $history->activity_type = 'Date Of Initiation';
            //     $history->previous = $lastData->date_of_initiation;
            //     $history->current = $data->date_of_initiation;
            //     $history->comment = $request->comment;
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = $lastData->status;
            //     $history->change_to =   "Not Applicable";
            //     $history->change_from = $lastData->status;
            //     $history->action_name = 'Update';
            //     $history->save();
            // }


                if ($lastData->parent_product_material_name!= $data->parent_product_material_name|| ! empty($request->parent_product_material_name_comment)) {
                    $lastDataAudittrail  = RecommendedAuditTrialDetails::where('root_id', $data->id)
                        ->where('activity_type', '(Parent) Product/Material Name')
                        ->exists();
                // return 'history';
                $history = new  RecommendedAuditTrialDetails;
                $history->root_id = $id;
                $history->activity_type = '(Parent) Product/Material Name';
                $history->previous = $lastData->parent_product_material_name;
                $history->current = $data->parent_product_material_name;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to =   "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
                $history->save();
            }


                if ($lastData->assignee!= $data->assignee|| ! empty($request->comment)) {
                    $lastDataAudittrail  = RecommendedAuditTrialDetails::where('root_id', $data->id)
                        ->where('activity_type', 'Assignee')
                        ->exists();
                // return 'history';
                $history = new RecommendedAuditTrialDetails;
                $history->root_id = $id;
                $history->activity_type = 'Assignee';
                $history->previous = $lastData->assignee;
                $history->current = $data->assignee;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to =   "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
                $history->save();
            }

            if ($lastData->aqa_approver != $data->aqa_approver || !empty($request->comment)) {

                if ($lastData->aqa_approver!= $data->aqa_approver|| ! empty($request->aqa_approver_comment)) {
                    $lastDataAudittrail  = RecommendedAuditTrialDetails::where('root_id', $data->id)
                        ->where('activity_type', 'AQA Approver')
                        ->exists();
                // return 'history';
                $history = new  RecommendedAuditTrialDetails;
                $history->root_id = $id;
                $history->activity_type = 'AQA Approver';
                $history->previous = $lastData->aqa_approver;
                $history->current = $data->aqa_approver;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to =   "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
                $history->save();
            }


                if ($lastData->supervisor!= $data->supervisor|| ! empty($request->supervisor_comment)) {
                    $lastDataAudittrail  = RecommendedAuditTrialDetails::where('root_id', $data->id)
                        ->where('activity_type', 'Supervisor')
                        ->exists();
                // return 'history';
                $history = new  RecommendedAuditTrialDetails;
                $history->root_id = $id;
                $history->activity_type = 'Supervisor';
                $history->previous = $lastData->supervisor;
                $history->current = $data->supervisor;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to =   "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
                $history->save();
            }


            if ($lastData->inv_attachment_review!= $data->inv_attachment_review|| ! empty($request->inv_attachment_review_comment)) {
                $lastDataAudittrail  = RecommendedAuditTrialDetails::where('root_id', $data->id)
                    ->where('activity_type', 'AQA Review Attachment')
                    ->exists();
            // return 'history';
            $history = new  RecommendedAuditTrialDetails;
            $history->root_id = $id;
            $history->activity_type = 'AQA Review Attachment';
            $history->previous = $lastData->inv_attachment_review;
            $history->current = $data->inv_attachment_review;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
            $history->save();
        }

                if ($lastData->recommended_action!= $data->recommended_action|| ! empty($request->recommended_action_comment)) {
                    $lastDataAudittrail  = RecommendedAuditTrialDetails::where('root_id', $data->id)
                        ->where('activity_type', 'Recommended Action')
                        ->exists();
                // return 'history';
                $history = new RecommendedAuditTrialDetails;
                $history->root_id = $id;
                $history->activity_type = 'Recommended Action';
                $history->previous = $lastData->recommended_action;
                $history->current = $data->recommended_action;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to =   "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
                $history->save();
            }

            // if ($lastData->ustify_recommended_actions != $data->ustify_recommended_actions || !empty ($request->comment)) {
            //     // return 'history';
            //     $history = new RecommendedAuditTrialDetails;
            //     $history->root_id = $id;
            //     $history->activity_type = 'Comments';
            //     $history->previous = $lastData->ustify_recommended_actions;
            //     $history->current = $data->ustify_recommended_actions;
            //     $history->comment = $request->comment;
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = $lastData->status;
            //     $history->change_to =   "Not Applicable";
            //     $history->change_from = $lastData->status;
            //     $history->action_name = 'Update';
            //     $history->save();
            // }

            // if ($lastData->stage != $data->stage || !empty($request->comment)) {

            //     // return 'history';
            //     $history = new RecommendedAuditTrialDetails;
            //     $history->root_id = $id;
            //     $history->activity_type = 'Scheduled Start Date';
            //     $history->previous = $lastData->stage;
            //     $history->current = $data->stage;
            //     $history->comment = $request->comment;
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = $lastData->status;
            //     $history->change_to =   "Not Applicable";
            //     $history->change_from = $lastData->status;
            //     $history->action_name = 'Update';
            //     $history->save();
            // }

            // if ($lastData->status != $data->status || !empty($request->comment)) {
            //     // return 'history';
            //     $history = new RecommendedAuditTrialDetails;
            //     $history->root_id = $id;
            //     $history->activity_type = 'Status';
            //     $history->previous = $lastData->status;
            //     $history->current = $data->status;
            //     $history->comment = $request->comment;
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = $lastData->status;
            //     $history->change_to =   "Not Applicable";
            //     $history->change_from = $lastData->status;
            //     $history->action_name = 'Update';
            //     $history->save();
            // }

                if ($lastData->aqa_review_comments!= $data->aqa_review_comments|| ! empty($request->aqa_review_comments_comment)) {
                    $lastDataAudittrail  = RecommendedAuditTrialDetails::where('root_id', $data->id)
                        ->where('activity_type', 'AQA Review Comments')
                        ->exists();
                // return 'history';
                $history = new RecommendedAuditTrialDetails;
                $history->root_id = $id;
                $history->activity_type = 'AQA Review Comments';
                $history->previous = $lastData->review_comments;
                $history->current = $data->review_comments;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to =   "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
                $history->save();
            }



                    if ($lastData->aqa_review_attachment!= $data->aqa_review_attachment|| ! empty($request->aqa_review_attachment_comment)) {
                        $lastDataAudittrail  = RecommendedAuditTrialDetails::where('root_id', $data->id)
                            ->where('activity_type', 'AQA Review Attachment')
                            ->exists();
                // return 'history';
                $history = new RecommendedAuditTrialDetails;
                $history->root_id = $id;
                $history->activity_type = 'AQA Review Attachment';
                $history->previous = $lastData->aqa_review_attachment;
                $history->current = $data->aqa_review_attachment;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to =   "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
                $history->save();
            }


                if ($lastData->summary_of_recommended_actions!= $data->summary_of_recommended_actions|| ! empty($request->comment)) {
                    $lastDataAudittrail  = RecommendedAuditTrialDetails::where('root_id', $data->id)
                        ->where('activity_type', 'Action Execution Comments')
                        ->exists();
                // return 'history';
                $history = new RecommendedAuditTrialDetails;
                $history->root_id = $id;
                $history->activity_type = 'Action Execution Comments';
                $history->previous = $lastData->summary_of_recommended_actions;
                $history->current = $data->summary_of_recommended_actions;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to =   "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name = 'Update';
                $history->save();
            }

                if ($lastData->results_conclusion!= $data->results_conclusion|| ! empty($request->comment)) {
                    $lastDataAudittrail  = RecommendedAuditTrialDetails::where('root_id', $data->id)
                        ->where('activity_type', 'Quality Follow Up Summary')
                        ->exists();
                // return 'history';
                $history = new RecommendedAuditTrialDetails;
                $history->root_id = $id;
                $history->activity_type = ' Quality Follow Up Summary';
                $history->previous = $lastData->results_conclusion;
                $history->current = $data->results_conclusion;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to =   "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name = 'Update';
                $history->save();
            }


                if ($lastData->delay_justification!= $data->delay_justification|| ! empty($request->comment)) {
                    $lastDataAudittrail  = RecommendedAuditTrialDetails::where('root_id', $data->id)
                        ->where('activity_type', 'Delay Justification')
                        ->exists();
                // return 'history';
                $history = new RecommendedAuditTrialDetails;
                $history->root_id = $id;
                $history->activity_type = ' Delay Justification';
                $history->previous = $lastData->delay_justification;
                $history->current = $data->delay_justification;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to =   "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name = 'Update';
                $history->save();
            }
                if ($lastData->execution_attchment_if_any!= $data->execution_attchment_if_any|| ! empty($request->comment)) {
                    $lastDataAudittrail  = RecommendedAuditTrialDetails::where('root_id', $data->id)
                        ->where('activity_type', 'Execution Attachment')
                        ->exists();
                // return 'history';
                $history = new RecommendedAuditTrialDetails;
                $history->root_id = $id;
                $history->activity_type = ' Execution Attachment';
                $history->previous = $lastData->execution_attchment_if_any;
                $history->current = $data->execution_attchment_if_any;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to =   "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name = 'Update';
                $history->save();
            }

                if ($lastData->file_attchment_if_any1!= $data->file_attchment_if_any1|| ! empty($request->comment)) {
                    $lastDataAudittrail  = RecommendedAuditTrialDetails::where('root_id', $data->id)
                        ->where('activity_type', 'Execution Attachment')
                        ->exists();
                // return 'history';
                $history = new RecommendedAuditTrialDetails;
                $history->root_id = $id;
                $history->activity_type = ' File Attechment';
                $history->previous = $lastData->file_attchment_if_any1;
                $history->current = $data->file_attchment_if_any1;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to =   "Not Applicable";
                $history->change_from = $lastData->status;
                $history->action_name = 'Update';
                $history->save();
            }

            $rgridId = $data->id;
            // dd($data->id);

            $rgrid = ReccomendedActionGrid::where(['root_id' => $rgridId, 'indentifir' => 'parent_info_on_product_material'])->firstOrNew();
            $rgrid->root_id = $rgridId;
            $rgrid->indentifir = 'parent_info_on_product_material';

            $rgrid->data = $request->parent_info_on_product_material;
            // dd( $rgrid);
            $rgrid->save();


            $rgrids2 = $data->id;

            $rgrid = ReccomendedActionGrid::where(['root_id' => $rgrids2, 'indentifir' => 'OOS_Details'])->firstOrNew();
            $rgrid->root_id = $rgrids2;
            $rgrid->indentifir = 'OOS_Details';
            $rgrid->data = $request->parent_oos_details;
            $rgrid->save();


            $rgrids3 = $data->id;

            $rgrid = ReccomendedActionGrid::where(['root_id' => $rgrids3, 'indentifir' => 'parent_oot_results'])->firstOrNew();
            $rgrid->root_id = $rgrids3;
            $rgrid->indentifir = 'parent_oot_results';
            $rgrid->data = $request->parent_oot_results;
            $rgrid->save();


            $rgrids4 = $data->id;

            $rgrid = ReccomendedActionGrid::where(['root_id' => $rgrids4, 'indentifir' => 'Pack_Details'])->firstOrNew();
            $rgrid->root_id = $rgrids4;
            $rgrid->indentifir = 'Pack_Details';
            $rgrid->data = $request->parent_details_of_stability_study;
            $rgrid->save();
        }
            toastr()->success("Reccomended Action  is Updated succusfully");
            return back();

    }



    public function reccomended_send_stage(Request $request, $id)
    {


        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $data = Reccomended_action::find($id);
            $lastData = Reccomended_action::find($id);

            if ($data->stage == 1) {
                $data->stage = "2";
                $data->status = "Rec. Action Review by AQA Approver";
                $data->cancellation_request_by = Auth::user()->name;
                $data->cancellation_request_on = Carbon::now()->format('d-M-Y');
                $history = new RecommendedAuditTrialDetails();
                $history->root_id = $id;
                $history->activity_type = 'Activity log';
                $history->previous = $lastData->cancellation_request_by;
                $history->current = $data->cancellation_request_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state =$lastData->status;
                $history->change_from = $lastData->status;
                $history->change_to = "Rec. Action Review by AQA Approver";
                $history->action = "Submit";
                $history->action_name = "Not Applicable";
                $history->stage= "Submit";

                // $history->stage = 'Submited';

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
                $data->status = 'Recommendation Action Execution';

                // $data->more_info_by = Auth::user()->name;
                // $data->more_info_on = Carbon::now()->format('d-M-Y');


                $data->approver_complete_by = Auth::user()->name;
                $data->approver_complete_on = Carbon::now()->format('d-M-Y');

                $history = new RecommendedAuditTrialDetails();
                $history->root_id = $id;
                $history->activity_type = 'Activity log';
                $history->previous =$lastData->more_info_by;
                $history->current = $data->more_info_by;

                $history->previous = $lastData->approver_complete_by;
                $history->previous = $lastData->approver_complete_by;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->origin_state = $data->status;
                $history->change_from = $lastData->status;
                $history->change_to = "Recommendation Action Execution";
                $history->action = "Not Applicable";
                $history->action_name = "Submit";
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
                //   }
                $data->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($data->stage == 3) {
                $data->stage = "4";
                $data->status = "Recommendation Action Execution Review";
                $data->action_execution_complete_by = Auth::user()->name;
                $data->action_execution_complete_on = Carbon::now()->format('d-M-Y');
                $history = new RecommendedAuditTrialDetails();
                $history->root_id = $id;
                $history->activity_type = 'Recommendation Action Execution Review';
                $history->previous = $lastData->action_execution_complete_by;
                $history->current = $data->action_execution_complete_by;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_from =$lastData->status;
                $history->change_to = "Recommendation Action Execution Review";
                $history->action = "Not Applicable";
                $history->action_name = "Submit";
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
                $data->stage = "5";
                $data->status = 'Closed - Done';
                $data->rec_action_execution_by = Auth::user()->name;
                $data->rec_action_execution_on = Carbon::now()->format('d-M-Y');

                $data->ction_execution_review_by = Auth::user()->name;
                $data->ction_execution_review_on = Carbon::now()->format('d-M-Y');
                $history = new RecommendedAuditTrialDetails();
                $history->root_id = $id;
                $history->activity_type = 'Closed - Done';
                $history->previous = $lastData->rec_action_execution_by;
                $history->current = $data->rec_action_execution_by;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_from = $lastData->status;
                $history->change_to = "Closed - Done";
                $history->action = "Not Applicable";
                $history->action_name = "Submit";
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
                //   }
                $data->update();
                toastr()->success('Document Sent');
                return back();

                // if ($data->stage == 5)
                //     $data->stage = "6";
                //     $data->status = "QA Approve Review";
                //     $data->qA_review_complete_by = Auth::user()->name;
                // $data->qA_review_complete_on = Carbon::now()->format('d-M-Y');
                // $history = new ProductionValidationTrail();
                // $history->root_id = $id;
                // $history->activity_type = 'Activity Log';
                // $history->previous = $lastDocument->qA_review_complete_by;
                // $history->current = $root->qA_review_complete_by;
                // $history->comment = $request->comment;
                // $history->user_id = Auth::user()->id;
                // $history->user_name = Auth::user()->name;
                // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                // $history->origin_state = $lastDocument->status;
                // $history->origin_state = $data->status;
                // $history->change_from ="Initiator";
                // $history->change_to ="Opened";
                // $history->stage='Submit';
                // $history->save();


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
            $data->update();
            toastr()->success('Document Sent');
            return back();
        }
    }


    public function renewal_forword2(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $data = Reccomended_action::find($id);
            $lastData = Reccomended_action::find($id);

            if ($data->stage == "2") {
                $data->stage = "1";
                $data->status = "Opened";


                $data->more_info_by = Auth::user()->name;
                $data->more_info_on = Carbon::now()->format('d-M-Y');


                //    $data->closed_not_approved_comment = $request->comment;
                    $history = new RecommendedAuditTrialDetails();
                        $history->root_id = $id;
                        $history->activity_type = 'activity log';

                $history->previous = $lastData->more_info_by;
                $history->current = $data->more_info_by;
                        $history->comment = "Not Applicable";
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->origin_state = $lastData->status;
                        $history->change_from = $lastData->status;
                        $history->change_to ="Opened";
                        $history->action_name = "Submit";
                        $history->action = "Not Applicable";

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

            if ($data->stage == "4") {
                $data->stage = "3";
                $data->status = "Recommendation Action Execution";

                $data->more_info_by = Auth::user()->name;
                $data->more_info_on = Carbon::now()->format('d-M-Y');


                //    $data->closed_not_approved_comment = $request->comment;
                $history = new RecommendedAuditTrialDetails();
                $history->root_id = $id;
                $history->activity_type = 'Recommendation Action Execution';
                $history->previous = $lastData->more_info_by;
                $history->current = $data->more_info_by;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->origin_state = $data->status;
                $history->change_from = $lastData->status;
                $history->change_to = "Recommendation Action Execution";
                $history->action = "Not Applicable";
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

                $data->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($data->stage == "1") {
                $data->stage = "0";
                $data->status = "Closed - Cancelled";

                $data->cancellation_request_by = Auth::user()->name;
                $data->cancellation_request_on = Carbon::now()->format('d-M-Y');


                //    $data->closed_not_approved_comment = $request->comment;
                $history = new RecommendedAuditTrialDetails();
                $history->root_id = $id;
                $history->activity_type = 'Closed - Cancelled';
                $history->previous =$lastData->cancellation_request_by;
                $history->current = $data->cancellation_request_by;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state =$lastData->status;
                $history->origin_state = $data->status;
                $history->change_from = $lastData->status;
                $history->change_to = "Closed - Cancelled";
                $history->action = "Not Applicable";
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

                $data->update();
                toastr()->success('Document Sent');
                return back();
            }




            // if ($data->stage == "4"){
            //     $data->stage = "8";
            //     $data->status = "Product Released";
            //     $data->Recall_Closed_by = Auth::user()->name;
            //     $data->Recall_Closed_on = Carbon::now()->format('d-M-Y');
            //   // $data->closed_not_approved_comment = $request->comment;
            //     // $history = new ProductionValidationTrail();
            //     //     $history->root_id = $id;
            //     //     $history->activity_type = 'Product Released';
            //     //     $history->previous = "Recall_Closed_by";
            //     //     $history->current = $data->Recall_Closed_by;
            //     //     $history->comment = "Not Applicable";
            //     //     $history->user_id = Auth::user()->id;
            //     //     $history->user_name = Auth::user()->name;
            //     //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     //     $history->origin_state = $data->status;
            //     //      $history->change_from ="Initiator";
            //     //      $history->change_to ="Opened";
            //     //     $history->action_name = "Submit";
            //     //     $history->save();
            //         //     $list = Helpers::getHodUserList();
            //         //     foreach ($list as $u) {
            //         //         if($u->q_m_s_divisions_id == $capa->division_id){
            //         //             $email = Helpers::getInitiatorEmail($u->user_id);
            //         //             if ($email !== null) {

            //         //             Mail::send(
            //         //                 'mail.view-mail',
            //         //                 ['data' => $capa],
            //         //                 function ($message) use ($email) {
            //         //                     $message->to($email)
            //         //                         ->subject("Document is Submitted By ".Auth::user()->name);
            //         //                 }
            //         //             );
            //         //             }
            //         //     }
            //         // }
            //     $data->update();
            //     toastr()->success('Document Sent');
            //     return back();
            // }


            //     if ($data->stage == "5"){
            //         $data->stage = "6";
            //         $data->status = "Product Released";
            //         $data->Release_by = Auth::user()->name;
            //         $data->Release_on = Carbon::now()->format('d-M-Y');

            //       // $data->closed_not_approved_comment = $request->comment;
            //         // $history = new ProductionValidationTrail();
            //         //     $history->root_id = $id;
            //         //     $history->activity_type = 'Product Released';
            //         //     $history->previous = "Release_by";
            //         //     $history->current = $data->Release_by;
            //         //     $history->comment = "Not Applicable";
            //         //     $history->user_id = Auth::user()->id;
            //         //     $history->user_name = Auth::user()->name;
            //         //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //         //     $history->origin_state = $data->status;
            //         //      $history->change_from ="Initiator";
            //         //      $history->change_to ="Opened";
            //         //     $history->action_name = "Submit";
            //         //     $history->save();
            //             //     $list = Helpers::getHodUserList();
            //             //     foreach ($list as $u) {
            //             //         if($u->q_m_s_divisions_id == $capa->division_id){
            //             //             $email = Helpers::getInitiatorEmail($u->user_id);
            //             //             if ($email !== null) {

            //             //             Mail::send(
            //             //                 'mail.view-mail',
            //             //                 ['data' => $capa],
            //             //                 function ($message) use ($email) {
            //             //                     $message->to($email)
            //             //                         ->subject("Document is Submitted By ".Auth::user()->name);
            //             //                 }
            //             //             );
            //             //             }
            //             //     }
            //             // }
            //         $data->update();
            //         toastr()->success('Document Sent');
            //         return back();
            //     }
            //     if ($data->stage == 6){
            //         $data->stage = "7";
            //         $data->status = "Product Released";
            //         $data->Analyzee_by = Auth::user()->name;
            //         $data->Analyzee_by = Carbon::now()->format('d-M-Y');

            //       // $data->closed_not_approved_comment = $request->comment;
            //         // $history = new ProductionValidationTrail();
            //         //     $history->root_id = $id;
            //         //     $history->activity_type = 'Product Released';
            //         //     $history->previous = "Analyzee_by";
            //         //     $history->current = $data->Analyzee_by;
            //         //     $history->comment = "Not Applicable";
            //         //     $history->user_id = Auth::user()->id;
            //         //     $history->user_name = Auth::user()->name;
            //         //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //         //     $history->origin_state = $data->status;
            //         //      $history->change_from ="Initiator";
            //         //      $history->change_to ="Opened";
            //         //     $history->action_name = "Submit";
            //         //     $history->save();
            //             //     $list = Helpers::getHodUserList();
            //             //     foreach ($list as $u) {
            //             //         if($u->q_m_s_divisions_id == $capa->division_id){
            //             //             $email = Helpers::getInitiatorEmail($u->user_id);
            //             //             if ($email !== null) {

            //             //             Mail::send(
            //             //                 'mail.view-mail',
            //             //                 ['data' => $capa],
            //             //                 function ($message) use ($email) {
            //             //                     $message->to($email)
            //             //                         ->subject("Document is Submitted By ".Auth::user()->name);
            //             //                 }
            //             //             );
            //             //             }
            //             //     }
            //             // }
            //         $data->update();
            //         toastr()->success('Document Sent');
            //         return back();
            //     }
            //   if ($data->stage == 6){
            //         $data->stage = "7";
            //         $data->status = "Product Released";
            //         $data->Analyzee_by = Auth::user()->name;
            //         $data->Analyzee_by = Carbon::now()->format('d-M-Y');

            //       // $data->closed_not_approved_comment = $request->comment;
            //         // $history = new ProductionValidationTrail();
            //         //     $history->root_id = $id;
            //         //     $history->activity_type = 'Product Released';
            //         //     $history->previous = "Analyzee_by";
            //         //     $history->current = $data->Analyzee_by;
            //         //     $history->comment = "Not Applicable";
            //         //     $history->user_id = Auth::user()->id;
            //         //     $history->user_name = Auth::user()->name;
            //         //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //         //     $history->origin_state = $data->status;
            //         //      $history->change_from ="Initiator";
            //         //      $history->change_to ="Opened";
            //         //     $history->action_name = "Submit";
            //         //     $history->save();
            //             //     $list = Helpers::getHodUserList();
            //             //     foreach ($list as $u) {
            //             //         if($u->q_m_s_divisions_id == $capa->division_id){
            //             //             $email = Helpers::getInitiatorEmail($u->user_id);
            //             //             if ($email !== null) {

            //             //             Mail::send(
            //             //                 'mail.view-mail',
            //             //                 ['data' => $capa],
            //             //                 function ($message) use ($email) {
            //             //                     $message->to($email)
            //             //                         ->subject("Document is Submitted By ".Auth::user()->name);
            //             //                 }
            //             //             );
            //             //             }
            //             //     }
            //             // }
            //         $data->update();
            //         toastr()->success('Document Sent');
            //         return back();
            //     }

            //     if ($data->stage == 7){
            //         $data->stage = "9";
            //         $data->status = "close-Done";
            //         $data->Start_Production_by = Auth::user()->name;
            //         $data->Start_Production_on = Carbon::now()->format('d-M-Y');

            //       // $data->closed_not_approved_comment = $request->comment;
            //         // $history = new ProductionValidationTrail();
            //         //     $history->root_id = $id;
            //         //     $history->activity_type = 'close-Done';
            //         //     $history->previous = "Start_Production_by";
            //         //     $history->current = $data->Start_Production_by;
            //         //     $history->comment = "Not Applicable";
            //         //     $history->user_id = Auth::user()->id;
            //         //     $history->user_name = Auth::user()->name;
            //         //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //         //     $history->origin_state = $data->status;
            //         //      $history->change_from ="Initiator";
            //         //      $history->change_to ="Opened";
            //         //     $history->action_name = "Submit";
            //         //     $history->save();
            //             //     $list = Helpers::getHodUserList();
            //             //     foreach ($list as $u) {
            //             //         if($u->q_m_s_divisions_id == $capa->division_id){
            //             //             $email = Helpers::getInitiatorEmail($u->user_id);
            //             //             if ($email !== null) {

            //             //             Mail::send(
            //             //                 'mail.view-mail',
            //             //                 ['data' => $capa],
            //             //                 function ($message) use ($email) {
            //             //                     $message->to($email)
            //             //                         ->subject("Document is Submitted By ".Auth::user()->name);
            //             //                 }
            //             //             );
            //             //             }
            //             //     }
            //             // }
            //         $data->update();
            //         toastr()->success('Document Sent');
            //         return back();
            //     }
            //     else{
            //         toastr()->error('E-signature Not match');
            //         return back();
            //     }
            //     }
            // }

        }
    }
    public function RecommendedAuditTrialDetails($id)
    {

        $audit = RecommendedAuditTrialDetails::where('root_id', $id)->orderByDESC('id')->paginate(5);
        // dd($audit);
        $today = Carbon::now()->format('d-m-y');
        $document = Reccomended_action::where('id', $id)->first();
        $document->originator = User::where('id', $document->initiator_id)->value('name');

        return view('frontend.Reccomendation_action.AuditTrail', compact('audit', 'document', 'today'));
    }

    public function auditTrailPdf($id)
    {
        $doc = Reccomended_action::find($id);
        $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        $data = RecommendedAuditTrialDetails::where('root_id', $doc->id)->orderByDesc('id')->get();
        $audit = RecommendedAuditTrialDetails::Where('root_id',$id)->orderByDesc('id')->get();

        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.Reccomendation_action.AuditTrail_pdf', compact('data', 'doc','audit'))
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

    public function singleReports(Request $request, $id)
    {
        $data = Reccomended_action::find($id);
        // $data = QualityFollowup::where(['id' => $id, 'identifier' => 'details'])->first();
        if (!empty($data)) {
            // $data->data = Product_Validation::where('id', $id)->where('identifier', "details")->first();
            // $data->Instruments_Details = ErrataGrid::where('e_id', $id)->where('type', "Instruments_Details")->first();
            // $data->Material_Details = Erratagrid::where('e_id', $id)->where('type', "Material_Details")->first();
            // dd($data->all());
            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.Reccomendation_action.singleReport', compact('data'))
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
}
