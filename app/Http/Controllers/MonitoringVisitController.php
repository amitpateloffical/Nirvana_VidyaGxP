<?php

namespace App\Http\Controllers;

use App\Models\ActionItem;
use App\Models\Extension;
use App\Models\MonitoringVisit;
use App\Models\MonitoringVisitAuditTrial;
use App\Models\MonitoringVisitGrid;
use App\Models\RecordNumber;
use App\Models\RoleGroup;
use App\Models\User;
use Carbon\Carbon;
use Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PDF;

class MonitoringVisitController extends Controller
{
    public function index()
    {
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');

        return view('frontend.ctms.monitoring.monitoring_visit', compact('due_date', 'record_number'));
    }

    public function store(Request $request)
    {
        if (! $request->short_description) {
            toastr()->info('Short Description is required');

            return redirect()->back()->withInput();
        }
        $data = new MonitoringVisit();
        $data->Form_Type = 'Monitoring Visit';
        $data->record = ((RecordNumber::first()->value('counter')) + 1);
        $data->initiator_id = Auth::user()->id;
        $data->division_id = $request->division_id;
        $data->intiation_date = $request->intiation_date;
        $data->assign_to = $request->assign_to;
        $data->due_date = $request->due_date;
        $data->short_description = $request->short_description;
        $data->type = $request->type;
        // $data->file_attach = $request->file_attach;

        if (! empty($request->file_attach)) {
            $files = [];
            if ($request->hasfile('file_attach')) {
                foreach ($request->file('file_attach') as $file) {
                    $name = $request->name.'file_attach'.rand(1, 100).'.'.$file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $data->file_attach = json_encode($files);
        }

        $data->description = $request->description;
        $data->comments = $request->comments;
        $data->source_documents = $request->source_documents;
        $data->zone = $request->zone;
        $data->country = $request->country == 'Select Country' ? null : $request->country;
        $data->city = $request->city == 'Select City' ? null : $request->city;
        $data->state = $request->state == 'Select State' ? null : $request->state;
        $data->name_on_site = $request->name_on_site;
        $data->building = $request->building;
        $data->floor = $request->floor;
        $data->room = $request->room;
        $data->site = $request->site;
        $data->site_contact = $request->site_contact;
        $data->lead_investigator = $request->lead_investigator;
        $data->manufacturer = $request->manufacturer;
        $data->additional_investigators = $request->additional_investigators;
        $data->comment = $request->comment;
        $data->monitoring_report = $request->monitoring_report;
        $data->follow_up_start_date = $request->follow_up_start_date;
        $data->follow_up_end_date = $request->follow_up_end_date;
        $data->visit_start_date = $request->visit_start_date;
        $data->visit_end_date = $request->visit_end_date;
        $data->report_complete_start_date = $request->report_complete_start_date;
        $data->report_complete_end_date = $request->report_complete_end_date;

        $data->status = 'Opened';
        $data->stage = '1';

        $data->save();
        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();

        if (! empty($data->assign_to)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Assigned To';
            $history->previous = 'Null';
            $history->current = $data->assign_to;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->due_date)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Due Date';
            $history->previous = 'Null';
            $history->current = $data->due_date;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->short_description)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Short Description';
            $history->previous = 'Null';
            $history->current = $data->short_description;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->type)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Type';
            $history->previous = 'Null';
            $history->current = $data->type;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->file_attach)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Initial Attachment';
            $history->previous = 'Null';
            $history->current = $data->file_attach;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->description)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Description';
            $history->previous = 'Null';
            $history->current = $data->description;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->comments)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Comments';
            $history->previous = 'Null';
            $history->current = $data->comments;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->source_documents)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Source Documents';
            $history->previous = 'Null';
            $history->current = $data->source_documents;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->zone)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Zone';
            $history->previous = 'Null';
            $history->current = $data->zone;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->country)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Country';
            $history->previous = 'Null';
            $history->current = $data->country;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->city)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'City';
            $history->previous = 'Null';
            $history->current = $data->city;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->state)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'State';
            $history->previous = 'Null';
            $history->current = $data->state;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->name_on_site)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = '(Parent) Name On Site';
            $history->previous = 'Null';
            $history->current = $data->name_on_site;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->building)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Building';
            $history->previous = 'Null';
            $history->current = $data->building;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->floor)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Floor';
            $history->previous = 'Null';
            $history->current = $data->floor;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->room)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Room';
            $history->previous = 'Null';
            $history->current = $data->room;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->site)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Site';
            $history->previous = 'Null';
            $history->current = $data->site;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->site_contact)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Site Contact';
            $history->previous = 'Null';
            $history->current = $data->site_contact;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->lead_investigator)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Lead Investigator';
            $history->previous = 'Null';
            $history->current = $data->lead_investigator;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->manufacturer)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Manufacturer';
            $history->previous = 'Null';
            $history->current = $data->manufacturer;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->additional_investigators)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Additional Investigators';
            $history->previous = 'Null';
            $history->current = $data->additional_investigators;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->comment)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Comments';
            $history->previous = 'Null';
            $history->current = $data->comment;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->monitoring_report)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Monitoring Report';
            $history->previous = 'Null';
            $history->current = $data->monitoring_report;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->follow_up_start_date)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Date Follow-Up Letter Sent';
            $history->previous = 'Null';
            $history->current = $data->follow_up_start_date;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->follow_up_end_date)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Date Follow-Up Completed';
            $history->previous = 'Null';
            $history->current = $data->follow_up_end_date;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->visit_start_date)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Date Of Visit';
            $history->previous = 'Null';
            $history->current = $data->visit_start_date;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->visit_end_date)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Date Return From Visit';
            $history->previous = 'Null';
            $history->current = $data->visit_end_date;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->report_complete_start_date)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Date Report Completed';
            $history->previous = 'Null';
            $history->current = $data->report_complete_start_date;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }
        if (! empty($data->report_complete_end_date)) {
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $data->id;
            $history->activity_type = 'Site Final Close-Out Date';
            $history->previous = 'Null';
            $history->current = $data->report_complete_end_date;
            $history->comment = 'Not Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Opened';
            $history->change_from = 'Initiation';
            $history->action_name = 'Create   ';
            $history->save();
        }

        //----------grid 1-----------------------------------------
        $MonitoringVisit_id = $data->id;

        $newDataMonitoringVisit = MonitoringVisitGrid::where(['mv_id' => $MonitoringVisit_id, 'identifier' => 'Monitor_Information'])->firstOrCreate();
        $newDataMonitoringVisit->mv_id = $MonitoringVisit_id;
        $newDataMonitoringVisit->identifier = 'Monitor_Information';
        $newDataMonitoringVisit->data = $request->Monitor_Information_details;
        // $history->change_to= "Opened";
        // $history->change_from= "Initiator";
        // $history->action_name="Create";
        $newDataMonitoringVisit->save();
        // dd($newDataMonitoringVisit);

        //----------grid 2-----------------------------------------
        $MonitoringVisit_id = $data->id;

        $newDataMonitoringVisit = MonitoringVisitGrid::where(['mv_id' => $MonitoringVisit_id, 'identifier' => 'Product_Material'])->firstOrCreate();
        $newDataMonitoringVisit->mv_id = $MonitoringVisit_id;
        $newDataMonitoringVisit->identifier = 'Product_Material';
        $newDataMonitoringVisit->data = $request->Product_Material_details;
        // $history->change_to= "Opened";
        // $history->change_from= "Initiator";
        // $history->action_name="Create";
        $newDataMonitoringVisit->save();
        // dd($newDataMonitoringVisit);

        //----------grid 3-----------------------------------------
        $MonitoringVisit_id = $data->id;

        $newDataMonitoringVisit = MonitoringVisitGrid::where(['mv_id' => $MonitoringVisit_id, 'identifier' => 'Equipment'])->firstOrCreate();
        $newDataMonitoringVisit->mv_id = $MonitoringVisit_id;
        $newDataMonitoringVisit->identifier = 'Equipment';
        $newDataMonitoringVisit->data = $request->Equipment_details;
        // $history->change_to= "Opened";
        // $history->change_from= "Initiator";
        // $history->action_name="Create";
        $newDataMonitoringVisit->save();
        // dd($newDataMonitoringVisit);

        //------------------------------------------------------

        toastr()->success('Record is created Successfully');

        return redirect('rcms/qms-dashboard');
    }

    public function show($id)
    {
        $data = MonitoringVisit::find($id);
        $data->record = str_pad($data->record, 4, '0', STR_PAD_LEFT);
        $data->assign_to_name = User::where('id', $data->assign_id)->value('name');
        $data->initiator_name = User::where('id', $data->initiator_id)->value('name');
        $MonitoringVisit_id = $data->id;
        $grid_Data = MonitoringVisitGrid::where(['mv_id' => $MonitoringVisit_id, 'identifier' => 'Monitor_Information'])->first();

        $grid_Data1 = MonitoringVisitGrid::where(['mv_id' => $MonitoringVisit_id, 'identifier' => 'Product_Material'])->first();
        $grid_Data2 = MonitoringVisitGrid::where(['mv_id' => $MonitoringVisit_id, 'identifier' => 'Equipment'])->first();

        return view('frontend.ctms.monitoring.monitoring_visit_view', compact('data', 'MonitoringVisit_id', 'grid_Data', 'grid_Data1', 'grid_Data2'));
    }

    public function update(Request $request, $id)
    {
        $lastDocument = MonitoringVisit::find($id);
        $data = MonitoringVisit::find($id);
        $lastdata = MonitoringVisit::find($id);
        $lastDocumentRecord = MonitoringVisit::find($data->id);
        $lastDocumentStatus = $lastDocumentRecord ? $lastDocumentRecord->status : null;

        $data->initiator_id = Auth::user()->id;
        $data->division_id = $request->division_id;
        // $data->intiation_date = $request->intiation_date;
        $data->assign_to = $request->assign_to;
        $data->due_date = $request->due_date;
        $data->short_description = $request->short_description;
        $data->type = $request->type;
        // $data->file_attach = $request->file_attach;

        if (! empty($request->file_attach)) {
            $files = [];
            if ($request->hasfile('file_attach')) {
                foreach ($request->file('file_attach') as $file) {
                    $name = $request->name.'file_attach'.rand(1, 100).'.'.$file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $data->file_attach = json_encode($files);
        }

        $data->description = $request->description;
        $data->comments = $request->comments;
        $data->source_documents = $request->source_documents;
        $data->zone = $request->zone;
        $data->country = $request->country == 'Select Country' ? null : $request->country;
        $data->city = $request->city == 'Select City' ? null : $request->city;
        $data->state = $request->state == 'Select State' ? null : $request->state;
        $data->name_on_site = $request->name_on_site;
        $data->building = $request->building;
        $data->floor = $request->floor;
        $data->room = $request->room;
        $data->site = $request->site;
        $data->site_contact = $request->site_contact;
        $data->lead_investigator = $request->lead_investigator;
        $data->manufacturer = $request->manufacturer;
        $data->additional_investigators = $request->additional_investigators;
        $data->comment = $request->comment;
        $data->monitoring_report = $request->monitoring_report;
        $data->follow_up_start_date = $request->follow_up_start_date;
        $data->follow_up_end_date = $request->follow_up_end_date;
        $data->visit_start_date = $request->visit_start_date;
        $data->visit_end_date = $request->visit_end_date;
        $data->report_complete_start_date = $request->report_complete_start_date;
        $data->report_complete_end_date = $request->report_complete_end_date;
        $data->update();

        if ($lastDocument->assign_to != $data->assign_to || ! empty($request->assign_to_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Assign To')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Assign To';
            $history->previous = $lastDocument->assign_to;
            $history->current = $data->assign_to;
            $history->comment = $request->assign_to_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->due_date != $data->due_date || ! empty($request->due_date_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Due Date')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Due Date';
            $history->previous = $lastDocument->due_date;
            $history->current = $data->due_date;
            $history->comment = $request->due_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->short_description != $data->short_description || ! empty($request->short_description_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Short Description')
                ->exists();

            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastDocument->short_description;
            $history->current = $data->short_description;
            $history->comment = $request->short_description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->type != $data->type || ! empty($request->type_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Type')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Type';
            $history->previous = $lastDocument->type;
            $history->current = $data->type;
            $history->comment = $request->type_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->file_attach != $data->file_attach || ! empty($request->file_attach_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Initial Attachment')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Initial Attachment';
            $history->previous = $lastDocument->file_attach;
            $history->current = $data->file_attach;
            $history->comment = $request->file_attach_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->description != $data->description || ! empty($request->description_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Description')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Description';
            $history->previous = $lastDocument->description;
            $history->current = $data->description;
            $history->comment = $request->description_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->comments != $data->comments || ! empty($request->comments_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Comments')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Comments';
            $history->previous = $lastDocument->comments;
            $history->current = $data->comments;
            $history->comment = $request->comments_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->source_documents != $data->source_documents || ! empty($request->source_documents_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Source Documents')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Source Documents';
            $history->previous = $lastDocument->source_documents;
            $history->current = $data->source_documents;
            $history->comment = $request->source_documents_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->zone != $data->zone || ! empty($request->zone_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Zone')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Zone';
            $history->previous = $lastDocument->zone;
            $history->current = $data->zone;
            $history->comment = $request->zone_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->country != $data->country || ! empty($request->country_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Country')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Country';
            $history->previous = $lastDocument->country;
            $history->current = $data->country;
            $history->comment = $request->country_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->city != $data->city || ! empty($request->city_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'City')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'City';
            $history->previous = $lastDocument->city;
            $history->current = $data->city;
            $history->comment = $request->city_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->state != $data->state || ! empty($request->state_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'State')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'State';
            $history->previous = $lastDocument->state;
            $history->current = $data->state;
            $history->comment = $request->state_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->name_on_site != $data->name_on_site || ! empty($request->name_on_site_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', '(Parent) Name On Site')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = '(Parent) Name On Site';
            $history->previous = $lastDocument->name_on_site;
            $history->current = $data->name_on_site;
            $history->comment = $request->name_on_site_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->building != $data->building || ! empty($request->building_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Building')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Building';
            $history->previous = $lastDocument->building;
            $history->current = $data->building;
            $history->comment = $request->building_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->floor != $data->floor || ! empty($request->floor_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Floor')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Floor';
            $history->previous = $lastDocument->floor;
            $history->current = $data->floor;
            $history->comment = $request->floor_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->room != $data->room || ! empty($request->room_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Room')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Room';
            $history->previous = $lastDocument->room;
            $history->current = $data->room;
            $history->comment = $request->room_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->site != $data->site || ! empty($request->site_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Site')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Site';
            $history->previous = $lastDocument->site;
            $history->current = $data->site;
            $history->comment = $request->site_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->site_contact != $data->site_contact || ! empty($request->site_contact_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Site Contact')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Site Contact';
            $history->previous = $lastDocument->site_contact;
            $history->current = $data->site_contact;
            $history->comment = $request->site_contact_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->lead_investigator != $data->lead_investigator || ! empty($request->lead_investigator_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Lead Investigator')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Lead Investigator';
            $history->previous = $lastDocument->lead_investigator;
            $history->current = $data->lead_investigator;
            $history->comment = $request->lead_investigator_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->manufacturer != $data->manufacturer || ! empty($request->manufacturer_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Manufacturer')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Manufacturer';
            $history->previous = $lastDocument->manufacturer;
            $history->current = $data->manufacturer;
            $history->comment = $request->manufacturer_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->additional_investigators != $data->additional_investigators || ! empty($request->additional_investigators_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Additional Investigators')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Additional Investigators';
            $history->previous = $lastDocument->additional_investigators;
            $history->current = $data->additional_investigators;
            $history->comment = $request->additional_investigators_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->comment != $data->comment || ! empty($request->comment_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Comments')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Comments';
            $history->previous = $lastDocument->comment;
            $history->current = $data->comment;
            $history->comment = $request->comment_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->monitoring_report != $data->monitoring_report || ! empty($request->monitoring_report_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Monitoring Report')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Monitoring Report';
            $history->previous = $lastDocument->monitoring_report;
            $history->current = $data->monitoring_report;
            $history->comment = $request->monitoring_report_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->follow_up_start_date != $data->follow_up_start_date || ! empty($request->follow_up_start_date_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Date Follow-Up Letter Sent')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Date Follow-Up Letter Sent';
            $history->previous = $lastDocument->follow_up_start_date;
            $history->current = $data->follow_up_start_date;
            $history->comment = $request->follow_up_start_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->follow_up_end_date != $data->follow_up_end_date || ! empty($request->follow_up_end_date_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Date Follow-Up Completed')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Date Follow-Up Completed';
            $history->previous = $lastDocument->follow_up_end_date;
            $history->current = $data->follow_up_end_date;
            $history->comment = $request->follow_up_end_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->visit_start_date != $data->visit_start_date || ! empty($request->visit_start_date_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Date Of Visit')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Date Of Visit';
            $history->previous = $lastDocument->visit_start_date;
            $history->current = $data->visit_start_date;
            $history->comment = $request->visit_start_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->visit_end_date != $data->visit_end_date || ! empty($request->visit_end_date_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Date Return From Visit')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Date Return From Visit';
            $history->previous = $lastDocument->visit_end_date;
            $history->current = $data->visit_end_date;
            $history->comment = $request->visit_end_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->report_complete_start_date != $data->report_complete_start_date || ! empty($request->report_complete_start_date_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Date Report Completed')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Date Report Completed';
            $history->previous = $lastDocument->report_complete_start_date;
            $history->current = $data->report_complete_start_date;
            $history->comment = $request->report_complete_start_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        if ($lastDocument->report_complete_end_date != $data->report_complete_end_date || ! empty($request->report_complete_end_date_comment)) {
            $lastDocumentAuditTrail = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $data->id)
                ->where('activity_type', 'Site Final Close-Out Date')
                ->exists();
            $history = new MonitoringVisitAuditTrial();
            $history->MonitoringVisit_id = $id;
            $history->activity_type = 'Site Final Close-Out Date';
            $history->previous = $lastDocument->report_complete_end_date;
            $history->current = $data->report_complete_end_date;
            $history->comment = $request->report_complete_end_date_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastDocument->status;
            $history->action_name = $lastDocumentAuditTrail ? 'Update' : 'New';

            $history->save();
        }

        //----------grid 1-----------------------------------------

        $MonitoringVisit_id = $data->id;

        $newDataMonitoringVisit = MonitoringVisitGrid::where(['mv_id' => $MonitoringVisit_id, 'identifier' => 'Monitor_Information'])->firstOrCreate();
        $newDataMonitoringVisit->mv_id = $MonitoringVisit_id;
        $newDataMonitoringVisit->identifier = 'Monitor_Information';
        $newDataMonitoringVisit->data = $request->Monitor_Information_details;
        // $history->change_to = 'Not Applicable';
        // $history->change_from = $lastDocument->status;
        // $history->action_name = 'Update';
        $newDataMonitoringVisit->save();
        // dd($newDataMonitoringVisit);

        //----------grid 2-----------------------------------------
        $MonitoringVisit_id = $data->id;

        $newDataMonitoringVisit = MonitoringVisitGrid::where(['mv_id' => $MonitoringVisit_id, 'identifier' => 'Product_Material'])->firstOrCreate();
        $newDataMonitoringVisit->mv_id = $MonitoringVisit_id;
        $newDataMonitoringVisit->identifier = 'Product_Material';
        $newDataMonitoringVisit->data = $request->Product_Material_details;
        // $history->change_to = 'Not Applicable';
        // $history->change_from = $lastDocument->status;
        // $history->action_name = 'Update';
        $newDataMonitoringVisit->save();
        // dd($newDataMonitoringVisit);

        //----------grid 3-----------------------------------------
        $MonitoringVisit_id = $data->id;

        $newDataMonitoringVisit = MonitoringVisitGrid::where(['mv_id' => $MonitoringVisit_id, 'identifier' => 'Equipment'])->firstOrCreate();
        $newDataMonitoringVisit->mv_id = $MonitoringVisit_id;
        $newDataMonitoringVisit->identifier = 'Equipment';
        $newDataMonitoringVisit->data = $request->Equipment_details;
        // $history->change_to = 'Not Applicable';
        // $history->change_from = $lastDocument->status;
        // $history->action_name = 'Update';
        $newDataMonitoringVisit->save();
        // dd($newDataMonitoringVisit);

        toastr()->success('Record is updated Successfully');

        return back();

    }

    public function StageChange(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = MonitoringVisit::find($id);
            $lastDocument = MonitoringVisit::find($id);
            $data = MonitoringVisit::find($id);

            if ($changeControl->stage == 1) {
                $changeControl->stage = '2';
                $changeControl->Schedule_Site_Visit_By = Auth::user()->name;
                $changeControl->Schedule_Site_Visit_On = Carbon::now()->format('d-M-Y');
                $changeControl->Schedule_Site_Visit_Comment = $request->comment;
                $changeControl->status = 'Visit in Progress';
                $history = new MonitoringVisitAuditTrial();
                $history->MonitoringVisit_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action = 'Schedule Site Visit';
                $history->previous = $lastDocument->Submitted_By;
                $history->current = $changeControl->Submitted_By;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = 'Schedule Site Visit';
                $history->change_to = 'Visit in Progress';
                $history->change_from = 'Opened';
                $history->action_name = 'Not Applicable';
                $history->save();
                $list = Helpers::getHodUserList();
                foreach ($list as $u) {

                    if ($u->q_m_s_divisions_id == $changeControl->division_id) {
                        $email = Helpers::getInitiatorEmail($u->user_id);
                        if ($email !== null) {

                            Mail::send(
                                'mail.view-mail',
                                ['data' => $changeControl],
                                function ($message) use ($email) {
                                    $message->to($email)
                                        ->subject('Document is Submitted By '.Auth::user()->name);
                                }
                            );
                        }
                    }
                }

                $changeControl->update();
                toastr()->success('Document Sent');

                return back();
            }
            if ($changeControl->stage == 2) {
                $changeControl->stage = '3';
                $changeControl->Close_Out_Visit_Scheduled_By = Auth::user()->name;
                $changeControl->Close_Out_Visit_Scheduled_On = Carbon::now()->format('d-M-Y');
                $changeControl->Close_Out_Visit_Scheduled_Comment = $request->comment;
                $changeControl->status = 'Close Out Visit In Progress';

                $history = new MonitoringVisitAuditTrial();
                $history->MonitoringVisit_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action = 'Close Out Visit Scheduled';
                $history->previous = $lastDocument->completed_by;
                $history->current = $changeControl->completed_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = 'Close Out Visit In Progress';
                $history->change_to = 'Close Out Visit In Progress';
                $history->change_from = 'Visit in Progress';
                $history->action_name = 'Not Applicable';
                $history->save();
                $list = Helpers::getHodUserList();
                foreach ($list as $u) {
                    if ($u->q_m_s_divisions_id == $changeControl->division_id) {
                        $email = Helpers::getInitiatorEmail($u->user_id);
                        if ($email !== null) {

                            Mail::send(
                                'mail.view-mail',
                                ['data' => $changeControl],
                                function ($message) use ($email) {
                                    $message->to($email)
                                        ->subject('Document is send By '.Auth::user()->name);
                                }
                            );
                        }
                    }
                }
                $changeControl->update();
                toastr()->success('Document Sent');

                return back();
            }
            if ($changeControl->stage == 3) {
                $changeControl->stage = '4';
                $changeControl->status = 'Closed - Done';
                $changeControl->Approve_Close_Out_By = Auth::user()->name;
                $changeControl->Approve_Close_Out_On = Carbon::now()->format('d-M-Y');
                $changeControl->Approve_Close_Out_Comment = $request->comment;

                $history = new MonitoringVisitAuditTrial();
                $history->MonitoringVisit_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action = 'Approve Close Out';
                $history->previous = $lastDocument->completed_by;
                $history->current = $changeControl->completed_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = 'Approve Close Out';
                $history->change_to = 'Closed - Done';
                $history->change_from = 'Close Out Visit In Progress';
                $history->action_name = 'Not Applicable';
                $history->save();
                $list = Helpers::getHodUserList();
                foreach ($list as $u) {
                    if ($u->q_m_s_divisions_id == $changeControl->division_id) {
                        $email = Helpers::getInitiatorEmail($u->user_id);
                        if ($email !== null) {

                            Mail::send(
                                'mail.view-mail',
                                ['data' => $changeControl],
                                function ($message) use ($email) {
                                    $message->to($email)
                                        ->subject('Document is send By '.Auth::user()->name);
                                }
                            );
                        }
                    }
                }
                $changeControl->update();
                toastr()->success('Document Sent');

                return back();
            }
        } else {
            toastr()->error('E-signature Not match');

            return back();
        }
    }

    public function ViolationChild()
    {
        return view('frontend.ctms.violation');
    }

    public function MonitoringVisitCancel(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $changeControl = MonitoringVisit::find($id);

            if ($changeControl->stage == 1) {
                $changeControl->stage = '0';
                $changeControl->status = 'Closed - Cancelled';
                $changeControl->cancelled_by = Auth::user()->name;
                $changeControl->cancelled_on = Carbon::now()->format('d-M-Y');
                $changeControl->Cancelled_Comment = $request->comment;

                $changeControl->update();
                toastr()->success('Document Sent');

                return back();
            }
        } else {
            toastr()->error('E-signature Not match');

            return back();
        }
    }

    public function MonitoringVisitAuditTrial($id)
    {
        $audit = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $id)->orderByDESC('id')->paginate(5);
        $today = Carbon::now()->format('d-m-y');
        $document = MonitoringVisit::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');

        return view('frontend.ctms.monitoring.monitoringVisitAuditTrial', compact('audit', 'document', 'today'));
    }

    public function SingleReport($id)
    {
        $data = MonitoringVisit::find($id);
        if (! empty($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();

            $MonitoringVisit_id = $data->id;
            $grid_Data = MonitoringVisitGrid::where(['mv_id' => $MonitoringVisit_id, 'identifier' => 'Monitor_Information'])->firstOrCreate();
            $grid_Data1 = MonitoringVisitGrid::where(['mv_id' => $MonitoringVisit_id, 'identifier' => 'Product_Material'])->firstOrCreate();
            $grid_Data2 = MonitoringVisitGrid::where(['mv_id' => $MonitoringVisit_id, 'identifier' => 'Equipment'])->firstOrCreate();
            $pdf = PDF::loadview('frontend.ctms.monitoring.monitoring_visit_single_report', compact('data', 'grid_Data', 'grid_Data1', 'grid_Data2'))
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

            return $pdf->stream('Monitoring-Visit-SingleReport'.$id.'.pdf');
        }
    }

    public function AuditReport($id)
    {

        $doc = MonitoringVisit::find($id);
        $audit = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $id)->orderByDesc('id')->get();
        $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        $data = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $doc->id)->orderByDesc('id')->get();
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.ctms.monitoring.Monitoring_Visit_AuditTrial_Report', compact('data', 'doc', 'audit'))
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

        return $pdf->stream('Monitoring-Visit-AuditTrial'.$id.'.pdf');

        // $doc = MonitoringVisit::find($id);
        // if (! empty($doc)) {
        //     $audit = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $id)->orderByDESC('id')->paginate(5);

        //     $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        //     $data = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $id)->get();
        //     $pdf = App::make('dompdf.wrapper');
        //     $time = Carbon::now();
        //     $pdf = PDF::loadview('frontend.ctms.monitoring.Monitoring_Visit_AuditTrial_Report', compact('data', 'doc', 'audit'))
        //         ->setOptions([
        //             'defaultFont' => 'sans-serif',
        //             'isHtml5ParserEnabled' => true,
        //             'isRemoteEnabled' => true,
        //             'isPhpEnabled' => true,
        //         ]);
        //     $pdf->setPaper('A4');
        //     $pdf->render();
        //     $canvas = $pdf->getDomPDF()->getCanvas();
        //     $height = $canvas->get_height();
        //     $width = $canvas->get_width();
        //     $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');
        //     $canvas->page_text($width / 4, $height / 2, $doc->status, null, 25, [0, 0, 0], 2, 6, -20);

        //     return $pdf->stream('Monitoring-Visit-AuditTrial'.$id.'.pdf');
        // }$doc = Validation::findOrFail($id);

        // if (! empty($doc)) {
        //     $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        // } else {
        //     $datas = ActionItem::find($id);

        //     if (empty($datas)) {
        //         $datas = Extension::find($id);
        //         $doc = MonitoringVisit::find($datas->MonitoringVisit_id);
        //         $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        //         $doc->created_at = $datas->created_at;
        //     } else {
        //         $doc = MonitoringVisit::find($datas->MonitoringVisit_id);
        //         $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        //         $doc->created_at = $datas->created_at;
        //     }
        // }
        // $data = MonitoringVisitAuditTrial::where('MonitoringVisit_id', $doc->id)->orderByDesc('id')->get();

        // $pdf = App::make('dompdf.wrapper');
        // $time = Carbon::now();
        // $pdf = PDF::loadview('frontend.ctms.monitoring.Monitoring_Visit_AuditTrial_Report', compact('data', 'audit', 'doc'))
        //     ->setOptions([
        //         'defaultFont' => 'sans-serif',
        //         'isHtml5ParserEnabled' => true,
        //         'isRemoteEnabled' => true,
        //         'isPhpEnabled' => true,
        //     ]);
        // $pdf->setPaper('A4');
        // $pdf->render();
        // $canvas = $pdf->getDomPDF()->getCanvas();
        // $height = $canvas->get_height();
        // $width = $canvas->get_width();

        // $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');

        // $canvas->page_text(
        //     $width / 3,
        //     $height / 2,
        //     $doc->status,
        //     null,
        //     60,
        //     [0, 0, 0],
        //     2,
        //     6,
        //     -20
        // );

        // return $pdf->stream('Monitoring_Visit_AuditTrial_Report'.$id.'.pdf');
    }
}
