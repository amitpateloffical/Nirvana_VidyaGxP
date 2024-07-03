<?php

namespace App\Http\Controllers\newForm;

use App\Http\Controllers\Controller;
use App\Models\RecordNumber;
use App\Models\User;
use App\Models\Study;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudyController extends Controller
{
    public function index(){

        $old_record = Study::select('id', 'division_id', 'record')->get();
        $record= ((RecordNumber::first()->value('counter')) + 1);
        $record = str_pad($record, 4, '0', STR_PAD_LEFT);
       // $division = QMSDivision::where('status', '1')->get();

        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        $users = User::all();

        // $registrations = MedicalDeviceRegistration::all();
        return view('frontend.Study.study', compact('old_record','record','formattedDate','currentDate','due_date','users'));
       // return view('frontend.Study.study');

    }

    public function store(Request $request){
      //  dd($request->all());
      //$study = Study::findOrFail($id);

     $study  = new Study();

     $study->record = ((RecordNumber::first()->value('counter')) + 1);


     $study->initiator_id= Auth::user()->id;
     $study->intiation_date  = $request->intiation_date;
     $study->division_id = $request->division_id;
    // $study->type = "Study";
     $study->short_description = $request->short_description;
     $study->assigned_to = $request->assigned_to;
     $study->divison_code = $request->divison_code;
     $study->due_date = $request->due_date;
     $study->study_num = $request->study_num;
     $study->sponsor = $request->sponsor;
     $study->type1 = $request->type1;

    // $study->record = $request->record;
     $study->version = $request->version;
     $study->type = $request->type;
     $study->sponsor = $request->sponsor;
    // $study->file_attach = $request->file_attach;
     $study->related_urls = $request->related_urls;
     $study->source_documents = $request->source_documents;
     $study->comments = $request->comments;
     $study->budget = $request->budget;

     $study->total_study = $request->Total_study;
     $study->currency = $request->currency;
     $study->parent_name = $request->parent_name;
     $study->audit_agenda_grid = $request->audit_agenda_grid;
     $study->projected = $request->projected;
     $study->total_sites = $request->total_sites;
     $study->subjects = $request->subjects;
     $study->total_subjects = $request->total_subjects;

     $study->departments = $request->departments;
     $study->protocol = $request->protocol;
     $study->protocol_activities = $request->protocol_activities;
     $study->counties = $request->counties;
     $study->agency = $request->agency;
     $study->eudraCT = $request->eudraCT;
     $study->regulatory = $request->regulatory;
     $study->global_regulatory = $request->global_regulatory;

     $study->protocol_name = $request->protocol_name;
     $study->comment1 = $request->comment1;
     $study->case_report = $request->case_report;
     $study->case_number = $request->case_number;

     $study->background = $request->background;
     $study->objectives = $request->objectives;
     $study->pediatric = $request->pediatric;
     $study->partner = $request->partner;

     $study->study_hypothesis = $request->study_hypothesis;
     $study->biomarker = $request->biomarker;
     $study->blinding = $request->blinding;
     $study->consent_form = $request->consent_form;

     $study->ctx = $request->ctx;
     $study->crossover_trial = $request->crossover_trial;
     $study->comperative = $request->comperative;
     $study->comperator = $request->comperator;

     $study->version_no = $request->version_no;
     $study->study_manual = $request->study_manual;
     $study->global_version = $request->global_version;
     $study->version_approved = $request->version_approved;

     $study->hospitals = $request->hospitals;
     $study->venders = $request->venders;
     $study->audit_agenda_grid1 = $request->audit_agenda_grid1;
     $study->interim_study_report = $request->interim_study_report;

     $study->result_synopsis = $request->result_synopsis;
     $study->study_final_report = $request->study_final_report;
     $study->surrogate = $request->surrogate;
     $study->special_handling = $request->special_handling;

     $study->minimum_time = $request->minimum_time;
     $study->washout_period = $request->washout_period;
     $study->admission_criteria = $request->admission_criteria;
     $study->clinical_significance = $request->clinical_significance;

     $study->audit_agenda_grid2 = $request->audit_agenda_grid2;
     $study->audit_agenda_grid3 = $request->audit_agenda_grid3;
     $study->start_Inclusion = $request->start_Inclusion;
     $study->end_Inclusion = $request->end_Inclusion;

     $study->scheduled_start_date = $request->scheduled_start_date;
     $study->scheduled_end_date = $request->scheduled_end_date;
     $study->actual_start = $request->actual_start;
     $study->actual_end = $request->actual_end;

     $study->date_trial_active = $request->date_trial_active;
     $study->end_date_trial_active = $request->end_date_trial_active;
     $study->protocol_date = $request->protocol_date;
     $study->dateofcurrent = $request->dateofcurrent;

     $study->irb_approval = $request->irb_approval;
     $study->international_birth = $request->international_birth;
     $study->ethics = $request->ethics;
     $study->manual_version = $request->manual_version;

     $study->first_subject = $request->first_subject;
     $study->last_subject = $request->last_subject;
     $study->signatures = $request->signatures;
     $study->lead = $request->lead;

     $study->project_manager = $request->project_manager;
     $study->crom = $request->crom;
     $study->sponsors = $request->sponsors;
     $study->additional_investigators = $request->additional_investigators;

     $study->manager = $request->manager;
     $study->clinical_research = $request->clinical_research;
     $study->data_safety = $request->data_safety;
     $study->clinical_event = $request->clinical_event;

     $study->irb = $request->irb;
     $study->statisticlans = $request->statisticlans;
     $study->biostatisticlans = $request->biostatisticlans;
     $study->stage = "1";
     $study->status = "Opened";

     if (!empty ($request->file_attach)) {
        $files = [];
        if ($request->hasfile('file_attach')) {
            foreach ($request->file('file_attach') as $file) {
                $name = $request->name . 'file_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }


        $study->file_attach = json_encode($files);
    }

    $study->save();

    $record_number = RecordNumber::first();
        $record_number->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record_number->update();

    toastr()->success("Study is created succusfully");
    return redirect(url('rcms/qms-dashboard'));

    }

  public function show($id){

       $study = Study::findOrFail($id);
        $record_number = str_pad($study->record, 4, '0', STR_PAD_LEFT);
        return view('frontend.Study.view_study', compact('study','record_number'));
  }

  public function studyUpdate(Request $request,$id){

    $study = Study::findOrFail($id);

//     $study  = new Study();

//    $study->record = ((RecordNumber::first()->value('counter')) + 1);


    $study->initiator_id= Auth::user()->id;
    $study->intiation_date  = $request->intiation_date;
    $study->division_id = $request->division_id;
    $study->type = "Study";
    $study->short_description = $request->short_description;
    $study->assigned_to = $request->assigned_to;
    $study->divison_code = $request->divison_code;
    $study->due_date = $request->due_date;
    $study->study_num = $request->study_num;
    $study->sponsor = $request->sponsor;
    $study->type1 = $request->type1;

   // $study->record = $request->record;
    $study->Version = $request->Version;
    $study->type = $request->type;
    $study->sponsor = $request->sponsor;
   // $study->file_attach = $request->file_attach;
    $study->related_urls = $request->related_urls;
    $study->source_documents = $request->source_documents;
    $study->comments = $request->comments;
    $study->budget = $request->budget;

    $study->total_study = $request->total_study;
    $study->currency = $request->currency;
    $study->parent_name = $request->parent_name;
    $study->audit_agenda_grid = $request->audit_agenda_grid;
    $study->projected = $request->projected;
    $study->total_sites = $request->total_sites;
    $study->subjects = $request->subjects;
    $study->total_subjects = $request->total_subjects;

    $study->departments = $request->departments;
    $study->protocol = $request->protocol;
    $study->protocol_activities = $request->protocol_activities;
    $study->counties = $request->counties;
    $study->agency = $request->agency;
    $study->eudraCT = $request->eudraCT;
    $study->regulatory = $request->regulatory;
    $study->global_regulatory = $request->global_regulatory;

    $study->protocol_name = $request->protocol_name;
    $study->comment1 = $request->comment1;
    $study->case_report = $request->case_report;
    $study->case_number = $request->case_number;

    $study->background = $request->background;
    $study->objectives = $request->objectives;
    $study->pediatric = $request->pediatric;
    $study->partner = $request->partner;

    $study->study_hypothesis = $request->study_hypothesis;
    $study->biomarker = $request->biomarker;
    $study->blinding = $request->blinding;
    $study->consent_form = $request->consent_form;

    $study->ctx = $request->ctx;
    $study->crossover_trial = $request->crossover_trial;
    $study->comperative = $request->comperative;
    $study->comperator = $request->comperator;

    $study->version_no = $request->version_no;
    $study->study_manual = $request->study_manual;
    $study->global_version = $request->global_version;
    $study->version_approved = $request->version_approved;

    $study->hospitals = $request->hospitals;
    $study->venders = $request->venders;
    $study->audit_agenda_grid1 = $request->audit_agenda_grid1;
    $study->interim_study_report = $request->interim_study_report;

    $study->result_synopsis = $request->result_synopsis;
    $study->study_final_report = $request->study_final_report;
    $study->surrogate = $request->surrogate;
    $study->special_handling = $request->special_handling;

    $study->minimum_time = $request->minimum_time;
    $study->washout_period = $request->washout_period;
    $study->admission_criteria = $request->admission_criteria;
    $study->clinical_significance = $request->clinical_significance;

    $study->audit_agenda_grid2 = $request->audit_agenda_grid2;
    $study->audit_agenda_grid3 = $request->audit_agenda_grid3;
    $study->start_Inclusion = $request->start_Inclusion;
    $study->end_Inclusion = $request->end_Inclusion;

    $study->scheduled_start_date = $request->scheduled_start_date;
    $study->scheduled_end_date = $request->scheduled_end_date;
    $study->actual_start = $request->actual_start;
    $study->actual_end = $request->actual_end;

    $study->date_trial_active = $request->date_trial_active;
    $study->end_date_trial_active = $request->end_date_trial_active;
    $study->protocol_date = $request->protocol_date;
    $study->dateofcurrent = $request->dateofcurrent;

    $study->irb_approval = $request->irb_approval;
    $study->international_birth = $request->international_birth;
    $study->ethics = $request->ethics;
    $study->manual_version = $request->manual_version;

    $study->first_subject = $request->first_subject;
    $study->last_subject = $request->last_subject;
    $study->signatures = $request->signatures;
    $study->lead = $request->lead;

    $study->project_manager = $request->project_manager;
    $study->crom = $request->crom;
    $study->sponsors = $request->sponsors;
    $study->additional_investigators = $request->additional_investigators;

    $study->manager = $request->manager;
    $study->clinical_research = $request->clinical_research;
    $study->data_safety = $request->data_safety;
    $study->clinical_event = $request->clinical_event;

    $study->irb = $request->irb;
    $study->statisticlans = $request->statisticlans;
    $study->biostatisticlans = $request->biostatisticlans;
    $study->stage = "1";
    $study->status = "Opened";

    if (!empty ($request->file_attach)) {
       $files = [];
       if ($request->hasfile('file_attach')) {
           foreach ($request->file('file_attach') as $file) {
               $name = $request->name . 'file_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
               $file->move('upload/', $name);
               $files[] = $name;
           }
       }


       $study->file_attach = json_encode($files);
   }

   $study->update();

   toastr()->success("Study is updated succusfully");
   return redirect(url('rcms/qms-dashboard'));




  }





    }

