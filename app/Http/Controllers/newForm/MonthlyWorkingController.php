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
        // $old_record = MonthlyWorking::select('id', 'division_id', 'record')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view('frontend.New_forms.monthly_working.monthly_working', compact( 'record_number', 'currentDate', 'formattedDate', 'due_date'));
    }

    public function monthly_workingStore(Request $request){
        dd($request->all());
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
            toastr()->success("Monthly is created Successfully");
            return redirect(url('rcms/qms-dashboard'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Failed to save Monthly : ' . $e->getMessage());
        }
    }
}
