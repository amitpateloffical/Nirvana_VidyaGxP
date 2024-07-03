<?php

namespace App\Http\Controllers\newForm;

use App\Http\Controllers\Controller;
use App\Models\ActionItem;
use App\Models\Extension;
use App\Models\MonthlyWorking;
use App\Models\MonthlyWorkingAudit;
use App\Models\RecordNumber;
use App\Models\RoleGroup;
use App\Models\User;
// use Barryvdh\DomPDF\PDF;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MonthlyWorkingController extends Controller
{
    public function index()
    {
        $old_record = MonthlyWorking::select('id', 'division_id', 'record')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view('frontend.New_forms.monthly_working.monthly_working', compact('record_number', 'currentDate', 'formattedDate', 'due_date'));
    }

    public function monthly_workingStore(Request $request)
    {
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

            //===========audit trails ===========//
            if (!empty($request->short_description)) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->previous = "Null";
                $validation2->current = $request->short_description;
                $validation2->activity_type = 'Short Description';
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "'Initiation";
                $validation2->action_name = 'Create';
                $validation2->comment = "Not Applicable";
                $validation2->save();
            }

            if (!empty($request->initiation_date)) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'Date of Initiation';
                $validation2->previous = "Null";
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
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'Assign To';
                $validation2->previous = "Null";
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
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'Due Date';
                $validation2->previous = "Null";
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

            if (!empty($request->description)) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'Description';
                $validation2->previous = "Null";
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

            if (!empty($request->zone)) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'Zone';
                $validation2->previous = "Null";
                $validation2->current = $request->zone;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "'Initiation";
                $validation2->action_name = 'Create';

                $validation2->save();
            }

            if (!empty($request->country)) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'Country';
                $validation2->previous = "Null";
                $validation2->current = $request->country;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "'Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->state)) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'State';
                $validation2->previous = "Null";
                $validation2->current = $request->state;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "'Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->city)) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'City';
                $validation2->previous = "Null";
                $validation2->current = $request->city;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "'Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }


            if (!empty($request->year)) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'Year';
                $validation2->previous = "Null";
                $validation2->current = $request->year;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "'Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->month)) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'Month';
                $validation2->previous = "Null";
                $validation2->current = $request->month;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "'Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->number_of_own_emp)) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'Number Of Own Employess';
                $validation2->previous = "Null";
                $validation2->current = $request->number_of_own_emp;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "'Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }
            if (!empty($request->hours_own_emp)) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'Hours Own Employess';
                $validation2->previous = "Null";
                $validation2->current = $request->hours_own_emp;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "'Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->number_of_contractors)) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'Number Of Contractors';
                $validation2->previous = "Null";
                $validation2->current = $request->number_of_contractors;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "'Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->hours_of_contractors)) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'Hours Of Contractors';
                $validation2->previous = "Null";
                $validation2->current = $request->hours_of_contractors;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "'Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }


            toastr()->success("Monthly is created Successfully");
            return redirect(url('rcms/qms-dashboard'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Failed to save Monthly : ' . $e->getMessage());
        }
    }

    public function monthly_workingEdit($id)
    {
        $monthly = MonthlyWorking::find($id);
        return view('frontend.New_forms.monthly_working.monthly_working_view', compact('monthly'));
    }

    public function monthly_workingUpdate(Request $request, $id)
    {

        try {

            $lastDocument = MonthlyWorking::find($id);
            $monthly = MonthlyWorking::find($id);

            $monthly->parent_id = $request->parent_id;
            $monthly->parent_type = $request->parent_type;

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


            //===========audit trails ===========//
            if ($lastDocument->short_description != $request->short_description) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->previous = $lastDocument->short_description;
                $validation2->current = $request->short_description;
                $validation2->activity_type = 'Short Description';
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                $validation2->action_name = 'Update';

                $validation2->save();
            }

            if ($lastDocument->initiation_date != $request->initiation_date) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'Date of Initiation';
                $validation2->previous = $lastDocument->initiation_date;
                $validation2->current = $request->initiation_date;
                $validation2->comment = "Not Applicable";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                $validation2->action_name = 'Update';
                $validation2->save();
            }
            if ($lastDocument->assign_to != $request->assign_to) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'Assign To';
                $validation2->previous = $lastDocument->assign_to;
                $validation2->current = $request->assign_to;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = "$lastDocument->status";
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if ($lastDocument->due_date != $request->due_date) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'Due Date';
                $validation2->previous = $lastDocument->due_date;
                $validation2->current = $request->due_date;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = "$lastDocument->status";
                $validation2->action_name = 'Update';

                $validation2->save();
            }
            if ($lastDocument->description != $request->description) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'Description';
                $validation2->previous = $lastDocument->description;
                $validation2->current = $request->description;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = "$lastDocument->status";
                $validation2->action_name = 'Update';

                $validation2->save();
            }

            if ($lastDocument->zone != $request->zone) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'Zone';
                $validation2->previous = $lastDocument->zone;
                $validation2->current = $request->zone;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = "$lastDocument->status";
                $validation2->action_name = 'Update';

                $validation2->save();
            }

            if ($lastDocument->country != $request->country) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'Country';
                $validation2->previous = $lastDocument->country;
                $validation2->current = $request->country;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = "$lastDocument->status";
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if ($lastDocument->state != $request->state) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'State';
                $validation2->previous = $lastDocument->state;
                $validation2->current = $request->state;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = "$lastDocument->status";
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if ($lastDocument->city != $request->city) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'City';
                $validation2->previous = $lastDocument->city;
                $validation2->current = $request->city;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = "$lastDocument->status";
                $validation2->action_name = 'Update';
                $validation2->save();
            }


            if ($lastDocument->year != $request->year) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'Year';
                $validation2->previous = $lastDocument->year;
                $validation2->current = $request->year;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = "$lastDocument->status";
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if ($lastDocument->month != $request->month) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'Month';
                $validation2->previous = $lastDocument->month;
                $validation2->current = $request->month;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = "$lastDocument->status";
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if ($lastDocument->number_of_own_emp != $request->number_of_own_emp) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'Number Of Own Employess';
                $validation2->previous = $lastDocument->number_of_own_emp;
                $validation2->current = $request->number_of_own_emp;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = "$lastDocument->status";
                $validation2->action_name = 'Update';
                $validation2->save();
            }
            if ($lastDocument->hours_own_emp != $request->hours_own_emp) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'Hours Own Employess';
                $validation2->previous = $lastDocument->hours_own_emp;
                $validation2->current = $request->hours_own_emp;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = "$lastDocument->status";
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if ($lastDocument->number_of_contractors != $request->number_of_contractors) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'Number Of Contractors';
                $validation2->previous = $lastDocument->number_of_contractors;
                $validation2->current = $request->number_of_contractors;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = "$lastDocument->status";
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if ($lastDocument->hours_of_contractors != $request->hours_of_contractors) {
                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $monthly->id;
                $validation2->activity_type = 'Hours Of Contractors';
                $validation2->previous = $lastDocument->hours_of_contractors;
                $validation2->current = $request->hours_of_contractors;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = "$lastDocument->status";
                $validation2->action_name = 'Update';
                $validation2->save();
            }




            toastr()->success("Monthly is updated Successfully");
            return redirect(url('rcms/qms-dashboard'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Failed to save Monthly : ' . $e->getMessage());
        }
    }

    public function audit_monthly_working($id)
    {
        $audit = MonthlyWorkingAudit::where('monthlyworking_id', $id)->orderByDESC('id')->paginate();
        $today = Carbon::now()->format('d-m-y');
        $document = MonthlyWorking::where('id', $id)->first();
        $document->originator = User::where('id', $document->initiator_id)->value('name');

        return view('frontend.New_forms.monthly_working.monthly_working_audit', compact('document', 'audit', 'today'));
    }

    public function monthly_workingAuditTrialDetails($id)
    {
        $detail = MonthlyWorkingAudit::find($id);
        $detail_data = MonthlyWorkingAudit::where('activity_type', $detail->activity_type)->where('monthlyworking_id', $detail->monthlyworking_id)->latest()->get();
        $doc = MonthlyWorking::where('id', $detail->monthly_id)->first();
        return view('frontend.New_forms.monthly_working.monthly_working_audit_details', compact('detail', 'doc', 'detail_data'));
    }

    public function monthlynCancel(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $equipment = MonthlyWorking::find($id);
            $lastDocument = MonthlyWorking::find($id);

            if (!$equipment) {
                toastr()->error('Monthly Working not found');
                return back();
            }

            if ($equipment->stage == 1) {
                $equipment->stage = "2";
                $equipment->status = "Closed";
                $equipment->closed_by = Auth::user()->name;
                $equipment->closed_on = Carbon::now()->format('d-M-Y');
                $equipment->close_comment = $request->comment;

                $validation2 = new MonthlyWorkingAudit();
                $validation2->monthlyworking_id = $id;
                $validation2->activity_type = 'Activity Log';
                $validation2->current = $equipment->submit_by;
                $validation2->comment = $request->comment;
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation2->change_from = $lastDocument->status;
                $validation2->action = 'close';
                $validation2->change_to = "Closed";
                $validation2->stage = 'Close';
                $validation2->save();

                $equipment->update();
                toastr()->success('Document Sent');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function audit2_pdf($id)
    {
        $doc = MonthlyWorking::find($id);
        if (!empty($doc)) {
            $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        } else {
            $datas = ActionItem::find($id);

            if (empty($datas)) {
                $datas = Extension::find($id);
                $doc = MonthlyWorking::find($datas->monthlyworking_id);
                $doc->originator = User::where('id', $doc->initiator_id)->value('name');
                $doc->created_at = $datas->created_at;
            } else {
                $doc = MonthlyWorking::find($datas->monthlyworking_id);
                $doc->originator = User::where('id', $doc->initiator_id)->value('name');
                $doc->created_at = $datas->created_at;
            }
        }
        $data = MonthlyWorkingAudit::where('monthlyworking_id', $doc->id)->orderByDesc('id')->get();
        // pdf related work
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.New_forms.monthly_working.monthly_working_audit_pdf', compact('data', 'doc'))
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

        return $pdf->stream('Monthly Working' . $id . '.pdf');
    }

    public function singleReport($id)
    {
        $data = MonthlyWorking::find($id);
        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');

            $doc = MonthlyWorkingAudit::where('monthlyworking_id', $data->id)->first();
            $detail_data = MonthlyWorkingAudit::where('activity_type', $data->activity_type)
                ->where('monthlyworking_id', $data->monthlyworking_id)
                ->latest()
                ->get();

            // pdf related work
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.New_forms.monthly_working.singleMonthlyWorkingReport', compact(
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
            return $pdf->stream('Monthly Working' . $id . '.pdf');
        }

        return redirect()->back()->with('error', 'Monthly Working not found.');
    }
}
