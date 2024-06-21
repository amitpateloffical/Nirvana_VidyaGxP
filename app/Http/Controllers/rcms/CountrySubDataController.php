<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecordNumber;
use App\Models\CountrySubData;
use App\Models\CountrySubGrid;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CountrySubDataController extends Controller
{
    public function country_submission()
    {
        $record = ((RecordNumber::first()->value('counter')) + 1);
        $record = str_pad($record, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view("frontend.ctms.country_sub_data", compact('due_date', 'record'));
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


          //==================GRID=======================
         //for product material
        $griddata = $country->id;

        $newData = CountrySubGrid::where(['c_id' => $griddata, 'identifer' => 'ProductMaterialDetails'])->firstOrNew();
        $newData->c_id = $griddata;
        $newData->identifer = 'ProductMaterialDetails';
        $newData->data = $request->serial_number_gi;
        $newData->save();

           //=========================================

         toastr()->success("Record is created Successfully");
         return redirect(url('rcms/qms-dashboard'));

    }

    public function country_update(Request $request, $id)
    {

    }

    public function country_show($id)
    {

    }

    public function country_send_stage(Request $request, $id)
    {

    }

    public function country_Cancle(Request $request)
    {

    }

    public function countryAuditTrail($id)
    {

    }

    public static function singleReport($id)
    {

    }

    public static function auditReport($id)
    {
        
    }



}
