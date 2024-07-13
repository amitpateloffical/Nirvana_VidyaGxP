<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecordNumber;
use App\Models\RoleGroup;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Capa;
use App\Models\OpenStage;
use PDF;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use App\Models\EhsEvent;
use App\Models\EhsEventGrid;
use App\Models\EhsEventAuditTrail;
use PhpParser\Node\Identifier;
use App\Models\QMSDivision;
use App\Models\User;

class EhsEventController extends Controller
{
    
    public function index(){

        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        $division = QMSDivision::where('id',7)->get();
        // dd($division[]);
        

        return view('frontend.ehs.ehs-event.ehs_event',compact('record_number','division'));
    }

    public function store(Request $request)
    {
        if (!$request->short_description) {
            toastr()->error("Short description is required");
            return response()->redirect()->back()->withInput();
        }


        $ehsevent = new EhsEvent();
        // $ehsevent->form_type = "EhsEvent";
        // $ehsevent->record = ((RecordNumber::first()->value('counter')) + 1);
        // $ehsevent->initiator_id = Auth::user()->id;

        # -------------new-----------
        //  $ehsevent->record_number = $request->record_number;
        $ehsevent->record = ((RecordNumber::first()->value('counter')) + 1);
        $ehsevent->initiator_id = Auth:: user()->id;
        $ehsevent->intiation_date = $request->intiation_date;
        $ehsevent->assigned_to = $request->assigned_to;
        $ehsevent->date_due = $request->date_due;
        $ehsevent->short_description = $request->short_description;
        $ehsevent->event_type = $request->event_type;
        $ehsevent->incident_sub_type = $request->incident_sub_type;

        $ehsevent->date_occurred = $request->date_occurred;
        $ehsevent->time_occurred = $request->time_occurred;
        $ehsevent->date_of_reporting = $request->date_of_reporting;
        $ehsevent->reporter = $request->reporter;
        
        
        $ehsevent->similar_incidents = $request->similar_incidents;
        $ehsevent->description = $request->description;
        $ehsevent->immediate_actions = $request->immediate_actions;

        
        // $ehsevent->Description_Deviation = implode(',', $request->Description_Deviation);

       
      

        //     $ehsevent->QA_attachment = json_encode($files);
        // }
        // if (!empty ($request->Investigation_attachment)) {
        //     $files = [];
        //     if ($request->hasfile('Investigation_attachment')) {
        //         foreach ($request->file('Investigation_attachment') as $file) {
        //             $name = $request->name . 'Investigation_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        //             $file->move('upload/', $name);
        //             $files[] = $name;
        //         }
        //     }


        //     $ehsevent->Investigation_attachment = json_encode($files);
        // }
        // if (!empty ($request->Capa_attachment)) {
        //     $files = [];
        //     if ($request->hasfile('Capa_attachment')) {
        //         foreach ($request->file('Capa_attachment') as $file) {
        //             $name = $request->name . 'Capa_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        //             $file->move('upload/', $name);
        //             $files[] = $name;
        //         }
        //     }


        //     $ehsevent->Capa_attachment = json_encode($files);
        // }
       
        // if (!empty ($request->closure_attachment)) {
        //     $files = [];
        //     if ($request->hasfile('closure_attachment')) {
        //         foreach ($request->file('closure_attachment') as $file) {
        //             $name = $request->name . 'closure_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        //             $file->move('upload/', $name);
        //             $files[] = $name;
        //         }
        //     }


        //     $ehsevent->closure_attachment = json_encode($files);
        // }

        //--------------ccform2---------------------------------
        $ehsevent->accident_type = $request->accident_type;
        $ehsevent->osha_reportable = $request->osha_reportable;
        $ehsevent->first_lost_work_date = $request->first_lost_work_date;

        $ehsevent->last_lost_work_date = $request->last_lost_work_date;
        $ehsevent->first_restricted_work_date = $request->first_restricted_work_date;
        $ehsevent->last_restricted_work_date = $request->last_restricted_work_date;
        $ehsevent->vehicle_type = $request->vehicle_type;
        $ehsevent->vehicle_number = $request->vehicle_number;
        $ehsevent->litigation = $request->litigation;
        $ehsevent->department = $request->department;
        $ehsevent->employee_involved = $request->employee_involved;
        $ehsevent->involved_contractor = $request->involved_contractor;
        $ehsevent->attorneys_involved = $request->attorneys_involved;
        $ehsevent->lead_investigator = $request->lead_investigator; 
        $ehsevent->line_operator = $request->line_operator;
        $ehsevent->detail_info_reporter = $request->detail_info_reporter;
        $ehsevent->supervisor = $request->supervisor;
        $ehsevent->unsafe_situation = $request->unsafe_situation;
        $ehsevent->safeguarding_measure_taken = $request->safeguarding_measure_taken;
        $ehsevent->enviromental_category = $request->enviromental_category;
        $ehsevent->Special_Weather_Conditions = $request->Special_Weather_Conditions;
        $ehsevent->source_Of_release_or_spill = $request->source_Of_release_or_spill;

        // $ehsevent->Special_Weather_Conditions = $request->Special_Weather_Conditions;
        $ehsevent->environment_evacuation_ordered = $request->environment_evacuation_ordered;
        $ehsevent->date_simples_taken = $request->date_simples_taken;
        $ehsevent->agency_notified = $request->agency_notified;
        $ehsevent->fire_category = $request->fire_category;
        $ehsevent->fire_evacuation_ordered = $request->fire_evacuation_ordered;
        $ehsevent->combat_by = $request->combat_by;
        $ehsevent->fire_fighting_equipment_used = $request->fire_fighting_equipment_used;
        $ehsevent->zone = $request->zone;
        $ehsevent->country = $request->country;
        $ehsevent->city = $request->city;
        $ehsevent->state = $request->state;
        $ehsevent->site_name = $request->site_name;
        $ehsevent->building = $request->building;
        $ehsevent->floor = $request->floor;
        $ehsevent->room = $request->room;
        $ehsevent->location = $request->location;
        
        
        // --------------------CCform3 -------------------------------
        $ehsevent->victim = $request->victim;
        $ehsevent->medical_treatment = $request->medical_treatment;
        $ehsevent->victim_position = $request->victim_position;
        $ehsevent->victim_realation = $request->victim_realation;
        $ehsevent->hospitalization = $request->hospitalization;
        $ehsevent->hospital_name = $request->hospital_name;
        $ehsevent->date_of_treatment = $request->date_of_treatment;
        $ehsevent->victim_treated_by = $request->victim_treated_by;
        $ehsevent->medical_treatment_discription = $request->medical_treatment_discription;

        $ehsevent->injury_type = $request->injury_type;
        $ehsevent->number_of_injuries = $request->number_of_injuries;
        $ehsevent->type_of_illness = $request->type_of_illness;
        $ehsevent->permanent_disability = $request->permanent_disability;
        $ehsevent->damage_category = $request->damage_category;
        $ehsevent->related_equipment = $request->related_equipment;
        $ehsevent->estimated_amount = $request->estimated_amount;
        $ehsevent->insurance_company_involved = $request->insurance_company_involved;
        $ehsevent->denied_by_insurance = $request->denied_by_insurance;
        $ehsevent->damage_details = $request->damage_details;

        // --------------------CCform4 -------------------------------
        $ehsevent->actual_amount = $request->actual_amount;
        $ehsevent->currency = $request->currency;
        $ehsevent->investigation_summary = $request->investigation_summary;
        $ehsevent->conclusion = $request->conclusion;

        // --------------------CCform5 -------------------------------
        $ehsevent->safety_impact_probability = $request->safety_impact_probability;
        $ehsevent->safety_impact_severity = $request->safety_impact_severity;
        $ehsevent->legal_impact_probability = $request->legal_impact_probability;
        $ehsevent->legal_impact_severity = $request->legal_impact_severity;
        $ehsevent->business_impact_probability = $request->business_impact_probability;
        $ehsevent->business_impact_severity = $request->business_impact_severity;
        $ehsevent->revenue_impact_probability = $request->revenue_impact_probability;
        $ehsevent->revenue_impact_severity = $request->revenue_impact_severity;
        $ehsevent->brand_impact_probability = $request->brand_impact_probability;
        $ehsevent->brand_impact_severity = $request->brand_impact_severity;
        $ehsevent->safety_impact_risk = $request->safety_impact_risk;
        $ehsevent->legal_impact_risk = $request->legal_impact_risk;
        $ehsevent->business_impact_risk = $request->business_impact_risk;
        $ehsevent->revenue_impact_risk = $request->revenue_impact_risk;
        $ehsevent->brand_impact_risk = $request->brand_impact_risk;
        $ehsevent->impact = $request->impact;
        $ehsevent->impact_analysis = $request->impact_analysis;
        $ehsevent->recommended_action = $request->recommended_action;
        $ehsevent->comments = $request->comments;
        $ehsevent->direct_cause = $request->direct_cause;

        $ehsevent->root_cause_safeguarding_measure_taken = $request->root_cause_safeguarding_measure_taken;
        $ehsevent->root_cause_methodlogy = $request->root_cause_methodlogy;
        
        $ehsevent->root_cause_description = $request->root_cause_description;
        $ehsevent->severity_rate = $request->severity_rate;
        $ehsevent->occurrence = $request->occurrence;
        $ehsevent->detection = $request->detection;
        $ehsevent->rpn = $request->rpn;
        $ehsevent->risk_analysis = $request->risk_analysis;
        $ehsevent->criticality = $request->criticality;
        $ehsevent->inform_local_authority = $request->inform_local_authority;
        $ehsevent->authority_type = $request->authority_type;
        $ehsevent->authority_notified = $request->authority_notified;
        $ehsevent->other_authority = $request->other_authority;

        $ehsevent->status = 'Opened';
        $ehsevent->stage = 1;
        
        $ehsevent->save();
    
    
    if (!empty($request->file_attachment)) {
        $files = [];
        if ($request->hasfile('file_attachment')) {
                        foreach ($request->file('file_attachment') as $file) {
                            $name = $request->name . 'file_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                            $file->move('upload/', $name);
                            $files[] = $name;
                        }
                    }
                    // $ehsevent = new EhsEvent;
                    $ehsevent->file_attachment = json_encode($files);
                }

        $ehsevent->save();  

        
        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();


//------------------- audit trail start--------------------------------------------------
                
if (!empty($request->short_description)) {
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $ehsevent->id;
    $history->activity_type = 'Short Description';
    $history->previous = "Null";
    $history->current = $request->short_description;
    $history->comment = "Not Applicable";
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $ehsevent->status;
    $history->change_to =   "Opened";
    $history->change_from = "Initiation";
    $history->action_name = 'Create';
    $history->save();
}

    if (!empty($request->event_type)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Event type';
        $history->previous = "Null";
        $history->current = $request->event_type;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->incident_sub_type)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Incident Sub-Type';
        $history->previous = "Null";
        $history->current = $request->incident_sub_type;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->date_occurred)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Date Occurred ';
        $history->previous = "Null";
        $history->current = $request->date_occurred;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->time_occurred)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Time Occurred';
        $history->previous = "Null";
        $history->current = $request->time_occurred;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->date_of_reporting)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Date of Reporting';
        $history->previous = "Null";
        $history->current = $request->date_of_reporting;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->reporter)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Reporter';
        $history->previous = "Null";
        $history->current = $request->reporter;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->file_attachment)) {
        $fileAttachments = implode(',', $request->file_attachment); // Convert array to string
        
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'File Attachments';
        $history->previous = "Null";
        $history->current = $fileAttachments;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to = "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    
    if (!empty($request->similar_incidents)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Similar Incidents(s)';
        $history->previous = "Null";
        $history->current = $request->similar_incidents;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->description)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Description';
        $history->previous = "Null";
        $history->current = $request->description;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->immediate_actions)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Immediate Actions';
        $history->previous = "Null";
        $history->current = $request->immediate_actions;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    // -------------------ccform2--------------------------
    if (!empty($request->accident_type)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Accident Type';
        $history->previous = "Null";
        $history->current = $request->accident_type;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->osha_reportable)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'OSHA Reportable?';
        $history->previous = "Null";
        $history->current = $request->osha_reportable;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->first_lost_work_date)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'First Lost Work Date';
        $history->previous = "Null";
        $history->current = $request->first_lost_work_date;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->last_lost_work_date)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Last Lost Work Date';
        $history->previous = "Null";
        $history->current = $request->last_lost_work_date;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->first_restricted_work_date)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'First Restricted Work Date';
        $history->previous = "Null";
        $history->current = $request->first_restricted_work_date;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->last_restricted_work_date)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Last Restricted Work Date';
        $history->previous = "Null";
        $history->current = $request->last_restricted_work_date;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->vehicle_type)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Vehicle Type';
        $history->previous = "Null";
        $history->current = $request->vehicle_type;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->vehicle_number)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Vehicle Number';
        $history->previous = "Null";
        $history->current = $request->vehicle_number;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->litigation)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Litigation';
        $history->previous = "Null";
        $history->current = $request->litigation;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->department)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Department(s)';
        $history->previous = "Null";
        $history->current = $request->department;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->employee_involved)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Employee(s) Involved';
        $history->previous = "Null";
        $history->current = $request->employee_involved;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->involved_contractor)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Involved(s) Contractor(s)';
        $history->previous = "Null";
        $history->current = $request->involved_contractor;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->attorneys_involved)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Attorneys (s) Involved(s)';
        $history->previous = "Null";
        $history->current = $request->attorneys_involved;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }

    //-----------grid----------------
    if (!empty($request->lead_investigator)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Lead Investigator';
        $history->previous = "Null";
        $history->current = $request->lead_investigator;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->line_operator)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Line Operator ';
        $history->previous = "Null";
        $history->current = $request->line_operator;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->detail_info_reporter)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Reporter';
        $history->previous = "Null";
        $history->current = $request->detail_info_reporter;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->supervisor)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Supervisor';
        $history->previous = "Null";
        $history->current = $request->supervisor;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->unsafe_situation)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Unsafe Situation';
        $history->previous = "Null";
        $history->current = $request->unsafe_situation;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->safeguarding_measure_taken)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Safeguarding Measure Taken';
        $history->previous = "Null";
        $history->current = $request->safeguarding_measure_taken;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->enviromental_category)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Enviromental Category';
        $history->previous = "Null";
        $history->current = $request->enviromental_category;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->Special_Weather_Conditions)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Special Weather Conditions';
        $history->previous = "Null";
        $history->current = $request->Special_Weather_Conditions;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->source_Of_release_or_spill)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Source Of Release or Spill';
        $history->previous = "Null";
        $history->current = $request->source_Of_release_or_spill;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->Special_Weather_Conditions)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Special Weather Conditions';
        $history->previous = "Null";
        $history->current = $request->Special_Weather_Conditions;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->environment_evacuation_ordered)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Environment Evacuation Ordered';
        $history->previous = "Null";
        $history->current = $request->environment_evacuation_ordered;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->date_simples_taken)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Date Simples Taken';
        $history->previous = "Null";
        $history->current = $request->date_simples_taken;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->agency_notified)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Agency(s) Notified';
        $history->previous = "Null";
        $history->current = $request->agency_notified;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->fire_category)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Fire Category';
        $history->previous = "Null";
        $history->current = $request->fire_category;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->fire_evacuation_ordered)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Fire Evacuation Ordered?';
        $history->previous = "Null";
        $history->current = $request->fire_evacuation_ordered;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->combat_by)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Combat By';
        $history->previous = "Null";
        $history->current = $request->combat_by;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->fire_fighting_equipment_used)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Fire Fighting Equipment Used';
        $history->previous = "Null";
        $history->current = $request->fire_fighting_equipment_used;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->zone)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Zone';
        $history->previous = "Null";
        $history->current = $request->zone;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->country)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Country';
        $history->previous = "Null";
        $history->current = $request->country;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }

    if (!empty($request->city)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'City';
        $history->previous = "Null";
        $history->current = $request->city;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->state)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'State/District';
        $history->previous = "Null";
        $history->current = $request->state;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->site_name)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Site Name';
        $history->previous = "Null";
        $history->current = $request->site_name;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->building)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Building';
        $history->previous = "Null";
        $history->current = $request->building;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->floor)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Floor';
        $history->previous = "Null";
        $history->current = $request->floor;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->room)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Room';
        $history->previous = "Null";
        $history->current = $request->room;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->location)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Location';
        $history->previous = "Null";
        $history->current = $request->location;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }

    //--------------ccform3--------------------
    if (!empty($request->victim)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Victim';
        $history->previous = "Null";
        $history->current = $request->victim;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->medical_treatment)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Medical Treatment?(Y/N)';
        $history->previous = "Null";
        $history->current = $request->medical_treatment;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->victim_position)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Victim Position';
        $history->previous = "Null";
        $history->current = $request->victim_position;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->victim_realation)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Victim Realation To Company';
        $history->previous = "Null";
        $history->current = $request->victim_realation;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->hospitalization)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Hospitalization';
        $history->previous = "Null";
        $history->current = $request->hospitalization;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }

    if (!empty($request->hospital_name)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Hospital Name';
        $history->previous = "Null";
        $history->current = $request->hospital_name;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->date_of_treatment)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Date of Treatment';
        $history->previous = "Null";
        $history->current = $request->date_of_treatment;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->victim_treated_by)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Victim Treated By';
        $history->previous = "Null";
        $history->current = $request->victim_treated_by;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->medical_treatment_discription)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Medical Treatment Discription';
        $history->previous = "Null";
        $history->current = $request->medical_treatment_discription;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->injury_type)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Injury Type';
        $history->previous = "Null";
        $history->current = $request->injury_type;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->number_of_injuries)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Number of Injuries';
        $history->previous = "Null";
        $history->current = $request->number_of_injuries;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->type_of_illness)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Type of Illness';
        $history->previous = "Null";
        $history->current = $request->type_of_illness;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->permanent_disability)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Permanent Disability?';
        $history->previous = "Null";
        $history->current = $request->permanent_disability;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->damage_category)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Damage Category';
        $history->previous = "Null";
        $history->current = $request->damage_category;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->related_equipment)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Related Equipment';
        $history->previous = "Null";
        $history->current = $request->related_equipment;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->estimated_amount)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Estimated Amount of Damage Equipment';
        $history->previous = "Null";
        $history->current = $request->estimated_amount;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->insurance_company_involved)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Insurance Company Involved?';
        $history->previous = "Null";
        $history->current = $request->insurance_company_involved;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->denied_by_insurance)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Denied By Insurance Company?';
        $history->previous = "Null";
        $history->current = $request->denied_by_insurance;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->damage_details)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Damage Details';
        $history->previous = "Null";
        $history->current = $request->damage_details;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    //--------------ccform4-------------------
    if (!empty($request->actual_amount)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Actual Amount of Damage';
        $history->previous = "Null";
        $history->current = $request->actual_amount;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->currency)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Currency';
        $history->previous = "Null";
        $history->current = $request->currency;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->investigation_summary)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Investigation summary';
        $history->previous = "Null";
        $history->current = $request->investigation_summary;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->conclusion)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Conclusion';
        $history->previous = "Null";
        $history->current = $request->conclusion;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }

    //---------------ccfrom5----------------
    if (!empty($request->safety_impact_probability)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Safety Impact Probability';
        $history->previous = "Null";
        $history->current = $request->safety_impact_probability;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->safety_impact_severity)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Safety Impact Severity';
        $history->previous = "Null";
        $history->current = $request->safety_impact_severity;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->legal_impact_probability)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Legal Impact Probability';
        $history->previous = "Null";
        $history->current = $request->legal_impact_probability;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->legal_impact_severity)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Legal Impact Severity';
        $history->previous = "Null";
        $history->current = $request->legal_impact_severity;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->business_impact_probability)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Business Impact Probability';
        $history->previous = "Null";
        $history->current = $request->business_impact_probability;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->business_impact_severity)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Business Impact Severity';
        $history->previous = "Null";
        $history->current = $request->business_impact_severity;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->revenue_impact_probability)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Revenue Impact Probability';
        $history->previous = "Null";
        $history->current = $request->revenue_impact_probability;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->revenue_impact_severity)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Revenue Impact Severity';
        $history->previous = "Null";
        $history->current = $request->revenue_impact_severity;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->brand_impact_probability)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Brand Impact Probability';
        $history->previous = "Null";
        $history->current = $request->brand_impact_probability;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->brand_impact_severity)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Brand Impact Severity';
        $history->previous = "Null";
        $history->current = $request->brand_impact_severity;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->safety_impact_risk)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Safety Impact Risk';
        $history->previous = "Null";
        $history->current = $request->safety_impact_risk;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->legal_impact_risk)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Legal Impact Risk';
        $history->previous = "Null";
        $history->current = $request->legal_impact_risk;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->business_impact_risk)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Business Impact Risk';
        $history->previous = "Null";
        $history->current = $request->business_impact_risk;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->revenue_impact_risk)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Revenue Impact Risk';
        $history->previous = "Null";
        $history->current = $request->revenue_impact_risk;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->brand_impact_risk)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Brand Impact Risk';
        $history->previous = "Null";
        $history->current = $request->brand_impact_risk;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->impact)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Impact';
        $history->previous = "Null";
        $history->current = $request->impact;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }if (!empty($request->impact_analysis)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Impact Analysis';
        $history->previous = "Null";
        $history->current = $request->impact_analysis;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->recommended_action)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Recommended Action';
        $history->previous = "Null";
        $history->current = $request->recommended_action;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->comments)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Comments';
        $history->previous = "Null";
        $history->current = $request->comments;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->direct_cause)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Direct Cause';
        $history->previous = "Null";
        $history->current = $request->direct_cause;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->root_cause_safeguarding_measure_taken)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Safeguarding Measure Taken';
        $history->previous = "Null";
        $history->current = $request->root_cause_safeguarding_measure_taken;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->root_cause_methodlogy)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Root cause Methodlogy';
        $history->previous = "Null";
        $history->current = $request->root_cause_methodlogy;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->root_cause_description)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Root cause Description';
        $history->previous = "Null";
        $history->current = $request->root_cause_description;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->severity_rate)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Severity Rate';
        $history->previous = "Null";
        $history->current = $request->severity_rate;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->occurrence)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Occurrence';
        $history->previous = "Null";
        $history->current = $request->occurrence;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->detection)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Detection';
        $history->previous = "Null";
        $history->current = $request->detection;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->rpn)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'RPN';
        $history->previous = "Null";
        $history->current = $request->rpn;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }if (!empty($request->risk_analysis)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Risk Analysis';
        $history->previous = "Null";
        $history->current = $request->risk_analysis;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->criticality)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Criticality';
        $history->previous = "Null";
        $history->current = $request->criticality;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->inform_local_authority)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Inform Local Authority?';
        $history->previous = "Null";
        $history->current = $request->inform_local_authority;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->authority_type)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Authority Type';
        $history->previous = "Null";
        $history->current = $request->authority_type;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->authority_notified)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Authority(s) Notified';
        $history->previous = "Null";
        $history->current = $request->authority_notified;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    if (!empty($request->other_authority)) {
        $history = new EhsEventAuditTrail();
        $history->ehse_id = $ehsevent->id;
        $history->activity_type = 'Other Authority';
        $history->previous = "Null";
        $history->current = $request->other_authority;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $ehsevent->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiation";
        $history->action_name = 'Create';
        $history->save();
    }
    //------------------------------Audit trail End-----------------------------------------------------


    //------------------------------grid Start  --------------------------------------------------------
    $ehsevent_id1= $ehsevent->id;
    $newDataMeetingManagement = EhsEventGrid::where(['ci_id' => $ehsevent_id1, 'identifier' => 'Witness_details' ])->firstOrNew();
    $newDataMeetingManagement->ci_id = $ehsevent_id1;
    $newDataMeetingManagement->identifier = 'Witness_details';
    $newDataMeetingManagement->data = $request->Witness_details_details;
    $newDataMeetingManagement->save();

    $ehsevent_id2= $ehsevent->id;
    $newDataMeetingManagement = EhsEventGrid::where(['ci_id' => $ehsevent_id2, 'identifier' => 'materials_released' ])->firstOrCreate();
    $newDataMeetingManagement->ci_id = $ehsevent_id2;
    $newDataMeetingManagement->identifier = 'materials_released';
    $newDataMeetingManagement->data = $request->materials_released;
    $newDataMeetingManagement->save();
    
    $ehsevent_id3= $ehsevent->id;
    $newDataMeetingManagement = EhsEventGrid::where(['ci_id' => $ehsevent_id3, 'identifier' => 'root_cause' ])->firstOrCreate();
    $newDataMeetingManagement->ci_id = $ehsevent_id3;
    $newDataMeetingManagement->identifier = 'root_cause';
    $newDataMeetingManagement->data = $request->root_cause;
    $newDataMeetingManagement->save();
    
    //------------------------------grid End-----------------------------------------------------------
    
    
    toastr()->success("Record is created Successfully");
        return redirect(url('rcms/qms-dashboard'));
    }

    public function ViewShow($id)
    {
  
        $ehsevent = EhsEvent::find($id);
        
        $ehsevent->record = str_pad($ehsevent->record, 4, '0', STR_PAD_LEFT);
        $ehsevent->assign_to_name = User::where('id', $ehsevent->assign_id)->value('name');
        $ehsevent->initiator_name = User::where('id', $ehsevent->initiator_id)->value('name');
     
        
        $grid_data1 = EhsEventGrid::where(['ci_id' => $id, 'identifier' => 'Witness_details'])->firstorCreate();
        $grid_data2= EhsEventGrid:: where(['ci_id'=> $id, 'identifier' =>'materials_released'])->firstorCreate();
        $grid_data3= EhsEventGrid:: where(['ci_id'=> $id, 'identifier' =>'root_cause'])->firstorCreate();
        
        return view('frontend.ehs.ehs-event.ehs_event_view', compact('ehsevent','grid_data1','grid_data2','grid_data3'));
    } 
     public function update(Request $request, $id)
    {
        $lastDocument = EhsEvent::find($id);
        $ehsevent = EhsEvent::find($id);
        $lastdata = EhsEvent::find($id);
        $lastDocumentRecord = EhsEvent::find($ehsevent->id);
        $lastDocumentStatus = $lastDocumentRecord ? $lastDocumentRecord->status : null;


        // $old_record = EhsEvent::select('id', 'division_id', 'record')->get();
        $ehsevent = EhsEvent::find($id);
        //--------------ccform1 ---------------------------------
        $ehsevent->initiator_id = Auth:: user()->id;
        // $ehsevent->intiation_date = $request->intiation_date;
        $ehsevent->assigned_to = $request->assigned_to;
        // $ehsevent->date_due = $request->date_due;
        $ehsevent->short_description = $request->short_description;
        $ehsevent->event_type = $request->event_type;
        $ehsevent->incident_sub_type = $request->incident_sub_type;
        // $ehsevent->date_occurred = $request->date_occurred;
        $ehsevent->time_occurred = $request->time_occurred;
        // $ehsevent->date_of_reporting = $request->date_of_reporting;
        $ehsevent->reporter = $request->reporter;
        $ehsevent->similar_incidents = $request->similar_incidents;
        $ehsevent->description = $request->description;
        $ehsevent->immediate_actions = $request->immediate_actions;

        //--------------ccform2 ---------------------------------
        $ehsevent->accident_type = $request->accident_type;
        $ehsevent->osha_reportable = $request->osha_reportable;
        // $ehsevent->first_lost_work_date = $request->first_lost_work_date;
        // $ehsevent->last_lost_work_date = $request->last_lost_work_date;
        // $ehsevent->first_restricted_work_date = $request->first_restricted_work_date;
        // $ehsevent->last_restricted_work_date = $request->last_restricted_work_date;
        $ehsevent->vehicle_type = $request->vehicle_type;
        $ehsevent->vehicle_number = $request->vehicle_number;
        $ehsevent->litigation = $request->litigation;
        $ehsevent->department = $request->department;
        $ehsevent->employee_involved = $request->employee_involved;
        $ehsevent->involved_contractor = $request->involved_contractor;
        $ehsevent->attorneys_involved = $request->attorneys_involved;
        $ehsevent->lead_investigator = $request->lead_investigator; 
        $ehsevent->line_operator = $request->line_operator;
        $ehsevent->detail_info_reporter = $request->detail_info_reporter;
        $ehsevent->supervisor = $request->supervisor;
        $ehsevent->unsafe_situation = $request->unsafe_situation;
        $ehsevent->safeguarding_measure_taken = $request->safeguarding_measure_taken;
        $ehsevent->enviromental_category = $request->enviromental_category;
        $ehsevent->Special_Weather_Conditions = $request->Special_Weather_Conditions;
        $ehsevent->source_Of_release_or_spill = $request->source_Of_release_or_spill;
        // $ehsevent->Special_Weather_Conditions = $request->Special_Weather_Conditions;
        $ehsevent->environment_evacuation_ordered = $request->environment_evacuation_ordered;
        // $ehsevent->date_simples_taken = $request->date_simples_taken;
        $ehsevent->agency_notified = $request->agency_notified;
        $ehsevent->fire_category = $request->fire_category;
        $ehsevent->fire_evacuation_ordered = $request->fire_evacuation_ordered;
        $ehsevent->combat_by = $request->combat_by;
        $ehsevent->fire_fighting_equipment_used = $request->fire_fighting_equipment_used;
        $ehsevent->zone = $request->zone;
        $ehsevent->country = $request->country;
        $ehsevent->city = $request->city;
        $ehsevent->state = $request->state;
        $ehsevent->site_name = $request->site_name;
        $ehsevent->building = $request->building;
        $ehsevent->floor = $request->floor;
        $ehsevent->room = $request->room;

        $ehsevent->location = $request->location;
        
        // --------------------CCform3 -------------------------------
        $ehsevent->victim = $request->victim;
        $ehsevent->medical_treatment = $request->medical_treatment;
        $ehsevent->victim_position = $request->victim_position;
        $ehsevent->victim_realation = $request->victim_realation;
        $ehsevent->hospitalization = $request->hospitalization;
        $ehsevent->hospital_name = $request->hospital_name;
        // $ehsevent->date_of_treatment = $request->date_of_treatment;
        $ehsevent->victim_treated_by = $request->victim_treated_by;
        $ehsevent->medical_treatment_discription = $request->medical_treatment_discription;
        $ehsevent->injury_type = $request->injury_type;
        $ehsevent->number_of_injuries = $request->number_of_injuries;
        $ehsevent->type_of_illness = $request->type_of_illness;
        $ehsevent->permanent_disability = $request->permanent_disability;
        $ehsevent->damage_category = $request->damage_category;
        $ehsevent->related_equipment = $request->related_equipment;
        $ehsevent->estimated_amount = $request->estimated_amount;
        $ehsevent->insurance_company_involved = $request->insurance_company_involved;
        $ehsevent->denied_by_insurance = $request->denied_by_insurance;
        $ehsevent->damage_details = $request->damage_details;

        // --------------------CCform4 -------------------------------
        $ehsevent->actual_amount = $request->actual_amount;
        $ehsevent->currency = $request->currency;
        $ehsevent->investigation_summary = $request->investigation_summary;
        $ehsevent->conclusion = $request->conclusion;

        // --------------------CCform5 -------------------------------
        $ehsevent->safety_impact_probability = $request->safety_impact_probability;
        $ehsevent->safety_impact_severity = $request->safety_impact_severity;
        $ehsevent->legal_impact_probability = $request->legal_impact_probability;
        $ehsevent->legal_impact_severity = $request->legal_impact_severity;
        $ehsevent->business_impact_probability = $request->business_impact_probability;
        $ehsevent->business_impact_severity = $request->business_impact_severity;
        $ehsevent->revenue_impact_probability = $request->revenue_impact_probability;
        $ehsevent->revenue_impact_severity = $request->revenue_impact_severity;
        $ehsevent->brand_impact_probability = $request->brand_impact_probability;
        $ehsevent->brand_impact_severity = $request->brand_impact_severity;
        $ehsevent->safety_impact_risk = $request->safety_impact_risk;
        $ehsevent->legal_impact_risk = $request->legal_impact_risk;
        $ehsevent->business_impact_risk = $request->business_impact_risk;
        $ehsevent->revenue_impact_risk = $request->revenue_impact_risk;
        $ehsevent->brand_impact_risk = $request->brand_impact_risk;
        $ehsevent->impact = $request->impact;
        $ehsevent->impact_analysis = $request->impact_analysis;
        $ehsevent->recommended_action = $request->recommended_action;
        $ehsevent->comments = $request->comments;
        $ehsevent->direct_cause = $request->direct_cause;
        $ehsevent->root_cause_safeguarding_measure_taken = $request->root_cause_safeguarding_measure_taken;
        $ehsevent->root_cause_methodlogy = $request->root_cause_methodlogy;
        $ehsevent->root_cause_description = $request->root_cause_description;
        $ehsevent->severity_rate = $request->severity_rate;
        $ehsevent->occurrence = $request->occurrence;
        $ehsevent->detection = $request->detection;
        $ehsevent->rpn = $request->rpn;
        $ehsevent->risk_analysis = $request->risk_analysis;
        $ehsevent->criticality = $request->criticality;
        $ehsevent->inform_local_authority = $request->inform_local_authority;
        $ehsevent->authority_type = $request->authority_type;
        $ehsevent->authority_notified = $request->authority_notified;
        $ehsevent->other_authority = $request->other_authority;

                if (!empty($request->file_attachment)) {
                    $files = [];
                    if ($request->hasfile('file_attachment')) {
                        foreach ($request->file('file_attachment') as $file) {
                            $name = $request->name . 'file_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                            $file->move('upload/', $name);
                            $files[] = $name;
                        }
                    }
                    // $ehsevent = new EhsEvent;
                    $ehsevent->file_attachment = json_encode($files);
                }
                
        $ehsevent->update();  


//------------------- audit trail update start--------------------------------------------------------
if ($lastDocument->date_due != $ehsevent->date_due || ! empty($request->date_due_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Due Date')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Due Date';
    $history->previous = $lastDocument->date_due;
    $history->current = $ehsevent->date_due;
    $history->comment = $request->date_due_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}

if ($lastDocument->short_description != $ehsevent->short_description || ! empty($request->short_description_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Short description')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Short description';
    $history->previous = $lastDocument->short_description;
    $history->current = $ehsevent->short_description;
    $history->comment = $request->short_description_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}

if ($lastDocument->event_type != $ehsevent->event_type || ! empty($request->event_type_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Event type')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Event type';
    $history->previous = $lastDocument->event_type;
    $history->current = $ehsevent->event_type;
    $history->comment = $request->event_type_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;
    
    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}

if ($lastDocument->incident_sub_type != $ehsevent->incident_sub_type || ! empty($request->incident_sub_type_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Incident Sub Type')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Incident Sub Type';
    $history->previous = $lastDocument->incident_sub_type;
    $history->current = $ehsevent->short_description;
    $history->comment = $request->incident_sub_type_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->date_occurred != $ehsevent->date_occurred || ! empty($request->date_occurred_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Date Occurred')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Short description';
    $history->previous = $lastDocument->date_occurred;
    $history->current = $ehsevent->date_occurred;
    $history->comment = $request->date_occurred_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->time_occurred != $ehsevent->time_occurred || ! empty($request->time_occurred_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Time Occurred')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Time Occurred';
    $history->previous = $lastDocument->time_occurred;
    $history->current = $ehsevent->time_occurred;
    $history->comment = $request->time_occurred_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->date_of_reporting != $ehsevent->date_of_reporting || ! empty($request->date_of_reporting_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Date of reporting')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Date of reporting';
    $history->previous = $lastDocument->date_of_reporting;
    $history->current = $ehsevent->date_of_reporting;
    $history->comment = $request->date_of_reporting_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->reporter != $ehsevent->reporter || ! empty($request->reporter_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Reporter')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Reporter';
    $history->previous = $lastDocument->reporter;
    $history->current = $ehsevent->reporter;
    $history->comment = $request->reporter_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->file_attachment != $ehsevent->file_attachment || ! empty($request->file_attachment_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'File attachment')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'File attachment';
    $history->previous = $lastDocument->file_attachment;
    $history->current = $ehsevent->file_attachment;
    $history->comment = $request->file_attachment_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->similar_incidents != $ehsevent->similar_incidents || ! empty($request->similar_incidents_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Similar Incidents')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Similar Incidents';
    $history->previous = $lastDocument->similar_incidents;
    $history->current = $ehsevent->similar_incidents;
    $history->comment = $request->similar_incidents_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->description != $ehsevent->description || ! empty($request->description_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Description')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Description';
    $history->previous = $lastDocument->description;
    $history->current = $ehsevent->description;
    $history->comment = $request->description_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->immediate_actions != $ehsevent->immediate_actions || ! empty($request->immediate_actions_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Immediate Actions')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Immediate Actions';
    $history->previous = $lastDocument->immediate_actions;
    $history->current = $ehsevent->immediate_actions;
    $history->comment = $request->immediate_actions_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}

// -------------ccform2-------------------------
if ($lastDocument->accident_type != $ehsevent->accident_type || ! empty($request->accident_type_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Accident Type')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Accident Type';
    $history->previous = $lastDocument->accident_type;
    $history->current = $ehsevent->accident_type;
    $history->comment = $request->accident_type_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->osha_reportable != $ehsevent->osha_reportable || ! empty($request->osha_reportable_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'OSHA Reportable?')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'OSHA Reportable?';
    $history->previous = $lastDocument->osha_reportable;
    $history->current = $ehsevent->osha_reportable;
    $history->comment = $request->osha_reportable_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->first_lost_work_date != $ehsevent->first_lost_work_date || ! empty($request->first_lost_work_date_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'First Lost Work Date')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'First Lost Work Date';
    $history->previous = $lastDocument->first_lost_work_date;
    $history->current = $ehsevent->first_lost_work_date;
    $history->comment = $request->first_lost_work_date_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->last_lost_work_date != $ehsevent->last_lost_work_date || ! empty($request->last_lost_work_date_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Last Lost Work Date')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Last Lost Work Date';
    $history->previous = $lastDocument->last_lost_work_date;
    $history->current = $ehsevent->last_lost_work_date;
    $history->comment = $request->last_lost_work_date_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->first_restricted_work_date != $ehsevent->first_restricted_work_date || ! empty($request->first_restricted_work_date_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'First Restricted Work Date')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'First Restricted Work Date';
    $history->previous = $lastDocument->first_restricted_work_date;
    $history->current = $ehsevent->first_restricted_work_date;
    $history->comment = $request->first_restricted_work_date_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->last_restricted_work_date != $ehsevent->last_restricted_work_date || ! empty($request->last_restricted_work_date_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Last Restricted Work Date')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Last Restricted Work Date';
    $history->previous = $lastDocument->last_restricted_work_date;
    $history->current = $ehsevent->last_restricted_work_date;
    $history->comment = $request->last_restricted_work_date_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}if ($lastDocument->vehicle_type != $ehsevent->vehicle_type || ! empty($request->vehicle_type_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Vehicle Type')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Vehicle Type';
    $history->previous = $lastDocument->vehicle_type;
    $history->current = $ehsevent->vehicle_type;
    $history->comment = $request->vehicle_type_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->vehicle_number != $ehsevent->vehicle_number || ! empty($request->vehicle_number_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Vehicle Number')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Vehicle Number';
    $history->previous = $lastDocument->vehicle_number;
    $history->current = $ehsevent->vehicle_number;
    $history->comment = $request->vehicle_number_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->litigation != $ehsevent->litigation || ! empty($request->litigation_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Litigation')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Litigation';
    $history->previous = $lastDocument->litigation;
    $history->current = $ehsevent->litigation;
    $history->comment = $request->litigation_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->department != $ehsevent->department || ! empty($request->department_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Department(s)')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Department(s)';
    $history->previous = $lastDocument->department;
    $history->current = $ehsevent->department;
    $history->comment = $request->department_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->employee_involved != $ehsevent->employee_involved || ! empty($request->employee_involved_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Employee(s) Involved')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Employee(s) Involved';
    $history->previous = $lastDocument->employee_involved;
    $history->current = $ehsevent->employee_involved;
    $history->comment = $request->employee_involved_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->involved_contractor != $ehsevent->involved_contractor || ! empty($request->involved_contractor_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Involved(s) Contractor(s)')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Involved(s) Contractor(s)';
    $history->previous = $lastDocument->involved_contractor;
    $history->current = $ehsevent->involved_contractor;
    $history->comment = $request->involved_contractor_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->attorneys_involved != $ehsevent->attorneys_involved || ! empty($request->attorneys_involved_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Attorneys (s) Involved(s)')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Attorneys (s) Involved(s)';
    $history->previous = $lastDocument->attorneys_involved;
    $history->current = $ehsevent->attorneys_involved;
    $history->comment = $request->attorneys_involved_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->lead_investigator != $ehsevent->lead_investigator || ! empty($request->lead_investigator_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Lead Investigator')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Lead Investigator';
    $history->previous = $lastDocument->lead_investigator;
    $history->current = $ehsevent->lead_investigator;
    $history->comment = $request->lead_investigator_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->line_operator != $ehsevent->line_operator || ! empty($request->line_operator_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Line Operator')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Line Operator';
    $history->previous = $lastDocument->line_operator;
    $history->current = $ehsevent->line_operator;
    $history->comment = $request->line_operator_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}   
if ($lastDocument->detail_info_reporter != $ehsevent->detail_info_reporter || ! empty($request->detail_info_reporter_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Reporter')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Reporter';
    $history->previous = $lastDocument->detail_info_reporter;
    $history->current = $ehsevent->detail_info_reporter;
    $history->comment = $request->detail_info_reporter_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->supervisor != $ehsevent->supervisor || ! empty($request->supervisor_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Supervisor')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Supervisor';
    $history->previous = $lastDocument->supervisor;
    $history->current = $ehsevent->supervisor;
    $history->comment = $request->supervisor_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->unsafe_situation != $ehsevent->unsafe_situation || ! empty($request->unsafe_situation_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Unsafe Situation')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Unsafe Situation';
    $history->previous = $lastDocument->unsafe_situation;
    $history->current = $ehsevent->unsafe_situation;
    $history->comment = $request->unsafe_situation_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->safeguarding_measure_taken != $ehsevent->safeguarding_measure_taken || ! empty($request->safeguarding_measure_taken_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Safeguarding Measure Taken')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Safeguarding Measure Taken';
    $history->previous = $lastDocument->safeguarding_measure_taken;
    $history->current = $ehsevent->safeguarding_measure_taken;
    $history->comment = $request->safeguarding_measure_taken_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->enviromental_category != $ehsevent->enviromental_category || ! empty($request->enviromental_category_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Enviromental Category')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Enviromental Category';
    $history->previous = $lastDocument->enviromental_category;
    $history->current = $ehsevent->enviromental_category;
    $history->comment = $request->enviromental_category_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->Special_Weather_Conditions != $ehsevent->Special_Weather_Conditions || ! empty($request->Special_Weather_Conditions_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Special Weather Conditions')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Special Weather Conditions';
    $history->previous = $lastDocument->Special_Weather_Conditions;
    $history->current = $ehsevent->Special_Weather_Conditions;
    $history->comment = $request->Special_Weather_Conditions_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->source_Of_release_or_spill != $ehsevent->source_Of_release_or_spill || ! empty($request->source_Of_release_or_spill_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Source Of Release or Spill')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Source Of Release or Spill';
    $history->previous = $lastDocument->source_Of_release_or_spill;
    $history->current = $ehsevent->source_Of_release_or_spill;
    $history->comment = $request->source_Of_release_or_spill_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}
if ($lastDocument->environment_evacuation_ordered != $ehsevent->environment_evacuation_ordered || ! empty($request->environment_evacuation_ordered_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Environment Evacuation Ordered')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Environment Evacuation Ordered';
    $history->previous = $lastDocument->environment_evacuation_ordered;
    $history->current = $ehsevent->environment_evacuation_ordered;
    $history->comment = $request->environment_evacuation_ordered_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
} 
if ($lastDocument->date_simples_taken != $ehsevent->date_simples_taken || ! empty($request->date_simples_taken_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Date Simples Taken')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Date Simples Taken';
    $history->previous = $lastDocument->date_simples_taken;
    $history->current = $ehsevent->date_simples_taken;
    $history->comment = $request->date_simples_taken_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->agency_notified != $ehsevent->agency_notified || ! empty($request->agency_notified_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Agency(s) Notified')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Agency(s) Notified';
    $history->previous = $lastDocument->agency_notified;
    $history->current = $ehsevent->agency_notified;
    $history->comment = $request->agency_notified_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->fire_category != $ehsevent->fire_category || ! empty($request->fire_category_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Fire Category')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Fire Category';
    $history->previous = $lastDocument->fire_category;
    $history->current = $ehsevent->fire_category;
    $history->comment = $request->fire_category_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->fire_evacuation_ordered != $ehsevent->fire_evacuation_ordered || ! empty($request->fire_evacuation_ordered_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Fire Evacuation Ordered?')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Fire Evacuation Ordered?';
    $history->previous = $lastDocument->fire_evacuation_ordered;
    $history->current = $ehsevent->fire_evacuation_ordered;
    $history->comment = $request->fire_evacuation_ordered_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->combat_by != $ehsevent->combat_by || ! empty($request->combat_by_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Combat By')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Combat By';
    $history->previous = $lastDocument->combat_by;
    $history->current = $ehsevent->combat_by;
    $history->comment = $request->combat_by_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->fire_fighting_equipment_used != $ehsevent->fire_fighting_equipment_used || ! empty($request->fire_fighting_equipment_used_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Fire Fighting Equipment Used')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Fire Fighting Equipment Used';
    $history->previous = $lastDocument->fire_fighting_equipment_used;
    $history->current = $ehsevent->fire_fighting_equipment_used;
    $history->comment = $request->fire_fighting_equipment_used_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->zone != $ehsevent->zone || ! empty($request->zone_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Zone')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Zone';
    $history->previous = $lastDocument->zone;
    $history->current = $ehsevent->zone;
    $history->comment = $request->zone_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->country != $ehsevent->country || ! empty($request->country_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Country')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Country';
    $history->previous = $lastDocument->country;
    $history->current = $ehsevent->country;
    $history->comment = $request->country_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->city != $ehsevent->city || ! empty($request->city_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'City')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'City';
    $history->previous = $lastDocument->city;
    $history->current = $ehsevent->city;
    $history->comment = $request->city_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->state != $ehsevent->state || ! empty($request->state_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'State/District')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'State/District';
    $history->previous = $lastDocument->state;
    $history->current = $ehsevent->state;
    $history->comment = $request->state_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->site_name != $ehsevent->site_name || ! empty($request->site_name_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Site Name')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Site Name';
    $history->previous = $lastDocument->site_name;
    $history->current = $ehsevent->site_name;
    $history->comment = $request->site_name_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->building != $ehsevent->building || ! empty($request->building_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'BuildingFloor')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'BuildingFloor';
    $history->previous = $lastDocument->building;
    $history->current = $ehsevent->building;
    $history->comment = $request->building_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->floor != $ehsevent->floor || ! empty($request->floor_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Floor')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Floor';
    $history->previous = $lastDocument->floor;
    $history->current = $ehsevent->floor;
    $history->comment = $request->floor_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->room != $ehsevent->room || ! empty($request->room_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Room')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Room';
    $history->previous = $lastDocument->room;
    $history->current = $ehsevent->room;
    $history->comment = $request->room_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->location != $ehsevent->location || ! empty($request->location_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Location')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Location';
    $history->previous = $lastDocument->location;
    $history->current = $ehsevent->location;
    $history->comment = $request->location_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
//----------------ccform3-----------------------------------
if ($lastDocument->victim != $ehsevent->victim || ! empty($request->victim_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Victim')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Victim';
    $history->previous = $lastDocument->victim;
    $history->current = $ehsevent->victim;
    $history->comment = $request->victim_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->medical_treatment != $ehsevent->medical_treatment || ! empty($request->medical_treatment_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Medical Treatment?(Y/N)')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Medical Treatment?(Y/N)';
    $history->previous = $lastDocument->medical_treatment;
    $history->current = $ehsevent->medical_treatment;
    $history->comment = $request->medical_treatment_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->victim_position != $ehsevent->victim_position || ! empty($request->victim_position_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Victim Position')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Victim Position';
    $history->previous = $lastDocument->victim_position;
    $history->current = $ehsevent->victim_position;
    $history->comment = $request->victim_position_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->victim_realation != $ehsevent->victim_realation || ! empty($request->victim_realation_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Victim Realation To Company')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Victim Realation To Company';
    $history->previous = $lastDocument->victim_realation;
    $history->current = $ehsevent->victim_realation;
    $history->comment = $request->victim_realation_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->hospitalization != $ehsevent->hospitalization || ! empty($request->hospitalization_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Hospitalization')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Hospitalization';
    $history->previous = $lastDocument->hospitalization;
    $history->current = $ehsevent->hospitalization;
    $history->comment = $request->hospitalization_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->hospital_name != $ehsevent->hospital_name || ! empty($request->hospital_name_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', '
Hospital Name')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Hospital Name';
    $history->previous = $lastDocument->hospital_name;
    $history->current = $ehsevent->hospital_name;
    $history->comment = $request->hospital_name_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->date_of_treatment != $ehsevent->date_of_treatment || ! empty($request->date_of_treatment_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Date of Treatment')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Date of Treatment';
    $history->previous = $lastDocument->date_of_treatment;
    $history->current = $ehsevent->date_of_treatment;
    $history->comment = $request->date_of_treatment_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->victim_treated_by != $ehsevent->victim_treated_by || ! empty($request->victim_treated_by_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Victim Treated By')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Victim Treated By';
    $history->previous = $lastDocument->victim_treated_by;
    $history->current = $ehsevent->victim_treated_by;
    $history->comment = $request->victim_treated_by_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->medical_treatment_discription != $ehsevent->medical_treatment_discription || ! empty($request->medical_treatment_discription_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Medical Treatment Discription')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Medical Treatment Discription';
    $history->previous = $lastDocument->medical_treatment_discription;
    $history->current = $ehsevent->medical_treatment_discription;
    $history->comment = $request->medical_treatment_discription_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->injury_type != $ehsevent->injury_type || ! empty($request->injury_type_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Injury Type')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Injury Type';
    $history->previous = $lastDocument->injury_type;
    $history->current = $ehsevent->injury_type;
    $history->comment = $request->injury_type_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->number_of_injuries != $ehsevent->number_of_injuries || ! empty($request->number_of_injuries_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Number of Injuries')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Number of Injuries';
    $history->previous = $lastDocument->number_of_injuries;
    $history->current = $ehsevent->number_of_injuries;
    $history->comment = $request->number_of_injuries_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->type_of_illness != $ehsevent->type_of_illness || ! empty($request->type_of_illness_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Type of Illness')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Type of Illness';
    $history->previous = $lastDocument->type_of_illness;
    $history->current = $ehsevent->type_of_illness;
    $history->comment = $request->type_of_illness_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->permanent_disability != $ehsevent->permanent_disability || ! empty($request->permanent_disability_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Permanent Disability?')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Permanent Disability?';
    $history->previous = $lastDocument->permanent_disability;
    $history->current = $ehsevent->permanent_disability;
    $history->comment = $request->permanent_disability_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->damage_category != $ehsevent->damage_category || ! empty($request->damage_category_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Damage Category')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Damage Category';
    $history->previous = $lastDocument->damage_category;
    $history->current = $ehsevent->damage_category;
    $history->comment = $request->damage_category_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->related_equipment != $ehsevent->related_equipment || ! empty($request->related_equipment_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Related Equipment')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Related Equipment';
    $history->previous = $lastDocument->related_equipment;
    $history->current = $ehsevent->related_equipment;
    $history->comment = $request->related_equipment_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->estimated_amount != $ehsevent->estimated_amount || ! empty($request->estimated_amount_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Estimated Amount of Damage Equipment')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Estimated Amount of Damage Equipment';
    $history->previous = $lastDocument->estimated_amount;
    $history->current = $ehsevent->estimated_amount;
    $history->comment = $request->estimated_amount_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->insurance_company_involved != $ehsevent->insurance_company_involved || ! empty($request->insurance_company_involved_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Insurance Company Involved?')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Insurance Company Involved?';
    $history->previous = $lastDocument->insurance_company_involved;
    $history->current = $ehsevent->insurance_company_involved;
    $history->comment = $request->insurance_company_involved_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->denied_by_insurance != $ehsevent->denied_by_insurance || ! empty($request->denied_by_insurance_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Denied By Insurance Company?')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Denied By Insurance Company?';
    $history->previous = $lastDocument->denied_by_insurance;
    $history->current = $ehsevent->denied_by_insurance;
    $history->comment = $request->denied_by_insurance_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->damage_details != $ehsevent->damage_details || ! empty($request->damage_details_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Damage Details')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Damage Details';
    $history->previous = $lastDocument->damage_details;
    $history->current = $ehsevent->damage_details;
    $history->comment = $request->damage_details_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
//------------------ ccform4 -----------------------------
if ($lastDocument->actual_amount != $ehsevent->actual_amount || ! empty($request->actual_amount_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Actual Amount of Damage')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Actual Amount of Damage';
    $history->previous = $lastDocument->actual_amount;
    $history->current = $ehsevent->actual_amount;
    $history->comment = $request->actual_amount_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->currency != $ehsevent->currency || ! empty($request->currency_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Currency')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Currency';
    $history->previous = $lastDocument->currency;
    $history->current = $ehsevent->currency;
    $history->comment = $request->currency_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->investigation_summary != $ehsevent->investigation_summary || ! empty($request->investigation_summary_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Investigation summary')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Investigation summary';
    $history->previous = $lastDocument->investigation_summary;
    $history->current = $ehsevent->investigation_summary;
    $history->comment = $request->investigation_summary_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->conclusion != $ehsevent->conclusion || ! empty($request->conclusion_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Conclusion')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Conclusion';
    $history->previous = $lastDocument->conclusion;
    $history->current = $ehsevent->conclusion;
    $history->comment = $request->conclusion_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}   
//---------------- ccform5 ------------------------ 
if ($lastDocument->safety_impact_probability != $ehsevent->safety_impact_probability || ! empty($request->safety_impact_probability_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Safety Impact Probability')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Safety Impact Probability';
    $history->previous = $lastDocument->safety_impact_probability;
    $history->current = $ehsevent->safety_impact_probability;
    $history->comment = $request->safety_impact_probability_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->safety_impact_severity != $ehsevent->safety_impact_severity || ! empty($request->safety_impact_severity_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Safety Impact Severity')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Safety Impact Severity';
    $history->previous = $lastDocument->safety_impact_severity;
    $history->current = $ehsevent->safety_impact_severity;
    $history->comment = $request->safety_impact_severity_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->legal_impact_probability != $ehsevent->legal_impact_probability || ! empty($request->legal_impact_probability_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Legal Impact Probability')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Legal Impact Probability';
    $history->previous = $lastDocument->legal_impact_probability;
    $history->current = $ehsevent->legal_impact_probability;
    $history->comment = $request->legal_impact_probability_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->legal_impact_severity != $ehsevent->legal_impact_severity || ! empty($request->legal_impact_severity_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Legal Impact Severity
')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Legal Impact Severity
';
    $history->previous = $lastDocument->legal_impact_severity;
    $history->current = $ehsevent->legal_impact_severity;
    $history->comment = $request->legal_impact_severity_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->business_impact_probability != $ehsevent->business_impact_probability || ! empty($request->business_impact_probability_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Business Impact Probability')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Business Impact Probability';
    $history->previous = $lastDocument->business_impact_probability;
    $history->current = $ehsevent->business_impact_probability;
    $history->comment = $request->business_impact_probability_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->business_impact_severity != $ehsevent->business_impact_severity || ! empty($request->business_impact_severity_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Business Impact Severity')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Business Impact Severity';
    $history->previous = $lastDocument->business_impact_severity;
    $history->current = $ehsevent->business_impact_severity;
    $history->comment = $request->business_impact_severity_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->revenue_impact_probability != $ehsevent->revenue_impact_probability || ! empty($request->revenue_impact_probability_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Revenue Impact Probability')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Revenue Impact Probability';
    $history->previous = $lastDocument->revenue_impact_probability;
    $history->current = $ehsevent->revenue_impact_probability;
    $history->comment = $request->revenue_impact_probability_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->revenue_impact_severity != $ehsevent->revenue_impact_severity || ! empty($request->revenue_impact_severity_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Revenue Impact Severity')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Revenue Impact Severity';
    $history->previous = $lastDocument->revenue_impact_severity;
    $history->current = $ehsevent->revenue_impact_severity;
    $history->comment = $request->revenue_impact_severity_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->brand_impact_probability != $ehsevent->brand_impact_probability || ! empty($request->brand_impact_probability_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Brand Impact Probability')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Brand Impact Probability';
    $history->previous = $lastDocument->brand_impact_probability;
    $history->current = $ehsevent->brand_impact_probability;
    $history->comment = $request->brand_impact_probability_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->brand_impact_severity != $ehsevent->brand_impact_severity || ! empty($request->brand_impact_severity_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Brand Impact Severity')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Brand Impact Severity';
    $history->previous = $lastDocument->brand_impact_severity;
    $history->current = $ehsevent->brand_impact_severity;
    $history->comment = $request->brand_impact_severity_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->safety_impact_risk != $ehsevent->safety_impact_risk || ! empty($request->safety_impact_risk_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Safety Impact Risk')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Safety Impact Risk';
    $history->previous = $lastDocument->safety_impact_risk;
    $history->current = $ehsevent->safety_impact_risk;
    $history->comment = $request->safety_impact_risk_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->legal_impact_risk != $ehsevent->legal_impact_risk || ! empty($request->legal_impact_risk_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Legal Impact Risk')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Legal Impact Risk';
    $history->previous = $lastDocument->legal_impact_risk;
    $history->current = $ehsevent->legal_impact_risk;
    $history->comment = $request->legal_impact_risk_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->business_impact_risk != $ehsevent->business_impact_risk || ! empty($request->business_impact_risk_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Business Impact Risk')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Business Impact Risk';
    $history->previous = $lastDocument->business_impact_risk;
    $history->current = $ehsevent->business_impact_risk;
    $history->comment = $request->business_impact_risk_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->revenue_impact_risk != $ehsevent->revenue_impact_risk || ! empty($request->revenue_impact_risk_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Revenue Impact Risk')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Revenue Impact Risk';
    $history->previous = $lastDocument->revenue_impact_risk;
    $history->current = $ehsevent->revenue_impact_risk;
    $history->comment = $request->revenue_impact_risk_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->brand_impact_risk != $ehsevent->brand_impact_risk || ! empty($request->brand_impact_risk_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Brand Impact Risk')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Brand Impact Risk';
    $history->previous = $lastDocument->brand_impact_risk;
    $history->current = $ehsevent->brand_impact_risk;
    $history->comment = $request->brand_impact_risk_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->impact != $ehsevent->impact || ! empty($request->impact_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Impact')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Impact';
    $history->previous = $lastDocument->impact;
    $history->current = $ehsevent->impact;
    $history->comment = $request->impact_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->impact_analysis != $ehsevent->impact_analysis || ! empty($request->impact_analysis_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Impact Analysis')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Impact Analysis';
    $history->previous = $lastDocument->impact_analysis;
    $history->current = $ehsevent->impact_analysis;
    $history->comment = $request->impact_analysis_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->recommended_action != $ehsevent->recommended_action || ! empty($request->recommended_action_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Recommended Action')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Recommended Action';
    $history->previous = $lastDocument->recommended_action;
    $history->current = $ehsevent->recommended_action;
    $history->comment = $request->recommended_action_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->comments != $ehsevent->comments || ! empty($request->comments_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', '
Comments')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Comments';
    $history->previous = $lastDocument->comments;
    $history->current = $ehsevent->comments;
    $history->comment = $request->comments_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->direct_cause != $ehsevent->direct_cause || ! empty($request->direct_cause_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Direct Cause')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Direct Cause';
    $history->previous = $lastDocument->direct_cause;
    $history->current = $ehsevent->direct_cause;
    $history->comment = $request->direct_cause_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->root_cause_safeguarding_measure_taken != $ehsevent->root_cause_safeguarding_measure_taken || ! empty($request->root_cause_safeguarding_measure_taken_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Safeguarding Measure Taken')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Safeguarding Measure Taken';
    $history->previous = $lastDocument->root_cause_safeguarding_measure_taken;
    $history->current = $ehsevent->root_cause_safeguarding_measure_taken;
    $history->comment = $request->root_cause_safeguarding_measure_taken_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->root_cause_methodlogy != $ehsevent->root_cause_methodlogy || ! empty($request->root_cause_methodlogy_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Root cause Methodlogy')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Root cause Methodlogy';
    $history->previous = $lastDocument->root_cause_methodlogy;
    $history->current = $ehsevent->root_cause_methodlogy;
    $history->comment = $request->root_cause_methodlogy_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->root_cause_description != $ehsevent->root_cause_description || ! empty($request->root_cause_description_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Root cause Description')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Root cause Description';
    $history->previous = $lastDocument->root_cause_description;
    $history->current = $ehsevent->root_cause_description;
    $history->comment = $request->root_cause_description_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->severity_rate != $ehsevent->severity_rate || ! empty($request->severity_rate_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Severity Rate')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Severity Rate';
    $history->previous = $lastDocument->severity_rate;
    $history->current = $ehsevent->severity_rate;
    $history->comment = $request->severity_rate_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->occurrence != $ehsevent->occurrence || ! empty($request->occurrence_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Occurrence')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Occurrence';
    $history->previous = $lastDocument->occurrence;
    $history->current = $ehsevent->occurrence;
    $history->comment = $request->occurrence_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->detection != $ehsevent->detection || ! empty($request->detection_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Detection')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Detection';
    $history->previous = $lastDocument->detection;
    $history->current = $ehsevent->detection;
    $history->comment = $request->detection_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->rpn != $ehsevent->rpn || ! empty($request->rpn_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'RPN')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'RPN';
    $history->previous = $lastDocument->rpn;
    $history->current = $ehsevent->rpn;
    $history->comment = $request->rpn_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->risk_analysis != $ehsevent->risk_analysis || ! empty($request->risk_analysis_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Risk Analysis')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Risk Analysis';
    $history->previous = $lastDocument->risk_analysis;
    $history->current = $ehsevent->risk_analysis;
    $history->comment = $request->risk_analysis_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->criticality != $ehsevent->criticality || ! empty($request->criticality_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Criticality')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Criticality';
    $history->previous = $lastDocument->criticality;
    $history->current = $ehsevent->criticality;
    $history->comment = $request->criticality_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->inform_local_authority != $ehsevent->inform_local_authority || ! empty($request->inform_local_authority_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Inform Local Authority?')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Inform Local Authority?';
    $history->previous = $lastDocument->inform_local_authority;
    $history->current = $ehsevent->inform_local_authority;
    $history->comment = $request->inform_local_authority_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->authority_type != $ehsevent->authority_type || ! empty($request->authority_type_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Authority Type')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Authority Type';
    $history->previous = $lastDocument->authority_type;
    $history->current = $ehsevent->authority_type;
    $history->comment = $request->authority_type_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->authority_notified != $ehsevent->authority_notified || ! empty($request->authority_notified_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Authority(s) Notified')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Authority(s) Notified';
    $history->previous = $lastDocument->authority_notified;
    $history->current = $ehsevent->authority_notified;
    $history->comment = $request->authority_notified_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    
if ($lastDocument->other_authority != $ehsevent->other_authority || ! empty($request->other_authority_comment)) {
    $lastDocumentAuditTrail = EhsEventAuditTrail::where('ehse_id', $ehsevent->id)
        ->where('activity_type', 'Other Authority')
        ->exists();
    $history = new EhsEventAuditTrail();
    $history->ehse_id = $id;
    $history->activity_type = 'Other Authority';
    $history->previous = $lastDocument->other_authority;
    $history->current = $ehsevent->other_authority;
    $history->comment = $request->other_authority_comment;
    $history->user_id = Auth::user()->id;
    $history->user_name = Auth::user()->name;
    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    $history->origin_state = $lastDocument->status;
    $history->change_to = 'Not Applicable';
    $history->change_from = $lastDocument->status;

    $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

    $history->save();
}    

     

//------------------- audit trail update End--------------------------------------------------------
        
        
  //------------------------------grid Start-----------------------------------------------------
  $ehsevent_id1= $ehsevent->id;
  $newDataMeetingManagement = EhsEventGrid::where(['ci_id' => $ehsevent_id1, 'identifier' => 'Witness_details' ])->firstOrNew();
  $newDataMeetingManagement->ci_id = $ehsevent_id1;
  $newDataMeetingManagement->identifier = 'Witness_details';
  $newDataMeetingManagement->data = $request->Witness_details_details;
  $newDataMeetingManagement->update();

  $ehsevent_id2= $ehsevent->id;
  $newDataMeetingManagement = EhsEventGrid::where(['ci_id' => $ehsevent_id2, 'identifier' => 'materials_released' ])->firstOrCreate();
  $newDataMeetingManagement->ci_id = $ehsevent_id2;
  $newDataMeetingManagement->identifier = 'materials_released';
  $newDataMeetingManagement->data = $request->materials_released;
  $newDataMeetingManagement->update();
  
  $ehsevent_id3= $ehsevent->id;
  $newDataMeetingManagement = EhsEventGrid::where(['ci_id' => $ehsevent_id3, 'identifier' => 'root_cause' ])->firstOrCreate();
  $newDataMeetingManagement->ci_id = $ehsevent_id3;
  $newDataMeetingManagement->identifier = 'root_cause';
  $newDataMeetingManagement->data = $request->root_cause;
  $newDataMeetingManagement->update();
  
  //------------------------------grid End-----------------------------------------------------------

        return back();
    }




    //------------------Audit function------------------------------------------------------
    public function ehsEventAuditTrail($id)
    {
        $audit = EhsEventAuditTrail::where('ehse_id', $id)->orderByDESC('id')->get()->unique('activity_type');
        $today = Carbon::now()->format('d-m-y');
        $document = EhsEvent::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');

        return view("frontend.ehs.ehs-event.ehs_event_audit", compact('audit', 'document', 'today'));
    }



    //--------------------- stage change--------------------------------------------
    public function EhsEventStateChange(Request $request, $id)
    {
            $changeControl = EhsEvent::find($id);
            $lastDocument =  EhsEvent::find($id);

            if ($changeControl->stage == 1) {
                $changeControl->stage = "2";
                $changeControl->status = "Pending Review";
                $changeControl->submitted_by = Auth::user()->name;
                $changeControl->submitted_on = Carbon::now()->format('d-M-Y');
                $changeControl->submitted_comment = $request->comment;

                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changeControl->stage == 2) {
                $changeControl->stage = "3";
                $changeControl->status = "Pending Investigation";
                $changeControl->review_complete_by = Auth::user()->name;
                $changeControl->review_complete_on = Carbon::now()->format('d-M-Y');
                $changeControl->review_complete_comment = $request->comment;

                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }
           if ($changeControl->stage == 3) {
            $changeControl->stage = "4";
            $changeControl->status = "Root Cause and Risk Analysis";
            $changeControl->complete_investigation_by = Auth::user()->name;
            $changeControl->complete_investigation_on = Carbon::now()->format('d-M-Y');
            $changeControl->complete_investigation_comment = $request->comment;


            $changeControl->update();
            toastr()->success('Document Sent');
            return back();
        }
      if ($changeControl->stage == 4) {
        $changeControl->stage = "5";
        $changeControl->analysis_complete_by = Auth::user()->name;
        $changeControl->analysis_complete_on = Carbon::now()->format('d-M-Y');
        $changeControl->analysis_complete_comment = $request->comment;

        $changeControl->status = "Pending Action Planning";

        $changeControl->update();
        toastr()->success('Document Sent');
        return back();
     }
if ($changeControl->stage == 5) {
    $changeControl->stage = "6";
    $changeControl->propose_plan_by = Auth::user()->name;
    $changeControl->propose_plan_on = Carbon::now()->format('d-M-Y');
    $changeControl->propose_plan_comment = $request->comment;

    $changeControl->status = "Pending Approval";

    $changeControl->update();
    toastr()->success('Document Sent');
    return back();
}
if ($changeControl->stage == 6) {
    $changeControl->stage = "7";
    $changeControl->approve_plan_by = Auth::user()->name;
    $changeControl->approve_plan_on = Carbon::now()->format('d-M-Y');
    $changeControl->approve_plan_comment = $request->comment;

    $changeControl->status = "CAPA Execution in Progress";

    $changeControl->update();
    toastr()->success('Document Sent');
    return back();
}
if ($changeControl->stage == 7) {
    $changeControl->stage = "8";
    $changeControl->all_capa_closed_by = Auth::user()->name;
    $changeControl->all_capa_closed_on = Carbon::now()->format('d-M-Y');
    $changeControl->all_capa_closed_comment = $request->comment;

    $changeControl->status = "CAPA Execution in Progress";

    $changeControl->update();
    toastr()->success('Document Sent');
    return back();
}

else {
toastr()->error('E-signature Not match');
return back();
}
}

// ------------------------------------------back button in workflow  -------------------------------

public function MoreInfoChange(Request $request, $id)
{
    // if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password))
    //  {
        $changeControl = EhsEvent::find($id);
        $lastDocument =  EhsEvent::find($id);
        // $changeControl = EhsEvent::find($id);

        if ($changeControl->stage == 2) {
            $changeControl->stage = "1";
            $changeControl->status = "Opened";
                $changeControl->more_info_required_by = Auth::user()->name;
                $changeControl->more_info_required_on = Carbon::now()->format('d-M-Y');
                $changeControl->more_info_required_comment = $request->comment;

            $changeControl->update();
            toastr()->success('Document Sent');
            return back();
        }

        if ($changeControl->stage == 4) {
            $changeControl->stage = "3";
            $changeControl->status = "Pending Investigation";
            $changeControl->more_investig_required_by = Auth::user()->name;
            $changeControl->more_investig_required_on = Carbon::now()->format('d-M-Y');
            $changeControl->more_investig_required_comment = $request->comment;
            $changeControl->update();
            toastr()->success('Document Sent');
            return back();
        }
        if ($changeControl->stage == 6) {
            $changeControl->stage = "5";
            $changeControl->status = "Pending Action Planning";
            $changeControl->reject_by = Auth::user()->name;
            $changeControl->reject_on = Carbon::now()->format('d-M-Y');
            $changeControl->reject_comment = $request->comment;
            $changeControl->update();
            toastr()->success('Document Sent');
            return back();
        }
     else {
        toastr()->error('E-signature Not match');
        return back();
    }
}

    public function RejectStateChange(Request $request, $id)
    {
      
            $changeControl = EhsEvent::find($id);
            $lastDocument =  EhsEvent::find($id);

            if ($changeControl->stage == 1) {
                $changeControl->stage = "0";
                $changeControl->status = "Closed-Cancelled";
                $changeControl->cancel_by = Auth::user()->name;
                $changeControl->cancel_on = Carbon::now()->format('d-M-Y');
                $changeControl->cancel_comment = $request->comment;
                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changeControl->stage == 2) {
                $changeControl->stage = "0";
                $changeControl->status = "Closed-Cancelled";
                $changeControl->cancel_by = Auth::user()->name;
                $changeControl->cancel_on = Carbon::now()->format('d-M-Y');
                $changeControl->cancel_comment = $request->comment;
                $changeControl->update();
                toastr()->success('Document Sent');
                return back();
            }
           
        else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function Child(Request $request, $id)
    {
        $cft = [];
        $parent_id = $id;
        $parent_type = "Investigation";
        $old_record = Capa::select('id', 'division_id', 'record')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('d-M-Y');
        $changeControl = OpenStage::find(1);
        if(!empty($changecontrol->cft)) $cft = explode(',',$changeControl->cft);
        
        if($request->revision == 'investigation'){
            return view('frontend.ehs.investigation',compact('cft','record_number','parent_type','due_date'));
        }
        if($request->revision == 'CAPA')
        {
            return view('frontend.forms.capa',compact('cft','record_number','parent_type','due_date','old_record'));

        }
        if($request->revision=='Sanction')
        {
            return view('frontend.ehs.sanction',compact('cft','record_number','parent_type','due_date'));

        }

    }






    public function singleReport($id)
    {
        $data = EhsEvent::find($id);
        
        $grid1 = EhsEventGrid::where(['ci_id' => $id, 'identifier' => 'Witness_details'])->first();
        $grid2= EhsEventGrid:: where(['ci_id'=> $id, 'identifier' =>'materials_released'])->first();
        $grid3= EhsEventGrid:: where(['ci_id'=> $id, 'identifier' =>'root_cause'])->first();
        $grid_data1 = $grid1 ? $grid1->data : null;
        $grid_data2 = $grid2 ? $grid2->data : null;
        $grid_data3 = $grid3 ? $grid3->data : null;
        if (!empty($data)) {
            $data->originator_id = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf =  PDF::loadview('frontend.ehs.ehs-event.single-report', compact('data', 'grid_data1', 'grid_data2', 'grid_data3'))
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
            return $pdf->stream('EHS-Event-Single-Report' . $id . '.pdf');
        }
    }

    public function auditReport($id)
    {
        $doc = EhsEvent::find($id);
        if (!empty($doc)) {
            $doc->originator_id = User::where('id', $doc->initiator_id)->value('name');
            $data = EhsEventAuditTrail::where('ehse_id', $id)->get();
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.ehs.ehs-event.AuditReport', compact('data', 'doc'))
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
            return $pdf->stream('Ehs-Event-Audit-Report' . $id . '.pdf');
        }
    }
}

