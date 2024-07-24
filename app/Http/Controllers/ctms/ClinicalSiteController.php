<?php

namespace App\Http\Controllers\ctms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClinicalSite;
use App\Models\ClinicalSiteGrids;
use App\Models\ClinicalSiteAudittrail;

use App\Models\Capa;
use App\Models\RecordNumber;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use App\Models\RoleGroup;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Helpers;

use PDF;




class ClinicalSiteController extends Controller
{
    public function index()
    {
        $record = ((RecordNumber::first()->value('counter')) + 1);
        $record = str_pad($record, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');

        return view('frontend.ctms.clinicalsite.clinical_site',compact('due_date', 'record'));

    }

    public function store(Request $request)
    {
        // Create a new ClinicalSite instance and fill it with request data
        $clinicalSite = new ClinicalSite;
        $clinicalSite->form_type ="ClinicalSite";
        $clinicalSite->stage = 1;
        $clinicalSite->status = 'Opened';
        $clinicalSite->record = ((RecordNumber::first()->value('counter')) + 1);
        $clinicalSite->division_code = $request->input('division_code');
        // $clinicalSite->initiator = $request->input('initiator');
        $clinicalSite->initiator = Auth::user()->id;
        $clinicalSite->initiation_date = $request->input('initiation_date');
        $clinicalSite->short_description = $request->input('short_description');
        $clinicalSite->due_date = $request->input('due_date');
        $clinicalSite->assign_to = $request->input('assign_to');
        $clinicalSite->type = $request->input('type');
        $clinicalSite->site_name = $request->input('site_name');
        // $clinicalSite->source_documents = $request->input('source_documents');
        $clinicalSite->sponsor = $request->input('sponsor');
        $clinicalSite->description = $request->input('description');
        // $clinicalSite->attached_files = $request->input('attached_files');
        $clinicalSite->comments = $request->input('comments');
        $clinicalSite->version_no = $request->input('version_no');
        $clinicalSite->admission_criteria = $request->input('admission_criteria');
        $clinicalSite->clinical_significance = $request->input('clinical_significance');
        $clinicalSite->trade_name = $request->input('trade_name');
        $clinicalSite->tracking_number = $request->input('tracking_number');
        $clinicalSite->phase_of_study = $request->input('phase_of_study');
        $clinicalSite->parent_type = $request->input('parent_type');
        $clinicalSite->par_oth_type = $request->input('par_oth_type');
        $clinicalSite->zone = $request->input('zone');
        $clinicalSite->country = $request->input('country');
        $clinicalSite->city = $request->input('city');
        $clinicalSite->state_district = $request->input('state_district');
        $clinicalSite->sel_site_name = $request->input('sel_site_name');
        $clinicalSite->building = $request->input('building');
        $clinicalSite->floor = $request->input('floor');
        $clinicalSite->room = $request->input('room');
        $clinicalSite->site_name_sai = $request->input('site_name_sai');
        $clinicalSite->pharmacy = $request->input('pharmacy');
        $clinicalSite->site_no = $request->input('site_no');
        $clinicalSite->site_status = $request->input('site_status');
        $clinicalSite->acti_date = $request->input('acti_date');
        $clinicalSite->date_final_report = $request->input('date_final_report');
        $clinicalSite->ini_irb_app_date = $request->input('ini_irb_app_date');
        $clinicalSite->imp_site_date = $request->input('imp_site_date');
        $clinicalSite->lab_de_name = $request->input('lab_de_name');
        $clinicalSite->moni_per_by = $request->input('moni_per_by');
        $clinicalSite->drop_withdrawn = $request->input('drop_withdrawn');
        $clinicalSite->enrolled = $request->input('enrolled');
        $clinicalSite->follow_up = $request->input('follow_up');
        $clinicalSite->planned = $request->input('planned');
        $clinicalSite->screened = $request->input('screened');
        $clinicalSite->project_annual_mv = $request->input('project_annual_mv');
        $clinicalSite->schedule_start_date = $request->input('schedule_start_date');
        $clinicalSite->schedule_end_date = $request->input('schedule_end_date');
        $clinicalSite->actual_start_date = $request->input('actual_start_date');
        $clinicalSite->actual_end_date = $request->input('actual_end_date');
        $clinicalSite->lab_name = $request->input('lab_name');
        $clinicalSite->monitoring_per_by_si = $request->input('monitoring_per_by_si');
        $clinicalSite->control_group = $request->input('control_group');
        // $clinicalSite->consent_form = $request->input('consent_form');
        $clinicalSite->budget = $request->input('budget');
        $clinicalSite->proj_sites_si = $request->input('proj_sites_si');
        $clinicalSite->proj_subject_si = $request->input('proj_subject_si');
        $clinicalSite->auto_calculation = $request->input('auto_calculation');
        $clinicalSite->currency_si = $request->input('currency_si');
        // $clinicalSite->attached_payments = $request->input('attached_payments');
        $clinicalSite->cra = $request->input('cra');
        $clinicalSite->lead_investigator = $request->input('lead_investigator');
        $clinicalSite->reserve_team_associate = $request->input('reserve_team_associate');
        $clinicalSite->additional_investigators = $request->input('additional_investigators');
        $clinicalSite->clinical_research_coordinator = $request->input('clinical_research_coordinator');
        $clinicalSite->pharmacist = $request->input('pharmacist');
        $clinicalSite->comments_si = $request->input('comments_si');
        $clinicalSite->budget_ut = $request->input('budget_ut');
        $clinicalSite->currency_ut = $request->input('currency_ut');
        
       
        // Save the ClinicalSite instance to the database
        if (!empty($request->source_documents)) {
            $files = [];
            if ($request->hasfile('source_documents')) {
                foreach ($request->file('source_documents') as $file) {
                    $name = $request->name . 'source_documents' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $clinicalSite->source_documents = json_encode($files);
        }
        // dd( $clinicalSite->source_documents);
        if (!empty($request->attached_files)) {
            $files = [];
            if ($request->hasfile('attached_files')) {
                foreach ($request->file('attached_files') as $file) {
                    $name = $request->name . 'attached_files' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $clinicalSite->attached_files = json_encode($files);
        }
    if (!empty($request->attached_payments)) {
            $files = [];
            if ($request->hasfile('attached_payments')) {
                foreach ($request->file('attached_payments') as $file) {
                    $name = $request->name . 'attached_payments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $clinicalSite->attached_payments = json_encode($files);
        }
        
        if (!empty($request->consent_form)) {
            $files = [];
            if ($request->hasfile('consent_form')) {
                foreach ($request->file('consent_form') as $file) {
                    $name = $request->name . 'consent_form' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $clinicalSite->consent_form = json_encode($files);
        }

        $clinicalSite->save();

        // ====================================aduit trail show=============

        if (!empty($clinicalSite->short_description)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Short Description';
            $history->previous = "NA";
            $history->current = $clinicalSite->short_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->assign_to)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Assign To';
            $history->previous = "NA";
            $history->current = $clinicalSite->assign_to;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }

        if (!empty($clinicalSite->due_date)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Due Date';
            $history->previous = "NA";
            $history->current = $clinicalSite->due_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }

        if (!empty($clinicalSite->type)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Type';
            $history->previous = "NA";
            $history->current = $clinicalSite->type;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
         if (!empty($clinicalSite->site_name)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Site Name';
            $history->previous = "NA";
            $history->current = $clinicalSite->site_name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->source_documents)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Source Documents';
            $history->previous = "NA";
            $history->current = $clinicalSite->source_documents;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->sponsor)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Sponsor';
            $history->previous = "NA";
            $history->current = $clinicalSite->sponsor;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->description)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Description';
            $history->previous = "NA";
            $history->current = $clinicalSite->description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->attached_files)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Attached_files';
            $history->previous = "NA";
            $history->current = $clinicalSite->attached_files;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->comments)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Comments';
            $history->previous = "NA";
            $history->current = $clinicalSite->comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
       
        if (!empty($clinicalSite->version_no)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Version No.';
            $history->previous = "NA";
            $history->current = $clinicalSite->version_no;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->admission_criteria)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Admission Criteria';
            $history->previous = "NA";
            $history->current = $clinicalSite->admission_criteria;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->cinical_significance)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Clinical Significance';
            $history->previous = "NA";
            $history->current = $clinicalSite->cinical_significance;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->trade_name)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = '(Root Parent) Trade Name';
            $history->previous = "NA";
            $history->current = $clinicalSite->trade_name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->tracking_number)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = '(Parent) Tracking Number';
            $history->previous = "NA";
            $history->current = $clinicalSite->tracking_number;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->phase_of_study)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Phase of Study';
            $history->previous = "NA";
            $history->current = $clinicalSite->phase_of_study;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->phase_of_study)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Phase of Study';
            $history->previous = "NA";
            $history->current = $clinicalSite->phase_of_study;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->par_oth_type)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Parent Other Type';
            $history->previous = "NA";
            $history->current = $clinicalSite->par_oth_type;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->zone)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Zone';
            $history->previous = "NA";
            $history->current = $clinicalSite->zone;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->country)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Country';
            $history->previous = "NA";
            $history->current = $clinicalSite->country;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->city)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'City';
            $history->previous = "NA";
            $history->current = $clinicalSite->city;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->state_district)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'State District';
            $history->previous = "NA";
            $history->current = $clinicalSite->state_district;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->sel_site_name)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Loc.Site Name';
            $history->previous = "NA";
            $history->current = $clinicalSite->sel_site_name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->building)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Building';
            $history->previous = "NA";
            $history->current = $clinicalSite->building;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }

        if (!empty($clinicalSite->floor)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Floor';
            $history->previous = "NA";
            $history->current = $clinicalSite->floor;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->room)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Room';
            $history->previous = "NA";
            $history->current = $clinicalSite->room;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->site_name_sai)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Site Name';
            $history->previous = "NA";
            $history->current = $clinicalSite->site_name_sai;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }

        if (!empty($clinicalSite->pharmacy)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Pharmacy';
            $history->previous = "NA";
            $history->current = $clinicalSite->pharmacy;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->site_no)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Site No';
            $history->previous = "NA";
            $history->current = $clinicalSite->site_no;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->site_status)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Site Status';
            $history->previous = "NA";
            $history->current = $clinicalSite->site_status;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }

        if (!empty($clinicalSite->acti_date)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Activation Date';
            $history->previous = "NA";
            $history->current = $clinicalSite->acti_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->date_final_report)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Date of Final Report';
            $history->previous = "NA";
            $history->current = $clinicalSite->date_final_report;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->ini_irb_app_date)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Initial IRB Approval Date';
            $history->previous = "NA";
            $history->current = $clinicalSite->ini_irb_app_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->imp_site_date)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Initial IRB Approval Date';
            $history->previous = "NA";
            $history->current = $clinicalSite->imp_site_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->lab_de_name)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Lab/Department Name';
            $history->previous = "NA";
            $history->current = $clinicalSite->lab_de_name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->moni_per_by)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Monitoring Performed By';
            $history->previous = "NA";
            $history->current = $clinicalSite->moni_per_by;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->drop_withdreawn)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Dropped/Withdrawn';
            $history->previous = "NA";
            $history->current = $clinicalSite->drop_withdreawn;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->enrolled)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Enrolled';
            $history->previous = "NA";
            $history->current = $clinicalSite->enrolled;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        // if (!empty($clinicalSite->follow-up)) {
        //     $history = new ClinicalSiteAudittrail();
        //     $history->clinical_id = $clinicalSite->id;
        //     $history->activity_type = 'Follow Up';
        //     $history->previous = "NA";
        //     $history->current = $clinicalSite->follow-up;
        //     $history->comment = "Not Applicable";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $clinicalSite->status;
        //     $history->change_to = "Opened";
        //     $history->change_from = "Initiator";
        //     $history->action_name = "store";
        //     $history->save();
        // }
         if (!empty($clinicalSite->planned)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Planned';
            $history->previous = "NA";
            $history->current = $clinicalSite->planned;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->screened)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Screened';
            $history->previous = "NA";
            $history->current = $clinicalSite->screened;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }

        if (!empty($clinicalSite->project_annual_mv)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Project Annual MV';
            $history->previous = "NA";
            $history->current = $clinicalSite->project_annual_mv;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->schedual_start_date)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Scheduled Start Date';
            $history->previous = "NA";
            $history->current = $clinicalSite->schedual_start_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->schedual_end_date)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Scheduled Etart Date';
            $history->previous = "NA";
            $history->current = $clinicalSite->schedual_end_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->actual_start_date)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Actual Start Date';
            $history->previous = "NA";
            $history->current = $clinicalSite->actual_start_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->actual_end_date)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Actual End Date';
            $history->previous = "NA";
            $history->current = $clinicalSite->actual_end_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->lab_name)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Lab Name';
            $history->previous = "NA";
            $history->current = $clinicalSite->lab_name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->monitring_per_by_si)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Monitoring Performed By';
            $history->previous = "NA";
            $history->current = $clinicalSite->monitring_per_by_si;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->control_group)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Monitoring Performed By';
            $history->previous = "NA";
            $history->current = $clinicalSite->control_group;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->consent_form)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Consent Form';
            $history->previous = "NA";
            $history->current = $clinicalSite->consent_form;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->budget)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Budget';
            $history->previous = "NA";
            $history->current = $clinicalSite->budget;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->proj_sties_si)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Project of Sites';
            $history->previous = "NA";
            $history->current = $clinicalSite->proj_sties_si;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->proj_subject_si)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Project of Subject';
            $history->previous = "NA";
            $history->current = $clinicalSite->proj_subject_si;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->auto_calcultion)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Subjects in Site';
            $history->previous = "NA";
            $history->current = $clinicalSite->auto_calcultion;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->currency_si)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Currency';
            $history->previous = "NA";
            $history->current = $clinicalSite->currency_si;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->attached_payments)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Attached Payments';
            $history->previous = "NA";
            $history->current = $clinicalSite->attached_payments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->cra)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'CRA';
            $history->previous = "NA";
            $history->current = $clinicalSite->cra;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->lead_investigator)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Lead Investigator';
            $history->previous = "NA";
            $history->current = $clinicalSite->lead_investigator;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->reserve_team_associate)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Reserve Team Associate';
            $history->previous = "NA";
            $history->current = $clinicalSite->reserve_team_associate;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->additional_investigators)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Additional Investigators';
            $history->previous = "NA";
            $history->current = $clinicalSite->additional_investigators;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->clini_res_coordi)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Clinical Site';
            $history->previous = "NA";
            $history->current = $clinicalSite->clini_res_coordi;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->pharmacist)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Pharmacist';
            $history->previous = "NA";
            $history->current = $clinicalSite->pharmacist;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->comments_si)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Comments';
            $history->previous = "NA";
            $history->current = $clinicalSite->comments_si;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->budget_ut)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Budget';
            $history->previous = "NA";
            $history->current = $clinicalSite->budget_ut;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
        if (!empty($clinicalSite->currency_ut)) {
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $clinicalSite->id;
            $history->activity_type = 'Currency';
            $history->previous = "NA";
            $history->current = $clinicalSite->currency_ut;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $clinicalSite->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "store";
            $history->save();
        }
