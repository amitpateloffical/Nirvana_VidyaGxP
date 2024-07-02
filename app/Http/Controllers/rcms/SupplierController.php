<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Helpers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use PDF;

use App\Models\{RecordNumber,
Supplier,
SupplierGrid,
User,
SupplierAuditTrail,
RoleGroup
};

class SupplierController extends Controller
{
    public function index(Request $request){        
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_numbers = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('d-M-Y');

        return view('frontend.supplier.supplier_new', compact('formattedDate', 'due_date', 'record_numbers'));
    }

    public function store(Request $request){
        $supplier = new Supplier();
        $supplier->type = "Supplier";
        $supplier->division_id = $request->division_id;
        $supplier->record = DB::table('record_numbers')->value('counter') + 1;
        $supplier->parent_id = $request->parent_id;
        $supplier->parent_type = $request->parent_type;
        $supplier->initiator_id = Auth::user()->id;
        $supplier->date_opened = $request->date_opened;
        $supplier->intiation_date = $request->intiation_date;
        $supplier->short_description = $request->short_description;
        $supplier->assign_to = $request->assign_to;
        $supplier->due_date = Carbon::now()->addDays(30)->format('d-M-Y');
        $supplier->supplier_person = $request->supplier_person;        
        $supplier->supplier_contact_person = $request->supplier_contact_person;
        $supplier->supplier_products = $request->supplier_products;
        $supplier->description = $request->description;
        $supplier->supplier_type = $request->supplier_type;
        $supplier->supplier_sub_type = $request->supplier_sub_type;
        $supplier->supplier_other_type = $request->supplier_other_type;
        $supplier->supply_from = $request->supply_from;
        $supplier->supply_to = $request->supply_to;
        $supplier->supplier_website = $request->supplier_website;
        $supplier->supplier_web_search = $request->supplier_web_search;
        $supplier->related_url = $request->related_url;
        $supplier->related_quality_events = $request->related_quality_events;

        if (!empty($request->logo_attachment)) {
            $files = [];
            if ($request->hasfile('logo_attachment')) {
                foreach ($request->file('logo_attachment') as $file) {
                    $name = "CC" . '-logo_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $supplier->logo_attachment = json_encode($files);
        }

        if (!empty($request->supplier_attachment)) {
            $files = [];
            if ($request->hasfile('supplier_attachment')) {
                foreach ($request->file('supplier_attachment') as $file) {
                    $name = "CC" . '-supplier_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $supplier->supplier_attachment = json_encode($files);
        } 

        /****************** HOD Review ********************/
        $supplier->HOD_feedback = $request->HOD_feedback;
        $supplier->HOD_comment = $request->HOD_comment;

        if (!empty($request->HOD_attachment)) {
            $files = [];
            if ($request->hasfile('HOD_attachment')) {
                foreach ($request->file('HOD_attachment') as $file) {
                    $name = "CC" . '-HOD_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $supplier->HOD_attachment = json_encode($files);
        }

        /****************** Supplier Details ********************/
        $supplier->supplier_name = $request->supplier_name;
        $supplier->supplier_id = $request->supplier_id;        
        $supplier->manufacturer_name = $request->manufacturer_name;
        $supplier->manufacturer_id = $request->manufacturer_id;
        $supplier->vendor_name = $request->vendor_name;
        $supplier->vendor_id = $request->vendor_id;
        $supplier->contact_person = $request->contact_person;
        $supplier->other_contacts = $request->other_contacts;
        $supplier->supplier_serivce = $request->supplier_serivce;
        $supplier->zone = $request->zone;
        $supplier->country = $request->country;
        $supplier->state = $request->state;
        $supplier->city = $request->city;
        $supplier->address = $request->address;
        $supplier->iso_certified_date = $request->iso_certified_date;
        $supplier->suppplier_contacts = $request->suppplier_contacts;
        $supplier->related_non_conformance = $request->related_non_conformance;
        $supplier->suppplier_agreement = $request->suppplier_agreement;
        $supplier->regulatory_history = $request->regulatory_history;
        $supplier->distribution_sites = $request->distribution_sites;
        $supplier->manufacturing_sited = $request->manufacturing_sited;
        $supplier->quality_management = $request->quality_management;
        $supplier->bussiness_history = $request->bussiness_history;
        $supplier->performance_history = $request->performance_history;
        $supplier->compliance_risk = $request->compliance_risk;

        /****************** Score Card Content ********************/
        $supplier->cost_reduction = $request->cost_reduction;
        $supplier->cost_reduction_weight = $request->cost_reduction_weight;        
        $supplier->payment_term = $request->payment_term;
        $supplier->payment_term_weight = $request->payment_term_weight;
        $supplier->lead_time_days = $request->lead_time_days;
        $supplier->lead_time_days_weight = $request->lead_time_days_weight;
        $supplier->ontime_delivery = $request->ontime_delivery;
        $supplier->ontime_delivery_weight = $request->ontime_delivery_weight;
        $supplier->supplier_bussiness_planning = $request->supplier_bussiness_planning;
        $supplier->supplier_bussiness_planning_weight = $request->supplier_bussiness_planning_weight;
        $supplier->rejection_ppm = $request->rejection_ppm;
        $supplier->rejection_ppm_weight = $request->rejection_ppm_weight;
        $supplier->quality_system = $request->quality_system;
        $supplier->quality_system_ranking = $request->quality_system_ranking;
        $supplier->car_generated = $request->car_generated;
        $supplier->car_generated_weight = $request->car_generated_weight;
        $supplier->closure_time = $request->closure_time;
        $supplier->closure_time_weight = $request->closure_time_weight;
        $supplier->end_user_satisfaction = $request->end_user_satisfaction;
        $supplier->end_user_satisfaction_weight = $request->end_user_satisfaction_weight;
        $supplier->scorecard_record = $request->scorecard_record;
        $supplier->achieved_score = $request->achieved_score;
        $supplier->total_available_score = $request->total_available_score;
        $supplier->total_score = $request->total_score;

        /****************** QA Reviewer ********************/
        $supplier->QA_reviewer_feedback = $request->QA_reviewer_feedback;
        $supplier->QA_reviewer_comment = $request->QA_reviewer_comment;

        if (!empty($request->QA_reviewer_attachment)) {
            $files = [];
            if ($request->hasfile('QA_reviewer_attachment')) {
                foreach ($request->file('QA_reviewer_attachment') as $file) {
                    $name = "CC" . '-QA_reviewer_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $supplier->QA_reviewer_attachment = json_encode($files);
        }

        /****************** Risk Assessment Content ********************/
        $supplier->last_audit_date = $request->last_audit_date;
        $supplier->next_audit_date = $request->next_audit_date;        
        $supplier->audit_frequency = $request->audit_frequency;
        $supplier->last_audit_result = $request->last_audit_result;
        $supplier->facility_type = $request->facility_type;
        $supplier->nature_of_employee = $request->nature_of_employee;
        $supplier->technical_support = $request->technical_support;
        $supplier->survice_supported = $request->survice_supported;
        $supplier->reliability = $request->reliability;
        $supplier->revenue = $request->revenue;
        $supplier->client_base = $request->client_base;
        $supplier->previous_audit_result = $request->previous_audit_result;
        $supplier->risk_raw_total = $request->risk_raw_total;
        $supplier->risk_median = $request->risk_median;
        $supplier->risk_average = $request->risk_average;
        $supplier->risk_assessment_total = $request->risk_assessment_total;

        /****************** QA Reviewer ********************/
        $supplier->QA_head_comment = $request->QA_head_comment;

        if (!empty($request->QA_head_attachment)) {
            $files = [];
            if ($request->hasfile('QA_head_attachment')) {
                foreach ($request->file('QA_head_attachment') as $file) {
                    $name = "CC" . '-QA_head_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $supplier->QA_head_attachment = json_encode($files);
        }

        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();

        $supplier->status = 'Opened';
        $supplier->stage = 1;
        $supplier->save();

        $certificationData = SupplierGrid::where(['supplier_id' => $supplier->id, 'identifier' =>'CertificationData'])->firstOrCreate();
        $certificationData->supplier_id = $supplier->id;
        $certificationData->identifier = 'CertificationData';
        $certificationData->data = $request->certificationData;
        $certificationData->save();

        /******************* Audit Trail Code ***********************/
        $history = new SupplierAuditTrail;
        $history->supplier_id = $supplier->id;
        $history->activity_type = 'Inititator';
        $history->previous = "Null";
        $history->current = Auth::user()->name;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $supplier->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiator";
        $history->action_name = 'Create';
        $history->save();

        $history = new SupplierAuditTrail;
        $history->supplier_id = $supplier->id;
        $history->activity_type = 'Due Date';
        $history->previous = "Null";
        $history->current = $supplier->due_date;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $supplier->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiator";
        $history->action_name = 'Create';
        $history->save();

        $history = new SupplierAuditTrail;
        $history->supplier_id = $supplier->id;
        $history->activity_type = 'Initiation Date';
        $history->previous = "Null";
        $history->current = $supplier->intiation_date;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $supplier->status;
        $history->change_to =   "Opened";
        $history->change_from = "Initiator";
        $history->action_name = 'Create';
        $history->save();

        if(!empty($request->assign_to)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Assign To';
            $history->previous = "Null";
            $history->current = $supplier->assign_to;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->supplier_person)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Supplier Person';
            $history->previous = "Null";
            $history->current = $supplier->supplier_person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if(!empty($request->supplier_contact_person)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Supplier Contact Person';
            $history->previous = "Null";
            $history->current = $supplier->supplier_contact_person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }







        if(!empty($request->supplier_products)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Supplier Product';
            $history->previous = "Null";
            $history->current = $supplier->supplier_products;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->supplier_type)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Supplier Type';
            $history->previous = "Null";
            $history->current = $supplier->supplier_type;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->supplier_sub_type)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Supplier Sub Type';
            $history->previous = "Null";
            $history->current = $supplier->supplier_contact_person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->supplier_other_type)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Supplier Other Type';
            $history->previous = "Null";
            $history->current = $supplier->supplier_contact_person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->supply_from)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Supplier From';
            $history->previous = "Null";
            $history->current = $supplier->supply_from;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->supply_to)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Supplier To';
            $history->previous = "Null";
            $history->current = $supplier->supply_to;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->supplier_website)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Supplier website';
            $history->previous = "Null";
            $history->current = $supplier->supplier_website;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->related_url)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Related URL';
            $history->previous = "Null";
            $history->current = $supplier->related_url;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->related_quality_events)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Related Quality Events';
            $history->previous = "Null";
            $history->current = $supplier->related_quality_events;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->HOD_feedback)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'HOD Feedback';
            $history->previous = "Null";
            $history->current = $supplier->HOD_feedback;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->HOD_comment)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'HOD Comment';
            $history->previous = "Null";
            $history->current = $supplier->HOD_comment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->supplier_name)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Supplier Name';
            $history->previous = "Null";
            $history->current = $supplier->supplier_name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->supplier_id)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Supplier ID';
            $history->previous = "Null";
            $history->current = $supplier->supplier_id;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->manufacturer_name)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Manufacturer Name';
            $history->previous = "Null";
            $history->current = $supplier->manufacturer_name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->manufacturer_id)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Manufacturer ID';
            $history->previous = "Null";
            $history->current = $supplier->manufacturer_id;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->vendor_name)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Vendor Name';
            $history->previous = "Null";
            $history->current = $supplier->vendor_name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->vendor_id)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Vendor Id';
            $history->previous = "Null";
            $history->current = $supplier->vendor_id;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->contact_person)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Supplier Contract Person';
            $history->previous = "Null";
            $history->current = $supplier->contact_person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->supplier_serivce)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Supplier Services';
            $history->previous = "Null";
            $history->current = $supplier->supplier_serivce;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->zone)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Zone';
            $history->previous = "Null";
            $history->current = $supplier->zone;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->country)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Country';
            $history->previous = "Null";
            $history->current = $supplier->country;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->state)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'State';
            $history->previous = "Null";
            $history->current = $supplier->state;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->city)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'City';
            $history->previous = "Null";
            $history->current = $supplier->city;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->address)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Address';
            $history->previous = "Null";
            $history->current = $supplier->address;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->iso_certified_date)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'ISO Certified Date';
            $history->previous = "Null";
            $history->current = $supplier->iso_certified_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->related_non_conformance)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Related non-conformance';
            $history->previous = "Null";
            $history->current = $supplier->related_non_conformance;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->suppplier_agreement)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Supplier Agreement';
            $history->previous = "Null";
            $history->current = $supplier->suppplier_agreement;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->regulatory_history)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Regulatory History';
            $history->previous = "Null";
            $history->current = $supplier->regulatory_history;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->distribution_sites)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Distribution Site';
            $history->previous = "Null";
            $history->current = $supplier->distribution_sites;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->manufacturing_sited)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Manufacturing Site';
            $history->previous = "Null";
            $history->current = $supplier->manufacturing_sited;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->quality_management)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Quality  Management';
            $history->previous = "Null";
            $history->current = $supplier->quality_management;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->bussiness_history)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Business History';
            $history->previous = "Null";
            $history->current = $supplier->bussiness_history;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->performance_history)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Performance History';
            $history->previous = "Null";
            $history->current = $supplier->performance_history;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->compliance_risk)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Compliance Risk';
            $history->previous = "Null";
            $history->current = $supplier->compliance_risk;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->cost_reduction)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Cost Reduction';
            $history->previous = "Null";
            $history->current = $supplier->cost_reduction;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->cost_reduction_weight)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Cost Reduction Weight';
            $history->previous = "Null";
            $history->current = $supplier->cost_reduction_weight;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->payment_term)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Payment Term';
            $history->previous = "Null";
            $history->current = $supplier->payment_term;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->payment_term_weight)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Payment Term Weight';
            $history->previous = "Null";
            $history->current = $supplier->payment_term_weight;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->lead_time_days)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Lead Time Days';
            $history->previous = "Null";
            $history->current = $supplier->lead_time_days;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->lead_time_days_weight)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Lead Time Day Weight';
            $history->previous = "Null";
            $history->current = $supplier->lead_time_days_weight;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->ontime_delivery)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'On Time Delivery';
            $history->previous = "Null";
            $history->current = $supplier->ontime_delivery;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->ontime_delivery_weight)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'On Time Delivery Weight';
            $history->previous = "Null";
            $history->current = $supplier->ontime_delivery_weight;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->supplier_bussiness_planning)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Supplier Business Planning';
            $history->previous = "Null";
            $history->current = $supplier->supplier_bussiness_planning;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->supplier_bussiness_planning_weight)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Supplier Business Weight';
            $history->previous = "Null";
            $history->current = $supplier->supplier_bussiness_planning_weight;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->rejection_ppm)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Rejection in PPM';
            $history->previous = "Null";
            $history->current = $supplier->rejection_ppm;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->rejection_ppm_weight)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Rejection in PPM Weight';
            $history->previous = "Null";
            $history->current = $supplier->rejection_ppm_weight;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->quality_system)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Quality Systems';
            $history->previous = "Null";
            $history->current = $supplier->quality_system;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if(!empty($request->quality_system_ranking)){
            $history = new SupplierAuditTrail;
            $history->supplier_id = $supplier->id;
            $history->activity_type = 'Quality Systems Weight';
            $history->previous = "Null";
            $history->current = $supplier->quality_system_ranking;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $supplier->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        toastr()->success("Record is created Successfully");
        return redirect(url('rcms/qms-dashboard'));
    }

    public function show(Request $request, $id){
        $data = Supplier::find($id);
        $gridData = SupplierGrid::where(['supplier_id' => $id, 'identifier' => "CertificationData"])->first();
        $certificationData = json_decode($gridData->data, true);
        return view('frontend.supplier.supplier_view', compact('data', 'certificationData'));
    }

    public function update(Request $request, $id){       
        $lastDocument = Supplier::find($id);
        $supplier = Supplier::find($id);

        $supplier->date_opened = $request->date_opened;
        $supplier->short_description = $request->short_description;
        $supplier->assign_to = $request->assign_to;
        // dd($request->due_date);
        // $supplier->due_date = $request->due_date;
        $supplier->supplier_person = $request->supplier_person;        
        $supplier->supplier_contact_person = $request->supplier_contact_person;
        $supplier->supplier_products = $request->supplier_products;
        $supplier->description = $request->description;
        $supplier->supplier_type = $request->supplier_type;
        $supplier->supplier_sub_type = $request->supplier_sub_type;
        $supplier->supplier_other_type = $request->supplier_other_type;
        $supplier->supply_from = $request->supply_from;
        $supplier->supply_to = $request->supply_to;
        $supplier->supplier_website = $request->supplier_website;
        $supplier->supplier_web_search = $request->supplier_web_search;
        $supplier->related_url = $request->related_url;
        $supplier->related_quality_events = $request->related_quality_events;

        if (!empty($request->logo_attachment)) {
            $files = [];
            if ($request->hasfile('logo_attachment')) {
                foreach ($request->file('logo_attachment') as $file) {
                    $name = "CC" . '-logo_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $supplier->logo_attachment = json_encode($files);
        }

        if (!empty($request->supplier_attachment)) {
            $files = [];
            if ($request->hasfile('supplier_attachment')) {
                foreach ($request->file('supplier_attachment') as $file) {
                    $name = "CC" . '-supplier_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $supplier->supplier_attachment = json_encode($files);
        } 

        /****************** HOD Review ********************/
        $supplier->HOD_feedback = $request->HOD_feedback;
        $supplier->HOD_comment = $request->HOD_comment;

        if (!empty($request->HOD_attachment)) {
            $files = [];
            if ($request->hasfile('HOD_attachment')) {
                foreach ($request->file('HOD_attachment') as $file) {
                    $name = "CC" . '-HOD_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $supplier->HOD_attachment = json_encode($files);
        }

        /****************** Supplier Details ********************/
        $supplier->supplier_name = $request->supplier_name;
        $supplier->supplier_id = $request->supplier_id;        
        $supplier->manufacturer_name = $request->manufacturer_name;
        $supplier->manufacturer_id = $request->manufacturer_id;
        $supplier->vendor_name = $request->vendor_name;
        $supplier->vendor_id = $request->vendor_id;
        $supplier->contact_person = $request->contact_person;
        $supplier->other_contacts = $request->other_contacts;
        $supplier->supplier_serivce = $request->supplier_serivce;
        $supplier->zone = $request->zone;
        $supplier->country = $request->country;
        $supplier->state = $request->state;
        $supplier->city = $request->city;
        $supplier->address = $request->address;
        $supplier->iso_certified_date = $request->iso_certified_date;
        $supplier->suppplier_contacts = $request->suppplier_contacts;
        $supplier->related_non_conformance = $request->related_non_conformance;
        $supplier->suppplier_agreement = $request->suppplier_agreement;
        $supplier->regulatory_history = $request->regulatory_history;
        $supplier->distribution_sites = $request->distribution_sites;
        $supplier->manufacturing_sited = $request->manufacturing_sited;
        $supplier->quality_management = $request->quality_management;
        $supplier->bussiness_history = $request->bussiness_history;
        $supplier->performance_history = $request->performance_history;
        $supplier->compliance_risk = $request->compliance_risk;

        /****************** Score Card Content ********************/
        $supplier->cost_reduction = $request->cost_reduction;
        $supplier->cost_reduction_weight = $request->cost_reduction_weight;        
        $supplier->payment_term = $request->payment_term;
        $supplier->payment_term_weight = $request->payment_term_weight;
        $supplier->lead_time_days = $request->lead_time_days;
        $supplier->lead_time_days_weight = $request->lead_time_days_weight;
        $supplier->ontime_delivery = $request->ontime_delivery;
        $supplier->ontime_delivery_weight = $request->ontime_delivery_weight;
        $supplier->supplier_bussiness_planning = $request->supplier_bussiness_planning;
        $supplier->supplier_bussiness_planning_weight = $request->supplier_bussiness_planning_weight;
        $supplier->rejection_ppm = $request->rejection_ppm;
        $supplier->rejection_ppm_weight = $request->rejection_ppm_weight;
        $supplier->quality_system = $request->quality_system;
        $supplier->quality_system_ranking = $request->quality_system_ranking;
        $supplier->car_generated = $request->car_generated;
        $supplier->car_generated_weight = $request->car_generated_weight;
        $supplier->closure_time = $request->closure_time;
        $supplier->closure_time_weight = $request->closure_time_weight;
        $supplier->end_user_satisfaction = $request->end_user_satisfaction;
        $supplier->end_user_satisfaction_weight = $request->end_user_satisfaction_weight;
        $supplier->scorecard_record = $request->scorecard_record;
        $supplier->achieved_score = $request->achieved_score;
        $supplier->total_available_score = $request->total_available_score;
        $supplier->total_score = $request->total_score;

        /****************** QA Reviewer ********************/
        $supplier->QA_reviewer_feedback = $request->QA_reviewer_feedback;
        $supplier->QA_reviewer_comment = $request->QA_reviewer_comment;

        if (!empty($request->QA_reviewer_attachment)) {
            $files = [];
            if ($request->hasfile('QA_reviewer_attachment')) {
                foreach ($request->file('QA_reviewer_attachment') as $file) {
                    $name = "CC" . '-QA_reviewer_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $supplier->QA_reviewer_attachment = json_encode($files);
        }

        /****************** Risk Assessment Content ********************/
        $supplier->last_audit_date = $request->last_audit_date;
        $supplier->next_audit_date = $request->next_audit_date;        
        $supplier->audit_frequency = $request->audit_frequency;
        $supplier->last_audit_result = $request->last_audit_result;
        $supplier->facility_type = $request->facility_type;
        $supplier->nature_of_employee = $request->nature_of_employee;
        $supplier->technical_support = $request->technical_support;
        $supplier->survice_supported = $request->survice_supported;
        $supplier->reliability = $request->reliability;
        $supplier->revenue = $request->revenue;
        $supplier->client_base = $request->client_base;
        $supplier->previous_audit_result = $request->previous_audit_result;
        $supplier->risk_raw_total = $request->risk_raw_total;
        $supplier->risk_median = $request->risk_median;
        $supplier->risk_average = $request->risk_average;
        $supplier->risk_assessment_total = $request->risk_assessment_total;

        /****************** QA Reviewer ********************/
        $supplier->QA_head_comment = $request->QA_head_comment;

        if (!empty($request->QA_head_attachment)) {
            $files = [];
            if ($request->hasfile('QA_head_attachment')) {
                foreach ($request->file('QA_head_attachment') as $file) {
                    $name = "CC" . '-QA_head_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $supplier->QA_head_attachment = json_encode($files);
        }

        $supplier->update();

        $certificationData = SupplierGrid::where(['supplier_id' => $supplier->id, 'identifier' =>'CertificationData'])->firstOrCreate();
        $certificationData->supplier_id = $supplier->id;
        $certificationData->identifier = 'CertificationData';
        $certificationData->data = $request->certificationData;
        $certificationData->update();


        return back();
    }

    public function singleReport(Request $request, $id){
        $data = Supplier::find($id);
        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $gridData = SupplierGrid::where('supplier_id', $data->id)->first();
            
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.supplier.supplier-single-report', compact(
                'data',
                'gridData',
            ))
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
                $width / 4,
                $height / 2,
                $data->status,
                null,
                25,
                [0, 0, 0],
                2,
                6,
                -20
            );
            return $pdf->stream('SOP' . $id . '.pdf');
        }
    }

    public function auditTrail(Request $request, $id){
        $audit = SupplierAuditTrail::where('supplier_id', $id)->orderByDESC('id')->paginate(5);
        $today = Carbon::now()->format('d-m-y');
        $document = Supplier::where('id', $id)->first();
        $document->originator = User::where('id', $document->initiator_id)->value('name');

        return view('frontend.supplier.supplier-audit-trail', compact('audit', 'document', 'today'));
    }

    public function auditTrailPdf(Request $request, $id){
        $doc = Supplier::find($id);
        if (!empty($doc)) {
            $doc->originator = User::where('id', $doc->initiator_id)->value('name');
            $data = SupplierAuditTrail::where('supplier_id', $doc->id)->orderByDesc('id')->get();
    
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.supplier.supplier-audit-trail-pdf', compact('data', 'doc'))
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

    public function supplierSendStage(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $supplier = Supplier::find($id);
            $lastDocument = Supplier::find($id);
            if ($supplier->stage == 1) {
                    $supplier->stage = "2";
                    $supplier->status = "Pending Qualification";
                    $supplier->submitted_by = Auth::user()->name;
                    $supplier->submitted_on = Carbon::now()->format('d-M-Y');
                    $supplier->submitted_comment = $request->comments;

                    $history = new SupplierAuditTrail();
                    $history->supplier_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = "";
                    $history->action = 'Submit Supplier Details';
                    $history->current = "Not Applicable";
                    $history->comment = $request->comments;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "Pending Qualification";
                    $history->change_from = $lastDocument->status;
                    $history->stage = 'Plan Proposed';
                    $history->save();
                    //  $list = Helpers::getHodUserList();
                    //     foreach ($list as $u) {
                    //         if($u->q_m_s_divisions_id == $supplier->division_id){
                    //             $email = Helpers::getInitiatorEmail($u->user_id);
                    //              if ($email !== null) {
                    //               Mail::send(
                    //                   'mail.view-mail',
                    //                    ['data' => $supplier],
                    //                 function ($message) use ($email) {
                    //                     $message->to($email)
                    //                         ->subject("Document is Send By".Auth::user()->name);
                    //                 }
                    //               );
                    //             }
                    //      }
                    //   }
                    $supplier->update();

                    toastr()->success('Sent to HOD Review');
                    return back();
            }
            if ($supplier->stage == 2) {
                    $supplier->stage = "3";
                    $supplier->status = "Pending Supplier Audit";
                    $supplier->pending_qualification_by = Auth::user()->name;
                    $supplier->pending_qualification_on = Carbon::now()->format('d-M-Y');
                    $supplier->pending_qualification_comment = $request->comments;

                    $history = new SupplierAuditTrail();
                    $history->supplier_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = "";
                    $history->action = 'Qualification Complete';
                    $history->current = "Not Applicable";
                    $history->comment = $request->comments;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "Pending Supplier Audit";
                    $history->change_from = $lastDocument->status;
                    $history->stage = 'Plan Proposed';
                    $history->save();
                    //  $list = Helpers::getHodUserList();
                    //     foreach ($list as $u) {
                    //         if($u->q_m_s_divisions_id == $supplier->division_id){
                    //             $email = Helpers::getInitiatorEmail($u->user_id);
                    //              if ($email !== null) {
                    //               Mail::send(
                    //                   'mail.view-mail',
                    //                    ['data' => $supplier],
                    //                 function ($message) use ($email) {
                    //                     $message->to($email)
                    //                         ->subject("Document is Send By".Auth::user()->name);
                    //                 }
                    //               );
                    //             }
                    //      }
                    //   }
                    $supplier->update();
                    
                    toastr()->success('Sent to Pending Supplier Audit');
                    return back();
            }
            if ($supplier->stage == 3) {
                $supplier->stage = "4";
                $supplier->status = "Pending Rejction";
                $supplier->pending_supplier_audit_by = Auth::user()->name;
                $supplier->pending_supplier_audit_on = Carbon::now()->format('d-M-Y');
                $supplier->pending_supplier_audit_comment = $request->comments;

                $history = new SupplierAuditTrail();
                    $history->supplier_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = "";
                    $history->action = 'Audit Failed';
                    $history->current = "Not Applicable";
                    $history->comment = $request->comments;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "Pending Rejction";
                    $history->change_from = $lastDocument->status;
                    $history->stage = 'Plan Proposed';
                    $history->save();
                //  $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $supplier->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //              if ($email !== null) {
                //               Mail::send(
                //                   'mail.view-mail',
                //                    ['data' => $supplier],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Send By".Auth::user()->name);
                //                 }
                //               );
                //             }
                //      }
                //   }
                $supplier->update();

                toastr()->success('Sent to Pending Rejction');
                return back();
            }
            if ($supplier->stage == 4) {
                $supplier->stage = "6";
                $supplier->status = "Obselete";
                $supplier->pending_rejection_by = Auth::user()->name;
                $supplier->pending_rejection_on = Carbon::now()->format('d-M-Y');
                $supplier->pending_rejection_comment = $request->comments;

                $history = new SupplierAuditTrail();
                    $history->supplier_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = "";
                    $history->action = 'Supplier Obsolete';
                    $history->current = $supplier->submit_by;
                    $history->comment = $request->comments;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to = "Obselete";
                    $history->change_from = $lastDocument->status;
                    $history->stage = 'Plan Proposed';
                    $history->save();
                //  $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $supplier->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //              if ($email !== null) {
                //               Mail::send(
                //                   'mail.view-mail',
                //                    ['data' => $supplier],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Send By".Auth::user()->name);
                //                 }
                //               );
                //             }
                //      }
                //   }
                $supplier->update();
                
                toastr()->success('Pending CFT Review');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function sendToSupplierApproved(Request $request, $id){
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $supplier = Supplier::find($id);
            $lastDocument = Supplier::find($id);

            $supplier->stage = "5";
            $supplier->status = "Supplier Approved";
            $supplier->supplier_approved_by = Auth::user()->name;
            $supplier->supplier_approved_on = Carbon::now()->format('d-M-Y');
            $supplier->supplier_approved_comment = $request->comments;
        
            $history = new SupplierAuditTrail();
            $history->supplier_id = $id;
            $history->activity_type = 'Activity Log';
            $history->previous = "";
            $history->action = 'Audit Passed';
            $history->current = "";
            $history->comment = $request->comments;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Supplier Approved";
            $history->change_from = $lastDocument->status;        
            $history->save();
            $supplier->update();

            // foreach ($list as $u) {
            //     if ($u->q_m_s_divisions_id == $deviation->division_id) {
            //         $email = Helpers::getInitiatorEmail($u->user_id);
            //         if ($email !== null) {

            //             try {
            //                 Mail::send(
            //                     'mail.view-mail',
            //                     ['data' => $deviation],
            //                     function ($message) use ($email) {
            //                         $message->to($email)
            //                             ->subject("Activity Performed By " . Auth::user()->name);
            //                     }
            //                 );
            //             } catch (\Exception $e) {
            //                 //log error
            //             }
            //         }
            //     }
            // }
            $supplier->update();
            toastr()->success('Document Sent');
            return back();

        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function supplierApprovedToObselete(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $supplier = Supplier::find($id);
            $lastDocument = Supplier::find($id);

            $supplier->stage = "6";
            $supplier->status = "Obselete";
            $supplier->supplier_approved_to_obselete_by = Auth::user()->name;
            $supplier->supplier_approved_to_obselete_on = Carbon::now()->format('d-M-Y');
            $supplier->supplier_approved_to_obselete_comment = $request->comments;
        
            $history = new SupplierAuditTrail();
            $history->supplier_id = $id;
            $history->activity_type = 'Activity Log';
            $history->previous = "";
            $history->action = 'Supplier Obsolete';
            $history->current = "";
            $history->comment = $request->comments;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Obselete";
            $history->change_from = $lastDocument->status;        
            $history->save();
            $supplier->update();

            // foreach ($list as $u) {
            //     if ($u->q_m_s_divisions_id == $deviation->division_id) {
            //         $email = Helpers::getInitiatorEmail($u->user_id);
            //         if ($email !== null) {

            //             try {
            //                 Mail::send(
            //                     'mail.view-mail',
            //                     ['data' => $deviation],
            //                     function ($message) use ($email) {
            //                         $message->to($email)
            //                             ->subject("Activity Performed By " . Auth::user()->name);
            //                     }
            //                 );
            //             } catch (\Exception $e) {
            //                 //log error
            //             }
            //         }
            //     }
            // }
            $supplier->update();
            toastr()->success('Document Sent');
            return back();

        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function cancelDocument(Request $request, $id){
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $supplier = Supplier::find($id);
            $lastDocument = Supplier::find($id);

            $supplier->stage = "0";
            $supplier->status = "Close - Cancelled";
            $supplier->cancelled_by = Auth::user()->name;
            $supplier->cancelled_on = Carbon::now()->format('d-M-Y');
            $supplier->cancelled_comment = $request->comments;
        
            $history = new SupplierAuditTrail();
            $history->supplier_id = $id;
            $history->activity_type = 'Activity Log';
            $history->previous = "";
            $history->action = 'Cancel';
            $history->current = "";
            $history->comment = $request->comments;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =  "Close - Cancelled";
            $history->change_from = $lastDocument->status;        
            $history->save();
            $supplier->update();

            // foreach ($list as $u) {
            //     if ($u->q_m_s_divisions_id == $deviation->division_id) {
            //         $email = Helpers::getInitiatorEmail($u->user_id);
            //         if ($email !== null) {

            //             try {
            //                 Mail::send(
            //                     'mail.view-mail',
            //                     ['data' => $deviation],
            //                     function ($message) use ($email) {
            //                         $message->to($email)
            //                             ->subject("Activity Performed By " . Auth::user()->name);
            //                     }
            //                 );
            //             } catch (\Exception $e) {
            //                 //log error
            //             }
            //         }
            //     }
            // }
            $supplier->update();
            toastr()->success('Document Sent');
            return back();

        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function sendToPendingSupplierAudit(Request $request, $id){
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $supplier = Supplier::find($id);
            $lastDocument = Supplier::find($id);
            if ($supplier->stage == 4) {
                    $supplier->stage = "3";
                    $supplier->status = "Pending Supplier Audit";
                    $supplier->reAudit_by = Auth::user()->name;
                    $supplier->reAudit_on = Carbon::now()->format('d-M-Y');
                    $supplier->reAudit_comment = $request->comments;

                    $history = new SupplierAuditTrail();
                    $history->supplier_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = "";
                    $history->action = 'Re-Audit';
                    $history->current = "Not Applicable";
                    $history->comment = $request->comments;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "Pending Supplier Audit";
                    $history->change_from = $lastDocument->status;
                    $history->stage = 'Plan Proposed';
                    $history->save();
                    //  $list = Helpers::getHodUserList();
                    //     foreach ($list as $u) {
                    //         if($u->q_m_s_divisions_id == $supplier->division_id){
                    //             $email = Helpers::getInitiatorEmail($u->user_id);
                    //              if ($email !== null) {
                    //               Mail::send(
                    //                   'mail.view-mail',
                    //                    ['data' => $supplier],
                    //                 function ($message) use ($email) {
                    //                     $message->to($email)
                    //                         ->subject("Document is Send By".Auth::user()->name);
                    //                 }
                    //               );
                    //             }
                    //      }
                    //   }
                    $supplier->update();

                    toastr()->success('Sent to HOD Review');
                    return back();
            }
            if ($supplier->stage == 5) {
                    $supplier->stage = "3";
                    $supplier->status = "Pending Supplier Audit";
                    $supplier->rejectedDueToQuality_by = Auth::user()->name;
                    $supplier->rejectedDueToQuality_on = Carbon::now()->format('d-M-Y');
                    $supplier->rejectedDueToQuality_comment = $request->comments;

                    $history = new SupplierAuditTrail();
                    $history->supplier_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = "";
                    $history->action = 'Reject Due To Quality Issues';
                    $history->current = "Not Applicable";
                    $history->comment = $request->comments;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "Pending Supplier Audit";
                    $history->change_from = $lastDocument->status;
                    $history->stage = 'Plan Proposed';
                    $history->save();
                    //  $list = Helpers::getHodUserList();
                    //     foreach ($list as $u) {
                    //         if($u->q_m_s_divisions_id == $supplier->division_id){
                    //             $email = Helpers::getInitiatorEmail($u->user_id);
                    //              if ($email !== null) {
                    //               Mail::send(
                    //                   'mail.view-mail',
                    //                    ['data' => $supplier],
                    //                 function ($message) use ($email) {
                    //                     $message->to($email)
                    //                         ->subject("Document is Send By".Auth::user()->name);
                    //                 }
                    //               );
                    //             }
                    //      }
                    //   }
                    $supplier->update();
                    
                    toastr()->success('Sent to Pending Supplier Audit');
                    return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function supplierChild(Request $request, $id){

    }
}