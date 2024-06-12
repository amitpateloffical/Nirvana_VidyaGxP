<?php

namespace App\Http\Controllers;

use App\Models\Serious;
use App\Models\SeriousGrid;
use App\Models\RecordNumber;
use App\Models\SeriousAuditTrail;
use App\Models\RoleGroup;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use PDF;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SeriousController extends Controller
{
    public function index()
    {
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        return view('frontend.ctms.serious_adverse_event', compact('record_number'));
    }

    public function SeriousStore(Request $request,)
    {
        $adverse = new Serious();
        $adverse->record = ((RecordNumber::first()->value('counter')) + 1);
        $adverse->initiator_id = Auth::user()->id;
        $adverse->date_of_initiation = $request->date_of_initiation;
        $adverse->short_description = $request->short_description;
        $adverse->assign_to = $request->assign_to;
        $adverse->due_date = $request->due_date;
        $adverse->type = $request->type;

        $files = [];
        if ($request->hasFile('file_attach')) {
            foreach ($request->file('file_attach') as $file) {
                $name = $request->name . 'file_attach' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload/'), $name);
                $files[] = $name;
            }
        }
        $adverse->file_attach = json_encode($files);


        // $adverse->file_attach = $request->file_attach;------->Image
        $adverse->description = $request->description;
        $adverse->comments = $request->comments;
        $adverse->zone = $request->zone;
        $adverse->country = $request->country;
        $adverse->state = $request->state;
        $adverse->city = $request->city;
        $adverse->site_name = $request->site_name;
        $adverse->building = $request->building;
        $adverse->floor = $request->floor;
        $adverse->room = $request->room;
        $adverse->number = $request->number;
        $adverse->project_code = $request->project_code;
        $adverse->primary_sae = $request->primary_sae;
        $adverse->Sae_number = $request->Sae_number;
        $adverse->severity_rate = $request->severity_rate;
        $adverse->occurance = $request->occurance;
        $adverse->detection = $request->detection;
        $adverse->RPN = $request->RPN;
        $adverse->protocol_type = $request->protocol_type;
        $adverse->reportability = $request->reportability;
        $adverse->crom = $request->crom;
        $adverse->lead_investigator = $request->lead_investigator;
        $adverse->follow_up_information = $request->follow_up_information;
        $adverse->route_of_administration = $request->route_of_administration;
        $adverse->carbon_copy_list = $request->carbon_copy_list;
        $adverse->comments2 = $request->comments2;
        $adverse->primary_sae2 = $request->primary_sae2;
        $adverse->manufacturer = $request->manufacturer;
        $adverse->awareness_date = $request->awareness_date;
        $adverse->crom_saftey_report_app_on = $request->crom_saftey_report_app_on;
        $adverse->date_crom_concurred = $request->date_crom_concurred;
        $adverse->date_draft_sr_sent = $request->date_draft_sr_sent;
        $adverse->date_mm_concurred = $request->date_mm_concurred;
        $adverse->date_of_event_resolution = $request->date_of_event_resolution;
        $adverse->date_pi_concurred = $request->date_pi_concurred;
        $adverse->date_recieved = $request->date_recieved;
        $adverse->date_safety_assessment_sent = $request->date_safety_assessment_sent;
        $adverse->date_sent_to_ra = $request->date_sent_to_ra;
        $adverse->date_sent_to_sites = $request->date_sent_to_sites;
        $adverse->sae_onset_date = $request->sae_onset_date;
        $adverse->mm_saftey_report_approved_on = $request->mm_saftey_report_approved_on;
        $adverse->pi_saftey_report_approved_on = $request->pi_saftey_report_approved_on;


        $adverse->status = 'Opened';
        $adverse->stage = 1;
        $adverse->save();

        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();
        // dd($record);

        if (!empty($adverse->short_description)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Null";
            $history->current = $adverse->short_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->assign_to)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Assigned To';
            $history->previous = "Null";
            $history->current = $adverse->assign_to;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->due_date)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Due Date';
            $history->previous = "Null";
            $history->current = $adverse->due_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->type)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Type';
            $history->previous = "Null";
            $history->current = $adverse->type;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->file_attach)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'File Attachments';
            $history->previous = "Null";
            $history->current = $adverse->file_attach;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->description)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Description';
            $history->previous = "Null";
            $history->current = $adverse->description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->comments)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Comments';
            $history->previous = "Null";
            $history->current = $adverse->comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->zone)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Zone';
            $history->previous = "Null";
            $history->current = $adverse->zone;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->country)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Country';
            $history->previous = "Null";
            $history->current = $adverse->country;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->state)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'State';
            $history->previous = "Null";
            $history->current = $adverse->state;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->city)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'City';
            $history->previous = "Null";
            $history->current = $adverse->city;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->site_name)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Site Name';
            $history->previous = "Null";
            $history->current = $adverse->site_name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->building)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Building';
            $history->previous = "Null";
            $history->current = $adverse->building;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->floor)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Floor';
            $history->previous = "Null";
            $history->current = $adverse->floor;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->room)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Room';
            $history->previous = "Null";
            $history->current = $adverse->room;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->number)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Number(ID)';
            $history->previous = "Null";
            $history->current = $adverse->number;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->project_code)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Project Code';
            $history->previous = "Null";
            $history->current = $adverse->project_code;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->primary_sae)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Primary SAE';
            $history->previous = "Null";
            $history->current = $adverse->primary_sae;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->Sae_number)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'SAE Number';
            $history->previous = "Null";
            $history->current = $adverse->Sae_number;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->severity_rate)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Severity Rate';
            $history->previous = "Null";
            $history->current = $adverse->severity_rate;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->occurance)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Occurance';
            $history->previous = "Null";
            $history->current = $adverse->occurance;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->detection)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Detection';
            $history->previous = "Null";
            $history->current = $adverse->detection;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->RPN)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'RPN';
            $history->previous = "Null";
            $history->current = $adverse->RPN;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->protocol_type)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Protocol Type';
            $history->previous = "Null";
            $history->current = $adverse->protocol_type;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->reportability)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Reportability';
            $history->previous = "Null";
            $history->current = $adverse->reportability;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->crom)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'CROM';
            $history->previous = "Null";
            $history->current = $adverse->crom;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->lead_investigator)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Lead Investigator';
            $history->previous = "Null";
            $history->current = $adverse->lead_investigator;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->follow_up_information)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Follow-up Information';
            $history->previous = "Null";
            $history->current = $adverse->follow_up_information;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->route_of_administration)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Route Of Administration';
            $history->previous = "Null";
            $history->current = $adverse->route_of_administration;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->carbon_copy_list)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Carbon Copy List';
            $history->previous = "Null";
            $history->current = $adverse->carbon_copy_list;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->comments2)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Comments';
            $history->previous = "Null";
            $history->current = $adverse->comments2;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->primary_sae2)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Primary SAE';
            $history->previous = "Null";
            $history->current = $adverse->primary_sae2;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->manufacturer)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Manufacturer';
            $history->previous = "Null";
            $history->current = $adverse->manufacturer;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->awareness_date)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Awareness Date';
            $history->previous = "Null";
            $history->current = $adverse->awareness_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->crom_saftey_report_app_on)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'CROM Safety Report App On';
            $history->previous = "Null";
            $history->current = $adverse->crom_saftey_report_app_on;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->date_crom_concurred)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Date CROM Concurred';
            $history->previous = "Null";
            $history->current = $adverse->date_crom_concurred;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->date_draft_sr_sent)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Date Draft SR Sent';
            $history->previous = "Null";
            $history->current = $adverse->date_draft_sr_sent;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->date_mm_concurred)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Date MM Concurred';
            $history->previous = "Null";
            $history->current = $adverse->date_mm_concurred;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->date_of_event_resolution)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Date Of Event Resolution';
            $history->previous = "Null";
            $history->current = $adverse->date_of_event_resolution;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->date_pi_concurred)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Date PI Concurred';
            $history->previous = "Null";
            $history->current = $adverse->date_pi_concurred;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->date_recieved)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Date Recieved';
            $history->previous = "Null";
            $history->current = $adverse->date_recieved;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->date_safety_assessment_sent)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Date Safety Assessment Sent';
            $history->previous = "Null";
            $history->current = $adverse->date_safety_assessment_sent;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->date_sent_to_ra)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Date Sent To RA';
            $history->previous = "Null";
            $history->current = $adverse->date_sent_to_ra;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->date_sent_to_sites)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'Date Sent To Sites';
            $history->previous = "Null";
            $history->current = $adverse->date_sent_to_sites;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->sae_onset_date)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'SAE Onset Date';
            $history->previous = "Null";
            $history->current = $adverse->sae_onset_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->mm_saftey_report_approved_on)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'MM Safety Report Approved On';
            $history->previous = "Null";
            $history->current = $adverse->mm_saftey_report_approved_on;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($adverse->pi_saftey_report_approved_on)) {
            $history = new SeriousAuditTrail();
            $history->serious_id = $adverse->id;
            $history->activity_type = 'PI Safety Report Approved On';
            $history->previous = "Null";
            $history->current = $adverse->pi_saftey_report_approved_on;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $adverse->status;
            $history->change_from = "Initiator";
            $history->change_to =   "Opened";
            $history->action_name = 'Create';
            $history->save();
        }


        //==================GRID=======================
        $serious_id = $adverse->id;
        $newDataGridSerious = SeriousGrid::where(['s_id' => $serious_id, 'identifier' => 'product'])->firstOrCreate();
        $newDataGridSerious->s_id = $serious_id;
        $newDataGridSerious->identifier = 'product';
        $newDataGridSerious->data = $request->product;
        $newDataGridSerious->save();
        //================================================================


        toastr()->success("Record is created Successfully");
        return redirect(url('rcms/qms-dashboard'));
    }

    public function SeriousShow($id)
    {
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $adverse = Serious::find($id);
        $serious_id = $id;
        $grid_Data = SeriousGrid::where(['s_id' => $serious_id, 'identifier' => 'product'])->first();
        // dd($adverse);
        return view('frontend.serious-adverse-event.view', compact('adverse', 'record_number', 'adverse', 'serious_id','grid_Data'));
    }

    public function SeriousUpdate(Request $request, $id)
    {
        $adverse = Serious::find($id);
        $lastData = Serious::find($id);
        $adverse->record = ((RecordNumber::first()->value('counter')) + 1);
        $adverse->initiator_id = Auth::user()->id;
        $adverse->date_of_initiation = $request->date_of_initiation;
        $adverse->short_description = $request->short_description;
        $adverse->assign_to = $request->assign_to;
        $adverse->due_date = $request->due_date;
        $adverse->type = $request->type;

        $files = [];
        if ($request->hasFile('file_attach')) {
            foreach ($request->file('file_attach') as $file) {
                $name = $request->name . 'file_attach' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload/'), $name);
                $files[] = $name;
            }
        }
        $adverse->file_attach = json_encode($files);


        // $adverse->file_attach = $request->file_attach;------->Image
        $adverse->description = $request->description;
        $adverse->comments = $request->comments;
        $adverse->zone = $request->zone;
        $adverse->country = $request->country;
        $adverse->state = $request->state;
        $adverse->city = $request->city;
        $adverse->site_name = $request->site_name;
        $adverse->building = $request->building;
        $adverse->floor = $request->floor;
        $adverse->room = $request->room;
        $adverse->number = $request->number;
        $adverse->project_code = $request->project_code;
        $adverse->primary_sae = $request->primary_sae;
        $adverse->Sae_number = $request->Sae_number;
        $adverse->severity_rate = $request->severity_rate;
        $adverse->occurance = $request->occurance;
        $adverse->detection = $request->detection;
        $adverse->RPN = $request->RPN;
        $adverse->protocol_type = $request->protocol_type;
        $adverse->reportability = $request->reportability;
        $adverse->crom = $request->crom;
        $adverse->lead_investigator = $request->lead_investigator;
        $adverse->follow_up_information = $request->follow_up_information;
        $adverse->route_of_administration = $request->route_of_administration;
        $adverse->carbon_copy_list = $request->carbon_copy_list;
        $adverse->comments2 = $request->comments2;
        $adverse->primary_sae2 = $request->primary_sae2;
        $adverse->manufacturer = $request->manufacturer;
        $adverse->awareness_date = $request->awareness_date;
        $adverse->crom_saftey_report_app_on = $request->crom_saftey_report_app_on;
        $adverse->date_crom_concurred = $request->date_crom_concurred;
        $adverse->date_draft_sr_sent = $request->date_draft_sr_sent;
        $adverse->date_mm_concurred = $request->date_mm_concurred;
        $adverse->date_of_event_resolution = $request->date_of_event_resolution;
        $adverse->date_pi_concurred = $request->date_pi_concurred;
        $adverse->date_recieved = $request->date_recieved;
        $adverse->date_safety_assessment_sent = $request->date_safety_assessment_sent;
        $adverse->date_sent_to_ra = $request->date_sent_to_ra;
        $adverse->date_sent_to_sites = $request->date_sent_to_sites;
        $adverse->sae_onset_date = $request->sae_onset_date;
        $adverse->mm_saftey_report_approved_on = $request->mm_saftey_report_approved_on;
        $adverse->pi_saftey_report_approved_on = $request->pi_saftey_report_approved_on;


        $adverse->update();

        if ($lastData->short_description != $adverse->short_description || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastData->short_description;
            $history->current = $adverse->short_description;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->assign_to != $adverse->assign_to || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Assign To';
            $history->previous = $lastData->assign_to;
            $history->current = $adverse->assign_to;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->due_date != $adverse->due_date || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Due Date';
            $history->previous = $lastData->due_date;
            $history->current = $adverse->due_date;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->type != $adverse->type || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Type';
            $history->previous = $lastData->type;
            $history->current = $adverse->type;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->file_attach != $adverse->file_attach || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'File Attachments';
            $history->previous = $lastData->file_attach;
            $history->current = $adverse->file_attach;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->description != $adverse->description || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Description';
            $history->previous = $lastData->description;
            $history->current = $adverse->description;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->comments != $adverse->comments || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Comments';
            $history->previous = $lastData->comments;
            $history->current = $adverse->comments;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->zone != $adverse->zone || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Zone';
            $history->previous = $lastData->zone;
            $history->current = $adverse->zone;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->country != $adverse->country || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Country';
            $history->previous = $lastData->country;
            $history->current = $adverse->country;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->state != $adverse->state || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'State';
            $history->previous = $lastData->state;
            $history->current = $adverse->state;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->city != $adverse->city || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'City';
            $history->previous = $lastData->city;
            $history->current = $adverse->city;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        // if ($lastData->site_name != $adverse->site_name || !empty ($request->comment)) {
        //     // return 'history';
        //     $history = new SeriousAuditTrail;
        //     $history->serious_id = $id;
        //     $history->activity_type = 'Site Name';
        //     $history->previous = $lastData->site_name;
        //     $history->current = $adverse->site_name;
        //     $history->comment = $request->comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastData->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastData->status;
        //     $history->action_name = 'Update';
        //     $history->save();
        // }


        if ($lastData->site_name != $adverse->site_name || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Site Name';
            $history->previous = $lastData->site_name;
            $history->current = $adverse->site_name;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->building != $adverse->building || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Building';
            $history->previous = $lastData->building;
            $history->current = $adverse->building;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->floor != $adverse->floor || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Floor';
            $history->previous = $lastData->floor;
            $history->current = $adverse->floor;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->room != $adverse->room || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Room';
            $history->previous = $lastData->room;
            $history->current = $adverse->room;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->number != $adverse->number || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Number';
            $history->previous = $lastData->number;
            $history->current = $adverse->number;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->project_code != $adverse->project_code || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Project Code';
            $history->previous = $lastData->project_code;
            $history->current = $adverse->project_code;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->primary_sae != $adverse->primary_sae || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Primary SAE';
            $history->previous = $lastData->primary_sae;
            $history->current = $adverse->primary_sae;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->Sae_number != $adverse->Sae_number || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'SAE Number';
            $history->previous = $lastData->Sae_number;
            $history->current = $adverse->Sae_number;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->severity_rate != $adverse->severity_rate || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Severity Rate';
            $history->previous = $lastData->severity_rate;
            $history->current = $adverse->severity_rate;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->occurance != $adverse->occurance || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Occurance';
            $history->previous = $lastData->occurance;
            $history->current = $adverse->occurance;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->detection != $adverse->detection || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Detection';
            $history->previous = $lastData->detection;
            $history->current = $adverse->detection;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->RPN != $adverse->RPN || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'RPN';
            $history->previous = $lastData->RPN;
            $history->current = $adverse->RPN;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->protocol_type != $adverse->protocol_type || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Protocol Type';
            $history->previous = $lastData->protocol_type;
            $history->current = $adverse->protocol_type;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->reportability != $adverse->reportability || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Reportablity';
            $history->previous = $lastData->reportability;
            $history->current = $adverse->reportability;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->crom != $adverse->crom || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'CROM';
            $history->previous = $lastData->crom;
            $history->current = $adverse->crom;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->lead_investigator != $adverse->lead_investigator || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Lead Investigator';
            $history->previous = $lastData->lead_investigator;
            $history->current = $adverse->lead_investigator;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->follow_up_information != $adverse->follow_up_information || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Follow-up Information';
            $history->previous = $lastData->follow_up_information;
            $history->current = $adverse->follow_up_information;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->route_of_administration != $adverse->route_of_administration || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Route Of Administration';
            $history->previous = $lastData->route_of_administration;
            $history->current = $adverse->route_of_administration;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->carbon_copy_list != $adverse->carbon_copy_list || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = ' Carbon Copy List';
            $history->previous = $lastData->carbon_copy_list;
            $history->current = $adverse->carbon_copy_list;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->comments2 != $adverse->comments2 || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Comments';
            $history->previous = $lastData->comments2;
            $history->current = $adverse->comments2;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->primary_sae2 != $adverse->primary_sae2 || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Primary SAE';
            $history->previous = $lastData->primary_sae2;
            $history->current = $adverse->primary_sae2;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->manufacturer != $adverse->manufacturer || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Manufacturer';
            $history->previous = $lastData->manufacturer;
            $history->current = $adverse->manufacturer;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->awareness_date != $adverse->awareness_date || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Awareness Date';
            $history->previous = $lastData->awareness_date;
            $history->current = $adverse->awareness_date;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->crom_saftey_report_app_on != $adverse->crom_saftey_report_app_on || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'CROM Safety Report App On';
            $history->previous = $lastData->crom_saftey_report_app_on;
            $history->current = $adverse->crom_saftey_report_app_on;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->date_crom_concurred != $adverse->date_crom_concurred || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Date CROM Concurred';
            $history->previous = $lastData->date_crom_concurred;
            $history->current = $adverse->date_crom_concurred;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->date_draft_sr_sent != $adverse->date_draft_sr_sent || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Date Draft SR Sent';
            $history->previous = $lastData->date_draft_sr_sent;
            $history->current = $adverse->date_draft_sr_sent;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->date_mm_concurred != $adverse->date_mm_concurred || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Date MM Concurred';
            $history->previous = $lastData->date_mm_concurred;
            $history->current = $adverse->date_mm_concurred;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->date_of_event_resolution != $adverse->date_of_event_resolution || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Date Of Event Resolution';
            $history->previous = $lastData->date_of_event_resolution;
            $history->current = $adverse->date_of_event_resolution;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->date_pi_concurred != $adverse->date_pi_concurred || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Date PI Concurred';
            $history->previous = $lastData->date_pi_concurred;
            $history->current = $adverse->date_pi_concurred;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->date_recieved != $adverse->date_recieved || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Date Recieved';
            $history->previous = $lastData->date_recieved;
            $history->current = $adverse->date_recieved;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->date_safety_assessment_sent != $adverse->date_safety_assessment_sent || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Date Safety Assessment Sent';
            $history->previous = $lastData->date_safety_assessment_sent;
            $history->current = $adverse->date_safety_assessment_sent;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->date_sent_to_ra != $adverse->date_sent_to_ra || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Date Sent To RA';
            $history->previous = $lastData->date_sent_to_ra;
            $history->current = $adverse->date_sent_to_ra;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->date_sent_to_sites != $adverse->date_sent_to_sites || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'Date Sent To Sites';
            $history->previous = $lastData->date_sent_to_sites;
            $history->current = $adverse->date_sent_to_sites;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->sae_onset_date != $adverse->sae_onset_date || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'SAE Onset Date';
            $history->previous = $lastData->sae_onset_date;
            $history->current = $adverse->sae_onset_date;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->mm_saftey_report_approved_on != $adverse->mm_saftey_report_approved_on || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'MM Safety Report Approved On';
            $history->previous = $lastData->mm_saftey_report_approved_on;
            $history->current = $adverse->mm_saftey_report_approved_on;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }


        if ($lastData->pi_saftey_report_approved_on != $adverse->pi_saftey_report_approved_on || !empty ($request->comment)) {
            // return 'history';
            $history = new SeriousAuditTrail;
            $history->serious_id = $id;
            $history->activity_type = 'PI Safety Report Approved On';
            $history->previous = $lastData->pi_saftey_report_approved_on;
            $history->current = $adverse->pi_saftey_report_approved_on;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        //==================GRID=======================
        $serious_id = $adverse->id;
        $newDataGridSerious = SeriousGrid::where(['s_id' => $serious_id, 'identifier' => 'product'])->firstOrCreate();
        $newDataGridSerious->s_id = $serious_id;
        $newDataGridSerious->identifier = 'product';
        $newDataGridSerious->data = $request->product;
        $newDataGridSerious->save();
        //================================================================



        toastr()->success("Record is Updated Successfully");
        return back();
    }

    public function stagechange(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $SeriousControl = Serious::find($id);
            $lastDocument = Serious::find($id);

            if ($SeriousControl->stage == 1) {
                $SeriousControl->stage = "2";
                $SeriousControl->status = "Pending CROM/PI Concurrence";
                $SeriousControl->submitted_by = Auth::user()->name;
                $SeriousControl->submitted_on = Carbon::now()->format('d-M-Y');
                $SeriousControl->comment = $request->comment;

                $history = new SeriousAuditTrail();
                $history->serious_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $SeriousControl->submitted_by;
                $history->comment = $request->comment;
                $history->action = 'Submit';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_from = $lastDocument->status;
                $history->change_to =   "Pending CROM/PI Concurrence";
                $history->action_name = '';
                // $history->stage = 'Plan Approved';
                $history->save();

                $SeriousControl->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($SeriousControl->stage == 2) {
                $SeriousControl->stage = "3";
                $SeriousControl->status = "Pending Submission To FDA";
                $SeriousControl->submitted_by = Auth::user()->name;
                $SeriousControl->submitted_on = Carbon::now()->format('d-M-Y');
                $SeriousControl->comment = $request->comment;

                $history = new SeriousAuditTrail();
                $history->serious_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $SeriousControl->submitted_by;
                $history->comment = $request->comment;
                $history->action = 'Submit';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_from = $lastDocument->status;
                $history->change_to =   "Pending Submission To FDA";
                $history->action_name = '';
                // $history->stage = 'Plan Approved';
                $history->save();

                $SeriousControl->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($SeriousControl->stage == 3) {
                $SeriousControl->stage = "4";
                $SeriousControl->status = "Pending Storage";
                $SeriousControl->submitted_by = Auth::user()->name;
                $SeriousControl->submitted_on = Carbon::now()->format('d-M-Y');
                $SeriousControl->comment = $request->comment;

                $history = new SeriousAuditTrail();
                $history->serious_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $SeriousControl->submitted_by;
                $history->comment = $request->comment;
                $history->action = 'Submit';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_from = $lastDocument->status;
                $history->change_to =   "Pending Storage";
                $history->action_name = '';
                // $history->stage = 'Plan Approved';
                $history->save();

                $SeriousControl->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($SeriousControl->stage == 4) {
                $SeriousControl->stage = "5";
                $SeriousControl->status = "SAE Storage";
                $SeriousControl->submitted_by = Auth::user()->name;
                $SeriousControl->submitted_on = Carbon::now()->format('d-M-Y');
                $SeriousControl->comment = $request->comment;

                $history = new SeriousAuditTrail();
                $history->serious_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $SeriousControl->submitted_by;
                $history->comment = $request->comment;
                $history->action = 'Submit';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_from = $lastDocument->status;
                $history->change_to =   "SAE Storage";
                $history->action_name = '';
                // $history->stage = 'Plan Approved';
                $history->save();

                $SeriousControl->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($SeriousControl->stage == 5) {
                $SeriousControl->stage = "6";
                $SeriousControl->status = "Closed-Done";
                $SeriousControl->submitted_by = Auth::user()->name;
                $SeriousControl->submitted_on = Carbon::now()->format('d-M-Y');
                $SeriousControl->comment = $request->comment;

                $history = new SeriousAuditTrail();
                $history->serious_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $SeriousControl->submitted_by;
                $history->comment = $request->comment;
                $history->action = 'Submit';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_from = $lastDocument->status;
                $history->change_to =   "Closed-Done";
                $history->action_name = '';
                // $history->stage = 'Plan Approved';
                $history->save();

                $SeriousControl->update();
                toastr()->success('Document Sent');
                return back();
            }
        }
    }

    public function DirectStage(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $SeriousControl = Serious::find($id);
            $lastDocument = Serious::find($id);


        if ($SeriousControl->stage == 1) {
            $SeriousControl->stage = "5";
            $SeriousControl->status = "SAE Storage";
            $SeriousControl->submitted_by = Auth::user()->name;
            $SeriousControl->submitted_on = Carbon::now()->format('d-M-Y');
            $SeriousControl->comment = $request->comment;

                $history = new SeriousAuditTrail();
                $history->serious_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $SeriousControl->submitted_by;
                $history->comment = $request->comment;
                $history->action = 'Submit';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_from = $lastDocument->status;
                $history->change_to =   "SAE Storage";
                $history->action_name = '';
                // $history->stage = 'Plan Approved';
                $history->save();

            $SeriousControl->update();
            toastr()->success('Document Sent');
            return back();
        }
    }
}

    public function BackStage(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $SeriousControl = Serious::find($id);
            $lastDocument = Serious::find($id);



        if ($SeriousControl->stage == 2) {
            $SeriousControl->stage = "1";
            $SeriousControl->status = "Opened";
            $SeriousControl->submitted_by = Auth::user()->name;
            $SeriousControl->submitted_on = Carbon::now()->format('d-M-Y');
            $SeriousControl->comment = $request->comment;

                $history = new SeriousAuditTrail();
                $history->serious_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $SeriousControl->submitted_by;
                $history->comment = $request->comment;
                $history->action = 'Submit';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_from = $lastDocument->status;
                $history->change_to =   "Opened";
                $history->action_name = '';
                // $history->stage = 'Plan Approved';
                $history->save();

            $SeriousControl->update();
            toastr()->success('Document Sent');
            return back();
        }

        if ($SeriousControl->stage == 5) {
            $SeriousControl->stage = "1";
            $SeriousControl->status = "Opened";
            $SeriousControl->submitted_by = Auth::user()->name;
            $SeriousControl->submitted_on = Carbon::now()->format('d-M-Y');
            $SeriousControl->comment = $request->comment;

            $history = new SeriousAuditTrail();
            $history->serious_id = $id;
            $history->activity_type = 'Activity Log';
            $history->previous = "";
            $history->current = $SeriousControl->submitted_by;
            $history->comment = $request->comment;
            $history->action = 'Submit';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_from = $lastDocument->status;
            $history->change_to =   "Opened";
            $history->action_name = '';
            // $history->stage = 'Plan Approved';
            $history->save();

            $SeriousControl->update();
            toastr()->success('Document Sent');
            return back();
        }
    }
    }

    public function AuditTrial($id)
    {
        $audit = SeriousAuditTrail::where('serious_id', $id)->orderByDESC('id')->paginate(5);
        $today = Carbon::now()->format('d-m-y');
        $document = Serious::where('id', $id)->first();
        $document->originator = User::where('id', $document->initiator_id)->value('name');

        return view('frontend.serious-adverse-event.serious_audit_trail', compact('audit', 'document', 'today'));
    }

    public function auditTrailPdf($id){
        $doc = Serious::find($id);
        $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        $data = SeriousAuditTrail::where('serious_id', $doc->id)->orderByDesc('id')->get();
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.serious-adverse-event.serious_audit_report', compact('data', 'doc'))
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
