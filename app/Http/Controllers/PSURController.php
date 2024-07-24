<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\RecordNumber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\CC;
use App\Models\PsurGrid;
use PDF;
use App\Models\psur_audit_trail;
use App\Models\User;
use App\Models\RoleGroup;
use Illuminate\Support\Facades\App;

use App\Models\PSUR;
use Carbon\Carbon;


class PSURController extends Controller
{
    public function index()
    {
        $old_record = PSUR::select('id')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');

        return view('frontend.New_forms.PSUR', compact( 'currentDate', 'formattedDate', 'due_date','record_number','old_record'));

    }
    public function store(Request $request)
    {
        // dd($request->all());

        if (!$request->short_description) {
            toastr()->info("Short Description is required");
            return redirect()->back()->withInput();
        }


        $PSUR = new PSUR();
        $PSUR->status = 'opened';
        $PSUR->type = "PSUR";
        $PSUR->stage = 1;

        $recordCounter = RecordNumber::first();
        $newRecordNumber = $recordCounter->counter + 1;

        $recordCounter->counter = $newRecordNumber;
        $recordCounter->save();

        $PSUR->record = $newRecordNumber;

        // $PSUR->initiator_id = Auth::user()->id;

        $PSUR->initiator = $request->initiator;
        $PSUR->intiation_date = $request->date_of_initiation;
        $PSUR->short_description = $request->short_description;
        $PSUR->assigned_to = $request->assigned_to;
        $PSUR->due_date = $request->due_date;
        $PSUR->documents = $request->documents;
        // $PSUR->file_attachment = $request->file_attachment;
        $PSUR->type_new = $request->type_new;
        // dd($request->due_date);
        $PSUR->year = $request->year;
        $PSUR->actual_start_date = $request->actual_start_date;
        $PSUR->actual_end_date = $request->actual_end_date;
        $PSUR->authority_type = $request->authority_type;
        $PSUR->authority = $request->authority;
        $PSUR->introduction = $request->introduction;
        $PSUR->related_records = $request->related_records;
        $PSUR->world_ma_status = $request->world_ma_status;
        $PSUR->ra_actions_taken = $request->ra_actions_taken;
        $PSUR->mah_actions_taken = $request->mah_actions_taken;
        //----------------------------------------------------------------tab change----------------------------------------------------------------
        $PSUR->changes_to_safety_information = $request->changes_to_safety_information;
        $PSUR->patient_exposure = $request->patient_exposure;
        $PSUR->analysis_of_individual_case = $request->analysis_of_individual_case;
        $PSUR->newly_analyzed_studies = $request->newly_analyzed_studies;
        $PSUR->target_and_new_safety_studies = $request->target_and_new_safety_studies;
        $PSUR->publish_safety_studies = $request->publish_safety_studies;
        $PSUR->efficiency_related_info = $request->efficiency_related_info;
        $PSUR->late_breaking_information = $request->late_breaking_information;
        $PSUR->overall_safety_evaluation = $request->overall_safety_evaluation;
        $PSUR->conclusion = $request->conclusion;
        //----------------------------------------------------------------tab change----------------------------------------------------------------

         $PSUR->root_parent_manufaturer = $request->root_parent_manufaturer;
         $PSUR->root_parent_product_type = $request->root_parent_product_type;
         $PSUR->root_parent_trade_name = $request->root_parent_trade_name;
         $PSUR->international_birth_date = $request->international_birth_date;
         $PSUR->root_parent_api = $request->root_parent_api;
         $PSUR->root_parent_product_strength = $request->root_parent_product_strength;
         $PSUR->route_of_administration = $request->route_of_administration;
         $PSUR->root_parent_product_dosage_form = $request->root_parent_product_dosage_form;
         $PSUR->therapeutic_Area = $request->therapeutic_Area;
           //----------------------------------------------------------------tab change----------------------------------------------------------------

         $PSUR->registration_status = $request->registration_status;
         $PSUR->registration_number = $request->registration_number;
         $PSUR->planned_submission_date = $request->planned_submission_date;
         $PSUR->actual_submission_date = $request->actual_submission_date;
         $PSUR->comments = $request->comments;
         $PSUR->procedure_type = $request->procedure_type;
         $PSUR->procedure_number = $request->procedure_number;
         $PSUR->reference_member_state = $request->reference_member_state;
         $PSUR->renewal_rule = $request->renewal_rule;
         $PSUR->concerned_member_states = $request->concerned_member_states;

        $PSUR->save();
        //  dd($request->due_date);


        if (!empty($request->short_description)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
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

        if (!empty($request->initiator)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
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
        if (!empty($request->date_of_initiation)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Date Of Initiation';
            $history->previous = "Null";
            $history->current = $request->date_of_initiation;
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
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
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
        if (!empty($request->due_date)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Due date';
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
        if (!empty($request->documents)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Documents';
            $history->previous = "Null";
            $history->current = $request->documents;
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

        if (!empty($request->type_new)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Type';
            $history->previous = "Null";
            $history->current = $request->type_new;
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
        if (!empty($request->year)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Year';
            $history->previous = "Null";
            $history->current = $request->year;
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
        if (!empty($request->actual_start_date)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'actual_start_date';
            $history->previous = "Null";
            $history->current = $request->actual_start_date;
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

        if (!empty($request->actual_end_date)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'actual_end_date';
            $history->previous = "Null";
            $history->current = $request->actual_end_date;
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
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'authority_type';
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

        if (!empty($request->authority)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'authority';
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


        if (!empty($request->introduction)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Introduction';
            $history->previous = "Null";
            $history->current = $request->introduction;
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


        if (!empty($request->related_records)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'related_records';
            $history->previous = "Null";
            $history->current = $request->related_records;
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


        if (!empty($request->world_ma_status)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'world_ma_status';
            $history->previous = "Null";
            $history->current = $request->world_ma_status;
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


        if (!empty($request->ra_actions_taken)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'ra_actions_taken';
            $history->previous = "Null";
            $history->current = $request->ra_actions_taken;
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


        if (!empty($request->mah_actions_taken)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'mah_actions_taken';
            $history->previous = "Null";
            $history->current = $request->mah_actions_taken;
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


        if (!empty($request->changes_to_safety_information)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'changes_to_safety_information';
            $history->previous = "Null";
            $history->current = $request->changes_to_safety_information;
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

        if (!empty($request->patient_exposure)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'patient_exposure';
            $history->previous = "Null";
            $history->current = $request->patient_exposure;
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

        if (!empty($request->analysis_of_individual_case)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'analysis_of_individual_case';
            $history->previous = "Null";
            $history->current = $request->analysis_of_individual_case;
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


        if (!empty($request->newly_analyzed_studies)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'newly_analyzed_studies';
            $history->previous = "Null";
            $history->current = $request->newly_analyzed_studies;
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


        if (!empty($request->target_and_new_safety_studies)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'target_and_new_safety_studies';
            $history->previous = "Null";
            $history->current = $request->target_and_new_safety_studies;
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


        if (!empty($request->publish_safety_studies)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'publish_safety_studies';
            $history->previous = "Null";
            $history->current = $request->publish_safety_studies;
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


        if (!empty($request->efficiency_related_info)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'efficiency_related_info';
            $history->previous = "Null";
            $history->current = $request->efficiency_related_info;
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


        if (!empty($request->late_breaking_information)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'late_breaking_information';
            $history->previous = "Null";
            $history->current = $request->late_breaking_information;
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


        if (!empty($request->overall_safety_evaluation)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'overall_safety_evaluation';
            $history->previous = "Null";
            $history->current = $request->overall_safety_evaluation;
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


        if (!empty($request->conclusion)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'conclusion';
            $history->previous = "Null";
            $history->current = $request->conclusion;
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


        if (!empty($request->root_parent_manufaturer)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'root_parent_manufaturer';
            $history->previous = "Null";
            $history->current = $request->root_parent_manufaturer;
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


        if (!empty($request->root_parent_product_type)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'root_parent_product_type';
            $history->previous = "Null";
            $history->current = $request->root_parent_product_type;
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


        if (!empty($request->root_parent_trade_name)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'root_parent_trade_name';
            $history->previous = "Null";
            $history->current = $request->root_parent_trade_name;
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
        if (!empty($request->root_parent_api)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'root_parent_api';
            $history->previous = "Null";
            $history->current = $request->root_parent_api;
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
        if (!empty($request->root_parent_product_strength)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'root_parent_product_strength';
            $history->previous = "Null";
            $history->current = $request->root_parent_product_strength;
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
        if (!empty($request->route_of_administration)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'route_of_administration';
            $history->previous = "Null";
            $history->current = $request->route_of_administration;
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
        if (!empty($request->root_parent_product_dosage_form)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'root_parent_product_dosage_form';
            $history->previous = "Null";
            $history->current = $request->root_parent_product_dosage_form;
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
        if (!empty($request->therapeutic_Area)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'therapeutic_Area';
            $history->previous = "Null";
            $history->current = $request->therapeutic_Area;
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
        if (!empty($request->registration_status)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'registration_status';
            $history->previous = "Null";
            $history->current = $request->registration_status;
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
        if (!empty($request->registration_number)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'registration_number';
            $history->previous = "Null";
            $history->current = $request->registration_number;
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



        if (!empty($request->planned_submission_date)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'planned_submission_date';
            $history->previous = "Null";
            $history->current = $request->planned_submission_date;
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



        if (!empty($request->actual_submission_date)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'actual_submission_date';
            $history->previous = "Null";
            $history->current = $request->actual_submission_date;
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

        if (!empty($request->comments)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'comments';
            $history->previous = "Null";
            $history->current = $request->comments;
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
        if (!empty($request->procedure_type)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'procedure_type';
            $history->previous = "Null";
            $history->current = $request->procedure_type;
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
        if (!empty($request->procedure_number)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'procedure_number';
            $history->previous = "Null";
            $history->current = $request->procedure_number;
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
        if (!empty($request->reference_member_state)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'reference_member_state';
            $history->previous = "Null";
            $history->current = $request->reference_member_state;
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
        if (!empty($request->renewal_rule)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'renewal_rule';
            $history->previous = "Null";
            $history->current = $request->renewal_rule;
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
        if (!empty($request->concerned_member_states)) {
            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'concerned_member_states';
            $history->previous = "Null";
            $history->current = $request->concerned_member_states;
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
        $griddata = $PSUR->id;
        $parent = PsurGrid::where(['psur_id' => $griddata, 'identifier' => ' ATC Codes'])->firstOrCreate();
         $parent->psur_id = $griddata;
         $parent->identifier = 'ATC Codes';
         $parent->data = $request-> ATCCodes;
         $parent->save();
        //  --------------------------------------Ingridents------------------------------------------//

         $ingrident = PsurGrid::where(['psur_id' => $griddata, 'identifier' => 'Ingredients'])->firstOrCreate();
         $ingrident->psur_id = $griddata;
         $ingrident->identifier = 'Ingredients';
         $ingrident->data = $request->ingridents;
         $ingrident->save();
         //  --------------------------------------Product/Material------------------------------------------//

         $Product = PsurGrid::where(['psur_id' => $griddata, 'identifier' => 'Product'])->firstOrCreate();
         $Product->psur_id = $griddata;
         $Product->identifier = 'Product';
         $Product->data = $request->product;
         $Product->save();
         //  -------------------------------------- Packaging Information------------------------------------------//

         $information = PsurGrid::where(['psur_id' => $griddata, 'identifier' => 'Packaging Information'])->firstOrCreate();
         $information->psur_id = $griddata;
         $information->identifier = 'Packaging Information';
         $information->data = $request->pacaging_information;
         $information->save();


        return redirect(url('rcms/qms-dashboard'));


        // return redirect()->back()->with('success', 'PSUR added successfully');
    }


    public function show($id) {
        $PSUR = PSUR::find($id);

        $PSUR->record = str_pad($PSUR->record, 4, '0', STR_PAD_LEFT);

        if (!$PSUR) {
            // Handle the case where the PSUR record is not found
            abort(404, 'PSUR not found');
        }

        $parent = PsurGrid::where(['identifier' => 'ATC Codes', 'psur_id' => $id])->first();
        $parentData = $parent ? json_decode($parent->data, true) : null;

        $ingrident = PsurGrid::where(['identifier' => 'Ingredients', 'psur_id' => $id])->first();
        $ingridentData = $ingrident ? json_decode($ingrident->data, true) : null;

        $Product = PsurGrid::where(['identifier' => 'Product', 'psur_id' => $id])->first();
        $ProductData = $Product ? json_decode($Product->data, true) : null;

        $information = PsurGrid::where(['identifier' => 'Packaging Information', 'psur_id' => $id])->first();
        $informationData = $information ? json_decode($information->data, true) : null;

        return view('frontend.New_forms.Psur_view', compact('PSUR', 'parentData', 'ingridentData', 'ProductData', 'informationData'));
    }

    public function Update(Request $request, $id)
    {
        $PSUR = PSUR::find($id);
        $lastDocument = PSUR::find($id);

        // $PSUR->Initiator_id = Auth::user()->id;
        // $PSUR->initiator = $request->initiator;
        // $PSUR->intiation_date = $request->date_of_initiation;
        $PSUR->short_description = $request->short_description;
        $PSUR->assigned_to = $request->assigned_to;
        $PSUR->due_date = $request->due_date;
        $PSUR->documents = $request->documents;
        // $PSUR->file_attachment = $request->file_attachment;
        $PSUR->type_new = $request->type_new;
        // dd($request->due_date);
        $PSUR->year = $request->year;
        $PSUR->actual_start_date = $request->actual_start_date;
        $PSUR->actual_end_date = $request->actual_end_date;
        $PSUR->authority_type = $request->authority_type;
        $PSUR->authority = $request->authority;
        $PSUR->introduction = $request->introduction;
        $PSUR->related_records = $request->related_records;
        $PSUR->world_ma_status = $request->world_ma_status;
        $PSUR->ra_actions_taken = $request->ra_actions_taken;
        $PSUR->mah_actions_taken = $request->mah_actions_taken;
        //----------------------------------------------------------------tab change----------------------------------------------------------------
        $PSUR->changes_to_safety_information = $request->changes_to_safety_information;
        $PSUR->patient_exposure = $request->patient_exposure;
        $PSUR->analysis_of_individual_case = $request->analysis_of_individual_case;
        $PSUR->newly_analyzed_studies = $request->newly_analyzed_studies;
        $PSUR->target_and_new_safety_studies = $request->target_and_new_safety_studies;
        $PSUR->publish_safety_studies = $request->publish_safety_studies;
        $PSUR->efficiency_related_info = $request->efficiency_related_info;
        $PSUR->late_breaking_information = $request->late_breaking_information;
        $PSUR->overall_safety_evaluation = $request->overall_safety_evaluation;
        $PSUR->conclusion = $request->conclusion;
        //----------------------------------------------------------------tab change----------------------------------------------------------------

         $PSUR->root_parent_manufaturer = $request->root_parent_manufaturer;
         $PSUR->root_parent_product_type = $request->root_parent_product_type;
         $PSUR->root_parent_trade_name = $request->root_parent_trade_name;
         $PSUR->international_birth_date = $request->international_birth_date;
         $PSUR->root_parent_api = $request->root_parent_api;
         $PSUR->root_parent_product_strength = $request->root_parent_product_strength;
         $PSUR->route_of_administration = $request->route_of_administration;
         $PSUR->root_parent_product_dosage_form = $request->root_parent_product_dosage_form;
         $PSUR->therapeutic_Area = $request->therapeutic_Area;
           //----------------------------------------------------------------tab change----------------------------------------------------------------

         $PSUR->registration_status = $request->registration_status;
         $PSUR->registration_number = $request->registration_number;
         $PSUR->planned_submission_date = $request->planned_submission_date;
         $PSUR->actual_submission_date = $request->actual_submission_date;
         $PSUR->comments = $request->comments;
         $PSUR->procedure_type = $request->procedure_type;
         $PSUR->procedure_number = $request->procedure_number;
         $PSUR->reference_member_state = $request->reference_member_state;
         $PSUR->renewal_rule = $request->renewal_rule;
         $PSUR->concerned_member_states = $request->concerned_member_states;

            $files = [];
            if ($request->hasfile('file_attachment')) {
                foreach ($request->file('file_attachment') as $file) {
                    $name = $request->name . 'file_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }

            $PSUR->file_attachment = json_encode($files);
            }

        $PSUR->update();

        $griddata = $PSUR->id;
        $parent = PsurGrid::where(['psur_id' => $griddata, 'identifier' => 'ATC Codes'])->firstOrNew();
         $parent->psur_id = $griddata;
         $parent->identifier = 'ATC Codes';
         $parent->data = $request->ATCCodes;
         $parent->save();
        //  --------------------------------------Ingridents------------------------------------------//

         $ingrident = PsurGrid::where(['psur_id' => $griddata, 'identifier' => 'Ingredients'])->firstOrNew();
         $ingrident->psur_id = $griddata;
         $ingrident->identifier = 'Ingredients';
         $ingrident->data = $request->ingridents;
         $ingrident->Update();
         //  --------------------------------------Product/Material------------------------------------------//

         $Product = PsurGrid::where(['psur_id' => $griddata, 'identifier' => 'Product'])->firstOrNew();
         $Product->psur_id = $griddata;
         $Product->identifier = 'Product';
         $Product->data = $request->Product;
         $Product->Update();
         //  -------------------------------------- Packaging Information------------------------------------------//

         $information = PsurGrid::where(['psur_id' => $griddata, 'identifier' => 'Packaging Information'])->firstOrNew();
         $information->psur_id = $griddata;
         $information->identifier = 'Packaging Information';
         $information->data = $request->pacaging_information;
         $information->Update();

        if ($lastDocument->short_description != $PSUR->short_description  ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Short Description')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastDocument->short_description;
            $history->current = $PSUR->short_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }

        if ($PSUR->date_of_initiation != $lastDocument->date_of_initiation) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Date Of Initiation')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Date Of Initiation';
            $history->previous = $lastDocument->date_of_initiation;
            $history->current = $PSUR->date_of_initiation;
            $history->comment = $request->date_of_initiation_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }

        if ($lastDocument->assigned_to != $lastDocument->assigned_to ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Assigned To')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Assigned To';
            $history->previous = $lastDocument->assigned_to;
            $history->current = $PSUR->assigned_to;
            $history->comment = $request->assigned_to_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->due_date != $lastDocument->due_date) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Due Date')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Due Date';
            $history->previous = $lastDocument->due_date;
            $history->current = $PSUR->due_date;
            $history->comment = $request->due_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->documents != $lastDocument->documents) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Documents')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Documents';
            $history->previous = $lastDocument->documents;
            $history->current = $PSUR->documents;
            $history->comment = $request->documents_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }

        if ($lastDocument->type_new != $lastDocument->type_new) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type','Type')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Type';
            $history->previous = $lastDocument->type_new;
            $history->current = $PSUR->type_new;
            $history->comment = $request->type_new_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->year != $PSUR->year) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Year')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Year';
            $history->previous = $lastDocument->year;
            $history->current = $PSUR->year;
            $history->comment = $request->year_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->actual_start_date != $PSUR->actual_start_date ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Actual start date')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Actual start date';
            $history->previous = $lastDocument->actual_start_date;
            $history->current = $PSUR->actual_start_date;
            $history->comment = $request->actual_start_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->actual_end_date != $PSUR->actual_end_date ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type','Actual end date')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Actual end date';
            $history->previous = $lastDocument->actual_end_date;
            $history->current = $PSUR->actual_end_date;
            $history->comment = $request->actual_end_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->authority_type != $PSUR->authority_type ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Authority Type')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Authority Type';
            $history->previous = $lastDocument->authority_type;
            $history->current = $PSUR->authority_type;
            $history->comment = $request->authority_type_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->authority != $PSUR->authority ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Authority')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Authority';
            $history->previous = $lastDocument->authority;
            $history->current = $PSUR->authority;
            $history->comment = $request->authority_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->introduction != $PSUR->introduction ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Introduction')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Introduction';
            $history->previous = $lastDocument->introduction;
            $history->current = $PSUR->introduction;
            $history->comment = $request->introduction_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->related_records != $PSUR->related_records ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Related Records')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Related Records';
            $history->previous = $lastDocument->related_records;
            $history->current = $PSUR->related_records;
            $history->comment = $request->related_records_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->world_ma_status != $PSUR->world_ma_status ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'World MA Status')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'World MA Status';
            $history->previous = $lastDocument->world_ma_status;
            $history->current = $PSUR->world_ma_status;
            $history->comment = $request->world_ma_status_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->ra_actions_taken != $PSUR->ra_actions_taken ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'RA Action Taken')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'RA Action Taken';
            $history->previous = $lastDocument->ra_actions_taken;
            $history->current = $PSUR->ra_actions_taken;
            $history->comment = $request->ra_actions_taken_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->mah_actions_taken != $PSUR->mah_actions_taken ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'MAH Action Taken')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'MAH Action Taken';
            $history->previous = $lastDocument->mah_actions_taken;
            $history->current = $PSUR->mah_actions_taken;
            $history->comment = $request->mah_actions_taken_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->changes_to_safety_information != $PSUR->changes_to_safety_information ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Changes to safety_information')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Changes to safety_information';
            $history->previous = $lastDocument->changes_to_safety_information;
            $history->current = $PSUR->changes_to_safety_information;
            $history->comment = $request->changes_to_safety_information_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->patient_exposure != $PSUR->patient_exposure ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Patient Exposure')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Patient Exposure';
            $history->previous = $lastDocument->patient_exposure;
            $history->current = $PSUR->patient_exposure;
            $history->comment = $request->patient_exposure_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->analysis_of_individual_case != $PSUR->analysis_of_individual_case ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Analysis of individual case')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Analysis of individual case';
            $history->previous = $lastDocument->analysis_of_individual_case;
            $history->current = $PSUR->analysis_of_individual_case;
            $history->comment = $request->analysis_of_individual_case_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->newly_analyzed_studies != $PSUR->newly_analyzed_studies ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Newly Analyzed Studies')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Newly Analyzed Studies';
            $history->previous = $lastDocument->newly_analyzed_studies;
            $history->current = $PSUR->newly_analyzed_studies;
            $history->comment = $request->newly_analyzed_studies_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->target_and_new_safety_studies != $PSUR->target_and_new_safety_studies ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Target and New Safety Studies')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Target and New Safety Studies';
            $history->previous = $lastDocument->target_and_new_safety_studies;
            $history->current = $PSUR->target_and_new_safety_studies;
            $history->comment = $request->target_and_new_safety_studies_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->publish_safety_studies != $PSUR->publish_safety_studies ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Publish Safety Studies')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Publish Safety Studies';
            $history->previous = $lastDocument->publish_safety_studies;
            $history->current = $PSUR->publish_safety_studies;
            $history->comment = $request->publish_safety_studies_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->efficiency_related_info != $PSUR->efficiency_related_info ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Efficiency Related Information')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Efficiency Related Information';
            $history->previous = $lastDocument->efficiency_related_info;
            $history->current = $PSUR->efficiency_related_info;
            $history->comment = $request->efficiency_related_info_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->late_breaking_information != $PSUR->late_breaking_information ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Late Breaking Information')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Late Breaking Information';
            $history->previous = $lastDocument->late_breaking_information;
            $history->current = $PSUR->late_breaking_information;
            $history->comment = $request->late_breaking_information_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->overall_safety_evaluation != $PSUR->overall_safety_evaluation ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Overall Safety Evaluation')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Overall Safety Evaluation';
            $history->previous = $lastDocument->overall_safety_evaluation;
            $history->current = $PSUR->overall_safety_evaluation;
            $history->comment = $request->overall_safety_evaluation_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->conclusion != $PSUR->conclusion ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Conclusion')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Conclusion';
            $history->previous = $lastDocument->conclusion;
            $history->current = $PSUR->conclusion;
            $history->comment = $request->conclusion_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->root_parent_product_type != $PSUR->root_parent_product_type ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Root Parent Product Type')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Root Parent Product Type';
            $history->previous = $lastDocument->root_parent_product_type;
            $history->current = $PSUR->root_parent_product_type;
            $history->comment = $request->root_parent_product_type_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->root_parent_trade_name != $PSUR->root_parent_trade_name ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Root Parent Trade Name')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Root Parent Trade Name';
            $history->previous = $lastDocument->root_parent_trade_name;
            $history->current = $PSUR->root_parent_trade_name;
            $history->comment = $request->root_parent_trade_name_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->international_birth_date != $PSUR->international_birth_date ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'International Birth Date')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'International Birth Date';
            $history->previous = $lastDocument->international_birth_date;
            $history->current = $PSUR->international_birth_date;
            $history->comment = $request->international_birth_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->root_parent_api != $PSUR->root_parent_api ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Root Prent API')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Root Prent API';
            $history->previous = $lastDocument->root_parent_api;
            $history->current = $PSUR->root_parent_api;
            $history->comment = $request->root_parent_api_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->root_parent_product_strength != $PSUR->root_parent_product_strength ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Root Parent product strength')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Root Parent product strength';
            $history->previous = $lastDocument->root_parent_product_strength;
            $history->current = $PSUR->root_parent_product_strength;
            $history->comment = $request->root_parent_product_strength_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->route_of_administration != $PSUR->route_of_administration ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Route of administration')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Route of administration';
            $history->previous = $lastDocument->route_of_administration;
            $history->current = $PSUR->route_of_administration;
            $history->comment = $request->route_of_administration_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->root_parent_product_dosage_form != $PSUR->root_parent_product_dosage_form ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Root Parent Dosage from')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Root Parent Dosage from';
            $history->previous = $lastDocument->root_parent_product_dosage_form;
            $history->current = $PSUR->root_parent_product_dosage_form;
            $history->comment = $request->root_parent_product_dosage_form_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->therapeutic_Area != $PSUR->therapeutic_Area ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type','Therapeutic Area')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Therapeutic Area';
            $history->previous = $lastDocument->therapeutic_Area;
            $history->current = $PSUR->therapeutic_Area;
            $history->comment = $request->therapeutic_Area_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->registration_status != $PSUR->registration_status ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Registration status')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Registration status';
            $history->previous = $lastDocument->registration_status;
            $history->current = $PSUR->registration_status;
            $history->comment = $request->registration_status_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->registration_number != $PSUR->registration_number ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Registration Number')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Registration Number';
            $history->previous = $lastDocument->registration_number;
            $history->current = $PSUR->registration_number;
            $history->comment = $request->registration_number_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->planned_submission_date != $PSUR->planned_submission_date ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Planned Submission Date')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Planned Submission Date';
            $history->previous = $lastDocument->planned_submission_date;
            $history->current = $PSUR->planned_submission_date;
            $history->comment = $request->planned_submission_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->actual_submission_date != $PSUR->actual_submission_date ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Actual Submission Date')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Actual Submission Date';
            $history->previous = $lastDocument->actual_submission_date;
            $history->current = $PSUR->actual_submission_date;
            $history->comment = $request->actual_submission_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->comments != $PSUR->comments ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Comments')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Comments';
            $history->previous = $lastDocument->comments;
            $history->current = $PSUR->comments;
            $history->comment = $request->comments_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->procedure_type != $PSUR->procedure_type ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Procedure Type')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Procedure Type';
            $history->previous = $lastDocument->procedure_type;
            $history->current = $PSUR->procedure_type;
            $history->comment = $request->procedure_type_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->procedure_number != $PSUR->procedure_number ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Procedure Number')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Procedure Number';
            $history->previous = $lastDocument->procedure_number;
            $history->current = $PSUR->procedure_number;
            $history->comment = $request->procedure_number_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->reference_member_state != $PSUR->reference_member_state ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Reference Member State')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Reference Member State';
            $history->previous = $lastDocument->reference_member_state;
            $history->current = $PSUR->reference_member_state;
            $history->comment = $request->reference_member_state_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->renewal_rule != $PSUR->renewal_rule  ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Renewal Rule')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Renewal Rule';
            $history->previous = $lastDocument->renewal_rule;
            $history->current = $PSUR->renewal_rule;
            $history->comment = $request->renewal_rule_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        if ($lastDocument->concerned_member_states != $PSUR->concerned_member_states ) {
            $lastDocumentAuditTrail = psur_audit_trail::where('psur_id', $PSUR->id)
            ->where('activity_type', 'Concerned Member States')
            ->exists();

            $history = new psur_audit_trail();
            $history->psur_id = $PSUR->id;
            $history->activity_type = 'Concerned Member States';
            $history->previous = $lastDocument->concerned_member_states;
            $history->current = $PSUR->concerned_member_states;
            $history->comment = $request->concerned_member_states_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            $history->change_to = "Not Applicable";
            $history->change_from  = $lastDocument->status;
            // $history->origin_state = $PSUR->status;
            $history->save();
        }
        return redirect()->back()->with('success', 'PSUR Updated successfully');
    }

    public function psur_cancel(Request $request, $id)
    {
        $device = PSUR::find($id);
        if ($device->stage == 1) {
            $device->stage = "0";
            $device->status = "Closed-Cancelled";
            $device->update();
            toastr()->success('Document Sent');
            return back();
        }
        if ($device->stage == 2) {
            $device->stage = "0";
            $device->status = "Closed-Cancelled";
            $device->update();
            toastr()->success('Document Sent');
            return back();
        }
        if ($device->stage == 3) {
            $device->stage = "0";
            $device->status = "Closed-Cancelled";
            $device->update();
            toastr()->success('Document Sent');
            return back();
        }

        if ($device->stage == 4) {
            $device->stage = "-1";
            $device->status = "Closed-withdrawn";
            $device->update();
            toastr()->success('Document Sent');
            return back();
        }

    }

    public function stageChange(Request $request, $id)
    {
        if($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password))
        {
            $device = PSUR::find($id);
            $lastDocument = PSUR::find($id);

            if ($device->stage == 1) {
                $device->stage = "2";
                $device->status = "Submission Preparation";

                $device->started_by = Auth::user()->name;
                $device->started_on = Carbon::now()->format('d-M-Y');
                // $device->cancelled_comment = $request->comment;
                $history = new psur_audit_trail();
                $history->psur_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->started_by;
                $history->current = $device->started_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = '2';
                $history->change_to = "Submission Preparation";
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Submit';
                $history->save();

                $device->update();
                toastr()->success('Document Sent');
                return back();
            }

        if ($device->stage == 2) {
            $device->stage = "3";
            $device->status = "Pending Submission Review";
            $device->approved_by = Auth::user()->name;
            $device->approved_on = Carbon::now()->format('d-M-Y');
            // $device->cancelled_comment = $request->comment;
            $history = new psur_audit_trail();
            $history->psur_id = $id;
            $history->activity_type = 'Activity Log';
            $history->previous = $lastDocument->approved_by;
            $history->current = $device->approved_by;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->stage = '3';
            $history->change_to = "Pending Submission Review";
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Submit for review';
            $history->save();
            $device->update();
            toastr()->success('Document Sent');
            return back();
        }
        if ($device->stage == 3) {
            $device->stage = "4";
            $device->status = "Authority Assessment";
            $device->withdrawn_by = Auth::user()->name;
            $device->withdrawn_on = Carbon::now()->format('d-M-Y');
            // $device->cancelled_comment = $request->comment;
            $history = new psur_audit_trail();
            $history->psur_id = $id;
            $history->activity_type = 'Activity Log';
            $history->previous = $lastDocument->withdrawn_by;
            $history->current = $device->withdrawn_by;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->stage = '4';
            $history->change_to = "Authority Assessment";
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Submit for review';
            $history->save();
            $device->update();
            toastr()->success('Document Sent');
            return back();
        }
        if ($device->stage == 4) {
            $device->stage = "5";
            $device->status = "Closed Done";
            // $device->withdrawn_by = Auth::user()->name;
            // $device->withdrawn_on = Carbon::now()->format('d-M-Y');
            // $device->cancelled_comment = $request->comment;
            $history = new psur_audit_trail();
            $history->psur_id = $id;
            $history->activity_type = 'Activity Log';
            // $history->previous = $lastDocument->withdrawn_by;
            // $history->current = $device->withdrawn_by;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->stage = '5';
            $history->change_to = "Authority Assessment";
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Closed Done';
            $history->save();
            $device->update();
            toastr()->success('Document Sent');
            return back();
        }

        }else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

      public static function singleReport($id)
    {
        $data = PSUR::find($id);
        // dd($data);
        if (!empty ($data)) {
            $data->initiator = User::where('id', $data->initiator)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.New_forms.singleReportPSUR', compact('data'))
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
            return $pdf->stream('PSUR' . $id . '.pdf');
        }

    }


    public function auditTrialshow($id)
    {
        $audit = psur_audit_trail::where("PSUR_id", $id)->orderByDESC('id')->paginate(20);
        $today = Carbon::now()->format('Y-m-d');
        $document = PSUR::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');

        return view('frontend.New_forms.psur_audit_trail', compact('audit', 'document', 'today'));
    }
    public function auditTrailPdf($id){
        $doc = PSUR::find($id);
        $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        $data = psur_audit_trail::where('psur_id', $doc->id)->orderByDesc('id')->get();
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.New_forms.Psur_audit_trail_pdf', compact('data', 'doc'))
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



    // public function PsurAuditTrialDetails($id)
    // {
    //     $detail =psur_audit_trail::find($id);
    //     $detail_data = PSUR::where('activity_type', $detail->activity_type)->where('deviation_id', $detail->deviation_id)->latest()->get();
    //     $doc = PSUR::where('id', $detail->deviation_id)->first();
    //     $doc->origiator_name = User::find($doc->initiator_id);
    //     return view('frontend.New_forms.psur-audit-trail-inner', compact('detail', 'doc', 'detail_data'));
    // }


    public function stagereject(Request $request,$id){
        if($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password))
        {
            $device = PSUR::find($id);
            $lastDocument = PSUR::find($id);

            if($device->stage == 1){
                $device->stage = "0";
                $device->status = "Opened";
                $history = new psur_audit_trail();
                $history->psur_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->started_by;
                $history->current = $device->started_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = '0';
                $history->change_to = "cancel";
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Request more info.';
                $history->save();
                $device->update();
                toastr()->success('Document Sent');
                return back();
            }
            if($device->stage == 2){
                $device->stage = "1";
                $device->status = "Opened";
                $history = new psur_audit_trail();
                $history->psur_id = $id;
                $history->activity_type = 'Activity Log';
                // $history->previous = $lastDocument->started_by;
                // $history->current = $device->started_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = '0';
                $history->change_to = "cancel";
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Request more info.';
                $history->save();
                $device->update();
                toastr()->success('Document Sent');
                return back();
            }
            if($device->stage == 3){
                $device->stage = "1";
                $device->status = "Opened";
                $history = new psur_audit_trail();
                $history->psur_id = $id;
                $history->activity_type = 'Activity Log';
                // $history->previous = $lastDocument->started_by;
                // $history->current = $device->started_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = '1';
                $history->change_to = "opened";
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Request more info.';
                $history->save();
                $device->update();
                toastr()->success('Document Sent');
                return back();
            }

            }
            else{
                toastr()->error('E-signature Not match');
                return back();
            }
        }

        public static function auditReport($id)
    {
        $doc = PSUR::find($id);
        if (!empty($doc)) {
            $doc->initiator_id = User::where('id', $doc->initiator_id)->value('name');
            $data = psur_audit_trail::where('PSUR_id', $id)->get();
            $audit = psur_audit_trail::where('PSUR_id', $id)->get();

            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.New_forms.psur_auditpdf', compact('data', 'doc','audit'))
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
            return $pdf->stream('PSUR-Audit' . $id . '.pdf');
        }
    }


}




