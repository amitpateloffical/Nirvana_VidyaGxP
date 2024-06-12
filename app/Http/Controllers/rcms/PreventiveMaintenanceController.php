<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RoleGroup;
use App\Models\PreventiveMaintenances;
use App\Models\PreventiveMaintenancesgrids;
use App\Models\PreventiveMaintenancesAuditTrial;
use App\Models\AuditReviewersDetails;
// use App\Services\Qms\PreventiveMaintenancesService;
use App\Models\RecordNumber;
use App\Models\Division;
use App\Models\QMSDivision;
use App\Models\Extension;
use Carbon\Carbon;
use Error;
use Helpers;
use PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;



class PreventiveMaintenanceController extends Controller
{
    public function index()
    {
        $cft = [];
        $old_record = PreventiveMaintenances::select('id', 'division_id', 'record_number')->get();
        
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $division = QMSDivision::where('name', Helpers::getDivisionName(session()->get('division')))->first();
        
        if ($division) {
            $last_PreventiveMaintenances = PreventiveMaintenances::where('division_id', $division->id)->latest()->first();
            if ($last_PreventiveMaintenances) {
                $record_number = $last_PreventiveMaintenances->record_number ? str_pad($last_PreventiveMaintenances->record_number + 1, 4, '0', STR_PAD_LEFT) : '0001';
                
            } else {
                $record_number = '0001';
            }
        }

        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date= $formattedDate->format('Y-m-d');
        // $changeControl = OpenStage::find(1);
        //  if(!empty($changeControl->cft)) $cft = explode(',', $changeControl->cft);
        return view("frontend.preventive-maintenance.preventive-maintenance", compact('due_date', 'record_number', 'old_record', 'cft'));

    }
    
