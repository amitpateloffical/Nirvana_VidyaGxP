<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connexo - Software</title>
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
                    National-Approval Single Report
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
                    <strong> Audit No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::getDivisionName(session()->get('division'))}}/{{ Helpers::year($data->created_at)}}/{{str_pad($data->record, 4, '0', STR_PAD_LEFT)}}
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
                    General Information
                </div>
                <table>
                    <tr> {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ Helpers::getInitiatorName($data->initiator_id) }}</td>
                        <th class="w-20">Date of Initiation</th>
                        <td class="w-50">{{ Helpers::getdateFormat($data->initiation_date) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Assign To </th>
                        <td class="w-30"> @if($data->assign_to){{$data->assign_to}} @else Not Applicable @endif</td>
                        <th class="w-20">Date Due</th>
                        <td class="w-30">@if($data->due_date){{ \Carbon\Carbon::parse($data->due_date)->format('d-M-Y')}} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <!-- <th class="w-20">Site/Location Code</th>
                        <td class="w-30">@if($data->division_code){{ $data->division_code }} @else Not Applicable @endif</td> -->
                        <th class="w-20">Short Description</th>
                        <td class="w-100">@if($data->short_description){{ $data->short_description }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">(Root Parent) Manufacturer</th>
                        <td class="w-30">@if($data->manufacturer){{ $data->manufacturer}} @else Not Applicable @endif</td>
                        <th class="w-20">(Root Parent) Trade Name</th>
                        <td class="w-30">@if($data->trade_name){{ $data->trade_name }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">(Parent) Procedure Type</th>
                        <td class="w-30">@if($data->procedure_type){{ $data->procedure_type }} @else Not Applicable @endif</td>
                        <th class="w-20">Planned Subnission Date</th>
                        <td class="w-30">@if($data->planned_subnission_date){{ \Carbon\Carbon::parse($data->planned_subnission_date)->format('d-M-Y')}}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Member State</th>
                        <td class="w-30">@if($data->member_state){{ ($data->member_state) }} @else Not Applicable @endif</td>
                        <th class="w-20">Local Trade Name</th>
                        <td class="w-30">@if($data->local_trade_name){{ $data->local_trade_name }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Registration Number</th>
                        <td class="w-30"> @if($data->registration_number){{ $data->registration_number }}@else Not Applicable @endif</td>
                        <th class="w-20">Renewal Rule</th>
                        <td class="w-30"> @if($data->renewal_rule){{ $data->renewal_rule }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Dossier Parts</th>
                        <td class="w-100">@if($data->dossier_parts){{ $data->dossier_parts }}@else Not Applicable @endif</td>

                    </tr>
                    <tr>
                        <th class="w-20">Related Dossier Documents</th>
                        <td class="w-30">@if($data->related_dossier_documents){{ $data->related_dossier_documents }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Pack Size</th>
                        <td class="w-30">@if($data->pack_size){{ $data->pack_size }}@else Not Applicable @endif</td>
                        <th class="w-20">Shelf Life</th>
                        <td class="w-30">@if($data->shelf_life){{ $data->shelf_life }}@else Not Applicable @endif</td>
                    </tr>

                    <tr>
                        <th class="w-20">PSUP Cycle</th>
                        <td class="w-30">@if($data->psup_cycle){{ $data->psup_cycle }}@else Not Applicable @endif</td>
                        <th class="w-20">Expiration Date</th>
                        <td class="w-30">@if($data->expiration_date){{ $data->expiration_date }}@else Not Applicable @endif</td>
                    </tr>

                    <!-- <tr>
                        <th class="w-20">Next PM Date</th>
                        <td class="w-30">@if($data->next_pm_date){{ $data->next_pm_date }}@else Not Applicable @endif</td>
                        <th class="w-20">Next Calibration Date</th>
                        <td class="w-30">@if($data->next_calibration_date){{ $data->next_calibration_date }}@else Not Applicable @endif</td>
                    </tr> -->

                    <!-- <tr>
                        <th class="w-20">Maintenance History</th>
                        <td class="w-30">@if($data->maintenance_history){{ $data->maintenance_history }}@else Not Applicable @endif</td>
                        <th class="w-20">Refrence Link</th>
                        <td class="w-30">@if($data->reference_link){{ $data->reference_link }}@else Not Applicable @endif</td>
                    </tr> -->

                    <!-- <tr>
                        <th class="w-20">Additional Refrences</th>
                        <td class="w-30">@if($data->additional_references){{ $data->additional_references }}@else Not Applicable @endif</td>
                        <th class="w-20">Items Attachment</th>
                        <td class="w-30">@if($data->items_attachment){{ $data->items_attachment }}@else Not Applicable @endif</td>
                    </tr>

                    <tr>
                        <th class="w-20">Additional Attachment Items</th>
                        <td class="w-30">@if($data->addition_attachment_items){{ $data->addition_attachment_items }}@else Not Applicable @endif</td>
                        <th class="w-20">Data Successfully Closed?</th>
                        <td class="w-30">@if($data->data_successfully_type){{ $data->data_successfully_type }}@else Not Applicable @endif</td>
                    </tr>

                    <tr>
                        <th class="w-20">Document Summary</th>
                        <td class="w-30">@if($data->documents_summary){{ $data->additional_references }}@else Not Applicable @endif</td>
                        <th class="w-20">Document Comments</th>
                        <td class="w-30">@if($data->document_comments){{ $data->document_comments }}@else Not Applicable @endif</td>
                    </tr> -->

                    <!-- <tr>
                        <th class="w-20">Additional Refrences</th>
                        <td class="w-30">@if($data->additional_references){{ $data->additional_references }}@else Not Applicable @endif</td>
                        <th class="w-20">Items Attachment</th>
                        <td class="w-30">@if($data->items_attachment){{ $data->items_attachment }}@else Not Applicable @endif</td>
                    </tr> -->


                </table>

                <div class="block">
                    <div class="block-head">
                        Approval Plan
                    </div>
                    <table>
                        <tr>
                            <th class="w-30">Approval Status</th>
                            <td class="w-20">@if($data->approval_status){{ $data->approval_status }}@else Not Applicable @endif</td>
                        </tr>

                        <tr>
                            <th class="w-30">Marketing Authorization Holder</th>
                            <td class="w-20">@if($data->marketing_authorization_holder){{ $data->marketing_authorization_holder }}@else Not Applicable @endif</td>
                        </tr>

                        <tr>
                            <th class="w-30">Planned Submission Date</th>
                            <td class="w-20">@if($data->planned_submission_date){{ \Carbon\Carbon::parse($data->planned_submission_date)->format('d-M-Y') }}@else Not Applicable @endif</td>
                        </tr>

                        <tr>
                            <th class="w-30">Planned Approval Date</th>
                            <td class="w-20">@if($data->planned_approval_date){{ \Carbon\Carbon::parse($data->planned_approval_date)->format('d-M-Y') }}@else Not Applicable @endif</td>
                        </tr>

                        <tr>
                            <th class="w-30">Actual Approval Date</th>
                            <td class="w-20">@if($data->actual_approval_date){{ \Carbon\Carbon::parse($data->actual_approval_date)->format('d-M-Y') }}@else Not Applicable @endif</td>
                        </tr>

                        <tr>
                            <th class="w-30">Actual Withdrawn Date</th>
                            <td class="w-20">@if($data->actual_withdrawn_date){{ \Carbon\Carbon::parse($data->actual_withdrawn_date)->format('d-M-Y') }}@else Not Applicable @endif</td>
                        </tr>

                        <tr>
                            <th class="w-30">Actual Rejection Date</th>
                            <td class="w-20">@if($data->actual_rejection_date){{ \Carbon\Carbon::parse($data->actual_rejection_date)->format('d-M-Y') }}@else Not Applicable @endif</td>
                        </tr>

                        <tr>
                            <th class="w-30">Comments</th>
                            <td class="w-20">@if($data->comments){{ $data->comments }}@else Not Applicable @endif</td>
                        </tr>
                    </table>


                </div>
            </div>

            <div class="block">
                <div class="block-head">
                    Approval Plan
                </div>
                <table>

                    <!-- <tr>
                        <th class="w-20">Initial Deviation category</th>
                        <td class="w-30">@if($data->Deviation_category){{ ($data->Deviation_category) }}@else Not Applicable @endif</td>
                        <th class="w-20">Justification for categorization</th>
                        <td class="w-30">@if($data->Justification_for_categorization){{ $data->Justification_for_categorization }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Investigation Is required ?</th>
                        <td class="w-30">@if($data->Investigation_required){{ $data->Investigation_required }}@else Not Applicable @endif</td>
                        <th class="w-20">Relevant Guidelines / Industry Standards</th>
                        <td class="w-30">@if($data->Investigation_Details){{ $data->Investigation_Details }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Customer Notification Required ?</th>
                        <td class="w-30">@if($data->Customer_notification){{$data->Customer_notification}}@else Not Applicable @endif</td>
                        <th class="w-20">Customers</th>
                        <td class="w-30">@if($data->customers){{ $data->customers }}@else Not Applicable @endif</td>
                    </tr>

                    <tr>
                        <th class="w-20">QA Initial Remarks</th>
                        <td class="w-30">@if($data->QAInitialRemark){{$data->QAInitialRemark }}@else Not Applicable @endif</td>
                        
                    </tr> -->

                </table>
            </div>

            <div class="border-table">
                <!-- <div class="block-head">
                    QA Initial Attachments
                </div> -->
                <table>
                    <!-- 
                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Batch No</th>
                    </tr>
                        @if($data->Initial_attachment)
                        @foreach(json_decode($data->Initial_attachment) as $key => $file)
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
                    @endif -->

                </table>
            </div>


            <div class="block">
                <div class="head">
                    <!-- <div class="block-head">
                      CFT
                    </div> -->
                    <div class="head">
                        <!-- <div class="block-head">
                            Production
                        </div> -->
                        <table>

                            <!-- <tr>
                            
                                    <th class="w-20">Production Review Required ?
                                    </th>
                                    <td class="w-30">
                                        <div>
                                            @if($data->Production_Review){{ $data->Production_Review }}@else Not Applicable @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Production Person</th>
                                    <td class="w-30">
                                        <div>
                                            @if($data->Production_person){{ $data->Production_person }}@else Not Applicable @endif
                                        </div>
                                    </td>
                                </tr>
                                
                                
                                <tr>
                            
                                    <th class="w-20">Impact Assessment (By Production)</</th>
                                    <td class="w-30">
                                        <div>
                                            @if($data->Production_assessment){{ $data->Production_assessment }}@else Not Applicable @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Production Feedback</th>
                                    <td class="w-30">
                                        <div>
                                            @if($data->Production_feedback){{ $data->Production_feedback }}@else Not Applicable @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                            
                                    <th class="w-20">Production Review Completed By</th>
                                    <td class="w-30">
                                        <div>
                                            @if($data->Production_Review_Completed_By){{ $data->production_by }}@else Not Applicable @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Production Review Completed On</th>
                                    <td class="w-30">
                                        <div>
                                            @if($data->production_on){{ $data->production_on }}@else Not Applicable @endif
                                        </div>
                                    </td>
                                </tr>                                -->
                        </table>
                    </div>



                    <div class="block">
                        <!-- <div class="block-head">
                    QAH/Designee Approval
                </div> -->
                        <table>

                            <!-- <tr>
                        <th class="w-20">Closure Comments</th>
                        <td class="w-30">@if($data->Closure_Comments){{ $data->Closure_Comments }}@else Not Applicable @endif</td>
                        <th class="w-20">Disposition of Batch</th>
                        <td class="w-30">@if($data->Disposition_Batch){{ $data->Disposition_Batch }}@else Not Applicable @endif</td>
                         -->
                        </table>
                    </div>
                    <div class="border-table">
                        <!-- <div class="block-head">
                        Closure Attachments
                    </div> -->
                        <table>
                            <!-- 
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th> 
                            <th class="w-60">File </th>
                        </tr>
                            @if($data->closure_attachment)
                            @foreach(json_decode($data->closure_attachment) as $key => $file)
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
                        @endif -->

                        </table>
                    </div>
                </div>
            </div>


            <div class="block">
                <!-- <div class="block-head">
                Signatures
                </div> -->
                <table>
                    <tr>
                        <th class="w-20">Started By</th>
                        <td class="w-20">{{ Auth::user()->name }}</td>
                        <th class="w-20">Started On</th>
                        <td class="w-20">{{ Helpers::getdateFormat($data->created_at) }}</td>
                        <th class="w-20">Submitted By</th>
                        <td class="w-20">{{ Auth::user()->name }}</td>
                        <th class="w-20">Submitted On</th>
                        <td class="w-20">{{ Helpers::getdateFormat($data->created_at) }}</td>
                        {{-- <td class="w-30">{{ $data }}</td> --}}
                    </tr>
                    <tr>
                        <th class="w-20">Approved By</th>
                        <td class="w-30">{{ $data->cancelled_by}}</td>
                        <th class="w-20">Approved On</th>
                        <!-- <td class="w-30">{{ Helpers::getdateFormat($data->cancelled_on) }}</td>
                        <th class="w-20">HOD Review Comments</th> -->
                        {{-- <td class="w-30">{{ $data-> }}</td> --}}
                    </tr>
                    <tr>
                        <th class="w-20">Refused By</th>
                        <td class="w-30">{{ $data->audit_observation_submitted_by }}</td>
                        <th class="w-20">Refused On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->audit_observation_submitted_on)  }}</td>
                        <th class="w-20">Withdrawn By</th>
                        {{-- <td class="w-30">{{ $data-> }}</td> --}}
                        <th class="w-20">Withdrawn On</th>
                        {{-- <td class="w-30">{{ $data-> }}</td> --}}
                        <!-- <th class="w-20">Report Reject By</th> -->
                        {{-- <td class="w-30">{{ $data-> }}</td> --}}
                        <!-- <th class="w-20">Report Reject On</th> -->
                        {{-- <td class="w-30">{{ $data-> }}</td> --}}
                    </tr>
                    <!-- <tr>
                        <th class="w-20">QA Final Review Complete By</th>
                        <td class="w-30">{{ $data->audit_mgr_more_info_reqd_by }}</td>
                        <th class="w-20">QA Final Review Complete On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->audit_mgr_more_info_reqd_on) }}</td>
                        <th class="w-20">QA Final Review Comments</th>
                        {{-- <td class="w-30">{{ $data-> }}</td> --}}
                    </tr>
                    <tr>
                        <th class="w-20">Approved By</th>
                        <td class="w-30">{{ $data->audit_observation_submitted_by }}</td>
                        <th class="w-20">Approved ON</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->audit_observation_submitted_on) }}</td>
                        <th class="w-20">Approved Comments</th>
                        {{-- <td class="w-30">{{ $data-> }}</td> --}}
                   
 -->

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
                {{-- <td class="w-30">
                    <strong>Page :</strong> 1 of 1
                </td> --}}
            </tr>
        </table>
    </footer>

</body>

</html>