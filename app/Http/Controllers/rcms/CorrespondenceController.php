<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Correspondence;
use App\Models\CorrespondenceGrid;
use Illuminate\Support\Facades\Auth;
use App\Models\RecordNumber;
use App\Models\User;
use App\Models\QMSDivision;
use App\Models\RoleGroup;
use App\Models\CorrespondenceAuditTrail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use PDF;

class CorrespondenceController extends Controller{

            public function index(){

                    $old_record = Correspondence::select('id', 'division_id', 'record')->get();
                    $record_number = ((RecordNumber::first()->value('counter')) + 1);
                    $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
                    $users = User::all();
                    $qmsDevisions = QMSDivision::all();

                    $currentDate = Carbon::now();
                    $formattedDate = $currentDate->addDays(30);
                    $due_date = $formattedDate->format('Y-m-d');

                    return view('frontend.New_forms.correspondence',compact('old_record','record_number','users','qmsDevisions','due_date'));
            }

            public function store(Request $request){
                    //dd($request->all());
                    $correspondence = new Correspondence();
                    $correspondence->form_type = "Correspondence";
                    $correspondence->record = ((RecordNumber::first()->value('counter')) + 1);
                    $correspondence->initiator_id = Auth::user()->id;
                    $correspondence->division_id = $request->division_id;
                    $correspondence->division_code = $request->division_code;
                    $correspondence->intiation_date = $request->intiation_date;
                    $correspondence->due_date = Carbon::now()->addDays(30)->format('d-M-Y');
                    $correspondence->parent_id = $request->parent_id;
                    $correspondence->parent_type = $request->parent_type;
                    $correspondence->short_description = $request->short_description;
                    $correspondence->assigned_to = $request->assigned_to;
                    $correspondence->process_application = $request->process_application;
                    $correspondence->trade_name = $request->trade_name;
                    $correspondence->how_initiated = $request->how_initiated;
                    $correspondence->type = $request->type;

                    if (!empty ($request->file_attachments)) {
                        $files = [];
                        if ($request->hasfile('file_attachments')) {
                            foreach ($request->file('file_attachments') as $file) {
                                $name = $request->name . 'file_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                                $file->move('upload/', $name);
                                $files[] = $name;
                            }
                        }


                        $correspondence->file_attachments = $files;
                    }

                    $correspondence->authority_type = $request->authority_type;
                    $correspondence->authority = $request->authority;
                    $correspondence->description = $request->description;
                    $correspondence->commitment_required = $request->commitment_required;
                    $correspondence->priority_level = $request->priority_level;
                    $correspondence->date_due_to_authority = $request->date_due_to_authority;
                    $correspondence->scheduled_start_date = $request->scheduled_start_date;
                    $correspondence->scheduled_end_date = $request->scheduled_end_date;
                    $correspondence->stage = '1';
                    $correspondence->status = 'Opened';
                    $correspondence->save();

                    //Grid Store

                    $g_id = $correspondence->id;
                    $newDataGridCorrespondence = CorrespondenceGrid::where(['correspondence_id' => $g_id, 'identifier' => 'action_plan'])->firstOrCreate();
                    $newDataGridCorrespondence->correspondence_id = $g_id;
                    $newDataGridCorrespondence->identifier = 'action_plan';
                    $newDataGridCorrespondence->data = $request->action_plan;
                    $newDataGridCorrespondence->save();

                //Audit Trail Store Start

                if(!empty($request->short_description)){
                    $history = new CorrespondenceAuditTrail();
                    $history->correspondence_id = $correspondence->id;
                    $history->previous = "Null";
                    $history->current = $request->short_description;
                    $history->activity_type = 'Short Description';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                    if(!empty($request->assigned_to)){

                        $assigned_to_name = User::where('id', $request->assigned_to)->value('name');

                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = "Null";
                        $history->current = $assigned_to_name;
                        $history->activity_type = 'Assigned To';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_to =   "Opened";
                        $history->change_from = "Initiation";
                        $history->action_name = 'Create';
                        $history->comment = "Not Applicable";
                        $history->save();
                    }

                    if(!empty($request->due_date)){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = "Null";
                        $history->current = date('d-M-Y', strtotime($request->due_date));
                        $history->activity_type = 'Date Due';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_to =   "Opened";
                        $history->change_from = "Initiation";
                        $history->action_name = 'Create';
                        $history->comment = "Not Applicable";
                        $history->save();
                    }

                    if(!empty($request->process_application)){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = "Null";
                        $history->current = $request->process_application;
                        $history->activity_type = 'Process/Application';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_to =   "Opened";
                        $history->change_from = "Initiation";
                        $history->action_name = 'Create';
                        $history->comment = "Not Applicable";
                        $history->save();
                    }

                    if(!empty($request->trade_name)){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = "Null";
                        $history->current = $request->trade_name;
                        $history->activity_type = 'Trade Name';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_to =   "Opened";
                        $history->change_from = "Initiation";
                        $history->action_name = 'Create';
                        $history->comment = "Not Applicable";
                        $history->save();
                    }

                    if(!empty($request->how_initiated)){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = "Null";
                        $history->current = $request->how_initiated;
                        $history->activity_type = 'How Initiated';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_to =   "Opened";
                        $history->change_from = "Initiation";
                        $history->action_name = 'Create';
                        $history->comment = "Not Applicable";
                        $history->save();
                    }

                    if(!empty($request->type)){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = "Null";
                        $history->current = $request->type;
                        $history->activity_type = 'Type';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_to =   "Opened";
                        $history->change_from = "Initiation";
                        $history->action_name = 'Create';
                        $history->comment = "Not Applicable";
                        $history->save();
                    }

                    if(!empty($correspondence->file_attachments)){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = "Null";
                        $history->current = json_encode($correspondence->file_attachments);
                        $history->activity_type = 'File Attachments';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_to =   "Opened";
                        $history->change_from = "Initiation";
                        $history->action_name = 'Create';
                        $history->comment = "Not Applicable";
                        $history->save();
                    }

                    if(!empty($request->authority_type)){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = "Null";
                        $history->current = $request->authority_type;
                        $history->activity_type = 'Authority Type';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_to =   "Opened";
                        $history->change_from = "Initiation";
                        $history->action_name = 'Create';
                        $history->comment = "Not Applicable";
                        $history->save();
                    }

                    if(!empty($request->authority)){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = "Null";
                        $history->current = $request->authority;
                        $history->activity_type = 'Authority';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_to =   "Opened";
                        $history->change_from = "Initiation";
                        $history->action_name = 'Create';
                        $history->comment = "Not Applicable";
                        $history->save();
                    }

                    if(!empty($request->description)){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = "Null";
                        $history->current = $request->description;
                        $history->activity_type = 'Description';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_to =   "Opened";
                        $history->change_from = "Initiation";
                        $history->action_name = 'Create';
                        $history->comment = "Not Applicable";
                        $history->save();
                    }

                    if(!empty($request->commitment_required)){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = "Null";
                        $history->current = $request->commitment_required;
                        $history->activity_type = 'Commitment Required';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_to =   "Opened";
                        $history->change_from = "Initiation";
                        $history->action_name = 'Create';
                        $history->comment = "Not Applicable";
                        $history->save();
                    }

                    if(!empty($request->priority_level)){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = "Null";
                        $history->current = $request->priority_level;
                        $history->activity_type = 'Priority Level';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_to =   "Opened";
                        $history->change_from = "Initiation";
                        $history->action_name = 'Create';
                        $history->comment = "Not Applicable";
                        $history->save();
                    }

                    if(!empty($request->date_due_to_authority)){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = "Null";
                        $history->current = $request->date_due_to_authority;
                        $history->activity_type = 'Date Due to Authority';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_to =   "Opened";
                        $history->change_from = "Initiation";
                        $history->action_name = 'Create';
                        $history->comment = "Not Applicable";
                        $history->save();
                    }

                    if(!empty($request->scheduled_start_date)){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = "Null";
                        $history->current = $request->scheduled_start_date;
                        $history->activity_type = 'Scheduled Start Date';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_to =   "Opened";
                        $history->change_from = "Initiation";
                        $history->action_name = 'Create';
                        $history->comment = "Not Applicable";
                        $history->save();
                    }

                    if(!empty($request->scheduled_end_date)){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = "Null";
                        $history->current = $request->scheduled_end_date;
                        $history->activity_type = 'Scheduled End Date';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_to =   "Opened";
                        $history->change_from = "Initiation";
                        $history->action_name = 'Create';
                        $history->comment = "Not Applicable";
                        $history->save();
                    }

                    toastr()->success("Record is created Successfully");
                    return redirect(url('rcms/qms-dashboard'));
            }

            public function edit($id){

                    $correspondence_data = Correspondence::findOrFail($id);

                    $old_record = Correspondence::select('id', 'division_id', 'record')->get();
                    $record_number = ((RecordNumber::first()->value('counter')) + 1);
                    $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
                    $users = User::all();
                    $qmsDevisions = QMSDivision::all();

                    $currentDate = Carbon::now();
                    $formattedDate = $currentDate->addDays(30);
                    $due_date = $formattedDate->format('Y-m-d');

                    $g_id = $correspondence_data->id;
                    $grid_Data = CorrespondenceGrid::where(['correspondence_id' => $g_id, 'identifier' => 'action_plan'])->first();
                    //dd($grid_Data);

                    return view('frontend.New_forms.correspondence_view',compact('correspondence_data','old_record','record_number','users','qmsDevisions','due_date','grid_Data'));

            }

            public function update(Request $request, $id){
                    //dd($request->all());
                    $correspondence_data = Correspondence::findOrFail($id);

                    $correspondence = Correspondence::findOrFail($id);

                    $correspondence->form_type = "Correspondence";
                    $correspondence->record = ((RecordNumber::first()->value('counter')) + 1);
                    $correspondence->initiator_id = Auth::user()->id;
                    $correspondence->division_id = $request->division_id;
                    $correspondence->division_code = $request->division_code;
                    $correspondence->intiation_date = $request->intiation_date;
                    $correspondence->due_date = Carbon::now()->addDays(30)->format('d-M-Y');
                    $correspondence->parent_id = $request->parent_id;
                    $correspondence->parent_type = $request->parent_type;
                    $correspondence->short_description = $request->short_description;
                    $correspondence->assigned_to = $request->assigned_to;
                    $correspondence->process_application = $request->process_application;
                    $correspondence->trade_name = $request->trade_name;
                    $correspondence->how_initiated = $request->how_initiated;
                    $correspondence->type = $request->type;

                    if (!empty ($request->file_attachments)) {
                        $files = [];
                        if ($request->hasfile('file_attachments')) {
                            foreach ($request->file('file_attachments') as $file) {
                                $name = $request->name . 'file_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                                $file->move('upload/', $name);
                                $files[] = $name;
                            }
                        }


                        $correspondence->file_attachments = $files;
                    }

                    $correspondence->authority_type = $request->authority_type;
                    $correspondence->authority = $request->authority;
                    $correspondence->description = $request->description;
                    $correspondence->commitment_required = $request->commitment_required;
                    $correspondence->priority_level = $request->priority_level;
                    $correspondence->date_due_to_authority = $request->date_due_to_authority;
                    $correspondence->scheduled_start_date = $request->scheduled_start_date;
                    $correspondence->scheduled_end_date = $request->scheduled_end_date;
                    $correspondence->stage = '1';
                    $correspondence->status = 'Opened';
                    $correspondence->save();

                    //Grid Update

                    $g_id = $correspondence->id;
                    $newDataGridCorrespondence = CorrespondenceGrid::where(['correspondence_id' => $g_id, 'identifier' => 'action_plan'])->firstOrCreate();
                    $newDataGridCorrespondence->correspondence_id = $g_id;
                    $newDataGridCorrespondence->identifier = 'action_plan';
                    $newDataGridCorrespondence->data = $request->action_plan;
                    $newDataGridCorrespondence->save();


                 //Audit Trail Update Start

                    if($correspondence_data->short_description != $correspondence->short_description){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = $correspondence_data->short_description;
                        $history->current = $correspondence->short_description;
                        $history->activity_type = 'Short Description';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $correspondence_data->status;
                        $history->change_to = "Not Applicable";
                        if (is_null($correspondence_data->short_description) || $correspondence_data->short_description === '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                    if($correspondence_data->assigned_to != $correspondence->assigned_to){

                        $previous_assigned_to_name = User::where('id', $correspondence_data->assigned_to)->value('name');
                        $current_assigned_to_name = User::where('id', $correspondence->assigned_to)->value('name');

                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = $previous_assigned_to_name;
                        $history->current = $current_assigned_to_name;
                        $history->activity_type = 'Assigned To';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $correspondence_data->status;
                        $history->change_to = "Not Applicable";
                        if (is_null($correspondence_data->assigned_to) || $correspondence_data->assigned_to === '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                    if($correspondence_data->due_date != $correspondence->due_date){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = $correspondence_data->due_date;
                        $history->current = $correspondence->due_date;
                        $history->activity_type = 'Date Due';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $correspondence_data->status;
                        $history->change_to = "Not Applicable";
                        if (is_null($correspondence_data->due_date) || $correspondence_data->due_date === '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                    if($correspondence_data->process_application != $correspondence->process_application){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = $correspondence_data->process_application;
                        $history->current = $correspondence->process_application;
                        $history->activity_type = 'Process/Application';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $correspondence_data->status;
                        $history->change_to = "Not Applicable";
                        if (is_null($correspondence_data->process_application) || $correspondence_data->process_application === '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                    if($correspondence_data->trade_name != $correspondence->trade_name){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = $correspondence_data->trade_name;
                        $history->current = $correspondence->trade_name;
                        $history->activity_type = 'Trade Name';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $correspondence_data->status;
                        $history->change_to = "Not Applicable";
                        if (is_null($correspondence_data->trade_name) || $correspondence_data->trade_name === '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                    if($correspondence_data->how_initiated != $correspondence->how_initiated){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = $correspondence_data->how_initiated;
                        $history->current = $correspondence->how_initiated;
                        $history->activity_type = 'How Initiated';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $correspondence_data->status;
                        $history->change_to = "Not Applicable";
                        if (is_null($correspondence_data->how_initiated) || $correspondence_data->how_initiated === '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                    if($correspondence_data->type != $correspondence->type){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = $correspondence_data->type;
                        $history->current = $correspondence->type;
                        $history->activity_type = 'Type';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $correspondence_data->status;
                        $history->change_to = "Not Applicable";
                        if (is_null($correspondence_data->type) || $correspondence_data->type === '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                    if($correspondence_data->file_attachments != $correspondence->file_attachments){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = json_encode($correspondence_data->file_attachments);
                        $history->current = json_encode($correspondence->file_attachments);
                        $history->activity_type = 'File Attachments';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $correspondence_data->status;
                        $history->change_to = "Not Applicable";
                        if (is_null($correspondence_data->file_attachments) || $correspondence_data->file_attachments === '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                    if($correspondence_data->authority_type != $correspondence->authority_type){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = $correspondence_data->authority_type;
                        $history->current = $correspondence->authority_type;
                        $history->activity_type = 'Authority Type';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $correspondence_data->status;
                        $history->change_to = "Not Applicable";
                        if (is_null($correspondence_data->authority_type) || $correspondence_data->authority_type === '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                    if($correspondence_data->authority != $correspondence->authority){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = $correspondence_data->authority;
                        $history->current = $correspondence->authority;
                        $history->activity_type = 'Authority';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $correspondence_data->status;
                        $history->change_to = "Not Applicable";
                        if (is_null($correspondence_data->authority) || $correspondence_data->authority === '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                    if($correspondence_data->description != $correspondence->description){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = $correspondence_data->description;
                        $history->current = $correspondence->description;
                        $history->activity_type = 'Description';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $correspondence_data->status;
                        $history->change_to = "Not Applicable";
                        if (is_null($correspondence_data->description) || $correspondence_data->description === '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                    if($correspondence_data->commitment_required != $correspondence->commitment_required){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = $correspondence_data->commitment_required;
                        $history->current = $correspondence->commitment_required;
                        $history->activity_type = 'Commitment Required';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $correspondence_data->status;
                        $history->change_to = "Not Applicable";
                        if (is_null($correspondence_data->commitment_required) || $correspondence_data->commitment_required === '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                    if($correspondence_data->priority_level != $correspondence->priority_level){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = $correspondence_data->priority_level;
                        $history->current = $correspondence->priority_level;
                        $history->activity_type = 'Priority Level';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $correspondence_data->status;
                        $history->change_to = "Not Applicable";
                        if (is_null($correspondence_data->priority_level) || $correspondence_data->priority_level === '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                    if($correspondence_data->date_due_to_authority != $correspondence->date_due_to_authority){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = $correspondence_data->date_due_to_authority;
                        $history->current = $correspondence->date_due_to_authority;
                        $history->activity_type = 'Date Due to Authority';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $correspondence_data->status;
                        $history->change_to = "Not Applicable";
                        if (is_null($correspondence_data->date_due_to_authority) || $correspondence_data->date_due_to_authority === '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                    if($correspondence_data->scheduled_start_date != $correspondence->scheduled_start_date){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = $correspondence_data->scheduled_start_date;
                        $history->current = $correspondence->scheduled_start_date;
                        $history->activity_type = 'Scheduled Start Date';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $correspondence_data->status;
                        $history->change_to = "Not Applicable";
                        if (is_null($correspondence_data->scheduled_start_date) || $correspondence_data->scheduled_start_date === '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                    if($correspondence_data->scheduled_end_date != $correspondence->scheduled_end_date){
                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $correspondence->id;
                        $history->previous = $correspondence_data->scheduled_end_date;
                        $history->current = $correspondence->scheduled_end_date;
                        $history->activity_type = 'Scheduled End Date';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $correspondence_data->status;
                        $history->change_to = "Not Applicable";
                        if (is_null($correspondence_data->scheduled_end_date) || $correspondence_data->scheduled_end_date === '') {
                            $history->action_name = 'New';
                        } else {
                            $history->action_name = 'Update';
                        }
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                    toastr()->success("Record is update Successfully");
                    return back();
            }

            public function Correspondence_send_stage(Request $request, $id){

                if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
                    $correspondence_data = Correspondence::find($id);
                    $lastDocument = Correspondence::find($id);

                    if ($correspondence_data->stage == 1) {
                        $correspondence_data->stage = "2";
                        $correspondence_data->status = "Response Preparation";
                        $correspondence_data->questions_recieved_by = Auth::user()->name;
                        $correspondence_data->questions_recieved_on = Carbon::now()->format('d-M-Y');
                        $correspondence_data->questions_recieved_comment = $request->comment;
                        $correspondence_data->save();

                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = "";
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from = "Opened";
                        $history->change_to = "Response Preparation";
                        $history->action_name = "Submit";
                        $history->stage = 'Plan Approved';
                        $history->save();

                        return back();

                    }

                elseif ($correspondence_data->stage == 2) {
                        $correspondence_data->stage = "3";
                        $correspondence_data->status = "Closed-Done";
                        $correspondence_data->finalize_response_by = Auth::user()->name;
                        $correspondence_data->finalize_response_on = Carbon::now()->format('d-M-Y');
                        $correspondence_data->finalize_response_comment = $request->comment;
                        $correspondence_data->save();

                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = "";
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from = "Response Preparation";
                        $history->change_to = "Closed-Done";
                        $history->action_name = "Submit";
                        $history->stage = 'Plan Approved';
                        $history->save();

                        return back();
                    }

                    }
                    else
                    {
                    toastr()->error('E-signature Not match');
                    return back();
                    }
            }

            public function Correspondence_cancel(Request $request, $id){

                    if ($request->username == Auth::user()->email && Hash::check($request->password,  Auth::user()->password)) {
                        $correspondence_data = Correspondence::find($id);
                        $lastDocument = Correspondence::find($id);

                    if ($correspondence_data->stage == 1) {
                        $correspondence_data->stage = "0";
                        $correspondence_data->status = "Closed-Cancelled";
                        $correspondence_data->open_cancel_by = Auth::user()->name;
                        $correspondence_data->open_cancel_on = Carbon::now()->format('d-M-Y');
                        $correspondence_data->open_cancel_comment = $request->comment;
                        $correspondence_data->save();

                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = "";
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from = "Opened";
                        $history->change_to = "Closed-Cancelled";
                        $history->action_name = "Submit";
                        $history->stage = 'Plan Approved';
                        $history->save();

                        return back();
                    }

                elseif ($correspondence_data->stage == 2) {
                        $correspondence_data->stage = "0";
                        $correspondence_data->status = "Closed-Cancelled";
                        $correspondence_data->cancel_by = Auth::user()->name;
                        $correspondence_data->cancel_on = Carbon::now()->format('d-M-Y');
                        $correspondence_data->cancel_comment = $request->comment;
                        $correspondence_data->save();

                        $history = new CorrespondenceAuditTrail();
                        $history->correspondence_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = "";
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from = "Response Preparation";
                        $history->change_to = "Closed-Cancelled";
                        $history->action_name = "Submit";
                        $history->stage = 'Plan Approved';
                        $history->save();

                        return back();
                        }
                    }
                    else
                    {
                    toastr()->error('E-signature Not match');
                    return back();
                    }
            }

            public function Correspondence_child(Request $request, $id){

                $correspondence_data = Correspondence::find($id);

                if($correspondence_data->stage == 2){

                        //return redirect(route('supplier_contract.index'));
                    }

                }

            //Single Report Start

            public function CorrespondenceSingleReport(Request $request, $id){

                    $correspondence_data = Correspondence::find($id);
                    //$users = User::all();
                    $grid_Data = CorrespondenceGrid::where(['correspondence_id' => $id, 'identifier' => 'action_plan'])->first();

                    if (!empty($correspondence_data)) {
                        $correspondence_data->data = CorrespondenceGrid::where('correspondence_id', $id)->where('identifier', "action_plan")->first();

                        $correspondence_data->originator = User::where('id', $correspondence_data->initiator_id)->value('name');
                        $correspondence_data->assign_to_gi = User::where('id', $correspondence_data->assigned_to)->value('name');
                        $pdf = App::make('dompdf.wrapper');
                        $time = Carbon::now();
                        $pdf = PDF::loadview('frontend.New_forms.correspondenceSingleReport', compact('correspondence_data','grid_Data'))
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
                        $canvas->page_text($width / 4, $height / 2, $correspondence_data->status, null, 25, [0, 0, 0], 2, 6, -20);
                        return $pdf->stream('Correspondence' . $id . '.pdf');
                    }
            }

                //Audit Trail Start

            public function CorrespondenceAuditTrial($id){

                    $audit = CorrespondenceAuditTrail::where('correspondence_id', $id)->orderByDESC('id')->paginate(5);
                    // dd($audit);
                    $today = Carbon::now()->format('d-m-y');
                    $document = Correspondence::where('id', $id)->first();
                    $document->originator = User::where('id', $document->initiator_id)->value('name');
                    // dd($document);

                    return view('frontend.New_forms.correspondenceAuditTrail',compact('document','audit','today'));
            }

            //Audit Trail Report Start

            public function CorrespondenceAuditTrailPdf($id)
            {
                $doc = Correspondence::find($id);
                $doc->originator = User::where('id', $doc->initiator_id)->value('name');
                $data = CorrespondenceAuditTrail::where('correspondence_id', $doc->id)->orderByDesc('id')->get();
                $pdf = App::make('dompdf.wrapper');
                $time = Carbon::now();
                $pdf = PDF::loadview('frontend.New_forms.correspondenceAuditTrailPdf', compact('data', 'doc'))
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