    public function store(Request $request)
    { 
        $res = Helpers::getDefaultResponse();
        try {
            
            $input = $request->all();
            $input['form_type'] = "Preventive Maintenances";
            $input['status'] = 'Opened';
            $input['stage'] = 1;
            $input['record_number'] = ((RecordNumber::first()->value('counter')) + 1);
             
            $PreventiveMaintenances = PreventiveMaintenances::create($input);
            $record = RecordNumber::first();
            $record->counter = ((RecordNumber::first()->value('counter')) + 1);
            $record->update();

            if(!empty($request->short_description)){
                $history = new PreventiveMaintenancesAuditTrial();
                $history->preventive_maintenances_id = $PreventiveMaintenances->id;
                $history->previous = "Null";
                $history->comment = "Not Applicable";
                $history->activity_type = 'Short Description';
                $history->current = $request->short_description;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $PreventiveMaintenances->status;
                $history->stage = $PreventiveMaintenances->stage;
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->save();
            }
            if(!empty($request->due_date)){
                $history = new PreventiveMaintenancesAuditTrial();
                $history->preventive_maintenances_id = $PreventiveMaintenances->id;
                $history->previous = "Null";
                $history->comment = "Not Applicable";
                $history->activity_type = 'Due Date';
                $history->current = $request->due_date;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $PreventiveMaintenances->status;
                $history->stage = $PreventiveMaintenances->stage;
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->save();
            }
            if(!empty($request->additional_information)){
                $history = new PreventiveMaintenancesAuditTrial();
                $history->preventive_maintenances_id = $PreventiveMaintenances->id;
                $history->previous = "Null";
                $history->comment = "Not Applicable";
                $history->activity_type = 'Additional Information';
                $history->current = $request->additional_information;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $PreventiveMaintenances->status;
                $history->stage = $PreventiveMaintenances->stage;
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->save();
            }
            if(!empty($request->related_urls)){
                $history = new PreventiveMaintenancesAuditTrial();
                $history->preventive_maintenances_id = $PreventiveMaintenances->id;
                $history->previous = "Null";
                $history->comment = "Not Applicable";
                $history->activity_type = 'Related Urls';
                $history->current = $request->related_urls;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $PreventiveMaintenances->status;
                $history->stage = $PreventiveMaintenances->stage;
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->save();
            }
            if(!empty($request->PM_frequency)){
                $history = new PreventiveMaintenancesAuditTrial();
                $history->preventive_maintenances_id = $PreventiveMaintenances->id;
                $history->previous = "Null";
                $history->comment = "Not Applicable";
                $history->activity_type = 'PM Frequency';
                $history->current = $request->PM_frequency;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $PreventiveMaintenances->status;
                $history->stage = $PreventiveMaintenances->stage;
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->save();
            }
            if(!empty($request->parent_site_name)){
                $history = new PreventiveMaintenancesAuditTrial();
                $history->preventive_maintenances_id = $PreventiveMaintenances->id;
                $history->previous = "Null";
                $history->comment = "Not Applicable";
                $history->activity_type = 'Parent Site Name';
                $history->current = $request->parent_site_name;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $PreventiveMaintenances->status;
                $history->stage = $PreventiveMaintenances->stage;
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->save();
            }
            if(!empty($request->parent_building)){
                $history = new PreventiveMaintenancesAuditTrial();
                $history->preventive_maintenances_id = $PreventiveMaintenances->id;
                $history->previous = "Null";
                $history->comment = "Not Applicable";
                $history->activity_type = 'Parent Building';
                $history->current = $request->parent_building;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $PreventiveMaintenances->status;
                $history->stage = $PreventiveMaintenances->stage;
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->save();
            }
            if(!empty($request->parent_floor)){
                $history = new PreventiveMaintenancesAuditTrial();
                $history->preventive_maintenances_id = $PreventiveMaintenances->id;
                $history->previous = "Null";
                $history->comment = "Not Applicable";
                $history->activity_type = 'Parent Floor';
                $history->current = $request->parent_floor;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $PreventiveMaintenances->status;
                $history->stage = $PreventiveMaintenances->stage;
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->save();
            }
            if(!empty($request->parent_room)){
                $history = new PreventiveMaintenancesAuditTrial();
                $history->preventive_maintenances_id = $PreventiveMaintenances->id;
                $history->previous = "Null";
                $history->comment = "Not Applicable";
                $history->activity_type = 'Parent Room';
                $history->current = $request->parent_room;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $PreventiveMaintenances->status;
                $history->stage = $PreventiveMaintenances->stage;
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->save();
            }
            if(!empty($request->comments)){
                $history = new PreventiveMaintenancesAuditTrial();
                $history->preventive_maintenances_id = $PreventiveMaintenances->id;
                $history->previous = "Null";
                $history->comment = "Not Applicable";
                $history->activity_type = 'Comments';
                $history->current = $request->comments;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $PreventiveMaintenances->status;
                $history->stage = $PreventiveMaintenances->stage;
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->save();
            }
            // ========audit trail complete========
            if ($PreventiveMaintenances_record['status'] == 'error')
            {
                throw new Error($PreventiveMaintenances_record['message']);
            } 

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
            info('Error in PreventiveMaintenancesController@store', [
                'message' => $e->getMessage()
            ]);
        }
        toastr()->success("Record is created Successfully");
        return redirect(url('rcms/qms-dashboard'));
    }


    public static function show($id)
    {
        $cft = [];
        $revised_date = "";
        $data = PreventiveMaintenances::find($id);
        // dd($data);
        $old_record = PreventiveMaintenances::select('id', 'division_id', 'record_number')->get();
        // $revised_date = Extension::where('parent_id', $id)->where('parent_type', "Preventive Maintenances")->value('revised_date');
        $data->record_number = str_pad($data->record_number, 4, '0', STR_PAD_LEFT);
        
        $data->assign_to_name = User::where('id', $data->assign_id)->value('name');
        $data->initiator_name = User::where('id', $data->initiator_id)->value('name');
        // dd($data);
         return view('frontend.preventive-maintenance.preventive-maintenance-view', 
        compact('data', 'old_record','revised_date'));

    }

