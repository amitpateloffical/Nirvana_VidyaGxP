<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use App\Models\RecordNumber;
use App\Models\RootAuditTrial;
use App\Models\RoleGroup;
use App\Models\RootCft;

use App\Models\RiskAssesmentGrid;
use App\Models\RootCauseAnalysis;
use App\Models\RootCauseAnalysesGrid;
use App\Models\RootCauseAnalysisHistory;
use App\Models\User;
use Helpers;
use Illuminate\Support\Facades\Mail;
use App\Models\RootcauseAnalysisDocDetails;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

 class RootCauseController extends Controller
{
    public function rootcause()
    {
        // $data1 = DeviationCft::where('deviation_id', $id)->first();
        
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view("frontend.forms.root-cause-analysis", compact('due_date', 'record_number'));
    }
    public function root_store(Request $request)
    { 
        if (!$request->short_description) {
           toastr()->error("Short description is required");
             return redirect()->back();
        }
        $root = new RootCauseAnalysis();
        $root->type = "RootCauseAnalysis"; 
        $root->originator_id = $request->originator_id;
        $root->date_opened = $request->date_opened;
        $root->division_id = $request->division_id;
        $root->priority_level = $request->priority_level;
        $root->severity_level = $request->severity_level;
        $root->short_description =($request->short_description);
        $root->assigned_to = $request->assigned_to;
        $root->assign_to = $request->assign_to;
        $root->root_cause_description = $request->root_cause_description;
        $root->due_date = $request->due_date;
        $root->cft_comments_new = $request->cft_comments_new;
        $root->Type1= $request->Type;
//=======================================signature data field=======================================//
         $root->hod_review_complete_by = $request->hod_review_complete_by;
         $root->hod_review_complete_on = $request->hod_review_complete_on;
         $root->responsible_person_update_by = $request->responsible_person_update_by;
         $root->responsible_person_update_on = $request->responsible_person_update_on;
         $root->initial_qa_review_by = $request->initial_qa_review_by;
         $root->initial_qa_review_on = $request->initial_qa_review_on;
         $root->cft_review_by = $request->cft_review_by;
         $root->cft_review_on = $request->cft_review_on;
         $root->qa_approve_review_by = $request->qa_approve_review_by;
         $root->qa_approve_review_on = $request->qa_approve_review_on;
         $root->hod_final_review_by = $request->hod_final_review_by;
         $root->hod_final_review_on = $request->hod_final_review_on;
         $root->child_closure_by = $request->child_closure_by;
         $root->child_closure_on = $request->child_closure_on;
         $root->qa_head_review_by = $request->qa_head_review_by;
         $root->qa_head_review_on = $request->qa_head_review_on;
         $root->close_done_by = $request->close_done_by;
         $root->close_done_on = $request->close_done_on;
         $root->re_open_addendum_by = $request->re_open_addendum_by;
         $root->addendum_approved_by = $request->addendum_approved_by;
         $root->addendum_approved_on = $request->addendum_approved_on;
         $root->under_addendum_execution_by = $request->under_addendum_execution_by;
         $root->under_addendum_execution_on = $request->under_addendum_execution_on;
         $root->under_addendum_verification_by = $request->under_addendum_verification_by;
         $root->under_addendum_verification_on = $request->under_addendum_verification_on;
         $root->closed_done_by = $request->closed_done_by;
         $root->closed_done_on = $request->closed_done_on;
        
         $root->investigators = $request->investigators;
        // $root->investigators = implode(',', $request->investigators);
        $root->initiated_through = $request->initiated_through;
        $root->initiated_if_other = $request->initiated_if_other;
        $root->department = $request->department;
        $root->description = ($request->description);
        $root->comments = ($request->comments);
        $root->related_url = ($request->related_url);
        $root->root_cause_methodology = implode(',', $request->root_cause_methodology);
        //Fishbone or Ishikawa Diagram
        if (!empty($request->measurement  )) {
            $root->measurement = serialize($request->measurement);
        }
        if (!empty($request->materials  )) {
            $root->materials = serialize($request->materials);
        }
        if (!empty($request->environment  )) {
            $root->environment = serialize($request->environment);
        }
        if (!empty($request->manpower  )) {
            $root->manpower = serialize($request->manpower);
        }
        if (!empty($request->machine  )) {
            $root->machine = serialize($request->machine);
        }
        if (!empty($request->methods)) {
            $root->methods = serialize($request->methods);
        }
        $root->problem_statement = ($request->problem_statement);
        // Why-Why Chart (Launch Instruction) Problem Statement 
        if (!empty($request->why_problem_statement)) {
            $root->why_problem_statement = $request->why_problem_statement;
        }
        if (!empty($request->why_1  )) {
            $root->why_1 = serialize($request->why_1);
        }
        if (!empty($request->why_2  )) {
            $root->why_2 = serialize($request->why_2);
        }
        if (!empty($request->why_3  )) {
            $root->why_3 = serialize($request->why_3);
        }
        if (!empty($request->why_4 )) {
            $root->why_4 = serialize($request->why_4);
        }
        if (!empty($request->why_5  )) {
            $root->why_5 = serialize($request->why_5);
        }
        if (!empty($request->why_root_cause)) {
            $root->why_root_cause = $request->why_root_cause;
        }

        // Is/Is Not Analysis (Launch Instruction)
        $root->what_will_be = ($request->what_will_be);
        $root->what_will_not_be = ($request->what_will_not_be);
        $root->what_rationable = ($request->what_rationable);

        $root->where_will_be = ($request->where_will_be);
        $root->where_will_not_be = ($request->where_will_not_be);
        $root->where_rationable = ($request->where_rationable);

        $root->when_will_be = ($request->when_will_be);
        $root->when_will_not_be = ($request->when_will_not_be);
        $root->when_rationable = ($request->when_rationable);

        $root->coverage_will_be = ($request->coverage_will_be);
        $root->coverage_will_not_be = ($request->coverage_will_not_be);
        $root->coverage_rationable = ($request->coverage_rationable);

        $root->who_will_be = ($request->who_will_be);
        $root->who_will_not_be = ($request->who_will_not_be);
        $root->who_rationable = ($request->who_rationable);
        
        $root->investigation_summary = ($request->investigation_summary);
        // $root->zone = ($request->zone);
        // $root->country = ($request->country);
        // $root->state = ($request->state);
        // $root->city = ($request->city);
        $root->submitted_by = ($request->submitted_by);

        if (!empty($request->Root_Cause_Category  )) {
            $root->Root_Cause_Category = serialize($request->Root_Cause_Category);
        }
        if (!empty($request->Root_Cause_Sub_Category)) {
            $root->Root_Cause_Sub_Category= serialize($request->Root_Cause_Sub_Category);
        }
        if (!empty($request->Probability)) {
            $root->Probability = serialize($request->Probability);
        }
        if (!empty($request->Remarks)) {
            $root->Remarks = serialize($request->Remarks);
        }

        if (!empty($request->initial_rpn)) {
            $root->initial_rpn = serialize($root->initial_rpn);
        }

        $root->record = ((RecordNumber::first()->value('counter')) + 1);
        $root->initiator_id = Auth::user()->id;
        $root->division_code = $request->division_code;
        $root->intiation_date = $request->intiation_date;
        $root->initiator_Group = $request->initiator_Group;
        $root->initiator_group_code = $request->initiator_group_code;
        $root->short_description = $request->short_description;
        $root->due_date = $request->due_date;
        $root->assign_to = $request->assign_to;
        $root->Sample_Types = $request->Sample_Types;
        if (!empty($request->root_cause_initial_attachment)) {
            $files = [];
            if ($request->hasfile('root_cause_initial_attachment')) {
                foreach ($request->file('root_cause_initial_attachment') as $file) {
                    $name = $request->name . 'root_cause_initial_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $root->root_cause_initial_attachment = json_encode($files);
        }
        if (!empty($request->cft_attchament_new)) {
            $files = [];
            if ($request->hasfile('cft_attchament_new')) {
                foreach ($request->file('cft_attchament_new') as $file) {
                    $name = $request->name . 'cft_attchament_new' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $root->cft_attchament_new = json_encode($files);
        }
        
        //Failure Mode and Effect Analysis+

        if (!empty($request->risk_factor)) {
            $root->risk_factor = serialize($request->risk_factor);
        }
        if (!empty($request->risk_element)) {
            $root->risk_element = serialize($request->risk_element);
        }
        if (!empty($request->problem_cause)) {
            $root->problem_cause = serialize($request->problem_cause);
        }
        if (!empty($request->existing_risk_control)) {
            $root->existing_risk_control = serialize($request->existing_risk_control);
        }
        if (!empty($request->initial_severity)) {
            $root->initial_severity = serialize($request->initial_severity);
        }
        if (!empty($request->initial_detectability)) {
            $root->initial_detectability = serialize($request->initial_detectability);
        }
        if (!empty($request->initial_probability)) {
            $root->initial_probability = serialize($request->initial_probability);
        }
        if (!empty($request->initial_rpn)) {
            $root->initial_rpn = serialize($request->initial_rpn);
        }
        if (!empty($request->risk_acceptance)) {
            $root->risk_acceptance = serialize($request->risk_acceptance);
        }
        if (!empty($request->risk_control_measure)) {
            $root->risk_control_measure = serialize($request->risk_control_measure);
        }
        if (!empty($request->residual_severity)) {
            $root->residual_severity = serialize($request->residual_severity);
        }
        if (!empty($request->residual_probability)) {
            $root->residual_probability = serialize($request->residual_probability);
        }
        if (!empty($request->residual_detectability)) {
            $root->residual_detectability = serialize($request->residual_detectability);
        }
        if (!empty($request->residual_rpn)) {
            $root->residual_rpn = serialize($request->residual_rpn);
        }
        if (!empty($request->risk_acceptance2)) {
            $root->risk_acceptance2 = serialize($request->risk_acceptance2);
        }
        if (!empty($request->mitigation_proposal)) {
            $root->mitigation_proposal = serialize($request->mitigation_proposal);
        }

        $root->status = 'Opened';
        $root->stage = 1;
        $root->save();

        //--------------------cft-------------------
        
        $Cft = new RootCft();
        $Cft->root_id = $root->id;
        $Cft->Production_Review = $request->Production_Review;
        $Cft->Production_person = $request->Production_person;
        $Cft->Production_assessment = $request->Production_assessment;
        $Cft->Production_feedback = $request->Production_feedback;
        $Cft->production_on = $request->production_on;
        $Cft->production_by = $request->production_by; 

        $Cft->Warehouse_review = $request->Warehouse_review;
        $Cft->Warehouse_notification = $request->Warehouse_notification;
        $Cft->Warehouse_assessment = $request->Warehouse_assessment;
        $Cft->Warehouse_feedback = $request->Warehouse_feedback;
        $Cft->Warehouse_by = $request->Warehouse_Review_Completed_By;
        $Cft->Warehouse_on = $request->Warehouse_on;

        $Cft->Quality_review = $request->Quality_review;
        $Cft->Quality_Control_Person = $request->Quality_Control_Person;
        $Cft->Quality_Control_assessment = $request->Quality_Control_assessment;
        $Cft->Quality_Control_feedback = $request->Quality_Control_feedback;
        $Cft->Quality_Control_by = $request->Quality_Control_by;
        $Cft->Quality_Control_on = $request->Quality_Control_on;

        $Cft->Quality_Assurance_Review = $request->Quality_Assurance_Review;
        $Cft->QualityAssurance_person = $request->QualityAssurance_person;
        $Cft->QualityAssurance_assessment = $request->QualityAssurance_assessment;
        $Cft->QualityAssurance_feedback = $request->QualityAssurance_feedback;
        $Cft->QualityAssurance_by = $request->QualityAssurance_by;
        $Cft->QualityAssurance_on = $request->QualityAssurance_on;

        $Cft->Engineering_review = $request->Engineering_review;
        $Cft->Engineering_person = $request->Engineering_person;
        $Cft->Engineering_assessment = $request->Engineering_assessment;
        $Cft->Engineering_feedback = $request->Engineering_feedback;
        $Cft->Engineering_by = $request->Engineering_by;
        $Cft->Engineering_on = $request->Engineering_on;

        $Cft->Analytical_Development_review = $request->Analytical_Development_review;
        $Cft->Analytical_Development_person = $request->Analytical_Development_person;
        $Cft->Analytical_Development_assessment = $request->Analytical_Development_assessment;
        $Cft->Analytical_Development_feedback = $request->Analytical_Development_feedback;
        $Cft->Analytical_Development_by = $request->Analytical_Development_by;
        $Cft->Analytical_Development_on = $request->Analytical_Development_on;

        $Cft->Kilo_Lab_review = $request->Kilo_Lab_review;
        $Cft->Kilo_Lab_person = $request->Kilo_Lab_person;
        $Cft->Kilo_Lab_assessment = $request->Kilo_Lab_assessment;
        $Cft->Kilo_Lab_feedback = $request->Kilo_Lab_feedback;
        $Cft->Kilo_Lab_attachment_by = $request->Kilo_Lab_attachment_by;
        $Cft->Kilo_Lab_attachment_on = $request->Kilo_Lab_attachment_on;

        $Cft->Technology_transfer_review = $request->Technology_transfer_review;
        $Cft->Technology_transfer_person = $request->Technology_transfer_person;
        $Cft->Technology_transfer_assessment = $request->Technology_transfer_assessment;
        $Cft->Technology_transfer_feedback = $request->Technology_transfer_feedback;
        $Cft->Technology_transfer_by = $request->Technology_transfer_by;
        $Cft->Technology_transfer_on = $request->Technology_transfer_on;

        $Cft->Environment_Health_review = $request->Environment_Health_review;
        $Cft->Environment_Health_Safety_person = $request->Environment_Health_Safety_person;
        $Cft->Health_Safety_assessment = $request->Health_Safety_assessment;
        $Cft->Health_Safety_feedback = $request->Health_Safety_feedback;
        $Cft->Environment_Health_Safety_by = $request->Environment_Health_Safety_by;
        $Cft->Environment_Health_Safety_on = $request->Environment_Health_Safety_on;

        $Cft->Human_Resource_review = $request->Human_Resource_review;
        $Cft->Human_Resource_person = $request->Human_Resource_person;
        $Cft->Human_Resource_assessment = $request->Human_Resource_assessment;
        $Cft->Human_Resource_feedback = $request->Human_Resource_feedback;
        $Cft->Human_Resource_by = $request->Human_Resource_by;
        $Cft->Human_Resource_on = $request->Human_Resource_on;

        $Cft->Information_Technology_review = $request->Information_Technology_review;
        $Cft->Information_Technology_person = $request->Information_Technology_person;
        $Cft->Information_Technology_assessment = $request->Information_Technology_assessment;
        $Cft->Information_Technology_feedback = $request->Information_Technology_feedback;
        $Cft->Information_Technology_by = $request->Information_Technology_by;
        $Cft->Information_Technology_on = $request->Information_Technology_on;

        $Cft->Project_management_review = $request->Project_management_review;
        $Cft->Project_management_person = $request->Project_management_person;
        $Cft->Project_management_assessment = $request->Project_management_assessment;
        $Cft->Project_management_feedback = $request->Project_management_feedback;
        $Cft->Project_management_by = $request->Project_management_by;
        $Cft->Project_management_on = $request->Project_management_on;

        $Cft->Other1_review = $request->Other1_review;
        $Cft->Other1_person = $request->Other1_person;
        $Cft->Other1_Department_person = $request->Other1_Department_person;
        $Cft->Other1_assessment = $request->Other1_assessment;
        $Cft->Other1_feedback = $request->Other1_feedback;
        $Cft->Other1_by = $request->Other1_by;
        $Cft->Other1_on = $request->Other1_on;

        $Cft->Other2_review = $request->Other2_review;
        $Cft->Other2_person = $request->Other2_person;
        $Cft->Other2_Department_person = $request->Other2_Department_person;
        $Cft->Other2_Assessment = $request->Other2_Assessment;
        $Cft->Other2_feedback = $request->Other2_feedback;
        $Cft->Other2_by = $request->Other2_by;
        $Cft->Other2_on = $request->Other2_on;

        $Cft->Other3_review = $request->Other3_review;
        $Cft->Other3_person = $request->Other3_person;
        $Cft->Other3_Department_person = $request->Other3_Department_person;
        $Cft->Other3_Assessment = $request->Other3_Assessment;
        $Cft->Other3_feedback = $request->Other3_feedback;
        $Cft->Other3_by = $request->Other3_by;
        $Cft->Other3_on = $request->Other3_on;

        $Cft->Other4_review = $request->Other4_review;
        $Cft->Other4_person = $request->Other4_person;
        $Cft->Other4_Department_person = $request->Other4_Department_person;
        $Cft->Other4_Assessment = $request->Other4_Assessment;
        $Cft->Other4_feedback = $request->Other4_feedback;
        $Cft->Other4_by = $request->Other4_by;
        $Cft->Other4_on = $request->Other4_on;

        $Cft->Other5_review = $request->Other5_review;
        $Cft->Other5_person = $request->Other5_person;
        $Cft->Other5_Department_person = $request->Other5_Department_person;
        $Cft->Other5_Assessment = $request->Other5_Assessment;
        $Cft->Other5_feedback = $request->Other5_feedback;
        $Cft->Other5_by = $request->Other5_by;
        $Cft->Other5_on = $request->Other5_on;

        if (!empty ($request->production_attachment)) {
            $files = [];
            if ($request->hasfile('production_attachment')) {
                foreach ($request->file('production_attachment') as $file) {
                    $name = $request->name . 'production_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->production_attachment = json_encode($files);
        }
        if (!empty ($request->Warehouse_attachment)) {
            $files = [];
            if ($request->hasfile('Warehouse_attachment')) {
                foreach ($request->file('Warehouse_attachment') as $file) {
                    $name = $request->name . 'Warehouse_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Warehouse_attachment = json_encode($files);
        }
        if (!empty ($request->Quality_Control_attachment)) {
            $files = [];
            if ($request->hasfile('Quality_Control_attachment')) {
                foreach ($request->file('Quality_Control_attachment') as $file) {
                    $name = $request->name . 'Quality_Control_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Quality_Control_attachment = json_encode($files);
        }
        if (!empty ($request->Quality_Assurance_attachment)) {
            $files = [];
            if ($request->hasfile('Quality_Assurance_attachment')) {
                foreach ($request->file('Quality_Assurance_attachment') as $file) {
                    $name = $request->name . 'Quality_Assurance_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Quality_Assurance_attachment = json_encode($files);
        }
        if (!empty ($request->Engineering_attachment)) {
            $files = [];
            if ($request->hasfile('Engineering_attachment')) {
                foreach ($request->file('Engineering_attachment') as $file) {
                    $name = $request->name . 'Engineering_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Engineering_attachment = json_encode($files);
        }
        if (!empty ($request->Analytical_Development_attachment)) {
            $files = [];
            if ($request->hasfile('Analytical_Development_attachment')) {
                foreach ($request->file('Analytical_Development_attachment') as $file) {
                    $name = $request->name . 'Analytical_Development_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Analytical_Development_attachment = json_encode($files);
        }
        if (!empty ($request->Kilo_Lab_attachment)) {
            $files = [];
            if ($request->hasfile('Kilo_Lab_attachment')) {
                foreach ($request->file('Kilo_Lab_attachment') as $file) {
                    $name = $request->name . 'Kilo_Lab_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Kilo_Lab_attachment = json_encode($files);
        }
        if (!empty ($request->Technology_transfer_attachment)) {
            $files = [];
            if ($request->hasfile('Technology_transfer_attachment')) {
                foreach ($request->file('Technology_transfer_attachment') as $file) {
                    $name = $request->name . 'Technology_transfer_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Technology_transfer_attachment = json_encode($files);
        }
        if (!empty ($request->Environment_Health_Safety_attachment)) {
            $files = [];
            if ($request->hasfile('Environment_Health_Safety_attachment')) {
                foreach ($request->file('Environment_Health_Safety_attachment') as $file) {
                    $name = $request->name . 'Environment_Health_Safety_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Environment_Health_Safety_attachment = json_encode($files);
        }
        if (!empty ($request->Human_Resource_attachment)) {
            $files = [];
            if ($request->hasfile('Human_Resource_attachment')) {
                foreach ($request->file('Human_Resource_attachment') as $file) {
                    $name = $request->name . 'Human_Resource_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Human_Resource_attachment = json_encode($files);
        }
        if (!empty ($request->Information_Technology_attachment)) {
            $files = [];
            if ($request->hasfile('Information_Technology_attachment')) {
                foreach ($request->file('Information_Technology_attachment') as $file) {
                    $name = $request->name . 'Information_Technology_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Information_Technology_attachment = json_encode($files);
        }
        if (!empty ($request->Project_management_attachment)) {
            $files = [];
            if ($request->hasfile('Project_management_attachment')) {
                foreach ($request->file('Project_management_attachment') as $file) {
                    $name = $request->name . 'Project_management_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Project_management_attachment = json_encode($files);
        }
        if (!empty ($request->Other1_attachment)) {
            $files = [];
            if ($request->hasfile('Other1_attachment')) {
                foreach ($request->file('Other1_attachment') as $file) {
                    $name = $request->name . 'Other1_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Other1_attachment = json_encode($files);
        }
        if (!empty ($request->Other2_attachment)) {
            $files = [];
            if ($request->hasfile('Other2_attachment')) {
                foreach ($request->file('Other2_attachment') as $file) {
                    $name = $request->name . 'Other2_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Other2_attachment = json_encode($files);
        }
        if (!empty ($request->Other3_attachment)) {
            $files = [];
            if ($request->hasfile('Other3_attachment')) {
                foreach ($request->file('Other3_attachment') as $file) {
                    $name = $request->name . 'Other3_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Other3_attachment = json_encode($files);
        }
        if (!empty ($request->Other4_attachment)) {
            $files = [];
            if ($request->hasfile('Other4_attachment')) {
                foreach ($request->file('Other4_attachment') as $file) {
                    $name = $request->name . 'Other4_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Other4_attachment = json_encode($files);
        }
        if (!empty ($request->Other5_attachment)) {
            $files = [];
            if ($request->hasfile('Other5_attachment')) {
                foreach ($request->file('Other5_attachment') as $file) {
                    $name = $request->name . 'Other5_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Other5_attachment = json_encode($files);
        }


        $Cft->save();




        // -------------------------------------------------------
        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();
        
        if(!empty($root->division_code)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Division Code';
        $history->previous = "Null";
        $history->current = $root->division_code;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_from ="Initiator";
        $history->change_to ="Opened";
        $history->action_name ="Submit";        
        $history->save();
        }

    if(!empty($root->record_number)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Record Number';
        $history->previous = "Null";
        $history->current = $root->record_number;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_from ="Initiator";
        $history->change_to ="Opened";
        $history->action_name ="Submit";        
        $history->save();
        }
    if(!empty($root->initiator_id)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Initiator';
        $history->previous = "Null";
        $history->current = $root->initiator_id;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_from ="Initiator";
        $history->change_to ="Opened";
        $history->action_name ="Submit";        
        $history->save();
        }
        
        if(!empty($root->initiator_group)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Initiator Group';
        $history->previous = "Null";
        $history->current = $root->initiator_Group;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_from ="Initiator";
        $history->change_to ="Opened";
        $history->action_name ="Submit";  
        $history->save();
        }
    if(!empty($root->initiator_group_code)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Initiator Group Code';
        $history->previous = "Null";
        $history->current = $root->initiator_group_code;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_from ="Initiator";
        $history->change_to ="Opened";
        $history->action_name ="Submit";  
        $history->save();
        }
        
        if(!empty($root->short_description)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Short Description';
        $history->previous = "Null";
        $history->current = $root->short_description;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to ="Opened";
        $history->change_from ="Initiator";
        $history->action_name ="Submit"; 
        $history->save();
        }

    if(!empty($root->severity_level)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Severity Level';
        $history->previous = "Null";
        $history->current = $root->severity_level;
        $history->comment = "Null";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_to ="Opened";
        $history->change_from ="Initiator";
        $history->action_name ="Submit"; 
        $history->save();
        }
        if(!empty($root->assign_to)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Assign Id';
        $history->previous = "Null";
        $history->current = $root->assign_to;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_from ="Initiator";
        $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->due_date)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Due Date';
        $history->previous = "Null";
        $history->current = $root->due_date;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_from ="Initiator";
        $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }

        if(!empty($root->initiated_through)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Initiated Through';
        $history->previous = "Null";
        $history->current = $root->initiated_through;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_from ="Initiator";
        $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }

    if(!empty($root->priority_level)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Priority Level';
        $history->previous = "Null";
        $history->current = $root->priority_level;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_from ="Initiator";
        $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }

    if(!empty($root->department)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Department';
        $history->previous = "Null";
        $history->current = $root->department;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        $history->change_from ="Initiator";
        $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
        
        if(!empty($root->investigators)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Investigators';
        $history->previous = "Null";
        $history->current = $root->investigators;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->description)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Description';
        $history->previous = "Null";
        $history->current = $root->description;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }

        if(!empty($root->root_cause_initial_attachment)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Initial Attachment';
        $history->previous = "Null";
        $history->current = empty($root->root_cause_initial_attachment) ? null : $root->root_cause_initial_attachment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
        if(!empty($root->root_cause_initial_attachment)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Initial Attachment';
        $history->previous = "Null";
        $history->current = empty($root->root_cause_initial_attachment) ? null : $root->root_cause_initial_attachment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
        if(!empty($root->related_url)){
            $history = new RootAuditTrial();
            $history->root_id = $root->id;
            $history->activity_type = 'Related URL';
            $history->previous = "Null";
            $history->current = $root->related_url;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $root->status;
            // $history->change_from ="Initiator";
            // $history->change_to ="Opened";
            $history->action_name ="Submit";
            $history->save();
            }

        if(!empty($root->comments)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Comments';
        $history->previous = "Null";
        $history->current = $root->comments;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->root_cause_methodology)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Root Cause Methodology';
        $history->previous = "Null";
        $history->current = $root->root_cause_methodology;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->root_cause_description)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Root Cause Description';
        $history->previous = "Null";
        $history->current = $root->root_cause_description;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }

        if(!empty($root->investigation_summary)){
            $history = new RootAuditTrial();
            $history->root_id = $root->id;
            $history->activity_type = 'Investigation Summary';
            $history->previous = "Null";
            $history->current = $root->investigation_summary;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $root->status;
            // $history->change_from ="Initiator";
            // $history->change_to ="Opened";
            $history->action_name ="Submit";
            $history->save();
            }

        if(!empty($root->Production_Review)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Production Review Required ?';
        $history->previous = "Null";
        $history->current = $root->Production_Review;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }

    if(!empty($root->Production_person)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Production Person';
        $history->previous = "Null";
        $history->current = $root->Production_person;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }

    if(!empty($root->Production_assessment)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Impact Assessment (By Production)';
        $history->previous = "Null";
        $history->current = $root->Production_assessment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }

    if(!empty($root->Production_feedback)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Production Feedback';
        $history->previous = "Null";
        $history->current = $root->Production_feedback;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
        
        if(!empty($root->production_attachment)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Production Attachments';
        $history->previous = "Null";
        $history->current = $root->production_attachment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }

    if(!empty($root->production_review_completed_by)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Production Review Completed By';
        $history->previous = "Null";
        $history->current = $root->production_review_completed_by;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }

        if(!empty($root->production_on)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Production Review Completed On';
        $history->previous = "Null";
        $history->current = $root->production_on;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }

    if(!empty($root->Warehouse_review)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Warehouse Review Required ?';
        $history->previous = "Null";
        $history->current = $root->Warehouse_review;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }

    if(!empty($root->Warehouse_notification)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Warehouse Person';
        $history->previous = "Null";
        $history->current = $root->Warehouse_notification;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }

    if(!empty($root->Warehouse_assessment)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Impact Assessment (By Warehouse)';
        $history->previous = "Null";
        $history->current = $root->Warehouse_assessment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }

    if(!empty($root->Warehouse_feedback)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Warehouse Feedback';
        $history->previous = "Null";
        $history->current = $root->Warehouse_feedback;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
        
    if(!empty($root->Warehouse_attachment)){
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Warehouse Attachments';
        $history->previous = "Null";
        $history->current = $root->Warehouse_attachment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Warehouse_by)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Warehouse Review Completed By';
        $history->previous = "Null";
        $history->current = $root->Warehouse_by;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }

    if(!empty($root->Quality_review)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Quality Control Review Required?';
        $history->previous = "Null";
        $history->current = $root->Quality_review;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }

    if(!empty($root->Quality_Control_Person)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Quality Control Person';
        $history->previous = "Null";
        $history->current = $root->Quality_Control_Person;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }

    if(!empty($root->Quality_Control_assessment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Impact Assessment (By Quality Control)';
        $history->previous = "Null";
        $history->current = $root->Quality_Control_assessment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }

    if (!empty($root->Quality_Control_feedback)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Quality Control Feedback';
        $history->previous = "Null";
        $history->current = $root->Quality_Control_feedback;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }

    if (!empty($root->Quality_Control_attachment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Quality Control Attachments';
        $history->previous = "Null";
        $history->current = $root->Quality_Control_attachment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Quality_Control_by)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Quality Control Review Completed By';
        $history->previous = "Null";
        $history->current = $root->Quality_Control_by;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Quality_Assurance_Review)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Quality Assurance Review Required ?';
        $history->previous = "Null";
        $history->current = $root->Quality_Assurance_Review;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->QualityAssurance_person)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Quality Assurance Person';
        $history->previous = "Null";
        $history->current = $root->QualityAssurance_person;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->QualityAssurance_assessment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Impact Assessment (By Quality Assurance)';
        $history->previous = "Null";
        $history->current = $root->QualityAssurance_assessment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->QualityAssurance_feedback)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Quality Assurance Feedback';
        $history->previous = "Null";
        $history->current = $root->QualityAssurance_feedback;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Quality_Assurance_attachment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Quality Assurance Attachments';
        $history->previous = "Null";
        $history->current = $root->Quality_Assurance_attachment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->QualityAssurance_by)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Quality Assurance Review Completed By';
        $history->previous = "Null";
        $history->current = $root->QualityAssurance_by;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->QualityAssurance_on)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Quality Assurance Review Completed On';
        $history->previous = "Null";
        $history->current = $root->QualityAssurance_on;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Engineering_review)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Engineering Review Required ?';
        $history->previous = "Null";
        $history->current = $root->Engineering_review;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->QualityAssurance_on)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Quality Assurance Review Completed On';
        $history->previous = "Null";
        $history->current = $root->QualityAssurance_on;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Engineering_person)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Engineering  Person';
        $history->previous = "Null";
        $history->current = $root->Engineering_person;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Engineering_assessment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Impact Assessment (By Engineering)';
        $history->previous = "Null";
        $history->current = $root->Engineering_assessment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Engineering_feedback)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Engineering  Feedback';
        $history->previous = "Null";
        $history->current = $root->Engineering_feedback;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Engineering_attachment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Engineering  Attachments';
        $history->previous = "Null";
        $history->current = $root->Engineering_attachment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }

    if(!empty($root->Engineering_on)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Engineering Review Completed On';
        $history->previous = "Null";
        $history->current = $root->Engineering_on;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        } 
        
    if(!empty($root->Analytical_Development_review)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Analytical Development Laboratory Review Required ?';
        $history->previous = "Null";
        $history->current = $root->Analytical_Development_review;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        } 
    if(!empty($root->Analytical_Development_person)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Analytical Development Laboratory Person';
        $history->previous = "Null";
        $history->current = $root->Analytical_Development_person;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        } 
    if(!empty($root->Analytical_Development_assessment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Impact Assessment (By Analytical Development Laboratory)';
        $history->previous = "Null";
        $history->current = $root->Analytical_Development_assessment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Analytical_Development_feedback)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Analytical Development Laboratory Feedback';
        $history->previous = "Null";
        $history->current = $root->Analytical_Development_feedback;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Analytical_Development_attachment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Analytical Development Laboratory Attachments';
        $history->previous = "Null";
        $history->current = $root->Analytical_Development_attachment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Analytical_Development_by)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Analytical Development Laboratory Review Completed By';
        $history->previous = "Null";
        $history->current = $root->Analytical_Development_by;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Analytical_Development_on)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Analytical Development Laboratory Review Completed On';
        $history->previous = "Null";
        $history->current = $root->Analytical_Development_on;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Kilo_Lab_review)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Process Development Laboratory / Kilo Lab Review Required ?';
        $history->previous = "Null";
        $history->current = $root->Kilo_Lab_review;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Kilo_Lab_person)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Process Development Laboratory / Kilo Lab  Person';
        $history->previous = "Null";
        $history->current = $root->Kilo_Lab_person;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Kilo_Lab_assessment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Impact Assessment (By Process Development Laboratory / Kilo Lab)';
        $history->previous = "Null";
        $history->current = $root->Kilo_Lab_assessment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Kilo_Lab_feedback)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Process Development Laboratory / Kilo Lab  Feedback';
        $history->previous = "Null";
        $history->current = $root->Kilo_Lab_feedback;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Kilo_Lab_attachment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Process Development Laboratory / Kilo Lab Attachments';
        $history->previous = "Null";
        $history->current = $root->Kilo_Lab_attachment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Kilo_Lab_attachment_by)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Process Development Laboratory / Kilo Lab Review Completed By';
        $history->previous = "Null";
        $history->current = $root->Kilo_Lab_attachment_by;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Kilo_Lab_attachment_on)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Process Development Laboratory / Kilo Lab Review Completed On';
        $history->previous = "Null";
        $history->current = $root->Kilo_Lab_attachment_on;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Technology_transfer_review)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Technology Transfer / Design Review Required ?';
        $history->previous = "Null";
        $history->current = $root->Technology_transfer_review;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Technology_transfer_person)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Technology Transfer / Design  Person';
        $history->previous = "Null";
        $history->current = $root->Technology_transfer_person;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Technology_transfer_assessment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Impact Assessment (By Technology Transfer / Design)';
        $history->previous = "Null";
        $history->current = $root->Technology_transfer_assessment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Technology_transfer_feedback)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Technology Transfer / Design  Feedback';
        $history->previous = "Null";
        $history->current = $root->Technology_transfer_feedback;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Technology_transfer_attachment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Technology Transfer / Design Attachments';
        $history->previous = "Null";
        $history->current = $root->Technology_transfer_attachment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Technology_transfer_by)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Technology Transfer / Design Review Completed By';
        $history->previous = "Null";
        $history->current = $root->Technology_transfer_by;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Technology_transfer_on)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Technology Transfer / Design Review Completed On';
        $history->previous = "Null";
        $history->current = $root->Technology_transfer_on;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Environment_Health_review)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Environment, Health & Safety Review Required ?';
        $history->previous = "Null";
        $history->current = $root->Environment_Health_review;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Environment_Health_Safety_person)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Environment, Health & Safety  Person';
        $history->previous = "Null";
        $history->current = $root->Environment_Health_Safety_person;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Health_Safety_assessment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Impact Assessment (By Environment, Health & Safety)';
        $history->previous = "Null";
        $history->current = $root->Health_Safety_assessment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Health_Safety_feedback)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Environment, Health & Safety  Feedback';
        $history->previous = "Null";
        $history->current = $root->Health_Safety_feedback;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Environment_Health_Safety_attachment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Environment, Health & Safety Attachments';
        $history->previous = "Null";
        $history->current = $root->Environment_Health_Safety_attachment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Environment_Health_Safety_on)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Environment, Health & Safety Review Completed On';
        $history->previous = "Null";
        $history->current = $root->Environment_Health_Safety_on;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Human_Resource_review)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Human Resource & Administration Review Required ?';
        $history->previous = "Null";
        $history->current = $root->Human_Resource_review;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Human_Resource_person)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Human Resource & Administration  Person';
        $history->previous = "Null";
        $history->current = $root->Human_Resource_person;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Human_Resource_assessment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Impact Assessment (By Human Resource & Administration)';
        $history->previous = "Null";
        $history->current = $root->Human_Resource_assessment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Human_Resource_feedback)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Human Resource & Administration  Feedback';
        $history->previous = "Null";
        $history->current = $root->Human_Resource_feedback;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Human_Resource_attachment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Human Resource & Administration Attachments';
        $history->previous = "Null";
        $history->current = $root->Human_Resource_attachment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Human_Resource_by)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Human Resource & Administration Review Completed By';
        $history->previous = "Null";
        $history->current = $root->Human_Resource_by;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Environment_Health_Safety_on)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Human Resource & Administration Review Completed On';
        $history->previous = "Null";
        $history->current = $root->Environment_Health_Safety_on;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Information_Technology_review)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Information Technology Review Required ?';
        $history->previous = "Null";
        $history->current = $root->Information_Technology_review;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Information_Technology_person)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Information Technology  Person';
        $history->previous = "Null";
        $history->current = $root->Information_Technology_person;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Information_Technology_assessment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Impact Assessment (By Information Technology)';
        $history->previous = "Null";
        $history->current = $root->Information_Technology_assessment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Information_Technology_feedback)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Information Technology Feedback';
        $history->previous = "Null";
        $history->current = $root->Information_Technology_feedback;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Information_Technology_attachment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Information Technology Attachments';
        $history->previous = "Null";
        $history->current = $root->Information_Technology_attachment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Information_Technology_by)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Information Technology Review Completed By';
        $history->previous = "Null";
        $history->current = $root->Information_Technology_by;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Information_Technology_on)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Information Technology Review Completed On';
        $history->previous = "Null";
        $history->current = $root->Information_Technology_on;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Project_management_review)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Project management Review Required ?';
        $history->previous = "Null";
        $history->current = $root->Project_management_review;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Project_management_person)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Project management Person';
        $history->previous = "Null";
        $history->current = $root->Project_management_person;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Project_management_assessment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Impact Assessment (By  Project management )';
        $history->previous = "Null";
        $history->current = $root->Project_management_assessment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Project_management_feedback)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Project management  Feedback';
        $history->previous = "Null";
        $history->current = $root->Project_management_feedback;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Project_management_attachment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Project management Attachments';
        $history->previous = "Null";
        $history->current = $root->Project_management_attachment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Project_management_by)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Project management Review Completed By';
        $history->previous = "Null";
        $history->current = $root->Project_management_by;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Project_management_on)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Project management Review Completed On';
        $history->previous = "Null";
        $history->current = $root->Project_management_on;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other1_review)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 1 Review Required ?';
        $history->previous = "Null";
        $history->current = $root->Other1_review;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other1_Department_person)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 1 Department';
        $history->previous = "Null";
        $history->current = $root->Other1_Department_person;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other1_assessment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Impact Assessment (By  Others 1)';
        $history->previous = "Null";
        $history->current = $root->Other1_assessment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other1_feedback)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 1 Feedback';
        $history->previous = "Null";
        $history->current = $root->Other1_feedback;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other1_attachment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 1 Attachments';
        $history->previous = "Null";
        $history->current = $root->Other1_attachment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other1_by)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 1 Review Completed By';
        $history->previous = "Null";
        $history->current = $root->Other1_by;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other1_on)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 1 Review Completed On';
        $history->previous = "Null";
        $history->current = $root->Other1_on;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other2_review)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 2 Review Required ?';
        $history->previous = "Null";
        $history->current = $root->Other2_review;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other2_person)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 2 Person';
        $history->previous = "Null";
        $history->current = $root->Other2_person;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other2_Department_person)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 2 Department';
        $history->previous = "Null";
        $history->current = $root->Other2_Department_person;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other2_Assessment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Impact Assessment (By  Others 2)';
        $history->previous = "Null";
        $history->current = $root->Other2_Assessment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other2_feedback)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 2 Feedback';
        $history->previous = "Null";
        $history->current = $root->Other2_feedback;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other2_attachment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 2 Attachments';
        $history->previous = "Null";
        $history->current = $root->Other2_attachment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other2_by)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 2 Review Completed By';
        $history->previous = "Null";
        $history->current = $root->Other2_by;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other2_on)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 2 Review Completed On';
        $history->previous = "Null";
        $history->current = $root->Other2_on;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other3_review)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 3 Review Required ?';
        $history->previous = "Null";
        $history->current = $root->Other3_review;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other3_person)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 3 Person';
        $history->previous = "Null";
        $history->current = $root->Other3_person;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other3_Department_person)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 3 Department';
        $history->previous = "Null";
        $history->current = $root->Other3_Department_person;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other3_Assessment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Impact Assessment (By  Others 3)';
        $history->previous = "Null";
        $history->current = $root->Other3_Assessment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other3_feedback)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 3 Feedback';
        $history->previous = "Null";
        $history->current = $root->Other3_feedback;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other3_attachment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 3 Attachments';
        $history->previous = "Null";
        $history->current = $root->Other3_attachment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other3_by)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 3 Review Completed By';
        $history->previous = "Null";
        $history->current = $root->Other3_by;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other3_on)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 3 Review Completed On';
        $history->previous = "Null";
        $history->current = $root->Other3_on;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other4_review)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 4 Review Required ?';
        $history->previous = "Null";
        $history->current = $root->Other4_review;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other4_person)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 4 Person';
        $history->previous = "Null";
        $history->current = $root->Other4_person;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other4_Department_person)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 4 Department';
        $history->previous = "Null";
        $history->current = $root->Other4_Department_person;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other4_Assessment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Impact Assessment (By  Others 4)';
        $history->previous = "Null";
        $history->current = $root->Other4_Assessment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other4_feedback)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 4 Feedback';
        $history->previous = "Null";
        $history->current = $root->Other4_feedback;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other4_attachment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 4 Attachments';
        $history->previous = "Null";
        $history->current = $root->Other4_attachment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other4_by)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 4 Review Completed By';
        $history->previous = "Null";
        $history->current = $root->Other4_by;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other4_on)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 4 Review Completed On';
        $history->previous = "Null";
        $history->current = $root->Other4_on;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other5_review)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 5 Review Required ?';
        $history->previous = "Null";
        $history->current = $root->Other5_review;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other5_person)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 5 Person';
        $history->previous = "Null";
        $history->current = $root->Other5_person;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other5_Department_person)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 5 Department';
        $history->previous = "Null";
        $history->current = $root->Other5_Department_person;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other5_Assessment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Impact Assessment (By  Others 5)';
        $history->previous = "Null";
        $history->current = $root->Other5_Assessment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other5_feedback)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 5 Feedback';
        $history->previous = "Null";
        $history->current = $root->Other5_feedback;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other5_attachment)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 5 Attachments';
        $history->previous = "Null";
        $history->current = $root->Other5_attachment;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other5_by)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 5 Review Completed By';
        $history->previous = "Null";
        $history->current = $root->Other5_by;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->Other5_on)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Others 5 Review Completed On';
        $history->previous = "Null";
        $history->current = $root->Other5_on;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->cft_comments_new)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Final Comments';
        $history->previous = "Null";
        $history->current = $root->cft_comments_new;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
    if(!empty($root->cft_attchament_new)) {
        $history = new RootAuditTrial();
        $history->root_id = $root->id;
        $history->activity_type = 'Final Attachment';
        $history->previous = "Null";
        $history->current = $root->cft_attchament_new;
        $history->comment = "NA";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $root->status;
        // $history->change_from ="Initiator";
        // $history->change_to ="Opened";
        $history->action_name ="Submit";
        $history->save();
        }
            
        toastr()->success("Record is created Successfully");
        return redirect(url('rcms/qms-dashboard'));
    }
    public function root_update(Request $request, $id)
    {
        if (!$request->short_description) {
            toastr()->error("Short description is required");
            return redirect()->back();
        }
        $lastDocument =  RootCauseAnalysis::find($id);
        $root =  RootCauseAnalysis::find($id);
        $root->initiator_Group = $request->initiator_Group;
        $root->initiated_through = $request->initiated_through;
        $root->initiated_if_other = ($request->initiated_if_other);
        $root->short_description = $request->short_description;
        $root->due_date = $request->due_date;
        $root->severity_level= $request->severity_level;
        $root->Type= ($request->Type);
        $root->priority_level = ($request->priority_level);
        $root->department = ($request->department);
        $root->description = ($request->description);
        $root->investigation_summary = ($request->investigation_summary);
        $root->root_cause_description = ($request->root_cause_description);
        $root->cft_comments_new = ($request->cft_comments_new);
       
         $root->investigators = ($request->investigators);
        $root->related_url = ($request->related_url);
        // $root->investigators = implode(',', $request->investigators);
        $root->root_cause_methodology = implode(',', $request->root_cause_methodology);
        // $root->country = ($request->country);
        $root->assign_to = $request->assign_to;
        $root->Sample_Types = $request->Sample_Types;
         
        // Root Cause +
        if (!empty($request->Root_Cause_Category  )) {
            $root->Root_Cause_Category = serialize($request->Root_Cause_Category);
        }
        if (!empty($request->Root_Cause_Sub_Category)) {
            $root->Root_Cause_Sub_Category= serialize($request->Root_Cause_Sub_Category);
        }
        if (!empty($request->Probability)) {
            $root->Probability = serialize($request->Probability);
        }
        if (!empty($request->Remarks)) {
            $root->Remarks = serialize($request->Remarks);
        }
        if (!empty($request->why_problem_statement)) {
            $root->why_problem_statement = $request->why_problem_statement;
        } 
        if (!empty($request->why_1  )) {
            $root->why_1 = serialize($request->why_1);
        }
        if (!empty($request->why_2  )) {
            $root->why_2 = serialize($request->why_2);
        }
        if (!empty($request->why_3  )) {
            $root->why_3 = serialize($request->why_3);
        }
        if (!empty($request->why_4 )) {
            $root->why_4 = serialize($request->why_4);
        }
        if (!empty($request->why_5  )) {
            $root->why_5 = serialize($request->why_5);
        }
        if (!empty($request->why_root_cause)) {
            $root->why_root_cause = $request->why_root_cause;
        }

         // Is/Is Not Analysis (Launch Instruction)
         $root->what_will_be = ($request->what_will_be);
         $root->what_will_not_be = ($request->what_will_not_be);
         $root->what_rationable = ($request->what_rationable);
 
         $root->where_will_be = ($request->where_will_be);
         $root->where_will_not_be = ($request->where_will_not_be);
         $root->where_rationable = ($request->where_rationable);
 
         $root->when_will_be = ($request->when_will_be);
         $root->when_will_not_be = ($request->when_will_not_be);
         $root->when_rationable = ($request->when_rationable);
 
         $root->coverage_will_be = ($request->coverage_will_be);
         $root->coverage_will_not_be = ($request->coverage_will_not_be);
         $root->coverage_rationable = ($request->coverage_rationable);
 
         $root->who_will_be = ($request->who_will_be);
         $root->who_will_not_be = ($request->who_will_not_be);
         $root->who_rationable = ($request->who_rationable);
         
        if (!empty($request->root_cause_initial_attachment)) {
            $files = [];
            if ($request->hasfile('root_cause_initial_attachment')) {
                foreach ($request->file('root_cause_initial_attachment') as $file) {
                    $name = $request->name . 'root_cause_initial_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $root->root_cause_initial_attachment = json_encode($files);
        }

        if (!empty($request->cft_attchament_new)) {
            $files = [];
            if ($request->hasfile('cft_attchament_new')) {
                foreach ($request->file('cft_attchament_new') as $file) {
                    $name = $request->name . 'cft_attchament_new' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $root->cft_attchament_new = json_encode($files);
        }

        
        // $root->investigators = json_encode($request->investigators);
        $root->submitted_by = $request->submitted_by;
        
        $root->comments = $request->comments;
        $root->lab_inv_concl = $request->lab_inv_concl;
        //Failure Mode and Effect Analysis+

        if (!empty($request->risk_factor)) {
            $root->risk_factor = serialize($request->risk_factor);
        }
        if (!empty($request->risk_element)) {
            $root->risk_element = serialize($request->risk_element);
        }
        if (!empty($request->problem_cause)) {
            $root->problem_cause = serialize($request->problem_cause);
        }
        if (!empty($request->existing_risk_control)) {
            $root->existing_risk_control = serialize($request->existing_risk_control);
        }
        if (!empty($request->initial_severity)) {
            $root->initial_severity = serialize($request->initial_severity);
        }
        if (!empty($request->initial_detectability)) {
            $root->initial_detectability = serialize($request->initial_detectability);
        }
        if (!empty($request->initial_probability)) {
            $root->initial_probability = serialize($request->initial_probability);
        }
        if (!empty($request->initial_rpn)) {
            $root->initial_rpn = serialize($request->initial_rpn);
        }
        if (!empty($request->risk_acceptance)) {
            $root->risk_acceptance = serialize($request->risk_acceptance);
        }
        if (!empty($request->risk_control_measure)) {
            $root->risk_control_measure = serialize($request->risk_control_measure);
        }
        if (!empty($request->residual_severity)) {
            $root->residual_severity = serialize($request->residual_severity);
        }
        if (!empty($request->residual_probability)) {
            $root->residual_probability = serialize($request->residual_probability);
        }
        if (!empty($request->residual_detectability)) {
            $root->residual_detectability = serialize($request->residual_detectability);
        }
        if (!empty($request->residual_rpn)) {
            $root->residual_rpn = serialize($request->residual_rpn);
        }
        if (!empty($request->risk_acceptance2)) {
            $root->risk_acceptance2 = serialize($request->risk_acceptance2);
        }
        if (!empty($request->mitigation_proposal)) {
            $root->mitigation_proposal = serialize($request->mitigation_proposal);
        }

        // Fishbone or Ishikawa Diagram +  (Launch Instruction)

        if (!empty($request->measurement)) {
            $root->measurement = serialize($request->measurement);
        }
        if (!empty($request->materials)) {
            $root->materials = serialize($request->materials);
        }
        if (!empty($request->methods)) {
            $root->methods = serialize($request->methods);
        }
        if (!empty($request->environment)) {
            $root->environment = serialize($request->environment);
        }
        if (!empty($request->manpower)) {
            $root->manpower = serialize($request->manpower);
        }
        if (!empty($request->machine)) {
            $root->machine = serialize($request->machine);
        }
        if (!empty($request->problem_statement)) {
            $root->problem_statement = $request->problem_statement;
        }
        $root->update(); 
    
        $Cft = RootCft::withoutTrashed()->where('root_id', $id)->first();
        // dd($Cft);
        $Cft->Production_Review = $request->Production_Review;
        $Cft->Production_person = $request->Production_person;
        $Cft->Production_assessment = $request->Production_assessment;
        $Cft->Production_feedback = $request->Production_feedback;
        $Cft->production_on = $request->production_on;
        $Cft->production_by = $request->production_by; 

        $Cft->Warehouse_review = $request->Warehouse_review;
        $Cft->Warehouse_notification = $request->Warehouse_notification;
        $Cft->Warehouse_assessment = $request->Warehouse_assessment;
        $Cft->Warehouse_feedback = $request->Warehouse_feedback;
        $Cft->Warehouse_by = $request->Warehouse_Review_Completed_By;
        $Cft->Warehouse_on = $request->Warehouse_on;

        $Cft->Quality_review = $request->Quality_review;
        $Cft->Quality_Control_Person = $request->Quality_Control_Person;
        $Cft->Quality_Control_assessment = $request->Quality_Control_assessment;
        $Cft->Quality_Control_feedback = $request->Quality_Control_feedback;
        $Cft->Quality_Control_by = $request->Quality_Control_by;
        $Cft->Quality_Control_on = $request->Quality_Control_on;

        $Cft->Quality_Assurance_Review = $request->Quality_Assurance_Review;
        $Cft->QualityAssurance_person = $request->QualityAssurance_person;
        $Cft->QualityAssurance_assessment = $request->QualityAssurance_assessment;
        $Cft->QualityAssurance_feedback = $request->QualityAssurance_feedback;
        $Cft->QualityAssurance_by = $request->QualityAssurance_by;
        $Cft->QualityAssurance_on = $request->QualityAssurance_on;

        $Cft->Engineering_review = $request->Engineering_review;
        $Cft->Engineering_person = $request->Engineering_person;
        $Cft->Engineering_assessment = $request->Engineering_assessment;
        $Cft->Engineering_feedback = $request->Engineering_feedback;
        $Cft->Engineering_by = $request->Engineering_by;
        $Cft->Engineering_on = $request->Engineering_on;

        $Cft->Analytical_Development_review = $request->Analytical_Development_review;
        $Cft->Analytical_Development_person = $request->Analytical_Development_person;
        $Cft->Analytical_Development_assessment = $request->Analytical_Development_assessment;
        $Cft->Analytical_Development_feedback = $request->Analytical_Development_feedback;
        $Cft->Analytical_Development_by = $request->Analytical_Development_by;
        $Cft->Analytical_Development_on = $request->Analytical_Development_on;

        $Cft->Kilo_Lab_review = $request->Kilo_Lab_review;
        $Cft->Kilo_Lab_person = $request->Kilo_Lab_person;
        $Cft->Kilo_Lab_assessment = $request->Kilo_Lab_assessment;
        $Cft->Kilo_Lab_feedback = $request->Kilo_Lab_feedback;
        $Cft->Kilo_Lab_attachment_by = $request->Kilo_Lab_attachment_by;
        $Cft->Kilo_Lab_attachment_on = $request->Kilo_Lab_attachment_on;

        $Cft->Technology_transfer_review = $request->Technology_transfer_review;
        $Cft->Technology_transfer_person = $request->Technology_transfer_person;
        $Cft->Technology_transfer_assessment = $request->Technology_transfer_assessment;
        $Cft->Technology_transfer_feedback = $request->Technology_transfer_feedback;
        $Cft->Technology_transfer_by = $request->Technology_transfer_by;
        $Cft->Technology_transfer_on = $request->Technology_transfer_on;

        $Cft->Environment_Health_review = $request->Environment_Health_review;
        $Cft->Environment_Health_Safety_person = $request->Environment_Health_Safety_person;
        $Cft->Health_Safety_assessment = $request->Health_Safety_assessment;
        $Cft->Health_Safety_feedback = $request->Health_Safety_feedback;
        $Cft->Environment_Health_Safety_by = $request->Environment_Health_Safety_by;
        $Cft->Environment_Health_Safety_on = $request->Environment_Health_Safety_on;

        $Cft->Human_Resource_review = $request->Human_Resource_review;
        $Cft->Human_Resource_person = $request->Human_Resource_person;
        $Cft->Human_Resource_assessment = $request->Human_Resource_assessment;
        $Cft->Human_Resource_feedback = $request->Human_Resource_feedback;
        $Cft->Human_Resource_by = $request->Human_Resource_by;
        $Cft->Human_Resource_on = $request->Human_Resource_on;

        $Cft->Information_Technology_review = $request->Information_Technology_review;
        $Cft->Information_Technology_person = $request->Information_Technology_person;
        $Cft->Information_Technology_assessment = $request->Information_Technology_assessment;
        $Cft->Information_Technology_feedback = $request->Information_Technology_feedback;
        $Cft->Information_Technology_by = $request->Information_Technology_by;
        $Cft->Information_Technology_on = $request->Information_Technology_on;

        $Cft->Project_management_review = $request->Project_management_review;
        $Cft->Project_management_person = $request->Project_management_person;
        $Cft->Project_management_assessment = $request->Project_management_assessment;
        $Cft->Project_management_feedback = $request->Project_management_feedback;
        $Cft->Project_management_by = $request->Project_management_by;
        $Cft->Project_management_on = $request->Project_management_on;

        $Cft->Other1_review = $request->Other1_review;
        $Cft->Other1_person = $request->Other1_person;
        $Cft->Other1_Department_person = $request->Other1_Department_person;
        $Cft->Other1_assessment = $request->Other1_assessment;
        $Cft->Other1_feedback = $request->Other1_feedback;
        $Cft->Other1_by = $request->Other1_by;
        $Cft->Other1_on = $request->Other1_on;

        $Cft->Other2_review = $request->Other2_review;
        $Cft->Other2_person = $request->Other2_person;
        $Cft->Other2_Department_person = $request->Other2_Department_person;
        $Cft->Other2_Assessment = $request->Other2_Assessment;
        $Cft->Other2_feedback = $request->Other2_feedback;
        $Cft->Other2_by = $request->Other2_by;
        $Cft->Other2_on = $request->Other2_on;

        $Cft->Other3_review = $request->Other3_review;
        $Cft->Other3_person = $request->Other3_person;
        $Cft->Other3_Department_person = $request->Other3_Department_person;
        $Cft->Other3_Assessment = $request->Other3_Assessment;
        $Cft->Other3_feedback = $request->Other3_feedback;
        $Cft->Other3_by = $request->Other3_by;
        $Cft->Other3_on = $request->Other3_on;

        $Cft->Other4_review = $request->Other4_review;
        $Cft->Other4_person = $request->Other4_person;
        $Cft->Other4_Department_person = $request->Other4_Department_person;
        $Cft->Other4_Assessment = $request->Other4_Assessment;
        $Cft->Other4_feedback = $request->Other4_feedback;
        $Cft->Other4_by = $request->Other4_by;
        $Cft->Other4_on = $request->Other4_on;

        $Cft->Other5_review = $request->Other5_review;
        $Cft->Other5_person = $request->Other5_person;
        $Cft->Other5_Department_person = $request->Other5_Department_person;
        $Cft->Other5_Assessment = $request->Other5_Assessment;
        $Cft->Other5_feedback = $request->Other5_feedback;
        $Cft->Other5_by = $request->Other5_by;
        $Cft->Other5_on = $request->Other5_on;

        if (!empty ($request->production_attachment)) {
            $files = [];
            if ($request->hasfile('production_attachment')) {
                foreach ($request->file('production_attachment') as $file) {
                    $name = $request->name . 'production_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->production_attachment = json_encode($files);
        }
        if (!empty ($request->Warehouse_attachment)) {
            $files = [];
            if ($request->hasfile('Warehouse_attachment')) {
                foreach ($request->file('Warehouse_attachment') as $file) {
                    $name = $request->name . 'Warehouse_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Warehouse_attachment = json_encode($files);
        }
        if (!empty ($request->Quality_Control_attachment)) {
            $files = [];
            if ($request->hasfile('Quality_Control_attachment')) {
                foreach ($request->file('Quality_Control_attachment') as $file) {
                    $name = $request->name . 'Quality_Control_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Quality_Control_attachment = json_encode($files);
        }
        if (!empty ($request->Quality_Assurance_attachment)) {
            $files = [];
            if ($request->hasfile('Quality_Assurance_attachment')) {
                foreach ($request->file('Quality_Assurance_attachment') as $file) {
                    $name = $request->name . 'Quality_Assurance_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Quality_Assurance_attachment = json_encode($files);
        }
        if (!empty ($request->Engineering_attachment)) {
            $files = [];
            if ($request->hasfile('Engineering_attachment')) {
                foreach ($request->file('Engineering_attachment') as $file) {
                    $name = $request->name . 'Engineering_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Engineering_attachment = json_encode($files);
        }
        if (!empty ($request->Analytical_Development_attachment)) {
            $files = [];
            if ($request->hasfile('Analytical_Development_attachment')) {
                foreach ($request->file('Analytical_Development_attachment') as $file) {
                    $name = $request->name . 'Analytical_Development_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Analytical_Development_attachment = json_encode($files);
        }
        if (!empty ($request->Kilo_Lab_attachment)) {
            $files = [];
            if ($request->hasfile('Kilo_Lab_attachment')) {
                foreach ($request->file('Kilo_Lab_attachment') as $file) {
                    $name = $request->name . 'Kilo_Lab_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Kilo_Lab_attachment = json_encode($files);
        }
        if (!empty ($request->Technology_transfer_attachment)) {
            $files = [];
            if ($request->hasfile('Technology_transfer_attachment')) {
                foreach ($request->file('Technology_transfer_attachment') as $file) {
                    $name = $request->name . 'Technology_transfer_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Technology_transfer_attachment = json_encode($files);
        }
        if (!empty ($request->Environment_Health_Safety_attachment)) {
            $files = [];
            if ($request->hasfile('Environment_Health_Safety_attachment')) {
                foreach ($request->file('Environment_Health_Safety_attachment') as $file) {
                    $name = $request->name . 'Environment_Health_Safety_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Environment_Health_Safety_attachment = json_encode($files);
        }
        if (!empty ($request->Human_Resource_attachment)) {
            $files = [];
            if ($request->hasfile('Human_Resource_attachment')) {
                foreach ($request->file('Human_Resource_attachment') as $file) {
                    $name = $request->name . 'Human_Resource_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Human_Resource_attachment = json_encode($files);
        }
        if (!empty ($request->Information_Technology_attachment)) {
            $files = [];
            if ($request->hasfile('Information_Technology_attachment')) {
                foreach ($request->file('Information_Technology_attachment') as $file) {
                    $name = $request->name . 'Information_Technology_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Information_Technology_attachment = json_encode($files);
        }
        if (!empty ($request->Project_management_attachment)) {
            $files = [];
            if ($request->hasfile('Project_management_attachment')) {
                foreach ($request->file('Project_management_attachment') as $file) {
                    $name = $request->name . 'Project_management_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Project_management_attachment = json_encode($files);
        }
        if (!empty ($request->Other1_attachment)) {
            $files = [];
            if ($request->hasfile('Other1_attachment')) {
                foreach ($request->file('Other1_attachment') as $file) {
                    $name = $request->name . 'Other1_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Other1_attachment = json_encode($files);
        }
        if (!empty ($request->Other2_attachment)) {
            $files = [];
            if ($request->hasfile('Other2_attachment')) {
                foreach ($request->file('Other2_attachment') as $file) {
                    $name = $request->name . 'Other2_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Other2_attachment = json_encode($files);
        }
        if (!empty ($request->Other3_attachment)) {
            $files = [];
            if ($request->hasfile('Other3_attachment')) {
                foreach ($request->file('Other3_attachment') as $file) {
                    $name = $request->name . 'Other3_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Other3_attachment = json_encode($files);
        }
        if (!empty ($request->Other4_attachment)) {
            $files = [];
            if ($request->hasfile('Other4_attachment')) {
                foreach ($request->file('Other4_attachment') as $file) {
                    $name = $request->name . 'Other4_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Other4_attachment = json_encode($files);
        }
        if (!empty ($request->Other5_attachment)) {
            $files = [];
            if ($request->hasfile('Other5_attachment')) {
                foreach ($request->file('Other5_attachment') as $file) {
                    $name = $request->name . 'Other5_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Other5_attachment = json_encode($files);
        }
    

    $Cft->save();
    



        if ($lastDocument->division_code != $root->division_code || !empty($request->division_code_comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Division Code';
            $history->previous = $lastDocument->division_code;
            $history->current = $root->division_code;
            $history->comment = $request->division_code_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->record_number != $root->record_number || !empty($request->record_number_comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Record Number';
            $history->previous = $lastDocument->record_number;
            $history->current = $root->record_number;
            $history->comment = $request->record_number_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->initiator_id != $root->initiator_id || !empty($request->initiator_id_comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Record Number';
            $history->previous = $lastDocument->initiator_id;
            $history->current = $root->initiator_id;
            $history->comment = $request->initiator_id_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->initiator_Group != $root->initiator_Group || !empty($request->initiator_Group_comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Initiator Group';
            $history->previous = $lastDocument->initiator_Group;
            $history->current = $root->initiator_Group;
            $history->comment = $request->initiator_Group_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->initiator_group_code != $root->initiator_group_code || !empty($request->initiator_group_code_comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Initiator Group Code';
            $history->previous = $lastDocument->initiator_group_code;
            $history->current = $root->initiator_group_code;
            $history->comment = $request->initiator_group_code_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->short_description != $root->short_description || !empty($request->short_description_comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastDocument->short_description;
            $history->current = $root->short_description;
            $history->comment = $request->short_description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->severity_level != $root->severity_level || !empty($request->severity_level_comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Severity Level';
            $history->previous = $lastDocument->severity_level;
            $history->current = $root->severity_level;
            $history->comment = $request->severity_level_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->assign_to != $root->assign_to || !empty($request->assign_to_comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Assign Id';
            $history->previous = $lastDocument->assign_to;
            $history->current = $root->assign_to;
            $history->comment = $request->assign_to_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->due_date != $root->due_date || !empty($request->due_date_comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Due Date';
            $history->previous = $lastDocument->due_date;
            $history->current = $root->due_date;
            $history->comment = $request->due_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->initiated_through != $root->initiated_through || !empty($request->initiated_through_comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Initiated Through';
            $history->previous = $lastDocument->initiated_through;
            $history->current = $root->initiated_through;
            $history->comment = $request->initiated_through_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->priority_level != $root->priority_level || !empty($request->priority_level_comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Priority Level';
            $history->previous = $lastDocument->priority_level;
            $history->current = $root->priority_level;
            $history->comment = $request->priority_level_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->department != $root->department || !empty($request->department_comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Department';
            $history->previous = $lastDocument->department;
            $history->current = $root->department;
            $history->comment = $request->department_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->investigators != $root->investigators || !empty($request->investigators_comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Investigators';
            $history->previous = $lastDocument->investigators;
            $history->current = $root->investigators;
            $history->comment = $request->investigators_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->description != $root->description || !empty($request->description_comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Description';
            $history->previous = $lastDocument->description;
            $history->current = $root->description;
            $history->comment = $request->description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->root_cause_initial_attachment != $root->root_cause_initial_attachment || !empty($request->root_cause_initial_attachment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Initial Attachment';;
            $history->previous = $lastDocument->root_cause_initial_attachment;
            $history->current = $root->root_cause_initial_attachment;
            $history->comment = $request->root_cause_initial_attachment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;

            $history->save();
        }
        
        if ($lastDocument->comments != $root->comments || !empty($request->comments_comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Comments';
            $history->previous = $lastDocument->comments;
            $history->current = $root->comments;
            $history->comment = $request->comments_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->related_url != $root->related_url || !empty($request->related_url_comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Related URL';
            $history->previous = $lastDocument->related_url;
            $history->current = $root->related_url;
            $history->comment = $request->related_url_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->root_cause_methodology != $root->root_cause_methodology || !empty($request->root_cause_methodology)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Root Cause Methodology';
            $history->previous = $lastDocument->root_cause_methodology;
            $history->current = $root->root_cause_methodology;
            $history->comment = $request->root_cause_methodology_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->root_cause_description != $root->root_cause_description || !empty($request->root_cause_description)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Root Cause Description';
            $history->previous = $lastDocument->root_cause_description;
            $history->current = $root->root_cause_description;
            $history->comment = $request->root_cause_description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->investigation_summary != $root->investigation_summary || !empty($request->investigation_summary_comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Investigation Summary';
            $history->previous = $lastDocument->investigation_summary;
            $history->current = $root->investigation_summary;
            $history->comment = $request->investigation_summary_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Production_Review != $root->Production_Review || !empty($request->Production_Review_comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Production Review Required ?';
            $history->previous = $lastDocument->Production_Review;
            $history->current = $root->Production_Review;
            $history->comment = $request->Production_Review_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Production_person != $root->inv_aProduction_personttach || !empty($request->Production_person_comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Production Person';
            $history->previous = $lastDocument->Production_person;
            $history->current = $root->inv_attaProduction_personch;
            $history->comment = $request->Production_person_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Production_assessment != $root->Production_assessment || !empty($request->Production_assessment_comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Impact Assessment (By Production)';
            $history->previous = $lastDocument->Production_assessment;
            $history->current = $root->Production_assessment;
            $history->comment = $request->Production_assessment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Production_feedback != $root->Production_feedback || !empty($request->Production_feedback_comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Production Feedback';
            $history->previous = $lastDocument->Production_feedback;
            $history->current = $root->Production_feedback;
            $history->comment = $request->Production_feedback_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }

        if ($lastDocument->production_review_completed_by != $root->production_review_completed_by || !empty($request->production_review_completed_by_comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Production Review Completed By';
            $history->previous = $lastDocument->production_review_completed_by;
            $history->current = $root->production_review_completed_by;
            $history->comment = $request->production_review_completed_by_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->production_on != $root->production_on || !empty($request->production_on_comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Production Review Completed On';
            $history->previous = $lastDocument->production_on;
            $history->current = $root->production_on;
            $history->comment = $request->production_on_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Warehouse_review != $root->Warehouse_review || !empty($request->Warehouse_review_comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Warehouse Review Required ?';
            $history->previous = $lastDocument->Warehouse_review;
            $history->current = $root->Warehouse_review;
            $history->comment = $request->Warehouse_review_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
        if ($lastDocument->Warehouse_notification != $root->Warehouse_notification || !empty($request->Warehouse_notification_comment)) {

            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Warehouse Person';
            $history->previous = $lastDocument->Warehouse_notification;
            $history->current = $root->Warehouse_notification;
            $history->comment = $request->Warehouse_notification_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->save();
        }
    if ($lastDocument->Warehouse_assessment != $root->Warehouse_assessment || !empty($request->Warehouse_assessment_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Impact Assessment (By Warehouse)';
        $history->previous = $lastDocument->Warehouse_assessment;
        $history->current = $root->Warehouse_assessment;
        $history->comment = $request->Warehouse_assessment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
        }
    if ($lastDocument->Warehouse_feedback != $root->Warehouse_feedback || !empty($request->Warehouse_feedback_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Production Feedback';
        $history->previous = $lastDocument->Warehouse_feedback;
        $history->current = $root->Warehouse_feedback;
        $history->comment = $request->Warehouse_feedback_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Warehouse_attachment != $root->Warehouse_attachment || !empty($request->Warehouse_attachment_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Warehouse Attachments';
        $history->previous = $lastDocument->Warehouse_attachment;
        $history->current = $root->Warehouse_attachment;
        $history->comment = $request->Warehouse_attachment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Warehouse_by != $root->Warehouse_by || !empty($request->Warehouse_by_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Warehouse Review Completed By';
        $history->previous = $lastDocument->Warehouse_by;
        $history->current = $root->Warehouse_by;
        $history->comment = $request->Warehouse_by_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Quality_review != $root->Quality_review || !empty($request->Quality_review_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Quality Control Review Required?';
        $history->previous = $lastDocument->Quality_review;
        $history->current = $root->Quality_review;
        $history->comment = $request->Quality_review_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Quality_Control_Person != $root->Quality_Control_Person || !empty($request->Quality_Control_Person_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Quality Control Person';
        $history->previous = $lastDocument->Quality_Control_Person;
        $history->current = $root->Quality_Control_Person;
        $history->comment = $request->Quality_Control_Person_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Quality_Control_assessment != $root->Quality_Control_assessment || !empty($request->Quality_Control_assessment_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Impact Assessment (By Quality Control)';
        $history->previous = $lastDocument->Quality_Control_assessment;
        $history->current = $root->Quality_Control_assessment;
        $history->comment = $request->Quality_Control_assessment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Quality_Control_feedback != $root->Quality_Control_feedback || !empty($request->Quality_Control_feedback_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Quality Control Feedback';
        $history->previous = $lastDocument->Quality_Control_feedback;
        $history->current = $root->Quality_Control_feedback;
        $history->comment = $request->Quality_Control_feedback_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Quality_Control_attachment != $root->Quality_Control_attachment || !empty($request->Quality_Control_attachment_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Quality Control Attachments';
        $history->previous = $lastDocument->Quality_Control_attachment;
        $history->current = $root->Quality_Control_attachment;
        $history->comment = $request->Quality_Control_attachment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Quality_Control_by != $root->Quality_Control_by || !empty($request->Quality_Control_by_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Quality Control Review Completed By';
        $history->previous = $lastDocument->Quality_Control_by;
        $history->current = $root->Quality_Control_by;
        $history->comment = $request->Quality_Control_by_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Quality_Assurance_Review != $root->Quality_Assurance_Review || !empty($request->Quality_Assurance_Review_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Quality Assurance Review Required ?';
        $history->previous = $lastDocument->Quality_Assurance_Review;
        $history->current = $root->Quality_Assurance_Review;
        $history->comment = $request->Quality_Assurance_Review_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->QualityAssurance_person != $root->QualityAssurance_person || !empty($request->QualityAssurance_person_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Quality Assurance Person';
        $history->previous = $lastDocument->QualityAssurance_person;
        $history->current = $root->QualityAssurance_person;
        $history->comment = $request->QualityAssurance_person_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Quality_Assurance_attachment != $root->Quality_Assurance_attachment || !empty($request->Quality_Assurance_attachment_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Quality Assurance Attachments';
        $history->previous = $lastDocument->Quality_Assurance_attachment;
        $history->current = $root->Quality_Assurance_attachment;
        $history->comment = $request->Quality_Assurance_attachment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->QualityAssurance_by != $root->QualityAssurance_by || !empty($request->QualityAssurance_by_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Quality Assurance Review Completed By';
        $history->previous = $lastDocument->QualityAssurance_by;
        $history->current = $root->QualityAssurance_by;
        $history->comment = $request->QualityAssurance_by_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->QualityAssurance_on != $root->QualityAssurance_on || !empty($request->QualityAssurance_on_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Quality Assurance Review Completed On';
        $history->previous = $lastDocument->QualityAssurance_on;
        $history->current = $root->QualityAssurance_on;
        $history->comment = $request->QualityAssurance_on_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Engineering_review != $root->Engineering_review || !empty($request->Engineering_review_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Engineering Review Required ?';
        $history->previous = $lastDocument->Engineering_review;
        $history->current = $root->Engineering_review;
        $history->comment = $request->Engineering_review_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->QualityAssurance_on != $root->QualityAssurance_on || !empty($request->QualityAssurance_on_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Quality Assurance Review Completed On';
        $history->previous = $lastDocument->Engineering_review;
        $history->current = $root->QualityAssurance_on;
        $history->comment = $request->QualityAssurance_on_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Engineering_person != $root->Engineering_person || !empty($request->Engineering_person_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Engineering  Person';
        $history->previous = $lastDocument->Engineering_person;
        $history->current = $root->Engineering_person;
        $history->comment = $request->Engineering_person_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Engineering_assessment != $root->Engineering_assessment || !empty($request->Engineering_assessment_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Impact Assessment (By Engineering)';
        $history->previous = $lastDocument->Engineering_assessment;
        $history->current = $root->Engineering_assessment;
        $history->comment = $request->Engineering_assessment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Engineering_feedback != $root->Engineering_feedback || !empty($request->Engineering_feedback_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Engineering  Feedback';
        $history->previous = $lastDocument->Engineering_feedback;
        $history->current = $root->Engineering_feedback;
        $history->comment = $request->Engineering_feedback_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Engineering_attachment != $root->Engineering_attachment || !empty($request->Engineering_attachment_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Engineering  Attachments';
        $history->previous = $lastDocument->Engineering_attachment;
        $history->current = $root->Engineering_attachment;
        $history->comment = $request->Engineering_attachment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Engineering_on != $root->Engineering_on || !empty($request->Engineering_on_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Engineering Review Completed On';
        $history->previous = $lastDocument->Engineering_on;
        $history->current = $root->Engineering_on;
        $history->comment = $request->Engineering_on_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Analytical_Development_review != $root->Analytical_Development_review || !empty($request->Analytical_Development_review_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Analytical Development Laboratory Review Required ?';
        $history->previous = $lastDocument->Analytical_Development_review;
        $history->current = $root->Analytical_Development_review;
        $history->comment = $request->Analytical_Development_review_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Analytical_Development_person != $root->Analytical_Development_person || !empty($request->Analytical_Development_person_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Analytical Development Laboratory Person';
        $history->previous = $lastDocument->Analytical_Development_person;
        $history->current = $root->Analytical_Development_person;
        $history->comment = $request->Analytical_Development_person;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Analytical_Development_assessment != $root->Analytical_Development_assessment || !empty($request->Analytical_Development_assessment_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Impact Assessment (By Analytical Development Laboratory)';
        $history->previous = $lastDocument->Analytical_Development_assessment;
        $history->current = $root->Analytical_Development_assessment;
        $history->comment = $request->Analytical_Development_assessment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Analytical_Development_feedback != $root->Analytical_Development_feedback || !empty($request->Analytical_Development_feedback_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Analytical Development Laboratory Feedback';
        $history->previous = $lastDocument->Analytical_Development_feedback;
        $history->current = $root->Analytical_Development_feedback;
        $history->comment = $request->Analytical_Development_feedback_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Analytical_Development_attachment != $root->Analytical_Development_attachment || !empty($request->Analytical_Development_attachment_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Analytical Development Laboratory Attachments';
        $history->previous = $lastDocument->Analytical_Development_attachment;
        $history->current = $root->Analytical_Development_attachment;
        $history->comment = $request->Analytical_Development_attachment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Analytical_Development_by != $root->Analytical_Development_by || !empty($request->Analytical_Development_by_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Analytical Development Laboratory Review Completed By';
        $history->previous = $lastDocument->Analytical_Development_by;
        $history->current = $root->Analytical_Development_by;
        $history->comment = $request->Analytical_Development_by_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Analytical_Development_on != $root->Analytical_Development_on || !empty($request->Analytical_Development_on_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Analytical Development Laboratory Review Completed On';
        $history->previous = $lastDocument->Analytical_Development_on;
        $history->current = $root->Analytical_Development_on;
        $history->comment = $request->Analytical_Development_on_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Kilo_Lab_review != $root->Kilo_Lab_review || !empty($request->Kilo_Lab_review_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Process Development Laboratory / Kilo Lab Review Required ?';
        $history->previous = $lastDocument->Kilo_Lab_review;
        $history->current = $root->Kilo_Lab_review;
        $history->comment = $request->Kilo_Lab_review_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Kilo_Lab_person != $root->Kilo_Lab_person || !empty($request->Kilo_Lab_person_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Process Development Laboratory / Kilo Lab  Person';
        $history->previous = $lastDocument->Kilo_Lab_person;
        $history->current = $root->Kilo_Lab_person;
        $history->comment = $request->Kilo_Lab_person_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Kilo_Lab_assessment != $root->Kilo_Lab_assessment || !empty($request->Kilo_Lab_assessment_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Impact Assessment (By Process Development Laboratory / Kilo Lab)';
        $history->previous = $lastDocument->Kilo_Lab_assessment;
        $history->current = $root->Kilo_Lab_assessment;
        $history->comment = $request->Kilo_Lab_assessment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Kilo_Lab_feedback != $root->Kilo_Lab_feedback || !empty($request->Kilo_Lab_feedback_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Process Development Laboratory / Kilo Lab  Feedback';
        $history->previous = $lastDocument->Kilo_Lab_feedback;
        $history->current = $root->Kilo_Lab_feedback;
        $history->comment = $request->Kilo_Lab_feedback_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Kilo_Lab_attachment != $root->Kilo_Lab_attachment || !empty($request->Kilo_Lab_attachment_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Process Development Laboratory / Kilo Lab Attachments';
        $history->previous = $lastDocument->Kilo_Lab_attachment;
        $history->current = $root->Kilo_Lab_attachment;
        $history->comment = $request->Kilo_Lab_attachment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Kilo_Lab_attachment_by != $root->Kilo_Lab_attachment_by || !empty($request->Kilo_Lab_attachment_by_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Process Development Laboratory / Kilo Lab Review Completed By';
        $history->previous = $lastDocument->Kilo_Lab_attachment_by;
        $history->current = $root->Kilo_Lab_attachment_by;
        $history->comment = $request->Kilo_Lab_attachment_by_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Kilo_Lab_attachment_on != $root->Kilo_Lab_attachment_on || !empty($request->Kilo_Lab_attachment_on_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Process Development Laboratory / Kilo Lab Review Completed On';
        $history->previous = $lastDocument->Kilo_Lab_attachment_on;
        $history->current = $root->Kilo_Lab_attachment_on;
        $history->comment = $request->Kilo_Lab_attachment_on_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Technology_transfer_review != $root->Technology_transfer_review || !empty($request->Technology_transfer_review_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Technology Transfer / Design Review Required ?';
        $history->previous = $lastDocument->Technology_transfer_review;
        $history->current = $root->Technology_transfer_review;
        $history->comment = $request->Technology_transfer_review_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Technology_transfer_person != $root->Technology_transfer_person || !empty($request->Technology_transfer_person_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Technology Transfer / Design  Person';
        $history->previous = $lastDocument->Technology_transfer_person;
        $history->current = $root->Technology_transfer_person;
        $history->comment = $request->Technology_transfer_person_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Technology_transfer_assessment != $root->Technology_transfer_assessment || !empty($request->Technology_transfer_assessment_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Impact Assessment (By Technology Transfer / Design) ';
        $history->previous = $lastDocument->Technology_transfer_assessment;
        $history->current = $root->Technology_transfer_assessment;
        $history->comment = $request->Technology_transfer_assessment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Technology_transfer_feedback != $root->Technology_transfer_feedback || !empty($request->Technology_transfer_feedback_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Technology Transfer / Design  Feedback';
        $history->previous = $lastDocument->Technology_transfer_feedback;
        $history->current = $root->Technology_transfer_feedback;
        $history->comment = $request->Technology_transfer_feedback_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Technology_transfer_on != $root->Technology_transfer_on || !empty($request->Technology_transfer_on_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Technology Transfer / Design Review Completed On';
        $history->previous = $lastDocument->Technology_transfer_on;
        $history->current = $root->Technology_transfer_on;
        $history->comment = $request->Technology_transfer_on_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Environment_Health_review != $root->Environment_Health_review || !empty($request->Environment_Health_review_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Environment, Health & Safety Review Required ?';
        $history->previous = $lastDocument->Environment_Health_review;
        $history->current = $root->Environment_Health_review;
        $history->comment = $request->Environment_Health_review_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Environment_Health_Safety_person != $root->Environment_Health_Safety_person || !empty($request->Environment_Health_Safety_person_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Environment, Health & Safety  Person';
        $history->previous = $lastDocument->Environment_Health_Safety_person;
        $history->current = $root->Environment_Health_Safety_person;
        $history->comment = $request->Environment_Health_Safety_person_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Health_Safety_assessment != $root->Health_Safety_assessment || !empty($request->Health_Safety_assessment_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Impact Assessment (By Environment, Health & Safety)';
        $history->previous = $lastDocument->Health_Safety_assessment;
        $history->current = $root->Health_Safety_assessment;
        $history->comment = $request->Health_Safety_assessment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Health_Safety_feedback != $root->Health_Safety_feedback || !empty($request->Health_Safety_feedback_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Environment, Health & Safety  Feedback';
        $history->previous = $lastDocument->Health_Safety_feedback;
        $history->current = $root->Health_Safety_feedback;
        $history->comment = $request->Health_Safety_feedback_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Environment_Health_Safety_attachment != $root->Environment_Health_Safety_attachment || !empty($request->Environment_Health_Safety_attachment_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Environment, Health & Safety Attachments';
        $history->previous = $lastDocument->Environment_Health_Safety_attachment;
        $history->current = $root->Environment_Health_Safety_attachment;
        $history->comment = $request->Environment_Health_Safety_attachment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Environment_Health_Safety_on != $root->Environment_Health_Safety_on || !empty($request->Environment_Health_Safety_on_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Environment, Health & Safety Review Completed On';
        $history->previous = $lastDocument->Environment_Health_Safety_on;
        $history->current = $root->Environment_Health_Safety_on;
        $history->comment = $request->Environment_Health_Safety_on_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Human_Resource_review != $root->Human_Resource_review || !empty($request->Human_Resource_review_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Human Resource & Administration Review Required ?';
        $history->previous = $lastDocument->Human_Resource_review;
        $history->current = $root->Human_Resource_review;
        $history->comment = $request->Human_Resource_review_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Human_Resource_person != $root->Human_Resource_person || !empty($request->Human_Resource_person_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Human Resource & Administration  Person';
        $history->previous = $lastDocument->Human_Resource_person;
        $history->current = $root->Human_Resource_person;
        $history->comment = $request->Human_Resource_person_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Human_Resource_assessment != $root->Human_Resource_assessment || !empty($request->Human_Resource_assessment_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Impact Assessment (By Human Resource & Administration)';
        $history->previous = $lastDocument->Human_Resource_assessment;
        $history->current = $root->Human_Resource_assessment;
        $history->comment = $request->Human_Resource_assessment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Human_Resource_feedback != $root->Human_Resource_feedback || !empty($request->Human_Resource_feedback_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Human Resource & Administration  Feedback';
        $history->previous = $lastDocument->Human_Resource_feedback;
        $history->current = $root->Human_Resource_feedback;
        $history->comment = $request->Human_Resource_feedback_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Human_Resource_attachment != $root->Human_Resource_attachment || !empty($request->Human_Resource_attachment_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Human Resource & Administration Attachments';
        $history->previous = $lastDocument->Human_Resource_attachment;
        $history->current = $root->Human_Resource_attachment;
        $history->comment = $request->Human_Resource_attachment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Human_Resource_by != $root->Human_Resource_by || !empty($request->Human_Resource_by)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Human Resource & Administration Review Completed By';
        $history->previous = $lastDocument->Human_Resource_by;
        $history->current = $root->Human_Resource_by;
        $history->comment = $request->Human_Resource_by_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Human_Resource_on != $root->Human_Resource_on || !empty($request->Human_Resource_on)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Human Resource & Administration Review Completed On';
        $history->previous = $lastDocument->Human_Resource_on;
        $history->current = $root->Human_Resource_on;
        $history->comment = $request->Human_Resource_on_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Information_Technology_review != $root->Information_Technology_review || !empty($request->Information_Technology_review_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Information Technology Review Required ?';
        $history->previous = $lastDocument->Information_Technology_review;
        $history->current = $root->Information_Technology_review;
        $history->comment = $request->Information_Technology_review_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Information_Technology_person != $root->Information_Technology_person || !empty($request->Information_Technology_person_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Information Technology  Person';
        $history->previous = $lastDocument->Information_Technology_person;
        $history->current = $root->Information_Technology_person;
        $history->comment = $request->Information_Technology_person_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Information_Technology_assessment != $root->Information_Technology_assessment || !empty($request->Information_Technology_assessment_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Impact Assessment (By Information Technology)';
        $history->previous = $lastDocument->Information_Technology_assessment;
        $history->current = $root->Information_Technology_assessment;
        $history->comment = $request->Information_Technology_assessment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Information_Technology_feedback != $root->Information_Technology_feedback || !empty($request->Information_Technology_feedback_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Information Technology Feedback';
        $history->previous = $lastDocument->Information_Technology_feedback;
        $history->current = $root->Information_Technology_feedback;
        $history->comment = $request->Information_Technology_feedback_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Information_Technology_attachment != $root->Information_Technology_attachment || !empty($request->Information_Technology_attachment_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Information Technology Attachments';
        $history->previous = $lastDocument->Information_Technology_attachment;
        $history->current = $root->Information_Technology_attachment;
        $history->comment = $request->Information_Technology_attachment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Information_Technology_by != $root->Information_Technology_by || !empty($request->Information_Technology_by_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Information Technology Review Completed By';
        $history->previous = $lastDocument->Information_Technology_by;
        $history->current = $root->Information_Technology_by;
        $history->comment = $request->Information_Technology_by_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Information_Technology_on != $root->Information_Technology_on || !empty($request->Information_Technology_on_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Information Technology Review Completed On';
        $history->previous = $lastDocument->Information_Technology_on;
        $history->current = $root->Information_Technology_on;
        $history->comment = $request->Information_Technology_on_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Project_management_review != $root->Project_management_review || !empty($request->Project_management_review_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Project management Review Required ?';
        $history->previous = $lastDocument->Project_management_review;
        $history->current = $root->Project_management_review;
        $history->comment = $request->Project_management_review_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Project_management_person != $root->Project_management_person || !empty($request->Project_management_person_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Project management Person';
        $history->previous = $lastDocument->Project_management_person;
        $history->current = $root->Project_management_person;
        $history->comment = $request->Project_management_person_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Project_management_assessment != $root->Project_management_assessment || !empty($request->Project_management_assessment_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Impact Assessment (By  Project management )';
        $history->previous = $lastDocument->Project_management_assessment;
        $history->current = $root->Project_management_assessment;
        $history->comment = $request->Project_management_assessment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Project_management_feedback != $root->Project_management_feedback || !empty($request->Project_management_feedback_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Project management  Feedback';
        $history->previous = $lastDocument->Project_management_feedback;
        $history->current = $root->Project_management_feedback;
        $history->comment = $request->Project_management_feedback_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Project_management_attachment != $root->Project_management_attachment || !empty($request->Project_management_attachment_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Project management Attachments';
        $history->previous = $lastDocument->Project_management_attachment;
        $history->current = $root->Project_management_attachment;
        $history->comment = $request->Project_management_attachment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Project_management_by != $root->Project_management_by || !empty($request->Project_management_by_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Project management Review Completed By';
        $history->previous = $lastDocument->Project_management_by;
        $history->current = $root->Project_management_by;
        $history->comment = $request->Project_management_by_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Project_management_on != $root->Project_management_on || !empty($request->Project_management_on_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Project management Review Completed On';
        $history->previous = $lastDocument->Project_management_on;
        $history->current = $root->Project_management_on;
        $history->comment = $request->Project_management_on_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other1_review != $root->Other1_review || !empty($request->Other1_review_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others 1 Review Required ?';
        $history->previous = $lastDocument->Other1_review;
        $history->current = $root->Other1_review;
        $history->comment = $request->Other1_review_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other1_review != $root->Other1_review || !empty($request->Other1_review_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others 1 Department';
        $history->previous = $lastDocument->Other1_review;
        $history->current = $root->Other1_review;
        $history->comment = $request->Other1_review_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other1_assessment != $root->Other1_assessment || !empty($request->Other1_assessment_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Impact Assessment (By  Others 1)';
        $history->previous = $lastDocument->Other1_assessment;
        $history->current = $root->Other1_assessment;
        $history->comment = $request->Other1_assessment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other1_feedback != $root->Other1_feedback || !empty($request->Other1_feedback_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others 1 Feedback';
        $history->previous = $lastDocument->Other1_feedback;
        $history->current = $root->Other1_feedback;
        $history->comment = $request->Other1_feedback_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other1_by != $root->Other1_by || !empty($request->Other1_by_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others 1 Review Completed By';
        $history->previous = $lastDocument->Other1_by;
        $history->current = $root->Other1_by;
        $history->comment = $request->Other1_by_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other1_on != $root->Other1_on || !empty($request->Other1_on_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others 1 Review Completed On';
        $history->previous = $lastDocument->Other1_on;
        $history->current = $root->Other1_on;
        $history->comment = $request->Other1_on_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other2_review != $root->Other2_review || !empty($request->Other2_review_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others 2 Review Required ?';
        $history->previous = $lastDocument->Other2_review;
        $history->current = $root->Other2_review;
        $history->comment = $request->Other2_review_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other2_review != $root->Other2_review || !empty($request->Other2_review_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others 2 Department';
        $history->previous = $lastDocument->Other2_review;
        $history->current = $root->Other2_review;
        $history->comment = $request->Other2_review_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other2_assessment != $root->Other2_assessment || !empty($request->Other2_assessment_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Impact Assessment (By  Others 2)';
        $history->previous = $lastDocument->Other2_assessment;
        $history->current = $root->Other2_assessment;
        $history->comment = $request->Other2_assessment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other2_feedback != $root->Other2_feedback || !empty($request->Other2_feedback_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others 2 Feedback';
        $history->previous = $lastDocument->Other2_feedback;
        $history->current = $root->Other2_feedback;
        $history->comment = $request->Other2_feedback_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other2_by != $root->Other2_by || !empty($request->Other2_by_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others 2 Review Completed By';
        $history->previous = $lastDocument->Other2_by;
        $history->current = $root->Other2_by;
        $history->comment = $request->Other2_by_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other2_on != $root->Other2_on || !empty($request->Other2_on_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others 2 Review Completed On';
        $history->previous = $lastDocument->Other2_on;
        $history->current = $root->Other2_on;
        $history->comment = $request->Other2_on_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other3_review != $root->Other3_review || !empty($request->Other3_review_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others 3 Review Required ?';
        $history->previous = $lastDocument->Other3_review;
        $history->current = $root->Other3_review;
        $history->comment = $request->Other3_review_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other3_review != $root->Other3_review || !empty($request->Other3_review_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others 3 Department';
        $history->previous = $lastDocument->Other3_review;
        $history->current = $root->Other3_review;
        $history->comment = $request->Other3_review_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other3_assessment != $root->Other3_assessment || !empty($request->Other3_assessment_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Impact Assessment (By  Others 2)';
        $history->previous = $lastDocument->Other3_assessment;
        $history->current = $root->Other3_assessment;
        $history->comment = $request->Other3_assessment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other3_feedback != $root->Other3_feedback || !empty($request->Other3_feedback_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others 3 Feedback';
        $history->previous = $lastDocument->Other3_feedback;
        $history->current = $root->Other3_feedback;
        $history->comment = $request->Other3_feedback_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other3_by != $root->Other3_by || !empty($request->Other3_by_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others 3 Review Completed By';
        $history->previous = $lastDocument->Other3_by;
        $history->current = $root->Other3_by;
        $history->comment = $request->Other3_by_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other3_on != $root->Other3_on || !empty($request->Other3_on_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others 3 Review Completed On';
        $history->previous = $lastDocument->Other3_on;
        $history->current = $root->Other3_on;
        $history->comment = $request->Other3_on_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other4_review != $root->Other4_review || !empty($request->Other4_review_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others 4 Review Required ?';
        $history->previous = $lastDocument->Other4_review;
        $history->current = $root->Other4_review;
        $history->comment = $request->Other4_review_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other4_review != $root->Other4_review || !empty($request->Other4_review_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others 4 Department';
        $history->previous = $lastDocument->Other4_review;
        $history->current = $root->Other4_review;
        $history->comment = $request->Other4_review_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other4_assessment != $root->Other4_assessment || !empty($request->Other4_assessment_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Impact Assessment (By  Others 2)';
        $history->previous = $lastDocument->Other4_assessment;
        $history->current = $root->Other4_assessment;
        $history->comment = $request->Other4_assessment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other4_feedback != $root->Other4_feedback || !empty($request->Other4_feedback_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others 4 Feedback';
        $history->previous = $lastDocument->Other4_feedback;
        $history->current = $root->Other4_feedback;
        $history->comment = $request->Other4_feedback_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other4_by != $root->Other4_by || !empty($request->Other4_by_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others 4 Review Completed By';
        $history->previous = $lastDocument->Other4_by;
        $history->current = $root->Other4_by;
        $history->comment = $request->Other4_by_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other4_on != $root->Other4_on || !empty($request->Other4_on_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others 4 Review Completed On';
        $history->previous = $lastDocument->Other4_on;
        $history->current = $root->Other4_on;
        $history->comment = $request->Other4_on_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other5_review != $root->Other5_review || !empty($request->Other5_review_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others 5 Review Required ?';
        $history->previous = $lastDocument->Other5_review;
        $history->current = $root->Other5_review;
        $history->comment = $request->Other5_review_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other5_review != $root->Other5_review || !empty($request->Other5_review_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others 5 Department';
        $history->previous = $lastDocument->Other4_review;
        $history->current = $root->Other5_review;
        $history->comment = $request->Other5_review_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other5_assessment != $root->Other5_assessment || !empty($request->Other5_assessment_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Impact Assessment (By  Others 2)';
        $history->previous = $lastDocument->Other5_assessment;
        $history->current = $root->Other5_assessment;
        $history->comment = $request->Other5_assessment_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other5_feedback != $root->Other5_feedback || !empty($request->Other5_feedback_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others 5 Feedback';
        $history->previous = $lastDocument->Other5_feedback;
        $history->current = $root->Other5_feedback;
        $history->comment = $request->Other5_feedback_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other5_by != $root->Other5_by || !empty($request->Other5_by_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others 5 Review Completed By';
        $history->previous = $lastDocument->Other5_by;
        $history->current = $root->Other5_by;
        $history->comment = $request->Other5_by_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    if ($lastDocument->Other5_on != $root->Other5_on || !empty($request->Other5_on_comment)) {

        $history = new RootAuditTrial();
        $history->root_id = $id;
        $history->activity_type = 'Others 5 Review Completed On';
        $history->previous = $lastDocument->Other5_on;
        $history->current = $root->Other5_on;
        $history->comment = $request->Other5_on_comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->save();
    }
    
        toastr()->success("Record is update Successfully");
        return back();
    }
    public function root_show($id)
    {
        $old_record = RootCauseAnalysis::select('id', 'division_id', 'record')->get();
        $data = RootCauseAnalysis::find($id);
        $data1 = RootCft::where('root_id', $id)->first();
        // if(empty($data)) {
        //     toastr()->error('Invalid ID.');
        //     return back();
        // }
        $data->record = str_pad($data->record, 4, '0', STR_PAD_LEFT);
        $data->assign_to_name = User::where('id', $data->assign_to)->value('name');
        $data->initiator_name = User::where('id', $data->initiator_id)->value('name');
          return view('frontend.root-cause-analysis.root_cause_analysisView', compact('data','old_record','data1'));
    }


//===========================================Stage=============================================================//

    public function root_send_stage(Request $request, $id)
    {


        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $root = RootCauseAnalysis::find($id);
            $lastDocument =  RootCauseAnalysis::find($id);

            if ($root->stage == 1) {
                $root->stage = "2";
                $root->status = "HOD Review";
                $root->hod_review_complete_by= Auth::user()->name;
                $root->hod_review_complete_on= Carbon::now()->format('d-M-Y');
                $root->update();

                $history = new RootAuditTrial();
                $history->root_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->acknowledge_by;
                $history->current = $root->acknowledge_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='Plan Proposed';

                $history->save();
            //    $list = Helpers::getQAUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $root->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //              if ($email !== null) {
                        
                      
            //               Mail::send(
            //                   'mail.view-mail',
            //                    ['data' => $root],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document sent ".Auth::user()->name);
            //                 }
            //               );
            //             }
            //      } 
            //   }
            //     $root->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($root->stage == 2) {
                $root->stage = "3";
                $root->status = 'Responsible Person Update';
                $root->responsible_person_update_by = Auth::user()->name;
                $root->responsible_person_update_on = Carbon::now()->format('d-M-Y');
                $history = new RootAuditTrial();
                $history->root_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->submitted_by;
                $history->current = $root->submitted_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='';

                $history->save();
             //   $list = Helpers::getQAUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $root->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //              if ($email !== null) {
                        
                      
            //               Mail::send(
            //                   'mail.view-mail',
            //                    ['data' => $root],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document sent ".Auth::user()->name);
            //                 }
            //               );
            //             }
            //      } 
            //   }
                $root->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($root->stage == 3) {
                $root->stage = "4";
                $root->status = "Initial QA Review";
                $root->initial_qa_review_by = Auth::user()->name;
                $root->initial_qa_review_on = Carbon::now()->format('d-M-Y');
                $history = new RootAuditTrial();
                $history->root_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->submitted_by;
                $history->current = $root->submitted_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='';
                $history->save();
             //   $list = Helpers::getQAUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $root->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //              if ($email !== null) {
                        
                      
            //               Mail::send(
            //                   'mail.view-mail',
            //                    ['data' => $root],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document sent ".Auth::user()->name);
            //                 }
            //               );
            //             }
            //      } 
            //   }
                $root->update();
                 toastr()->success('Document Sent');
                return back();
              }
              if ($root->stage == 4) {
                  $root->stage = "5";
                $root->status = 'CFT Review';
                $root->cft_review_by = Auth::user()->name;
                $root->cft_review_on = Carbon::now()->format('d-M-Y');
                $history = new RootAuditTrial();
                $history->root_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->submitted_by;
                $history->current = $root->submitted_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='';
                $history->save();
            //     $list = Helpers::getQAUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $root->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //              if ($email !== null) {
                        
                      
            //               Mail::send(
            //                   'mail.view-mail',
            //                    ['data' => $root],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document sent ".Auth::user()->name);
            //                 }
            //               );
            //             }
            //      } 
            //   }
                $root->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($root->stage == 5) {
                $root->stage = "6";
                $root->status = "QA Approve Review";
                $root->qa_approve_review_by = Auth::user()->name;
                $root->qa_approve_review_on = Carbon::now()->format('d-M-Y');
                $history = new RootAuditTrial();
                $history->root_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->qA_review_complete_by;
                $history->current = $root->qA_review_complete_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='';
                $history->save();
            //     $list = Helpers::getQAUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $root->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //              if ($email !== null) {
                        
                      
            //               Mail::send(
            //                   'mail.view-mail',
            //                    ['data' => $root],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document sent ".Auth::user()->name);
            //                 }
            //               );
            //             }
            //      } 
            //   }
                $root->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($root->stage == 6) {
                $root->stage = "7";
                $root->status = " ";
                $root->hod_final_review_by = Auth::user()->name;
                $root->hod_final_review_on = Carbon::now()->format('d-M-Y');
                $history = new RootAuditTrial();
                $history->root_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->evaluation_complete_by;
                $history->current = $root->evaluation_complete_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='';
                $history->save();
            //     $list = Helpers::getQAUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $root->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //              if ($email !== null) {
                        
                      
            //               Mail::send(
            //                   'mail.view-mail',
            //                    ['data' => $root],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document sent ".Auth::user()->name);
            //                 }
            //               );
            //             }
            //      } 
            //   }
                $root->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($root->stage == 7) {
                $root->stage = "8";
                $root->status = "Child Closure";
                $root->child_closure_by = Auth::user()->name;
                $root->child_closure_on = Carbon::now()->format('d-M-Y');
                $history = new RootAuditTrial();
                $history->root_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->evaluation_complete_by;
                $history->current = $root->evaluation_complete_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='';
                $history->save();
            //     $list = Helpers::getQAUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $root->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //              if ($email !== null) {
                        
                      
            //               Mail::send(
            //                   'mail.view-mail',
            //                    ['data' => $root],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document sent ".Auth::user()->name);
            //                 }
            //               );
            //             }
            //      } 
            //   }
                $root->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($root->stage == 8) {
                $root->stage = "9";
                $root->status = " QA Head Review";
                $root->qa_head_review_by = Auth::user()->name;
                $root->qa_head_review_on = Carbon::now()->format('d-M-Y');
                $history = new RootAuditTrial();
                $history->root_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->evaluation_complete_by;
                $history->current = $root->evaluation_complete_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='';
                $history->save();
             //   $list = Helpers::getQAUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $root->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //              if ($email !== null) {
                        
                      
            //               Mail::send(
            //                   'mail.view-mail',
            //                    ['data' => $root],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document sent ".Auth::user()->name);
            //                 }
            //               );
            //             }
            //      } 
            //   }
                $root->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($root->stage == 9) {
                $root->stage = "10";
                $root->status = " Close-Done";
                $root->close_done_by = Auth::user()->name;
                $root->close_done_on = Carbon::now()->format('d-M-Y');
                $history = new RootAuditTrial();
                $history->root_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->evaluation_complete_by;
                $history->current = $root->evaluation_complete_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='';
                $history->save();
                $root->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($root->stage == 10) {
                $root->stage = "11";
                $root->status = "Re-open Addendum";
                $root->re_open_addendum_by = Auth::user()->name;
                $root->re_open_addendum_on = Carbon::now()->format('d-M-Y');
                $history = new RootAuditTrial();
                $history->root_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->evaluation_complete_by;
                $history->current = $root->evaluation_complete_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='';
                $history->save();
            //     $list = Helpers::getQAUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $root->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //              if ($email !== null) {
                        
                      
            //               Mail::send(
            //                   'mail.view-mail',
            //                    ['data' => $root],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document sent ".Auth::user()->name);
            //                 }
            //               );
            //             }
            //      } 
            //   }
                $root->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($root->stage == 11) {
                $root->stage = "12";
                $root->status = "Addendum Approved";
                $root->addendum_approved_by = Auth::user()->name;
                $root->addendum_approved_on = Carbon::now()->format('d-M-Y');
                $history = new RootAuditTrial();
                $history->root_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->evaluation_complete_by;
                $history->current = $root->evaluation_complete_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='';
                $history->save();
            //     $list = Helpers::getQAUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $root->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //              if ($email !== null) {
                        
                      
            //               Mail::send(
            //                   'mail.view-mail',
            //                    ['data' => $root],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document sent ".Auth::user()->name);
            //                 }
            //               );
            //             }
            //      } 
            //   }
                $root->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($root->stage == 12) {
                $root->stage = "13";
                $root->status = "Under Addendum Execution";
                $root->under_addendum_execution_by = Auth::user()->name;
                $root->under_addendum_execution_on = Carbon::now()->format('d-M-Y');
                $history = new RootAuditTrial();
                $history->root_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->evaluation_complete_by;
                $history->current = $root->evaluation_complete_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='';
                $history->save();
            //     $list = Helpers::getQAUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $root->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //              if ($email !== null) {
                        
                      
            //               Mail::send(
            //                   'mail.view-mail',
            //                    ['data' => $root],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document sent ".Auth::user()->name);
            //                 }
            //               );
            //             }
            //      } 
            //   }
                $root->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($root->stage == 13) {
                $root->stage = "14";
                $root->status = "Re-open Child Close";
                $root->re_open_child_close_by = Auth::user()->name;
                $root->re_open_child_close_on = Carbon::now()->format('d-M-Y');
                $history = new RootAuditTrial();
                $history->root_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->evaluation_complete_by;
                $history->current = $root->evaluation_complete_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='';
                $history->save();
            //     $list = Helpers::getQAUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $root->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //              if ($email !== null) {
                        
                      
            //               Mail::send(
            //                   'mail.view-mail',
            //                    ['data' => $root],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document sent ".Auth::user()->name);
            //                 }
            //               );
            //             }
            //      } 
            //   }
                $root->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($root->stage == 14) {
                $root->stage = "15";
                $root->status = "Under Addendum Verification";
                $root->under_addendum_verification_by = Auth::user()->name;
                $root->under_addendum_verification_on = Carbon::now()->format('d-M-Y');
                $history = new RootAuditTrial();
                $history->root_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->evaluation_complete_by;
                $history->current = $root->evaluation_complete_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='';
                $history->save();
            //     $list = Helpers::getQAUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $root->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //              if ($email !== null) {
                        
                      
            //               Mail::send(
            //                   'mail.view-mail',
            //                    ['data' => $root],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document sent ".Auth::user()->name);
            //                 }
            //               );
            //             }
            //      } 
            //   }
                $root->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($root->stage == 15) {
                $root->stage = "16";
                $root->status = "Closed-Done";
                $root->closed_done_by = Auth::user()->name;
                $root->closed_done_on = Carbon::now()->format('d-M-Y');
                $history = new RootAuditTrial();
                $history->root_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->evaluation_complete_by;
                $history->current = $root->evaluation_complete_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage='';
                $history->save();
                $root->update();
                toastr()->success('Document Sent');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }
//==================================================================Cancel-Modal==================================================//

    public function root_Cancel(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $root = RootCauseAnalysis::find($id);
            $lastDocument =  RootCauseAnalysis::find($id);
            $data =  RootCauseAnalysis::find($id);

            $root->stage = "0";
            $root->status = "Closed-Cancelled";
            $root->cancelled_by = Auth::user()->name;
            $root->cancelled_on = Carbon::now()->format('d-M-Y');
            $history = new RootAuditTrial();
            $history->root_id = $id;
            $history->activity_type = 'Activity Log';
            // $history->previous = $lastDocument->cancelled_by;
            $history->current = $root->cancelled_by;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
             $history->origin_state = $lastDocument->status;
            $history->stage='Cancelled ';
            $history->save();
            $list = Helpers::getQAUserList();
            foreach ($list as $u) {
                if($u->q_m_s_divisions_id == $root->division_id){
                    $email = Helpers::getInitiatorEmail($u->user_id);
                     if ($email !== null) {
                  
                      Mail::send(
                          'mail.view-mail',
                           ['data' => $root],
                        function ($message) use ($email) {
                            $message->to($email)
                                ->subject("Document sent ".Auth::user()->name);
                        }
                      );
                    }
             } 
          }
            $root->update();
            $history = new RootCauseAnalysisHistory();
            $history->type = "Root Cause Analysis";
            $history->doc_id = $id;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->stage_id = $root->stage;
            $history->status = $root->status;
            $history->save();
            toastr()->success('Document Sent');
            return back();
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }
    //=============================================reject-modal============================================//

    public function root_reject(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $capa = RootCauseAnalysis::find($id);

            if ($capa->stage == 2) {
                $capa->stage = "1";
                $capa->status = "Opened";

                $capa->update();

                toastr()->success('Document Sent');
                return back();
            }
            
            if ($capa->stage == 3) {
                $capa->stage = "2";
                $capa->status = "HOD Review";
                $capa->update();

                toastr()->success('Document Sent');
                return back();
            }
        
            if ($capa->stage == 5) {
                $capa->stage = "4";
                $capa->status = "Initial QA Review";
                $capa->update();

                toastr()->success('Document Sent');
                return back();
            }
            if ($capa->stage == 6) {
                $capa->stage = "1";
                $capa->status = "Opened";

                $capa->update();

                toastr()->success('Document Sent');
                return back();
            }
            if ($capa->stage == 13) {
                $capa->stage = "10";
                $capa->status = "closed";
                $capa->update();

                toastr()->success('Document Sent');
                return back();
            }
            if ($capa->stage == 4) {
                $capa->stage = "6";
                $capa->status = "QA Approve Review";
    
                $capa->update();
    
                toastr()->success('Document Sent');
                return back();
             }else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }
}

//============================================backword-stage============================================//

public function root_backword(Request $request, $id)
{
    if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
        $capa = RootCauseAnalysis::find($id);

        if ($capa->stage == 6) {
            $capa->stage = "2";
            $capa->status = "HOD Review";

            $capa->update();

            toastr()->success('Document Sent');
            return back();
        }
            else {
        toastr()->error('E-signature Not match');
        return back();
       }
    }
}
//=============================================backword2-modal============================================//

public function root_backword_2(Request $request, $id)
{
    if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
        $capa = RootCauseAnalysis::find($id);

        if ($capa->stage == 6) {
            $capa->stage = "4";
            $capa->status = "QA Initial Review";

            $capa->update();

            toastr()->success('Document Sent');
            return back();
         }else {
        toastr()->error('E-signature Not match');
        return back();
       }
    }
}
//========================================================audittrail=============================================//

    public function rootAuditTrial($id)
    {
        $audit = RootAuditTrial::where('root_id', $id)->orderByDESC('id')->paginate(5);
        $today = Carbon::now()->format('d-m-y');
        $document = RootCauseAnalysis::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');

        return view("frontend.root-cause-analysis.root-audit-trail", compact('audit', 'document', 'today'));
    }
    //===============================================audit-report=================================================//

    public function auditDetailsroot($id)
    {

        $detail = RootAuditTrial::find($id);

        $detail_data = RootAuditTrial::where('activity_type', $detail->activity_type)->where('root_id', $detail->root_id)->latest()->get();

        $doc = RootCauseAnalysis::where('id', $detail->root_id)->first();

        $doc->origiator_name = User::find($doc->initiator_id);
        return view("frontend.root-cause-analysis.root-audit-trial-inner", compact('detail', 'doc', 'detail_data'));
    }
//=====================================================single-report====================================================//
    public static function singleReport($id)
    {    
        $data = RootCauseAnalysis::find($id);
        if (!empty($data)) {
            $data->originator_id = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.root-cause-analysis.singleReport', compact('data'))
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
            return $pdf->stream('Root-cause' . $id . '.pdf');
        }
    }
//===================================audit-report==============================//
    public static function auditReport($id)
    {
        $doc = RootCauseAnalysis::find($id);
        if (!empty($doc)) {
            $doc->originator_id = User::where('id', $doc->initiator_id)->value('name');
            $data = RootAuditTrial::where('root_id', $id)->get();
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.root-cause-analysis.auditReport', compact('data', 'doc'))
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
            return $pdf->stream('Root-Audit' . $id . '.pdf');
        }
    }

    public function root_child(Request $request, $id){
    }

    }

