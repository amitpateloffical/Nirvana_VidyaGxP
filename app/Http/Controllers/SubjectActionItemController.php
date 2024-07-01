<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\RecordNumber;
use App\Models\User;
use App\Models\QMSDivision;
use App\Models\RoleGroup;
use App\Models\SubjectActionItem;
use App\Models\SubjectActionItemGrid;
use App\Models\SubjectActionItemAuditTrail;
use PDF;

class SubjectActionItemController extends Controller
{
        public function index(){

            $old_record = SubjectActionItem::select('id', 'division_id', 'record')->get();
            $record_number = ((RecordNumber::first()->value('counter')) + 1);
            $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
            $users = User::all();
            $qmsDevisions = QMSDivision::all();

            $currentDate = Carbon::now();
            $formattedDate = $currentDate->addDays(30);
            $due_date = $formattedDate->format('Y-m-d');

            return view('frontend.ctms.subject_action_item',compact('old_record','record_number','users','qmsDevisions','due_date'));
        }

        public function store(Request $request){
                //dd($request->all());
                    $item = new SubjectActionItem();
                    $item->form_type = "Subject-Action-Item";
                    $item->record = ((RecordNumber::first()->value('counter')) + 1);
                    $item->initiator_id = Auth::user()->id;
                    $item->division_id = $request->division_id;
                    $item->division_code = $request->division_code;
                    $item->intiation_date = $request->intiation_date;
                    $item->parent_id = $request->parent_id;
                    $item->parent_type = $request->parent_type;
                    $item->assign_to_gi = $request->assign_to_gi;
                    $item->due_date = $request->due_date;

                    //Study Details
                    $item->trade_name_sd = $request->trade_name_sd;
                    $item->assign_to_sd = $request->assign_to_sd;

                    //Subject Details
                    $item->subject_name_sd = $request->subject_name_sd;
                    $item->gender_sd = $request->gender_sd;
                    $item->date_of_birth_sd = $request->date_of_birth_sd;
                    $item->race_sd = $request->race_sd;

                    //Treatment Information
                    $item->short_description_ti = $request->short_description_ti;
                    $item->clinical_efficacy_ti = $request->clinical_efficacy_ti;
                    $item->carry_over_effect_ti = $request->carry_over_effect_ti;
                    $item->last_monitered_ti = $request->last_monitered_ti;
                    $item->total_doses_recieved_ti = $request->total_doses_recieved_ti;
                    $item->treatment_effect_ti = $request->treatment_effect_ti;
                    $item->comments_ti = $request->comments_ti;
                    $item->summary_ti = $request->summary_ti;

                    $item->status = 'Opened';
                    $item->stage = '1';
                    $item->save();

                    //grid store
                    $g_id = $item->id;
                    $newDataGridItem = SubjectActionItemGrid::where(['subject_action_item_id' => $g_id, 'identifier' => 'dfc_grid'])->firstOrCreate();
                    $newDataGridItem->subject_action_item_id = $g_id;
                    $newDataGridItem->identifier = 'dfc_grid';
                    $newDataGridItem->data = $request->dfc_grid;
                    $newDataGridItem->save();

                    $g_id = $item->id;
                    $newDataGridItem = SubjectActionItemGrid::where(['subject_action_item_id' => $g_id, 'identifier' => 'minor_protocol_voilation'])->firstOrCreate();
                    $newDataGridItem->subject_action_item_id = $g_id;
                    $newDataGridItem->identifier = 'minor_protocol_voilation';
                    $newDataGridItem->data = $request->minor_protocol_voilation;
                    $newDataGridItem->save();


                //Audit Trail store start

                if(!empty($request->assign_to_gi)){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = "Null";
                    $history->current = $request->assign_to_gi;
                    $history->activity_type = 'Assigned To';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "CS/CTM";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->due_date)){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = "Null";
                    $history->current = $request->due_date;
                    $history->activity_type = 'Date Due';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "CS/CTM";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->trade_name_sd)){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = "Null";
                    $history->current = $request->trade_name_sd;
                    $history->activity_type = 'Trade Name';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "CS/CTM";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->assign_to_sd)){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = "Null";
                    $history->current = $request->assign_to_sd;
                    $history->activity_type = '(Root Parent)Assigned To';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "CS/CTM";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->subject_name_sd)){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = "Null";
                    $history->current = $request->subject_name_sd;
                    $history->activity_type = 'Subject Name';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "CS/CTM";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->gender_sd)){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = "Null";
                    $history->current = $request->gender_sd;
                    $history->activity_type = 'Gender';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "CS/CTM";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->date_of_birth_sd)){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = "Null";
                    $history->current = $request->date_of_birth_sd;
                    $history->activity_type = 'Date Of Birth';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "CS/CTM";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->race_sd)){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = "Null";
                    $history->current = $request->race_sd;
                    $history->activity_type = '(Parent)Race';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "CS/CTM";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->short_description_ti)){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = "Null";
                    $history->current = $request->short_description_ti;
                    $history->activity_type = 'Short Description';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "CS/CTM";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->clinical_efficacy_ti)){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = "Null";
                    $history->current = $request->clinical_efficacy_ti;
                    $history->activity_type = 'Clinical Efficacy';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "CS/CTM";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->carry_over_effect_ti)){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = "Null";
                    $history->current = $request->carry_over_effect_ti;
                    $history->activity_type = 'Carry Over Effect';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "CS/CTM";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->last_monitered_ti)){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = "Null";
                    $history->current = $request->last_monitered_ti;
                    $history->activity_type = 'Last Monitered';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "CS/CTM";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->total_doses_recieved_ti)){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = "Null";
                    $history->current = $request->total_doses_recieved_ti;
                    $history->activity_type = 'Total Doses Recieved';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "CS/CTM";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->treatment_effect_ti)){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = "Null";
                    $history->current = $request->treatment_effect_ti;
                    $history->activity_type = 'Treatment Effect';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "CS/CTM";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->comments_ti)){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = "Null";
                    $history->current = $request->comments_ti;
                    $history->activity_type = 'Comments';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "CS/CTM";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->summary_ti)){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = "Null";
                    $history->current = $request->summary_ti;
                    $history->activity_type = 'Summary';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "CS/CTM";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                    toastr()->success("Record is created Successfully");
                    return redirect(url('rcms/qms-dashboard'));
        }

        public function edit($id){

                    $item_data = SubjectActionItem::findOrFail($id);
                    //dd($item_data);
                    $old_record = SubjectActionItem::select('id', 'division_id', 'record')->get();
                    $record_number = ((RecordNumber::first()->value('counter')) + 1);
                    $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);

                    $users = User::all();
                    $qmsDevisions = QMSDivision::all();

                    //due date
                    $currentDate = Carbon::now();
                    $formattedDate = $currentDate->addDays(30);
                    $due_date = $formattedDate->format('Y-m-d');

                    $g_id = $item_data->id;
                    $grid_DataD = SubjectActionItemGrid::where(['subject_action_item_id' => $g_id, 'identifier' => 'dfc_grid'])->first();
                    $grid_DataM = SubjectActionItemGrid::where(['subject_action_item_id' => $g_id, 'identifier' => 'minor_protocol_voilation'])->first();
                    // dd($grid_DataM);

                 return view('frontend.ctms.subject_action_item_view',compact('item_data','record_number','users','qmsDevisions','due_date','grid_DataD','grid_DataM'));
        }

        public function update(Request $request, $id){
                //  dd($request->all());
                    $item_data = SubjectActionItem::findOrFail($id);

                    $item = SubjectActionItem::findOrFail($id);

                    $item->form_type = "Subject-Action-Item";
                    $item->record = ((RecordNumber::first()->value('counter')) + 1);
                    $item->initiator_id = Auth::user()->id;
                    $item->division_id = $request->division_id;
                    $item->division_code = $request->division_code;
                    $item->intiation_date = $request->intiation_date;
                    $item->parent_id = $request->parent_id;
                    $item->parent_type = $request->parent_type;
                    $item->assign_to_gi = $request->assign_to_gi;
                    $item->due_date = $request->due_date;

                    //Study Details
                    $item->trade_name_sd = $request->trade_name_sd;
                    $item->assign_to_sd = $request->assign_to_sd;

                    //Subject Details
                    $item->subject_name_sd = $request->subject_name_sd;
                    $item->gender_sd = $request->gender_sd;
                    $item->date_of_birth_sd = $request->date_of_birth_sd;
                    $item->race_sd = $request->race_sd;

                    //Treatment Information
                    $item->short_description_ti = $request->short_description_ti;
                    $item->clinical_efficacy_ti = $request->clinical_efficacy_ti;
                    $item->carry_over_effect_ti = $request->carry_over_effect_ti;
                    $item->last_monitered_ti = $request->last_monitered_ti;
                    $item->total_doses_recieved_ti = $request->total_doses_recieved_ti;
                    $item->treatment_effect_ti = $request->treatment_effect_ti;
                    $item->comments_ti = $request->comments_ti;
                    $item->summary_ti = $request->summary_ti;

                    $item->save();


                    //grid update

                    $g_id = $item->id;
                    $newDataGridItem = SubjectActionItemGrid::where(['subject_action_item_id' => $g_id, 'identifier' => 'dfc_grid'])->firstOrCreate();
                    $newDataGridItem->subject_action_item_id = $g_id;
                    $newDataGridItem->identifier = 'dfc_grid';
                    $newDataGridItem->data = $request->dfc_grid;
                    $newDataGridItem->save();

                    $g_id = $item->id;
                    $newDataGridItem = SubjectActionItemGrid::where(['subject_action_item_id' => $g_id, 'identifier' => 'minor_protocol_voilation'])->firstOrCreate();
                    $newDataGridItem->subject_action_item_id = $g_id;
                    $newDataGridItem->identifier = 'minor_protocol_voilation';
                    $newDataGridItem->data = $request->minor_protocol_voilation;
                    $newDataGridItem->save();

                if($item_data->assign_to_gi != $item->assign_to_gi){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = $item_data->assign_to_gi;
                    $history->current = $item->assign_to_gi;
                    $history->activity_type = 'Assigned To';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $item_data->status;
                    $history->change_to = "Not Applicable";
                    $history->action_name = 'Update';
                    $history->comment = "Not Applicable";
                    $history->save();

                    }

                if($item_data->due_date != $item->due_date){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = $item_data->due_date;
                    $history->current = $item->due_date;
                    $history->activity_type = 'Date Due';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $item_data->status;
                    $history->change_to = "Not Applicable";
                    $history->action_name = 'Update';
                    $history->comment = "Not Applicable";
                    $history->save();

                }
                if($item_data->trade_name_sd != $item->trade_name_sd){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = $item_data->trade_name_sd;
                    $history->current = $item->trade_name_sd;
                    $history->activity_type = 'Trade Name';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $item_data->status;
                    $history->change_to = "Not Applicable";
                    $history->action_name = 'Update';
                    $history->comment = "Not Applicable";
                    $history->save();

               }
                if($item_data->assign_to_sd != $item->assign_to_sd){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = $item_data->assign_to_sd;
                    $history->current = $item->assign_to_sd;
                    $history->activity_type = '(Root Parent)Assigned To';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $item_data->status;
                    $history->change_to = "Not Applicable";
                    $history->action_name = 'Update';
                    $history->comment = "Not Applicable";
                    $history->save();

                    }
                if($item_data->subject_name_sd != $item->subject_name_sd){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = $item_data->subject_name_sd;
                    $history->current = $item->subject_name_sd;
                    $history->activity_type = 'Subject Name';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $item_data->status;
                    $history->change_to = "Not Applicable";
                    $history->action_name = 'Update';
                    $history->comment = "Not Applicable";
                    $history->save();

                }
                if($item_data->gender_sd != $item->gender_sd){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = $item_data->gender_sd;
                    $history->current = $item->gender_sd;
                    $history->activity_type = 'Gender';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $item_data->status;
                    $history->change_to = "Not Applicable";
                    $history->action_name = 'Update';
                    $history->comment = "Not Applicable";
                    $history->save();

                }
                if($item_data->date_of_birth_sd != $item->date_of_birth_sd){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = $item_data->date_of_birth_sd;
                    $history->current = $item->date_of_birth_sd;
                    $history->activity_type = 'Date Of Birth';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $item_data->status;
                    $history->change_to = "Not Applicable";
                    $history->action_name = 'Update';
                    $history->comment = "Not Applicable";
                    $history->save();

                }
                if($item_data->race_sd != $item->race_sd){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = $item_data->race_sd;
                    $history->current = $item->race_sd;
                    $history->activity_type = 'Race';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $item_data->status;
                    $history->change_to = "Not Applicable";
                    $history->action_name = 'Update';
                    $history->comment = "Not Applicable";
                    $history->save();

                }
                if($item_data->short_description_ti != $item->short_description_ti){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = $item_data->short_description_ti;
                    $history->current = $item->short_description_ti;
                    $history->activity_type = 'Short Description';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $item_data->status;
                    $history->change_to = "Not Applicable";
                    $history->action_name = 'Update';
                    $history->comment = "Not Applicable";
                    $history->save();

                }
                if($item_data->clinical_efficacy_ti != $item->clinical_efficacy_ti){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = $item_data->clinical_efficacy_ti;
                    $history->current = $item->clinical_efficacy_ti;
                    $history->activity_type = 'Clinical Efficacy';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $item_data->status;
                    $history->change_to = "Not Applicable";
                    $history->action_name = 'Update';
                    $history->comment = "Not Applicable";
                    $history->save();

                }
                if($item_data->carry_over_effect_ti != $item->carry_over_effect_ti){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = $item_data->carry_over_effect_ti;
                    $history->current = $item->carry_over_effect_ti;
                    $history->activity_type = 'Carry Over Effect';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $item_data->status;
                    $history->change_to = "Not Applicable";
                    $history->action_name = 'Update';
                    $history->comment = "Not Applicable";
                    $history->save();

                }
                if($item_data->last_monitered_ti != $item->last_monitered_ti){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = $item_data->last_monitered_ti;
                    $history->current = $item->last_monitered_ti;
                    $history->activity_type = 'Last Monitered';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $item_data->status;
                    $history->change_to = "Not Applicable";
                    $history->action_name = 'Update';
                    $history->comment = "Not Applicable";
                    $history->save();

                }
                if($item_data->total_doses_recieved_ti != $item->total_doses_recieved_ti){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = $item_data->total_doses_recieved_ti;
                    $history->current = $item->total_doses_recieved_ti;
                    $history->activity_type = 'Total Doses Recieved';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $item_data->status;
                    $history->change_to = "Not Applicable";
                    $history->action_name = 'Update';
                    $history->comment = "Not Applicable";
                    $history->save();

                }
                if($item_data->treatment_effect_ti != $item->treatment_effect_ti){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = $item_data->treatment_effect_ti;
                    $history->current = $item->treatment_effect_ti;
                    $history->activity_type = 'Treatment Effect';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $item_data->status;
                    $history->change_to = "Not Applicable";
                    $history->action_name = 'Update';
                    $history->comment = "Not Applicable";
                    $history->save();

                }
                if($item_data->comments_ti != $item->comments_ti){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = $item_data->comments_ti;
                    $history->current = $item->comments_ti;
                    $history->activity_type = 'Comments';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $item_data->status;
                    $history->change_to = "Not Applicable";
                    $history->action_name = 'Update';
                    $history->comment = "Not Applicable";
                    $history->save();

                }
                if($item_data->summary_ti != $item->summary_ti){
                    $history = new SubjectActionItemAuditTrail();
                    $history->subject_action_item_id = $item->id;
                    $history->previous = $item_data->summary_ti;
                    $history->current = $item->summary_ti;
                    $history->activity_type = 'Summary';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $item_data->status;
                    $history->change_to = "Not Applicable";
                    $history->action_name = 'Update';
                    $history->comment = "Not Applicable";
                    $history->save();

                }
                 toastr()->success("Record is Updated Successfully");
                 return back();


        }

        public function Subject_action_item_send_stage(Request $request, $id){

            if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
                   $item_data = SubjectActionItem::find($id);
                   $lastDocument = SubjectActionItem::find($id);

                if ($item_data->stage == 1) {
                            $item_data->stage = "2";
                            $item_data->status = "Pending Action Item Review";
                            $item_data->submit_by = Auth::user()->name;
                            $item_data->submit_on = Carbon::now()->format('d-M-Y');
                            $item_data->submit_comment = $request->comment;
                            $item_data->save();

                            $history = new SubjectActionItemAuditTrail();
                            $history->subject_action_item_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->previous = "";
                            $history->current = "";
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->change_from = "Opened";
                            $history->change_to = "Pending Action Item Review";
                            $history->action_name = "Submit";
                            $history->stage = 'Plan Approved';
                            $history->save();

                        return back();

               }

               elseif ($item_data->stage == 2) {
                            $item_data->stage = "3";
                            $item_data->status = "Closed-Done";
                            $item_data->close_by = Auth::user()->name;
                            $item_data->close_on = Carbon::now()->format('d-M-Y');
                            $item_data->close_comment = $request->comment;
                            $item_data->save();

                            $history = new SubjectActionItemAuditTrail();
                            $history->subject_action_item_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->previous = "";
                            $history->current = "";
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->change_from = "Pending Action Item Review";
                            $history->change_to = "Closed-Done";
                            $history->action_name = "Submit";
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

        public function Subject_action_item_cancel(Request $request, $id){

            if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
                    $item_data = SubjectActionItem::find($id);
                    $lastDocument = SubjectActionItem::find($id);

                    if ($item_data->stage == 1) {
                        $item_data->stage = "0";
                        $item_data->status = "Closed-Cancelled";
                        $item_data->cancel_by = Auth::user()->name;
                        $item_data->cancel_on = Carbon::now()->format('d-M-Y');
                        $item_data->cancel_comment = $request->comment;
                        $item_data->save();

                        $history = new SubjectActionItemAuditTrail();
                        $history->subject_action_item_id = $id;
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
            }
                else {
                    toastr()->error('E-signature Not match');
                    return back();
            }
        }

        public function Subject_action_item_child(Request $request, $id){

            $item_data = SubjectActionItem::find($id);

            if ($request->child_type == 'violation'){

                return redirect(route('violation.index'));
            }else{

                return view('frontend.ctms.serious_adverse_event');
            }

        }


            //single Report start

            public function Suject_Action_ItemSingleReport(Request $request, $id){

                        $item_data = SubjectActionItem::find($id);
                        //$users = User::all();
                        $grid_DataD = SubjectActionItemGrid::where(['subject_action_item_id' => $id, 'identifier' => 'dfc_grid'])->first();
                        $grid_DataM = SubjectActionItemGrid::where(['subject_action_item_id' => $id, 'identifier' => 'minor_protocol_voilation'])->first();
                        if (!empty($item_data)) {
                            $item_data->data = SubjectActionItemGrid::where('subject_action_item_id', $id)->where('identifier', "dfc_grid")->first();
                            $item_data->data = SubjectActionItemGrid::where('subject_action_item_id', $id)->where('identifier', "minor_protocol_voilation")->first();

                            $item_data->originator = User::where('id', $item_data->initiator_id)->value('name');
                            $item_data->a_originator = User::where('id', $item_data->assign_to_gi)->value('name');
                            $pdf = App::make('dompdf.wrapper');
                            $time = Carbon::now();
                            $pdf = PDF::loadview('frontend.ctms.subject_action_itemSingleReport', compact('item_data','grid_DataD','grid_DataM'))
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
                            $canvas->page_text($width / 4, $height / 2, $item_data->status, null, 25, [0, 0, 0], 2, 6, -20);
                            return $pdf->stream('Subject_Action_Item' . $id . '.pdf');
                        }
            }

            public function Subject_Action_ItemAuditTrial($id){

                $audit = SubjectActionItemAuditTrail::where('subject_action_item_id', $id)->orderByDESC('id')->paginate(5);
                // dd($audit);
                $today = Carbon::now()->format('d-m-y');
                $document = SubjectActionItem::where('id', $id)->first();
                $document->originator = User::where('id', $document->initiator_id)->value('name');
                // dd($document);

                return view('frontend.ctms.subject_action_itemAuditTrail',compact('document','audit','today'));
            }

            //Audit Trail Report Start

            public function Subject_Action_ItemAuditTrailPdf($id)
            {
                $doc = SubjectActionItem::find($id);
                $doc->originator = User::where('id', $doc->initiator_id)->value('name');
                $data = SubjectActionItemAuditTrail::where('subject_action_item_id', $doc->id)->orderByDesc('id')->get();
                $pdf = App::make('dompdf.wrapper');
                $time = Carbon::now();
                $pdf = PDF::loadview('frontend.ctms.subject_action_itemAuditTrailPdf', compact('data', 'doc'))
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
