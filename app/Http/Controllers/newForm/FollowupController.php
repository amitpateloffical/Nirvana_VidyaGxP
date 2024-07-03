<?php

namespace App\Http\Controllers\newForm;

use App\Http\Controllers\Controller;

use App\Models\FollowUpTask;
use App\Models\FollowUpTaskAudit;
use App\Models\RecordNumber;
use App\Models\User;
use App\Models\RoleGroup;


use Carbon\Carbon;
use PDF;
use Helpers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FollowupController extends Controller
{
    public function index(){
        $old_record = FollowUpTask::select('id', 'division_id', 'record_number')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);

        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');

        return view('frontend.followup.follow_up_task',compact('old_record', 'record_number', 'currentDate', 'formattedDate', 'due_date'));

    }

    public function store(Request $request){
        $recordCounter = RecordNumber::first();
        $newRecordNumber = $recordCounter->counter + 1;
        $recordCounter->counter = $newRecordNumber;
        $recordCounter->save();

        $task = new FollowUpTask();

        $task->record_number = $newRecordNumber;
        $task->initiator_id = Auth::user()->id;
        $task->division_id = $request->division_id;

        $task->originator_id = Auth::user()->id;
        $task->assigned_to = $request->assigned_to;
        // $task->record_number = $request->record_number;
        $task->short_description = $request->short_description;
        $task->initiation_date = $request->initiation_date;
        $task->due_date = $request->due_date;
        $task->followup_Desc = $request->followup_Desc;
        $task->division_code = $request->division_code;
        $task->parent_date = $request->parent_date;
        $task->capa_taken = $request->capa_taken;
        $task->Parent_observation = $request->Parent_observation;
        $task->parent_classification = $request->parent_classification;
        $task->tcd_date = $request->tcd_date;
        $task->execution_details = $request->execution_details;
        $task->delay_justification = $request->delay_justification;
        $task->completion_date = $request->completion_date;
        $task->varification_comments = $request->varification_comments;
        $task->cancellation_remarks = $request->cancellation_remarks;
        $task->status = 'Opened';
        $task->stage = 1;

        if (!empty($request->file_attachment)) {
            $files = [];
            if ($request->hasfile('file_attachment')) {
                foreach ($request->file('file_attachment') as $file) {
                    $name = $request->name . 'file_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $task->file_attachment = json_encode($files);
        }
        if (!empty($request->execution_attachment)) {
            $files = [];
            if ($request->hasfile('execution_attachment')) {
                foreach ($request->file('execution_attachment') as $file) {
                    $name = $request->name . 'execution_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $task->execution_attachment = json_encode($files);
        }
        if (!empty($request->verification_attachment)) {
            $files = [];
            if ($request->hasfile('verification_attachment')) {
                foreach ($request->file('verification_attachment') as $file) {
                    $name = $request->name . 'verification_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $task->verification_attachment = json_encode($files);
        }

               $task->save();

         if (!empty($request->short_description)) {

                $task3 = new FollowUpTaskAudit();
                $task3->task_id = $task->id;
                $task3->activity_type = 'short_description';
                $task3->previous = "Null";
                $task3->current = $request->short_description;
                $task3->comment = "NA";
                $task3->user_id = Auth::user()->id;
                $task3->user_name = Auth::user()->name;
                $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $task3->change_to =   "Opened";
                $task3->change_from = "Initiator";
                $task3->action_name = 'Create';
                $task3->save();
            }

            if (!empty($request->assigned_to)) {
                $task3 = new FollowUpTaskAudit();
                $task3->task_id = $task->id;
                $task3->activity_type = 'assigned_to';
                $task3->previous = "Null";
                $task3->current = $request->assigned_to;
                $task3->comment = "NA";
                $task3->user_id = Auth::user()->id;
                $task3->user_name = Auth::user()->name;
                $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $task3->change_to =   "Opened";
                $task3->change_from = "Initiator";
                $task3->action_name = 'Create';
                $task3->save();
            }
            if (!empty($request->due_date)) {
                $task3 = new FollowUpTaskAudit();
                $task3->task_id = $task->id;
                $task3->activity_type = 'due_date';
                $task3->previous = "Null";
                $task3->current = $request->due_date;
                $task3->comment = "NA";
                $task3->user_id = Auth::user()->id;
                $task3->user_name = Auth::user()->name;
                $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $task3->change_to =   "Opened";
                $task3->change_from = "Initiator";
                $task3->action_name = 'Create';
                $task3->save();
            }
            if (!empty($request->followup_Desc)) {
                $task3 = new FollowUpTaskAudit();
                $task3->task_id = $task->id;
                $task3->activity_type = 'followup_Desc';
                $task3->previous = "Null";
                $task3->current = $request->followup_Desc;
                $task3->comment = "NA";
                $task3->user_id = Auth::user()->id;
                $task3->user_name = Auth::user()->name;
                $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $task3->change_to =   "Opened";
                $task3->change_from = "Initiator";
                $task3->action_name = 'Create';
                $task3->save();
            }
            if (!empty($request->division_code)) {
                $task3 = new FollowUpTaskAudit();
                $task3->task_id = $task->id;
                $task3->activity_type = 'division_code';
                $task3->previous = "Null";
                $task3->current = $request->division_code;
                $task3->comment = "NA";
                $task3->user_id = Auth::user()->id;
                $task3->user_name = Auth::user()->name;
                $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $task3->change_to =   "Opened";
                $task3->change_from = "Initiator";
                $task3->action_name = 'Create';
                $task3->save();
            }

            if (!empty($request->parent_date)) {
                $task3 = new FollowUpTaskAudit();
                $task3->task_id = $task->id;
                $task3->activity_type = 'parent_date';
                $task3->previous = "Null";
                $task3->current = $request->parent_date;
                $task3->comment = "NA";
                $task3->user_id = Auth::user()->id;
                $task3->user_name = Auth::user()->name;
                $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $task3->change_to =   "Opened";
                $task3->change_from = "Initiator";
                $task3->action_name = 'Create';
                $task3->save();
            }

            if (!empty($request->capa_taken)) {
                $task3 = new FollowUpTaskAudit();
                $task3->task_id = $task->id;
                $task3->activity_type = 'capa_taken';
                $task3->previous = "Null";
                $task3->current = $request->capa_taken;
                $task3->comment = "NA";
                $task3->user_id = Auth::user()->id;
                $task3->user_name = Auth::user()->name;
                $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $task3->change_to =   "Opened";
                $task3->change_from = "Initiator";
                $task3->action_name = 'Create';
                $task3->save();
            }

            if (!empty($request->Parent_observation)) {
                $task3 = new FollowUpTaskAudit();
                $task3->task_id = $task->id;
                $task3->activity_type = 'Parent_observation';
                $task3->previous = "Null";
                $task3->current = $request->Parent_observation;
                $task3->comment = "NA";
                $task3->user_id = Auth::user()->id;
                $task3->user_name = Auth::user()->name;
                $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $task3->change_to =   "Opened";
                $task3->change_from = "Initiator";
                $task3->action_name = 'Create';
                $task3->save();
            }

            if (!empty($request->parent_classification)) {
                $task3 = new FollowUpTaskAudit();
                $task3->task_id = $task->id;
                $task3->activity_type = 'parent_classification';
                $task3->previous = "Null";
                $task3->current = $request->parent_classification;
                $task3->comment = "NA";
                $task3->user_id = Auth::user()->id;
                $task3->user_name = Auth::user()->name;
                $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $task3->change_to =   "Opened";
                $task3->change_from = "Initiator";
                $task3->action_name = 'Create';
                $task3->save();
            }

            if (!empty($request->tcd_date)) {
                $task3 = new FollowUpTaskAudit();
                $task3->task_id = $task->id;
                $task3->activity_type = 'tcd_date';
                $task3->previous = "Null";
                $task3->current = $request->tcd_date;
                $task3->comment = "NA";
                $task3->user_id = Auth::user()->id;
                $task3->user_name = Auth::user()->name;
                $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $task3->change_to =   "Opened";
                $task3->change_from = "Initiator";
                $task3->action_name = 'Create';
                $task3->save();
            }

            if (!empty($request->execution_details)) {
                $task3 = new FollowUpTaskAudit();
                $task3->task_id = $task->id;
                $task3->activity_type = 'execution_details';
                $task3->previous = "Null";
                $task3->current = $request->execution_details;
                $task3->comment = "NA";
                $task3->user_id = Auth::user()->id;
                $task3->user_name = Auth::user()->name;
                $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $task3->change_to =   "Opened";
                $task3->change_from = "Initiator";
                $task3->action_name = 'Create';
                $task3->save();
            }

            if (!empty($request->delay_justification)) {
                $task3 = new FollowUpTaskAudit();
                $task3->task_id = $task->id;
                $task3->activity_type = 'delay_justification';
                $task3->previous = "Null";
                $task3->current = $request->delay_justification;
                $task3->comment = "NA";
                $task3->user_id = Auth::user()->id;
                $task3->user_name = Auth::user()->name;
                $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $task3->change_to =   "Opened";
                $task3->change_from = "Initiator";
                $task3->action_name = 'Create';
                $task3->save();
            }

            if (!empty($request->completion_date)) {
                $task3 = new FollowUpTaskAudit();
                $task3->task_id = $task->id;
                $task3->activity_type = 'completion_date';
                $task3->previous = "Null";
                $task3->current = $request->completion_date;
                $task3->comment = "NA";
                $task3->user_id = Auth::user()->id;
                $task3->user_name = Auth::user()->name;
                $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $task3->change_to =   "Opened";
                $task3->change_from = "Initiator";
                $task3->action_name = 'Create';
                $task3->save();
            }
            if (!empty($request->varification_comments)) {
                $task3 = new FollowUpTaskAudit();
                $task3->task_id = $task->id;
                $task3->activity_type = 'varification_comments';
                $task3->previous = "Null";
                $task3->current = $request->varification_comments;
                $task3->comment = "NA";
                $task3->user_id = Auth::user()->id;
                $task3->user_name = Auth::user()->name;
                $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $task3->change_to =   "Opened";
                $task3->change_from = "Initiator";
                $task3->action_name = 'Create';
                $task3->save();
            }

            if (!empty($request->cancellation_remarks)) {
                $task3 = new FollowUpTaskAudit();
                $task3->task_id = $task->id;
                $task3->activity_type = 'cancellation_remarks';
                $task3->previous = "Null";
                $task3->current = $request->cancellation_remarks;
                $task3->comment = "NA";
                $task3->user_id = Auth::user()->id;
                $task3->user_name = Auth::user()->name;
                $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $task3->change_to =   "Opened";
                $task3->change_from = "Initiator";
                $task3->action_name = 'Create';
                $task3->save();
            }

               toastr()->success("Followup Task is created succusfully");
               return redirect(url('rcms/qms-dashboard'));

         }

    public function view($id){

        $task = FollowUpTask::findOrFail($id);
            // $record_number = str_pad($task->record_number, 4, '0', STR_PAD_LEFT);
           return view('frontend.followup.view_follow_up_task', compact('task'));

    }



    public function followupUpdate(Request $request,$id){



       $task1 = FollowUpTask::findOrFail($id);

       $task1->initiator_id = Auth::user()->id;
       $task1->division_id = $request->division_id;
       $task1->originator_id = Auth::user()->id;
       $task1->assigned_to = $request->assigned_to;
     //  $task1->record_number = $request->record_number;
       $task1->short_description = $request->short_description;
       $task1->initiation_date = $request->initiation_date;
       $task1->due_date = $request->due_date;
       $task1->followup_Desc = $request->followup_Desc;
       $task1->division_code = $request->division_code;
       $task1->parent_date = $request->parent_date;
       $task1->capa_taken = $request->capa_taken;
       $task1->Parent_observation = $request->Parent_observation;
       $task1->parent_classification = $request->parent_classification;
       $task1->tcd_date = $request->tcd_date;
       $task1->execution_details = $request->execution_details;
       $task1->delay_justification = $request->delay_justification;
       $task1->completion_date = $request->completion_date;
       $task1->varification_comments = $request->varification_comments;
       $task1->cancellation_remarks = $request->cancellation_remarks;

       if (!empty($request->file_attachment)) {
        $files = [];
        if ($request->hasfile('file_attachment')) {
            foreach ($request->file('file_attachment') as $file) {
                $name = $request->name . 'file_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $task1->file_attachment = json_encode($files);
    }


    if (!empty($request->execution_attachment)) {
        $files = [];
        if ($request->hasfile('execution_attachment')) {
            foreach ($request->file('execution_attachment') as $file) {
                $name = $request->name . 'execution_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $task1->execution_attachment = json_encode($files);
    }

    if (!empty($request->verification_attachment)) {
        $files = [];
        if ($request->hasfile('verification_attachment')) {
            foreach ($request->file('verification_attachment') as $file) {
                $name = $request->name . 'verification_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $task1->verification_attachment = json_encode($files);
    }

    $task1->update();

    if (!empty($request->short_description)) {
        $task3 = new FollowUpTaskAudit();
        $task3->task_id = $task1->id;
        $task3->activity_type = 'short_description';
        $task3->previous = "Null";
        $task3->current = $request->short_description;
        $task3->comment = "NA";
        $task3->user_id = Auth::user()->id;
        $task3->user_name = Auth::user()->name;
        $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

        $task3->change_to =  "Not Applicable";
        $task3->change_from = $task1->status;
        $task3->action_name = 'Update';
        $task3->save();

    }


    if (!empty($request->assigned_to)) {
        $task3 = new FollowUpTaskAudit();
        $task3->task_id = $task1->id;
        $task3->activity_type = 'assigned_to';
        $task3->previous = "Null";
        $task3->current = $request->assigned_to;
        $task3->comment = "NA";
        $task3->user_id = Auth::user()->id;
        $task3->user_name = Auth::user()->name;
        $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


        $task3->change_to =  "Not Applicable";
        $task3->change_from = $task1->status;
        $task3->action_name = 'Update';
        $task3->save();
    }
    if (!empty($request->due_date)) {
        $task3 = new FollowUpTaskAudit();
        $task3->task_id = $task1->id;
        $task3->activity_type = 'due_date';
        $task3->previous = "Null";
        $task3->current = $request->due_date;
        $task3->comment = "NA";
        $task3->user_id = Auth::user()->id;
        $task3->user_name = Auth::user()->name;
        $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


        $task3->change_to =  "Not Applicable";
        $task3->change_from = $task1->status;
        $task3->action_name = 'Update';
        $task3->save();
    }
    if (!empty($request->followup_Desc)) {
        $task3 = new FollowUpTaskAudit();
        $task3->task_id = $task1->id;
        $task3->activity_type = 'followup_Desc';
        $task3->previous = "Null";
        $task3->current = $request->followup_Desc;
        $task3->comment = "NA";
        $task3->user_id = Auth::user()->id;
        $task3->user_name = Auth::user()->name;
        $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


        $task3->change_to =  "Not Applicable";
        $task3->change_from = $task1->status;
        $task3->action_name = 'Update';
        $task3->save();
    }
    if (!empty($request->division_code)) {
        $task3 = new FollowUpTaskAudit();
        $task3->task_id = $task1->id;
        $task3->activity_type = 'division_code';
        $task3->previous = "Null";
        $task3->current = $request->division_code;
        $task3->comment = "NA";
        $task3->user_id = Auth::user()->id;
        $task3->user_name = Auth::user()->name;
        $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


        $task3->change_to =  "Not Applicable";
        $task3->change_from = $task1->status;
        $task3->action_name = 'Update';
        $task3->save();
    }

    if (!empty($request->parent_date)) {
        $task3 = new FollowUpTaskAudit();
        $task3->task_id = $task1->id;
        $task3->activity_type = 'parent_date';
        $task3->previous = "Null";
        $task3->current = $request->parent_date;
        $task3->comment = "NA";
        $task3->user_id = Auth::user()->id;
        $task3->user_name = Auth::user()->name;
        $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


        $task3->change_to =  "Not Applicable";
        $task3->change_from = $task1->status;
        $task3->action_name = 'Update';
        $task3->save();
    }

    if (!empty($request->capa_taken)) {
        $task3 = new FollowUpTaskAudit();
        $task3->task_id = $task1->id;
        $task3->activity_type = 'capa_taken';
        $task3->previous = "Null";
        $task3->current = $request->capa_taken;
        $task3->comment = "NA";
        $task3->user_id = Auth::user()->id;
        $task3->user_name = Auth::user()->name;
        $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


        $task3->change_to =  "Not Applicable";
        $task3->change_from = $task1->status;
        $task3->action_name = 'Update';
        $task3->save();
    }

    if (!empty($request->Parent_observation)) {
        $task3 = new FollowUpTaskAudit();
        $task3->task_id = $task1->id;
        $task3->activity_type = 'Parent_observation';
        $task3->previous = "Null";
        $task3->current = $request->Parent_observation;
        $task3->comment = "NA";
        $task3->user_id = Auth::user()->id;
        $task3->user_name = Auth::user()->name;
        $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


        $task3->change_to =  "Not Applicable";
        $task3->change_from = $task1->status;
        $task3->action_name = 'Update';
        $task3->save();
    }

    if (!empty($request->parent_classification)) {
        $task3 = new FollowUpTaskAudit();
        $task3->task_id = $task1->id;
        $task3->activity_type = 'parent_classification';
        $task3->previous = "Null";
        $task3->current = $request->parent_classification;
        $task3->comment = "NA";
        $task3->user_id = Auth::user()->id;
        $task3->user_name = Auth::user()->name;
        $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


        $task3->change_to =  "Not Applicable";
        $task3->change_from = $task1->status;
        $task3->action_name = 'Update';
        $task3->save();
    }

    if (!empty($request->tcd_date)) {
        $task3 = new FollowUpTaskAudit();
        $task3->task_id = $task1->id;
        $task3->activity_type = 'tcd_date';
        $task3->previous = "Null";
        $task3->current = $request->tcd_date;
        $task3->comment = "NA";
        $task3->user_id = Auth::user()->id;
        $task3->user_name = Auth::user()->name;
        $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


        $task3->change_to =  "Not Applicable";
        $task3->change_from = $task1->status;
        $task3->action_name = 'Update';
        $task3->save();
    }

    if (!empty($request->execution_details)) {
        $task3 = new FollowUpTaskAudit();
        $task3->task_id = $task1->id;
        $task3->activity_type = 'execution_details';
        $task3->previous = "Null";
        $task3->current = $request->execution_details;
        $task3->comment = "NA";
        $task3->user_id = Auth::user()->id;
        $task3->user_name = Auth::user()->name;
        $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


        $task3->change_to =  "Not Applicable";
        $task3->change_from = $task1->status;
        $task3->action_name = 'Update';
        $task3->save();
    }

    if (!empty($request->delay_justification)) {
        $task3 = new FollowUpTaskAudit();
        $task3->task_id = $task1->id;
        $task3->activity_type = 'delay_justification';
        $task3->previous = "Null";
        $task3->current = $request->delay_justification;
        $task3->comment = "NA";
        $task3->user_id = Auth::user()->id;
        $task3->user_name = Auth::user()->name;
        $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


        $task3->change_to =  "Not Applicable";
        $task3->change_from = $task1->status;
        $task3->action_name = 'Update';
        $task3->save();
    }

    if (!empty($request->completion_date)) {
        $task3 = new FollowUpTaskAudit();
        $task3->task_id = $task1->id;
        $task3->activity_type = 'completion_date';
        $task3->previous = "Null";
        $task3->current = $request->completion_date;
        $task3->comment = "NA";
        $task3->user_id = Auth::user()->id;
        $task3->user_name = Auth::user()->name;
        $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

        $task3->change_to =  "Not Applicable";
        $task3->change_from = $task1->status;
        $task3->action_name = 'Update';
        $task3->save();
    }
    if (!empty($request->varification_comments)) {
        $task3 = new FollowUpTaskAudit();
        $task3->task_id = $task1->id;
        $task3->activity_type = 'varification_comments';
        $task3->previous = "Null";
        $task3->current = $request->varification_comments;
        $task3->comment = "NA";
        $task3->user_id = Auth::user()->id;
        $task3->user_name = Auth::user()->name;
        $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


        $task3->change_to =  "Not Applicable";
        $task3->change_from = $task1->status;
        $task3->action_name = 'Update';
        $task3->save();
    }

    if (!empty($request->cancellation_remarks)) {
        $task3 = new FollowUpTaskAudit();
        $task3->task_id = $task1->id;
        $task3->activity_type = 'cancellation_remarks';
        $task3->previous = "Null";
        $task3->current = $request->cancellation_remarks;
        $task3->comment = "NA";
        $task3->user_id = Auth::user()->id;
        $task3->user_name = Auth::user()->name;
        $task3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


        $task3->change_to =  "Not Applicable";
        $task3->change_from = $task1->status;
        $task3->action_name = 'Update';
        $task3->save();
    }



    toastr()->success("followup task is updated succusfully");
    return redirect(url('rcms/qms-dashboard'));

    }

    public function followup_sends_stage(Request $request,$id){

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $task2 = FollowUpTask::find($id);
            $lastDocument = FollowUpTask::find($id);

            if ( $task2->stage == 1) {
                $task2->stage = "2";
                $task2->status = "Compliance In-Progress";
                $task2->submitted_by = Auth::user()->name;
                $task2->submitted_on = Carbon::now()->format('d-m-y');
                $task2->comment = $request->comment;

               $history = new followUpTaskAudit();
               $history->task_id = $id;
               $history->activity_type = 'Activity Log';
               $history->previous = $lastDocument->submitted_by;
               $history->current = $task2->submitted_on;
               //$history->comment = $request->comment;
               $history->user_id = Auth::user()->id;
               $history->user_name = Auth::user()->name;
               $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
              // $history->origin_state = $lastDocument->status;

              $history->change_from = '$task1->status';
               $history->change_to = 'Not Applicable';
               $history->stage='Submitted';
               $history->action_name ='Submitted';
              $history->save();
               $list = Helpers::getHodUserList();
                   foreach ($list as $u) {

                       if($u->q_m_s_divisions_id == $task2->division_id){
                           $email = Helpers::getInitiatorEmail($u->user_id);
                            if ($email !== null) {

                             Mail::send(
                                 'mail.view-mail',
                                  ['data' => $task2],
                               function ($message) use ($email) {
                                   $message->to($email)
                                       ->subject("Document is Submitted By ".Auth::user()->name);
                               }
                             );
                           }
                    }
                 }

               $task2->update();
               toastr()->success('Document Sent');
               return back();
            }


            if ( $task2->stage == 2) {
                $task2->stage = "3";
                $task2->status = "Compliance In-Progress";
                $task2->compliance_by = Auth::user()->name;
                $task2->compliance_on = Carbon::now()->format('d-m-y');
                $task2->compliance_comment = $request->comment;

                $history = new followUpTaskAudit();
                $history->task_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->compliance_by;
                $history->current = $task2->compliance_on;
                //$history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
               // $history->origin_state = $lastDocument->status;

               $history->change_from = '$task1->status';
               $history->change_to = 'Not Applicable';
                $history->stage='Submitted';
                $history->action_name ='Submitted';
                $history->save();
                $list = Helpers::getHodUserList();
                    foreach ($list as $u) {

                        if($u->q_m_s_divisions_id == $task2->division_id){
                            $email = Helpers::getInitiatorEmail($u->user_id);
                             if ($email !== null) {

                              Mail::send(
                                  'mail.view-mail',
                                   ['data' => $task2],
                                function ($message) use ($email) {
                                    $message->to($email)
                                        ->subject("Document is Submitted By ".Auth::user()->name);
                                }
                              );
                            }
                     }
                  }

                $task2->update();
                toastr()->success('Document Sent');
                return back();
            }


            if ( $task2->stage == 3) {
                $task2->stage = "4";
                $task2->status = "Closed - Done";
                $task2->varification_by = Auth::user()->name;
                $task2->varification_on = Carbon::now()->format('d-m-y');
                $task2->varification_comment = $request->comment;

               $history = new followUpTaskAudit();
               $history->task_id = $id;
               $history->activity_type = 'Activity Log';
               $history->previous = $lastDocument->varification_by;
               $history->current = $task2->varification_on;
               //$history->comment = $request->comment;
               $history->user_id = Auth::user()->id;
               $history->user_name = Auth::user()->name;
               $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
              // $history->origin_state = $lastDocument->status;

              $history->change_from = '$task1->status';
              $history->change_to = 'Not Applicable';
               $history->stage='Submitted';
               $history->action_name ='Submitted';
               $history->save();
               $list = Helpers::getHodUserList();
                   foreach ($list as $u) {

                       if($u->q_m_s_divisions_id == $task2->division_id){
                           $email = Helpers::getInitiatorEmail($u->user_id);
                            if ($email !== null) {

                             Mail::send(
                                 'mail.view-mail',
                                  ['data' => $task2],
                               function ($message) use ($email) {
                                   $message->to($email)
                                       ->subject("Document is Submitted By ".Auth::user()->name);
                               }
                             );
                           }
                    }
                 }

                $task2->update();
                toastr()->success('Document Sent');
                return back();
            }
         }else{
            toastr()->error("E-signature Not match");
            return back();
         }
        }





    public function followup_qa_more_info(Request $request,$id){
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $task2 = FollowUpTask::find($id);

            if ($task2->stage == 2) {
                $task2->stage = "1";
                $task2->status = "Opened";
                $task2->open_state_by = Auth::user()->name;
                $task2->open_state_on = Carbon::now()->format('d-m-y');
                $task2->open_state_comment = $request->comment;
                $task2->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($task2->stage == 3) {
                $task2->stage = "2";
                $task2->status = "Compliance In-Progress";
                $task2->progress_by = Auth::user()->name;
                $task2->progress_on = Carbon::now()->format('d-m-y');
                $task2->progress_comment = $request->comment;
                $task2->update();
                toastr()->success('Document Sent');
                return back();
            }
        }
    }




    public function  followup_Cancel (Request $request,$id){
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
           $task2 = FollowUpTask::find($id);
           $lastDocument = FollowUpTask::find($id);


        if ($task2->stage == 1) {
           $task2->stage = "0";
           $task2->status = "Closed-Cancelled";
           $task2->cancel_by = Auth::user()->name;
           $task2->cancel_on = Carbon::now()->format('d-m-y');
           $task2->cancellation_comment = $request->comment;

           $task2->update();
           toastr()->success('Document Sent');
           return back();
       }
       if ($task2->stage == 3) {
        $task2->stage = "4";
        $task2->status = "Closed - Done";
        $task2->varification_by = Auth::user()->name;
        $task2->varification_on = Carbon::now()->format('d-m-y');
        $task2->varification_comment = $request->comment;
        $task2->update();
       toastr()->success('Document Sent');
       return back();
   }



}
    }
    public function followupAuditTrail($id){
        $audit = FollowUpTaskAudit::where('task_id', $id)->orderByDESC('id')->paginate(5);
            $today = Carbon::now()->format('d-m-y');
            $document = FollowUpTask::where('id', $id)->first();
            $document->initiator = User::where('id', $document->initiator_id)->value('name');
            return view('frontend.followup.followup_auditTrail', compact('audit', 'document', 'today'));

    }
    public function followupauditReport($id){

        $doc = FollowUpTask::find($id);
        $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        $data = FollowUpTaskAudit::where('task_id', $doc->id)->orderByDesc('id')->get();
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.followup.followuptask_auditReport', compact('data', 'doc'))
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


    public function followupAuditDetails($id){
        $detail = FollowUpTaskAudit::find($id);
        $detail_data =FollowUpTaskAudit::where('activity_type', $detail->activity_type)->where('task_id', $detail->task_id)->latest()->get();
        $doc = FollowUpTask::where('id', $detail->task_id)->first();
        // $doc->origiator_name = User::find($doc->initiator_id);
        return view('frontend.followup.followup_auditDetails', compact('detail', 'doc', 'detail_data'));

    }



    public function followupauditSingleReport($id){

        $data = FollowUpTask::find($id);

        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');

            $doc = FollowUpTaskAudit::where('task_id', $data->id)->first();
            $detail_data = FollowUpTaskAudit::where('activity_type', $data->activity_type)
                ->where('task_id', $data->lab_id)
                ->latest()
                ->get();

            // pdf related work
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.followup.followup_singleReport', compact(
                'detail_data',
                'doc',
                'data'
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
                $canvas->page_text($width / 4, $height / 2, $data->status, null, 25, [0, 0, 0], 2, 6, -20);
                return $pdf->stream('Lab test' . $id . '.pdf');

        }

        return redirect()->back()->with('error', 'Lab test not found.');
    }




}


