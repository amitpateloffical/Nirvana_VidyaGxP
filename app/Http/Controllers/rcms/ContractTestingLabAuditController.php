<?php

namespace App\Http\Controllers\rcms;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecordNumber;
use App\Models\User;
use App\Models\RoleGroup;
use App\Models\QMSDivision;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use App\Models\ContractTestingLabAudit;
use App\Models\ContractTestingLabAuditGrid;
use App\Models\ContractTestingLabAuditTrail;
use Carbon\Carbon;
use PDF;

class ContractTestingLabAuditController extends Controller
{
        public function index(){

            $old_record = ContractTestingLabAudit::select('id', 'division_id', 'record')->get();
            $record_number = ((RecordNumber::first()->value('counter')) + 1);
            $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
            $users = User::all();
            $qmsDevisions = QMSDivision::all();
            //dd($qmsDevisions);

            //due date
            $currentDate = Carbon::now();
            $formattedDate = $currentDate->addDays(30);
            $due_date = $formattedDate->format('Y-m-d');

            return view('frontend.New_forms.contract_testing_lab_audit',compact('old_record','record_number','users','qmsDevisions','due_date'));
        }

        public function store(Request $request){
        //dd($request->all());
            $audit = new ContractTestingLabAudit();
            $audit->form_type = "CTL-Audit";
            $audit->record = ((RecordNumber::first()->value('counter')) + 1);
            $audit->initiator_id = Auth::user()->id;
            $audit->division_id = $request->division_id;
            $audit->division_code = $request->division_code;
            $audit->intiation_date = $request->intiation_date;
            $audit->due_date = $request->due_date;
            $audit->parent_id = $request->parent_id;
            $audit->parent_type = $request->parent_type;
            $audit->short_description = $request->short_description;
            $audit->assigned_to = $request->assigned_to;
            $audit->audit_scheduled_for_the_year = $request->audit_scheduled_for_the_year;
            $audit->ctl_audit_schedule_no = $request->ctl_audit_schedule_no;
            $audit->name_of_contract_testing_lab = $request->name_of_contract_testing_lab;
            $audit->laboratory_address = $request->laboratory_address;
            $audit->application_sites = implode(',', $request->application_sites);
            $audit->new_existing_laboratory = $request->new_existing_laboratory;
            $audit->date_of_last_audit = $request->date_of_last_audit;
            $audit->audit_due_on_month = $request->audit_due_on_month;
            $audit->tcd_for_audit_completion = $request->tcd_for_audit_completion;
            $audit->audit_planing_to_be_done_on = $request->audit_planing_to_be_done_on;
            $audit->audit_request_communicated_to = $request->audit_request_communicated_to;
            $audit->proposed_audit_start_date = $request->proposed_audit_start_date;
            $audit->proposed_audit_completion = $request->proposed_audit_completion;
            $audit->name_of_lead_auditor = $request->name_of_lead_auditor;
            $audit->name_of_co_auditor = implode(',', $request->name_of_co_auditor);
            $audit->external_auditor_if_applicable = $request->external_auditor_if_applicable;
            $audit->details_of_for_cause_audit = $request->details_of_for_cause_audit;
            $audit->other_information_gi = $request->other_information_gi;
            $audit->qa_approver = $request->qa_approver;

            if (!empty ($request->proposal_attachments)) {
                $files = [];
                if ($request->hasfile('proposal_attachments')) {
                    foreach ($request->file('proposal_attachments') as $file) {
                        $name = $request->name . 'proposal_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $audit->proposal_attachments = $files;
            }

            $audit->remarks = $request->remarks;

            //CTL Audit Preparation

            $audit->audit_agenda = $request->audit_agenda;
            $audit->audit_agenda_sent_on = $request->audit_agenda_sent_on;
            $audit->audit_agenda_sent_to = $request->audit_agenda_sent_to;
            $audit->comments_remarks = $request->comments_remarks;
            $audit->communication_and_others = $request->communication_and_others;

            //CTL Audit Execution
            $audit->ctl_audit_started_on = $request->ctl_audit_started_on;
            $audit->ctl_audit_completed_on = $request->ctl_audit_completed_on;
            $audit->audit_execution_comments = $request->audit_execution_comments;
            $audit->audit_enclosures = $request->audit_enclosures;
            $audit->delay_justification_deviation = $request->delay_justification_deviation;

            //Audit Report Prep. & Approval
            $audit->critical = $request->critical;
            $audit->major = $request->major;
            $audit->minor = $request->minor;
            $audit->recomendations_comments = $request->recomendations_comments;
            $audit->total = $request->total;
            $audit->corrective_actions_agreed = $request->corrective_actions_agreed;
            $audit->executive_summary = $request->executive_summary;
            $audit->laboratory_acceptability = $request->laboratory_acceptability;
            $audit->remarks_conclusion = $request->remarks_conclusion;
            $audit->audit_report_ref_no = $request->audit_report_ref_no;
            $audit->audit_report_signed_on = $request->audit_report_signed_on;
            $audit->audit_report_approved_on = $request->audit_report_approved_on;

            if (!empty ($request->ctl_audit_report)) {
                $files = [];
                if ($request->hasfile('ctl_audit_report')) {
                    foreach ($request->file('ctl_audit_report') as $file) {
                        $name = $request->name . 'ctl_audit_report' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $audit->ctl_audit_report = $files;
            }

            $audit->delay_justification = $request->delay_justification;
            $audit->supportive_documents = $request->supportive_documents;

            //CTL Audit Report Issueance
            $audit->ctl_audit_report_issue_date = $request->ctl_audit_report_issue_date;
            $audit->audit_report_sent_to_ctl_on = $request->audit_report_sent_to_ctl_on;
            $audit->audit_report_sent_to = $request->audit_report_sent_to;
            $audit->report_acknowledged_on = $request->report_acknowledged_on;
            $audit->tcd_for_receipt_of_compliance = $request->tcd_for_receipt_of_compliance;
            $audit->other_information = $request->other_information;

            if (!empty ($request->file_attachments_if_any)) {
                $files = [];
                if ($request->hasfile('file_attachments_if_any')) {
                    foreach ($request->file('file_attachments_if_any') as $file) {
                        $name = $request->name . 'file_attachments_if_any' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $audit->file_attachments_if_any = $files;
            }


            //Pending CTL Response

            $audit->initial_response_received_on = $request->initial_response_received_on;
            $audit->final_response_received_on = $request->final_response_received_on;
            $audit->response_received_within_tcd = $request->response_received_within_tcd;
            $audit->reason_for_delayed_response = $request->reason_for_delayed_response;
            $audit->comments = $request->comments;

            if (!empty ($request->ctl_response_report)) {
                $files = [];
                if ($request->hasfile('ctl_response_report')) {
                    foreach ($request->file('ctl_response_report') as $file) {
                        $name = $request->name . 'ctl_response_report' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $audit->ctl_response_report = $files;
            }

            //CTL Audit Compliance
            $audit->response_review_comments = $request->response_review_comments;
            $audit->audit_task_required = $request->audit_task_required;
            $audit->audit_task_ref_no = $request->audit_task_ref_no;
            $audit->follow_up_task_required = $request->follow_up_task_required;
            $audit->follow_up_task_ref_no = $request->follow_up_task_ref_no;
            $audit->tcd_for_capa_implementation = $request->tcd_for_capa_implementation;
            $audit->response_review = $request->response_review;
            $audit->reason_for_disqualification = $request->reason_for_disqualification;
            $audit->requalification_frequency = $request->requalification_frequency;
            $audit->next_audit_due_date = $request->next_audit_due_date;

            if (!empty ($request->audit_closure_report)) {
                $files = [];
                if ($request->hasfile('audit_closure_report')) {
                    foreach ($request->file('audit_closure_report') as $file) {
                        $name = $request->name . 'audit_closure_report' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $audit->audit_closure_report = $files;
            }


            if (!empty ($request->response_file_attachments)) {
                $files = [];
                if ($request->hasfile('response_file_attachments')) {
                    foreach ($request->file('response_file_attachments') as $file) {
                        $name = $request->name . 'response_file_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $audit->response_file_attachments = $files;
            }


            //CTL Audit Compliance Approval

            $audit->approval_comments = $request->approval_comments;

            if (!empty ($request->approval_attachments)) {
                $files = [];
                if ($request->hasfile('approval_attachments')) {
                    foreach ($request->file('approval_attachments') as $file) {
                        $name = $request->name . 'approval_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $audit->approval_attachments = $files;
            }


            //Audit Conclusion

            $audit->all_observation_closed = $request->all_observation_closed;
            $audit->implementation_review_comments = $request->implementation_review_comments;
            $audit->implementation_completed_on = $request->implementation_completed_on;
            $audit->audit_closure_report_issued_on = $request->audit_closure_report_issued_on;

            if (!empty ($request->audit_closure_attachments)) {
                $files = [];
                if ($request->hasfile('audit_closure_attachments')) {
                    foreach ($request->file('audit_closure_attachments') as $file) {
                        $name = $request->name . 'audit_closure_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $audit->audit_closure_attachments = $files;
            }


            $audit->status = 'Opened';
            $audit->stage = '1';

            $audit->save();

            //Grid Store

            $g_id = $audit->id;
            $newDataGridAudit = ContractTestingLabAuditGrid::where(['ctl_audit_id' => $g_id, 'identifier' => 'auditee'])->firstOrCreate();
            $newDataGridAudit->ctl_audit_id = $g_id;
            $newDataGridAudit->identifier = 'auditee';
            $newDataGridAudit->data = $request->auditee;
            $newDataGridAudit->save();

            $g_id = $audit->id;
            $newDataGridAudit = ContractTestingLabAuditGrid::where(['ctl_audit_id' => $g_id, 'identifier' => 'key_personnel_met_during_audit'])->firstOrCreate();
            $newDataGridAudit->ctl_audit_id = $g_id;
            $newDataGridAudit->identifier = 'key_personnel_met_during_audit';
            $newDataGridAudit->data = $request->key_personnel_met_during_audit;
            $newDataGridAudit->save();

        //Audit Trail Store Start

        if(!empty($request->short_description)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->short_description;
            $history->activity_type = 'Short Description';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->assigned_to)){
            // Fetch the name based on the assigned_to ID
            $assigned_to_name = User::where('id', $request->assigned_to)->value('name');

            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $assigned_to_name;
            $history->activity_type = 'Assigned To';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }


        if(!empty($request->due_date)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = date('d-M-Y', strtotime($request->due_date));
            $history->activity_type = 'Date Due';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->audit_scheduled_for_the_year)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->audit_scheduled_for_the_year;
            $history->activity_type = 'Audit Scheduled for the year';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->ctl_audit_schedule_no)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->ctl_audit_schedule_no;
            $history->activity_type = 'CTL Audit Schedule No';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->name_of_contract_testing_lab)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->name_of_contract_testing_lab;
            $history->activity_type = 'Name of Contract Testing Lab';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->laboratory_address)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->laboratory_address;
            $history->activity_type = 'Laboratory Address';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->application_sites)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = json_encode($request->application_sites);
            $history->activity_type = 'Application Sites';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->new_existing_laboratory)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->new_existing_laboratory;
            $history->activity_type = 'New Existing Laboratory';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->date_of_last_audit)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = date('d-M-Y', strtotime($request->date_of_last_audit));
            $history->activity_type = 'Date of Last Audit';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->audit_due_on_month)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->audit_due_on_month;
            $history->activity_type = 'Audit Due On Month';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->tcd_for_audit_completion)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->tcd_for_audit_completion;
            $history->activity_type = 'TCD For Audit Completion';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->audit_planing_to_be_done_on)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->audit_planing_to_be_done_on;
            $history->activity_type = 'Audit Planing to be Done On';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->audit_request_communicated_to)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->audit_request_communicated_to;
            $history->activity_type = 'Audit Request Communicated To';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->proposed_audit_start_date)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->proposed_audit_start_date;
            $history->activity_type = 'Proposed Audit Start Date';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->proposed_audit_completion)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->proposed_audit_completion;
            $history->activity_type = 'Proposed Audit Completion';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->name_of_lead_auditor)){

            $current_name_of_lead_auditor = User::where('id', $request->name_of_lead_auditor)->value('name');

            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $current_name_of_lead_auditor;
            $history->activity_type = 'Name of Lead Auditor';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->name_of_co_auditor)){
            // Fetch the names based on the name_of_co_auditor IDs
            $co_auditor_names = User::whereIn('id', $request->name_of_co_auditor)->pluck('name')->toArray();
            $co_auditor_names_string = implode(', ', $co_auditor_names);

            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $co_auditor_names_string;
            $history->activity_type = 'Name of Co-Auditor';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }


        if(!empty($request->external_auditor_if_applicable)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->external_auditor_if_applicable;
            $history->activity_type = 'External Auditor, if Applicable';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->propose_of_audit)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->propose_of_audit;
            $history->activity_type = 'Propose of Audit';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->details_of_for_cause_audit)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->details_of_for_cause_audit;
            $history->activity_type = 'Details of for Cause Audit';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->other_information_gi)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->other_information_gi;
            $history->activity_type = 'Other Information ';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->qa_approver)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->qa_approver;
            $history->activity_type = 'QA Approver';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->proposal_attachments)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = json_encode($request->proposal_attachments);
            $history->activity_type = 'Proposal Attachments';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->remarks)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->remarks;
            $history->activity_type = 'Remarks';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->audit_agenda)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->audit_agenda;
            $history->activity_type = 'Audit Agenda';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->audit_agenda_sent_on)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->audit_agenda_sent_on;
            $history->activity_type = 'Audit Aenda Sent On';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->audit_agenda_sent_to)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->audit_agenda_sent_to;
            $history->activity_type = 'Audit Agenda Sent To';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->comments_remarks)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->comments_remarks;
            $history->activity_type = 'Comments/Remarks(If Any)';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->communication_and_others)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->communication_and_others;
            $history->activity_type = 'Communication & Others';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->ctl_audit_started_on)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->ctl_audit_started_on;
            $history->activity_type = 'CTL Audit Started On';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->ctl_audit_completed_on)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->ctl_audit_completed_on;
            $history->activity_type = 'CTL Audit Completed On';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->audit_execution_comments)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->audit_execution_comments;
            $history->activity_type = 'Audit Execution Comments';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->audit_enclosures)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->audit_enclosures;
            $history->activity_type = 'Audit Enclosures';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->delay_justification_deviation)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->delay_justification_deviation;
            $history->activity_type = 'Delay Justification/Deviation';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->critical)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->critical;
            $history->activity_type = 'Critical';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->major)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->major;
            $history->activity_type = 'Major';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }


        if(!empty($request->minor)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->minor;
            $history->activity_type = 'Minor';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->recomendations_comments)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->recomendations_comments;
            $history->activity_type = 'Recomendations/Comments';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->total)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->total;
            $history->activity_type = 'Total';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->corrective_actions_agreed)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->corrective_actions_agreed;
            $history->activity_type = 'Corrective Actions Agreed';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->executive_summary)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->executive_summary;
            $history->activity_type = 'Executive Summary';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->laboratory_acceptability)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->laboratory_acceptability;
            $history->activity_type = 'Laboratory Acceptability';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->remarks_conclusion)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->remarks_conclusion;
            $history->activity_type = 'Remarks & Conclusion';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->audit_report_ref_no)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->audit_report_ref_no;
            $history->activity_type = 'Audit Report Ref. No.';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->audit_report_signed_on)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->audit_report_signed_on;
            $history->activity_type = 'Audit Report Signed On';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->audit_report_approved_on)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->audit_report_approved_on;
            $history->activity_type = 'Audit Report Approved On';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->ctl_audit_report)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = json_encode($request->ctl_audit_report);
            $history->activity_type = 'CTL Audit Report';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->delay_justification)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->delay_justification;
            $history->activity_type = 'Delay Justification';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->supportive_documents)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->supportive_documents;
            $history->activity_type = 'Supportive Documents';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->ctl_audit_report_issue_date)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->ctl_audit_report_issue_date;
            $history->activity_type = 'CTL Audit Report Issue Date';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->audit_report_sent_to_ctl_on)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->audit_report_sent_to_ctl_on;
            $history->activity_type = 'Audit Report Sent To CTL On';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->audit_report_sent_to)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->audit_report_sent_to;
            $history->activity_type = 'Audit Report Sent To';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->report_acknowledged_on)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->report_acknowledged_on;
            $history->activity_type = 'Report Acknowledged On';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->tcd_for_receipt_of_compliance)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->tcd_for_receipt_of_compliance;
            $history->activity_type = 'TCD for Receipt of Compliance';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->other_information)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->other_information;
            $history->activity_type = 'Other Information (If Any)';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->file_attachments_if_any)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = json_encode($request->file_attachments_if_any);
            $history->activity_type = 'File Attachments If Any';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->initial_response_received_on)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->initial_response_received_on;
            $history->activity_type = 'Initial Response Received On';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->final_response_received_on)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->final_response_received_on;
            $history->activity_type = 'Final Response Received On';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->response_received_within_tcd)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->response_received_within_tcd;
            $history->activity_type = 'Response Received Within TCD';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->reason_for_delayed_response)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->reason_for_delayed_response;
            $history->activity_type = 'Reason for Delayed Response';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->comments)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->comments;
            $history->activity_type = 'Comments';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->ctl_response_report)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = json_encode($request->ctl_response_report);
            $history->activity_type = 'CTL Response Report';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->response_review_comments)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->response_review_comments;
            $history->activity_type = 'Response Review Comments';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->audit_task_required)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->audit_task_required;
            $history->activity_type = 'Audit Task Required';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->audit_task_ref_no)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->audit_task_ref_no;
            $history->activity_type = 'Audit Task Ref. No';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->follow_up_task_required)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->follow_up_task_required;
            $history->activity_type = 'Follow Up Task Required';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->follow_up_task_ref_no)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->follow_up_task_ref_no;
            $history->activity_type = 'Follow-Up Task Ref. No';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }


        if(!empty($request->tcd_for_capa_implementation)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->tcd_for_capa_implementation;
            $history->activity_type = 'TCD for Capa Implementation';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }


        if(!empty($request->response_review)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->response_review;
            $history->activity_type = 'Response Review';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->reason_for_disqualification)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->reason_for_disqualification;
            $history->activity_type = 'Reason For Disqualification';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->requalification_frequency)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->requalification_frequency;
            $history->activity_type = 'Requalification Frequency';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->next_audit_due_date)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->next_audit_due_date;
            $history->activity_type = 'Next Audit Due Date';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->audit_closure_report)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = json_encode($request->audit_closure_report);
            $history->activity_type = 'Audit Closure Report';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->response_file_attachments)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = json_encode($request->response_file_attachments);
            $history->activity_type = 'Response File Attachments';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->approval_comments)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->approval_comments;
            $history->activity_type = 'Approval Comments';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->approval_attachments)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = json_encode($request->approval_attachments);
            $history->activity_type = 'Approval Attachments';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();

        }

        if(!empty($request->all_observation_closed)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->all_observation_closed;
            $history->activity_type = 'All Observation Closed';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }


        if(!empty($request->implementation_review_comments)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->implementation_review_comments;
            $history->activity_type = 'Implementation Review Comments';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }


        if(!empty($request->implementation_completed_on)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->implementation_completed_on;
            $history->activity_type = 'Implementation Completed On';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->audit_closure_report_issued_on)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = $request->audit_closure_report_issued_on;
            $history->activity_type = 'Audit Closure Report Issued On';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }

        if(!empty($request->audit_closure_attachments)){
            $history = new ContractTestingLabAuditTrail();
            $history->ctl_audit_id = $audit->id;
            $history->previous = "Null";
            $history->current = json_encode($request->audit_closure_attachments);
            $history->activity_type = 'Audit Closure Attachments';
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = "Opened";
            $history->change_from = "Initiation";
            $history->action_name = 'Create';
            $history->comment = "Not Applicable";
            $history->save();
        }
            toastr()->success("Record is created Successfully");
            return redirect(url('rcms/qms-dashboard'));

        }



        public function edit($id){

            $audit_data = ContractTestingLabAudit::findOrFail($id);

            $old_record = ContractTestingLabAudit::select('id', 'division_id', 'record')->get();
            $record_number = ((RecordNumber::first()->value('counter')) + 1);
            $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
            $users = User::all();
            $qmsDevisions = QMSDivision::all();
            //dd($qmsDevisions);

            //due date
            $currentDate = Carbon::now();
            $formattedDate = $currentDate->addDays(30);
            $due_date = $formattedDate->format('Y-m-d');

            $g_id = $audit_data->id;
            $grid_DataA = ContractTestingLabAuditGrid::where(['ctl_audit_id' => $g_id, 'identifier' => 'auditee'])->first();
            //dd($grid_Data);

            $g_id = $audit_data->id;
            $grid_DataK = ContractTestingLabAuditGrid::where(['ctl_audit_id' => $g_id, 'identifier' => 'key_personnel_met_during_audit'])->first();
            //dd($grid_Data);

            return view('frontend.New_forms.contract_testing_lab_audit_view',compact('audit_data','old_record','record_number','users','qmsDevisions','due_date','grid_DataA','grid_DataK'));
         }

        public function update(Request $request, $id){
            //dd($request->all());
            $audit_data = ContractTestingLabAudit::findOrFail($id);

            $audit = ContractTestingLabAudit::findOrFail($id);

            $audit->form_type = "CTL-Audit";
            $audit->record = ((RecordNumber::first()->value('counter')) + 1);
            $audit->initiator_id = Auth::user()->id;
            $audit->division_id = $request->division_id;
            $audit->division_code = $request->division_code;
            $audit->intiation_date = $request->intiation_date;
            $audit->due_date = $request->due_date;
            $audit->parent_id = $request->parent_id;
            $audit->parent_type = $request->parent_type;
            $audit->short_description = $request->short_description;
            $audit->assigned_to = $request->assigned_to;
            $audit->audit_scheduled_for_the_year = $request->audit_scheduled_for_the_year;
            $audit->ctl_audit_schedule_no = $request->ctl_audit_schedule_no;
            $audit->name_of_contract_testing_lab = $request->name_of_contract_testing_lab;
            $audit->laboratory_address = $request->laboratory_address;
            $audit->application_sites = implode(',', $request->application_sites);
            $audit->new_existing_laboratory = $request->new_existing_laboratory;
            $audit->date_of_last_audit = $request->date_of_last_audit;
            $audit->audit_due_on_month = $request->audit_due_on_month;
            $audit->tcd_for_audit_completion = $request->tcd_for_audit_completion;
            $audit->audit_planing_to_be_done_on = $request->audit_planing_to_be_done_on;
            $audit->audit_request_communicated_to = $request->audit_request_communicated_to;
            $audit->proposed_audit_start_date = $request->proposed_audit_start_date;
            $audit->proposed_audit_completion = $request->proposed_audit_completion;
            $audit->name_of_lead_auditor = $request->name_of_lead_auditor;
            $audit->name_of_co_auditor = implode(',', $request->name_of_co_auditor);
            $audit->external_auditor_if_applicable = $request->external_auditor_if_applicable;
            $audit->propose_of_audit = $request->propose_of_audit;
            $audit->details_of_for_cause_audit = $request->details_of_for_cause_audit;
            $audit->other_information_gi = $request->other_information_gi;
            $audit->qa_approver = $request->qa_approver;

            if (!empty ($request->proposal_attachments)) {
                $files = [];
                if ($request->hasfile('proposal_attachments')) {
                    foreach ($request->file('proposal_attachments') as $file) {
                        $name = $request->name . 'proposal_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $audit->proposal_attachments = $files;
            }

            $audit->remarks = $request->remarks;

            //CTL Audit Preparation

            $audit->audit_agenda = $request->audit_agenda;
            $audit->audit_agenda_sent_on = $request->audit_agenda_sent_on;
            $audit->audit_agenda_sent_to = $request->audit_agenda_sent_to;
            $audit->comments_remarks = $request->comments_remarks;
            $audit->communication_and_others = $request->communication_and_others;

            //CTL Audit Execution
            $audit->ctl_audit_started_on = $request->ctl_audit_started_on;
            $audit->ctl_audit_completed_on = $request->ctl_audit_completed_on;
            $audit->audit_execution_comments = $request->audit_execution_comments;
            $audit->audit_enclosures = $request->audit_enclosures;
            $audit->delay_justification_deviation = $request->delay_justification_deviation;

            //Audit Report Prep. & Approval
            $audit->critical = $request->critical;
            $audit->major = $request->major;
            $audit->minor = $request->minor;
            $audit->recomendations_comments = $request->recomendations_comments;
            $audit->total = $request->total;
            $audit->corrective_actions_agreed = $request->corrective_actions_agreed;
            $audit->executive_summary = $request->executive_summary;
            $audit->laboratory_acceptability = $request->laboratory_acceptability;
            $audit->remarks_conclusion = $request->remarks_conclusion;
            $audit->audit_report_ref_no = $request->audit_report_ref_no;
            $audit->audit_report_signed_on = $request->audit_report_signed_on;
            $audit->audit_report_approved_on = $request->audit_report_approved_on;

            if (!empty ($request->ctl_audit_report)) {
                $files = [];
                if ($request->hasfile('ctl_audit_report')) {
                    foreach ($request->file('ctl_audit_report') as $file) {
                        $name = $request->name . 'ctl_audit_report' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $audit->ctl_audit_report = $files;
            }

            $audit->delay_justification = $request->delay_justification;
            $audit->supportive_documents = $request->supportive_documents;

            //CTL Audit Report Issueance
            $audit->ctl_audit_report_issue_date = $request->ctl_audit_report_issue_date;
            $audit->audit_report_sent_to_ctl_on = $request->audit_report_sent_to_ctl_on;
            $audit->audit_report_sent_to = $request->audit_report_sent_to;
            $audit->report_acknowledged_on = $request->report_acknowledged_on;
            $audit->tcd_for_receipt_of_compliance = $request->tcd_for_receipt_of_compliance;
            $audit->other_information = $request->other_information;

            if (!empty ($request->file_attachments_if_any)) {
                $files = [];
                if ($request->hasfile('file_attachments_if_any')) {
                    foreach ($request->file('file_attachments_if_any') as $file) {
                        $name = $request->name . 'file_attachments_if_any' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $audit->file_attachments_if_any = $files;
            }


            //Pending CTL Response

            $audit->initial_response_received_on = $request->initial_response_received_on;
            $audit->final_response_received_on = $request->final_response_received_on;
            $audit->response_received_within_tcd = $request->response_received_within_tcd;
            $audit->reason_for_delayed_response = $request->reason_for_delayed_response;
            $audit->comments = $request->comments;

            if (!empty ($request->ctl_response_report)) {
                $files = [];
                if ($request->hasfile('ctl_response_report')) {
                    foreach ($request->file('ctl_response_report') as $file) {
                        $name = $request->name . 'ctl_response_report' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $audit->ctl_response_report = $files;
            }

            //CTL Audit Compliance
            $audit->response_review_comments = $request->response_review_comments;
            $audit->audit_task_required = $request->audit_task_required;
            $audit->audit_task_ref_no = $request->audit_task_ref_no;
            $audit->follow_up_task_required = $request->follow_up_task_required;
            $audit->follow_up_task_ref_no = $request->follow_up_task_ref_no;
            $audit->tcd_for_capa_implementation = $request->tcd_for_capa_implementation;
            $audit->response_review = $request->response_review;
            $audit->reason_for_disqualification = $request->reason_for_disqualification;
            $audit->requalification_frequency = $request->requalification_frequency;
            $audit->next_audit_due_date = $request->next_audit_due_date;

            if (!empty ($request->audit_closure_report)) {
                $files = [];
                if ($request->hasfile('audit_closure_report')) {
                    foreach ($request->file('audit_closure_report') as $file) {
                        $name = $request->name . 'audit_closure_report' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $audit->audit_closure_report = $files;
            }


            if (!empty ($request->response_file_attachments)) {
                $files = [];
                if ($request->hasfile('response_file_attachments')) {
                    foreach ($request->file('response_file_attachments') as $file) {
                        $name = $request->name . 'response_file_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $audit->response_file_attachments = $files;
            }


            //CTL Audit Compliance Approval

            $audit->approval_comments = $request->approval_comments;

            if (!empty ($request->approval_attachments)) {
                $files = [];
                if ($request->hasfile('approval_attachments')) {
                    foreach ($request->file('approval_attachments') as $file) {
                        $name = $request->name . 'approval_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $audit->approval_attachments = $files;
            }


            //Audit Conclusion

            $audit->all_observation_closed = $request->all_observation_closed;
            $audit->implementation_review_comments = $request->implementation_review_comments;
            $audit->implementation_completed_on = $request->implementation_completed_on;
            $audit->audit_closure_report_issued_on = $request->audit_closure_report_issued_on;

            if (!empty ($request->audit_closure_attachments)) {
                $files = [];
                if ($request->hasfile('audit_closure_attachments')) {
                    foreach ($request->file('audit_closure_attachments') as $file) {
                        $name = $request->name . 'audit_closure_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $audit->audit_closure_attachments = $files;
            }


            $audit->save();

            //Grid Update

            $g_id = $audit->id;
            $newDataGridAudit = ContractTestingLabAuditGrid::where(['ctl_audit_id' => $g_id, 'identifier' => 'auditee'])->firstOrCreate();
            $newDataGridAudit->ctl_audit_id = $g_id;
            $newDataGridAudit->identifier = 'auditee';
            $newDataGridAudit->data = $request->auditee;
            $newDataGridAudit->save();

            $g_id = $audit->id;
            $newDataGridAudit = ContractTestingLabAuditGrid::where(['ctl_audit_id' => $g_id, 'identifier' => 'key_personnel_met_during_audit'])->firstOrCreate();
            $newDataGridAudit->ctl_audit_id = $g_id;
            $newDataGridAudit->identifier = 'key_personnel_met_during_audit';
            $newDataGridAudit->data = $request->key_personnel_met_during_audit;
            $newDataGridAudit->save();


            //Audit Trail Update

            if($audit_data->short_description != $audit->short_description){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->short_description;
                $history->current = $audit->short_description;
                $history->activity_type = 'Short Description';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->short_description) || $audit_data->short_description === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();

            }

            if($audit_data->assigned_to != $audit->assigned_to){
                // Fetch names based on assigned_to IDs
                $previous_assigned_to_name = User::where('id', $audit_data->assigned_to)->value('name');
                $current_assigned_to_name = User::where('id', $audit->assigned_to)->value('name');

                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $previous_assigned_to_name;
                $history->current = $current_assigned_to_name;
                $history->activity_type = 'Assigned To';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from = $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->assigned_to) || $audit_data->assigned_to === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }


            if($audit_data->due_date != $audit->due_date){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = date('d-M-Y', strtotime($audit_data->due_date));
                $history->current = date('d-M-Y', strtotime($audit->due_date));
                $history->activity_type = 'Date Due';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->due_date) || $audit_data->due_date === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();

            }

            if($audit_data->audit_scheduled_for_the_year != $audit->audit_scheduled_for_the_year){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->audit_scheduled_for_the_year;
                $history->current = $audit->audit_scheduled_for_the_year;
                $history->activity_type = 'Audit Scheduled for the year';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->audit_scheduled_for_the_year) || $audit_data->audit_scheduled_for_the_year === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();

            }

            if($audit_data->ctl_audit_schedule_no != $audit->ctl_audit_schedule_no){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->ctl_audit_schedule_no;
                $history->current = $audit->ctl_audit_schedule_no;
                $history->activity_type = 'CTL Audit Schedule No.';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->ctl_audit_schedule_no) || $audit_data->ctl_audit_schedule_no === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();

            }


            if($audit_data->name_of_contract_testing_lab != $audit->name_of_contract_testing_lab){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->name_of_contract_testing_lab;
                $history->current = $audit->name_of_contract_testing_lab;
                $history->activity_type = 'Name of Contract Testing Lab';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->name_of_contract_testing_lab) || $audit_data->name_of_contract_testing_lab === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();

            }

            if($audit_data->laboratory_address != $audit->laboratory_address){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->laboratory_address;
                $history->current = $audit->laboratory_address;
                $history->activity_type = 'Laboratory Address';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->laboratory_address) || $audit_data->laboratory_address === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();

            }

            if($audit_data->application_sites != $audit->application_sites){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = json_encode($audit_data->application_sites);
                $history->current = json_encode($audit->application_sites);
                $history->activity_type = 'Application Sites';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->application_sites) || $audit_data->application_sites === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();

            }

            if($audit_data->new_existing_laboratory != $audit->new_existing_laboratory){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->new_existing_laboratory;
                $history->current = $audit->new_existing_laboratory;
                $history->activity_type = 'New Existing Laboratory';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->new_existing_laboratory) || $audit_data->new_existing_laboratory === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();

            }

            if($audit_data->date_of_last_audit != $audit->date_of_last_audit){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = date('d-M-Y', strtotime($audit_data->date_of_last_audit));
                $history->current = date('d-M-Y', strtotime($audit->date_of_last_audit));
                $history->activity_type = 'Date of Last Audit';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from = $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->date_of_last_audit) || $audit_data->date_of_last_audit === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }


            if($audit_data->audit_due_on_month != $audit->audit_due_on_month){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->audit_due_on_month;
                $history->current = $audit->audit_due_on_month;
                $history->activity_type = 'Audit Due On Month';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->audit_due_on_month) || $audit_data->audit_due_on_month === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();

            }

            if($audit_data->tcd_for_audit_completion != $audit->tcd_for_audit_completion){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->tcd_for_audit_completion;
                $history->current = $audit->tcd_for_audit_completion;
                $history->activity_type = 'TCD For Audit Completion';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->tcd_for_audit_completion) || $audit_data->tcd_for_audit_completion === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();

            }

            if($audit_data->audit_planing_to_be_done_on != $audit->audit_planing_to_be_done_on){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->audit_planing_to_be_done_on;
                $history->current = $audit->audit_planing_to_be_done_on;
                $history->activity_type = 'Audit Planing to be Done On';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->audit_planing_to_be_done_on) || $audit_data->audit_planing_to_be_done_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();

            }

            if($audit_data->audit_request_communicated_to != $audit->audit_request_communicated_to){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->audit_request_communicated_to;
                $history->current = $audit->audit_request_communicated_to;
                $history->activity_type = 'Audit Request Communicated To';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->audit_request_communicated_to) || $audit_data->audit_request_communicated_to === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();

            }

            if($audit_data->proposed_audit_start_date != $audit->proposed_audit_start_date){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->proposed_audit_start_date;
                $history->current = $audit->proposed_audit_start_date;
                $history->activity_type = 'Proposed Audit Start Date';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->proposed_audit_start_date) || $audit_data->proposed_audit_start_date === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();

            }

            if($audit_data->proposed_audit_completion != $audit->proposed_audit_completion){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->proposed_audit_completion;
                $history->current = $audit->proposed_audit_completion;
                $history->activity_type = 'Proposed Audit Completion';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->proposed_audit_completion) || $audit_data->proposed_audit_completion === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();

            }

            if($audit_data->name_of_lead_auditor != $audit->name_of_lead_auditor){

                $previous_name_of_lead_auditor = User::where('id', $audit_data->name_of_lead_auditor)->value('name');
                $current_name_of_lead_auditor = User::where('id', $audit->name_of_lead_auditor)->value('name');

                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $previous_name_of_lead_auditor;
                $history->current = $current_name_of_lead_auditor;
                $history->activity_type = 'Name of Lead Auditor';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->name_of_lead_auditor) || $audit_data->name_of_lead_auditor === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();

            }

            if($audit_data->name_of_co_auditor != $audit->name_of_co_auditor){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = json_encode($audit_data->name_of_co_auditor);
                $history->current = json_encode($audit->name_of_co_auditor);
                $history->activity_type = 'Name of Co-Auditor';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->name_of_co_auditor) || $audit_data->name_of_co_auditor === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();

            }

            if($audit_data->external_auditor_if_applicable != $audit->external_auditor_if_applicable){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->external_auditor_if_applicable;
                $history->current = $audit->external_auditor_if_applicable;
                $history->activity_type = 'External Auditor, if Applicable';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->external_auditor_if_applicable) || $audit_data->external_auditor_if_applicable === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->propose_of_audit != $audit->propose_of_audit){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->propose_of_audit;
                $history->current = $audit->propose_of_audit;
                $history->activity_type = 'Propose of Audit';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->propose_of_audit) || $audit_data->propose_of_audit === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->details_of_for_cause_audit != $audit->details_of_for_cause_audit){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->details_of_for_cause_audit;
                $history->current = $audit->details_of_for_cause_audit;
                $history->activity_type = 'Details of for Cause Audit';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->details_of_for_cause_audit) || $audit_data->details_of_for_cause_audit === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->other_information_gi != $audit->other_information_gi){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->other_information_gi;
                $history->current = $audit->other_information_gi;
                $history->activity_type = 'Other Information (If Any)';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->other_information_gi) || $audit_data->other_information_gi === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }


            if($audit_data->qa_approver != $audit->qa_approver){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->qa_approver;
                $history->current = $audit->qa_approver;
                $history->activity_type = 'QA Approver';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->qa_approver) || $audit_data->qa_approver === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->proposal_attachments != $audit->proposal_attachments){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = json_encode($audit_data->proposal_attachments);
                $history->current = json_encode($audit->proposal_attachments);
                $history->activity_type = 'Proposal Attachments';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->proposal_attachments) || $audit_data->proposal_attachments === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->remarks != $audit->remarks){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->remarks;
                $history->current = $audit->remarks;
                $history->activity_type = 'Remarks';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->remarks) || $audit_data->remarks === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->audit_agenda != $audit->audit_agenda){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->audit_agenda;
                $history->current = $audit->audit_agenda;
                $history->activity_type = 'Audit Agenda';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->audit_agenda) || $audit_data->audit_agenda === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->audit_agenda_sent_on != $audit->audit_agenda_sent_on){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->audit_agenda_sent_on;
                $history->current = $audit->audit_agenda_sent_on;
                $history->activity_type = 'Audit Aenda Sent On';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->audit_agenda_sent_on) || $audit_data->audit_agenda_sent_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->audit_agenda_sent_to != $audit->audit_agenda_sent_to){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->audit_agenda_sent_to;
                $history->current = $audit->audit_agenda_sent_to;
                $history->activity_type = 'Audit Agenda Sent To';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->audit_agenda_sent_to) || $audit_data->audit_agenda_sent_to === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->comments_remarks != $audit->comments_remarks){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->comments_remarks;
                $history->current = $audit->comments_remarks;
                $history->activity_type = 'Comments / Remarks(If Any)';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->comments_remarks) || $audit_data->comments_remarks === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->communication_and_others != $audit->communication_and_others){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->communication_and_others;
                $history->current = $audit->communication_and_others;
                $history->activity_type = 'Communication & Others';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->communication_and_others) || $audit_data->communication_and_others === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->ctl_audit_started_on != $audit->ctl_audit_started_on){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->ctl_audit_started_on;
                $history->current = $audit->ctl_audit_started_on;
                $history->activity_type = 'CTL Audit Started On';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->ctl_audit_started_on) || $audit_data->ctl_audit_started_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->ctl_audit_completed_on != $audit->ctl_audit_completed_on){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->ctl_audit_completed_on;
                $history->current = $audit->ctl_audit_completed_on;
                $history->activity_type = 'CTL Audit Completed On';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->ctl_audit_completed_on) || $audit_data->ctl_audit_completed_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->audit_execution_comments != $audit->audit_execution_comments){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->audit_execution_comments;
                $history->current = $audit->audit_execution_comments;
                $history->activity_type = 'Audit Execution Comments';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->audit_execution_comments) || $audit_data->audit_execution_comments === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->audit_enclosures != $audit->audit_enclosures){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->audit_enclosures;
                $history->current = $audit->audit_enclosures;
                $history->activity_type = 'Audit Enclosures';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->audit_enclosures) || $audit_data->audit_enclosures === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->delay_justification_deviation != $audit->delay_justification_deviation){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->delay_justification_deviation;
                $history->current = $audit->delay_justification_deviation;
                $history->activity_type = 'Delay Justification/Deviation';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->delay_justification_deviation) || $audit_data->delay_justification_deviation === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->critical != $audit->critical){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->critical;
                $history->current = $audit->critical;
                $history->activity_type = 'Critical';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->critical) || $audit_data->critical === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->major != $audit->major){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->major;
                $history->current = $audit->major;
                $history->activity_type = 'Major';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->major) || $audit_data->major === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }


            if($audit_data->minor != $audit->minor){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->minor;
                $history->current = $audit->minor;
                $history->activity_type = 'Minor';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->minor) || $audit_data->minor === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->recomendations_comments != $audit->recomendations_comments){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->recomendations_comments;
                $history->current = $audit->recomendations_comments;
                $history->activity_type = 'Recomendations/Comments';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->recomendations_comments) || $audit_data->recomendations_comments === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->total != $audit->total){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->total;
                $history->current = $audit->total;
                $history->activity_type = 'Total';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->total) || $audit_data->total === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->corrective_actions_agreed != $audit->corrective_actions_agreed){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->corrective_actions_agreed;
                $history->current = $audit->corrective_actions_agreed;
                $history->activity_type = 'Corrective Actions Agreed';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->corrective_actions_agreed) || $audit_data->corrective_actions_agreed === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->executive_summary != $audit->executive_summary){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->executive_summary;
                $history->current = $audit->executive_summary;
                $history->activity_type = 'Executive Summary';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->executive_summary) || $audit_data->executive_summary === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->laboratory_acceptability != $audit->laboratory_acceptability){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->laboratory_acceptability;
                $history->current = $audit->laboratory_acceptability;
                $history->activity_type = 'Laboratory Acceptability';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->laboratory_acceptability) || $audit_data->laboratory_acceptability === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->remarks_conclusion != $audit->remarks_conclusion){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->remarks_conclusion;
                $history->current = $audit->remarks_conclusion;
                $history->activity_type = 'Remarks & Conclusion';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->remarks_conclusion) || $audit_data->remarks_conclusion === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->audit_report_ref_no != $audit->audit_report_ref_no){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->audit_report_ref_no;
                $history->current = $audit->audit_report_ref_no;
                $history->activity_type = 'Audit Report Ref. No.';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->audit_report_ref_no) || $audit_data->audit_report_ref_no === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->audit_report_signed_on != $audit->audit_report_signed_on){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->audit_report_signed_on;
                $history->current = $audit->audit_report_signed_on;
                $history->activity_type = 'Audit Report Signed On';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->audit_report_signed_on) || $audit_data->audit_report_signed_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->audit_report_approved_on != $audit->audit_report_approved_on){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->audit_report_approved_on;
                $history->current = $audit->audit_report_approved_on;
                $history->activity_type = 'Audit Report Approved On';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->audit_report_approved_on) || $audit_data->audit_report_approved_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->ctl_audit_report != $audit->ctl_audit_report){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = json_encode($audit_data->ctl_audit_report);
                $history->current = json_encode($audit->ctl_audit_report);
                $history->activity_type = 'CTL Audit Report';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->ctl_audit_report) || $audit_data->ctl_audit_report === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->delay_justification != $audit->delay_justification){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->delay_justification;
                $history->current = $audit->delay_justification;
                $history->activity_type = 'Delay Justification';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->delay_justification) || $audit_data->delay_justification === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->supportive_documents != $audit->supportive_documents){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->supportive_documents;
                $history->current = $audit->supportive_documents;
                $history->activity_type = 'Supportive Documents';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->supportive_documents) || $audit_data->supportive_documents === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->ctl_audit_report_issue_date != $audit->ctl_audit_report_issue_date){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->ctl_audit_report_issue_date;
                $history->current = $audit->ctl_audit_report_issue_date;
                $history->activity_type = 'CTL Audit Report Issue Date';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->ctl_audit_report_issue_date) || $audit_data->ctl_audit_report_issue_date === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->audit_report_sent_to_ctl_on != $audit->audit_report_sent_to_ctl_on){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->audit_report_sent_to_ctl_on;
                $history->current = $audit->audit_report_sent_to_ctl_on;
                $history->activity_type = 'Audit Report Sent To CTL On';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->audit_report_sent_to_ctl_on) || $audit_data->audit_report_sent_to_ctl_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->audit_report_sent_to != $audit->audit_report_sent_to){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->audit_report_sent_to;
                $history->current = $audit->audit_report_sent_to;
                $history->activity_type = 'Audit Report Sent To';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->audit_report_sent_to) || $audit_data->audit_report_sent_to === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->report_acknowledged_on != $audit->report_acknowledged_on){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->report_acknowledged_on;
                $history->current = $audit->report_acknowledged_on;
                $history->activity_type = 'Report Acknowledged On';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->report_acknowledged_on) || $audit_data->report_acknowledged_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->tcd_for_receipt_of_compliance != $audit->tcd_for_receipt_of_compliance){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->tcd_for_receipt_of_compliance;
                $history->current = $audit->tcd_for_receipt_of_compliance;
                $history->activity_type = 'TCD for Receipt of Compliance';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->tcd_for_receipt_of_compliance) || $audit_data->tcd_for_receipt_of_compliance === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->other_information != $audit->other_information){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->other_information;
                $history->current = $audit->other_information;
                $history->activity_type = 'Other Information (If Any)';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->other_information) || $audit_data->other_information === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->file_attachments_if_any != $audit->file_attachments_if_any){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = json_encode($audit_data->file_attachments_if_any);
                $history->current = json_encode($audit->file_attachments_if_any);
                $history->activity_type = 'File Attachments If Any';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->file_attachments_if_any) || $audit_data->file_attachments_if_any === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->initial_response_received_on != $audit->initial_response_received_on){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->initial_response_received_on;
                $history->current = $audit->initial_response_received_on;
                $history->activity_type = 'Initial Response Received On';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->initial_response_received_on) || $audit_data->initial_response_received_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->final_response_received_on != $audit->final_response_received_on){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->final_response_received_on;
                $history->current = $audit->final_response_received_on;
                $history->activity_type = 'Final Response Received On';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->final_response_received_on) || $audit_data->final_response_received_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->response_received_within_tcd != $audit->response_received_within_tcd){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->response_received_within_tcd;
                $history->current = $audit->response_received_within_tcd;
                $history->activity_type = 'Response Received Within TCD';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->response_received_within_tcd) || $audit_data->response_received_within_tcd === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->reason_for_delayed_response != $audit->reason_for_delayed_response){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->reason_for_delayed_response;
                $history->current = $audit->reason_for_delayed_response;
                $history->activity_type = 'Reason for Delayed Response';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->reason_for_delayed_response) || $audit_data->reason_for_delayed_response === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->comments != $audit->comments){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->comments;
                $history->current = $audit->comments;
                $history->activity_type = 'Comments';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->comments) || $audit_data->comments === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->ctl_response_report != $audit->ctl_response_report){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = json_encode($audit_data->ctl_response_report);
                $history->current = json_encode($audit->ctl_response_report);
                $history->activity_type = 'CTL Response Report';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->ctl_response_report) || $audit_data->ctl_response_report === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->response_review_comments != $audit->response_review_comments){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->response_review_comments;
                $history->current = $audit->response_review_comments;
                $history->activity_type = 'Response Review Comments';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->response_review_comments) || $audit_data->response_review_comments === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->audit_task_required != $audit->audit_task_required){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->audit_task_required;
                $history->current = $audit->audit_task_required;
                $history->activity_type = 'Audit Task Required?';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->audit_task_required) || $audit_data->audit_task_required === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->audit_task_ref_no != $audit->audit_task_ref_no){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->audit_task_ref_no;
                $history->current = $audit->audit_task_ref_no;
                $history->activity_type = 'Audit Task Ref. No';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->audit_task_ref_no) || $audit_data->audit_task_ref_no === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->follow_up_task_required != $audit->follow_up_task_required){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->follow_up_task_required;
                $history->current = $audit->follow_up_task_required;
                $history->activity_type = 'Follow Up Task Required';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->follow_up_task_required) || $audit_data->follow_up_task_required === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->follow_up_task_ref_no != $audit->follow_up_task_ref_no){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->follow_up_task_ref_no;
                $history->current = $audit->follow_up_task_ref_no;
                $history->activity_type = 'Follow-Up Task Ref. No';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->follow_up_task_ref_no) || $audit_data->follow_up_task_ref_no === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->tcd_for_capa_implementation != $audit->tcd_for_capa_implementation){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->tcd_for_capa_implementation;
                $history->current = $audit->tcd_for_capa_implementation;
                $history->activity_type = 'TCD for Capa Implementation';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->tcd_for_capa_implementation) || $audit_data->tcd_for_capa_implementation === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->response_review != $audit->response_review){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->response_review;
                $history->current = $audit->response_review;
                $history->activity_type = 'Response Review';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->response_review) || $audit_data->response_review === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->reason_for_disqualification != $audit->reason_for_disqualification){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->reason_for_disqualification;
                $history->current = $audit->reason_for_disqualification;
                $history->activity_type = 'Reason For Disqualification';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->reason_for_disqualification) || $audit_data->reason_for_disqualification === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->requalification_frequency != $audit->requalification_frequency){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->requalification_frequency;
                $history->current = $audit->requalification_frequency;
                $history->activity_type = 'Requalification Frequency';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->requalification_frequency) || $audit_data->requalification_frequency === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->next_audit_due_date != $audit->next_audit_due_date){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->next_audit_due_date;
                $history->current = $audit->next_audit_due_date;
                $history->activity_type = 'Next Audit Due Date';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->next_audit_due_date) || $audit_data->next_audit_due_date === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }


            if($audit_data->audit_closure_report != $audit->audit_closure_report){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = json_encode($audit_data->audit_closure_report);
                $history->current = json_encode($audit->audit_closure_report);
                $history->activity_type = 'Audit Closure Report';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->audit_closure_report) || $audit_data->audit_closure_report === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->response_file_attachments != $audit->response_file_attachments){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = json_encode($audit_data->response_file_attachments);
                $history->current = json_encode($audit->response_file_attachments);
                $history->activity_type = 'Response File Attachments';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->response_file_attachments) || $audit_data->response_file_attachments === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->approval_comments != $audit->approval_comments){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->approval_comments;
                $history->current = $audit->approval_comments;
                $history->activity_type = 'Approval Comments';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->approval_comments) || $audit_data->approval_comments === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->approval_attachments != $audit->approval_attachments){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = json_encode($audit_data->approval_attachments);
                $history->current = json_encode($audit->approval_attachments);
                $history->activity_type = 'Approval Attachments';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->approval_attachments) || $audit_data->approval_attachments === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->all_observation_closed != $audit->all_observation_closed){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->all_observation_closed;
                $history->current = $audit->all_observation_closed;
                $history->activity_type = 'All Observation Closed';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->all_observation_closed) || $audit_data->all_observation_closed === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->implementation_review_comments != $audit->implementation_review_comments){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->implementation_review_comments;
                $history->current = $audit->implementation_review_comments;
                $history->activity_type = 'Implementation Review Comments';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->implementation_review_comments) || $audit_data->implementation_review_comments === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->implementation_completed_on != $audit->implementation_completed_on){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->implementation_completed_on;
                $history->current = $audit->implementation_completed_on;
                $history->activity_type = 'Implementation Completed On';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->implementation_completed_on) || $audit_data->implementation_completed_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->audit_closure_report_issued_on != $audit->audit_closure_report_issued_on){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = $audit_data->audit_closure_report_issued_on;
                $history->current = $audit->audit_closure_report_issued_on;
                $history->activity_type = 'Audit Closure Report Issued On';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->audit_closure_report_issued_on) || $audit_data->audit_closure_report_issued_on === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

            if($audit_data->audit_closure_attachments != $audit->audit_closure_attachments){
                $history = new ContractTestingLabAuditTrail();
                $history->ctl_audit_id = $audit->id;
                $history->previous = json_encode($audit_data->audit_closure_attachments);
                $history->current = json_encode($audit->audit_closure_attachments);
                $history->activity_type = 'Audit Closure Attachments';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_from =   $audit_data->status;
                $history->change_to = "Not Applicable";
                if (is_null($audit_data->audit_closure_attachments) || $audit_data->audit_closure_attachments === '') {
                    $history->action_name = 'New';
                } else {
                    $history->action_name = 'Update';
                }
                $history->comment = "Not Applicable";
                $history->save();
            }

                toastr()->success("Record is created Successfully");
                return back();
         }


         //workflow

        public function CTL_Audit_send_stage(Request $request, $id){

            if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
                $audit_data = ContractTestingLabAudit::find($id);
                $lastDocument = ContractTestingLabAudit::find($id);

                if ($audit_data->stage == 1) {
                        $audit_data->stage = "2";
                        $audit_data->status = "CTL Audit Preparation";
                        $audit_data->submitted_by = Auth::user()->name;
                        $audit_data->submitted_on = Carbon::now()->format('d-M-Y');
                        $audit_data->submitted_comment = $request->comment;
                        $audit_data->save();

                        $history = new ContractTestingLabAuditTrail();
                        $history->ctl_audit_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = "";
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from = "Opened";
                        $history->change_to = "CTL Audit Preparation";
                        $history->action_name = "Submit";
                        $history->stage = 'Plan Approved';
                        $history->save();

                        return back();

                }

                elseif ($audit_data->stage == 2) {
                        $audit_data->stage = "3";
                        $audit_data->status = "CTL Audit Execution";
                        $audit_data->preparation_completed_by = Auth::user()->name;
                        $audit_data->preparation_completed_on = Carbon::now()->format('d-M-Y');
                        $audit_data->preparation_completed_comment = $request->comment;
                        $audit_data->save();

                        $history = new ContractTestingLabAuditTrail();
                        $history->ctl_audit_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = "";
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from = "CTL Audit Preparation";
                        $history->change_to = "CTL Audit Execution";
                        $history->action_name = "Submit";
                        $history->stage = 'Plan Approved';
                        $history->save();

                        return back();
                }

                elseif ($audit_data->stage == 3) {
                        $audit_data->stage = "4";
                        $audit_data->status = "CTL Audit Report Preparation & Approval";
                        $audit_data->completed_by = Auth::user()->name;
                        $audit_data->completed_on = Carbon::now()->format('d-M-Y');
                        $audit_data->completed_comment = $request->comment;
                        $audit_data->save();

                        $history = new ContractTestingLabAuditTrail();
                        $history->ctl_audit_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = "";
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from = "CTL Audit Execution";
                        $history->change_to = "CTL Audit Report Preparation & Approval";
                        $history->action_name = "Submit";
                        $history->stage = 'Plan Approved';
                        $history->save();

                        return back();
            }

                elseif ($audit_data->stage == 4) {
                        $audit_data->stage = "5";
                        $audit_data->status = "Under CTL Audit Report Issuance";
                        $audit_data->report_completed_by = Auth::user()->name;
                        $audit_data->report_completed_on = Carbon::now()->format('d-M-Y');
                        $audit_data->report_completed_comment = $request->comment;
                        $audit_data->save();

                        $history = new ContractTestingLabAuditTrail();
                        $history->ctl_audit_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = "";
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from = "CTL Audit Report Preparation & Approval";
                        $history->change_to = "Under CTL Audit Report Issuance";
                        $history->action_name = "Submit";
                        $history->stage = 'Plan Approved';
                        $history->save();

                        return back();
            }

                elseif ($audit_data->stage == 5) {
                        $audit_data->stage = "6";
                        $audit_data->status = "Pending CTL Response";
                        $audit_data->report_issued_by = Auth::user()->name;
                        $audit_data->report_issued_on = Carbon::now()->format('d-M-Y');
                        $audit_data->report_issued_comment = $request->comment;
                        $audit_data->save();

                        $history = new ContractTestingLabAuditTrail();
                        $history->ctl_audit_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = "";
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from = "Under CTL Audit Report Issuance";
                        $history->change_to = "Pending CTL Response";
                        $history->action_name = "Submit";
                        $history->stage = 'Plan Approved';
                        $history->save();

                        return back();
            }

                elseif ($audit_data->stage == 6) {
                        $audit_data->stage = "7";
                        $audit_data->status = "Under CTL Audit Compliance Acceptance";
                        $audit_data->response_received_by = Auth::user()->name;
                        $audit_data->response_received_on = Carbon::now()->format('d-M-Y');
                        $audit_data->response_received_comment = $request->comment;
                        $audit_data->save();

                        $history = new ContractTestingLabAuditTrail();
                        $history->ctl_audit_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = "";
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from = "Pending CTL Response";
                        $history->change_to = "Under CTL Audit Compliance Acceptance";
                        $history->action_name = "Submit";
                        $history->stage = 'Plan Approved';
                        $history->save();

                        return back();
            }

                elseif ($audit_data->stage == 7) {
                        $audit_data->stage = "8";
                        $audit_data->status = "CTL Audit Compliance Approval";
                        $audit_data->acceptance_completed_by = Auth::user()->name;
                        $audit_data->acceptance_completed_on = Carbon::now()->format('d-M-Y');
                        $audit_data->acceptance_completed_comment = $request->comment;
                        $audit_data->save();

                        $history = new ContractTestingLabAuditTrail();
                        $history->ctl_audit_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = "";
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from = "Under CTL Audit Compliance Acceptance";
                        $history->change_to = "CTL Audit Compliance Approval";
                        $history->action_name = "Submit";
                        $history->stage = 'Plan Approved';
                        $history->save();

                        return back();
                }

                elseif ($audit_data->stage == 8) {
                        $audit_data->stage = "9";
                        $audit_data->status = "Under Audit Compliance Monitoring";
                        $audit_data->approval_completed_by = Auth::user()->name;
                        $audit_data->approval_completed_on = Carbon::now()->format('d-M-Y');
                        $audit_data->approval_completed_comment = $request->comment;
                        $audit_data->save();

                        $history = new ContractTestingLabAuditTrail();
                        $history->ctl_audit_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = "";
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from = "CTL Audit Compliance Approval";
                        $history->change_to = "Under Audit Compliance Monitoring";
                        $history->action_name = "Submit";
                        $history->stage = 'Plan Approved';
                        $history->save();

                        return back();
                }

                elseif ($audit_data->stage == 9) {
                        $audit_data->stage = "10";
                        $audit_data->status = "CTL Audit Conclusion";
                        $audit_data->monitoring_completed_by = Auth::user()->name;
                        $audit_data->monitoring_completed_on = Carbon::now()->format('d-M-Y');
                        $audit_data->monitoring_completed_comment = $request->comment;
                        $audit_data->save();

                        $history = new ContractTestingLabAuditTrail();
                        $history->ctl_audit_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = "";
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from = "Under Audit Compliance Monitoring";
                        $history->change_to = "CTL Audit Conclusion";
                        $history->action_name = "Submit";
                        $history->stage = 'Plan Approved';
                        $history->save();

                        return back();
                }

                elseif ($audit_data->stage == 10) {
                        $audit_data->stage = "11";
                        $audit_data->status = "Close-Done";
                        $audit_data->conclusion_completed_by = Auth::user()->name;
                        $audit_data->conclusion_completed_on = Carbon::now()->format('d-M-Y');
                        $audit_data->conclusion_completed_comment = $request->comment;
                        $audit_data->save();

                        $history = new ContractTestingLabAuditTrail();
                        $history->ctl_audit_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = "";
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from = "CTL Audit Conclusion";
                        $history->change_to = "Close-Done";
                        $history->action_name = "Submit";
                        $history->stage = 'Plan Approved';
                        $history->save();

                        return back();
                }
             }

            else
            {
            toastr()->error('E-signature Not match');
                return back();
            }
        }

        public function CTL_Audit_cancel(Request $request, $id){

            if ($request->username == Auth::user()->email && Hash::check($request->password,  Auth::user()->password)) {
                $audit_data = ContractTestingLabAudit::find($id);
                $lastDocument = ContractTestingLabAudit::find($id);

             if ($audit_data->stage == 1) {
                    $audit_data->stage = "0";
                    $audit_data->status = "Closed-Cancelled";
                    $audit_data->cancelled_by = Auth::user()->name;
                    $audit_data->cancelled_on = Carbon::now()->format('d-M-Y');
                    $audit_data->cancelled_comment = $request->comment;
                    $audit_data->save();

                    $history = new ContractTestingLabAuditTrail();
                    $history->ctl_audit_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = "";
                    $history->current = "";
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from = "Opened";
                    $history->change_to = "Closed-Cancelled";
                    $history->action_name = "Submit";
                    $history->stage = 'Plan Approved';
                    $history->save();

                    return back();

              }
             }
                {
                    toastr()->error('E-signature Not match');
                    return back();
                }
            }


        public function CTL_Audit_reject(Request $request, $id){

                if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
                    $audit_data = ContractTestingLabAudit::find($id);
                    $lastDocument = ContractTestingLabAudit::find($id);

                    if ($audit_data->stage == 2) {
                            $audit_data->stage = "1";
                            $audit_data->status = "Opened";
                            $audit_data->open_state_by = Auth::user()->name;
                            $audit_data->open_state_on = Carbon::now()->format('d-M-Y');
                            $audit_data->open_state_comment = $request->comment;
                            $audit_data->save();

                            $history = new ContractTestingLabAuditTrail();
                            $history->ctl_audit_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->previous = "";
                            $history->current = "";
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->change_from = "CTL Audit Preparation";
                            $history->change_to = "Opened";
                            $history->action_name = "Submit";
                            $history->stage = 'Plan Approved';
                            $history->save();

                            return back();

                    }

                    elseif ($audit_data->stage == 3) {
                            $audit_data->stage = "2";
                            $audit_data->status = "CTL Audit Preparation";
                            $audit_data->audit_preparation_by = Auth::user()->name;
                            $audit_data->audit_preparation_on = Carbon::now()->format('d-M-Y');
                            $audit_data->audit_preparation_comment = $request->comment;
                            $audit_data->save();

                            $history = new ContractTestingLabAuditTrail();
                            $history->ctl_audit_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->previous = "";
                            $history->current = "";
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->change_from = "CTL Audit Execution";
                            $history->change_to = "CTL Audit Preparation";
                            $history->action_name = "Submit";
                            $history->stage = 'Plan Approved';
                            $history->save();

                            return back();
                    }

                    elseif ($audit_data->stage == 4) {
                            $audit_data->stage = "3";
                            $audit_data->status = "CTL Audit Execution";
                            $audit_data->audit_executed_by = Auth::user()->name;
                            $audit_data->audit_executed_on = Carbon::now()->format('d-M-Y');
                            $audit_data->audit_executed_comment = $request->comment;
                            $audit_data->save();

                            $history = new ContractTestingLabAuditTrail();
                            $history->ctl_audit_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->previous = "";
                            $history->current = "";
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->change_from = "CTL Audit Report Preparation & Approval";
                            $history->change_to = "CTL Audit Execution";
                            $history->action_name = "Submit";
                            $history->stage = 'Plan Approved';
                            $history->save();

                            return back();
                    }

                    elseif ($audit_data->stage == 5) {
                            $audit_data->stage = "4";
                            $audit_data->status = "CTL Audit Report Preparation & Approval";
                            $audit_data->report_prepared_by = Auth::user()->name;
                            $audit_data->report_prepared_on = Carbon::now()->format('d-M-Y');
                            $audit_data->report_prepared_comment = $request->comment;
                            $audit_data->save();

                            $history = new ContractTestingLabAuditTrail();
                            $history->ctl_audit_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->previous = "";
                            $history->current = "";
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->change_from = "Under CTL Audit Report Issuance";
                            $history->change_to = "CTL Audit Report Preparation & Approval";
                            $history->action_name = "Submit";
                            $history->stage = 'Plan Approved';
                            $history->save();

                            return back();
                    }

                    elseif ($audit_data->stage == 8) {
                            $audit_data->stage = "7";
                            $audit_data->status = "Under CTL Audit Compliance Acceptance";
                            $audit_data->compliance_accepted_by = Auth::user()->name;
                            $audit_data->compliance_accepted_on = Carbon::now()->format('d-M-Y');
                            $audit_data->compliance_accepted_comment = $request->comment;
                            $audit_data->save();

                            $history = new ContractTestingLabAuditTrail();
                            $history->ctl_audit_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->previous = "";
                            $history->current = "";
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->change_from = "CTL Audit Compliance Approval";
                            $history->change_to = "Under CTL Audit Compliance Acceptance";
                            $history->action_name = "Submit";
                            $history->stage = 'Plan Approved';
                            $history->save();

                            return back();
                    }

                    elseif ($audit_data->stage == 10) {
                            $audit_data->stage = "7";
                            $audit_data->status = "Under CTL Audit Compliance Acceptance";
                            $audit_data->audit_comp_accepted_by = Auth::user()->name;
                            $audit_data->audit_comp_accepted_on = Carbon::now()->format('d-M-Y');
                            $audit_data->audit_comp_accepted_comment = $request->comment;
                            $audit_data->save();

                            $history = new ContractTestingLabAuditTrail();
                            $history->ctl_audit_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->previous = "";
                            $history->current = "";
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->change_from = "CTL Audit Conclusion";
                            $history->change_to = "Under CTL Audit Compliance Acceptance";
                            $history->action_name = "Submit";
                            $history->stage = 'Plan Approved';
                            $history->save();

                            return back();
                    }

                 }

                else
                {
                toastr()->error('E-signature Not match');
                    return back();
                }
        }

        public function CTL_Audit_child(Request $request, $id){

            $audit_data = ContractTestingLabAudit::find($id);

            if ($request->child_type == 'audit_task'){

                //return redirect(route('violation.index'));
            }elseif($request->child_type1 == 'follow_up_task'){

                //return view('frontend.ctms.serious_adverse_event');
            }else{
                //return redirect(route('contract_testing_lab_audit.index')); 
            }

        }

        //Single Report Start

        public function CTL_auditSingleReport(Request $request, $id){

            $audit_data = ContractTestingLabAudit::find($id);
            //$users = User::all();
            $grid_DataA = ContractTestingLabAuditGrid::where(['ctl_audit_id' => $id, 'identifier' => 'auditee'])->first();
            $grid_DataK = ContractTestingLabAuditGrid::where(['ctl_audit_id' => $id, 'identifier' => 'key_personnel_met_during_audit'])->first();

                if (!empty($audit_data)) {
                    $audit_data->data = ContractTestingLabAuditGrid::where('ctl_audit_id', $id)->where('identifier', "auditee")->first();
                    $audit_data->data = ContractTestingLabAuditGrid::where('ctl_audit_id', $id)->where('identifier', "key_personnel_met_during_audit")->first();

                    $audit_data->originator = User::where('id', $audit_data->initiator_id)->value('name');
                    $audit_data->assign_to_gi = User::where('id', $audit_data->assigned_to)->value('name');
                    $pdf = App::make('dompdf.wrapper');
                    $time = Carbon::now();
                    $pdf = PDF::loadview('frontend.New_forms.contract_testing_lab_auditSingleReport', compact('audit_data','grid_DataA','grid_DataK'))
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
                    $canvas->page_text($width / 4, $height / 2, $audit_data->status, null, 25, [0, 0, 0], 2, 6, -20);
                    return $pdf->stream('CTL_Audit' . $id . '.pdf');
                }
        }

            //Audit Trail Start

        public function CTL_AuditTrial($id){

                $audit = ContractTestingLabAuditTrail::where('ctl_audit_id', $id)->orderByDESC('id')->paginate(5);
                // dd($audit);
                $today = Carbon::now()->format('d-m-y');
                $document = ContractTestingLabAudit::where('id', $id)->first();
                $document->originator = User::where('id', $document->initiator_id)->value('name');
                // dd($document);

                return view('frontend.New_forms.contract_testing_labAuditTrail',compact('document','audit','today'));
        }

            //Audit Trail Report Start

        public function CTL_AuditTrailPdf($id)
        {
                $doc = ContractTestingLabAudit::find($id);
                $doc->originator = User::where('id', $doc->initiator_id)->value('name');
                $data = ContractTestingLabAuditTrail::where('ctl_audit_id', $doc->id)->orderByDesc('id')->get();
                $pdf = App::make('dompdf.wrapper');
                $time = Carbon::now();
                $pdf = PDF::loadview('frontend.New_forms.contract_testing_labAuditTrailPdf', compact('data', 'doc'))
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
