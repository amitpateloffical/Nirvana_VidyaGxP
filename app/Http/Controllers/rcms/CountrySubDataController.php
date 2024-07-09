<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecordNumber;
use App\Models\CountrySubData;
use App\Models\CountrySubGrid;
use App\Models\RoleGroup;
use App\Models\CountrySubHistory;
use App\Models\CountrySubAuditTrail;
use App\Models\User;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class CountrySubDataController extends Controller
{
    public function country_submission()
    {
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view("frontend.ctms.country_sub_data", compact('due_date', 'record_number'));
    }

    public function country_store(Request $request)
    {
        if (!$request->short_description) {
            toastr()->error("Short description is required");
              return redirect()->back();
         }

         $country = new CountrySubData();
         $country->form_type_new = "Country-Submission-Data";
         $country->originator_id = Auth::user()->name;
         $country->record = ((RecordNumber::first()->value('counter')) + 1);
         $country->initiator_id = Auth::user()->id;
         $country->intiation_date = $request->intiation_date;
         $country->short_description =($request->short_description);
         $country->assigned_to = $request->assigned_to;
         $country->due_date = $request->due_date;
         $country->type = $request->type;
         $country->other_type = $request->other_type;

         if (!empty($request->attached_files)){
            $files = [];
            if ($request->hasfile('attached_files')){
                foreach ($request->file('attached_files') as $file){
                    $name = $request->name . 'attached_files' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/',$name);
                    $files[] = $name;
                }
            }
            $country->attached_files = json_encode($files);
         }

         $country->related_urls = $request->related_urls;
         $country->descriptions = $request->descriptions;
         $country->zone = $request->zone;
         $country->country = $request->country;
         $country->city = $request->city;
         $country->state_district = $request->state_district;
         $country->manufacturer = $request->manufacturer;
         $country->number_id = $request->number_id;
         $country->project_code = $request->project_code;
         $country->authority_type = $request->authority_type;
         $country->authority = $request->authority;
         $country->priority_level = $request->priority_level;
         $country->other_authority = $request->other_authority;
         $country->approval_status = $request->approval_status;
         $country->managed_by_company = $request->managed_by_company;
         $country->marketing_status = $request->marketing_status;
         $country->therapeutic_area = $request->therapeutic_area;
         $country->end_of_trial_date_status = $request->end_of_trial_date_status;
         $country->protocol_type = $request->protocol_type;
         $country->registration_status = $request->registration_status;
         $country->unblinded_SUSAR_to_CEC = $request->unblinded_SUSAR_to_CEC;
         $country->trade_name = $request->trade_name;
         $country->dosage_form = $request->dosage_form;
         $country->photocure_trade_name = $request->photocure_trade_name;
         $country->currency = $request->currency;
         
         if (!empty($request->attacehed_payments)){
            $files = [];
            if ($request->hasfile('attacehed_payments')){
                foreach ($request->file('attacehed_payments') as $file){
                    $name = $request->name . 'attacehed_payments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/',$name);
                    $files[] = $name;
                }
            }
            $country->attacehed_payments = json_encode($files);
         }

         $country->follow_up_documents = $request->follow_up_documents;
         $country->hospitals = $request->hospitals;
         $country->vendors = $request->vendors;
         $country->INN = $request->INN;
         $country->route_of_administration = $request->route_of_administration;
         $country->first_IB_version = $request->first_IB_version;
         $country->first_protocol_version = $request->first_protocol_version;
         $country->eudraCT_number = $request->eudraCT_number;
         $country->budget = $request->budget;
         $country->phase_of_study = $request->phase_of_study;
         $country->related_clinical_trials = $request->related_clinical_trials;
         $country->data_safety_notes = $request->data_safety_notes;
         $country->comments = $request->comments;
         $country->annual_IB_update_date_due = $request->annual_IB_update_date_due;
         $country->date_of_first_IB = $request->date_of_first_IB;
         $country->date_of_first_protocol = $request->date_of_first_protocol;
         $country->date_safety_report = $request->date_safety_report;
         $country->date_trial_active = $request->date_trial_active;
         $country->end_of_study_report_date = $request->end_of_study_report_date;
         $country->end_of_study_synopsis_date = $request->end_of_study_synopsis_date;
         $country->end_of_trial_date = $request->end_of_trial_date;
         $country->last_visit = $request->last_visit;
         $country->next_visit = $request->next_visit;
         $country->ethics_commitee_approval = $request->ethics_commitee_approval;
         $country->safety_impact_risk = $request->safety_impact_risk;
         $country->CROM = $request->CROM;
         $country->lead_investigator = $request->lead_investigator;
         $country->assign_to = $request->assign_to;
         $country->sponsor = $request->sponsor;
         $country->additional_investigators = $request->additional_investigators;
         $country->clinical_events_committee = $request->clinical_events_committee;
         $country->clinical_research_team = $request->clinical_research_team;
         $country->data_safety_monitoring_board = $request->data_safety_monitoring_board;
         $country->distribution_list = $request->distribution_list;

         $country->status = 'Opened';
         $country->stage = 1;
         $country->save();

         $record = RecordNumber::first();
         $record->counter = ((RecordNumber::first()->value('counter')) + 1);
         $record->update(); 

         if (!empty($country->originator_id)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Initiated By';
            $history->previous = "Null";
            $history->current = $country->originator_id;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->short_description)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Null";
            $history->current = $country->short_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->assigned_to)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Assigned To';
            $history->previous = "Null";
            $history->current = $country->assigned_to;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->due_date)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Due Date';
            $history->previous = "Null";
            $history->current = $country->due_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->type)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Type';
            $history->previous = "Null";
            $history->current = $country->type;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->other_type)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Other Type';
            $history->previous = "Null";
            $history->current = $country->other_type;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->attached_files)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Attached Files';
            $history->previous = "Null";
            $history->current = $country->attached_files;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->related_urls)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Related Urls';
            $history->previous = "Null";
            $history->current = $country->related_urls;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->descriptions)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Descriptions';
            $history->previous = "Null";
            $history->current = $country->descriptions;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->zone)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Zone';
            $history->previous = "Null";
            $history->current = $country->zone;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->country)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Country';
            $history->previous = "Null";
            $history->current = $country->country;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->city)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'City';
            $history->previous = "Null";
            $history->current = $country->city;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->state_district)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'State District';
            $history->previous = "Null";
            $history->current = $country->state_district;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->manufacturer)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Manufacturer';
            $history->previous = "Null";
            $history->current = $country->manufacturer;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->number_id)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Number Id';
            $history->previous = "Null";
            $history->current = $country->number_id;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->project_code)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Project Code';
            $history->previous = "Null";
            $history->current = $country->project_code;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->authority_type)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Authority Type';
            $history->previous = "Null";
            $history->current = $country->authority_type;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->authority)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Authority';
            $history->previous = "Null";
            $history->current = $country->authority;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->priority_level)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Priority Level';
            $history->previous = "Null";
            $history->current = $country->priority_level;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->other_authority)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Other Authority';
            $history->previous = "Null";
            $history->current = $country->other_authority;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->approval_status)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Approval Status';
            $history->previous = "Null";
            $history->current = $country->approval_status;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->managed_by_company)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Managed By Company';
            $history->previous = "Null";
            $history->current = $country->managed_by_company;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->marketing_status)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Marketing Status';
            $history->previous = "Null";
            $history->current = $country->marketing_status;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->therapeutic_area)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Therapeutic Area';
            $history->previous = "Null";
            $history->current = $country->therapeutic_area;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->end_of_trial_date_status)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'End Of Trial Date Status';
            $history->previous = "Null";
            $history->current = $country->end_of_trial_date_status;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->protocol_type)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Protocol Type';
            $history->previous = "Null";
            $history->current = $country->protocol_type;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->registration_status)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Registration Status';
            $history->previous = "Null";
            $history->current = $country->registration_status;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->unblinded_SUSAR_to_CEC)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Unblinded SUSAR To CEC';
            $history->previous = "Null";
            $history->current = $country->unblinded_SUSAR_to_CEC;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->trade_name)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Trade Name';
            $history->previous = "Null";
            $history->current = $country->trade_name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->dosage_form)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Dosage Form';
            $history->previous = "Null";
            $history->current = $country->dosage_form;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->photocure_trade_name)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Photocure Trade Name';
            $history->previous = "Null";
            $history->current = $country->photocure_trade_name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->currency)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Currency';
            $history->previous = "Null";
            $history->current = $country->currency;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->attacehed_payments)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Attacehed Payments';
            $history->previous = "Null";
            $history->current = $country->attacehed_payments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->follow_up_documents)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Follow Up Documents';
            $history->previous = "Null";
            $history->current = $country->follow_up_documents;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->hospitals)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Hospitals';
            $history->previous = "Null";
            $history->current = $country->hospitals;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->vendors)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Vendors';
            $history->previous = "Null";
            $history->current = $country->vendors;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->INN)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'INN';
            $history->previous = "Null";
            $history->current = $country->INN;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->route_of_administration)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Route Of Administration';
            $history->previous = "Null";
            $history->current = $country->route_of_administration;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->first_IB_version)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'First IB Version';
            $history->previous = "Null";
            $history->current = $country->first_IB_version;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->first_protocol_version)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'First Protocol Version';
            $history->previous = "Null";
            $history->current = $country->first_protocol_version;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->eudraCT_number)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'EudraCT Number';
            $history->previous = "Null";
            $history->current = $country->eudraCT_number;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->budget)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Budget';
            $history->previous = "Null";
            $history->current = $country->budget;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->phase_of_study)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Phase Of Study';
            $history->previous = "Null";
            $history->current = $country->phase_of_study;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->related_clinical_trials)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Related Clinical Trials';
            $history->previous = "Null";
            $history->current = $country->related_clinical_trials;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->data_safety_notes)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Data Safety Notes';
            $history->previous = "Null";
            $history->current = $country->data_safety_notes;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->comments)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Comments';
            $history->previous = "Null";
            $history->current = $country->comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->annual_IB_update_date_due)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Annual IB Update Date Due';
            $history->previous = "Null";
            $history->current = $country->annual_IB_update_date_due;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->date_of_first_IB)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Date Of First IB';
            $history->previous = "Null";
            $history->current = $country->date_of_first_IB;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->date_of_first_protocol)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Date Of First Protocol';
            $history->previous = "Null";
            $history->current = $country->date_of_first_protocol;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->date_safety_report)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Date Safety Report';
            $history->previous = "Null";
            $history->current = $country->date_safety_report;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->date_trial_active)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Date Trial Active';
            $history->previous = "Null";
            $history->current = $country->date_trial_active;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->end_of_study_report_date)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'End Of Study Report Date';
            $history->previous = "Null";
            $history->current = $country->end_of_study_report_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->end_of_study_synopsis_date)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'End Of Study Synopsis Date';
            $history->previous = "Null";
            $history->current = $country->end_of_study_synopsis_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->end_of_trial_date)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'End Of Trial Date';
            $history->previous = "Null";
            $history->current = $country->end_of_trial_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->end_of_trial_date)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'End Of Trial Date';
            $history->previous = "Null";
            $history->current = $country->end_of_trial_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->last_visit)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Last Visit';
            $history->previous = "Null";
            $history->current = $country->last_visit;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->next_visit)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Next Visit';
            $history->previous = "Null";
            $history->current = $country->next_visit;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->ethics_commitee_approval)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Ethics Commitee Approval';
            $history->previous = "Null";
            $history->current = $country->ethics_commitee_approval;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->safety_impact_risk)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Safety Impact Risk';
            $history->previous = "Null";
            $history->current = $country->safety_impact_risk;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->CROM)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'CROM';
            $history->previous = "Null";
            $history->current = $country->CROM;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->lead_investigator)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Lead Investigator';
            $history->previous = "Null";
            $history->current = $country->lead_investigator;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->sponsor)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Sponsor';
            $history->previous = "Null";
            $history->current = $country->sponsor;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->additional_investigators)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Additional Investigators';
            $history->previous = "Null";
            $history->current = $country->additional_investigators;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->clinical_events_committee)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Clinical Events Committee';
            $history->previous = "Null";
            $history->current = $country->clinical_events_committee;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->clinical_research_team)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Clinical Research Team';
            $history->previous = "Null";
            $history->current = $country->clinical_research_team;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->data_safety_monitoring_board)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Data Safety Monitoring Board';
            $history->previous = "Null";
            $history->current = $country->data_safety_monitoring_board;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($country->distribution_list)) {
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Distribution List';
            $history->previous = "Null";
            $history->current = $country->distribution_list;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $country->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }



        //==================GRID=======================
        //for product material
        $griddata = $country->id;

        $newData = CountrySubGrid::where(['c_id' => $griddata, 'identifer' => 'ProductMaterialDetails'])->firstOrNew();
        $newData->c_id = $griddata;
        $newData->identifer = 'ProductMaterialDetails';
        $newData->data = $request->serial_number_gi;
        $newData->save();


        $financial = CountrySubGrid::where(['c_id' => $griddata, 'identifer' => 'FinancialTransactions'])->firstOrNew();
        $financial->c_id = $griddata;
        $financial->identifer = 'FinancialTransactions';
        $financial->data = $request->financial_transection;
        $financial->save();


        $ingredient = CountrySubGrid::where(['c_id' => $griddata, 'identifer' => 'Ingredients'])->firstOrNew();
        $ingredient->c_id = $griddata;
        $ingredient->identifer = 'Ingredients';
        $ingredient->data = $request->ingredi;
        $ingredient->save();

           //=========================================

         toastr()->success("Record is created Successfully");
         return redirect(url('rcms/qms-dashboard'));

    }

    public function country_update(Request $request, $id)
    {

        if (!$request->short_description) {
            toastr()->error("Short description is required");
              return redirect()->back();
         }
         
        // $lastData =  CountrySubData::find($id);
        $country = CountrySubData::find($id);

        $lastDocument = CountrySubData::find($id);
        $lastdata = CountrySubData::find($id);
        $lastDocumentRecord = CountrySubData::find($country->id);
        $lastDocumentStatus = $lastDocumentRecord ? $lastDocumentRecord->status : null;

        //  $country->form_type_new = "Country-Submission-Data";
        //  $country->originator_id = Auth::user()->name;
        //  $country->form_type_new = "Country-Submission-Data";
        //  $country->record = ((RecordNumber::first()->value('counter')) + 1);
        //  $country->initiator_id = Auth::user()->id;
        //  $country->intiation_date = $request->intiation_date;
         $country->short_description =($request->short_description);
         $country->assigned_to = $request->assigned_to;
         $country->due_date = $request->due_date;
         $country->type = $request->type;
         $country->other_type = $request->other_type;

         if (!empty($request->attached_files)){
            $files = [];
            if ($request->hasfile('attached_files')){
                foreach ($request->file('attached_files') as $file){
                    $name = $request->name . 'attached_files' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/',$name);
                    $files[] = $name;
                }
            }
            $country->attached_files = json_encode($files);
         }

         $country->related_urls = $request->related_urls;
         $country->descriptions = $request->descriptions;
         $country->zone = $request->zone;
         $country->country = $request->country;
         $country->city = $request->city;
         $country->state_district = $request->state_district;
         $country->manufacturer = $request->manufacturer;
         $country->number_id = $request->number_id;
         $country->project_code = $request->project_code;
         $country->authority_type = $request->authority_type;
         $country->authority = $request->authority;
         $country->priority_level = $request->priority_level;
         $country->other_authority = $request->other_authority;
         $country->approval_status = $request->approval_status;
         $country->managed_by_company = $request->managed_by_company;
         $country->marketing_status = $request->marketing_status;
         $country->therapeutic_area = $request->therapeutic_area;
         $country->end_of_trial_date_status = $request->end_of_trial_date_status;
         $country->protocol_type = $request->protocol_type;
         $country->registration_status = $request->registration_status;
         $country->unblinded_SUSAR_to_CEC = $request->unblinded_SUSAR_to_CEC;
         $country->trade_name = $request->trade_name;
         $country->dosage_form = $request->dosage_form;
         $country->photocure_trade_name = $request->photocure_trade_name;
         $country->currency = $request->currency;
         
         if (!empty($request->attacehed_payments)){
            $files = [];
            if ($request->hasfile('attacehed_payments')){
                foreach ($request->file('attacehed_payments') as $file){
                    $name = $request->name . 'attacehed_payments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/',$name);
                    $files[] = $name;
                }
            }
            $country->attacehed_payments = json_encode($files);
         }

         $country->follow_up_documents = $request->follow_up_documents;
         $country->hospitals = $request->hospitals;
         $country->vendors = $request->vendors;
         $country->INN = $request->INN;
         $country->route_of_administration = $request->route_of_administration;
         $country->first_IB_version = $request->first_IB_version;
         $country->first_protocol_version = $request->first_protocol_version;
         $country->eudraCT_number = $request->eudraCT_number;
         $country->budget = $request->budget;
         $country->phase_of_study = $request->phase_of_study;
         $country->related_clinical_trials = $request->related_clinical_trials;
         $country->data_safety_notes = $request->data_safety_notes;
         $country->comments = $request->comments;
         $country->annual_IB_update_date_due = $request->annual_IB_update_date_due;
         $country->date_of_first_IB = $request->date_of_first_IB;
         $country->date_of_first_protocol = $request->date_of_first_protocol;
         $country->date_safety_report = $request->date_safety_report;
         $country->date_trial_active = $request->date_trial_active;
         $country->end_of_study_report_date = $request->end_of_study_report_date;
         $country->end_of_study_synopsis_date = $request->end_of_study_synopsis_date;
         $country->end_of_trial_date = $request->end_of_trial_date;
         $country->last_visit = $request->last_visit;
         $country->next_visit = $request->next_visit;
         $country->ethics_commitee_approval = $request->ethics_commitee_approval;
         $country->safety_impact_risk = $request->safety_impact_risk;
         $country->CROM = $request->CROM;
         $country->lead_investigator = $request->lead_investigator;
         $country->assign_to = $request->assign_to;
         $country->sponsor = $request->sponsor;
         $country->additional_investigators = $request->additional_investigators;
         $country->clinical_events_committee = $request->clinical_events_committee;
         $country->clinical_research_team = $request->clinical_research_team;
         $country->data_safety_monitoring_board = $request->data_safety_monitoring_board;
         $country->distribution_list = $request->distribution_list;

         $country->update();

        $griddata = $country->id;

        $newData = CountrySubGrid::where(['c_id' => $griddata, 'identifer' => 'ProductMaterialDetails'])->firstOrNew();
        $newData->c_id = $griddata;
        $newData->identifer = 'ProductMaterialDetails';
        $newData->data = $request->serial_number_gi;
        $newData->update();

        $financial = CountrySubGrid::where(['c_id' => $griddata, 'identifer' => 'FinancialTransactions'])->firstOrNew();
        $financial->c_id = $griddata;
        $financial->identifer = 'FinancialTransactions';
        $financial->data = $request->financial_transection;
        $financial->update();


        $ingredient = CountrySubGrid::where(['c_id' => $griddata, 'identifer' => 'Ingredients'])->firstOrNew();
        $ingredient->c_id = $griddata;
        $ingredient->identifer = 'Ingredients';
        $ingredient->data = $request->ingredi;
        $ingredient->update();

        if($lastDocument->originator_id !=$resampling->originator_id || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Originator Id')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Originator Id';
            $history->previous =  $lastDocument->originator_id;
            $history->current = $country->originator_id;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->short_description !=$resampling->short_description || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Short Description')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Short Description';
            $history->previous =  $lastDocument->short_description;
            $history->current = $country->short_description;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->assigned_to !=$resampling->assigned_to || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Assigned To')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Assigned To';
            $history->previous =  $lastDocument->assigned_to;
            $history->current = $country->assigned_to;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->due_date !=$resampling->due_date || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Due Date')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Due Date';
            $history->previous =  $lastDocument->due_date;
            $history->current = $country->due_date;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->type !=$resampling->type || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Type')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Type';
            $history->previous =  $lastDocument->type;
            $history->current = $country->type;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }


        if($lastDocument->other_type !=$resampling->other_type || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Other Type')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Other Type';
            $history->previous =  $lastDocument->other_type;
            $history->current = $country->other_type;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->attached_files !=$resampling->attached_files || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Attached Files')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Attached Files';
            $history->previous =  $lastDocument->attached_files;
            $history->current = $country->attached_files;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->related_urls !=$resampling->related_urls || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Related Urls')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Related Urls';
            $history->previous =  $lastDocument->related_urls;
            $history->current = $country->related_urls;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->descriptions !=$resampling->descriptions || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Descriptions')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Descriptions';
            $history->previous =  $lastDocument->descriptions;
            $history->current = $country->descriptions;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->zone !=$resampling->zone || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Zone')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Zone';
            $history->previous =  $lastDocument->zone;
            $history->current = $country->zone;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->country !=$resampling->country || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Country')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Country';
            $history->previous =  $lastDocument->country;
            $history->current = $country->country;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->city !=$resampling->city || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'City')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'City';
            $history->previous =  $lastDocument->city;
            $history->current = $country->city;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->state_district !=$resampling->state_district || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'State District')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'State District';
            $history->previous =  $lastDocument->state_district;
            $history->current = $country->state_district;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->manufacturer !=$resampling->manufacturer || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Manufacturer')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Manufacturer';
            $history->previous =  $lastDocument->manufacturer;
            $history->current = $country->manufacturer;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->number_id !=$resampling->number_id || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Number Id')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Number Id';
            $history->previous =  $lastDocument->number_id;
            $history->current = $country->number_id;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->project_code !=$resampling->project_code || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Project Code')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Project Code';
            $history->previous =  $lastDocument->project_code;
            $history->current = $country->project_code;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->authority_type !=$resampling->authority_type || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Authority Type')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Authority Type';
            $history->previous =  $lastDocument->authority_type;
            $history->current = $country->authority_type;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->authority !=$resampling->authority || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Authority')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Authority';
            $history->previous =  $lastDocument->authority;
            $history->current = $country->authority;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->priority_level !=$resampling->priority_level || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Priority Level')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Priority Level';
            $history->previous =  $lastDocument->priority_level;
            $history->current = $country->priority_level;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->other_authority !=$resampling->other_authority || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Other Authority')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Other Authority';
            $history->previous =  $lastDocument->other_authority;
            $history->current = $country->other_authority;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->approval_status !=$resampling->approval_status || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Approval Status')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Approval Status';
            $history->previous =  $lastDocument->approval_status;
            $history->current = $country->approval_status;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->managed_by_company !=$resampling->managed_by_company || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Managed By Company')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Managed By Company';
            $history->previous =  $lastDocument->managed_by_company;
            $history->current = $country->managed_by_company;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->marketing_status !=$resampling->marketing_status || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Marketing Status')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Marketing Status';
            $history->previous =  $lastDocument->marketing_status;
            $history->current = $country->marketing_status;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->therapeutic_area !=$resampling->therapeutic_area || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Therapeutic Area')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Therapeutic Area';
            $history->previous =  $lastDocument->therapeutic_area;
            $history->current = $country->therapeutic_area;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->end_of_trial_date_status !=$resampling->end_of_trial_date_status || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'End of Trial Date Status')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'End of Trial Date Status';
            $history->previous =  $lastDocument->end_of_trial_date_status;
            $history->current = $country->end_of_trial_date_status;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->protocol_type !=$resampling->protocol_type || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Protocol Type')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Protocol Type';
            $history->previous =  $lastDocument->protocol_type;
            $history->current = $country->protocol_type;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->registration_status !=$resampling->registration_status || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Registration Status')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Registration Status';
            $history->previous =  $lastDocument->registration_status;
            $history->current = $country->registration_status;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }


        if($lastDocument->unblinded_SUSAR_to_CEC !=$resampling->unblinded_SUSAR_to_CEC || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Unblinded SUSAR To CEC')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Unblinded SUSAR To CEC';
            $history->previous =  $lastDocument->unblinded_SUSAR_to_CEC;
            $history->current = $country->unblinded_SUSAR_to_CEC;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }


        if($lastDocument->trade_name !=$resampling->trade_name || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Trade Name')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Trade Name';
            $history->previous =  $lastDocument->trade_name;
            $history->current = $country->trade_name;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->dosage_form !=$resampling->dosage_form || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Dosage Form')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Dosage Form';
            $history->previous =  $lastDocument->dosage_form;
            $history->current = $country->dosage_form;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }


        if($lastDocument->photocure_trade_name !=$resampling->photocure_trade_name || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Photocure Trade Name')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Photocure Trade Name';
            $history->previous =  $lastDocument->photocure_trade_name;
            $history->current = $country->photocure_trade_name;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->currency !=$resampling->currency || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Currency')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Currency';
            $history->previous =  $lastDocument->currency;
            $history->current = $country->currency;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->attacehed_payments !=$resampling->attacehed_payments || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Attacehed Payments')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Attacehed Payments';
            $history->previous =  $lastDocument->attacehed_payments;
            $history->current = $country->attacehed_payments;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->follow_up_documents !=$resampling->follow_up_documents || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Follow Up Documents')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Follow Up Documents';
            $history->previous =  $lastDocument->follow_up_documents;
            $history->current = $country->follow_up_documents;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->hospitals !=$resampling->hospitals || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Hospitals')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Hospitals';
            $history->previous =  $lastDocument->hospitals;
            $history->current = $country->hospitals;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->vendors !=$resampling->vendors || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Vendors')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Vendors';
            $history->previous =  $lastDocument->vendors;
            $history->current = $country->vendors;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }
        
        if($lastDocument->INN !=$resampling->INN || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'INN')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'INN';
            $history->previous =  $lastDocument->INN;
            $history->current = $country->INN;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->route_of_administration !=$resampling->route_of_administration || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Route of Administration')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Route of Administration';
            $history->previous =  $lastDocument->route_of_administration;
            $history->current = $country->route_of_administration;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->first_IB_version !=$resampling->first_IB_version || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'First IB Version')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'First IB Version';
            $history->previous =  $lastDocument->first_IB_version;
            $history->current = $country->first_IB_version;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->first_protocol_version !=$resampling->first_protocol_version || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'First Protocol Version')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'First Protocol Version';
            $history->previous =  $lastDocument->first_protocol_version;
            $history->current = $country->first_protocol_version;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->eudraCT_number !=$resampling->eudraCT_number || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'EudraCT Number')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'EudraCT Number';
            $history->previous =  $lastDocument->eudraCT_number;
            $history->current = $country->eudraCT_number;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->budget !=$resampling->budget || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Budget')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Budget';
            $history->previous =  $lastDocument->budget;
            $history->current = $country->budget;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->phase_of_study !=$resampling->phase_of_study || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Phase of Study')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Phase of Study';
            $history->previous =  $lastDocument->phase_of_study;
            $history->current = $country->phase_of_study;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->related_clinical_trials !=$resampling->related_clinical_trials || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Related Clinical Trials')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Related Clinical Trials';
            $history->previous =  $lastDocument->related_clinical_trials;
            $history->current = $country->related_clinical_trials;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->data_safety_notes !=$resampling->data_safety_notes || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Data Safety Notes')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Data Safety Notes';
            $history->previous =  $lastDocument->data_safety_notes;
            $history->current = $country->data_safety_notes;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->comments !=$resampling->comments || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Comments')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Comments';
            $history->previous =  $lastDocument->comments;
            $history->current = $country->comments;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->annual_IB_update_date_due !=$resampling->annual_IB_update_date_due || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Annual IB Update Date Due')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Annual IB Update Date Due';
            $history->previous =  $lastDocument->annual_IB_update_date_due;
            $history->current = $country->annual_IB_update_date_due;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->date_of_first_IB !=$resampling->date_of_first_IB || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Date of First IB')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Date of First IB';
            $history->previous =  $lastDocument->date_of_first_IB;
            $history->current = $country->date_of_first_IB;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->date_of_first_protocol !=$resampling->date_of_first_protocol || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Date of First Protocol')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Date of First Protocol';
            $history->previous =  $lastDocument->date_of_first_protocol;
            $history->current = $country->date_of_first_protocol;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->date_safety_report !=$resampling->date_safety_report || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Date Safety Report')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Date Safety Report';
            $history->previous =  $lastDocument->date_safety_report;
            $history->current = $country->date_safety_report;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->date_trial_active !=$resampling->date_trial_active || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Date Trial Active')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Date Trial Active';
            $history->previous =  $lastDocument->date_trial_active;
            $history->current = $country->date_trial_active;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->end_of_study_report_date !=$resampling->end_of_study_report_date || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'End of Study Report Date')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'End of Study Report Date';
            $history->previous =  $lastDocument->end_of_study_report_date;
            $history->current = $country->end_of_study_report_date;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->end_of_study_synopsis_date !=$resampling->end_of_study_synopsis_date || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'End of Study Synopsis Date')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'End of Study Synopsis Date';
            $history->previous =  $lastDocument->end_of_study_report_date;
            $history->current = $country->end_of_study_report_date;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->end_of_trial_date !=$resampling->end_of_trial_date || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'End of Trial Date')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'End of Trial Date';
            $history->previous =  $lastDocument->end_of_trial_date;
            $history->current = $country->end_of_trial_date;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->last_visit !=$resampling->last_visit || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Last Visit')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Last Visit';
            $history->previous =  $lastDocument->last_visit;
            $history->current = $country->last_visit;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->next_visit !=$resampling->next_visit || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Next Visit')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Next Visit';
            $history->previous =  $lastDocument->next_visit;
            $history->current = $country->next_visit;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->ethics_commitee_approval !=$resampling->ethics_commitee_approval || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Ethics Commitee Approval')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Ethics Commitee Approval';
            $history->previous =  $lastDocument->ethics_commitee_approval;
            $history->current = $country->ethics_commitee_approval;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->safety_impact_risk !=$resampling->safety_impact_risk || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'Safety Impact Risk')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'Safety Impact Risk';
            $history->previous =  $lastDocument->safety_impact_risk;
            $history->current = $country->safety_impact_risk;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        if($lastDocument->CROM !=$resampling->CROM || !empty($request->comment)) {
            $lastDocumentAuditTrail = CountrySubAuditTrail::where('country_id', $country->id)
                     ->where('activity_type', 'CROM')
                     ->exists();
            $history = new CountrySubAuditTrail();
            $history->country_id = $country->id;
            $history->activity_type = 'CROM';
            $history->previous =  $lastDocument->CROM;
            $history->current = $country->CROM;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state= $lastDocument->status;
            $history->change_to= "Not Applicable";
            $history->change_from= $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? "Update" : "New"; 
            $history->save();    
        }

        // if ($lastData->lead_investigator != $country->lead_investigator || !empty($request->comment)) {
        //     // return 'history';
        //     $history = new CountrySubAuditTrail();
        //     $history->country_id = $id;
        //     $history->activity_type = 'Lead Investigator';
        //     $history->previous = $lastData->lead_investigator;
        //     $history->current = $country->lead_investigator;
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

        // if ($lastData->sponsor != $country->sponsor || !empty($request->comment)) {
        //     // return 'history';
        //     $history = new CountrySubAuditTrail();
        //     $history->country_id = $id;
        //     $history->activity_type = 'Sponsor';
        //     $history->previous = $lastData->sponsor;
        //     $history->current = $country->sponsor;
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

        // if ($lastData->additional_investigators != $country->additional_investigators || !empty($request->comment)) {
        //     // return 'history';
        //     $history = new CountrySubAuditTrail();
        //     $history->country_id = $id;
        //     $history->activity_type = 'Additional Investigators';
        //     $history->previous = $lastData->additional_investigators;
        //     $history->current = $country->additional_investigators;
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

        // if ($lastData->clinical_events_committee != $country->clinical_events_committee || !empty($request->comment)) {
        //     // return 'history';
        //     $history = new CountrySubAuditTrail();
        //     $history->country_id = $id;
        //     $history->activity_type = 'Clinical Events Committee';
        //     $history->previous = $lastData->clinical_events_committee;
        //     $history->current = $country->clinical_events_committee;
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

        // if ($lastData->clinical_research_team != $country->clinical_research_team || !empty($request->comment)) {
        //     // return 'history';
        //     $history = new CountrySubAuditTrail();
        //     $history->country_id = $id;
        //     $history->activity_type = 'Clinical Research Team';
        //     $history->previous = $lastData->clinical_research_team;
        //     $history->current = $country->clinical_research_team;
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

        // if ($lastData->data_safety_monitoring_board != $country->data_safety_monitoring_board || !empty($request->comment)) {
        //     // return 'history';
        //     $history = new CountrySubAuditTrail();
        //     $history->country_id = $id;
        //     $history->activity_type = 'Data Safety Monitoring Board';
        //     $history->previous = $lastData->data_safety_monitoring_board;
        //     $history->current = $country->data_safety_monitoring_board;
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

        // if ($lastData->distribution_list != $country->distribution_list || !empty($request->comment)) {
        //     // return 'history';
        //     $history = new CountrySubAuditTrail();
        //     $history->country_id = $id;
        //     $history->activity_type = 'Distribution List';
        //     $history->previous = $lastData->distribution_list;
        //     $history->current = $country->distribution_list;
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

        toastr()->success("Record is update Successfully");
        return back();

    }

    public function country_show($id)
    {
        $data = CountrySubData::find($id);
        if(empty($data)) {
            toastr()->error('Invalid ID.');
            return back();
        }
        $data->record = str_pad($data->record, 4, '0', STR_PAD_LEFT);
        $data->assign_to_name = User::where('id', $data->assigned_to)->value('name');
        $data->initiator_name = User::where('id', $data->initiator_id)->value('name');
        $country_id = $data->id;

        $grid_Data = CountrySubGrid::where(['c_id' => $country_id, 'identifer' => 'ProductMaterialDetails'])->first();
        $grid_two = CountrySubGrid::where(['c_id' => $country_id, 'identifer' => 'FinancialTransactions'])->first();
        $grid_three = CountrySubGrid::where(['c_id' => $country_id, 'identifer' => 'Ingredients'])->first();

        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');


        return view('frontend.country-submission-data.country_sub_data_view', compact('data','grid_Data','grid_two','grid_three','country_id','due_date'));

    }

    public function country_send_stage(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $country = CountrySubData::find($id);
            $lastDocument =  CountrySubData::find($id);

            if ($country->stage == 1) {
                $country->stage = "2";
                $country->status = 'Country Record Created';
                $country->activate_by = Auth::user()->name;
                $country->activate_on = Carbon::now()->format('d-M-Y');
                $country->activate_comment = $request->comment;
                $history = new CountrySubAuditTrail();
                $history->country_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $country->activate_by;
                $history->comment = $request->comment;
                $history->action = 'Activate';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Country Record Created";
                $history->change_from = $lastDocument->status;
                $history->stage='Activate';
                $history->action_name = 'Not Applicable';

                $history->save();
                $country->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($country->stage == 2) {
                $country->stage = "3";
                $country->status = 'Closed - Done';
                $country->close_by = Auth::user()->name;
                $country->close_on = Carbon::now()->format('d-M-Y');
                $country->close_comment = $request->comment;
                $history = new CountrySubAuditTrail();
                $history->country_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $country->close_by;
                $history->comment = $request->comment;
                $history->action = 'Close';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Closed - Done";
                $history->change_from = $lastDocument->status;
                $history->stage='Close';
                $history->action_name = 'Not Applicable';

                $history->save();
                $country->update();
                toastr()->success('Document Sent');
                return back();
            }
        }else {
            toastr()->error('E-signature Not match');
            return back();
        }

    }

    public function country_Cancle(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $country = CountrySubData::find($id);
            $lastDocument =  CountrySubData::find($id);

            if ($country->stage == 2) {
                $country->stage = "0";
                $country->status = "Closed - Cancelled";
                $country->cancel_by = Auth::user()->name;
                $country->cancel_on = Carbon::now()->format('d-M-Y');
                $country->cancel_comment = $request->comment;
                $country->update();

                $history = new CountrySubAuditTrail();
                $history->country_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $country->cancel_by;
                $history->comment = $request->comment;
                $history->action = 'Cancel';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Closed - Cancelled";
                $history->change_from = $lastDocument->status;
                $history->stage='Cancel';
                $history->action_name = 'Not Applicable';
                $history->save();

                $history = new CountrySubHistory();
                $history->type = "Country-Submission-Data";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $country->stage;
                $history->status = $country->status;
                $history->save();
                toastr()->success('Document Sent');
                return back();
                
            }
        }else {
            toastr()->error('E-signature Not match');
            return back();
        }

    }


    public function countryAuditTrail($id)
    {
        $audit = CountrySubAuditTrail::where('country_id', $id)->orderByDESC('id')->get()->unique('activity_type');
        $today = Carbon::now()->format('d-m-y');
        $document = CountrySubData::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');

        return view("frontend.country-submission-data.country_sub_audit_trail", compact('audit', 'document', 'today'));

    }

    public function auditDetailsCountry(Request $request, $id)
    {
        $detail = CountrySubAuditTrail::find($id);

        $detail_data = CountrySubAuditTrail::where('activity_type', $detail->activity_type)->where('country_id', $detail->country_id)->latest()->get();

        $doc = CountrySubData::where('id', $detail->country_id)->first();

        $doc->origiator_name = User::find($doc->initiator_id);
        return view("frontend.country-submission-data.audit-trail-inner", compact('detail', 'doc', 'detail_data'));
    }

    public static function singleReport($id)
    {
        $data = CountrySubData::find($id);
        $grid_Data = CountrySubGrid::where(['c_id' => $id,'identifer' => 'ProductMaterialDetails'])->first();
        $second_grid = CountrySubGrid::where(['c_id' => $id,'identifer' => 'FinancialTransactions'])->first();
        $third_grid = CountrySubGrid::where(['c_id' => $id,'identifer' => 'Ingredients'])->first();

        if (!empty($data)) {
            $data->originator_id = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.country-submission-data.singleReport', compact('data','grid_Data','second_grid','third_grid'))
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
            return $pdf->stream('Country-Submission-Data-Obs' . $id . '.pdf');
        }


    }

    public static function auditReport($id)
    {
        $doc = CountrySubData::find($id);
        $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        $data = CountrySubAuditTrail::where('country_id', $doc->id)->orderByDesc('id')->get();
        $audit = CountrySubAuditTrail::where('country_id', $id)->orderByDESC('id')->get()->unique('activity_type');
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.country-submission-data.auditReport', compact('data', 'doc','audit'))
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
