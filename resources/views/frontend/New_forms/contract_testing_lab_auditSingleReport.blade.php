<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vidyagxp - Software</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }

    .w-10 {
        width: 10%;
    }

    .w-20 {
        width: 20%;
    }

    .w-25 {
        width: 25%;
    }

    .w-30 {
        width: 30%;
    }

    .w-40 {
        width: 40%;
    }

    .w-50 {
        width: 50%;
    }

    .w-60 {
        width: 60%;
    }

    .w-70 {
        width: 70%;
    }

    .w-80 {
        width: 80%;
    }

    .w-90 {
        width: 90%;
    }

    .w-100 {
        width: 100%;
    }

    .h-100 {
        height: 100%;
    }

    header table,
    header th,
    header td,
    footer table,
    footer th,
    footer td,
    .border-table table,
    .border-table th,
    .border-table td {
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 0.9rem;
        vertical-align: middle;
    }

    table {
        width: 100%;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    footer .head,
    header .head {
        text-align: center;
        font-weight: bold;
        font-size: 1.2rem;
    }

    @page {
        size: A4;
        margin-top: 160px;
        margin-bottom: 60px;
    }

    header {
        position: fixed;
        top: -140px;
        left: 0;
        width: 100%;
        display: block;
    }

    footer {
        width: 100%;
        position: fixed;
        display: block;
        bottom: -40px;
        left: 0;
        font-size: 0.9rem;
    }

    footer td {
        text-align: center;
    }

    .inner-block {
        padding: 10px;
    }

    .inner-block tr {
        font-size: 0.8rem;
    }

    .inner-block .block {
        margin-bottom: 30px;
    }

    .inner-block .block-head {
        font-weight: bold;
        font-size: 1.1rem;
        padding-bottom: 5px;
        border-bottom: 2px solid #4274da;
        margin-bottom: 10px;
        color: #4274da;
    }

    .inner-block th,
    .inner-block td {
        vertical-align: baseline;
    }

    .table_bg {
        background: #4274da57;
    }
</style>

<body>

    <header>
        <table>
            <tr>
                <td class="w-70 head">
                    CTL-Audit Single Report
                </td>
                <td class="w-30">
                    <div class="logo">
                        <img src="https://vidyagxp.com/vidyaGxp_logo.png" alt="" class="w-100">
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="w-30">
                    <strong>CTL-Audit No.</strong>{{ $audit_data->id }}
                </td>
                <td class="w-40">
                       {{ Helpers::getDivisionName($audit_data->division_id) }}/CTL_Audit/{{ Helpers::year($audit_data->created_at) }}/{{ str_pad($audit_data->record, 4, '0', STR_PAD_LEFT) }}
                    {{--{{ Helpers::divisionNameForQMS($study_data->division_id) }}/{{ Helpers::year($study_data->created_at) }}/{{ $study_data->record_number ? str_pad($study_data->record_number->record_number, 4, '0', STR_PAD_LEFT) : '' }}--}}
                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($audit_data->record, 4, '0', STR_PAD_LEFT) }}
                </td>
            </tr>
        </table>
    </header>

    <footer>
        <table>
            <tr>
                <td class="w-30">
                    <strong>Printed On :</strong> {{ date('d-M-Y') }}
                </td>
                <td class="w-40">
                    <strong>Printed By :</strong> {{ Auth::user()->name }}
                </td>
                {{--<td class="w-30">
                    <strong>Page :</strong> 1 of 1
                </td>--}}
            </tr>
        </table>
    </footer>

    <div class="inner-block">

         <div class="content-table">
            <div class="block">
                <div class="block-head">
                    Parent Record Information
                </div>

                <table>
                    <tr>
                        <th class="w-20">Audit Scheduled for the year</th>
                        <td class="w-30">{{ $audit_data->audit_scheduled_for_the_year }}</td>

                        <th class="w-20">CTL Audit Schedule No</th>
                        <td class="w-30">{{ $audit_data->ctl_audit_schedule_no }}</td>
                    </tr>
                </table>

                </div>
             </div>


        <div class="content-table">
            <div class="block">
                <div class="block-head">
                    General Information
                </div>
                <table>

                        <tr>
                            <th class="w-20">Record Number</th>
                            <td class="w-30">
                                @if ($audit_data->record)
                                    {{ str_pad($audit_data->record, 4, '0', STR_PAD_LEFT) }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                            <th class="w-20">Site/Location Code</th>
                            <td class="w-30">
                                @if ( Helpers::getDivisionName(session()->get('division')) )
                                {{ Helpers::getDivisionName(session()->get('division')) }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr> {{ $audit_data->created_at }} added by {{ $audit_data->originator }}
                            <th class="w-20">Initiator</th>
                            <td class="w-30">{{ $audit_data->originator }}</td>

                            <th class="w-20">Date of Initiation</th>
                            <td class="w-30">{{ Helpers::getdateFormat($audit_data->created_at) }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">Short Description</th>
                            <td class="w-30">
                                @if ($audit_data->short_description)
                                    {{ $audit_data->short_description }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                            <th class="w-20">Assign To</th>
                            <td class="w-80">{{ $audit_data->assign_to_gi }}</td>
                        </tr>

                        <tr>
                           <th class="w-20">Date Due</th>
                           <td class="w-80">{{ date('d-M-Y', strtotime($audit_data->due_date)) }}</td>

                           <th class="w-20">Name of Contract Testing Lab</th>
                           <td class="w-30">
                               @if ($audit_data->name_of_contract_testing_lab)
                                   {{ $audit_data->name_of_contract_testing_lab }}

                               @endif
                           </td>
                        </tr>
                    </table>

                    <table>
                        <tr>
                            <th class="w-10">Laboratory Address</th>
                            <td class="w-90">
                                @if ($audit_data->laboratory_address)
                                    {{ $audit_data->laboratory_address }}

                                @endif
                            </td>
                        </tr>
                    </table>

                    <table>

                      <tr>

                            <th class="w-20">Application Sites</th>
                            <td class="w-30">
                                @if ($audit_data->application_sites)
                                    {{ Helpers::getApplicationSites($audit_data->application_sites) }}

                                @endif
                            </td>

                            <th class="w-20">New Existing Laboratory</th>
                            <td class="w-30">
                                @if ($audit_data->new_existing_laboratory)
                                    {{ $audit_data->new_existing_laboratory }}

                                @endif
                            </td>
                      </tr>
                      <tr>
                          <th class="w-20">Date of Last Audit</th>
                            <td class="w-30">
                                @if ($audit_data->date_of_last_audit)
                                    {{ date('d-M-Y', strtotime($audit_data->date_of_last_audit)) }}

                                @endif
                            </td>
                          <th class="w-20">Audit Due On Month</th>
                            <td class="w-30">
                                @if ($audit_data->audit_due_on_month)
                                    {{ date('d-M-Y', strtotime($audit_data->audit_due_on_month)) }}

                                @endif
                            </td>

                        </tr>
                        <tr>
                            <th class="w-20">TCD For Audit Completion</th>
                            <td class="w-30">
                                @if ($audit_data->tcd_for_audit_completion)
                                    {{ date('d-M-Y', strtotime($audit_data->tcd_for_audit_completion)) }}

                                @endif
                            </td>

                            <th class="w-20">Audit Planing to be Done On</th>
                            <td class="w-30">
                                @if ($audit_data->audit_planing_to_be_done_on)
                                    {{ date('d-M-Y', strtotime($audit_data->audit_planing_to_be_done_on)) }}

                                @endif
                            </td>

                        </tr>

                        <tr>
                            <th class="w-20">Audit Request Communicated To</th>
                            <td class="w-30">
                                @if ($audit_data->audit_request_communicated_to)
                                    {{ $audit_data->audit_request_communicated_to }}

                                @endif
                            </td>

                            <th class="w-20">Proposed Audit Start Date</th>
                            <td class="w-30">
                                @if ($audit_data->proposed_audit_start_date)
                                    {{ date('d-M-Y', strtotime($audit_data->proposed_audit_start_date)) }}

                                @endif
                            </td>

                        </tr>

                        <tr>
                            <th class="w-20">Proposed Audit Completion</th>
                            <td class="w-30">
                                @if ($audit_data->proposed_audit_completion)
                                    {{ date('d-M-Y', strtotime($audit_data->proposed_audit_completion)) }}

                                @endif
                            </td>

                            <th class="w-20">Name of Lead Auditor</th>
                            <td class="w-30">
                                @if ($audit_data->name_of_lead_auditor)
                                    {{ Helpers::getLeadAuditorUserList1($audit_data->name_of_lead_auditor) }}

                                @endif
                            </td>

                        </tr>

                        <tr>
                            <th class="w-20">Name of Co-Auditor</th>
                            <td class="w-30">
                                @if ($audit_data->name_of_co_auditor)
                                    {{ Helpers::getCoAuditorUserList($audit_data->name_of_co_auditor) }}

                                @endif
                            </td>

                            <th class="w-20">External Auditor, if Applicable</th>
                            <td class="w-30">
                                @if ($audit_data->external_auditor_if_applicable)
                                    {{ $audit_data->external_auditor_if_applicable }}

                                @endif
                            </td>

                        </tr>

                        <tr>
                            <th class="w-20">Propose of Audit</th>
                            <td class="w-80">{{ $audit_data->propose_of_audit }}</td>

                            <th class="w-20">QA Approver</th>
                            <td class="w-80">{{ Helpers::getLeadAuditorUserList1($audit_data->qa_approver) }}</td>

                        </tr>
                    </table>

                    <table>
                        <tr>
                            <th class="w-20">Details of for Cause Audit</th>
                            <td class="w-80">{{ $audit_data->details_of_for_cause_audit }}</td>
                        </tr>
                    </table>

                    <table>
                        <tr>
                            <th class="w-20">Other Information (If Any)</th>
                            <td class="w-80">{{ $audit_data->other_information_gi }}</td>
                        </tr>
                    </table>

                </div>


                    <div class="content-table">
                        <div class="block">
                            <div class="block-head">
                                Cancellation
                            </div>

                        <table>
                            <tr>
                                <th class="w-20">Remarks</th>
                                <td class="w-80">{{ $audit_data->remarks }}</td>
                            </tr>
                        </table>
                        </div>
                    </div>

                    <div class="block">
                        <div class="block-head">
                            CTL Audit Preparation
                        </div>

                        <table>
                            <tr>
                                <th class="w-20">Audit Agenda</th>
                                <td class="w-80">{{ $audit_data->audit_agenda }}</td>
                            </tr>
                        </table>

                        <table>
                            <tr>
                                <th class="w-20">Audit Agenda Sent On</th>
                                <td class="w-30">{{ date('d-M-Y', strtotime($audit_data->audit_agenda_sent_on)) }}</td>

                                <th class="w-20">Audit Agenda Sent To</th>
                                <td class="w-30">{{ $audit_data->audit_agenda_sent_to }}</td>
                            </tr>
                        </table>

                        <table>
                            <tr>
                                <th class="w-20">Comments/Remarks</th>
                                <td class="w-80">{{ $audit_data->comments_remarks }}</td>
                            </tr>
                        </table>

                        <table>
                            <tr>
                                <th class="w-20">Communication & Others</th>
                                <td class="w-80">{{ $audit_data->communication_and_others }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="block">
                        <div class="block-head">
                            CTL Audit Execution
                        </div>

                        <table>
                            <tr>
                                <th class="w-20">CTL Audit Started On</th>
                                <td class="w-20">{{ date('d-M-Y', strtotime($audit_data->ctl_audit_started_on)) }}</td>

                                <th class="w-20">CTL Audit Completed On</th>
                                <td class="w-20">{{ date('d-M-Y', strtotime($audit_data->ctl_audit_completed_on)) }}</td>
                            </tr>
                        </table>

                        <table>
                            <tr>
                                <th class="w-20">Audit Execution Comments</th>
                                <td class="w-80">{{ $audit_data->audit_execution_comments }}</td>
                            </tr>

                            <tr>
                                <th class="w-20">Delay Justification Deviation</th>
                                <td class="w-80">{{ $audit_data->delay_justification_deviation }}</td>
                            </tr>
                        </table>

                        <table>
                            <tr>
                                <th class="w-20">Audit Enclosures</th>
                                <td class="w-80">{{ $audit_data->audit_enclosures }}</td>
                            </tr>
                        </table>
                    </div>


                    <div class="block">
                        {{-- <div class="block"> --}}
                        {{-- <div class="block-head"> --}}
                        <div style="font-weight: 200">Auditee</div>
                        {{-- </div> --}}
                        <div class="border-table">
                            <table>
                                <tr class="table_bg">
                                    <th class="w-10">Sr. No.</th>
                                    <th class="w-20">Name</th>
                                    <th class="w-20">Designation/Position</th>
                                </tr>

                                    @php
                                    $data = isset($grid_DataA) && $grid_DataA->data ? json_decode($grid_DataA->data, true) : null;
                                    @endphp
                                    @if ($data && is_array($data))
                                    @foreach ($data as $index => $item)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}.</td>
                                            <td>{{ isset($item['Name']) ? $item['Name'] : '' }}</td>
                                            <td>{{ isset($item['DesignationPosition']) ? $item['DesignationPosition'] : '' }}</td>
                                        </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td>Not Applicable</td>
                                        <td>Not Applicable</td>
                                        <td>Not Applicable</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        {{-- </div> --}}
                    </div>
                <div>

                    <div class="block">
                        {{-- <div class="block"> --}}
                        {{-- <div class="block-head"> --}}
                        <div style="font-weight: 200">Key Personnel Met During Audit</div>
                        {{-- </div> --}}
                        <div class="border-table">
                            <table>
                                <tr class="table_bg">
                                    <th class="w-10">Sr. No.</th>
                                    <th class="w-20">Name</th>
                                    <th class="w-20">Designation/Position</th>
                                </tr>

                                    @php
                                    $data = isset($grid_DataK) && $grid_DataK->data ? json_decode($grid_DataK->data, true) : null;
                                    @endphp
                                    @if ($data && is_array($data))
                                    @foreach ($data as $index => $item)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}.</td>
                                            <td>{{ isset($item['Name']) ? $item['Name'] : '' }}</td>
                                            <td>{{ isset($item['DesignationPosition']) ? $item['DesignationPosition'] : '' }}</td>
                                        </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td>Not Applicable</td>
                                        <td>Not Applicable</td>
                                        <td>Not Applicable</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        {{-- </div> --}}
                    </div>
                <div>


                    <div class="block">
                        <div class="block-head">
                            Observation/Non-Confirmances
                        </div>
                            <table>
                        <tr>
                            <th class="w-20">Critical</th>
                            <td class="w-80">{{ $audit_data->critical }}</td>

                            <th class="w-20">Major</th>
                            <td class="w-80">{{ $audit_data->major }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">Minor</th>
                            <td class="w-80">{{ $audit_data->minor }}</td>

                            <th class="w-20">Recomendations/Comments</th>
                            <td class="w-80">{{ $audit_data->recomendations_comments }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">Total</th>
                            <td class="w-80">{{ $audit_data->total }}</td>
                        </tr>

                    </table>
                </div>


                    <div class="block">
                        <div class="block-head">
                            Audit Summary
                        </div>
                        <table>
                            <tr>
                                <th class="w-20">Corrective Actions Agreed</th>
                                <td class="w-80">{{ $audit_data->corrective_actions_agreed }}</td>
                            </tr>

                            <tr>
                                <th class="w-20">Executive Summary</th>
                                <td class="w-80">{{ $audit_data->executive_summary }}</td>
                            </tr>

                            <tr>
                                <th class="w-20">Laboratory Acceptability</th>
                                <td class="w-80">{{ $audit_data->laboratory_acceptability }}</td>
                            </tr>

                            <tr>
                                <th class="w-20">Remarks & Conclusion</th>
                                <td class="w-80">{{ $audit_data->remarks_conclusion }}</td>
                            </tr>
                    </table>
                </div>

                <div class="block">
                    <div class="block-head">
                        Audit Report Details
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Audit Report Ref. No.</th>
                            <td class="w-30">{{ $audit_data->audit_report_ref_no }}</td>

                            <th class="w-20">Audit Report Signed On</th>
                            <td class="w-30">{{ date('d-M-Y', strtotime($audit_data->audit_report_signed_on)) }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">Audit Report Approved On</th>
                            <td class="w-30">{{ date('d-M-Y', strtotime($audit_data->audit_report_approved_on)) }}</td>

                            <th class="w-20">Supportive Documents</th>
                            <td class="w-30">{{ $audit_data->supportive_documents }}</td>
                        </tr>
                    </table>

                    <table>

                        <tr>
                            <th class="w-20">Delay Justification</th>
                            <td class="w-80">{{ $audit_data->delay_justification }}</td>
                        </tr>

                    </table>
            </div>

            <div class="block">
                <div class="block-head">
                    CTL Audit Report Issuance
                </div>

                <table>
                    <tr>
                        <th class="w-20">CTL Audit Report Issue Date</th>
                        <td class="w-30">{{ date('d-M-Y', strtotime($audit_data->ctl_audit_report_issue_date)) }}</td>

                        <th class="w-20">Audit Report Sent To CTL On</th>
                        <td class="w-30">{{ date('d-M-Y', strtotime($audit_data->audit_report_sent_to_ctl_on)) }}</td>
                    </tr>

                    <tr>
                        <th class="w-30">Audit Report Sent To</th>
                        <td class="w-20">{{ $audit_data->audit_report_sent_to }}</td>

                        <th class="w-30">Report Acknowledged On</th>
                        <td class="w-20">{{ date('d-M-Y', strtotime($audit_data->report_acknowledged_on)) }}</td>
                    </tr>

                    <tr>
                        <th class="w-30">TCD for Receipt of Compliance</th>
                        <td class="w-20">{{ date('d-M-Y', strtotime($audit_data->tcd_for_receipt_of_compliance)) }}</td>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th class="w-20">Other Information</th>
                        <td class="w-80">{{ $audit_data->other_information }}</td>
                    </tr>
                </table>

            </div>

            <div class="block">
                <div class="block-head">
                    Response Details
                </div>

                <table>
                    <tr>
                        <th class="w-20">Initial Response Received On</th>
                        <td class="w-30">{{ date('d-M-Y', strtotime($audit_data->initial_response_received_on)) }}</td>

                        <th class="w-20">Final Response Received On</th>
                        <td class="w-30">{{ date('d-M-Y', strtotime($audit_data->final_response_received_on)) }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Response Received Within TCD</th>
                        <td class="w-30">{{ $audit_data->response_received_within_tcd }}</td>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th class="w-30">Reason for Delayed Response</th>
                        <td class="w-20">{{ $audit_data->reason_for_delayed_response }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Comments</th>
                        <td class="w-80">{{ $audit_data->comments }}</td>

                    </tr>
                </table>
            </div>


            <div class="block">
                <div class="block-head">
                    CTL Audit Compliance Accept
                </div>

                <table>
                    <tr>
                        <th class="w-20">Response Review Comments</th>
                        <td class="w-80">{{ $audit_data->response_review_comments }}</td>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th class="w-20">Audit Task Required</th>
                        <td class="w-30">{{ $audit_data->audit_task_required }}</td>

                        <th class="w-20">Audit Task Ref. No</th>
                        <td class="w-30">{{ $audit_data->audit_task_ref_no }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Follow Up Task Required</th>
                        <td class="w-30">{{ $audit_data->follow_up_task_required }}</td>

                        <th class="w-20">Follow-Up Task Ref. No</th>
                        <td class="w-30">{{ $audit_data->follow_up_task_ref_no }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">TCD for Capa Implementation</th>
                        <td class="w-30">{{ $audit_data->tcd_for_capa_implementation }}</td>

                        <th class="w-20">Response Review</th>
                        <td class="w-30">{{ $audit_data->response_review }}</td>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th class="w-20">Reason For Disqualification</th>
                        <td class="w-80">{{ $audit_data->reason_for_disqualification }}</td>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th class="w-20">Requalification Frequency</th>
                        <td class="w-30">{{ $audit_data->requalification_frequency }}</td>

                        <th class="w-20">Next Audit Due Date</th>
                        <td class="w-30">{{ date('d-M-Y', strtotime($audit_data->next_audit_due_date)) }}</td>
                    </tr>
                </table>
            </div>


            <div class="block">
                <div class="block-head">
                    CTL Audit Compliance Approval
                </div>
                <table>
                    <tr>
                        <th class="w-20">Approval Comments</th>
                        <td class="w-80">{{ $audit_data->approval_comments }}</td>

                    </tr>
                </table>
           </div>

           <div class="block">
                <div class="block-head">
                    Capa Implementation Status
                </div>

            <table>
                <tr>
                    <th class="w-20">All Observation Closed</th>
                    <td class="w-80">{{ $audit_data->all_observation_closed }}</td>
                </tr>
            </table>

            <table>
                <tr>
                    <th class="w-20">Implementation Review Comments</th>
                    <td class="w-80">{{ $audit_data->implementation_review_comments }}</td>
                </tr>
            </table>

            <table>
                <tr>
                    <th class="w-20">Implementation Completed On</th>
                    <td class="w-30">{{ date('d-M-Y', strtotime($audit_data->implementation_completed_on)) }}</td>

                    <th class="w-20">Audit Closure Report Issued On</th>
                    <td class="w-30">{{ date('d-M-Y', strtotime($audit_data->audit_closure_report_issued_on)) }}</td>
                </tr>
            </table>
        </div>



</body>

</html>