// =======================================grid data store====================
        $griddata = $clinicalSite->id;
        $drug_accou = ClinicalSiteGrids::where(['cs_id' => $griddata, 'identifiers' => 'Drug Accountability'])->firstOrNew();
        $drug_accou->cs_id = $griddata;
        $drug_accou->identifiers = 'Drug Accountability';
        $drug_accou->data = $request->drugaccountability;
        $drug_accou->save();

        
        $equipment = ClinicalSiteGrids::where(['cs_id' => $griddata, 'identifiers' => 'Equipment'])->firstOrNew();
        $equipment->cs_id = $griddata;
        $equipment->identifiers = 'Equipment';
        $equipment->data = $request->equipments;
        $equipment->save();

        $finan_transa = ClinicalSiteGrids::where(['cs_id' => $griddata, 'identifiers' => 'Financial Transactions'])->firstOrNew();
        $finan_transa->cs_id = $griddata;
        $finan_transa->identifiers = 'Financial Transactions';
        $finan_transa->data = $request->financialTransactions;
        $finan_transa->save();
        return redirect()->to('rcms/qms-dashboard')->with('success','record succesfull');


    }


    public function show($id)
    {
        // Find the ClinicalSite instance by ID
        $record = ((RecordNumber::first()->value('counter')) + 1);
        $data = ClinicalSite::findOrFail($id);
        $drug_accou = ClinicalSiteGrids::where('cs_id',$id)->where('identifiers','Drug Accountability')->first();
        $equipment= ClinicalSiteGrids::where('cs_id',$id)->where('identifiers','Equipment')->first();
        $finan_transa = ClinicalSiteGrids::where('cs_id',$id)->where('identifiers','Financial Transactions')->first();
    //    dd( $drug_accou);
        return view('frontend.ctms.clinicalsite.clinical_site_view',compact('record','data','finan_transa','equipment','drug_accou'));
    }

    public function update(Request $request, $id)
    {
        $lastclinical = ClinicalSite::find($id);
        $clinicalSite = ClinicalSite::findOrFail($id);

        // Update the instance with request data
        $clinicalSite->record = ((RecordNumber::first()->value('counter')) + 1);

        $clinicalSite->division_code = $request->input('division_code');
        $clinicalSite->initiator = $request->input('initiator');
        $clinicalSite->initiation_date = $request->input('initiation_date');
        $clinicalSite->short_description = $request->input('short_description');
        $clinicalSite->due_date = $request->input('due_date');
        $clinicalSite->assign_to = $request->input('assign_to');
        $clinicalSite->type = $request->input('type');
        $clinicalSite->site_name = $request->input('site_name');
        $clinicalSite->source_documents = $request->input('source_documents');
        $clinicalSite->sponsor = $request->input('sponsor');
        $clinicalSite->description = $request->input('description');
        $clinicalSite->attached_files = $request->input('attached_files');
        $clinicalSite->comments = $request->input('comments');
        $clinicalSite->version_no = $request->input('version_no');
        $clinicalSite->admission_criteria = $request->input('admission_criteria');
        $clinicalSite->clinical_significance = $request->input('clinical_significance');
        $clinicalSite->trade_name = $request->input('trade_name');
        $clinicalSite->tracking_number = $request->input('tracking_number');
        $clinicalSite->phase_of_study = $request->input('phase_of_study');
        $clinicalSite->parent_type = $request->input('parent_type');
        $clinicalSite->par_oth_type = $request->input('par_oth_type');
        $clinicalSite->zone = $request->input('zone');
        $clinicalSite->country = $request->input('country');
        $clinicalSite->city = $request->input('city');
        $clinicalSite->state_district = $request->input('state_district');
        $clinicalSite->sel_site_name = $request->input('sel_site_name');
        $clinicalSite->building = $request->input('building');
        $clinicalSite->floor = $request->input('floor');
        $clinicalSite->room = $request->input('room');
        $clinicalSite->site_name_sai = $request->input('site_name_sai');
        $clinicalSite->pharmacy = $request->input('pharmacy');
        $clinicalSite->site_no = $request->input('site_no');
        $clinicalSite->site_status = $request->input('site_status');
        $clinicalSite->acti_date = $request->input('acti_date');
        $clinicalSite->date_final_report = $request->input('date_final_report');
        $clinicalSite->ini_irb_app_date = $request->input('ini_irb_app_date');
        $clinicalSite->imp_site_date = $request->input('imp_site_date');
        $clinicalSite->lab_de_name = $request->input('lab_de_name');
        $clinicalSite->moni_per_by = $request->input('moni_per_by');
        $clinicalSite->drop_withdrawn = $request->input('drop_withdrawn');
        $clinicalSite->enrolled = $request->input('enrolled');
        $clinicalSite->follow_up = $request->input('follow_up');
        $clinicalSite->planned = $request->input('planned');
        $clinicalSite->screened = $request->input('screened');
        $clinicalSite->project_annual_mv = $request->input('project_annual_mv');
        $clinicalSite->schedule_start_date = $request->input('schedule_start_date');
        $clinicalSite->schedule_end_date = $request->input('schedule_end_date');
        $clinicalSite->actual_start_date = $request->input('actual_start_date');
        $clinicalSite->actual_end_date = $request->input('actual_end_date');
        $clinicalSite->lab_name = $request->input('lab_name');
        $clinicalSite->monitoring_per_by_si = $request->input('monitoring_per_by_si');
        $clinicalSite->control_group = $request->input('control_group');
        $clinicalSite->consent_form = $request->input('consent_form');
        $clinicalSite->budget = $request->input('budget');
        $clinicalSite->proj_sites_si = $request->input('proj_sites_si');
        $clinicalSite->proj_subject_si = $request->input('proj_subject_si');
        $clinicalSite->auto_calculation = $request->input('auto_calculation');
        $clinicalSite->currency_si = $request->input('currency_si');
        $clinicalSite->attached_payments = $request->input('attached_payments');
        $clinicalSite->cra = $request->input('cra');
        $clinicalSite->lead_investigator = $request->input('lead_investigator');
        $clinicalSite->reserve_team_associate = $request->input('reserve_team_associate');
        $clinicalSite->additional_investigators = $request->input('additional_investigators');
        $clinicalSite->clinical_research_coordinator = $request->input('clinical_research_coordinator');
        $clinicalSite->pharmacist = $request->input('pharmacist');
        $clinicalSite->comments_si = $request->input('comments_si');
        $clinicalSite->budget_ut = $request->input('budget_ut');
        $clinicalSite->currency_ut = $request->input('currency_ut');
       $clinicalSite->form_type ="ClinicalSite";

    //  ===========================file attachemnt======

        $files = [];
        if ($request->hasFile('source_documents')) {
            foreach ($request->file('source_documents') as $file) {
                // Generate a unique name for the file
                $name = $request->name . 'source_documents' . uniqid() . '.' . $file->getClientOriginalExtension();
                
                $file->move(public_path('upload/'), $name);
                
                $files[] = $name;
            }
        }
        $clinicalSite->source_documents = json_encode($files);

        $files = [];
        if ($request->hasFile('attached_files')) {
            foreach ($request->file('attached_files') as $file) {
                $name = $request->name . 'attached_files' . uniqid() . '.' . $file->getClientOriginalExtension();
                
                $file->move(public_path('upload/'), $name);
                
                $files[] = $name;
            }
        }
        $clinicalSite->attached_files = json_encode($files);

        if ($request->hasFile('attached_payments')) {
            foreach ($request->file('attached_payments') as $file) {
                $name = $request->name . 'attached_payments' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload/'), $name);                
                $files[] = $name;
            }
        }
        $clinicalSite->attached_payments = json_encode($files);

        if ($request->hasFile('consent_form')) {
            foreach ($request->file('consent_form') as $file) {
                $name = $request->name . 'consent_form' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload/'), $name);                
                $files[] = $name;
            }
        }
        $clinicalSite->consent_form = json_encode($files);
        // Save the updated ClinicalSite instance to the database

        $clinicalSite->save();

// ==================================aduit trail show update======================
if ( $lastclinical->short_description != $clinicalSite->short_description) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type ='Short_description';
    $history->previous = $lastclinical->short_description;
    $history->current = $clinicalSite->short_description;
    $history->comment = $request->short_description_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}

