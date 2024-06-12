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
        $clinicalSite->stage = 1;
        $clinicalSite->status = 'Opened';
        $clinicalSite->record = ((RecordNumber::first()->value('counter')) + 1);
        $clinicalSite->division_code = $request->input('division_code');
        $clinicalSite->initiator = $request->input('initiator');
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
        $data = ClinicalSite::findOrFail($id);
        $drug_accou = ClinicalSiteGrids::where('cs_id',$id)->where('identifiers','Drug Accountability')->first();
        $equipment= ClinicalSiteGrids::where('cs_id',$id)->where('identifiers','Equipment')->first();
        $finan_transa = ClinicalSiteGrids::where('cs_id',$id)->where('identifiers','Financial Transactions')->first();
    //    dd( $drug_accou);
        return view('frontend.ctms.clinicalsite.clinical_site_view',compact('data','finan_transa','equipment','drug_accou'));
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
if ( $lastclinical->description != $clinicalSite->description) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type ='Description';
    $history->previous = $lastclinical->description;
    $history->current = $clinicalSite->description;
    $history->comment = $request->description_comment;
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
    $history->activity_type ='Assign To';
    $history->previous = $lastclinical->assign_to;
    $history->current = $clinicalSite->assign_to;
    $history->comment = $request->assign_to_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}

if ( $lastclinical->due_date != $clinicalSite->due_date) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type ='Assign To';
    $history->previous = $lastclinical->due_date;
    $history->current = $clinicalSite->due_date;
    $history->comment = $request->due_date_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}

if ( $lastclinical->type != $clinicalSite->type) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type ='Assign To';
    $history->previous = $lastclinical->type;
    $history->current = $clinicalSite->type;
    $history->comment = $request->type_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}

if ( $lastclinical->site_name != $clinicalSite->site_name) {
    $history = new ClinicalSiteAudittrail();
    $history->clinical_id = $clinicalSite->id;
    $history->activity_type ='Assign To';
    $history->previous = $lastclinical->site_name;
    $history->current = $clinicalSite->site_name;
    $history->comment = $request->type_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $clinicalSite->status;
    $history->change_to = "Not Applicable";
    $history->change_from = $clinicalSite->status;
    $history->action_name = "Update";
    $history->save();
}



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



}