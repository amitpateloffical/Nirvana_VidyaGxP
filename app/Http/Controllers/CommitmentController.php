<?php

namespace App\Http\Controllers;

use App\Models\Commitment;
use App\Http\Controllers\Controller;
use App\Models\Commitment_Grid;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\RecordNumber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PDF;
use App\Models\User;
use App\Models\RoleGroup;
use Illuminate\Support\Facades\App;
use App\Models\Commitment_audit;


class CommitmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $old_record = Commitment::select('id')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');


        return view('frontend.Registration-Tracking.commitment', compact( 'old_record', 'record_number','currentDate', 'formattedDate', 'due_date'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
        if (!$request->short_description) {
            toastr()->error("Short description is required");
              return redirect()->back();
         }

        $commit = new Commitment();
        $commit->status = 'opened';
        $commit->stage = 1;

        $recordCounter = RecordNumber::first();
        $newRecordNumber = $recordCounter->counter + 1;

        $recordCounter->counter = $newRecordNumber;
        $recordCounter->save();

        $commit->record = $newRecordNumber;
        $commit->division_id = $request->division_id;
        $commit->initiator = Auth::user()->id;
        $commit->member_state = $request->member_state;
        $commit->trade_name = $request->trade_name;
        $commit->date_of_initiaton = $request->date_of_initiaton;
        $commit->short_description = $request->short_description;
        $commit->assigned_to = $request->assigned_to;
        $commit->type = $request->type;
        $commit->due_date = $request->due_date;
        $commit->authority_duedate = $request->authority_duedate;
        $commit->start_date = $request->start_date;
        $commit->end_date = $request->end_date;
        $commit->estimated_man = $request->estimated_man;
        //   $commit->division_id = '7';
        $commit->summary = $request->summary;
        $commit->priority_level = $request->priority_level;
        $commit->person_responsible = $request->person_responsible;
        $commit->parent_authority = $request->parent_authority;
        // $commit->Severity_Rate = $request->Severity_Rate;
        $commit->authority_type = $request->authority_type;

        $commit->description = $request->description;

        $commit->Safety_Impact_Probability = $request->Safety_Impact_Probability;
        $commit->Safety_Impact_Severity = $request->Safety_Impact_Severity;
        $commit->Legal_Impact_Probability = $request->Legal_Impact_Probability;
        $commit->Legal_Impact_Severity = $request->Legal_Impact_Severity;
        $commit->Business_Impact_Probability = $request->Business_Impact_Probability;
        $commit->Business_Impact_Severity = $request->Business_Impact_Severity;
        $commit->Revenue_Impact_Probability = $request->Revenue_Impact_Probability;
        $commit->Brand_Impact_Probability = $request->Brand_Impact_Probability;
        $commit->Revenue_Impact_Severity = $request->Revenue_Impact_Severity;
        $commit->Brand_Impact_Severity = $request->Brand_Impact_Severity;
        $commit->Safety_Impact_Risk = $request->Safety_Impact_Risk;
        $commit->Legal_Impact_Risk = $request->Legal_Impact_Risk;
        $commit->Business_Impact_Risk = $request->Business_Impact_Risk;

        $commit->Revenue_Impact_Risk = $request->Revenue_Impact_Risk;
        $commit->Brand_Impact_Risk = $request->Brand_Impact_Risk;
        $commit->Impact = $request->Impact;
        $commit->Impact_Analysis = $request->Impact_Analysis;
        $commit->Recommended_Action = $request->Recommended_Action;
        $commit->Comments = $request->Comments;
        $commit->direct_Cause = $request->direct_Cause;

        $commit->safeguarding = $request->safeguarding;
        $commit->root = $request->root;
        $commit->Root_cause_Description = $request->Root_cause_Description;
        $commit->Severity_Rate = $request->Severity_Rate;
        $commit->Occurrence = $request->Occurrence;
        $commit->Detection = $request->Detection;
        $commit->RPN = $request->RPN;

        $commit->Risk_Analysis = $request->Risk_Analysis;
        $commit->Criticality = $request->Criticality;
        $commit->Inform_Local_Authority = $request->Inform_Local_Authority;
        $commit->authority = $request->authority;
        $commit->parent_description = $request->parent_description;


        if (!empty($request->file_attach)) {
            $files = [];
            if ($request->hasFile('file_attach')) {
                foreach ($request->file('file_attach') as $file) {
                    // Generate a unique name for the file
                    $name = $request->name . 'file_attach' . rand(1,100) . '.' . $file->getClientOriginalExtension();

                    // Move the file to the upload directory
                    $file->move('upload/', $name);

                    // Add the file name to the array
                    $files[] = $name;
                }
            }
            // Encode the file names array to JSON and assign it to the model
            $commit->file_attach = json_encode($files);
        }

        $commit->save();
        $griddata = $commit->id;
        $action = Commitment_Grid::where(['commit_id' => $griddata, 'identifier' => 'Action Plan'])->firstOrCreate();
         $action->commit_id = $griddata;
         $action->identifier = 'Action Plan';
         $action->data = $request-> Action_plan;
         $action->save();

         $griddata = $commit->id;
         $root = Commitment_Grid::where(['commit_id' => $griddata, 'identifier' => 'Root Cause'])->firstOrCreate();
          $root->commit_id = $griddata;
          $root->identifier = 'Root Cause';
          $root->data = $request-> root_cause;
          $root->save();

          if (!empty($request->initiator)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Initiator';
            $history->previous = "Null";
            $history->current = $request->initiator;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->short_description)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Null";
            $history->current = $request->short_description;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->member_state)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Member State';
            $history->previous = "Null";
            $history->current = $request->member_state;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->trade_name)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Trade Name';
            $history->previous = "Null";
            $history->current = $request->trade_name;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->date_of_initiaton)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Date Of Initiaton';
            $history->previous = "Null";
            $history->current = $request->date_of_initiaton;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->assigned_to)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Assigned To';
            $history->previous = "Null";
            $history->current = $request->assigned_to;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->type)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Type';
            $history->previous = "Null";
            $history->current = $request->type;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->due_date)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Due Date ';
            $history->previous = "Null";
            $history->current = $request->due_date;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->authority_duedate)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Authority due date ';
            $history->previous = "Null";
            $history->current = $request->authority_duedate;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->start_date)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Actual Start Date';
            $history->previous = "Null";
            $history->current = $request->start_date;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->end_date)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Actual End Date';
            $history->previous = "Null";
            $history->current = $request->end_date;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->estimated_man)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Estimated Man';
            $history->previous = "Null";
            $history->current = $request->estimated_man;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->summary)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Summary ';
            $history->previous = "Null";
            $history->current = $request->summary;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->priority_level)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Priority Level';
            $history->previous = "Null";
            $history->current = $request->priority_level;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->person_responsible)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Person Responsible';
            $history->previous = "Null";
            $history->current = $request->person_responsible;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->parent_authority)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Parent Authority';
            $history->previous = "Null";
            $history->current = $request->parent_authority;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }

        if (!empty($request->authority_type)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Authority Type';
            $history->previous = "Null";
            $history->current = $request->authority_type;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->description)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Description';
            $history->previous = "Null";
            $history->current = $request->description;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->Safety_Impact_Probability)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Safety Impact Probability';
            $history->previous = "Null";
            $history->current = $request->Safety_Impact_Probability;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->Safety_Impact_Severity)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Safety Impact Severity';
            $history->previous = "Null";
            $history->current = $request->Safety_Impact_Severity;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->Legal_Impact_Probability)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Legal Impact Probability';
            $history->previous = "Null";
            $history->current = $request->Legal_Impact_Probability;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->Legal_Impact_Severity)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Legal Impact Severity';
            $history->previous = "Null";
            $history->current = $request->Legal_Impact_Severity;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->Business_Impact_Probability)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Business Impact Probability';
            $history->previous = "Null";
            $history->current = $request->Business_Impact_Probability;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }

        if (!empty($request->Business_Impact_Severity)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Business Impact Severity';
            $history->previous = "Null";
            $history->current = $request->Business_Impact_Severity;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->Revenue_Impact_Probability)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Revenue Impact Probability';
            $history->previous = "Null";
            $history->current = $request->Revenue_Impact_Probability;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->Revenue_Impact_Severity)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Revenue Impact Severity';
            $history->previous = "Null";
            $history->current = $request->Revenue_Impact_Severity;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }

        if (!empty($request->Brand_Impact_Probability)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Brand Impact Probability';
            $history->previous = "Null";
            $history->current = $request->Brand_Impact_Probability;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->Brand_Impact_Severity)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Brand Impact Severity';
            $history->previous = "Null";
            $history->current = $request->Brand_Impact_Severity;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->Safety_Impact_Risk)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Safety Impact Risk ';
            $history->previous = "Null";
            $history->current = $request->Safety_Impact_Risk;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->Legal_Impact_Risk)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Leagal Impact Risk';
            $history->previous = "Null";
            $history->current = $request->Legal_Impact_Risk;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->Business_Impact_Risk)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Business Impact Risk';
            $history->previous = "Null";
            $history->current = $request->Business_Impact_Risk;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->Revenue_Impact_Risk)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Revenue Impact Risk';
            $history->previous = "Null";
            $history->current = $request->Revenue_Impact_Risk;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->Brand_Impact_Risk)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Brand Impact Risk';
            $history->previous = "Null";
            $history->current = $request->Brand_Impact_Risk;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->Impact)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Impact';
            $history->previous = "Null";
            $history->current = $request->Impact;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->Impact_Analysis)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Impact Analysis';
            $history->previous = "Null";
            $history->current = $request->Impact_Analysis;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->Recommended_Action)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Recommended Action';
            $history->previous = "Null";
            $history->current = $request->Recommended_Action;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->Comments)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Comments';
            $history->previous = "Null";
            $history->current = $request->Comments;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->direct_Cause)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Direct Cause';
            $history->previous = "Null";
            $history->current = $request->direct_Cause;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->safeguarding)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Safeguarding';
            $history->previous = "Null";
            $history->current = $request->safeguarding;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->root)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Root cause Methodology';
            $history->previous = "Null";
            $history->current = $request->root;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->Root_cause_Description)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Root cause Description';
            $history->previous = "Null";
            $history->current = $request->Root_cause_Description;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->Severity_Rate)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Severity Rate';
            $history->previous = "Null";
            $history->current = $request->Severity_Rate;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->Occurrence)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Occurrence';
            $history->previous = "Null";
            $history->current = $request->Occurrence;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->Detection)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Detection';
            $history->previous = "Null";
            $history->current = $request->Detection;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->RPN)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'RPN';
            $history->previous = "Null";
            $history->current = $request->RPN;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->Risk_Analysis)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Risk Analysis';
            $history->previous = "Null";
            $history->current = $request->Risk_Analysis;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->Criticality)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Criticality ';
            $history->previous = "Null";
            $history->current = $request->Criticality;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->Inform_Local_Authority)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Inform Local Authority';
            $history->previous = "Null";
            $history->current = $request->Inform_Local_Authority;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->authority)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Authority';
            $history->previous = "Null";
            $history->current = $request->authority;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->parent_description)) {
            $history = new commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Parent description';
            $history->previous = "Null";
            $history->current = $request->parent_description;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }

        return redirect()->back()->with('success', 'Commitment added successfully');

}


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commitment  $commitment
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        $commit = Commitment::find($id);

        $action = Commitment_Grid::where(['identifier' => 'Action Plan', 'commit_id' => $id])->first();
        $actionData = $action ? json_decode($action->data, true) : null;

        $root = Commitment_Grid::where(['identifier' => 'Root Cause', 'commit_id' => $id])->first();
        $rootData = $root ? json_decode($root->data, true) : null;

        return view('frontend.Registration-Tracking.commitmentment_view', compact('commit', 'actionData', 'rootData'));
    }

    public function update(Request $request, Commitment $commitment,$id)
    {

        $commit =  Commitment::find($id);
        $lastDocument = Commitment::find($id);
        // $commit->record = $newRecordNumber;
        // $commit->Initiator = $request->initiator;
        $commit->member_state = $request->member_state;
        $commit->trade_name = $request->trade_name;
        // $commit->date_of_initiaton = $request->date_of_initiaton;
        $commit->short_description = $request->short_description;
        $commit->assigned_to = $request->assigned_to;
        $commit->type = $request->type;
        $commit->due_date = $request->due_date;
        $commit->authority_duedate = $request->authority_duedate;
        $commit->start_date = $request->start_date;
        $commit->end_date = $request->end_date;
        $commit->estimated_man = $request->estimated_man;
        // $commit->file_attach = $request->file_attach;

        $commit->summary = $request->summary;
        $commit->priority_level = $request->priority_level;
        $commit->person_responsible = $request->person_responsible;
        $commit->parent_authority = $request->parent_authority;

        $commit->authority_type = $request->authority_type;
        $commit->description = $request->description;

        $commit->Safety_Impact_Probability = $request->Safety_Impact_Probability;
        $commit->Safety_Impact_Severity = $request->Safety_Impact_Severity;
        $commit->Legal_Impact_Probability = $request->Legal_Impact_Probability;
        $commit->Legal_Impact_Severity = $request->Legal_Impact_Severity;
        $commit->Business_Impact_Probability = $request->Business_Impact_Probability;
        $commit->Business_Impact_Severity = $request->Business_Impact_Severity;
        $commit->Revenue_Impact_Probability = $request->Revenue_Impact_Probability;
        $commit->Brand_Impact_Probability = $request->Brand_Impact_Probability;
        $commit->Revenue_Impact_Severity = $request->Revenue_Impact_Severity;
        $commit->Brand_Impact_Severity = $request->Brand_Impact_Severity;
        $commit->Safety_Impact_Risk = $request->Safety_Impact_Risk;
        $commit->Legal_Impact_Risk = $request->Legal_Impact_Risk;
        $commit->Business_Impact_Risk = $request->Business_Impact_Risk;

        $commit->Revenue_Impact_Risk = $request->Revenue_Impact_Risk;
        $commit->Brand_Impact_Risk = $request->Brand_Impact_Risk;
        $commit->Impact = $request->Impact;
        $commit->Impact_Analysis = $request->Impact_Analysis;
        $commit->Recommended_Action = $request->Recommended_Action;
        $commit->Comments = $request->Comments;
        $commit->direct_Cause = $request->direct_Cause;

        $commit->safeguarding = $request->safeguarding;
        $commit->root = $request->root;
        $commit->Root_cause_Description = $request->Root_cause_Description;
        $commit->Severity_Rate = $request->Severity_Rate;
        $commit->Occurrence = $request->Occurrence;
        $commit->Detection = $request->Detection;
        $commit->RPN = $request->RPN;

        $commit->Risk_Analysis = $request->Risk_Analysis;
        $commit->Criticality = $request->Criticality;
        $commit->Inform_Local_Authority = $request->Inform_Local_Authority;
        $commit->authority = $request->authority;
        $commit->parent_description = $request->parent_description;


        $files = [];
        if ($request->hasfile('file_attach')) {
            foreach ($request->file('file_attach') as $file) {
                $name = $request->name . 'file_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }

        $commit->file_attach = json_encode($files);
        }

        if ($lastDocument->short_description != $commit->short_description  ) {

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastDocument->short_description;
            $history->current = $commit->short_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }

        if ($lastDocument->member_state != $commit->member_state  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
                            ->where('activity_type', '(Parent) Member State')
                            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = '(Parent) Member State';
            $history->previous = $lastDocument->member_state;
            $history->current = $commit->member_state;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }

        if ($lastDocument->trade_name != $commit->trade_name  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
             ->where('activity_type', '(Parent) Trade Name')
              ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = '(Parent) Trade Name';
            $history->previous = $lastDocument->trade_name;
            $history->current = $commit->trade_name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->assigned_to != $commit->assigned_to  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
             ->where('activity_type', 'Assigned To')
             ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Assigned To';
            $history->previous = $lastDocument->assigned_to;
            $history->current = $commit->assigned_to;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->type != $commit->type  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', 'Type')
              ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Type';
            $history->previous = $lastDocument->type;
            $history->current = $commit->type;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->authority_duedate != $commit->authority_duedate  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', '(Parent) Date Due to Authority')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = '(Parent) Date Due to Authority';
            $history->previous = $lastDocument->authority_duedate;
            $history->current = $commit->authority_duedate;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }

        if ($lastDocument->estimated_man != $commit->estimated_man  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', 'Estimated Man-Hours')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Estimated Man-Hours';
            $history->previous = $lastDocument->estimated_man;
            $history->current = $commit->estimated_man;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->summary != $commit->summary  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', 'Summary')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Summary';
            $history->previous = $lastDocument->summary;
            $history->current = $commit->summary;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->priority_level != $commit->priority_level  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', '(Parent) Priority Level')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = '(Parent) Priority Level';
            $history->previous = $lastDocument->priority_level;
            $history->current = $commit->priority_level;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->person_responsible != $commit->person_responsible  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', '(Parent) Local Trade Name')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = '(Parent) Local Trade Name';
            $history->previous = $lastDocument->person_responsible;
            $history->current = $commit->person_responsible;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->parent_authority != $commit->parent_authority  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', 'Parent Authority')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Parent Authority';
            $history->previous = $lastDocument->parent_authority;
            $history->current = $commit->parent_authority;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->authority_type != $commit->authority_type  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', '(Parent) Authority Type')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = '(Parent) Authority Type';
            $history->previous = $lastDocument->authority_type;
            $history->current = $commit->authority_type;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->description != $commit->description  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', '(Parent) Description')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = '(Parent) Description';
            $history->previous = $lastDocument->description;
            $history->current = $commit->description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Safety_Impact_Probability != $commit->Safety_Impact_Probability  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type','Safety Impact Probability')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Safety Impact Probability';
            $history->previous = $lastDocument->Safety_Impact_Probability;
            $history->current = $commit->Safety_Impact_Probability;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Safety_Impact_Severity != $commit->Safety_Impact_Severity  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type','Safety Impact Severity')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Safety Impact Severity';
            $history->previous = $lastDocument->Safety_Impact_Severity;
            $history->current = $commit->Safety_Impact_Severity;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Legal_Impact_Probability != $commit->Legal_Impact_Probability  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type','Legal Impact Probability')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Legal Impact Probability';
            $history->previous = $lastDocument->Legal_Impact_Probability;
            $history->current = $commit->Legal_Impact_Probability;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Legal_Impact_Severity != $commit->Legal_Impact_Severity  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type','Legal Impact Severity')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Legal Impact Severity';
            $history->previous = $lastDocument->Legal_Impact_Severity;
            $history->current = $commit->Legal_Impact_Severity;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Business_Impact_Probability != $commit->Business_Impact_Probability  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type','Business Impact Probability')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Business Impact Probability';
            $history->previous = $lastDocument->Business_Impact_Probability;
            $history->current = $commit->Business_Impact_Probability;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Business_Impact_Severity != $commit->Business_Impact_Severity  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type','Business Impact Severity')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Business Impact Severity';
            $history->previous = $lastDocument->Business_Impact_Severity;
            $history->current = $commit->Business_Impact_Severity;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Revenue_Impact_Probability != $commit->Revenue_Impact_Probability  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type','Revenue Impact Probability')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Revenue Impact Probability';
            $history->previous = $lastDocument->Revenue_Impact_Probability;
            $history->current = $commit->Revenue_Impact_Probability;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Revenue_Impact_Severity != $commit->Revenue_Impact_Severity  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type','Revenue Impact Severity')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Revenue Impact Severity';
            $history->previous = $lastDocument->Revenue_Impact_Severity;
            $history->current = $commit->Revenue_Impact_Severity;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Brand_Impact_Probability != $commit->Brand_Impact_Probability  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type','Brand Impact Probability')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Brand Impact Probability';
            $history->previous = $lastDocument->Brand_Impact_Probability;
            $history->current = $commit->Brand_Impact_Probability;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Brand_Impact_Severity != $commit->Brand_Impact_Severity  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type','Brand Impact Severity')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Brand Impact Severity';
            $history->previous = $lastDocument->Brand_Impact_Severity;
            $history->current = $commit->Brand_Impact_Severity;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Safety_Impact_Risk != $commit->Safety_Impact_Risk  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type','Safety Impact Risk')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Safety Impact Risk';
            $history->previous = $lastDocument->Safety_Impact_Risk;
            $history->current = $commit->Safety_Impact_Risk;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Legal_Impact_Risk != $commit->Legal_Impact_Risk  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', 'Legal Impact Risk')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Legal Impact Risk';
            $history->previous = $lastDocument->Legal_Impact_Risk;
            $history->current = $commit->Legal_Impact_Risk;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Business_Impact_Risk != $commit->Business_Impact_Risk  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', 'Business Impact Risk')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Business Impact Risk';
            $history->previous = $lastDocument->Business_Impact_Risk;
            $history->current = $commit->Business_Impact_Risk;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Revenue_Impact_Risk != $commit->Revenue_Impact_Risk  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', 'Revenue Impact Risk')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Revenue Impact Risk';
            $history->previous = $lastDocument->Revenue_Impact_Risk;
            $history->current = $commit->Revenue_Impact_Risk;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Brand_Impact_Risk != $commit->Brand_Impact_Risk  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', 'Brand Impact Risk')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Brand Impact Risk';
            $history->previous = $lastDocument->Brand_Impact_Risk;
            $history->current = $commit->Brand_Impact_Risk;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Impact != $commit->Impact  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type','Impact')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Impact';
            $history->previous = $lastDocument->Impact;
            $history->current = $commit->Impact;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Impact_Analysis != $commit->Impact_Analysis  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type','Impact Analysis')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Impact Analysis';
            $history->previous = $lastDocument->Impact_Analysis;
            $history->current = $commit->Impact_Analysis;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Recommended_Action != $commit->Recommended_Action  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', 'Recommended Action')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Recommended Action';
            $history->previous = $lastDocument->Recommended_Action;
            $history->current = $commit->Recommended_Action;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Comments != $commit->Comments  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type','Comments')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Comments';
            $history->previous = $lastDocument->Comments;
            $history->current = $commit->Comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->direct_Cause != $commit->direct_Cause  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', 'Direct Cause')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Direct Cause';
            $history->previous = $lastDocument->direct_Cause;
            $history->current = $commit->direct_Cause;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->safeguarding != $commit->safeguarding  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', 'Safeguarding Measure Taken')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Safeguarding Measure Taken';
            $history->previous = $lastDocument->safeguarding;
            $history->current = $commit->safeguarding;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->root != $commit->root  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', 'Root cause Methodology')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Root cause Methodology';
            $history->previous = $lastDocument->root;
            $history->current = $commit->root;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Root_cause_Description != $commit->Root_cause_Description  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', 'Root cause Description')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Root cause Description';
            $history->previous = $lastDocument->Root_cause_Description;
            $history->current = $commit->Root_cause_Description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Severity_Rate != $commit->Severity_Rate  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', 'Severity Rate')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Severity Rate';
            $history->previous = $lastDocument->Severity_Rate;
            $history->current = $commit->Severity_Rate;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Occurrence != $commit->Occurrence  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', 'Occurrence')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Occurrence';
            $history->previous = $lastDocument->Occurrence;
            $history->current = $commit->Occurrence;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Detection != $commit->Detection  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', 'Detection')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Detection';
            $history->previous = $lastDocument->Detection;
            $history->current = $commit->Detection;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->RPN != $commit->RPN  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', 'RPN')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'RPN';
            $history->previous = $lastDocument->RPN;
            $history->current = $commit->RPN;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Risk_Analysis != $commit->Risk_Analysis  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', 'Risk Analysis')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Risk Analysis';
            $history->previous = $lastDocument->Risk_Analysis;
            $history->current = $commit->Risk_Analysis;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Criticality != $commit->Criticality  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', 'Criticality')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Criticality';
            $history->previous = $lastDocument->Criticality;
            $history->current = $commit->Criticality;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Inform_Local_Authority != $commit->Inform_Local_Authority  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', 'Inform Local_Authority')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Inform Local_Authority';
            $history->previous = $lastDocument->Inform_Local_Authority;
            $history->current = $commit->Inform_Local_Authority;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->authority != $commit->authority  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', 'Authority Type')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Authority Type';
            $history->previous = $lastDocument->authority;
            $history->current = $commit->authority;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->parent_description != $commit->parent_description  ) {
            $lastDocumentAuditTrail = Commitment_audit::where('commit_id', $commit->id)
            ->where('activity_type', '(Parent) Description')
            ->exists();

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = '(Parent) Description';
            $history->previous = $lastDocument->parent_description;
            $history->current = $commit->parent_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Risk_Analysis != $commit->Risk_Analysis  ) {

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Completed by';
            $history->previous = $lastDocument->Risk_Analysis;
            $history->current = $commit->Risk_Analysis;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Risk_Analysis != $commit->Risk_Analysis  ) {

            $history = new Commitment_audit();
            $history->commit_id = $commit->id;
            $history->activity_type = 'Completed on';
            $history->previous = $lastDocument->Risk_Analysis;
            $history->current = $commit->Risk_Analysis;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            $history->save();
        }
          // dd($commit->short_description);
        $commit->update();

        $griddata = $commit->id;
        $action = Commitment_Grid::where(['commit_id' => $griddata, 'identifier' => 'Action Plan'])->firstOrCreate();
         $action->commit_id = $griddata;
         $action->identifier = 'Action Plan';
         $action->data = $request-> Action_plan;
         $action->update();

         $griddata = $commit->id;
         $root = Commitment_Grid::where(['commit_id' => $griddata, 'identifier' => 'Root Cause'])->firstOrCreate();
          $root->commit_id = $griddata;
          $root->identifier = 'Root Cause';
          $root->data = $request-> root_cause;
          $root->update();

        return redirect()->back()->with('success', 'Commitment Updated successfully');

    }

    public function stageChange(Request $request, $id)
    {
         if($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password))
         {

            $device =Commitment::find($id);
            $lastDocument =Commitment::find($id);

            if ($device->stage == 1) {
                $device->stage = "2";
                $device->status = "Execution in Progress";

                $device->acknowledged_by = Auth::user()->name;
                $device->acknowledged_on = Carbon::now()->format('d-M-Y');
                // $device->cancelled_comment = $request->comment;
                $history = new Commitment_audit();
                $history->commit_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->acknowledged_by;
                $history->current = $device->acknowledged_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = '2';
                $history->change_to = "Execution in Progress";
                $history->change_from = $lastDocument->status;
                $history->action = 'Acknowledge';
                $history->save();

                $device->update();
                toastr()->success('Document Sent');
                return back();
            }

        if ($device->stage == 2) {
            $device->stage = "3";
            $device->status = "Closed Done";
            $device->taskcompleted_by = Auth::user()->name;
                $device->taskcompleted_on = Carbon::now()->format('d-M-Y');
                // $device->cancelled_comment = $request->comment;
                $history = new Commitment_audit();
                $history->commit_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->taskcompleted_by;
                $history->current = $device->taskcompleted_by;
                // $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = '3';
                $history->change_to = "Closed Done";
                $history->change_from = $lastDocument->status;
                $history->action = 'Task Completed';
                $history->save();
            $device->update();
            toastr()->success('Closed-Done');
            return back();
        }

        }else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function stage_cancel(Request $request, $id)
    {
        $device = Commitment::find($id);
        $lastDocument = Commitment::find($id);
        if ($device->stage == 1) {
            $device->stage = "0";
            $device->status = "Closed-Cancelled";

            $device->cancelled_by = Auth::user()->name;
            $device->cancelled_on = Carbon::now()->format('d-M-Y');
            // $device->cancelled_comment = $request->comment;
            $history = new Commitment_audit();
            $history->commit_id = $id;
            $history->activity_type = 'Activity Log';
            $history->previous = $lastDocument->cancelled_by;
            $history->current = $device->cancelled_by;
            // $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->stage = '0';
            $history->change_to = "Closed-Cancelled";
            $history->change_from = $lastDocument->status;
            $history->action = 'Cancel';
            $history->save();
            $device->update();
            toastr()->success('Document Sent');
            return back();
        }
        if ($device->stage == 2) {
            $device->stage = "0";
            $device->status = "Closed-Cancelled";
            $device->cancel_by = Auth::user()->name;
            $device->cancel_on = Carbon::now()->format('d-M-Y');
            // $device->cancelled_comment = $request->comment;
            $history = new Commitment_audit();
            $history->commit_id = $id;
            $history->activity_type = 'Activity Log';
            $history->previous = $lastDocument->cancel_by;
            $history->current = $device->cancel_by;
            // $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->stage = '0';
            $history->change_to = "Closed-Cancelled";
            $history->change_from = $lastDocument->status;
            $history->action = 'Cancel';
            $history->save();
            $device->update();
            toastr()->success('Document Sent');
            return back();
        }

    }
    public function auditTrialshow($id)
    {
            $audit = Commitment_audit::where("commit_id", $id)->orderByDESC('id')->paginate(20);
        $today = Carbon::now()->format('Y-m-d');
        $document = Commitment::where('id', $id)->first();
       // dd($document);
        $document->initiator = User::where('id', $document->initiator)->value('name');

        return view('frontend.Registration-Tracking.commitment_audit_trail', compact('audit', 'document', 'today'));
    }

    public function auditTrailPdf($id){
        $doc = Commitment_audit::find($id);
        $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        $data = Commitment_audit::where('commit_id', $doc->id)->orderByDesc('id')->get();
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.Registration-Tracking.commitment_auditpdf', compact('data', 'doc'))
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

    public function singleReport($id)
{
    $data = Commitment::find($id);

    if (!empty($data)) {
        // Fetch the originator's name
        $data->originator = User::where('id', $data->initiator_id)->value('name') ?? 'Not Applicable';

        // Create PDF instance
        $pdf = App::make('dompdf.wrapper');

        // Generate PDF from view
        $pdf = PDF::loadView('frontend.Registration-Tracking.commitment_singleReport', compact('data'))
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'isPhpEnabled' => true,
            ]);

        // Set paper size
        $pdf->setPaper('A4');

        // Render the PDF
        $pdf->render();

        // Get the canvas
        $canvas = $pdf->getDomPDF()->getCanvas();
        $height = $canvas->get_height();
        $width = $canvas->get_width();

        // Set watermark opacity
        $canvas->page_script('$pdf->set_opacity(0.1, "Multiply");');
        // $canvas->page_script(function ($pageNumber, $canvas, $pdf) {
        //     $canvas->set_opacity(0.1, "Multiply");
        // });

        // Add watermark text
        $canvas->page_text(
            $width / 4,
            $height / 2,
            $data->status ?? 'Not Applicable',
            null,
            25,
            [0, 0, 0],
            2,
            6,
            -20
        );

        // Stream the generated PDF
        return $pdf->stream('SOP' . $id . '.pdf');
    }

    // Return a response if data is not found
    return response()->json(['error' => 'Data not found'], 404);
}

public static function auditReport($id)
    {
        $doc = commitment::find($id);
        if (!empty($doc)) {
            $doc->initiator_id = User::where('id', $doc->initiator_id)->value('name');
            $data = Commitment_audit::where('commit_id', $id)->get();
            $audit = Commitment_audit::where('commit_id', $id)->get();

            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.Registration-Tracking.commitment_auditpdf', compact('data', 'doc','audit'))
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
            return $pdf->stream('commitment-Audit' . $id . '.pdf');
        }
    }

    public function destroy(Commitment $commitment)
    {
        //
    }
}
