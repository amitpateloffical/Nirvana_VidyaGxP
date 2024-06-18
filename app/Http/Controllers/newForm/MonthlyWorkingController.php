<?php

namespace App\Http\Controllers\newForm;

use App\Http\Controllers\Controller;
use App\Models\MonthlyWorking;
use App\Models\RecordNumber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonthlyWorkingController extends Controller
{
    public function index(){
        $old_record = MonthlyWorking::select('id', 'division_id', 'record')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view('frontend.New_forms.monthly_working.monthly_working', compact( 'record_number', 'currentDate', 'formattedDate', 'due_date'));
    }

    public function monthly_workingStore(Request $request){
        try {
            $recordCounter = RecordNumber::first();
            $newRecordNumber = $recordCounter->counter + 1;

            $recordCounter->counter = $newRecordNumber;
            $recordCounter->save();

            $monthly = new MonthlyWorking;

            $monthly->stage = '1';
            $monthly->status = 'Opened';
            $monthly->parent_id = $request->parent_id;
            $monthly->parent_type = $request->parent_type;
            $monthly->record = $newRecordNumber;

            $monthly->initiator_id = Auth::user()->id;
            $monthly->user_name = Auth::user()->name;
            $monthly->initiator = $request->initiator;
            $monthly->initiation_date = $request->initiation_date;
            $monthly->short_description = $request->short_description;
            $monthly->originator = $request->originator;
            $monthly->assign_to = $request->assign_to;
            $monthly->due_date = $request->due_date;
            $monthly->description = $request->description;
            $monthly->zone = $request->zone;
            $monthly->country = $request->country;
            $monthly->state = $request->state;
            $monthly->city = $request->city;
            $monthly->year = $request->year;
            $monthly->month = $request->month;
            $monthly->number_of_own_emp = $request->number_of_own_emp;
            $monthly->hours_own_emp = $request->hours_own_emp;
            $monthly->number_of_contractors = $request->number_of_contractors;
            $monthly->hours_of_contractors = $request->hours_of_contractors;
            $monthly->save();


            toastr()->success("Monthly is created Successfully");
            return redirect(url('rcms/qms-dashboard'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Failed to save Monthly : ' . $e->getMessage());
        }
    }

    public function monthly_workingEdit($id){
        $monthly = MonthlyWorking::find($id);
        return view('frontend.New_forms.monthly_working.monthly_working_view', compact('monthly'));
    }

    public function monthly_workingUpdate(Request $request, $id){

        try {
            // $recordCounter = RecordNumber::first();
            // $newRecordNumber = $recordCounter->counter + 1;

            // $recordCounter->counter = $newRecordNumber;
            // $recordCounter->save();

            $monthly = MonthlyWorking::find($id);

            // $monthly->stage = '1';
            // $monthly->status = 'Opened';
            $monthly->parent_id = $request->parent_id;
            $monthly->parent_type = $request->parent_type;
            // $monthly->record = $newRecordNumber;

            $monthly->initiator_id = Auth::user()->id;
            $monthly->user_name = Auth::user()->name;
            $monthly->initiator = $request->initiator;
            $monthly->initiation_date = $request->initiation_date;
            $monthly->short_description = $request->short_description;
            $monthly->originator = $request->originator;
            $monthly->assign_to = $request->assign_to;
            $monthly->due_date = $request->due_date;
            $monthly->description = $request->description;
            $monthly->zone = $request->zone;
            $monthly->country = $request->country;
            $monthly->state = $request->state;
            $monthly->city = $request->city;
            $monthly->year = $request->year;
            $monthly->month = $request->month;
            $monthly->number_of_own_emp = $request->number_of_own_emp;
            $monthly->hours_own_emp = $request->hours_own_emp;
            $monthly->number_of_contractors = $request->number_of_contractors;
            $monthly->hours_of_contractors = $request->hours_of_contractors;
            $monthly->update();


            toastr()->success("Monthly is updated Successfully");
            return redirect(url('rcms/qms-dashboard'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Failed to save Monthly : ' . $e->getMessage());
        }
    }
}