if ( $lastclinical->assign_to != $clinicalSite->assign_to) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Assign To';
    $history->previous = $lastclinical->assign_to;
    $history->current = $clinicalSite->assign_to;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Updatee";
    $history->save();
}

if ( $lastclinical->due_date != $clinicalSite->due_date) {

    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Due Date';
    $history->previous = $lastclinical->due_date;
    $history->current = $clinicalSite->due_date;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}

if (!empty($clinicalSite->type)) {
if ( $lastclinical->type != $clinicalSite->type) {

    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Type';
    $history->previous = $lastclinical->type;
    $history->current = $clinicalSite->type;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
 if (!empty($clinicalSite->site_name)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Site Name';
    $history->previous = $lastclinical->site_name;
    $history->current = $clinicalSite->site_name;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->source_documents)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Source Documents';
    $history->previous = $lastclinical->source_documents;
    $history->current = $clinicalSite->source_documents;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->sponsor)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Sponsor';
    $history->previous = $lastclinical->sponsor;
    $history->current = $clinicalSite->sponsor;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->description)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Description';
    $history->previous = $lastclinical->description;
    $history->current = $clinicalSite->description;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->attached_files)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Attached_files';
    $history->previous = $lastclinical->attached_files;
    $history->current = $clinicalSite->attached_files;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->comments)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Comments';
    $history->previous = $lastclinical->comments;
    $history->current = $clinicalSite->comments;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}

