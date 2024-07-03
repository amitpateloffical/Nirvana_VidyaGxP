<?php

namespace App\Http\Controllers\newForm;

use App\Http\Controllers\Controller;
use App\Models\ActionItem;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Deviation;
use App\Models\User;
use App\Models\RoleGroup;
use App\Models\Equipment;
use App\Models\EquipmentAudit;
use App\Models\Extension;
use App\Models\RecordNumber;

class EquipmentController extends Controller
{
    public function equipmentIndex()
    {

        $old_record = Equipment::select('id', 'division_id', 'record')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view('frontend.New_forms.equipment.equipment', compact('old_record', 'record_number', 'currentDate', 'formattedDate', 'due_date'));
    }


    public function equipmentStore(Request $request)
    {

        try {
            $recordCounter = RecordNumber::first();
            $newRecordNumber = $recordCounter->counter + 1;

            $recordCounter->counter = $newRecordNumber;
            $recordCounter->save();


            $equipment = new Equipment();

            // General Information
            $equipment->stage = '1';
            $equipment->status = 'Opened';
            $equipment->parent_id = $request->parent_id;
            $equipment->parent_type = $request->parent_type;
            $equipment->record = $newRecordNumber;

            $equipment->initiator_id = Auth::user()->id;
            $equipment->user_name = Auth::user()->name;
            $equipment->initiation_date = $request->initiation_date;
            $equipment->short_description = $request->short_description;
            $equipment->type = $request->type;
            $equipment->number_id = $request->number_id;
            $equipment->assign_to = $request->assign_to;
            $equipment->assign_due_date = $request->assign_due_date;
            $equipment->site_name = $request->site_name;
            $equipment->building = $request->building;
            $equipment->floor = $request->floor;
            $equipment->rooms = $request->rooms;
            $equipment->description = $request->description;
            $equipment->comments = $request->comments;
            $equipment->pm_frequency = $request->pm_frequency;
            $equipment->calibration_frequency = $request->calibration_frequency;
            $equipment->preventive_maintenance_plan = $request->preventive_maintenance_plan;
            $equipment->calibration_information = $request->calibration_information;
            $equipment->next_pm_date = $request->next_pm_date;
            $equipment->next_calibration_date = $request->next_calibration_date;
            $equipment->maintenance_history = $request->maintenance_history;


            if (!empty($request->file_attachment)) {
                $files = [];
                if ($request->hasfile('file_attachment')) {
                    foreach ($request->file('file_attachment') as $file) {
                        $name = $request->name . 'file_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $equipment->file_attachment = json_encode($files);
            }

            $equipment->save();

            if (!empty($request->short_description)) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->previous = "Null";
                $validation2->current = $request->short_description;
                $validation2->activity_type = 'Short Description';
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                // dd($validation2->validation_id);
                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->comment = "Not Applicable";
                $validation2->save();
            }

            if (!empty($request->initiation_date)) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Initiation Date';
                $validation2->previous = "Null";
                $validation2->current = $request->initiation_date;
                $validation2->comment = "Not Applicable";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->assign_to)) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Assign To';
                $validation2->previous = "Null";
                $validation2->current = $request->assign_to;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->assign_due_date)) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = ' Assign Due Date';
                $validation2->previous = "Null";
                $validation2->current = $request->assign_due_date;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';

                $validation2->save();
            }

            if (!empty($request->type)) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Type';
                $validation2->previous = "Null";
                $validation2->current = $request->type;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';

                $validation2->save();
            }

            if (!empty($request->number_id)) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Number IDs';
                $validation2->previous = "Null";
                $validation2->current = $request->number_id;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';

                $validation2->save();
            }

            if (!empty($request->site_name)) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Site Name';
                $validation2->previous = "Null";
                $validation2->current = $request->site_name;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->building)) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Building';
                $validation2->previous = "Null";
                $validation2->current = $request->building;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->floor)) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Floor';
                $validation2->previous = "Null";
                $validation2->current = $request->floor;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }


            if (!empty($request->rooms)) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Room';
                $validation2->previous = "Null";
                $validation2->current = $request->rooms;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->description)) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Description';
                $validation2->previous = "Null";
                $validation2->current = $request->description;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->comments)) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Comments';
                $validation2->previous = "Null";
                $validation2->current = $request->comments;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->file_attechment)) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'File Attachment';
                $validation2->previous = "Null";
                $validation2->current = $request->file_attechment;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->pm_frequency)) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'PM Frequency';
                $validation2->previous = "Null";
                $validation2->current = $request->pm_frequency;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->calibration_frequency)) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Calibration Frequency';
                $validation2->previous = "Null";
                $validation2->current = $request->calibration_frequency;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->preventive_maintenance_plan)) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Preventive Maintenance Plan';
                $validation2->previous = "Null";
                $validation2->current = $request->preventive_maintenance_plan;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->calibration_information)) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Calibration Information';
                $validation2->previous = "Null";
                $validation2->current = $request->calibration_information;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }


            if (!empty($request->next_pm_date)) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Next PM Date';
                $validation2->previous = "Null";
                $validation2->current = $request->next_pm_date;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->next_calibration_date)) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Next Calibration Date';
                $validation2->previous = "Null";
                $validation2->current = $request->next_calibration_date;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }


            if (!empty($request->maintenance_history)) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Maintenance History';
                $validation2->previous = "Null";
                $validation2->current = $request->maintenance_history;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }


            toastr()->success("Equipment is created Successfully");
            return redirect(url('rcms/qms-dashboard'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Failed to save equipment: ' . $e->getMessage());
        }
    }


    public function equipmentEdit($id)
    {
        $equipment = Equipment::findOrFail($id);
        return view('frontend.New_forms.equipment.equipment_view', compact('equipment'));
    }

    public function equipmentUpdate(Request $request, $id)
    {

        if (!$request->short_description) {
            toastr()->info("Short Description is required");
            return redirect()->back()->withInput();
        }
        try {

            $equipment =  Equipment::findOrFail($id);
            $lastDocument =  Equipment::findOrFail($id);
            // $equipment = new Equipment();

            // General Information
            // $equipment->stage = '1';
            // $equipment->status = 'Opened';
            $equipment->parent_id = $request->parent_id;
            $equipment->parent_type = $request->parent_type;

            $equipment->initiator_id = Auth::user()->id;
            $equipment->user_name = Auth::user()->name;
            $equipment->initiation_date = $request->initiation_date;
            $equipment->short_description = $request->short_description;
            $equipment->type = $request->type;
            $equipment->assign_to = $request->assign_to;
            $equipment->assign_due_date = $request->assign_due_date;
            $equipment->site_name = $request->site_name;
            $equipment->building = $request->building;
            $equipment->floor = $request->floor;
            $equipment->rooms = $request->rooms;
            $equipment->description = $request->description;
            $equipment->comments = $request->comments;
            $equipment->pm_frequency = $request->pm_frequency;
            $equipment->calibration_frequency = $request->calibration_frequency;
            $equipment->preventive_maintenance_plan = $request->preventive_maintenance_plan;
            $equipment->calibration_information = $request->calibration_information;
            $equipment->next_pm_date = $request->next_pm_date;
            $equipment->next_calibration_date = $request->next_calibration_date;
            $equipment->maintenance_history = $request->maintenance_history;


            if (!empty($request->file_attachment)) {
                $files = [];
                if ($request->hasfile('file_attachment')) {
                    foreach ($request->file('file_attachment') as $file) {
                        $name = $request->name . 'file_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $equipment->file_attachment = json_encode($files);
            }
            $equipment->update();



            if ($lastDocument->short_description != $request->short_description) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->previous = $lastDocument->short_description;
                $validation2->current = $request->short_description;
                $validation2->activity_type = 'Short Description';
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not applicable";
                $validation2->change_from = $lastDocument->status;
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if ($lastDocument->initiation_date != $request->initiation_date) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Initiation Date';
                $validation2->previous = $lastDocument->initiation_date;
                $validation2->current = $request->initiation_date;
                $validation2->comment = "Not Applicable";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


                $validation2->change_to =   "Not applicable";
                $validation2->change_from = $lastDocument->status;
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if ($lastDocument->assign_to != $request->assign_to) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Assign To';
                $validation2->previous = $lastDocument->assign_to;
                $validation2->current = $request->assign_to;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


                $validation2->change_to =   "Not applicable";
                $validation2->change_from = $lastDocument->status;
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if ($lastDocument->assign_due_date != $request->assign_due_date) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = ' Assign Due Date';
                $validation2->previous = $lastDocument->assign_due_date;
                $validation2->current = $request->assign_due_date;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not applicable";
                $validation2->change_from = $lastDocument->status;
                $validation2->action_name = 'Update';

                $validation2->save();
            }

            if ($lastDocument->type != $request->type) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Type';
                $validation2->previous = $lastDocument->type;
                $validation2->current = $request->type;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not applicable";
                $validation2->change_from = $lastDocument->status;
                $validation2->action_name = 'Update';

                $validation2->save();
            }

            if ($lastDocument->number_id != $request->number_id) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Number IDs';
                $validation2->previous = $lastDocument->number_id;
                $validation2->current = $request->number_id;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


                $validation2->change_to =   "Not applicable";
                $validation2->change_from = $lastDocument->status;
                $validation2->action_name = 'Update';

                $validation2->save();
            }

            if ($lastDocument->site_name != $request->site_name) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Site Name';
                $validation2->previous = $lastDocument->site_name;
                $validation2->current = $request->site_name;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


                $validation2->change_to =   "Not applicable";
                $validation2->change_from = $lastDocument->status;
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if ($lastDocument->building != $request->building) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Building';
                $validation2->previous = $lastDocument->building;
                $validation2->current = $request->building;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


                $validation2->change_to =   "Not applicable";
                $validation2->change_from = $lastDocument->status;
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if ($lastDocument->floor != $request->floor) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Floor';
                $validation2->previous = $lastDocument->floor;
                $validation2->current = $request->floor;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


                $validation2->change_to =   "Not applicable";
                $validation2->change_from = $lastDocument->status;
                $validation2->action_name = 'Update';
                $validation2->save();
            }


            if ($lastDocument->rooms != $request->rooms) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Room';
                $validation2->previous = $lastDocument->rooms;
                $validation2->current = $request->rooms;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


                $validation2->change_to =   "Not applicable";
                $validation2->change_from = $lastDocument->status;
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if ($lastDocument->description != $request->description) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Description';
                $validation2->previous = $lastDocument->description;
                $validation2->current = $request->description;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not applicable";
                $validation2->change_from = $lastDocument->status;
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if ($lastDocument->comments != $request->comments) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Comments';
                $validation2->previous = $lastDocument->comments;
                $validation2->current = $request->comments;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not applicable";
                $validation2->change_from = $lastDocument->status;
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if ($lastDocument->file_attechment != $request->file_attechment) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'File Attachment';
                $validation2->previous = $lastDocument->file_attechment;
                $validation2->current = $request->file_attechment;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


                $validation2->change_to =   "Not applicable";
                $validation2->change_from = $lastDocument->status;
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if ($lastDocument->pm_frequency != $request->pm_frequency) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'PM Frequency';
                $validation2->previous = $lastDocument->pm_frequency;
                $validation2->current = $request->pm_frequency;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


                $validation2->change_to =   "Not applicable";
                $validation2->change_from = $lastDocument->status;
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if ($lastDocument->calibration_frequency != $request->calibration_frequency) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Calibration Frequency';
                $validation2->previous = $lastDocument->calibration_frequency;
                $validation2->current = $request->calibration_frequency;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not applicable";
                $validation2->change_from = $lastDocument->status;
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if ($lastDocument->preventive_maintenance_plan != $request->preventive_maintenance_plan) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Preventive Maintenance Plan';
                $validation2->previous = $lastDocument->preventive_maintenance_plan;
                $validation2->current = $request->preventive_maintenance_plan;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not applicable";
                $validation2->change_from = $lastDocument->status;
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if ($lastDocument->calibration_information != $request->calibration_information) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Calibration Information';
                $validation2->previous = $lastDocument->calibration_information;
                $validation2->current = $request->calibration_information;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not applicable";
                $validation2->change_from = $lastDocument->status;
                $validation2->action_name = 'Update';
                $validation2->save();
            }


            if ($lastDocument->next_pm_date != $request->next_pm_date) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Next PM Date';
                $validation2->previous = $lastDocument->next_pm_date;
                $validation2->current = $request->next_pm_date;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


                $validation2->change_to =   "Not applicable";
                $validation2->change_from = $lastDocument->status;
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if ($lastDocument->next_calibration_date != $request->next_calibration_date) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Next Calibration Date';
                $validation2->previous = $lastDocument->next_calibration_date;
                $validation2->current = $request->next_calibration_date;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not applicable";
                $validation2->change_from = $lastDocument->status;
                $validation2->action_name = 'Update';
                $validation2->save();
            }


            if ($lastDocument->maintenance_history != $request->maintenance_history) {
                $validation2 = new EquipmentAudit();
                $validation2->equipment_id = $equipment->id;
                $validation2->activity_type = 'Maintenance History';
                $validation2->previous = $lastDocument->maintenance_history;
                $validation2->current = $request->maintenance_history;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


                $validation2->change_to =   "Not applicable";
                $validation2->change_from = $lastDocument->status;
                $validation2->action_name = 'Update';
                $validation2->save();
            }



            toastr()->success("Equipment is created Successfully");
            return redirect(url('rcms/qms-dashboard'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Failed to save equipment: ' . $e->getMessage());
        }
    }


    public function equipment_send_stage(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $equipment = Equipment::find($id);
            $lastDocument = Equipment::find($id);

            if (!$equipment) {
                toastr()->error('Equipment not found');
                return back();
            }

            if ($equipment->stage == 1) {
                $equipment->stage = "2";
                $equipment->status = "Supervisor Review";

                $equipment->update();

                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 2) {
                $equipment->stage = "3";
                $equipment->status = "Pending Validation";
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 3) {
                $equipment->stage = "4";
                $equipment->status = "Pending QA Approval";
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            // if ($equipment->stage == 4) {
            // if ($equipment->test_required == "yes") {
            //     $equipment->stage = "5";
            //     $equipment->status = "Deviation in Progress";
            //     $equipment->update();
            //     toastr()->success('Document Sent');
            //     return back();
            // } else {
            //     $equipment->stage = "6";
            //     $equipment->status = "Pending Completion";
            //     $equipment->update();
            //     toastr()->success('Document Sent');
            //     return back();
            // // }
            // }

            if ($equipment->stage == 4) {
                $equipment->stage = "5";
                $equipment->status = "Approved Equipment";
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 5) {
                $equipment->stage = "6";
                $equipment->status = "Out of Service";
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 6) {
                $equipment->stage = "7";
                $equipment->status = "In Storage";
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            // if ($equipment->stage == 7) {
            //     $equipment->stage = "8";
            //     $equipment->status = "Active Document";
            //     $equipment->update();
            //     toastr()->success('Document Sent');
            //     return back();
            // }

            if ($equipment->stage == 7) {
                $equipment->stage = "8";
                $equipment->status = "Closed - Done";
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }


    public function equipmentCancel(Request $request, $id)
    {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $equipment = Equipment::find($id);

            if ($equipment->stage == 1) {
                $equipment->stage = "0";
                $equipment->status = "Closed-Cancelled";
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 3) {
                $equipment->stage = "1";
                $equipment->status = "Opened";
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($equipment->stage == 4) {
                $equipment->stage = "3";
                $equipment->status = "Pending Validation";
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($equipment->stage == 5) {
                $equipment->stage = "4";
                $equipment->status = "Test in Progress";
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }
            // if ($equipment->stage == 6) {
            //     $equipment->stage = "5";
            //     $equipment->status = "Approved Equipment";
            //     $equipment->update();
            //     toastr()->success('Document Sent');
            //     return back();
            // }

            if ($equipment->stage == 6) {
                if ($equipment->re_active_not == "yes") {
                    $equipment->stage = "5";
                    $equipment->status = "Approved Equipment";
                    $equipment->update();
                    toastr()->success('Document Sent');
                    return back();
                } else {
                    $equipment->stage = "3";
                    $equipment->status = "Pending Validation";
                    $equipment->update();
                    toastr()->success('Document Sent');
                    return back();
                }
            }
            if ($equipment->stage == 7) {
                $equipment->stage = "6";
                $equipment->status = "Pending Completion";
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 7) {
                $equipment->stage = "9";
                $equipment->status = "Closed - Done";
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($equipment->stage == 8) {
                $equipment->stage = "7";
                $equipment->status = "Pending Approval";
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($equipment->stage == 9) {
                $equipment->stage = "8";
                $equipment->status = "Active Document";
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }
            toastr()->error('States not Defined');
            return back();
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }


    // <------------------equipment child start--------------------->
    public function equipment_child_1(Request $request, $id)
    {

        // $cft = [];
        // $parent_id = $id;
        // $parent_type = "Audit_Program";
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('d-M-Y');
        $parent_record = Equipment::where('id', $id)->value('record');
        $parent_record = str_pad($parent_record, 4, '0', STR_PAD_LEFT);
        $parent_division_id = Equipment::where('id', $id)->value('division_id');
        $parent_initiator_id = Equipment::where('id', $id)->value('initiator_id');
        $parent_initiation_date = Equipment::where('id', $id)->value('initiation_date');
        $parent_short_description = Equipment::where('id', $id)->value('short_description');
        $hod = User::where('role', 4)->get();
        if ($request->child_type == "calibration") {
            $parent_due_date = "";
            $parent_id = $id;
            $parent_name = $request->parent_name;
            if ($request->due_date) {
                $parent_due_date = $request->due_date;
            }

            $record_number = ((RecordNumber::first()->value('counter')) + 1);
            $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
            $Extensionchild = Equipment::find($id);
            // $Extensionchild->Extensionchild = $record_number;
            $Extensionchild->save();
            return view('frontend.forms.extension', compact('parent_id', 'parent_name', 'record_number', 'parent_due_date'));
        }
        if ($request->child_type == "pm") {
            $parent_due_date = "";
            $parent_id = $id;
            $parent_name = $request->parent_name;
            if ($request->due_date) {
                $parent_due_date = $request->due_date;
            }

            $record_number = ((RecordNumber::first()->value('counter')) + 1);
            $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
            $Extensionchild = Equipment::find($id);
            // $Extensionchild->Extensionchild = $record_number;
            $Extensionchild->save();
            return view('frontend.forms.extension', compact('parent_id', 'parent_name', 'record_number', 'parent_due_date'));
        }
        $old_record = Equipment::select('id', 'division_id', 'record')->get();
        if ($request->child_type == "deviation") {
            $parent_name = "Deviation";
            $Capachild = Equipment::find($id);
            $pre = Deviation::all();
            // $Capachild->record = $record_number;
            $Capachild->save();
            return view('frontend.forms.deviation_new', compact('record_number', 'due_date', 'Capachild', 'parent_short_description', 'parent_initiator_id', 'parent_initiation_date', 'parent_name', 'parent_division_id', 'parent_record', 'old_record', 'pre'));
        } else {
            $parent_name = "Root";
            $Rootchild = Equipment::find($id);
            $Rootchild->Rootchild = $record_number;
            $Rootchild->save();
            return view('frontend.forms.root-cause-analysis', compact('parent_id', 'parent_type', 'record_number', 'due_date', 'parent_short_description', 'parent_initiator_id', 'parent_intiation_date', 'parent_name', 'parent_division_id', 'parent_record',));
        }
    }


    public function audit_Equipment($id)
    {
        // dd('requ');
        $audit = EquipmentAudit::where('equipment_id', $id)->orderByDESC('id')->paginate(10);
        // dd($audit);
        $today = Carbon::now()->format('d-m-y');
        $document = Equipment::where('id', $id)->first();
        $document->originator = User::where('id', $document->initiator_id)->value('name');
        // dd($document);

        return view('frontend.new_forms.equipment.auditEquipment', compact('document', 'audit', 'today'));
    }

    public function singleReport($id)
    {
        $data = Equipment::find($id);
        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');

            $doc = EquipmentAudit::where('equipment_id', $data->id)->first();
            $detail_data = EquipmentAudit::where('activity_type', $data->activity_type)
                ->where('equipment_id', $data->equipment_id)
                ->latest()
                ->get();

            // pdf related work
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.New_forms.equipment.singleEquipmentReport', compact(
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
            return $pdf->stream('Equipment' . $id . '.pdf');


            // $pdf->setPaper('A4');
            // $pdf->render();
            // $canvas = $pdf->getDomPDF()->getCanvas();
            // $height = $canvas->get_height();
            // $width = $canvas->get_width();

            // $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');

            // // Ensure that the text parameter is a string
            // $text = 'Sample Watermark';  // Replace with actual text if needed
            // // Ensure the color is an array of three integers
            // $color = [0, 0, 0];  // RGB color array

            // $canvas->page_text(
            //     $width / 4,
            //     $height / 2,
            //     $text,
            //     null, // Font
            //     25,   // Font size
            //     $color, // Color array
            //     2, // Word spacing
            //     6, // Character spacing
            //     -20 // Angle
            // );

            // return $pdf->stream('SOP' . $id . '.pdf');
        }

        // Handle the case where the $data is empty or not found
        return redirect()->back()->with('error', 'Equipment not found.');
    }

    public function EquipmentAuditTrialDetails($id)
    {
        $detail = EquipmentAudit::find($id);
        $detail_data = EquipmentAudit::where('activity_type', $detail->activity_type)->where('equipment_id', $detail->equipment_id)->latest()->get();
        $doc = Equipment::where('id', $detail->equipment_id)->first();
        $doc->origiator_name = User::find($doc->initiator_id);
        return view('frontend.New_forms.equipment.equipment_audit_details', compact('detail', 'doc', 'detail_data'));
    }

    public function audit_pdf1($id)
    {
        $doc = Equipment::find($id);
        if (!empty($doc)) {
            $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        } else {
            $datas = ActionItem::find($id);

            if (empty($datas)) {
                $datas = Extension::find($id);
                $doc = Equipment::find($datas->equipment_id);
                $doc->originator = User::where('id', $doc->initiator_id)->value('name');
                $doc->created_at = $datas->created_at;
            } else {
                $doc = Equipment::find($datas->equipment_id);
                $doc->originator = User::where('id', $doc->initiator_id)->value('name');
                $doc->created_at = $datas->created_at;
            }
        }
        $data = EquipmentAudit::where('equipment_id', $doc->id)->orderByDesc('id')->get();
        // pdf related work
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.New_forms.equipment.equipment_audit_trail_pdf', compact('data', 'doc'))
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
