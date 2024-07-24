<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

use App\Models\MedicalDevice;
use App\Models\medicaldevice_audittrails;
use App\Models\RecordNumber;
use App\Models\RoleGroup;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Carbon\Carbon;
use PDF;

class MedicalDeviceController extends Controller
{
    public function index()
    {

        $old_record = MedicalDevice::select('id')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view('frontend.New_forms.medical-device', compact('old_record', 'record_number', 'currentDate', 'formattedDate', 'due_date'));

        // return view('frontend.New_forms.medical-device');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'short_description' => 'required',

        ]);
        $recordCounter = RecordNumber::first();
        $newRecordNumber = $recordCounter->counter + 1;

        $recordCounter->counter = $newRecordNumber;
        $recordCounter->save();

        $medicalDevice = new MedicalDevice();
        $medicalDevice->status = 'opened';
        $medicalDevice->stage = 1;



        $medicalDevice->initiator_id = Auth::user()->id;
        $medicalDevice->initiator = $request->initiator;
        $medicalDevice->date_of_initiation = $request->date_of_initiation;
        $medicalDevice->short_description = $request->short_description;
        $medicalDevice->type = $request->type;
        $medicalDevice->record = $newRecordNumber;
        $medicalDevice->other_type = $request->other_type;
        $medicalDevice->assign_to = $request->assign_to;
        $medicalDevice->due_date = $request->due_date;
        // dd($request->due_date);
        $medicalDevice->URLs = $request->URLs;
        $medicalDevice->trade_name = $request->trade_name;
        $medicalDevice->manufacturer = $request->manufacturer;
        $medicalDevice->therapeutic_area = $request->therapeutic_area;
        $medicalDevice->prooduct_code = $request->prooduct_code;
        $medicalDevice->intended_use = $request->intended_use;
        if (!empty($request->attachment)) {
            $files = [];
            if ($request->hasfile('attachment')) {
                foreach ($request->file('attachment') as $file) {
                    $name = $request->name . 'attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
                // dd($files);
            }

            $medicalDevice->attachment = json_encode($files);
        }

        $medicalDevice->save();

        // --------------------------for audit trail------------------------

        if (!empty($request->short_description)) {
            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $medicalDevice->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Null";
            $history->current = $request->short_description;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->initiator)) {
            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $medicalDevice->id;
            $history->activity_type = 'Initiator';
            $history->previous = "Null";
            $history->current = $request->initiator;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;`
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->type)) {
            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $medicalDevice->id;
            $history->activity_type = 'Type';
            $history->previous = "Null";
            $history->current = $request->type;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;`
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";

            $history->save();
        }
        if (!empty($request->other_type)) {
            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $medicalDevice->id;
            $history->activity_type = 'Other Type';
            $history->previous = "Null";
            $history->current = $request->other_type;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;`
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";


            $history->save();
        }
        if (!empty($request->assign_to)) {
            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $medicalDevice->id;
            $history->activity_type = 'Assigned To';
            $history->previous = "Null";
            $history->current = $request->assign_to;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;`
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";


            $history->save();
        }
        if (!empty($request->due_date)) {
            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $medicalDevice->id;
            $history->activity_type = ' Due Date';
            $history->previous = "Null";
            $history->current = $request->due_date;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;`
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";


            $history->save();
        }
        if (!empty($request->URLs)) {
            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $medicalDevice->id;
            $history->activity_type = 'Related URLs';
            $history->previous = "Null";
            $history->current = $request->URLs;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;`
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";


            $history->save();
        }
        if (!empty($request->attachment)) {
            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $medicalDevice->id;
            $history->activity_type = 'attachment';
            $history->previous = "Null";
            // $history->current = $request->attachment;
            $history->current = json_encode($request->attachment);
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;`
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";


            $history->save();
        }
        if (!empty($request->trade_name)) {
            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $medicalDevice->id;
            $history->activity_type = 'trade_name';
            $history->previous = "Null";
            $history->current = $request->trade_name;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;`
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";


            $history->save();
        }
        if (!empty($request->manufacturer)) {
            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $medicalDevice->id;
            $history->activity_type = 'manufacturer';
            $history->previous = "Null";
            $history->current = $request->manufacturer;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;`
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";


            $history->save();
        }
        if (!empty($request->therapeutic_area)) {
            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $medicalDevice->id;
            $history->activity_type = 'therapeutic_area';
            $history->previous = "Null";
            $history->current = $request->therapeutic_area;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;`
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";


            $history->save();
        }
        if (!empty($request->prooduct_code)) {
            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $medicalDevice->id;
            $history->activity_type = 'prooduct_code';
            $history->previous = "Null";
            $history->current = $request->prooduct_code;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;`
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";


            $history->save();
        }
        if (!empty($request->intended_use)) {
            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $medicalDevice->id;
            $history->activity_type = 'intended_use';
            $history->previous = "Null";
            $history->current = $request->intended_use;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;`
            $history->change_to =   "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";


            $history->save();
        }




        return redirect()->back()->with('success', 'Medical Device added successfully');
    }

    public function show($id)
    {
        $medicalDevice = MedicalDevice::find($id);
        $medicalDevice->record = str_pad($medicalDevice->record, 4, '0', STR_PAD_LEFT);


        return view('frontend.New_forms.medical_device_view', compact('medicalDevice'));
    }

    public function Update(Request $request, $id)
    {

        //if (!$request->short_descriptionription) {
        //toastr()->info("Short Description is required");
        //return redirect()->back()->withInput();
        // $MedicalDevice = new MedicalDevice();
        $medicalDevice = MedicalDevice::findOrFail($id);
        // $medicalDevice  = MedicalDevice::find($id);
        // $medicalDevice->initiator= $request->initiator;
        // $medicalDevice->date_Of_initiation=$request->date_Of_initiation;
        $medicalDevice->short_description = $request->short_description;
        $medicalDevice->type = $request->type;
        $medicalDevice->other_type = $request->other_type;
        $medicalDevice->assign_to = $request->assign_to;
        $medicalDevice->due_date = $request->due_date;
        $medicalDevice->URLs = $request->URLs;
        $medicalDevice->trade_name = $request->trade_name;
        $medicalDevice->manufacturer = $request->manufacturer;
        $medicalDevice->therapeutic_area = $request->therapeutic_area;
        $medicalDevice->prooduct_code = $request->prooduct_code;
        $medicalDevice->intended_use = $request->intended_use;

        if (!empty($request->attachment)) {
            $files = [];
            if ($request->hasfile('attachment')) {
                foreach ($request->file('attachment') as $file) {
                    $name = $request->name . 'attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $medicalDevice->attachment = json_encode($files);
        }

        $medicalDevice->save();

        if (!empty($request->short_description_comment)) {

            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $id;
            $history->activity_type = 'Short Description';
            $history->previous = $medicalDevice->short_description;
            $history->current = $medicalDevice->short_description;
            $history->comment = $request->short_description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // $history->origin_state = $medicalDevice->status;
                    //     $validation2->change_to =   "not applicable";
            // $validation2->change_from = $lastdocuments->stages;
            $history->action_name = 'Update';
        //     $validation2->comment = "Not Applicable";
            $history->save();
        }


        if ($medicalDevice->initiator != $medicalDevice->initiator || !empty($request->initiator_comment)) {

            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $id;
            $history->activity_type = 'Initiator';
            $history->previous = $medicalDevice->initiator;
            $history->current = $medicalDevice->initiator;
            $history->comment = $request->initiator_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            // $history->origin_state = $medicalDevice->status;
            $history->save();
        }
        if ($medicalDevice->type != $medicalDevice->type || !empty($request->type_comment)) {

            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $id;
            $history->activity_type = 'type';
            $history->previous = $medicalDevice->type;
            $history->current = $medicalDevice->type;
            $history->comment = $request->type_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            // $history->origin_state = $medicalDevice->status;
            $history->save();
        }
        if ($medicalDevice->other_type != $medicalDevice->other_type || !empty($request->other_type_comment)) {

            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $id;
            $history->activity_type = 'other_type';
            $history->previous = $medicalDevice->other_type;
            $history->current = $medicalDevice->other_type;
            $history->comment = $request->other_type_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            // $history->origin_state = $medicalDevice->status;
            $history->save();
        }
        if ($medicalDevice->assign_to != $medicalDevice->assign_to || !empty($request->assign_to_comment)) {

            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $id;
            $history->activity_type = 'assign_to';
            $history->previous = $medicalDevice->assign_to;
            $history->current = $medicalDevice->assign_to;
            $history->comment = $request->assign_to_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            // $history->origin_state = $medicalDevice->status;
            $history->save();
        }
        if ($medicalDevice->due_date != $medicalDevice->due_date || !empty($request->due_date_comment)) {

            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $id;
            $history->activity_type = 'due_date';
            $history->previous = $medicalDevice->due_date;
            $history->current = $medicalDevice->due_date;
            $history->comment = $request->due_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            // $history->origin_state = $medicalDevice->status;
            $history->save();
        }
        if ($medicalDevice->URLs != $medicalDevice->URLs || !empty($request->URLs_comment)) {

            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $id;
            $history->activity_type = 'URLs';
            $history->previous = $medicalDevice->URLs;
            $history->current = $medicalDevice->URLs;
            $history->comment = $request->URLs_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            // $history->origin_state = $medicalDevice->status;
            $history->save();
        }
        if ($medicalDevice->trade_name != $medicalDevice->trade_name || !empty($request->trade_name_comment)) {

            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $id;
            $history->activity_type = 'trade_name';
            $history->previous = $medicalDevice->trade_name;
            $history->current = $medicalDevice->trade_name;
            $history->comment = $request->trade_name_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            // $history->origin_state = $medicalDevice->status;
            $history->save();
        }
        if ($medicalDevice->manufacturer != $medicalDevice->manufacturer || !empty($request->manufacturer_comment)) {

            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $id;
            $history->activity_type = 'manufacturer';
            $history->previous = $medicalDevice->manufacturer;
            $history->current = $medicalDevice->manufacturer;
            $history->comment = $request->manufacturer_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            // $history->origin_state = $medicalDevice->status;
            $history->save();
        }
        if ($medicalDevice->therapeutic_area != $medicalDevice->therapeutic_area || !empty($request->therapeutic_area_comment)) {

            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $id;
            $history->activity_type = 'therapeutic_area';
            $history->previous = $medicalDevice->therapeutic_area;
            $history->current = $medicalDevice->therapeutic_area;
            $history->comment = $request->therapeutic_area_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            // $history->origin_state = $medicalDevice->status;
            $history->save();
        }
        if ($medicalDevice->prooduct_code != $medicalDevice->prooduct_code || !empty($request->prooduct_code_comment)) {

            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $id;
            $history->activity_type = 'prooduct_code';
            $history->previous = $medicalDevice->prooduct_code;
            $history->current = $medicalDevice->prooduct_code;
            $history->comment = $request->prooduct_code_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            // $history->origin_state = $medicalDevice->status;
            $history->save();
        }
        if ($medicalDevice->intended_use != $medicalDevice->intended_use || !empty($request->intended_use_comment)) {

            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $id;
            $history->activity_type = 'intended_use';
            $history->previous = $medicalDevice->intended_use;
            $history->current = $medicalDevice->intended_use;
            $history->comment = $request->intended_use_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->action_name = 'Update';
            // $history->origin_state = $medicalDevice->status;
            $history->save();
        }

        return redirect()->back()->with('success', 'Medical Device updated successfully');
    }



    public function medicalDevice_cancel(Request $request, $id)
    {
        $device = MedicalDevice::find($id);
        if ($device->stage == 1) {
            $device->stage = "0";
            $device->status = "Closed-Cancelled";
            $device->update();
            toastr()->success('Document Sent');
            return back();
        }
    }



    public function stageChange(Request $request, $id)
    {
        // if($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password))
        {
            $device = MedicalDevice::find($id);
            $device = MedicalDevice::find($id);
            $lastDocument = medicaldevice_audittrails::where('medicalDevice_id', $id)->orderBy('id', 'desc')->first();
            if ($device->stage == 1) {
                $device->stage = "2";
                $device->status = "In Progress";
                $device->started_by = Auth::user()->name;
                $device->started_on = Carbon::now()->format('d-M-Y');
                // $device->cancelled_comment = $request->comment;
                $history = new medicaldevice_audittrails();
                $history->medicalDevice_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->started_by;
                $history->current = $device->started_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = '2';
                $history->change_to = " In Progress";
                $history->change_from = $lastDocument->status;
                $history->action_name = 'Start';
                $history->save();

                $device->update();
                toastr()->success('Document Sent');
                return back();
            }
        }
        if ($device->stage == 2) {
            $device->stage = "3";
            $device->status = "Retired";
            $device->retired_by = Auth::user()->name;
            $device->retired_on = Carbon::now()->format('d-M-Y');
            // $device->cancelled_comment = $request->comment;
            $history = new medicaldevice_audittrails();
            $history->medicalDevice_id = $id;
            $history->activity_type = 'Activity Log';
            $history->previous = $lastDocument->retired_by;
            $history->current = $device->retired_by;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->stage = '3';
            $history->change_to = "Retired";
            $history->change_from = $lastDocument->status;
            $history->action_name = 'Retire';
            $history->save();

            $device->update();
            toastr()->success('Document Sent');
            return back();
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public static function singleReport($id)
    {
        $data = MedicalDevice::find($id);
        // dd($data);
        if (!empty ($data)) {
            $data->initiator = User::where('id', $data->initiator)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.forms.singleMedicalReport', compact('data'))
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
            return $pdf->stream('PSUR' . $id . '.pdf');
        }

    }

    public function auditTrialshow($id)
    {
        $audit = medicaldevice_audittrails::where("medicalDevice_id", $id)->orderByDESC('id')->paginate(20);
        $today = Carbon::now()->format('Y-m-d');
        $document = MedicalDevice::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');

        return view('frontend.forms.medicaldevice_audit_trail', compact('audit', 'document', 'today'));
    }
    public function auditTrailPdf($id){
        $doc = MedicalDevice::find($id);
        $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        $data = medicaldevice_audittrails::where('medicalDevice_id', $doc->id)->orderByDesc('id')->get();
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.forms.Medicaldevice-audit-pdf', compact('data', 'doc'))
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