if (!empty($clinicalSite->version_no)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Version No.';
    $history->previous = $lastclinical->version_no;
    $history->current = $clinicalSite->version_no;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->admission_criteria)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Admission Criteria';
    $history->previous = $lastclinical->admission_criteria;
    $history->current = $clinicalSite->admission_criteria;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->cinical_significance)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Clinical Significance';
    $history->previous = $lastclinical->cinical_significance;
    $history->current = $clinicalSite->cinical_significance;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->trade_name)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = '(Root Parent) Trade Name';
    $history->previous = $lastclinical->trade_name;
    $history->current = $clinicalSite->trade_name;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->tracking_number)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = '(Parent) Tracking Number';
    $history->previous = $lastclinical->tracking_number;
    $history->current = $clinicalSite->tracking_number;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->phase_of_study)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Phase of Study';
    $history->previous = $lastclinical->phase_of_study;
    $history->current = $clinicalSite->phase_of_study;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->phase_of_study)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Phase of Study';
    $history->previous = $lastclinical->phase_of_study;
    $history->current = $clinicalSite->phase_of_study;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->par_oth_type)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Parent Other Type';
    $history->previous = $lastclinical->par_oth_type;
    $history->current = $clinicalSite->par_oth_type;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->zone)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Zone';
    $history->previous = $lastclinical->zone;
    $history->current = $clinicalSite->zone;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->country)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Country';
    $history->previous = $lastclinical->country;
    $history->current = $clinicalSite->country;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->city)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'City';
    $history->previous = $lastclinical->city;
    $history->current = $clinicalSite->city;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->state_district)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'State District';
    $history->previous = $lastclinical->state_district;
    $history->current = $clinicalSite->state_district;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->sel_site_name)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Loc.Site Name';
    $history->previous = $lastclinical->sel_site_name;
    $history->current = $clinicalSite->sel_site_name;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->building)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Building';
    $history->previous = $lastclinical->building;
    $history->current = $clinicalSite->building;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}

