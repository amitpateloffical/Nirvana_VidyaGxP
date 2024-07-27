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

        $record = ((RecordNumber::first()->value('counter')) + 1);
        $record = str_pad($record, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $zones = ['Zone 1', 'Zone 2']; // Example zones
        $countries = ['Country 1', 'Country 2']; // Example countries
        $states = ['State 1', 'State 2']; // Example states
        $cities = ['City 1', 'City 2']; // Example cities
       
        return view('frontend.lab-investigation.lab_investigation',compact('record', 'zones', 'countries', 'states', 'cities'));
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
        
        $lab->additional_investigator = $request->additional_investigator;
      
        $lab->departments = is_array($request->departments) ? implode(',', $request->departments) : '';

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
        
        $lab->investigation_summary = ($request->investigation_summary);
        
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
        
           $grid->type = "root_cause";
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
        $grid->save();  


        $data1= new labInvestigationgrid();

        $data1->lab_investigation_id = $lab->id;
        $data1->type = "effect_analysis";
        if (!empty($request->risk_factor)) {
            $data1->risk_factor = serialize($request->risk_factor);
        }
        if (!empty($request->risk_element)) {
            $data1->risk_element = serialize($request->risk_element);
        }
        if (!empty($request->problem_cause)) {
            $data1->problem_cause = serialize($request->problem_cause);
        }
        if (!empty($request->existing_risk_control)) {
            $data1->existing_risk_control = serialize($request->existing_risk_control);
        }
        if (!empty($request->initial_severity)) {
            $data1->initial_severity = serialize($request->initial_severity);
        }
        if (!empty($request->initial_detectability)) {
            $data1->initial_detectability = serialize($request->initial_detectability);
        }
        if (!empty($request->initial_probability)) {
            $data1->initial_probability = serialize($request->initial_probability);
        }
        if (!empty($request->initial_rpn)) {
            $data1->initial_rpn = serialize($request->initial_rpn);
        }
        if (!empty($request->risk_acceptance)) {
            $data1->risk_acceptance = serialize($request->risk_acceptance);
        }
        if (!empty($request->risk_control_measure)) {
            $data1->risk_control_measure = serialize($request->risk_control_measure);
        }
        if (!empty($request->residual_severity)) {
            $data1->residual_severity = serialize($request->residual_severity);
        }
        if (!empty($request->residual_probability)) {
            $data1->residual_probability = serialize($request->residual_probability);
        }
        if (!empty($request->residual_detectability)) {
            $data1->residual_detectability = serialize($request->residual_detectability);
        }
        if (!empty($request->residual_rpn)) {
            $data1->residual_rpn = serialize($request->residual_rpn);
        }
        
        if (!empty($request->risk_acceptance2)) {
            $data1->risk_acceptance2 = serialize($request->risk_acceptance2);
        }
        if (!empty($request->mitigation_proposal)) {
            $data1->mitigation_proposal = serialize($request->mitigation_proposal);
        }

        $data1->save();




  // -------------------------------------------------------
         $record = RecordNumber::first();
         $record->counter = ((RecordNumber::first()->value('counter')) + 1);
         $record->update();
        

        //  if (!empty($lab->assigned_to)) {
        //     $history= new LabInvestigation_AuditTrails();
        //     $history->lab_id = $lab->id;
        //     $history->activity_type = 'assign to';
        //     $history->previous = "Null";
        //     $history->current = $lab->assigned_to;
        //     $history->comment = "NA";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lab->status;
        //     $history->change_to = "Opened";
        //     $history->change_from = "Initiator";
        //     $history->action_name = "Create";
        //     $history->save();

        //  }
       

        //  if (!empty($lab->intiation_date)) {
        //     $history= new LabInvestigation_AuditTrails();
        //     $history->lab_id = $lab->id;
        //     $history->activity_type = 'intiation date';
        //     $history->previous = "Null";
        //     $history->current = $lab->intiation_date;
        //     $history->comment = "NA";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lab->status;
        //     $history->change_to = "Opened";
        //     $history->change_from = "Initiator";
        //     $history->action_name = "Create";
        //     $history->save();
        // }




        // if (!empty($lab->due_date)) {
        //     $history= new LabInvestigation_AuditTrails();
        //     $history->lab_id = $lab->id;
        //     $history->activity_type = 'due date';
        //     $history->previous = "Null";
        //     $history->current = $lab->due_date;
        //     $history->comment = "NA";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lab->status;
        //     $history->change_to = "Opened";
        //     $history->change_from = "Initiator";
        //     $history->action_name = "Create";
        //     $history->save();
        // }


        // if (!empty($lab->trainer)) {
        //     $history= new LabInvestigation_AuditTrails();
        //     $history->lab_id = $lab->id;
        //     $history->activity_type = 'trainer';
        //     $history->previous = "Null";
        //     $history->current = $lab->trainer;
        //     $history->comment = "NA";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lab->status;
        //     $history->change_to = "Opened";
        //     $history->change_from = "Initiator";
        //     $history->action_name = "Create";
        //     $history->save();
        // }


        // if (!empty($lab->short_description)) {
        //     $history= new LabInvestigation_AuditTrails();
        //     $history->lab_id = $lab->id;
        //     $history->activity_type = 'short description';
        //     $history->previous = "Null";
        //     $history->current = $lab->short_description;
        //     $history->comment = "NA";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lab->status;
        //     $history->change_to = "Opened";
        //     $history->change_from = "Initiator";
        //     $history->action_name = "Create";
        //     $history->save();
        // }




        
        // if (!empty($lab->expiry_date)) {
        //     $history= new LabInvestigation_AuditTrails();
        //     $history->lab_id = $lab->id;
        //     $history->activity_type = 'expiry date';
        //     $history->previous = "Null";
        //     $history->current = $lab->expiry_date;
        //     $history->comment = "NA";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lab->status;
        //     $history->change_to = "Opened";
        //     $history->change_from = "Initiator";
        //     $history->action_name = "Create";
        //     $history->save();
        // }

        // if (!empty($lab->type)) {
        //     $history= new LabInvestigation_AuditTrails();
        //     $history->lab_id = $lab->id;
        //     $history->activity_type = 'type';
        //     $history->previous = "Null";
        //     $history->current = $lab->type;
        //     $history->comment = "NA";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lab->status;
        //     $history->change_to = "Opened";
        //     $history->change_from = "Initiator";
        //     $history->action_name = "Create";
        //     $history->save();
        // }

        // if (!empty($lab->priority_level)) {
        //     $history= new LabInvestigation_AuditTrails();
        //     $history->lab_id = $lab->id;
        //     $history->activity_type = 'priority level';
        //     $history->previous = "Null";
        //     $history->current = $lab->priority_level;
        //     $history->comment = "NA";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lab->status;
        //     $history->change_to = "Opened";
        //     $history->change_from = "Initiator";
        //     $history->action_name = "Create";
        //     $history->save();
        // }

        // if (!empty($lab->external_tests)) {
        //     $history= new LabInvestigation_AuditTrails();
        //     $history->lab_id = $lab->id;
        //     $history->activity_type = 'external test';
        //     $history->previous = "Null";
        //     $history->current = $lab->external_tests;
        //     $history->comment = "NA";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lab->status;
        //     $history->change_to = "Opened";
        //     $history->change_from = "Initiator";
        //     $history->action_name = "Create";
        //     $history->save();
        // }
        // if (!empty($lab->test_lab)) {
        //     $history= new LabInvestigation_AuditTrails();
        //     $history->lab_id = $lab->id;
        //     $history->activity_type = 'test lab';
        //     $history->previous = "Null";
        //     $history->current = $lab->test_lab;
        //     $history->comment = "NA";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lab->status;
        //     $history->change_to = "Opened";
        //     $history->change_from = "Initiator";
        //     $history->action_name = "Create";
        //     $history->save();
        // }
        // if (!empty($lab->original_test_result)) {
        //     $history= new LabInvestigation_AuditTrails();
        //     $history->lab_id = $lab->id;
        //     $history->activity_type = 'original test result';
        //     $history->previous = "Null";
        //     $history->current = $lab->original_test_result;
        //     $history->comment = "NA";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lab->status;
        //     $history->change_to = "Opened";
        //     $history->change_from = "Initiator";
        //     $history->action_name = "Create";
        //     $history->save();
        // }
        // if (!empty($lab->additional_investigator)) {
        //     $history= new LabInvestigation_AuditTrails();
        //     $history->lab_id = $lab->id;
        //     $history->activity_type = 'additional investigator';
        //     $history->previous = "Null";
        //     $history->current = $lab->additional_investigator;
        //     $history->comment = "NA";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lab->status;
        //     $history->change_to = "Opened";
        //     $history->change_from = "Initiator";
        //     $history->action_name = "Create";
        //     $history->save();
        // }
        // if (!empty($lab->departments)) {
        //     $history= new LabInvestigation_AuditTrails();
        //     $history->lab_id = $lab->id;
        //     $history->activity_type = 'deparments';
        //     $history->previous = "Null";
        //     $history->current = $lab->departments;
        //     $history->comment = "NA";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lab->status;
        //     $history->change_to = "Opened";
        //     $history->change_from = "Initiator";
        //     $history->action_name = "Create";
        //     $history->save();
        // }
        // if (!empty($lab->description)) {
        //     $history= new LabInvestigation_AuditTrails();
        //     $history->lab_id = $lab->id;
        //     $history->activity_type = 'description';
        //     $history->previous = "Null";
        //     $history->current = $lab->description;
        //     $history->comment = "NA";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lab->status;
        //     $history->change_to = "Opened";
        //     $history->change_from = "Initiator";
        //     $history->action_name = "Create";
        //     $history->save();
        // }
        // if (!empty($lab->comments)) {
        //     $history= new LabInvestigation_AuditTrails();
        //     $history->lab_id = $lab->id;
        //     $history->activity_type = 'comments';
        //     $history->previous = "Null";
        //     $history->current = $lab->comments;
        //     $history->comment = "NA";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lab->status;
        //     $history->change_to = "Opened";
        //     $history->change_from = "Initiator";
        //     $history->action_name = "Create";
        //     $history->save();
        // }
        // if (!empty($lab->related_urls)) {
        //     $history= new LabInvestigation_AuditTrails();
        //     $history->lab_id = $lab->id;
        //     $history->activity_type = 'related url';
        //     $history->previous = "Null";
        //     $history->current = $lab->related_urls;
        //     $history->comment = "NA";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lab->status;
        //     $history->change_to = "Opened";
        //     $history->change_from = "Initiator";
        //     $history->action_name = "Create";
        //     $history->save();
        // }



        $fields = [
            'due_date',
            'trainer',
            'short_description',
            'expiry_date',
            'type',
            'priority_level',
            'external_tests',
            'test_lab',
            'original_test_result',
            'limit_specifications',
            'additional_investigator',
            'departments',
            'description',
            'comments',
            'related_urls',
            'severity_rate',
            'occurrence',
            'detection',
            'RPN',
            'risk_analysis',
            'zone',
            'country',
            'city',
            'state_district',
            'root_cause_methodology'
        ];
    
        foreach ($fields as $field) {
            if (!empty($request->$field)) {
                $previousValue = $lab->$field ?? "Null"; // Assuming this is a new record, the previous value is "Null"
                $lab->$field = is_array($request->$field) ? implode(',', $request->$field) : $request->$field;
                $currentValue = $lab->$field;
    
                $history = new LabInvestigation_AuditTrails();
                $history->lab_id = $lab->id;
                $history->activity_type = $field;
                $history->previous = $previousValue;
                $history->current = $currentValue;
                $history->comment = "NA";
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lab->status;
                $history->change_to = "Opened";
                $history->change_from = "Initiator";
                $history->action_name = "Create";
                $history->save();
            }
        }



// Fields that need to be serialized
$serializeFields = [
    'measurement', 'materials', 'environment', 'manpower', 'machine', 'methods', 
    'why_1', 'why_2', 'why_3', 'why_4', 'why_5'
];

// Handle serialized fields and create audit trails
foreach ($serializeFields as $field) {
    if (!empty($request->$field)) {
        $previousValue = $lab->$field ?? "Null";
        $lab->$field = serialize($request->$field);
        $currentValue = $lab->$field;

        if ($previousValue !== $currentValue) {
            $history = new LabInvestigation_AuditTrails();
            $history->lab_id = $lab->id;
            $history->activity_type = str_replace('_', ' ', $field); // Replace underscores with spaces for better readability
            $history->previous = $previousValue;
            $history->current = $currentValue;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lab->status;
            $history->change_to = "Opened";
            $history->change_from = "Initiator";
            $history->action_name = "Create";
            $history->save();
        }
    }
}



        $normalFields = [
            'problem_statement', 'why_problem_statement', 'why_root_cause', 
            'what_will_be', 'what_will_not_be', 'what_rationable',
            'where_will_be', 'where_will_not_be', 'where_rationable',
            'when_will_be', 'when_will_not_be', 'when_rationable',
            'coverage_will_be', 'coverage_will_not_be', 'coverage_rationable',
            'who_will_be', 'who_will_not_be', 'who_rationable',
            'investigation_summary', 'root_cause_description', 'submitted_by'
        ];

        foreach ($normalFields as $field) {
            if (!empty($request->$field)) {
                $previousValue = $lab->$field ?? "Null";
                $lab->$field = $request->$field;
                $currentValue = $lab->$field;

                $history = new LabInvestigation_AuditTrails();
                $history->lab_id = $lab->id;
                $history->activity_type = str_replace('_', ' ', $field); // Replace underscores with spaces for better readability
                $history->previous = $previousValue;
                $history->current = $currentValue;
                $history->comment = "NA";
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lab->status;
                $history->change_to = "Opened";
                $history->change_from = "Initiator";
                $history->action_name = "Create";
                $history->save();
            }
        }


        

        // Save the lab investigation after setting all fields
      
    

         toastr()->success("Record is created Successfully");
           return redirect(url('rcms/qms-dashboard'));
    }



    public function edit(Request $request, $id)
    {

        
        $data = LabInvestigation::find($id);
        $data->record = str_pad($data->record, 4, '0', STR_PAD_LEFT);
        $riskEffectAnalysis = labInvestigationgrid::where('lab_investigation_id',$id)->where('type',"effect_analysis")->first();
       
       // $data1=labInvestigationgrid::find($id);
        if (empty($data)) {
            toastr()->error('Invalid ID.');
            return back();
        }
        $data->departments = explode(',', $data->departments); 

        $zones = ['Zone 1', 'Zone 2']; // Example zones
        $countries = ['Country 1', 'Country 2']; // Example countries
        $states = ['State 1', 'State 2']; // Example states
        $cities = ['City 1', 'City 2']; // Example cities
    
        $users = User::all(); // Fetch all users to populate the dropdowns
        return view('frontend.lab-investigation.lab_investigation_view', compact('data', 'riskEffectAnalysis','users', 'zones', 'countries', 'states', 'cities'));
    }
    


    public function     update(Request $request,$id)
    {


//        dd($request->all());

        $lab = LabInvestigation::find($id);
        $lastDocument =   LabInvestigation::find($id);
               


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
        $lab->additional_investigator = $request->additional_investigator;
        $lab->departments = is_array($request->departments) ? implode(',', $request->departments) : '';

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
        $lab->state_district = $request->state_district;


        $lab->detection = $request->detection;
        $lab->RPN = $request->RPN;
        $lab->risk_analysis = $request->risk_analysis;


        //dd($lab->city);
        $lab->root_cause_methodology = implode(',', $request->root_cause_methodology);

        // dd($root->root_cause_methodology);
         // $root->country = ($request->country);
         $lab->assigned_to = $request->assign_to;
         //$lab->Sample_Types = $request->Sample_Types;
          


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
         // Root Cause +
         if (!empty($request->Root_Cause_Category  )) {
             $lab->Root_Cause_Category = serialize($request->Root_Cause_Category);
         }
         if (!empty($request->Root_Cause_Sub_Category)) {
             $lab->Root_Cause_Sub_Category= serialize($request->Root_Cause_Sub_Category);
         }
         if (!empty($request->Probability)) {
             $lab->Probability = serialize($request->Probability);
         }
         if (!empty($request->Remarks)) {
             $lab->Remarks = serialize($request->Remarks);
         }
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
        $lab->update();


        $data1 = labInvestigationgrid::where('lab_investigation_id',$lab->id)->where('type','effect_analysis')->first();
            
        if (!empty($request->risk_factor)) {
            $data1->risk_factor = serialize($request->risk_factor);
        }
        if (!empty($request->risk_element)) {
            $data1->risk_element = serialize($request->risk_element);
        }
        if (!empty($request->problem_cause)) {
            $data1->problem_cause = serialize($request->problem_cause);
        }
        if (!empty($request->existing_risk_control)) {
            $data1->existing_risk_control = serialize($request->existing_risk_control);
        }
        if (!empty($request->initial_severity)) {
            $data1->initial_severity = serialize($request->initial_severity);
        }
        if (!empty($request->initial_detectability)) {
            $data1->initial_detectability = serialize($request->initial_detectability);
        }
        if (!empty($request->initial_probability)) {
            $data1->initial_probability = serialize($request->initial_probability);
        }
        if (!empty($request->initial_rpn)) {
            $data1->initial_rpn = serialize($request->initial_rpn);
        }
        if (!empty($request->risk_acceptance)) {
            $data1->risk_acceptance = serialize($request->risk_acceptance);
        }
        if (!empty($request->risk_control_measure)) {
            $data1->risk_control_measure = serialize($request->risk_control_measure);
        }
        if (!empty($request->residual_severity)) {
            $data1->residual_severity = serialize($request->residual_severity);
        }
        if (!empty($request->residual_probability)) {
            $data1->residual_probability = serialize($request->residual_probability);
        }
        if (!empty($request->residual_detectability)) {
            $data1->residual_detectability = serialize($request->residual_detectability);
        }
        if (!empty($request->residual_rpn)) {
            $data1->residual_rpn = serialize($request->residual_rpn);
        }
        if (!empty($request->risk_acceptance2)) {
            $data1->risk_acceptance2 = serialize($request->risk_acceptance2);
        }
        if (!empty($request->mitigation_proposal)) {
            $data1->mitigation_proposal = serialize($request->mitigation_proposal);
        }
         //dd($data1);
        $data1->save();

 


        $fields = [
            'due_date',
            'trainer',
            'short_description',
            'expiry_date',
            'type',
            'priority_level',
            'external_tests',
            'test_lab',
            'original_test_result',
            'limit_specifications',
            'additional_investigator',
            'departments',
            'description',
            'comments',
            'related_urls',
            'severity_rate',
            'occurrence',
            'detection',
            'RPN',
            'risk_analysis',
            'zone',
            'country',
            'city',
            'state_district',
            'root_cause_methodology',
            'what_will_be',
            'what_will_not_be',
            'what_rationable',
            'where_will_be',
            'where_will_not_be',
            'where_rationable',
            'when_will_be',
            'when_will_not_be',
            'when_rationable',
            'coverage_will_be',
            'coverage_will_not_be',
            'coverage_rationable',
            'who_will_be',
            'who_will_not_be',
            'who_rationable',
            'root_cause_description',
            'investigation_summary'


        ];

   
    
        foreach ($fields as $field) {
            if ($request->filled($field)) {
                $previousValue = $lastDocument->$field ?? "Null"; // Get the previous value from the last document
                $currentValue = is_array($request->$field) ? implode(',', $request->$field) : $request->$field;
    
                // Check if the current value is different from the previous value
                if ($previousValue != $currentValue) {
                  //  $lab->$field = $currentValue; // Update the lab field with the new value
    
                    // Create an audit trail entry
                    $history = new LabInvestigation_AuditTrails();
                    $history->lab_id = $lab->id;
                    $history->activity_type = str_replace('_', ' ', $field); // Replace underscores with spaces for better readability
                    $history->previous = $previousValue;
                    $history->current = $currentValue;
                    $history->comment = $request->comment ?? "NA"; // Use provided comment or "NA" if not available
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to = "Not Applicable";
                    $history->change_from = $lastDocument->status;
                    $history->action_name = is_null($previousValue) || $previousValue === '' ? "New" : "Update";
                    $history->save();
                }
            }
        }




        $fields = ['measurement', 'materials', 'environment', 'manpower', 'machine', 'methods', 'problem_statement', 'Root_Cause_Category', 'Root_Cause_Sub_Category','Probability','Remarks', 'why_problem_statement', 'why_1', 'why_2', 'why_3', 'why_4','why_5','why_root_cause'];
        foreach ($fields as $field) {
            if (!empty($request->$field)) {
                $lab->$field = is_array($request->$field) ? serialize($request->$field) : $request->$field;
        
                if ($lastDocument->$field != $lab->$field || !empty($request->comment)) {
                    $history = new LabInvestigation_AuditTrails();
                    $history->lab_id = $id;
                    $history->activity_type = ucfirst(str_replace('_', ' ', $field));
                    $history->previous = $lastDocument->$field;
                    $history->current = $lab->$field;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to = "Not Applicable";
                    $history->change_from = $lastDocument->status;
                    $history->action_name = is_null($lastDocument->$field) || $lastDocument->$field === '' ? "New" : "Update";
                    $history->save();
                }
            }
        }
        
       
   
         toastr()->success("Record is update Successfully");
        return redirect()->back();

    }



    public function lab_send_stage(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
        {
            $changestage = LabInvestigation::find($id);

            $lastDocument =  LabInvestigation::find($id);
           // $changestage = LabInvestigation::find($id);
            if($changestage->stage == 1)
            {
                $changestage->stage = "2";
                $changestage->status = "Lab Investigation in Progress";
                $changestage->submitted_by =  Auth::user()->name;
                $changestage->submitted_on =  Carbon::now()->format('d-M-Y');
                $changestage->comment1 = $request->comment;

                $history = new LabInvestigation_AuditTrails();
                $history->lab_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous ="";
                $history->current = $changestage->submitted_by;
                $history->comment = $request->comment;
                $history->action = 'Submit';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Lab Investigation in Progress";
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Update';
                $history->stage = 'Lab Investigation in Progress';
              
                

                $history->save();
          


                $changestage->update();
                // dd($changestage);
                toastr()->success('Document Sent');
                return back();

            }

            if($changestage->stage == 2)
            {
                $changestage->stage ="3";
                $changestage->status = "Lab Investigation Evaluation";
                $changestage->submitted_by =  Auth::user()->name;
                $changestage->submitted_on =  Carbon::now()->format('d-M-Y');
                $changestage->comment2 = $request->comment;

                $history = new LabInvestigation_AuditTrails();
                $history->lab_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous ="";
                $history->current = $changestage->submitted_by;
                $history->comment = $request->comment;
                $history->action = 'Report Result';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Lab Investigation Evaluation";
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Update';
                $history->stage = 'Lab Investigation Evaluation';
              
                

                $history->save();

                $changestage->update();
                // dd($changestage);
                toastr()->success('Document Sent');
                return back();

            }
            if($changestage->stage == 3)
            {
                $changestage->stage = "4";
                $changestage->status = "Close-Done";
                $changestage->submitted_by =  Auth::user()->name;
                $changestage->submitted_on =  Carbon::now()->format('d-M-Y');
                $changestage->comment3 = $request->comment;

                $history = new LabInvestigation_AuditTrails();
                $history->lab_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous ="";
                $history->current = $changestage->submitted_by;
                $history->comment = $request->comment;
                $history->action = 'Evaluation Completed';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Close-Done";
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Update';
                $history->stage = 'Close-Done';
              
                

                $history->save();
                $changestage->update();
                // dd($changestage);
                toastr()->success('Document Sent');
                return back();

            }


           




        }


    }else {
        toastr()->error('E-signature Not match');
        return back();
    }

    
}

        public function lab_reject(Request $request, $id)
        {
            if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
                
                $data = LabInvestigation::find($id);
                $lastDocument = LabInvestigation::find($id);
            
                if ($data->stage == 1) {
                    $data->stage = "4";
                    $data->status = "Close Done";
                    $data->rejected_by = Auth::user()->name;
                    $data->rejected_on = Carbon::now()->format('d-M-Y');

                    $data->comment4 = $request->comment;

                    $history = new LabInvestigation_AuditTrails();
                    $history->lab_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->previous ="";
                    $history->current = $data->submitted_by;
                    $history->comment = $request->comment;
                    $history->action = 'Cancel';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "Close-Done";
                    $history->change_from = $lastDocument->status;
                    $history->action_name = 'Update';
                    $history->stage = 'Close-Done';
                  
                    
    
                    $history->save();


                    $data->update();
                    toastr()->success('Document Sent');
                    return back();
                }
                if ($data->stage == 3) {
                    $data->stage = "2";
                    $data->status = "Lab Investigation in Progress";
                    $data->rejected_by = Auth::user()->name;
                    $data->rejected_on = Carbon::now()->format('d-M-Y');

                    $data->comment5 = $request->comment;

                    $history = new LabInvestigation_AuditTrails();
                    $history->lab_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->previous ="";
                    $history->current = $data->submitted_by;
                    $history->comment = $request->comment;
                    $history->action = 'Reject';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "Lab Investigation in Progress";
                    $history->change_from = $lastDocument->status;
                    $history->action_name = 'Update';
                    $history->stage = 'Lab Investigation in Progress';
                  
                    
    
                    $history->save();



                    $data->update();
                    toastr()->success('Document Sent');
                    return back();
                }

             

            }

        }   



        public function lab_cancel(Request $request, $id)
        {
            if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
                
                $data = LabInvestigation::find($id);
                $lastDocument = LabInvestigation::find($id);
            

                

             

            }

        }   



        public static function singleReport($id)
        {    
            $data = LabInvestigation::find($id);
            $failure_mode = labInvestigationgrid::where('lab_investigation_id',$id)->where('type',"effect_analysis")->first();
       
            //dd($data);
            if (!empty($data)) {
                $data->originator_id = User::where('id', $data->initiator_id)->value('name');
                $pdf = App::make('dompdf.wrapper');
                $time = Carbon::now();
                $pdf = PDF::loadview('frontend.lab-investigation.singleReport', compact('data','failure_mode'))
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
                return $pdf->stream('Lab-Investigation' . $id . '.pdf');
            }
        }






        
    public function LabAuditTrial($id)
    {



          //$audit = RiskAuditTrail::where('risk_id', $id)->orderByDESC('id')->get()->unique('activity_type');
          $audit = LabInvestigation_AuditTrails::where('lab_id', $id)->orderByDesc('id')->paginate(5);
          $today = Carbon::now()->format('d-m-y');
          $document = LabInvestigation::where('id', $id)->first();
          $document->initiator = User::where('id', $document->initiator_id)->value('name');
  
  
          //dd($audit);
          return view("frontend.lab-investigation.auditReport", compact('audit', 'document', 'today'));

      


 
    }

        public static function auditReport($id)
        {


           //   return "hello";
            $doc = LabInvestigation::find($id);
            if (!empty($doc)) {
               // $audit = RootAuditTrial::where('root_id', $id)->orderByDESC('id')->get();
                $doc->originator_id = User::where('id', $doc->initiator_id)->value('name');
                $data = LabInvestigation::where('id', $id)->get();
                $pdf = App::make('dompdf.wrapper');
                $time = Carbon::now();
                $pdf = PDF::loadview('frontend.lab-investigation.auditReport', compact('data', 'doc'))
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


}