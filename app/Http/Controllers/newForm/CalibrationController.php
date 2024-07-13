<?php

namespace App\Http\Controllers\newForm;

use App\Http\Controllers\Controller;
use App\Models\Calibration;
use App\Models\CalibrationAudit;
use App\Models\RecordNumber;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ActionItem;
use App\Models\Extension;
use App\Models\RcmDocHistory;
use Carbon\Carbon;
use App\Models\RoleGroup;
use PDF;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CalibrationController extends Controller
{
    public function calibrationIndex()
    {

        $old_record = Calibration::select('id', 'division_id', 'record')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');

        return view('frontend.New_forms.calibration.calibration', compact('old_record', 'record_number', 'currentDate', 'formattedDate', 'due_date'));
    }

    public function calibrationStore(Request $request)
    {


        try {
            $recordCounter = RecordNumber::first();
            $newRecordNumber = $recordCounter->counter + 1;

            $recordCounter->counter = $newRecordNumber;
            $recordCounter->save();


            $calibration = new Calibration();

            $calibration->stage = '1';
            $calibration->status = 'Opened';
            $calibration->parent_id = $request->parent_id;
            $calibration->parent_type = $request->parent_type;
            $calibration->record = $newRecordNumber;

            $calibration->initiator_id = Auth::user()->id;
            $calibration->user_name = Auth::user()->name;
            $calibration->initiation_date = $request->initiation_date;
            $calibration->division_id = $request->division_id;
            $calibration->divison_code = $request->divison_code;
            $calibration->short_description = $request->short_description;
            $calibration->originator = $request->originator;
            $calibration->assign_to = $request->assign_to;
            $calibration->due_date = $request->due_date;
            $calibration->description = $request->description;
            $calibration->device_condition_m = $request->device_condition_m;
            $calibration->replace_parts_m = $request->replace_parts_m;
            $calibration->calibration_rating_m = $request->calibration_rating_m;
            $calibration->update_software_m = $request->update_software_m;
            $calibration->replace_betteries_m = $request->replace_betteries_m;
            $calibration->parent_equipment_name_m = $request->parent_equipment_name_m;
            $calibration->parent_equipment_type_m = $request->parent_equipment_type_m;
            $calibration->save();


            if (!empty($request->short_description)) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->previous = 'null';
                $validation2->current = $request->short_description;
                $validation2->activity_type = 'Short Description';
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "'Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->initiation_date)) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->activity_type = 'Date Of Opened';
                $validation2->previous = 'null';
                $validation2->current = $request->initiation_date;
                $validation2->comment = "Not Applicable";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation2->change_to =   "Opened";
                $validation2->change_from = "'Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->assign_to)) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->activity_type = 'Assign To';
                $validation2->previous = 'null';
                $validation2->current = $request->assign_to;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "'Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->due_date)) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->activity_type = ' Due Date';
                $validation2->previous = 'null';
                $validation2->current = $request->due_date;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "'Initiation";
                $validation2->action_name = 'Create';

                $validation2->save();
            }

            if (!empty($request->originator)) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->activity_type = 'Originator';
                $validation2->previous = 'null';
                $validation2->current = $request->originator;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation2->change_to =   "Opened";
                $validation2->change_from = "'Initiation";
                $validation2->action_name = 'Create';

                $validation2->save();
            }

            if (!empty($request->device_condition_m)) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->activity_type = 'Device Condition M';
                $validation2->previous = 'null';
                $validation2->current = $request->device_condition_m;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "'Initiation";
                $validation2->action_name = 'Create';

                $validation2->save();
            }

            if (!empty($request->replace_parts_m)) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->activity_type = 'Replace Parts M';
                $validation2->previous = 'null';
                $validation2->current = $request->replace_parts_m;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "'Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->calibration_rating_m)) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->activity_type = 'Calibration Rating M';
                $validation2->previous = 'null';
                $validation2->current = $request->calibration_rating_m;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "'Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->update_software_m)) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->activity_type = 'Update Software M';
                $validation2->previous = 'null';
                $validation2->current = $request->update_software_m;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "'Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }


            if (!empty($request->replace_betteries_m)) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->activity_type = 'Replace Betteries M';
                $validation2->previous = 'null';
                $validation2->current = $request->replace_betteries_m;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "'Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->description)) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->activity_type = 'Description';
                $validation2->previous = 'null';
                $validation2->current = $request->description;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "'Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->parent_equipment_name_m)) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->activity_type = 'Parent Equipment Name M';
                $validation2->previous = 'null';
                $validation2->current = $request->parent_equipment_name_m;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "'Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->parent_equipment_type_m)) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->activity_type = 'Parent Equipment Type M';
                $validation2->previous = 'null';
                $validation2->current = $request->parent_equipment_type_m;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "'Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            toastr()->success("Calibration is created Successfully");
            return redirect(url('rcms/qms-dashboard'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Failed to save calibration: ' . $e->getMessage());
        }
    }

    public function calibrationEdit($id)
    {
        $calibration = Calibration::findOrFail($id);

        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view('frontend.New_forms.calibration.calibration_view', compact('calibration', 'due_date'));
    }

    public function calibrationUpdate(Request $request, $id)
    {
        if (!$request->short_description) {
            toastr()->info("Short Description is required");
            return redirect()->back()->withInput();
        }

        try {
            $calibration = Calibration::findOrFail($id);

            $lastDocument = Calibration::findOrFail($id);

            $calibration->parent_id = $request->parent_id;
            $calibration->parent_type = $request->parent_type;

            $calibration->initiator_id = Auth::user()->id;
            $calibration->user_name = Auth::user()->name;
            $calibration->initiation_date = $request->initiation_date;
            $calibration->short_description = $request->short_description;
            $calibration->originator = $request->originator;
            $calibration->assign_to = $request->assign_to;
            $calibration->due_date = $request->due_date;
            $calibration->description = $request->description;
            $calibration->device_condition_m = $request->device_condition_m;
            $calibration->replace_parts_m = $request->replace_parts_m;
            $calibration->calibration_rating_m = $request->calibration_rating_m;
            $calibration->update_software_m = $request->update_software_m;
            $calibration->replace_betteries_m = $request->replace_betteries_m;
            $calibration->parent_equipment_name_m = $request->parent_equipment_name_m;
            $calibration->parent_equipment_type_m = $request->parent_equipment_type_m;

            $calibration->update();


            if ($lastDocument->short_description != $request->short_description) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->previous = $lastDocument->short_description;
                $validation2->current = $request->short_description;
                $validation2->activity_type = 'Short Description';
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->short_description) || $lastDocument->short_description === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }

                $validation2->save();
            }

            if ($lastDocument->initiation_date != $request->initiation_date) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->activity_type = 'Date Of Opened';
                $validation2->previous = \Carbon\Carbon::parse($lastDocument->initiation_date)->format('d-M-Y');
                $validation2->current = \Carbon\Carbon::parse($request->initiation_date)->format('d-M-Y');
                $validation2->comment = "Not Applicable";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->initiation_date) || $lastDocument->initiation_date === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->assign_to != $request->assign_to) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->activity_type = 'Assign To';
                $validation2->previous = $lastDocument->assign_to;
                $validation2->current = $request->assign_to;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->assign_to) || $lastDocument->assign_to === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->due_date != $request->due_date) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->activity_type = 'Due Date';
                $validation2->previous = \Carbon\Carbon::parse($lastDocument->due_date)->format('d-M-Y');
                $validation2->current = \Carbon\Carbon::parse($request->due_date)->format('d-M-Y');
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->due_date) || $lastDocument->due_date === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }

                $validation2->save();
            }

            if ($lastDocument->originator != $request->originator) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->activity_type = 'Originator';
                $validation2->previous = $lastDocument->originator;
                $validation2->current = $request->originator;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->originator) || $lastDocument->originator === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }

                $validation2->save();
            }

            if ($lastDocument->device_condition_m != $request->device_condition_m) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->activity_type = 'Device Condition M';
                $validation2->previous = $lastDocument->device_condition_m;
                $validation2->current = $request->device_condition_m;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->device_condition_m) || $lastDocument->device_condition_m === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->replace_parts_m != $request->replace_parts_m) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->activity_type = 'Replace Parts M';
                $validation2->previous = $lastDocument->replace_parts_m;
                $validation2->current = $request->replace_parts_m;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->replace_parts_m) || $lastDocument->replace_parts_m === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->calibration_rating_m != $request->calibration_rating_m) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->activity_type = 'Calibration Rating M';
                $validation2->previous = $lastDocument->calibration_rating_m;
                $validation2->current = $request->calibration_rating_m;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->calibration_rating_m) || $lastDocument->calibration_rating_m === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->update_software_m != $request->update_software_m) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->activity_type = 'Update Software M';
                $validation2->previous = $lastDocument->update_software_m;
                $validation2->current = $request->update_software_m;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


                $validation2->change_to =   "Not Applicable ";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->update_software_m) || $lastDocument->update_software_m === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }


            if ($lastDocument->replace_betteries_m != $request->replace_betteries_m) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->activity_type = 'Replace Betteries M';
                $validation2->previous = $lastDocument->replace_betteries_m;
                $validation2->current = $request->replace_betteries_m;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->replace_betteries_m) || $lastDocument->replace_betteries_m === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->description != $request->description) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->activity_type = 'Description';
                $validation2->previous = $lastDocument->description;
                $validation2->current = $request->description;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->description) || $lastDocument->description === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->parent_equipment_name_m != $request->parent_equipment_name_m) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->activity_type = 'Parent Equipment Name M';
                $validation2->previous = $lastDocument->parent_equipment_name_m;
                $validation2->current = $request->parent_equipment_name_m;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->parent_equipment_name_m) || $lastDocument->parent_equipment_name_m === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->parent_equipment_type_m != $request->parent_equipment_type_m) {
                $validation2 = new CalibrationAudit();
                $validation2->calibration_id = $calibration->id;
                $validation2->activity_type = 'Parent Equipment Type M';
                $validation2->previous = $lastDocument->parent_equipment_type_m;
                $validation2->current = $request->parent_equipment_type_m;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->parent_equipment_type_m) || $lastDocument->parent_equipment_type_m === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            toastr()->success("Calibration is updated Successfully");
            return redirect(url('rcms/qms-dashboard'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Failed to save calibration: ' . $e->getMessage());
        }
    }

    public function calibration_send_stage(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $equipment = Calibration::find($id);

            if (!$equipment) {
                toastr()->error('Calibration not found');
                return back();
            }

            if ($equipment->stage == 1) {
                $equipment->stage = "2";
                $equipment->status = "Calibration In Progress";
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 2) {
                $equipment->stage = "3";
                $equipment->status = "Pending Out of Limits Actions";
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            // if ($equipment->stage == 2) {
            //     if ($request->action == 'within-limits') {
            //         $equipment->stage = "4";
            //         $equipment->status = "Pending QA Approval";
            //     } elseif ($request->action == 'out-of-limits') {
            //         $equipment->stage = "3";
            //         $equipment->status = "Pending Out of Limits Actions";
            //     }
            //     $equipment->update();
            //     toastr()->success('Document Sent');
            //     return back();
            // }

            if ($equipment->stage == 3) {
                $equipment->stage = "4";
                $equipment->status = "Pending QA Approval";
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 4) {
                $equipment->stage = "5";
                $equipment->status = "Closed - Done";
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            // if ($equipment->stage == 7) {
            //     $equipment->stage = "8";
            //     $equipment->status = "Closed - Done";
            //     $equipment->update();
            //     toastr()->success('Document Sent');
            //     return back();
            // }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function calibrationCancel(Request $request, $id)
    {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $equipment = Calibration::find($id);

            if ($equipment->stage == 1) {
                $equipment->stage = "0";
                $equipment->status = "Closed-Cancelled";
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($equipment->stage == 2) {
                $equipment->stage = "4";
                $equipment->status = "Pending QA Approval";
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($equipment->stage == 4) {
                $equipment->stage = "2";
                $equipment->status = "Calibration In Progress";
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }



            // if ($equipment->stage == 7) {
            //     $equipment->stage = "9";
            //     $equipment->status = "Closed - Done";
            //     $equipment->update();
            //     toastr()->success('Document Sent');
            //     return back();
            // }

            toastr()->error('States not Defined');
            return back();
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function calibration_child_1(Request $request, $id)
    {
        // $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('d-M-Y');

        $parent_division_id = Calibration::where('id', $id)->value('division_id');
        $parent_initiator_id = Calibration::where('id', $id)->value('initiator_id');
        $parent_initiation_date = Calibration::where('id', $id)->value('initiation_date');
        $parent_short_description = Calibration::where('id', $id)->value('short_description');
        $hod = User::where('role', 4)->get();

        if ($request->child_type == "pm") {
            $parent_due_date = "";
            $parent_type = $request->parent_type;
            $parent_id = $id;
            $parent_intiation_date = Calibration::where('id', $id)->value('initiation_date');
            $parent_initiator_id = Calibration::where('id', $id)->value('initiator_id');
            $parent_record = Calibration::where('id', $id)->value('record');
            $parent_record = str_pad($parent_record, 4, '0', STR_PAD_LEFT);
            $parent_name = $request->parent_name;
            if ($request->due_date) {
                $parent_due_date = $request->due_date;
            }

            $record_number = ((RecordNumber::first()->value('counter')) + 1);
            $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
            $Extensionchild = Calibration::find($id);
            // $Extensionchild->Extensionchild = $record_number;
            $Extensionchild->save();
            return view('frontend.forms.action-item', compact('parent_id', 'parent_intiation_date', 'parent_name', 'parent_initiator_id', 'parent_record', 'parent_type', 'record_number', 'parent_due_date'));
        } else {
            $parent_name = "Root";
            $Rootchild = Calibration::find($id);
            // $Rootchild->Rootchild = $record_number;
            $Rootchild->save();
            return view('frontend.forms.root-cause-analysis', compact('parent_id', 'parent_type', 'record_number', 'due_date', 'parent_short_description', 'parent_initiator_id', 'parent_intiation_date', 'parent_name', 'parent_division_id', 'parent_record',));
        }
    }

    public function auditCalibration($id)
    {
        $calibration = Calibration::find($id);
        $audit = CalibrationAudit::where('calibration_id', $id)->orderByDESC('id')->paginate();

        $today = Carbon::now()->format('d-m-y');
        $document = Calibration::where('id', $id)->first();
        $document->originator = User::where('id', $document->initiator_id)->value('name');

        return view('frontend.new_forms.calibration.auditCalibration', compact('document', 'audit', 'today', 'calibration'));
    }

    public function CalibrationAuditTrialDetails($id)
    {
        $detail = CalibrationAudit::find($id);
        $detail_data = CalibrationAudit::where('activity_type', $detail->activity_type)->where('calibration_id', $detail->calibration_id)->latest()->get();
        $doc = Calibration::where('id', $detail->calibration_id)->first();
        $doc->origiator_name = User::find($doc->initiator_id);
        return view('frontend.New_forms.calibration.calibration_audit_details', compact('detail', 'doc', 'detail_data'));
    }

    public function singleReport($id)
    {
        $data = Calibration::find($id);
        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');

            $doc = CalibrationAudit::where('calibration_id', $data->id)->first();
            $detail_data = CalibrationAudit::where('activity_type', $data->activity_type)
                ->where('calibration_id', $data->calibration_id)
                ->latest()
                ->get();

            // pdf related work
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.New_forms.calibration.singleCalibrationReport', compact(
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

            // Ensure that the text parameter is a string
            $text = 'Sample Watermark';  // Replace with actual text if needed
            // Ensure the color is an array of three integers
            $color = [0, 0, 0];  // RGB color array

            $canvas->page_text(
                $width / 4,
                $height / 2,
                $text,
                null, // Font
                25,   // Font size
                $color, // Color array
                2, // Word spacing
                6, // Character spacing
                -20 // Angle
            );

            return $pdf->stream('SOP' . $id . '.pdf');
        }

        // Handle the case where the $data is empty or not found
        return redirect()->back()->with('error', 'Calibration not found.');
    }

    public function audit_pdf($id)
    {
        $doc = Calibration::findOrFail($id);
        if (!empty($doc)) {
            $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        } else {
            $datas = ActionItem::find($id);

            if (empty($datas)) {
                $datas = Extension::find($id);
                $doc = Calibration::find($datas->calibration_id);
                $doc->originator = User::where('id', $doc->initiator_id)->value('name');
                $doc->created_at = $datas->created_at;
            } else {
                $doc = Calibration::find($datas->calibration_id);
                $doc->originator = User::where('id', $doc->initiator_id)->value('name');
                $doc->created_at = $datas->created_at;
            }
        }
        $data = CalibrationAudit::where('calibration_id', $doc->id)->orderByDesc('id')->get();
        // pdf related work
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.New_forms.calibration.calibration_audit_trail_pdf', compact('data', 'doc'))
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