if (!empty($clinicalSite->floor)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Floor';
    $history->previous = $lastclinical->floor;
    $history->current = $clinicalSite->floor;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->room)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Room';
    $history->previous = $lastclinical->room;
    $history->current = $clinicalSite->room;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->site_name_sai)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Site Name';
    $history->previous = $lastclinical->site_name_sai;
    $history->current = $clinicalSite->site_name_sai;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}

if (!empty($clinicalSite->pharmacy)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Pharmacy';
    $history->previous = $lastclinical->pharmacy;
    $history->current = $clinicalSite->pharmacy;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->site_no)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Site No';
    $history->previous = $lastclinical->site_no;
    $history->current = $clinicalSite->site_no;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->site_status)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Site Status';
    $history->previous = $lastclinical->site_status;
    $history->current = $clinicalSite->site_status;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}

if (!empty($clinicalSite->acti_date)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Activation Date';
    $history->previous = $lastclinical->acti_date;
    $history->current = $clinicalSite->acti_date;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->date_final_report)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Date of Final Report';
    $history->previous = $lastclinical->date_final_report;
    $history->current = $clinicalSite->date_final_report;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->ini_irb_app_date)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Initial IRB Approval Date';
    $history->previous = $lastclinical->ini_irb_app_date;
    $history->current = $clinicalSite->ini_irb_app_date;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->imp_site_date)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Initial IRB Approval Date';
    $history->previous = $lastclinical->imp_site_date;
    $history->current = $clinicalSite->imp_site_date;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->lab_de_name)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Lab/Department Name';
    $history->previous = $lastclinical->lab_de_name;
    $history->current = $clinicalSite->lab_de_name;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->moni_per_by)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Monitoring Performed By';
    $history->previous = $lastclinical->moni_per_by;
    $history->current = $clinicalSite->moni_per_by;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->drop_withdreawn)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Dropped/Withdrawn';
    $history->previous = $lastclinical->drop_withdreawn;
    $history->current = $clinicalSite->drop_withdreawn;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->enrolled)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Enrolled';
    $history->previous = $lastclinical->enrolled;
    $history->current = $clinicalSite->enrolled;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
