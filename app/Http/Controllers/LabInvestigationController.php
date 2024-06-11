<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\RecordNumber;
use App\Models\RoleGroup;
use App\Models\User;
use App\Models\LabInvestigation_AuditTrails;
use App\Models\LabInvestigation;
use App\Models\labInvestigationgrid;
use Carbon\Carbon;

use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class LabInvestigationController extends Controller
{
    public function index()
    {
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
       
        return view('frontend.New_forms.lab_investigation',compact('record_number'));
    }

    public function store(Request $request)
    {

        //return $request->all();
        if (!$request->short_description) {
            toastr()->error("Short description is required");
              return redirect()->back();
         }
        $lab = new LabInvestigation();
        
        $lab->form_type = "lab-investigation"; 
      //  $lab->parent_id = $request->parent_id;
       // $lab->parent_type = $request->parent_type;
       $lab->record = ((RecordNumber::first()->value('counter')) + 1);
        $lab->initiator_id = $request->initiator_id;
      //  $lab->date_opened = $request->date_opened;
        $lab->division_id = '7';
        $lab->assigned_to = $request->assign_to;
        $lab->intiation_date = $request->intiation_date; 
        $lab->due_date = $request->due_date;
        $lab->trainer = $request->trainer;

        $lab->short_description =($request->short_description);
        $lab->expiry_date = $request->expiry_date;
        $lab->type = $request->type;
        $lab->priority_level = $request->priority_level;
        $lab->external_tests =$request->external_tests;
        $lab->test_lab = $request->test_lab;
        $lab->original_test_result = $request->original_test_result;
        $lab->limit_specifications = $request->limit_specifications;
        
        $additionalInvestigatorDate = $request->additional_investigator ? date('Y-m-d', strtotime($request->additional_investigator)) : date('Y-m-d');
        $lab->departments =$request->departments;
        $lab->description = $request->description;
        $lab->comments = $request->comments;
        $lab->related_urls = $request->related_urls;
        $lab->severity_rate = $request->severity_rate;
        $lab->occurrence =$request->occurrence;
        $lab->detection = $request->detection;
        $lab->RPN = $request->RPN;
        $lab->risk_analysis = $request->risk_analysis;
       
        $lab->zone = $request->zone;
        $lab->country = $request->country;
        $lab->city = $request->city;
        $lab->state_district =$request->state_district;
        $lab->detection = $request->detection;
        $lab->RPN = $request->RPN;
        $lab->risk_analysis = $request->risk_analysis;

        $lab->root_cause_methodology = implode(',', $request->root_cause_methodology);
        //Fishbone or Ishikawa Diagram 
        if (!empty($request->measurement  )) {
            $lab->measurement = serialize($request->measurement);
        }
        if (!empty($request->materials  )) {
            $lab->materials = serialize($request->materials);
        }
        if (!empty($request->environment  )) {
            $lab->environment = serialize($request->environment);
        }
        if (!empty($request->manpower  )) {
            $lab->manpower = serialize($request->manpower);
        }
        if (!empty($request->machine  )) {
            $lab->machine = serialize($request->machine);
        }
        if (!empty($request->methods)) {
            $lab->methods = serialize($request->methods);
        }
        $lab->problem_statement = ($request->problem_statement);
        // Why-Why Chart (Launch Instruction) Problem Statement 
        if (!empty($request->why_problem_statement)) {
            $lab->why_problem_statement = $request->why_problem_statement;
        }
        if (!empty($request->why_1  )) {
            $lab->why_1 = serialize($request->why_1);
        }
        if (!empty($request->why_2  )) {
            $lab->why_2 = serialize($request->why_2);
        }
        if (!empty($request->why_3  )) {
            $lab->why_3 = serialize($request->why_3);
        }
        if (!empty($request->why_4 )) {
            $lab->why_4 = serialize($request->why_4);
        }
        if (!empty($request->why_5  )) {
            $lab->why_5 = serialize($request->why_5);
        }
        if (!empty($request->why_root_cause)) {
            $lab->why_root_cause = $request->why_root_cause;
        }

        // Is/Is Not Analysis (Launch Instruction)
        $lab->what_will_be = ($request->what_will_be);
        $lab->what_will_not_be = ($request->what_will_not_be);
        $lab->what_rationable = ($request->what_rationable);

        $lab->where_will_be = ($request->where_will_be);
        $lab->where_will_not_be = ($request->where_will_not_be);
        $lab->where_rationable = ($request->where_rationable);

        $lab->when_will_be = ($request->when_will_be);
        $lab->when_will_not_be = ($request->when_will_not_be);
        $lab->when_rationable = ($request->when_rationable);

        $lab->coverage_will_be = ($request->coverage_will_be);
        $lab->coverage_will_not_be = ($request->coverage_will_not_be);
        $lab->coverage_rationable = ($request->coverage_rationable);

        $lab->who_will_be = ($request->who_will_be);
        $lab->who_will_not_be = ($request->who_will_not_be);
        $lab->who_rationable = ($request->who_rationable);
        
        $lab->root_cause_description = ($request->root_cause_description);
        $lab->investigation_summary = ($request->investigation_summary);
        $lab->submitted_by = ($request->submitted_by);

        if (!empty($request->attached_test)) {
            $files = [];
            if ($request->hasfile('attached_test')) {
                foreach ($request->file('attached_test') as $file) {
                    $name = $request->name . 'attached_test' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $lab->attached_test = json_encode($files);
        }

        
        $lab->status = 'Opened';
        $lab->stage = 1;

       // return $lab;
        $lab->save();

      
           $grid = new labInvestigationgrid();


           $grid->lab_investigation_id = $lab->id;
        
        
           //grid data store


        if (!empty($request->Root_Cause_Category  )) {
            $grid->Root_Cause_Category = serialize($request->Root_Cause_Category);
        }
        if (!empty($request->Root_Cause_Sub_Category)) {
            $grid->Root_Cause_Sub_Category= serialize($request->Root_Cause_Sub_Category);
        }
        if (!empty($request->Probability)) {
            $grid->Probability = serialize($request->Probability);
        }
        if (!empty($request->Remarks)) {
            $grid->Remarks = serialize($request->Remarks);
        }

         //Failure Mode and Effect Analysis+ grid

         if (!empty($request->risk_factor)) {
            $grid->risk_factor = serialize($request->risk_factor);
        }
        if (!empty($request->risk_element)) {
            $grid->risk_element = serialize($request->risk_element);
        }
        if (!empty($request->problem_cause)) {
            $grid->problem_cause = serialize($request->problem_cause);
        }
        if (!empty($request->existing_risk_control)) {
            $grid->existing_risk_control = serialize($request->existing_risk_control);
        }
        if (!empty($request->initial_severity)) {
            $grid->initial_severity = serialize($request->initial_severity);
        }
        if (!empty($request->initial_detectability)) {
            $grid->initial_detectability = serialize($request->initial_detectability);
        }
        if (!empty($request->initial_probability)) {
            $grid->initial_probability = serialize($request->initial_probability);
        }
        if (!empty($request->initial_rpn)) {
            $grid->initial_rpn = serialize($request->initial_rpn);
        }
        if (!empty($request->risk_acceptance)) {
            $grid->risk_acceptance = serialize($request->risk_acceptance);
        }
        if (!empty($request->risk_control_measure)) {
            $grid->risk_control_measure = serialize($request->risk_control_measure);
        }
        if (!empty($request->residual_severity)) {
            $grid->residual_severity = serialize($request->residual_severity);
        }
        if (!empty($request->residual_probability)) {
            $grid->residual_probability = serialize($request->residual_probability);
        }
        if (!empty($request->residual_detectability)) {
            $grid->residual_detectability = serialize($request->residual_detectability);
        }
        if (!empty($request->residual_rpn)) {
            $grid->residual_rpn = serialize($request->residual_rpn);
        }
        if (!empty($request->risk_acceptance2)) {
            $grid->risk_acceptance2 = serialize($request->risk_acceptance2);
        }
        if (!empty($request->mitigation_proposal)) {
            $grid->mitigation_proposal = serialize($request->mitigation_proposal);
        }

      //  dd($grid);

         $grid->save();

        
  // -------------------------------------------------------
         $record = RecordNumber::first();
         $record->counter = ((RecordNumber::first()->value('counter')) + 1);
         $record->update();
        


        // $history= new LabInvestigation_AuditTrails();
        // $history->lab_id = $lab->id;
        // $history->activity_type = 'Division Code';
        // $history->previous = "Null";
        // $history->current = $lab->division_id;
        // $history->comment = "NA";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $lab->status;
        // $history->save();

         toastr()->success("Record is created Successfully");
           return redirect(url('rcms/qms-dashboard'));
    }



    public function edit(Request $request, $id)
    {
        $data = LabInvestigation::find($id);
        if (empty($data)) {
            toastr()->error('Invalid ID.');
            return back();
        }
        $users = User::all(); // Fetch all users to populate the dropdowns
        return view('frontend.New_forms.lab_investigation_view', compact('data', 'users'));
    }
    
}
