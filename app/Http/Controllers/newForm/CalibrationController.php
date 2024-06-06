<?php

namespace App\Http\Controllers\newForm;

use App\Http\Controllers\Controller;
use App\Models\Calibration;
use App\Models\RecordNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use PDF;
class CalibrationController extends Controller
{
    public function calibrationIndex(){

        $old_record = Calibration::select('id', 'division_id', 'record')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');

        return view('frontend.New_forms.calibration.calibration',compact('old_record', 'record_number', 'currentDate', 'formattedDate', 'due_date'));
    }

    public function calibrationStore(Request $request){


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
            toastr()->success("Calibration is created Successfully");
            return redirect(url('rcms/qms-dashboard'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Failed to save calibration: ' . $e->getMessage());
        }
    }

    public function calibrationEdit($id){
        $calibration = Calibration::findOrFail($id);
        return view('frontend.New_forms.calibration.calibration_view', compact('calibration'));
    }


    public function calibrationUpdate(Request $request, $id){
        if (!$request->short_description) {
            toastr()->info("Short Description is required");
            return redirect()->back()->withInput();
        }

        try {
            $recordCounter = RecordNumber::first();
            $newRecordNumber = $recordCounter->counter + 1;

            $recordCounter->counter = $newRecordNumber;
            $recordCounter->save();


            $calibration =Calibration::findOrFail($id);

            $calibration->parent_id = $request->parent_id;
            $calibration->parent_type = $request->parent_type;
            $calibration->record = $newRecordNumber;

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
                if ($request->action == 'within-limits') {
                    $equipment->stage = "4";
                    $equipment->status = "Pending QA Approval";
                } elseif ($request->action == 'out-of-limits') {
                    $equipment->stage = "3";
                    $equipment->status = "Pending Out of Limits Actions";
                }
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

    public function calibrationCancel(Request $request, $id){
    
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $equipment = Calibration::find($id);

            if ($equipment->stage == 1) {
                $equipment->stage = "0";
                $equipment->status = "Closed-Cancelled";
                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }

            // if ($equipment->stage == 3) {
            //     $equipment->stage = "1";
            //     $equipment->status = "Opened";
            //     $equipment->update();
            //     toastr()->success('Document Sent');
            //     return back();
            // }
            // if ($equipment->stage == 4) {
            //     $equipment->stage = "3";
            //     $equipment->status = "Pending Validation";
            //     $equipment->update();
            //     toastr()->success('Document Sent');
            //     return back();
            // }
            // if ($equipment->stage == 5) {
            //     $equipment->stage = "4";
            //     $equipment->status = "Test in Progress";
            //     $equipment->update();
            //     toastr()->success('Document Sent');
            //     return back();
            // }
            // if ($equipment->stage == 6) {
            //     $equipment->stage = "5";
            //     $equipment->status = "Approved Equipment";
            //     $equipment->update();
            //     toastr()->success('Document Sent');
            //     return back();
            // }
            
           
            if ($equipment->stage == 7) {
                $equipment->stage = "9";
                $equipment->status = "Closed - Done";
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
    
}