// if (!empty($clinicalSite->follow-up)) {
//     $history = new ClinicalSiteAudittrail();
//     $history->clinical_id = $clinicalSite->id;
//     $history->activity_type = 'Follow Up';
//     $history->previous = $lastclinical->;
//     $history->current = $clinicalSite->follow-up;
//     $history->comment = "Not Applicable";
//     $history->user_id = Auth::user()->id;
//     $history->user_name = Auth::user()->name;
//     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
//     $history->origin_state = $clinicalSite->status;
//     $history->change_to = "Opened";
//     $history->change_from = $clinicalSite->status;
//     $history->action_name = "Update";
//     $history->save();
// }
 if (!empty($clinicalSite->planned)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Planned';
    $history->previous = $lastclinical->planned;
    $history->current = $clinicalSite->planned;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->screened)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Screened';
    $history->previous = $lastclinical->screened;
    $history->current = $clinicalSite->screened;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}

if (!empty($clinicalSite->project_annual_mv)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Project Annual MV';
    $history->previous = $lastclinical->project_annual_mv;
    $history->current = $clinicalSite->project_annual_mv;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->schedual_start_date)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Scheduled Start Date';
    $history->previous = $lastclinical->schedual_start_date;
    $history->current = $clinicalSite->schedual_start_date;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->schedual_end_date)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Scheduled Etart Date';
    $history->previous = $lastclinical->schedual_end_date;
    $history->current = $clinicalSite->schedual_end_date;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->actual_start_date)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Actual Start Date';
    $history->previous = $lastclinical->actual_start_date;
    $history->current = $clinicalSite->actual_start_date;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->actual_end_date)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Actual End Date';
    $history->previous = $lastclinical->actual_end_date;
    $history->current = $clinicalSite->actual_end_date;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->lab_name)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Lab Name';
    $history->previous = $lastclinical->lab_name;
    $history->current = $clinicalSite->lab_name;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->monitring_per_by_si)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Monitoring Performed By';
    $history->previous = $lastclinical->monitring_per_by_si;
    $history->current = $clinicalSite->monitring_per_by_si;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->control_group)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Monitoring Performed By';
    $history->previous = $lastclinical->control_group;
    $history->current = $clinicalSite->control_group;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->consent_form)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Consent Form';
    $history->previous = $lastclinical->consent_form;
    $history->current = $clinicalSite->consent_form;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->budget)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Budget';
    $history->previous = $lastclinical->budget;
    $history->current = $clinicalSite->budget;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->proj_sties_si)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Project of Sites';
    $history->previous = $lastclinical->proj_sties_si;
    $history->current = $clinicalSite->proj_sties_si;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->proj_subject_si)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Project of Subject';
    $history->previous = $lastclinical->proj_subject_si;
    $history->current = $clinicalSite->proj_subject_si;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->auto_calcultion)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Subjects in Site';
    $history->previous = $lastclinical->auto_calcultion;
    $history->current = $clinicalSite->auto_calcultion;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->currency_si)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Currency';
    $history->previous = $lastclinical->currency_si;
    $history->current = $clinicalSite->currency_si;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->attached_payments)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Attached Payments';
    $history->previous = $lastclinical->attached_payments;
    $history->current = $clinicalSite->attached_payments;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->cra)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'CRA';
    $history->previous = $lastclinical->cra;
    $history->current = $clinicalSite->cra;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->lead_investigator)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Lead Investigator';
    $history->previous = $lastclinical->lead_investigator;
    $history->current = $clinicalSite->lead_investigator;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->reserve_team_associate)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Reserve Team Associate';
    $history->previous = $lastclinical->reserve_team_associate;
    $history->current = $clinicalSite->reserve_team_associate;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->additional_investigators)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Additional Investigators';
    $history->previous = $lastclinical->reserve_team_associate;
    $history->current = $clinicalSite->c;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->clini_res_coordi)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Clinical Site';
    $history->previous = $lastclinical->clini_res_coordi;
    $history->current = $clinicalSite->clini_res_coordi;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->pharmacist)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Pharmacist';
    $history->previous = $lastclinical->pharmacist;
    $history->current = $clinicalSite->pharmacist;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->comments_si)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Comments';
    $history->previous = $lastclinical->comments_si;
    $history->current = $clinicalSite->comments_si;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->budget_ut)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Budget';
    $history->previous = $lastclinical->budget_ut;
    $history->current = $clinicalSite->budget_ut;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}
