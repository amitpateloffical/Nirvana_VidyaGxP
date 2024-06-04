<?php

namespace App\Http\Controllers\newForm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\RoleGroup;
use App\Models\User;
use App\Models\Equipment;
use App\Models\RecordNumber;

class EquipmentController extends Controller
{
    public function equipmentIndex(){

        $old_record = Equipment::select('id', 'division_id', 'record')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view('frontend.New_forms.equipment.equipment' , compact('old_record', 'record_number', 'currentDate', 'formattedDate', 'due_date'));
    }   


    public function equipmentStore(Request $request){

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

            // $equipment->record = DB::table('record_numbers')->value('counter') + 1;

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
            

                  // Retrieve the current counter value
         $counter = DB::table('record_numbers')->value('counter');
         // Generate the record number with leading zeros
         $recordNumber = str_pad($counter, 5, '0', STR_PAD_LEFT);
         // Increment the counter value
         $newCounter = $counter + 1;
         DB::table('record_numbers')->update(['counter' => $newCounter]);

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
            toastr()->success("Equipment is created Successfully");
            return redirect(url('rcms/qms-dashboard'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Failed to save equipment: ' . $e->getMessage());
        }
}


    public function equipmentEdit($id){
        $equipment = Equipment::findOrFail($id);
        return view('frontend.New_forms.equipment.equipment_view', compact('equipment'));
    }

    public function equipmentUpdate(Request $request, $id){
     
        if (!$request->short_description) {
            toastr()->info("Short Description is required");
            return redirect()->back()->withInput();
        }
        try {
    
            $equipment =  Equipment::findOrFail($id);

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

            toastr()->success("Equipment is created Successfully");
            return redirect(url('rcms/qms-dashboard'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Failed to save equipment: ' . $e->getMessage());
        }

    }

}