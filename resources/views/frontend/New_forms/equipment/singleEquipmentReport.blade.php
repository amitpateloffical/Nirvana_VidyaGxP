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
                    Equipment Single Report
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
                        <td class="w-30"> @if($data->assign_to){{($data->assign_to) }} @else Not Applicable @endif</td>
                        <th class="w-20">Date Due</th>
                        <td class="w-30">@if($data->assign_due_date){{ \Carbon\Carbon::parse($data->assign_due_date)->format('d-M-Y') }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-30">@if($data->division_code){{ $data->division_code }} @else Not Applicable @endif</td>
                        <!-- <th class="w-20"> Deviation Observed<</th>
                        <td class="w-30">@if($data->Deviation_date){{ $data->Deviation_date }} @else Not Applicable @endif</td> -->
                    </tr>
                    <tr>
                        <th class="w-20">Type</th>
                        <td class="w-30">@if($data->type == 1){{ $data->type == 1}} @else Not Applicable @endif</td>
                        <th class="w-20">Number (ID) </th>
                        <td class="w-30">@if($data->number_id){{ $data->number_id }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Site Name</th>
                        <td class="w-30">@if($data->site_name){{ $data->notify_type }} @else Not Applicable @endif</td>
                        <th class="w-20">Building</th>
                        <td class="w-30">@if($data->building){{ $data->building }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Floor</th>
                        <td class="w-30">@if($data->floor){{ ($data->floor) }} @else Not Applicable @endif</td>
                        <th class="w-20">Attached Files</th>
                        <td class="w-30">@if($data->file_attachment){{ $data->file_attachment }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Room</th>
                        <td class="w-30"> @if($data->rooms){{ $data->rooms }}@else Not Applicable @endif</td>
                        <th class="w-20">Description</th>
                        <td class="w-30"> @if($data->description){{ $data->description }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Attached Files</th>
                        <td class="w-30">@if($data->file_attachment){{ $data->file_attachment }}@else Not Applicable @endif</td>
                        <th class="w-20">Comments</th>
                        <td class="w-30">@if($data->comments){{ $data->comments }}@else Not Applicable @endif</td>
                    </tr>

                    <tr>
                        <th class="w-20">PM Frequency</th>
                        <td class="w-30">@if($data->pm_frequency){{ $data->pm_frequency }}@else Not Applicable @endif</td>
                        <th class="w-20">Calibration Frequency</th>
                        <td class="w-30">@if($data->calibration_frequency){{ $data->calibration_frequency }}@else Not Applicable @endif</td>
                    </tr>

                    <tr>
                        <th class="w-20">Preventive Maintenance Plan</th>
                        <td class="w-30">@if($data->preventive_maintenance_plan){{ $data->preventive_maintenance_plan }}@else Not Applicable @endif</td>
                        <th class="w-20">Calibration Information</th>
                        <td class="w-30">@if($data->calibration_information){{ $data->calibration_information }}@else Not Applicable @endif</td>
                    </tr>

                    <tr>
                        <th class="w-20">Next PM Date</th>
                        <td class="w-30">@if($data->next_pm_date){{\Carbon\Carbon::parse($data->next_pm_date)->format('d-M-Y') }}@else Not Applicable @endif</td>
                        <th class="w-20">Next Calibration Date</th>
                        <td class="w-30">@if($data->next_calibration_date){{\Carbon\Carbon::parse($data->next_calibration_date)->format('d-M-Y') }}@else Not Applicable @endif</td>
                    </tr>

                    <tr>
                        <th class="w-20">Maintenance History</th>
                        <td class="w-30">@if($data->maintenance_history){{ $data->maintenance_history }}@else Not Applicable @endif</td>
                        <!-- <th class="w-20">Refrence Link</th>
                        <td class="w-30">@if($data->reference_link){{ $data->reference_link }}@else Not Applicable @endif</td> -->
                    </tr>

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
                        <!-- Test Results -->
                    </div>
                    <table>
                        <!-- <tr>
                            <th class="w-30">Test Required?</th>
                            <td class="w-20">@if($data->test_required){{ $data->test_required }}@else Not Applicable @endif</td>
                        </tr>

                        <tr>
                            <th class="w-30">Test Start Date</th>
                            <td class="w-20">@if($data->test_start_date){{ $data->test_start_date }}@else Not Applicable @endif</td>
                        </tr>

                        <tr>
                            <th class="w-30">Test End Date</th>
                            <td class="w-20">@if($data->test_end_date){{ $data->test_end_date }}@else Not Applicable @endif</td>
                        </tr>

                        <tr>
                            <th class="w-30">Test Responsible</th>
                            <td class="w-20">@if($data->test_responsible){{ $data->test_responsible }}@else Not Applicable @endif</td>
                        </tr>

                        <tr>
                            <th class="w-30">Results Attachment</th>
                            <td class="w-20">@if($data->result_attachment){{ $data->result_attachment }}@else Not Applicable @endif</td>
                        </tr>

                        <tr>
                            <th class="w-30">Test Actions & Comments</th>
                            <td class="w-20">@if($data->test_action){{ $data->test_action }}@else Not Applicable @endif</td>
                        </tr> -->

                        <!-- <tr>
                            <th class="w-30">Results Attachment</th>
                            <td class="w-20">@if($data->result_attachment){{ $data->result_attachment }}@else Not Applicable @endif</td>
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
                        <th class="w-20">Submitted Protocol By</th>
                        <td class="w-30">{{ Auth::user()->name }}</td>
                        <th class="w-20">Submitted Protocol On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->created_at) }}</td>
                        <th class="w-20">Cancelled By</th>
                        {{-- <td class="w-30">{{ $data }}</td> --}}
                        <th class="w-20">Cancelled On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->cancelled_on) }}</td>
                        {{-- <td class="w-30">{{ $data }}</td> --}}
                    </tr>
                    <tr>
                        <th class="w-20">Review By</th>
                        <td class="w-30">{{ $data->cancelled_by}}</td>
                        <th class="w-20">Review On</th>
                        <!-- <td class="w-30">{{ Helpers::getdateFormat($data->cancelled_on) }}</td>
                        <th class="w-20">HOD Review Comments</th> -->
                        {{-- <td class="w-30">{{ $data-> }}</td> --}}
                    </tr>
                    <tr>
                        <th class="w-20">1st Final Approval By</th>
                        <td class="w-30">{{ $data->audit_observation_submitted_by }}</td>
                        <th class="w-20">1st Final Approval On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->audit_observation_submitted_on)  }}</td>
                        <th class="w-20">2nd Final Approval By</th>
                        {{-- <td class="w-30">{{ $data-> }}</td> --}}
                        <th class="w-20">2nd Final Approval On</th>
                        {{-- <td class="w-30">{{ $data-> }}</td> --}}
                        <th class="w-20">Report Reject By</th>
                        {{-- <td class="w-30">{{ $data-> }}</td> --}}
                        <th class="w-20">Report Reject On</th>
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


</body>

</html>