<?php

namespace App\Http\Controllers\rcms;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecordNumber;
use App\Models\QMSDivision;
use App\Models\RoleGroup;
use App\Models\User;
use App\Models\Violation;
use App\Models\ViolationGrid;
use App\Models\ViolationAuditTrail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use PDF;

class ViolationController extends Controller
{
        public function index(){

            $old_record = Violation::select('id', 'division_id', 'record')->get();
            $record_number = ((RecordNumber::first()->value('counter')) + 1);
            $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
            $users = User::all();
            $qmsDevisions = QMSDivision::all();
            //dd($qmsDevisions);

            //due date
            $currentDate = Carbon::now();
            $formattedDate = $currentDate->addDays(30);
            $due_date = $formattedDate->format('Y-m-d');

           return view('frontend.ctms.violation', compact('old_record','record_number','users','qmsDevisions','due_date'));
        }

            public function store(Request $request){
                    //dd($request->all());

                    $recordCounter = RecordNumber::first();
                    $newRecordNumber = $recordCounter->counter + 1;

                    $recordCounter->counter = $newRecordNumber;
                    $recordCounter->save();

                    $violation = new Violation();
                    $violation->form_type = "Violation";
                    $violation->record = $newRecordNumber;
                    $violation->initiator_id = Auth::user()->id;
                    $violation->division_id = $request->division_id;
                    $violation->division_code = $request->division_code;
                    $violation->intiation_date = $request->intiation_date;
                    $violation->parent_id = $request->parent_id;
                    $violation->parent_type = $request->parent_type;
                    $violation->short_description = $request->short_description;
                    $violation->assign_to = $request->assign_to;
                    $violation->due_date = $request->due_date;
                    $violation->type = $request->type;
                    $violation->other_type = $request->other_type;
                    $violation->related_url = $request->related_url;

                    if (!empty ($request->file_attachments)) {
                        $files = [];
                        if ($request->hasfile('file_attachments')) {
                            foreach ($request->file('file_attachments') as $file) {
                                $name = $request->name . 'file_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                                $file->move('upload/', $name);
                                $files[] = $name;
                            }
                        }

                      $violation->file_attachments = $files;
                    }

                    $violation->description = $request->description;
                    $violation->zone = $request->zone;
                    $violation->country_id = $request->country_id;
                    $violation->state_id = $request->state_id;
                    $violation->city_id = $request->city_id;
                    $violation->site_name_id = $request->site_name_id;
                    $violation->building_id = $request->building_id;
                    $violation->flore_id = $request->flore_id;
                    $violation->room_id = $request->room_id;

                    //Violation Information
                    $violation->date_occured = $request->date_occured;
                    $violation->notification_date = $request->notification_date;
                    $violation->severity_rate = $request->severity_rate;
                    $violation->occurance = $request->occurance;
                    $violation->detection = $request->detection;
                    $violation->rpn = $request->rpn;
                    $violation->manufacturer = $request->manufacturer;
                    $violation->date_sent = $request->date_sent;
                    $violation->date_returned = $request->date_returned;
                    $violation->follow_up = $request->follow_up;
                    $violation->summary = $request->summary;
                    $violation->Comments = $request->Comments;

                    $violation->status = 'Opened';
                    $violation->stage = '1';

                    $violation->save();

                    //Grid Store

                    $g_id = $violation->id;
                    $newDataGridViolation = ViolationGrid::where(['violation_id' => $g_id, 'identifier' => 'product_material'])->firstOrCreate();
                    $newDataGridViolation->violation_id = $g_id;
                    $newDataGridViolation->identifier = 'product_material';
                    $newDataGridViolation->data = $request->product_material;
                    $newDataGridViolation->save();


                  //Audit Trail store start

                if(!empty($request->short_description)){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
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

                if(!empty($request->assign_to)){

                    $assigned_to_name = User::where('id', $request->assign_to)->value('name');

                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
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
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = "Null";
                    $history->current = date('d-M-Y', strtotime($request->due_date));
                    $history->activity_type = 'Due Date';
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
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
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

                if(!empty($request->other_type)){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = "Null";
                    $history->current = $request->other_type;
                    $history->activity_type = 'Other Type';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->related_url)){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = "Null";
                    $history->current = $request->related_url;
                    $history->activity_type = 'Related URL';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }


                if (!empty($violation->file_attachments)) {

                    //$fileNames = array_map(function($file) {
                    //    return $file->getClientOriginalName();
                    //}, $request->file_attachments);

                    //$fileNamesString = json_encode($fileNames);

                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = "Null";
                    $history->current = json_encode($violation->file_attachments);
                    $history->activity_type = 'File Attachments';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }



                if(!empty($request->description)){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
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

                if(!empty($request->zone)){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = "Null";
                    $history->current = $request->zone;
                    $history->activity_type = 'Zone';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->country_id)){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = "Null";
                    $history->current = $request->country_id;
                    $history->activity_type = 'Country';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }



                if(!empty($request->state_id)){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = "Null";
                    $history->current = $request->state_id;
                    $history->activity_type = 'State/District';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->city_id)){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = "Null";
                    $history->current = $request->city_id;
                    $history->activity_type = 'City';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->site_name_id)){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = "Null";
                    $history->current = $request->site_name_id;
                    $history->activity_type = 'Site Name';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->building_id)){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = "Null";
                    $history->current = $request->building_id;
                    $history->activity_type = 'Building';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->flore_id)){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = "Null";
                    $history->current = $request->flore_id;
                    $history->activity_type = 'Floor';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->room_id)){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = "Null";
                    $history->current = $request->room_id;
                    $history->activity_type = 'Room';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->date_occured)){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = "Null";
                    $history->current = $request->date_occured;
                    $history->activity_type = 'Date Occured';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->notification_date)){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = "Null";
                    $history->current = $request->notification_date;
                    $history->activity_type = 'Notification Date';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->severity_rate)){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = "Null";
                    $history->current = $request->severity_rate;
                    $history->activity_type = 'Severity Rate';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->occurance)){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = "Null";
                    $history->current = $request->occurance;
                    $history->activity_type = 'Occurance';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->detection)){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = "Null";
                    $history->current = $request->detection;
                    $history->activity_type = 'Detection';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->rpn)){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = "Null";
                    $history->current = $request->rpn;
                    $history->activity_type = 'RPN';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->manufacturer)){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = "Null";
                    $history->current = $request->manufacturer;
                    $history->activity_type = 'Manufacturer';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->date_sent)){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = "Null";
                    $history->current = $request->date_sent;
                    $history->activity_type = 'Date Sent';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->date_returned)){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = "Null";
                    $history->current = $request->date_returned;
                    $history->activity_type = 'Date Returned';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->follow_up)){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = "Null";
                    $history->current = $request->follow_up;
                    $history->activity_type = 'Follow Up';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->summary)){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = "Null";
                    $history->current = $request->summary;
                    $history->activity_type = 'Summary';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->Comments)){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = "Null";
                    $history->current = $request->Comments;
                    $history->activity_type = 'Comments';
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

                    $violation_data = Violation::findOrFail($id);

                    $old_record = Violation::select('id', 'division_id', 'record')->get();
                    $record_number = ((RecordNumber::first()->value('counter')) + 1);
                    $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
                    $users = User::all();
                    $qmsDevisions = QMSDivision::all();

                    //Due date
                    $currentDate = Carbon::now();
                    $formattedDate = $currentDate->addDays(30);
                    $due_date = $formattedDate->format('Y-m-d');

                    //Grid fetch
                    $g_id = $violation_data->id;
                    $grid_Data = ViolationGrid::where(['violation_id' => $g_id, 'identifier' => 'product_material'])->first();


                    return view('frontend.ctms.violation_view',compact('violation_data','record_number','users','qmsDevisions','due_date','grid_Data'));
            }

            public function update(Request $request, $id){
                //dd($request->all());

                    $violation_data = Violation::findOrFail($id);

                    $violation = Violation::findOrFail($id);

                    $violation->form_type = "Violation";
                    //$violation->record = ((RecordNumber::first()->value('counter')) + 1);
                    $violation->initiator_id = Auth::user()->id;
                    $violation->division_id = $request->division_id;
                    $violation->division_code = $request->division_code;
                    $violation->intiation_date = $request->intiation_date;
                    $violation->parent_id = $request->parent_id;
                    $violation->parent_type = $request->parent_type;
                    $violation->short_description = $request->short_description;
                    $violation->assign_to = $request->assign_to;
                    $violation->due_date = $request->due_date;
                    $violation->type = $request->type;
                    $violation->other_type = $request->other_type;
                    $violation->related_url = $request->related_url;

                    if (!empty ($request->file_attachments)) {
                        $files = [];
                        if ($request->hasfile('file_attachments')) {
                            foreach ($request->file('file_attachments') as $file) {
                                $name = $request->name . 'file_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                                $file->move('upload/', $name);
                                $files[] = $name;
                            }
                        }


                        $violation->file_attachments = $files;
                    }

                    $violation->description = $request->description;
                    $violation->zone = $request->zone;
                    $violation->country_id = $request->country_id;
                    $violation->state_id = $request->state_id;
                    $violation->city_id = $request->city_id;
                    $violation->site_name_id = $request->site_name_id;
                    $violation->building_id = $request->building_id;
                    $violation->flore_id = $request->flore_id;
                    $violation->room_id = $request->room_id;

                    //Violation Information
                    $violation->date_occured = $request->date_occured;
                    $violation->notification_date = $request->notification_date;
                    $violation->severity_rate = $request->severity_rate;
                    $violation->occurance = $request->occurance;
                    $violation->detection = $request->detection;
                    $violation->rpn = $request->rpn;
                    $violation->manufacturer = $request->manufacturer;
                    $violation->date_sent = $request->date_sent;
                    $violation->date_returned = $request->date_returned;
                    $violation->follow_up = $request->follow_up;
                    $violation->summary = $request->summary;
                    $violation->Comments = $request->Comments;

                    $violation->save();

                    //Grid Store

                    $g_id = $violation->id;
                    $newDataGridViolation = ViolationGrid::where(['violation_id' => $g_id, 'identifier' => 'product_material'])->firstOrCreate();
                    $newDataGridViolation->violation_id = $g_id;
                    $newDataGridViolation->identifier = 'product_material';
                    $newDataGridViolation->data = $request->product_material;
                    $newDataGridViolation->save();


                //audit trail update

                if($violation_data->short_description != $violation->short_description){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->short_description;
                    $history->current = $violation->short_description;
                    $history->activity_type = 'Short Description';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->short_description) || $violation_data->short_description === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($violation_data->assign_to != $violation->assign_to){

                    $previous_assigned_to_name = User::where('id', $violation_data->assign_to)->value('name');
                    $current_assigned_to_name = User::where('id', $violation->assign_to)->value('name');

                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $previous_assigned_to_name;
                    $history->current = $current_assigned_to_name;
                    $history->activity_type = 'Assigned To';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->assign_to) || $violation_data->assign_to === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($violation_data->due_date != $violation->due_date){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->due_date;
                    $history->current = $violation->due_date;
                    $history->activity_type = 'Due Date';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->due_date) || $violation_data->due_date === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($violation_data->type != $violation->type){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->type;
                    $history->current = $violation->type;
                    $history->activity_type = 'Type';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->type) || $violation_data->type === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($violation_data->other_type != $violation->other_type){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->other_type;
                    $history->current = $violation->other_type;
                    $history->activity_type = 'Other Type';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->other_type) || $violation_data->other_type === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($violation_data->related_url != $violation->related_url){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->related_url;
                    $history->current = $violation->related_url;
                    $history->activity_type = 'Related URL';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->related_url) || $violation_data->related_url === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($violation_data->file_attachments != $violation->file_attachments){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = json_encode($violation_data->file_attachments);
                    $history->current = json_encode($violation->file_attachments);
                    $history->activity_type = 'File Attachments';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->file_attachments) || $violation_data->file_attachments === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($violation_data->description != $violation->description){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->description;
                    $history->current = $violation->description;
                    $history->activity_type = 'Description';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->description) || $violation_data->description === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }


                if($violation_data->zone != $violation->zone){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->zone;
                    $history->current = $violation->zone;
                    $history->activity_type = 'Zone';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->zone) || $violation_data->zone === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }


                if($violation_data->country_id != $violation->country_id){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->country_id;
                    $history->current = $violation->country_id;
                    $history->activity_type = 'Country';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->country_id) || $violation_data->country_id === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($violation_data->state_id != $violation->state_id){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->state_id;
                    $history->current = $violation->state_id;
                    $history->activity_type = 'State/District';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->state_id) || $violation_data->state_id === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($violation_data->city_id != $violation->city_id){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->city_id;
                    $history->current = $violation->city_id;
                    $history->activity_type = 'City';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->city_id) || $violation_data->city_id === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($violation_data->site_name_id != $violation->site_name_id){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->site_name_id;
                    $history->current = $violation->site_name_id;
                    $history->activity_type = 'Site Name';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->site_name_id) || $violation_data->site_name_id === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($violation_data->building_id != $violation->building_id){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->building_id;
                    $history->current = $violation->building_id;
                    $history->activity_type = 'Building';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->building_id) || $violation_data->building_id === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($violation_data->flore_id != $violation->flore_id){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->flore_id;
                    $history->current = $violation->flore_id;
                    $history->activity_type = 'Floor';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->flore_id) || $violation_data->flore_id === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($violation_data->room_id != $violation->room_id){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->room_id;
                    $history->current = $violation->room_id;
                    $history->activity_type = 'Room';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->room_id) || $violation_data->room_id === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($violation_data->date_occured != $violation->date_occured){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->date_occured;
                    $history->current = $violation->date_occured;
                    $history->activity_type = 'Date Occured';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->date_occured) || $violation_data->date_occured === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($violation_data->notification_date != $violation->notification_date){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->notification_date;
                    $history->current = $violation->notification_date;
                    $history->activity_type = 'Notification Date';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->notification_date) || $violation_data->notification_date === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($violation_data->severity_rate != $violation->severity_rate){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->severity_rate;
                    $history->current = $violation->severity_rate;
                    $history->activity_type = 'Severity Rate';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->severity_rate) || $violation_data->severity_rate === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($violation_data->occurance != $violation->occurance){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->occurance;
                    $history->current = $violation->occurance;
                    $history->activity_type = 'Occurance';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->occurance) || $violation_data->occurance === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($violation_data->detection != $violation->detection){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->detection;
                    $history->current = $violation->detection;
                    $history->activity_type = 'Detection';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->detection) || $violation_data->detection === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($violation_data->rpn != $violation->rpn){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->rpn;
                    $history->current = $violation->rpn;
                    $history->activity_type = 'RPN';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->rpn) || $violation_data->rpn === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($violation_data->manufacturer != $violation->manufacturer){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->manufacturer;
                    $history->current = $violation->manufacturer;
                    $history->activity_type = 'Manufacturer';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->manufacturer) || $violation_data->manufacturer === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($violation_data->date_sent != $violation->date_sent){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->date_sent;
                    $history->current = $violation->date_sent;
                    $history->activity_type = 'Date Sent';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->date_sent) || $violation_data->date_sent === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($violation_data->date_returned != $violation->date_returned){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->date_returned;
                    $history->current = $violation->date_returned;
                    $history->activity_type = 'Date Returned';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->date_returned) || $violation_data->date_returned === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($violation_data->follow_up != $violation->follow_up){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->follow_up;
                    $history->current = $violation->follow_up;
                    $history->activity_type = 'Follow Up';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->follow_up) || $violation_data->follow_up === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($violation_data->summary != $violation->summary){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->summary;
                    $history->current = $violation->summary;
                    $history->activity_type = 'Summary';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->summary) || $violation_data->summary === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($violation_data->Comments != $violation->Comments){
                    $history = new ViolationAuditTrail();
                    $history->violation_id = $violation->id;
                    $history->previous = $violation_data->Comments;
                    $history->current = $violation->Comments;
                    $history->activity_type = 'Comments';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $violation_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($violation_data->Comments) || $violation_data->Comments === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                    toastr()->success("Record is Updated Successfully");
                    return back();
                }


            public function Violation_send_stage(Request $request, $id){

                if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
                    $violation_data = Violation::find($id);
                    $lastDocument = Violation::find($id);

                    if ($violation_data->stage == 1) {
                        $violation_data->stage = "2";
                        $violation_data->status = "Pending Completion Activities";
                        $violation_data->pending_completion_by = Auth::user()->name;
                        $violation_data->pending_completion_on = Carbon::now()->format('d-M-Y');
                        $violation_data->pending_completion_comment = $request->comment;
                        $violation_data->save();

                        $history = new ViolationAuditTrail();
                        $history->violation_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = "";
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from = "Opened";
                        $history->change_to = "Pending Completion Activities";
                        $history->action = "Pending Completion";
                        $history->stage = 'Plan Approved';
                        $history->save();

                        return back();

                    }

                elseif ($violation_data->stage == 2) {
                        $violation_data->stage = "3";
                        $violation_data->status = "Closed-Done";
                        $violation_data->close_by = Auth::user()->name;
                        $violation_data->close_on = Carbon::now()->format('d-M-Y');
                        $violation_data->close_comment = $request->comment;
                        $violation_data->save();

                        $history = new ViolationAuditTrail();
                        $history->violation_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = "";
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from = "Pending Completion Activities";
                        $history->change_to = "Closed-Done";
                        $history->action = "Close";
                        $history->stage = 'Plan Approved';
                        $history->save();

                        return back();
                       }
                    }
                        else {
                            toastr()->error('E-signature Not match');
                            return back();
                    }
                }

                public function Violation_cancel(Request $request, $id){

                    if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
                        $violation_data = Violation::find($id);
                        $lastDocument = Violation::find($id);

                        if ($violation_data->stage == 1) {
                            $violation_data->stage = "0";
                            $violation_data->status = "Closed-Cancelled";
                            $violation_data->initiate_cancel_by = Auth::user()->name;
                            $violation_data->initiate_cancel_on = Carbon::now()->format('d-M-Y');
                            $violation_data->initiate_cancel_comment = $request->comment;
                            $violation_data->save();

                            $history = new ViolationAuditTrail();
                            $history->violation_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->previous = "";
                            $history->current = "";
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->change_from = "Opened";
                            $history->change_to = "Closed-Cancelled";
                            $history->action = "Cancel";
                            $history->stage = 'Plan Approved';
                            $history->save();

                            return back();
                        }
                    elseif ($violation_data->stage == 2) {
                            $violation_data->stage = "0";
                            $violation_data->status = "Closed-Cancelled";
                            $violation_data->cs_ctm_cancel_by = Auth::user()->name;
                            $violation_data->cs_ctm_cancel_on = Carbon::now()->format('d-M-Y');
                            $violation_data->cs_ctm_cancel_comment = $request->comment;
                            $violation_data->save();

                            $history = new ViolationAuditTrail();
                            $history->violation_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->previous = "";
                            $history->current = "";
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->change_from = "Pending Completion Activities";
                            $history->change_to = "Closed-Cancelled";
                            $history->action = "Cancel";
                            $history->stage = 'Plan Approved';
                            $history->save();

                            return back();
                        }
                      }
                        else {
                            toastr()->error('E-signature Not match');
                            return back();
                        }
            }


            //single Report start

            public function ViolationSingleReport(Request $request, $id){

                $violation_data = Violation::find($id);
                //$users = User::all();
                $grid_Data = ViolationGrid::where(['violation_id' => $id, 'identifier' => 'product_material'])->first();
                if (!empty($violation_data)) {
                    $violation_data->data = ViolationGrid::where('violation_id', $id)->where('identifier', "product_material")->first();

                    $violation_data->originator = User::where('id', $violation_data->initiator_id)->value('name');
                    $violation_data->a_originator = User::where('id', $violation_data->assign_to)->value('name');
                    $pdf = App::make('dompdf.wrapper');
                    $time = Carbon::now();
                    $pdf = PDF::loadview('frontend.ctms.violationSingleReport', compact('violation_data','grid_Data'))
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
                    $canvas->page_text($width / 4, $height / 2, $violation_data->status, null, 25, [0, 0, 0], 2, 6, -20);
                    return $pdf->stream('GCP_study' . $id . '.pdf');
                }
            }


            //Audit Trail Start

            public function ViolationAuditTrial($id){

                $audit = ViolationAuditTrail::where('violation_id', $id)->orderByDESC('id')->paginate(5);
                // dd($audit);
                $today = Carbon::now()->format('d-m-y');
                $document = Violation::where('id', $id)->first();
                $document->originator = User::where('id', $document->initiator_id)->value('name');
                // dd($document);

                return view('frontend.ctms.violationAuditTrail',compact('document','audit','today'));
            }

            //Audit Trail Report Start
            public function ViolationAuditTrailPdf($id)
            {
                $doc = Violation::find($id);
                $doc->originator = User::where('id', $doc->initiator_id)->value('name');
                $data = ViolationAuditTrail::where('violation_id', $doc->id)->orderByDesc('id')->get();
                $pdf = App::make('dompdf.wrapper');
                $time = Carbon::now();
                $pdf = PDF::loadview('frontend.ctms.violationAuditTrailPdf', compact('data', 'doc'))
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