    public function update(Request $request, $id)
    {
        
        $res = Helpers::getDefaultResponse();

        try {
                $input = $request->all();
                // dd($input);
                $PreventiveMaintenances = PreventiveMaintenances::findOrFail($id);
                $PreventiveMaintenances->update($input);
                $lastPreventiveMaintenancesRecod = PreventiveMaintenances::where('id', $id)->first();
            // ============= update audit trail==========
            if ($lastPreventiveMaintenancesRecod->short_description != $request->short_description){
               $history = new PreventiveMaintenancesAuditTrial();
               $history->preventive_maintenances_id = $lastPreventiveMaintenancesRecod->id;
               $history->previous = $lastPreventiveMaintenancesRecod->short_description;
               $history->activity_type = 'Short Description ';
               $history->current = $request->short_description;
               $history->comment = "Not Applicable";
               $history->user_id = Auth::user()->id;
               $history->user_name = Auth::user()->name;
               $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
               $history->origin_state = $lastPreventiveMaintenancesRecod->status;
               $history->stage = $lastPreventiveMaintenancesRecod->stage;
               $history->change_to =   "Opened";
               $history->change_from = $lastPreventiveMaintenancesRecod->status;
               $history->action_name = 'Update';
               $history->save();
           }
           if ($lastPreventiveMaintenancesRecod->due_date != $request->due_date){
            $history = new PreventiveMaintenancesAuditTrial();
            $history->preventive_maintenances_id = $lastPreventiveMaintenancesRecod->id;
            $history->previous = $lastPreventiveMaintenancesRecod->due_date;
            $history->activity_type = 'Due Date ';
            $history->current = $request->due_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastPreventiveMaintenancesRecod->status;
            $history->stage = $lastPreventiveMaintenancesRecod->stage;
            $history->change_to =   "Opened";
            $history->change_from = $lastPreventiveMaintenancesRecod->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($lastPreventiveMaintenancesRecod->additional_information != $request->additional_information){
            $history = new PreventiveMaintenancesAuditTrial();
            $history->preventive_maintenances_id = $lastPreventiveMaintenancesRecod->id;
            $history->previous = $lastPreventiveMaintenancesRecod->additional_information;
            $history->activity_type = 'Additional Information ';
            $history->current = $request->additional_information;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastPreventiveMaintenancesRecod->status;
            $history->stage = $lastPreventiveMaintenancesRecod->stage;
            $history->change_to =   "Opened";
            $history->change_from = $lastPreventiveMaintenancesRecod->status;
            $history->action_name = 'Update';
            $history->save();
        }
        
        if ($lastPreventiveMaintenancesRecod->related_urls != $request->related_urls){
            $history = new PreventiveMaintenancesAuditTrial();
            $history->preventive_maintenances_id = $lastPreventiveMaintenancesRecod->id;
            $history->previous = $lastPreventiveMaintenancesRecod->related_urls;
            $history->activity_type = 'Related Urls ';
            $history->current = $request->related_urls;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastPreventiveMaintenancesRecod->status;
            $history->stage = $lastPreventiveMaintenancesRecod->stage;
            $history->change_to =   "Opened";
            $history->change_from = $lastPreventiveMaintenancesRecod->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($lastPreventiveMaintenancesRecod->PM_frequency != $request->PM_frequency){
            $history = new PreventiveMaintenancesAuditTrial();
            $history->preventive_maintenances_id = $lastPreventiveMaintenancesRecod->id;
            $history->previous = $lastPreventiveMaintenancesRecod->PM_frequency;
            $history->activity_type = 'PM Frequency ';
            $history->current = $request->PM_frequency;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastPreventiveMaintenancesRecod->status;
            $history->stage = $lastPreventiveMaintenancesRecod->stage;
            $history->change_to =   "Opened";
            $history->change_from = $lastPreventiveMaintenancesRecod->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($lastPreventiveMaintenancesRecod->parent_site_name != $request->parent_site_name){
            $history = new PreventiveMaintenancesAuditTrial();
            $history->preventive_maintenances_id = $lastPreventiveMaintenancesRecod->id;
            $history->previous = $lastPreventiveMaintenancesRecod->parent_site_name;
            $history->activity_type = 'Parent Site Name';
            $history->current = $request->parent_site_name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastPreventiveMaintenancesRecod->status;
            $history->stage = $lastPreventiveMaintenancesRecod->stage;
            $history->change_to =   "Opened";
            $history->change_from = $lastPreventiveMaintenancesRecod->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($lastPreventiveMaintenancesRecod->parent_building != $request->parent_building){
            $history = new PreventiveMaintenancesAuditTrial();
            $history->preventive_maintenances_id = $lastPreventiveMaintenancesRecod->id;
            $history->previous = $lastPreventiveMaintenancesRecod->parent_building;
            $history->activity_type = 'Parent Building ';
            $history->current = $request->parent_building;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastPreventiveMaintenancesRecod->status;
            $history->stage = $lastPreventiveMaintenancesRecod->stage;
            $history->change_to =   "Opened";
            $history->change_from = $lastPreventiveMaintenancesRecod->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($lastPreventiveMaintenancesRecod->parent_floor != $request->parent_floor){
            $history = new PreventiveMaintenancesAuditTrial();
            $history->preventive_maintenances_id = $lastPreventiveMaintenancesRecod->id;
            $history->previous = $lastPreventiveMaintenancesRecod->parent_floor;
            $history->activity_type = 'Parent Floor ';
            $history->current = $request->parent_floor;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastPreventiveMaintenancesRecod->status;
            $history->stage = $lastPreventiveMaintenancesRecod->stage;
            $history->change_to =   "Opened";
            $history->change_from = $lastPreventiveMaintenancesRecod->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($lastPreventiveMaintenancesRecod->parent_room != $request->parent_room){
            $history = new PreventiveMaintenancesAuditTrial();
            $history->preventive_maintenances_id = $lastPreventiveMaintenancesRecod->id;
            $history->previous = $lastPreventiveMaintenancesRecod->parent_room;
            $history->activity_type = 'Parent Room ';
            $history->current = $request->parent_room;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastPreventiveMaintenancesRecod->status;
            $history->stage = $lastPreventiveMaintenancesRecod->stage;
            $history->change_to =   "Opened";
            $history->change_from = $lastPreventiveMaintenancesRecod->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($lastPreventiveMaintenancesRecod->comments != $request->comments){
            $history = new PreventiveMaintenancesAuditTrial();
            $history->preventive_maintenances_id = $lastPreventiveMaintenancesRecod->id;
            $history->previous = $lastPreventiveMaintenancesRecod->comments;
            $history->activity_type = 'Comments';
            $history->current = $request->comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastPreventiveMaintenancesRecod->status;
            $history->stage = $lastPreventiveMaintenancesRecod->stage;
            $history->change_to =   "Opened";
            $history->change_from = $lastPreventiveMaintenancesRecod->status;
            $history->action_name = 'Update';
            $history->save();
        }
        
        if ($PreventiveMaintenances_record['status'] == 'error')
            {
                throw new Error($PreventiveMaintenances_record['message']);
            } 

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
            info('Error in PreventiveMaintenancesController@store', [
                'message' => $e->getMessage()
            ]);
        }
        toastr()->success('Record is Update Successfully');
        return back();
        
        
    }

    public function send_stage(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $changestage = PreventiveMaintenances::find($id);
            $lastDocument = PreventiveMaintenances::find($id);
            if ($changestage->stage == 1) {
                $changestage->stage = "2";
                $changestage->status = "Supervisor Review";
                $changestage->completed_by_supervisor_review = Auth::user()->name;
                $changestage->completed_on_supervisor_review = Carbon::now()->format('d-M-Y');
                $changestage->comment_supervisor_review = $request->comment;
                    $history = new PreventiveMaintenancesAuditTrial();
                    $history->preventive_maintenances_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_supervisor_review;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = "2";
                    $history->save();
                //     $list = Helpers::getLeadAuditeeUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $changestage->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //              if ($email !== null) {
                            
                //               Mail::send(
                //                   'mail.view-mail',
                //                    ['data' => $changestage],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document sent ".Auth::user()->name);
                //                 }
                //               );
                //             }
                //      } 
                //   }
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changestage->stage == 2) {
                $changestage->stage = "3";
                $changestage->status = "Working in Progress";
                $changestage->completed_by_working_progress = Auth::user()->name;
                $changestage->completed_on_working_progress = Carbon::now()->format('d-M-Y');
                $changestage->comment_working_progress = $request->comment;
                    $history = new PreventiveMaintenancesAuditTrial();
                    $history->preventive_maintenances_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_working_progress;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = "3";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changestage->stage == 3) {
                $changestage->stage = "4";
                $changestage->status = "Pending QA Approval";
                $changestage->completed_by_approval_completed= Auth::user()->name;
                $changestage->completed_on_approval_completed = Carbon::now()->format('d-M-Y');
                $changestage->comment_approval_completed = $request->comment;
                    $history = new PreventiveMaintenancesAuditTrial();
                    $history->preventive_maintenances_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->current = $changestage->completed_by_approval_completed;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = "4";
                    $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($changestage->stage == 4) {
                $changestage->stage = "5";
                $changestage->status = "Close-Done";
                $changestage->completed_by_close_done= Auth::user()->name;
                $changestage->completed_on_close_done = Carbon::now()->format('d-M-Y');
                $changestage->comment_close_done = $request->comment;
                
                $history = new PreventiveMaintenancesAuditTrial();
                $history->preventive_maintenances_id = $id;
                $history->activity_type = 'Activity Log';
                $history->current = $changestage->completed_by_close_done;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = "Close-Done";
                $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }
    // ========== requestmoreinfo_back_stage ==============
    public function requestmoreinfo_back_stage(Request $request, $id)
    {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $changestage = PreventiveMaintenances::find($id);
            $lastDocument = PreventiveMaintenances::find($id);
            if ($changestage->stage == 4) {
                $changestage->stage = "2";
                $changestage->status = "Supervisor Review";
                $changestage->completed_by_supervisor_review = Auth::user()->name;
                $changestage->completed_on_supervisor_review = Carbon::now()->format('d-M-Y');
                $changestage->comment_supervisor_review = $request->comment;
                            $history = new PreventiveMaintenancesAuditTrial();
                            $history->preventive_maintenances_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->current = $changestage->completed_by_supervisor_review;
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->origin_state = $lastDocument->status;
                            $history->stage = "1";
                            $history->save();
                $changestage->update();
                toastr()->success('Document Sent');
                return back();
            }
           
            
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function cancel_stage(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $data = PreventiveMaintenances::find($id);
            $lastDocument = PreventiveMaintenances::find($id);
            $data->stage = "0";
            $data->status = "Closed-Cancelled";
            $data->cancelled_by = Auth::user()->name;
            $data->cancelled_on = Carbon::now()->format('d-M-Y');
            $data->comment_cancle = $request->comment;

                    $history = new PreventiveMaintenancesAuditTrial();
                    $history->preventive_maintenances_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->previous ="";
                    $history->current = $data->cancelled_by;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state =  $data->status;
                    $history->stage = 'Cancelled';
                    $history->save();
            $data->update();
            toastr()->success('Document Sent');
            return back();
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function AuditTrial($id)
    {
        $audit = PreventiveMaintenancesAuditTrial::where('preventive_maintenances_id', $id)->orderByDesc('id')->paginate(5);
        $today = Carbon::now()->format('d-m-y');
        $document = PreventiveMaintenances::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');
        return view('frontend.preventive-maintenance.audit-trial', compact('audit', 'document', 'today'));
    }

    public function store_audit_review(Request $request, $id)
    {
            $history = new AuditReviewersDetails;
            $history->deviation_id = $id;
            $history->user_id = Auth::user()->id;
            $history->type = $request->type;
            $history->reviewer_comment = $request->reviewer_comment;
            $history->reviewer_comment_by = Auth::user()->name;
            $history->reviewer_comment_on = Carbon::now()->toDateString();
            $history->save();

        return redirect()->back();
    }
    public function auditDetails($id)
    {

        $detail = PreventiveMaintenancesAuditTrial::find($id);
        $detail_data = PreventiveMaintenancesAuditTrial::where('activity_type', $detail->activity_type)->where('preventive_maintenances_id', $detail->id)->latest()->get();
        $doc = PreventiveMaintenances::where('id', $detail->preventive_maintenances_id)->first();
        $doc->origiator_name = User::find($doc->initiator_id);
        
        return view('frontend.preventive-maintenance.audit-trial-inner', compact('detail', 'doc', 'detail_data'));
    }
    public static function auditReport($id)
    {
        $doc = PreventiveMaintenances::find($id);
        if (!empty($doc)) {
            $doc->originator = User::where('id', $doc->initiator_id)->value('name');
            $data = PreventiveMaintenancesAuditTrial::where('preventive_maintenances_id', $id)->get();
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.preventive-maintenance.auditReport', compact('data', 'doc'))
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
            return $pdf->stream('PreventiveMaintenances-Audit' . $id . '.pdf');
        }
    }
    
    public static function singleReport($id)
    {
        $data = PreventiveMaintenances::find($id);
        if (!empty($data)) {
            // $data->info_product_materials = $data->grids()->where('identifier', 'info_product_material')->first();

            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.preventive-maintenance.singleReport', compact('data'))
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
            return $pdf->stream('Preventive Maintenances' . $id . '.pdf');
        }
    }
       
}
