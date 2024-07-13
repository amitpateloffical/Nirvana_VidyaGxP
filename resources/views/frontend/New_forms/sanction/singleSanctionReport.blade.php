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
                    Sanction Single Report
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
                    {{ Helpers::divisionNameForQMS($data->division_id) }}/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
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
                {{-- <td class="w-30">
                    <strong>Page :</strong> 1 of 1
                </td> --}}
            </tr>
        </table>
    </footer>

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
                        <td class="w-30">{{ Helpers::getdateFormat($data->initiation_date) }}</td>
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
                        <td class="w-30">@if($data->short_description){{ $data->short_description }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Type</th>
                        <td class="w-30">@if($data->sanction_type){{ $data->sanction_type}} @else Not Applicable @endif</td>
                        <th class="w-20">File Attachments</th>
                        <td class="w-30">@if($data->file_attach){{ $data->file_attach }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Description</th>
                        <td class="w-30">@if($data->description){{ $data->description }} @else Not Applicable @endif</td>
                        <th class="w-20">Authority Type</th>
                        <td class="w-30">@if($data->authority_type){{ $data->authority_type }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Authority</th>
                        <td class="w-30">@if($data->authority){{ ($data->authority) }} @else Not Applicable @endif</td>
                        <th class="w-20">Fine</th>
                        <td class="w-30">@if($data->fine){{ $data->fine }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Currency</th>
                        <td class="w-30"> @if($data->currency){{ $data->currency }}@else Not Applicable @endif</td>
                        <!-- <th class="w-20">Renewal Rule</th>
                        <td class="w-30"> @if($data->renewal_rule){{ $data->renewal_rule }} @else Not Applicable @endif</td> -->
                    </tr>


                    <!-- <tr>
                        <th class="w-20">PSUP Cycle</th>
                        <td class="w-30">@if($data->psup_cycle){{ $data->psup_cycle }}@else Not Applicable @endif</td>
                        <th class="w-20">Expiration Date</th>
                        <td class="w-30">@if($data->expiration_date){{ $data->expiration_date }}@else Not Applicable @endif</td>
                    </tr> -->

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
                        <!-- <tr>
                            <th class="w-30">Approval Status</th>
                            <td class="w-20">@if($data->approval_status){{ $data->approval_status }}@else Not Applicable @endif</td>
                        </tr>

                        <tr>
                            <th class="w-30">Marketing Authorization Holder</th>
                            <td class="w-20">@if($data->marketing_authorization_holder){{ $data->marketing_authorization_holder }}@else Not Applicable @endif</td>
                        </tr>

                        <tr>
                            <th class="w-30">Planned Submission Date</th>
                            <td class="w-20">@if($data->planned_submission_date){{ $data->planned_submission_date }}@else Not Applicable @endif</td>
                        </tr>

                        <tr>
                            <th class="w-30">Planned Approval Date</th>
                            <td class="w-20">@if($data->planned_approval_date){{ $data->planned_approval_date }}@else Not Applicable @endif</td>
                        </tr>

                        <tr>
                            <th class="w-30">Actual Approval Date</th>
                            <td class="w-20">@if($data->actual_approval_date){{ $data->actual_approval_date }}@else Not Applicable @endif</td>
                        </tr>

                        <tr>
                            <th class="w-30">Actual Withdrawn Date</th>
                            <td class="w-20">@if($data->actual_withdrawn_date){{ $data->actual_withdrawn_date }}@else Not Applicable @endif</td>
                        </tr>

                        <tr>
                            <th class="w-30">Actual Rejection Date</th>
                            <td class="w-20">@if($data->actual_rejection_date){{ $data->actual_rejection_date }}@else Not Applicable @endif</td>
                        </tr>

                        <tr>
                            <th class="w-30">Comments</th>
                            <td class="w-20">@if($data->comments){{ $data->comments }}@else Not Applicable @endif</td>
                        </tr> -->
                    </table>


                </div>
            </div>


            <div class="block">
                <div class="block-head">
                    Signatures
                </div>
                <table>
                    <tr>
                        <!-- <th class="w-20">Started By</th>
                        <td class="w-20">{{ Auth::user()->name }}</td>
                        <th class="w-20">Started On</th>
                        <td class="w-20">{{ Helpers::getdateFormat($data->created_at) }}</td> -->
                        <th class="w-20">Submitted By</th>
                        <td class="w-20">{{ Auth::user()->name }}</td>
                        <th class="w-20">Submitted On</th>
                        <td class="w-20">{{ Helpers::getdateFormat($data->created_at) }}</td>
                        {{-- <td class="w-30">{{ $data }}</td> --}}
                    </tr>
                    <tr>
                        <th class="w-20">Closed By</th>
                        <td class="w-20">{{ Auth::user()->name }}</td>
                        <th class="w-20">Closed On</th>
                        <td class="w-20">{{ Helpers::getdateFormat($data->cancelled_on) }}</td>
                        <!-- <th class="w-20">HOD Review Comments</th> -->
                        {{-- <td class="w-30">{{ $data-> }}</td> --}}
                    </tr>
                    <tr>
                        <!-- <th class="w-20">Refused By</th>
                        <td class="w-30">{{ $data->audit_observation_submitted_by }}</td>
                        <th class="w-20">Refused On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->audit_observation_submitted_on)  }}</td>
                        <th class="w-20">Withdrawn By</th> -->
                        {{-- <td class="w-30">{{ $data-> }}</td> --}}
                        <!-- <th class="w-20">Withdrawn On</th> -->
                        {{-- <td class="w-30">{{ $data-> }}</td> --}}
                        <!-- <th class="w-20">Report Reject By</th> -->
                        {{-- <td class="w-30">{{ $data-> }}</td> --}}
                        <!-- <th class="w-20">Report Reject On</th> -->
                        {{-- <td class="w-30">{{ $data-> }}</td> --}}
                    </tr>


                </table>
            </div>
        </div>

    </div>

</body>

</html>