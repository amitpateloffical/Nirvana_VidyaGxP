<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VidyaGxP - Software</title>
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
                   CTA Submission Single Report
                </td>
                <td class="w-30">
                    <div class="logo">
                        <img src="https://navin.mydemosoftware.com/public/user/images/logo.png" alt="" class="w-100">
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="w-30">
                    <strong>CTA Submission No.</strong>
                </td>
                <td class="w-40">
                   {{ Helpers::divisionNameForQMS($data->division_id) }}/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                </td>
            </tr>
        </table>
    </header>

    <div class="inner-block">
        <div class="content-table">
            <div class="block">
                <div class="block-head">
                    CTA Submission
                </div>
                <table>
                    <tr>  {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">Record Number</th>
                        <td class="w-30">@if($data->record){{ $data->record }} @else Not Applicable @endif</td>
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-30">@if($data->division_code){{ $data->division_code }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ Helpers::getInitiatorName($data->initiator_id) }}</td>
                        <th class="w-20">Date Initiation</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->created_at) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Short Description</th>
                        <td class="w-80" colspan="3">
                            @if($data->short_description){{ $data->short_description }}@else Not Applicable @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Assigned To</th>
                        <td class="w-30">@if($data->assign_to){{ Helpers::getInitiatorName($data->assign_to) }} @else Not Applicable @endif</td>r>
                        <th class="w-20">Due Date</th>
                        <td class="w-80" colspan="3"> @if($data->due_date){{ $data->due_date }} @else Not Applicable @endif</td>
                    <tr>
                        <th class="w-20">Type</th>
                        <td class="w-30">@if($data->type){{ $data->type }}@else Not Applicable @endif</td>
                        <th class="w-20">Other Type</th>
                        <td class="w-30">@if($data->other_type){{ $data->other_type }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Description</th>
                        <td class="w-80">@if($data->description) {!!$data->description ? $data->description  : "Not Applicable"!!} @else Not Applicable @endif</td>
                    </tr>                
                </table>
                <div class="border-table">
                    <div class="block-head">
                        Attached Files, if any
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Batch No</th>
                        </tr>
                       
                        @if($data->attached_files)
                        @foreach(json_decode($data->attached_files) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                            </tr>
                        @endforeach
                        @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                    @endif
                      

                    </table>
                </div>
            </div>
            <div class="block">
                <div class="block-head">
                    Location
                </div>
                    <table>
                        <tr>
                            <th class="w-20">Zone</th>
                            <td class="w-80">@if($data->zone){{ $data->zone }}@else Not Applicable @endif</td>
                            <th class="w-20">Country</th>
                            <td class="w-80">@if($data->country){{ $data->country }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">City</th>
                            <td class="w-80">@if($data->city){{ $data->city }}@else Not Applicable @endif</td>
                            <th class="w-20">State/District</th>
                            <td class="w-80">@if($data->state_district){{ $data->state_district }}@else Not Applicable @endif</td>
                        </tr>
                    </table>
                    <div class="block-head">
                        Submission Information
                    </div>
                    <table> 
                    <tr>
                        <th class="w-20">Procedure Number</th>
                        <td class="w-80">@if($data->procedure_number){{ $data->procedure_number }}@else Not Applicable @endif</td>
                        <th class="w-20">Project Code</th>
                        <td class="w-80">@if($data->project_code){{ $data->project_code }}@else Not Applicable @endif</td>
                    </tr> 
                    <tr>
                        <th class="w-20">Authority Type</th>
                        <td class="w-80">@if($data->authority_type){{ $data->authority_type }}@else Not Applicable @endif</td>
                        <th class="w-20">Authority</th>
                        <td class="w-80">@if($data->authority){{ $data->authority }}@else Not Applicable @endif</td>
                    </tr> 
                    <tr>
                        <th class="w-20">Registration Number</th>
                        <td class="w-80">@if($data->registration_number){{ $data->registration_number }}@else Not Applicable @endif</td>
                        <th class="w-20">Other Authority</th>
                        <td class="w-80">@if($data->other_authority){{ $data->other_authority }}@else Not Applicable @endif</td>
                    </tr> 
                    <tr>
                        <th class="w-20">Year</th>
                        <td class="w-80">@if($data->year){{ $data->year }}@else Not Applicable @endif</td>
                        <th class="w-20">Procedure Type</th>
                        <td class="w-80">@if($data->procedure_type){{ $data->procedure_type }}@else Not Applicable @endif</td>
                    </tr> 
                    <tr>
                        <th class="w-20">Registration Status</th>
                        <td class="w-80">@if($data->registration_status){{ $data->registration_status }}@else Not Applicable @endif</td>
                        <th class="w-20">Outcome</th>
                        <td class="w-80">@if($data->outcome){{ $data->outcome }}@else Not Applicable @endif</td>
                    </tr> 
                    <tr>
                        <th class="w-20">Trade Name</th>
                        <td class="w-80">@if($data->trade_number){{ $data->trade_number }}@else Not Applicable @endif</td>
                        <th class="w-20">Comments</th>
                        <td class="w-80">@if($data->comments) {!!$data->comments ? $data->comments : 'Not Applicable'!!}@else Not Applicable @endif</td>
                    </tr> 
             </table>
             <div class="block-head">
                Product Information
            </div>
            <table>
            <tr>
                <th class="w-20">Manufacturer</th>
                <td class="w-80">@if($data->manufacturer){{ $data->manufacturer }}@else Not Applicable @endif</td>
            </tr> 
     </table>
     <div class="border-table mb-3">
        <div class="block-head">
            Product/Material
        </div>
        <table>
            <thead>
                <tr class="table_bg">
                    <th>Row#</th>
                    <th>Product Name</th>
                    <th>Batch Number</th>
                    <th>Manufactured Date</th>
                    <th>Expiry Date</th>
                    <th>Disposition</th>
                    <th>Comments</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>

            @if ($newData && is_array($newData))
                @foreach ($newData as $gridData)
                <tr>
                <td>{{ $loop->index+1 }}</td>
                <td>{{ isset($gridData['info_product_name']) ? $gridData['info_product_name'] : '' }}</td>
                <td>{{ isset($gridData['info_batch_number']) ? $gridData['info_batch_number'] : '' }}</td>
                <td>{{ isset($gridData['info_mfg_date']) ? $gridData['info_mfg_date'] : '' }}</td>
                <td>{{ isset($gridData['info_expiry_date']) ? $gridData['info_expiry_date'] : '' }}</td>
                <td>{{ isset($gridData['info_disposition']) ? $gridData['info_disposition'] : '' }}</td>
                <td>{{ isset($gridData['info_comments']) ? $gridData['info_comments'] : '' }}</td>
                <td>{{ isset($gridData['info_remarks']) ? $gridData['info_remarks'] : '' }}</td>
                </tr>
                @endforeach
                @else
                <tr>
                <td>1</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            @endif
            </tbody>
        </table>
    </div>
     <div class="block-head">
        Important Dates
    </div>
    <table>
     <tr>
        <th class="w-20">Actual Submission Date</th>
        <td class="w-80">@if($data->actual_submission_date){{ $data->actual_submission_date }}@else Not Applicable @endif</td>
        <th class="w-20">Actual Rejection Date</th>
        <td class="w-80">@if($data->actual_rejection_date){{ $data->actual_rejection_date }}@else Not Applicable @endif</td>
    </tr>
    <tr>
        <th class="w-20">Actual Withdrawn Date</th>
        <td class="w-80">@if($data->actual_withdrawn_date){{ $data->actual_withdrawn_date }}@else Not Applicable @endif</td>
        <th class="w-20">Inquiry Date</th>
        <td class="w-80">@if($data->inquiry_date){{ $data->inquiry_date }}@else Not Applicable @endif</td>
    </tr>
    <tr>
        <th class="w-20">Planned Submission Date</th>
        <td class="w-80">@if($data->planned_submission_date){{ $data->planned_submission_date }}@else Not Applicable @endif</td>
        <th class="w-20">Planned Date Sent To Affilate</th>
        <td class="w-80">@if($data->planned_date_sent_to_affilate){{ $data->planned_date_sent_to_affilate }}@else Not Applicable @endif</td>
    </tr>
    <tr>
        <th class="w-20">Effective Date</th>
        <td class="w-80">@if($data->effective_date){{ $data->effective_date }}@else Not Applicable @endif</td>
    </tr> 
</table>        
                </div>
            </div>
            <div class="block">
                <div class="block-head">
                    Persons Involved
                </div>
                    <table>
                        <tr>
                            <th class="w-20">Additional Assignees</th>
                            <td class="w-80">@if($data->additional_assignees){{ $data->additional_assignees }}@else Not Applicable @endif</td>
                            <th class="w-20">Additional Investigators</th>
                            <td class="w-80">@if($data->additional_investigators){{ $data->additional_investigators }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Approvers</th>
                            <td class="w-80">@if($data->approvers){{ $data->approvers }}@else Not Applicable @endif</td>
                            <th class="w-20">Negotiation Team</th>
                            <td class="w-80">@if($data->negotiation_team){{ $data->negotiation_team }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Trainer</th>
                            <td class="w-80">@if($data->trainer){{ $data->trainer }}@else Not Applicable @endif</td>
                        </tr> 
                    </table>
                </div>
                <div class="block">
                    <div class="block-head">
                        Root Cause Analysis
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Root Cause Description</th>
                            <td class="w-30">@if($data->root_cause_description){!!$data->root_cause_description ? $data->root_cause_description : "Not Applicable"!!}@else Not Applicable @endif</td>
                            <th class="w-20">Reason(s) For Non-Approval</th>
                            <td class="w-30">@if($data->reason_for_non_approval){!!$data->reason_for_non_approval ? $data->reason_for_non_approval : 'Not Applicable'!!}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Reason(s) For Withdrawal</th>
                            <td class="w-80">@if($data->reason_for_withdrawal){!!$data->reason_for_withdrawal ? $data->reason_for_withdrawal : 'Not Applicable'!!}@else Not Applicable @endif</td>
                            <th class="w-20">Justification/Rationale</th>
                            <td class="w-80">@if($data->justification_rationale){!!$data->justification_rationale ? $data->justification_rationale : 'Not Applicable'!!}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Meeting Minutes</th>
                            <td class="w-80">@if($data->meeting_minutes){!!$data->meeting_minutes ? $data->meeting_minutes : 'Not Applicable'!!}@else Not Applicable @endif</td>
                            <th class="w-20">Rejection Reason</th>
                            <td class="w-80">@if($data->rejection_reason){!!$data->rejection_reason ? $data->rejection_reason : 'Not Applicable'!!}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Effectiveness Check Summary</th>
                            <td class="w-80">@if($data->effectiveness_check_summary){!!$data->effectiveness_check_summary ? $data->effectiveness_check_summary : 'Not Applicable'!!}@else Not Applicable @endif</td>
                            <th class="w-20">Decisions</th>
                            <td class="w-80">@if($data->decisions){!!$data->decisions ? $data->decisions : 'Not Applicable'!!}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Summary</th>
                            <td class="w-80">@if($data->summary){!!$data->summary ? $data->summary : 'Not Applicable'!!}@else Not Applicable @endif</td>
                            <th class="w-20">Documents Affected</th>
                            <td class="w-80">@if($data->documents_affected){{ $data->documents_affected }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Actual Time Spent</th>
                            <td class="w-80">@if($data->actual_time_spent){{ $data->actual_time_spent }}@else Not Applicable @endif</td>
                            <th class="w-20">Documents</th>
                            <td class="w-80">@if($data->documents){{ $data->documents }}@else Not Applicable @endif</td>
                        </tr>
                    </table>
                </div>
            
                <div class="block">
                    <div class="block-head">
                        Signatures
                    </div>
                    <table>
                    <tr>
                        <th class="w-20">Submission By</th>
                        <td class="w-30">@if($data->submitted_by){{ $data->submitted_by }}@else Not Applicable @endif</td>
                        <th class="w-20">Submission On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->submitted_on) }}</td>
                        <th class="w-20">Submission Comment</th>
                        <td class="w-30">@if($data->submitted_comment){{ $data->submitted_comment }}@else Not Applicable @endif</td>
                    </tr>
                     <tr>
                        <th class="w-20">Approved By</th>
                        <td class="w-30">@if($data->approved_by){{ $data->approved_by }}@else Not Applicable @endif</td>
                        <th class="w-20">Approved On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->approved_on) }}</td>
                        <th class="w-20">Approved Comment</th>
                        <td class="w-30">@if($data->approved_comment){{ $data->approved_comment }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Withdraw By</th>
                        <td class="w-30">@if($data->withdraw_by){{ $data->withdraw_by }}@else Not Applicable @endif</td>
                        <th class="w-20">Withdraw On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->withdraw_on) }}</td>
                        <th class="w-20">Withdraw Comment</th>
                        <td class="w-30">@if($data->withdraw_comment){{ $data->withdraw_comment }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Finalize Dossier By</th>
                        <td class="w-30">@if($data->finalize_dossier_by){{ $data->finalize_dossier_by }}@else Not Applicable @endif</td>
                        <th class="w-20">Finalize Dossier On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->finalize_dossier_on) }}</td>
                        <th class="w-20">Finalize Dossier Comment</th>
                        <td class="w-30">@if($data->finalize_dossier_comment){{ $data->finalize_dossier_comment }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Notification By</th>
                        <td class="w-30">@if($data->notification_by){{ $data->notification_by }}@else Not Applicable @endif</td>
                        <th class="w-20">Notification On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->notification_on) }}</td>
                        <th class="w-20">Notification Comment</th>
                        <td class="w-30">@if($data->notification_comment){{ $data->notification_comment }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Cancelled By</th>
                        <td class="w-30">@if($data->cancelled_by){{ $data->cancelled_by }}@else Not Applicable @endif</td>
                        <th class="w-20">Cancelled On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->cancelled_on) }}</td>
                        <th class="w-20">Cancelled Comment</th>
                        <td class="w-30">@if($data->cancelled_comment){{ $data->cancelled_comment }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Not Approved By</th>
                        <td class="w-30">@if($data->not_approved_by){{ $data->not_approved_by }}@else Not Applicable @endif</td>
                        <th class="w-20">Not Approved On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->not_approved_on) }}</td>
                        <th class="w-20">Not Approved Comment</th>
                        <td class="w-30">@if($data->not_approved_comment){{ $data->not_approved_comment }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Approved with Conditions By</th>
                        <td class="w-30">@if($data->approved_with_conditions_by){{ $data->approved_with_conditions_by }}@else Not Applicable @endif</td>
                        <th class="w-20">Approved with Conditions On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->approved_with_conditions_on) }}</td>
                        <th class="w-20">Approved with Conditions Comment</th>
                        <td class="w-30">@if($data->approved_with_conditions_comment){{ $data->approved_with_conditions_comment }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Conditions to Fulfill Before FPI By</th>
                        <td class="w-30">@if($data->conditions_to_fulfill_before_FPI_by){{ $data->conditions_to_fulfill_before_FPI_by }}@else Not Applicable @endif</td>
                        <th class="w-20">Conditions to Fulfill Before FPI On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->conditions_to_fulfill_before_FPI_on) }}</td>
                        <th class="w-20">Conditions to Fulfill Before FPI Comment</th>
                        <td class="w-30">@if($data->conditions_to_fulfill_before_FPI_comment){{ $data->conditions_to_fulfill_before_FPI_comment }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">More Comments By</th>
                        <td class="w-30">@if($data->more_comments_by){{ $data->more_comments_by }}@else Not Applicable @endif</td>
                        <th class="w-20">More Comments On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->more_comments_on) }}</td>
                        <th class="w-20">More Comments Comment</th>
                        <td class="w-30">@if($data->more_comments_comment){{ $data->more_comments_comment }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Submit response By</th>
                        <td class="w-30">@if($data->submit_response_by){{ $data->submit_response_by }}@else Not Applicable @endif</td>
                        <th class="w-20">Submit response On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->submit_response_on) }}</td>
                        <th class="w-20">Submit response Comment</th>
                        <td class="w-30">@if($data->submit_response_comment){{ $data->submit_response_comment }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Early Termination By</th>
                        <td class="w-30">@if($data->early_termination_by){{ $data->early_termination_by }}@else Not Applicable @endif</td>
                        <th class="w-20">Early Termination On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->early_termination_on) }}</td>
                        <th class="w-20">Early Termination Comment</th>
                        <td class="w-30">@if($data->early_termination_comment){{ $data->early_termination_comment }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">All Conditions are met By</th>
                        <td class="w-30">@if($data->all_conditions_are_met_by){{ $data->all_conditions_are_met_by }}@else Not Applicable @endif</td>
                        <th class="w-20">All Conditions are met On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->all_conditions_are_met_on) }}</td>
                        <th class="w-20">All Conditions are met Comment</th>
                        <td class="w-30">@if($data->all_conditions_are_met_comment){{ $data->all_conditions_are_met_comment }}@else Not Applicable @endif</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <footer>
        <table>
            <tr>
                <td class="w-30">
                    <strong>Printed On :</strong> {{ date('d-M-Y') }}
                </td>
                <td class="w-40">
                    <strong>Printed By :</strong> {{ Auth::user()->name }}
                </td>
                {{--  <td class="w-30">
                    <strong>Page :</strong> 1 of 1
                </td>  --}}
            </tr>
        </table>
    </footer>

</body>

</html>