if (!empty($clinicalSite->currency_ut)) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type = 'Currency';
    $history->previous = $lastclinical->currency_ut;
    $history->current = $clinicalSite->currency_ut;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Opened";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}}
// ================================================audit show update end ===========================



        // =================================grid data update============
        $griddata = $clinicalSite->id;
        $drug_accou = ClinicalSiteGrids::where(['cs_id' => $griddata, 'identifiers' => 'Drug Accountability'])->firstOrNew();
        $drug_accou->cs_id = $griddata;
        $drug_accou->identifiers = 'Drug Accountability';
        $drug_accou->data = $request->drugaccountability;
        $drug_accou->update();

        
        $equipment = ClinicalSiteGrids::where(['cs_id' => $griddata, 'identifiers' => 'Equipment'])->firstOrNew();
        $equipment->cs_id = $griddata;
        $equipment->identifiers = 'Equipment';
        $equipment->data = $request->equipments;
        $equipment->update();

        $finan_transa = ClinicalSiteGrids::where(['cs_id' => $griddata, 'identifiers' => 'Financial Transactions'])->firstOrNew();
        $finan_transa->cs_id = $griddata;
        $finan_transa->identifiers = 'Financial Transactions';
        $finan_transa->data = $request->financialTransactions;
        $finan_transa->update();

        // Return the updated resource as a JSON response
        toastr()->success('Record is updated Successfully');
        return redirect()->back();

    }


    public function clinicalsiteAuditTrial($id)
    {


        $audit = ClinicalSiteAudittrail::where('clinical_id', $id)->orderByDESC('id')->paginate();
        $today = Carbon::now()->format('d-m-y');
        $document = ClinicalSite::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');
// dd($document);
      
        return view('frontend.ctms.clinicalsite.audit-trial',compact('audit', 'document', 'today'));

    }

    


    public function ClinicalSiteStateChange(Request $request,$id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $clinicalstag = ClinicalSite::find($id);
            $lastDocument =  ClinicalSite::find($id);
            $data = ClinicalSite::find($id);


           if( $clinicalstag->stage == 1){
            $clinicalstag->stage = "2";
            $clinicalstag->to_Imp_phase_ny = Auth::user()->name;
            $clinicalstag->to_Imp_phase_on = Carbon::now()->format('d-M-Y');
            // $clinicalstag->submitted_comment = $request->comment;


            $clinicalstag->status = "Opened";
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $id;
            $history->activity_type = 'Activity Log';
            $history->current = $clinicalstag->submitted_by;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Opened";
            $history->change_from = $lastDocument->status;
            $history->stage='To Implementation Phase';
            $history->save();

            $clinicalstag->update();

            return redirect()->back();
           }



           if( $clinicalstag->stage == 2){
            $clinicalstag->stage = "3";
            $clinicalstag->to_pending_by = Auth::user()->name;
            $clinicalstag->	to_Pending_on = Carbon::now()->format('d-M-Y');
            // $clinicalstag->submitted_comment = $request->comment;


            $clinicalstag->status = "Implementation Phase";
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $id;
            $history->activity_type = 'Activity Log';
            $history->current = $clinicalstag->submitted_by;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Implementation Phase";
            $history->change_from = $lastDocument->status;
            $history->stage='To Pending';
            $history->save();

            $clinicalstag->update();

            return redirect()->back();
           }
           if( $clinicalstag->stage == 3){
            $clinicalstag->stage = "4";
            $clinicalstag->to_In_Effect_by = Auth::user()->name;
            $clinicalstag->to_In_Effect_on= Carbon::now()->format('d-M-Y');
            // $clinicalstag->submitted_comment = $request->comment;


            $clinicalstag->status = "Pending";
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $id;
            $history->activity_type = 'Activity Log';
            $history->current = $clinicalstag->submitted_by;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "Pending";
            $history->change_from = $lastDocument->status;
            $history->stage='To In Effect';
            $history->save();

            $clinicalstag->update();

            return redirect()->back();
           }

           if( $clinicalstag->stage == 4){
            $clinicalstag->stage = "6";
            $clinicalstag->Hold_Clinical_site_by = Auth::user()->name;
            $clinicalstag->Hold_Clinical_site_on = Carbon::now()->format('d-M-Y');
            // $clinicalstag->submitted_comment = $request->comment;


            $clinicalstag->status = "In Effect";
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $id;
            $history->activity_type = 'Activity Log';
            $history->current = $clinicalstag->submitted_by;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "In Effect";
            $history->change_from = $lastDocument->status;
            $history->stage='To In Effect';
            $history->save();

            $clinicalstag->update();

            return redirect()->back();
           }

        //    if( $clinicalstag->stage == 5){
        //     $clinicalstag->stage = "6";
        //     $clinicalstag->to_Imp_phase_ny = Auth::user()->name;
        //     $clinicalstag->to_Imp_phase_on = Carbon::now()->format('d-M-Y');
        //     // $clinicalstag->submitted_comment = $request->comment;


        //     $clinicalstag->status = "Clinical Site on Hold";
        //     $history = new ClinicalSiteAudittrail();
        //     $history->clinical_id = $id;
        //     $history->activity_type = 'Activity Log';
        //     $history->current = $clinicalstag->submitted_by;
        //     $history->comment = $request->comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastDocument->status;
        //     $history->change_to = "Clinical Site on Hold";
        //     $history->change_from = $lastDocument->status;
        //     $history->stage='Cancel';
        //     $history->save();

        //     $clinicalstag->update();

        //     return redirect()->back();
        //    }

           if( $clinicalstag->stage == 6){
            $clinicalstag->stage = "7";
            $clinicalstag->to_Imp_phase_ny = Auth::user()->name;
            $clinicalstag->to_Imp_phase_on = Carbon::now()->format('d-M-Y');
            // $clinicalstag->submitted_comment = $request->comment;


            $clinicalstag->status = "In Effect";
            $history = new ClinicalSiteAudittrail();
            $history->clinical_id = $id;
            $history->activity_type = 'Activity Log';
            $history->current = $clinicalstag->submitted_by;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = "In Effect";
            $history->change_from = $lastDocument->status;
            $history->stage='To In Effect';
            $history->save();

            $clinicalstag->update();

            return redirect()->back();
           }


        }else 
        {
            toastr()->error('E-signature Not match');
            return back();
        }


    }

    public function ClinicalSiteCancel(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = ClinicalSite::find($id);

            if ($changeControl->stage == 1) {
                $changeControl->stage = "0";
                $changeControl->status = "Closed - Cancelled";
                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changeControl->stage == 5) {
                $changeControl->stage = "0";
                $changeControl->status = "Closed - Cancelled";
                $changeControl->update();
                
                toastr()->success('Document Sent');
                return back();
            }


            // $changeControl->stage = "2";
            // // $changeControl->status = "Closed - Cancelled";
            // $changeControl->cancelled_by = Auth::user()->name;
            // $changeControl->cancelled_on = Carbon::now()->format('d-M-Y');
            // $changeControl->update();
            // toastr()->success('Document Sent');
            // return back();
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function ClinicalChild(Request $request,$id)
{
    // dd($request->revision);
    
    $cc = ClinicalSite::find($id);
    $cft = [];
    $parent_id = $id;
    $parent_type = "Capa";
    $old_record = Capa::select('id', 'division_id', 'record')->get();
    $record_number = ((RecordNumber::first()->value('counter')) + 1);
    $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
    $currentDate = Carbon::now();
    $formattedDate = $currentDate->addDays(30);
    $due_date = $formattedDate->format('d-M-Y');
    $parent_intiation_date = Capa::where('id', $id)->value('intiation_date');
    $parent_record =  ((RecordNumber::first()->value('counter')) + 1);
    $parent_record = str_pad($parent_record, 4, '0', STR_PAD_LEFT);
    $parent_initiator_id = $id;
   
    if ($request->revision == "rca-child") {
        $cc->originator = User::where('id', $cc->initiator_id)->value('name');
        return view('frontend.forms.root-cause-analysis', compact('record_number', 'due_date', 'parent_id','old_record', 'parent_type','parent_intiation_date','parent_record','parent_initiator_id','cft'));

    }
    if ($request->revision == "Action-Item") {
        // return "test";
        $cc->originator = User::where('id', $cc->initiator_id)->value('name');
        return view('frontend.forms.action-item', compact('record_number', 'due_date', 'parent_id','old_record', 'parent_type','parent_intiation_date','parent_record','parent_initiator_id'));

    }
    

}



    public function singleReport(Request $request, $id)
    {

        $data = ClinicalSite::find($id);
        // $prductgigrid =ClinicalSiteGrids::where(['cs_id' => $id,'identifer' => 'ProductDetails'])->first();
        // $martab_grid =MarketComplaintGrids::where(['mc_id' => $id,'identifer'=> 'Sutability'])->first();




        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.ctms.clinicalsite.singleReport', compact('data'))
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
            return $pdf->stream('Clinical Site' . $id . '.pdf');
        }


        return view('frontend.ctms.clinicalsite.singleReport',compact('data'));

    }
    // public function auditTrailPdf($id)
    // {
    
    //     $doc = ClinicalSite::find($id);
    //     $doc->originator = User::where('id', $doc->initiator_id)->value('name');
    //     $data = ClinicalSiteAudittrail::where('market_id', $doc->id)->orderByDesc('id')->paginate();
    //     $pdf = App::make('dompdf.wrapper');
    //     $time = Carbon::now();
    //     $pdf = PDF::loadview('frontend.ctms.clinicalsite.clinicalsite_audit_trail_pdf', compact('data', 'doc'))
    //         ->setOptions([
    //             'defaultFont' => 'sans-serif',
    //             'isHtml5ParserEnabled' => true,
    //             'isRemoteEnabled' => true,
    //             'isPhpEnabled' => true,
    //         ]);
    //     $pdf->setPaper('A4');
    //     $pdf->render();
    //     $canvas = $pdf->getDomPDF()->getCanvas();
    //     $height = $canvas->get_height();
    //     $width = $canvas->get_width();

    //     $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');

    //     $canvas->page_text(
    //         $width / 3,
    //         $height / 2,
    //         $doc->status,
    //         null,
    //         60,
    //         [0, 0, 0],
    //         2,
    //         6,
    //         -20
    //     );
    //     return $pdf->stream('Market-Audit_Trail' . $id . '.pdf');
    // }

    public function pdf($id){
            $doc = ClinicalSite::find($id);
            $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        $data = ClinicalSiteAudittrail::where('clinical_id', $doc->id)->orderByDesc('id')->paginate();
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.ctms.clinicalsite.clinicalsite_audit_trail_pdf', compact('data', 'doc'))
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
        return $pdf->stream('Market-Audit_Trail' . $id . '.pdf');
    }

    }


