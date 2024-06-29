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
         
        $lastData =  CountrySubData::find($id);
        $country = CountrySubData::find($id);

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

        if ($lastData->originator_id != $country->originator_id || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Initiated By';
            $history->previous = $lastData->originator_id;
            $history->current = $country->originator_id;
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

        if ($lastData->short_description != $country->short_description || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastData->short_description;
            $history->current = $country->short_description;
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

        if ($lastData->assigned_to != $country->assigned_to || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Assigned To';
            $history->previous = $lastData->assigned_to;
            $history->current = $country->assigned_to;
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

        if ($lastData->due_date != $country->due_date || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Due Date';
            $history->previous = $lastData->due_date;
            $history->current = $country->due_date;
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

        if ($lastData->type != $country->type || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Type';
            $history->previous = $lastData->type;
            $history->current = $country->type;
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

        if ($lastData->other_type != $country->other_type || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Other Type';
            $history->previous = $lastData->other_type;
            $history->current = $country->other_type;
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

        if ($lastData->attached_files != $country->attached_files || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Attached Files';
            $history->previous = $lastData->attached_files;
            $history->current = $country->attached_files;
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

        if ($lastData->related_urls != $country->related_urls || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Related Urls';
            $history->previous = $lastData->related_urls;
            $history->current = $country->related_urls;
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

        if ($lastData->descriptions != $country->descriptions || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Descriptions';
            $history->previous = $lastData->descriptions;
            $history->current = $country->descriptions;
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

        if ($lastData->zone != $country->zone || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Zone';
            $history->previous = $lastData->zone;
            $history->current = $country->zone;
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

        if ($lastData->country != $country->country || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Country';
            $history->previous = $lastData->country;
            $history->current = $country->country;
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

        if ($lastData->city != $country->city || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'City';
            $history->previous = $lastData->city;
            $history->current = $country->city;
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

        if ($lastData->state_district != $country->state_district || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'State District';
            $history->previous = $lastData->state_district;
            $history->current = $country->state_district;
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

        if ($lastData->manufacturer != $country->manufacturer || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Manufacturer';
            $history->previous = $lastData->manufacturer;
            $history->current = $country->manufacturer;
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

        if ($lastData->number_id != $country->number_id || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Number Id';
            $history->previous = $lastData->number_id;
            $history->current = $country->number_id;
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

        if ($lastData->project_code != $country->project_code || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Project Code';
            $history->previous = $lastData->project_code;
            $history->current = $country->project_code;
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

        if ($lastData->authority_type != $country->authority_type || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Authority Type';
            $history->previous = $lastData->authority_type;
            $history->current = $country->authority_type;
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

        if ($lastData->authority_type != $country->authority_type || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Authority Type';
            $history->previous = $lastData->authority_type;
            $history->current = $country->authority_type;
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

        if ($lastData->authority != $country->authority || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Authority';
            $history->previous = $lastData->authority;
            $history->current = $country->authority;
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

        if ($lastData->priority_level != $country->priority_level || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Priority Level';
            $history->previous = $lastData->priority_level;
            $history->current = $country->priority_level;
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

        if ($lastData->other_authority != $country->other_authority || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Other Authority';
            $history->previous = $lastData->other_authority;
            $history->current = $country->other_authority;
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

        if ($lastData->approval_status != $country->approval_status || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Approval Status';
            $history->previous = $lastData->approval_status;
            $history->current = $country->approval_status;
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

        if ($lastData->managed_by_company != $country->managed_by_company || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Managed By Company';
            $history->previous = $lastData->managed_by_company;
            $history->current = $country->managed_by_company;
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

        if ($lastData->marketing_status != $country->marketing_status || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Marketing Status';
            $history->previous = $lastData->marketing_status;
            $history->current = $country->marketing_status;
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

        if ($lastData->therapeutic_area != $country->therapeutic_area || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Therapeutic Area';
            $history->previous = $lastData->therapeutic_area;
            $history->current = $country->therapeutic_area;
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

        if ($lastData->end_of_trial_date_status != $country->end_of_trial_date_status || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'End Of Trial Date Status';
            $history->previous = $lastData->end_of_trial_date_status;
            $history->current = $country->end_of_trial_date_status;
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

        if ($lastData->protocol_type != $country->protocol_type || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Protocol Type';
            $history->previous = $lastData->protocol_type;
            $history->current = $country->protocol_type;
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

        if ($lastData->registration_status != $country->registration_status || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Registration Status';
            $history->previous = $lastData->registration_status;
            $history->current = $country->registration_status;
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

        if ($lastData->unblinded_SUSAR_to_CEC != $country->unblinded_SUSAR_to_CEC || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Unblinded SUSAR To CEC';
            $history->previous = $lastData->unblinded_SUSAR_to_CEC;
            $history->current = $country->unblinded_SUSAR_to_CEC;
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

        if ($lastData->trade_name != $country->trade_name || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Trade Name';
            $history->previous = $lastData->trade_name;
            $history->current = $country->trade_name;
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

        if ($lastData->dosage_form != $country->dosage_form || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Dosage Form';
            $history->previous = $lastData->dosage_form;
            $history->current = $country->dosage_form;
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

        if ($lastData->photocure_trade_name != $country->photocure_trade_name || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Photocure Trade Name';
            $history->previous = $lastData->photocure_trade_name;
            $history->current = $country->photocure_trade_name;
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

        if ($lastData->currency != $country->currency || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Currency';
            $history->previous = $lastData->currency;
            $history->current = $country->currency;
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

        if ($lastData->attacehed_payments != $country->attacehed_payments || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Attacehed Payments';
            $history->previous = $lastData->attacehed_payments;
            $history->current = $country->attacehed_payments;
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

        if ($lastData->follow_up_documents != $country->follow_up_documents || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Follow Up Documents';
            $history->previous = $lastData->follow_up_documents;
            $history->current = $country->follow_up_documents;
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

        if ($lastData->hospitals != $country->hospitals || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Hospitals';
            $history->previous = $lastData->hospitals;
            $history->current = $country->hospitals;
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

        if ($lastData->vendors != $country->vendors || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Vendors';
            $history->previous = $lastData->vendors;
            $history->current = $country->vendors;
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

        if ($lastData->INN != $country->INN || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'INN';
            $history->previous = $lastData->INN;
            $history->current = $country->INN;
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

        if ($lastData->route_of_administration != $country->route_of_administration || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Route Of Administration';
            $history->previous = $lastData->route_of_administration;
            $history->current = $country->route_of_administration;
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

        if ($lastData->first_IB_version != $country->first_IB_version || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'First IB Version';
            $history->previous = $lastData->first_IB_version;
            $history->current = $country->first_IB_version;
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

        if ($lastData->first_protocol_version != $country->first_protocol_version || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'First Protocol Version';
            $history->previous = $lastData->first_protocol_version;
            $history->current = $country->first_protocol_version;
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

        if ($lastData->eudraCT_number != $country->eudraCT_number || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'EudraCT Number';
            $history->previous = $lastData->eudraCT_number;
            $history->current = $country->eudraCT_number;
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

        if ($lastData->budget != $country->budget || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Budget';
            $history->previous = $lastData->budget;
            $history->current = $country->budget;
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

        if ($lastData->phase_of_study != $country->phase_of_study || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Phase Of Study';
            $history->previous = $lastData->phase_of_study;
            $history->current = $country->phase_of_study;
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

        if ($lastData->related_clinical_trials != $country->related_clinical_trials || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Related Clinical Trials';
            $history->previous = $lastData->related_clinical_trials;
            $history->current = $country->related_clinical_trials;
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

        if ($lastData->data_safety_notes != $country->data_safety_notes || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Data Safety Notes';
            $history->previous = $lastData->data_safety_notes;
            $history->current = $country->data_safety_notes;
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

        if ($lastData->comments != $country->comments || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Comments';
            $history->previous = $lastData->comments;
            $history->current = $country->comments;
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

        if ($lastData->annual_IB_update_date_due != $country->annual_IB_update_date_due || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Annual IB Update Date Due';
            $history->previous = $lastData->annual_IB_update_date_due;
            $history->current = $country->annual_IB_update_date_due;
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

        if ($lastData->date_of_first_IB != $country->date_of_first_IB || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Date Of First IB';
            $history->previous = $lastData->date_of_first_IB;
            $history->current = $country->date_of_first_IB;
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

        if ($lastData->date_of_first_protocol != $country->date_of_first_protocol || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Date Of First Protocol';
            $history->previous = $lastData->date_of_first_protocol;
            $history->current = $country->date_of_first_protocol;
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

        if ($lastData->date_safety_report != $country->date_safety_report || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Date Safety Report';
            $history->previous = $lastData->date_safety_report;
            $history->current = $country->date_safety_report;
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

        if ($lastData->date_trial_active != $country->date_trial_active || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Date Trial Active';
            $history->previous = $lastData->date_trial_active;
            $history->current = $country->date_trial_active;
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

        if ($lastData->end_of_study_report_date != $country->end_of_study_report_date || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'End Of Study Report Date';
            $history->previous = $lastData->end_of_study_report_date;
            $history->current = $country->end_of_study_report_date;
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

        if ($lastData->end_of_study_synopsis_date != $country->end_of_study_synopsis_date || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'End Of Study Synopsis Date';
            $history->previous = $lastData->end_of_study_synopsis_date;
            $history->current = $country->end_of_study_synopsis_date;
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

        if ($lastData->end_of_trial_date != $country->end_of_trial_date || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'End Of Trial Date';
            $history->previous = $lastData->end_of_trial_date;
            $history->current = $country->end_of_trial_date;
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

        if ($lastData->last_visit != $country->last_visit || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Last Visit';
            $history->previous = $lastData->last_visit;
            $history->current = $country->last_visit;
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

        if ($lastData->next_visit != $country->next_visit || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Next Visit';
            $history->previous = $lastData->next_visit;
            $history->current = $country->next_visit;
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

        if ($lastData->ethics_commitee_approval != $country->ethics_commitee_approval || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Ethics Commitee Approval';
            $history->previous = $lastData->ethics_commitee_approval;
            $history->current = $country->ethics_commitee_approval;
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

        if ($lastData->safety_impact_risk != $country->safety_impact_risk || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Safety Impact Risk';
            $history->previous = $lastData->safety_impact_risk;
            $history->current = $country->safety_impact_risk;
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

        if ($lastData->CROM != $country->CROM || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'CROM';
            $history->previous = $lastData->CROM;
            $history->current = $country->CROM;
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

        if ($lastData->lead_investigator != $country->lead_investigator || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Lead Investigator';
            $history->previous = $lastData->lead_investigator;
            $history->current = $country->lead_investigator;
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

        if ($lastData->sponsor != $country->sponsor || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Sponsor';
            $history->previous = $lastData->sponsor;
            $history->current = $country->sponsor;
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

        if ($lastData->additional_investigators != $country->additional_investigators || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Additional Investigators';
            $history->previous = $lastData->additional_investigators;
            $history->current = $country->additional_investigators;
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

        if ($lastData->clinical_events_committee != $country->clinical_events_committee || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Clinical Events Committee';
            $history->previous = $lastData->clinical_events_committee;
            $history->current = $country->clinical_events_committee;
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

        if ($lastData->clinical_research_team != $country->clinical_research_team || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Clinical Research Team';
            $history->previous = $lastData->clinical_research_team;
            $history->current = $country->clinical_research_team;
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

        if ($lastData->data_safety_monitoring_board != $country->data_safety_monitoring_board || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Data Safety Monitoring Board';
            $history->previous = $lastData->data_safety_monitoring_board;
            $history->current = $country->data_safety_monitoring_board;
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

        if ($lastData->distribution_list != $country->distribution_list || !empty($request->comment)) {
            // return 'history';
            $history = new CountrySubAuditTrail();
            $history->country_id = $id;
            $history->activity_type = 'Distribution List';
            $history->previous = $lastData->distribution_list;
            $history->current = $country->distribution_list;
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


        return view('frontend.country-submission-data.country_sub_data_view', compact('data','grid_Data','grid_two','grid_three','country_id'));

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
                $history->action = 'Country Record Created';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Country Record Created";
                $history->change_from = $lastDocument->status;
                $history->stage='Country Record Created';

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
                $history->action = 'Closed - Done';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Closed - Done";
                $history->change_from = $lastDocument->status;
                $history->stage='Closed - Done';

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
                $history->action = 'Closed - Cancelled';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Closed - Cancelled";
                $history->change_from = $lastDocument->status;
                $history->stage='Closed - Cancelled';
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
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.country-submission-data.auditReport', compact('data', 'doc'))
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
