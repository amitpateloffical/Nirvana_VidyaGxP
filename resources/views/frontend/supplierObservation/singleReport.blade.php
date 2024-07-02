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
                   Supplier Observation Single Report
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
                    <strong>Supplier Observation No.</strong>
                </td>
                <td class="w-40">
                   {{ Helpers::divisionNameForQMS($data->division_id) }}/SO/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
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
                    Supplier Observation
                </div>
                <table>
                    <tr>  {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">Initiator</th>
                        <td class="w-80">{{ Helpers::getInitiatorName($data->initiator_id) }}</td>
                        <th class="w-20">Date Initiation</th>
                        <td class="w-80">{{ Helpers::getdateFormat($data->created_at) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Record Number</th>
                        <td class="w-80">@if($data->record){{ $data->record }} @else Not Applicable @endif</td>
                        <th class="w-20">Short Description</th>
                        <td class="w-80" colspan="3">
                            @if($data->short_description){{ $data->short_description }}@else Not Applicable @endif</td>
                    </tr>
                </table>
            </div>
            
            <div class="block">
                <table>
                    <tr>
                        <th class="w-20">Due Date</th>
                        <td class="w-80"> @if($data->due_date){{ $data->due_date }} @else Not Applicable @endif</td>
                        <th class="w-20">Assigned To</th>
                        <td class="w-80">@if($data->assign_to){{ Helpers::getInitiatorName($data->assign_to) }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Criticality</th>
                        <td class="w-80">@if($data->criticality){{ $data->criticality }}@else Not Applicable @endif</td>
                        <th class="w-20">Priority Level</th>
                        <td class="w-80">@if($data->priority_level){{ $data->priority_level }}@else Not Applicable @endif</td>
                    </tr>
                </table>
            </div>
            
            <div class="block">
                <table>
                    <tr>
                        <th class="w-20">Auditee</th>
                        <td class="w-80">@if($data->auditee){{ $data->auditee }}@else Not Applicable @endif</td>
                        <th class="w-20">Contact Person</th>
                        <td class="w-80">@if($data->contact_person){{ $data->contact_person }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Descriptions</th>
                        <td class="w-80">@if($data->descriptions){{ $data->descriptions }}@else Not Applicable @endif</td>
                    </tr>
                </table>
            </div>

            <div class="block">
                    <table>
                        <tr>
                            <th class="w-20">Manufacturer</th>
                            <td class="w-80">@if($data->manufacturer){{ $data->manufacturer }}@else Not Applicable @endif</td>
                            <th class="w-20">Type</th>
                            <td class="w-80">@if($data->type){{ $data->type }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Product/Materials</th>
                            <td class="w-80">@if($data->product){{ $data->product }}@else Not Applicable @endif</td>
                        </tr>
                    </table>
            </div> 
            
            <div class="border-table">
                <div class="block-head">
                    Attached File
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Batch No</th>
                    </tr>
                        @if($data->attached_file)
                        @foreach(json_decode($data->attached_file) as $key => $file)
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
            </div><br>
            <div class="border-table">
                <div class="block-head">
                    Attached Picture
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Batch No</th>
                    </tr>
                        @if($data->attached_picture)
                        @foreach(json_decode($data->attached_picture) as $key => $file)
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
            </div><br>

            <div class="block">
                <div class="block-head">
                    Actions
                </div>
                    <table>
                        <tr>
                            <th class="w-20">Proposed Action</th>
                            <td class="w-80">@if($data->proposed_actions){{ $data->proposed_actions }}@else Not Applicable @endif</td>
                            <th class="w-20">Comments</th>
                            <td class="w-80">@if($data->comments){{ $data->comments }}@else Not Applicable @endif</td>
                        </tr>
                    </table>
            </div>     
            
            
            <div class="block">
                <div class="block-head">
                    Impact Analysis
                </div>
                    <table>
                        <tr>
                            <th class="w-20">Impact</th>
                            <td class="w-80">@if($data->impact){{ $data->impact }}@else Not Applicable @endif</td>
                            <th class="w-20">Impact Analysis</th>
                            <td class="w-80">@if($data->impact_analysis){{ $data->impact_analysis }}@else Not Applicable @endif</td>
                        </tr>
                    </table>
            </div> 


            <div class="block">
                <div class="block-head">
                    Risk Analysis
                </div>
                    <table>
                        <tr>
                            <th class="w-20">Severity Rate</th>
                            <td class="w-80">@if($data->severity_rate){{ $data->severity_rate }}@else Not Applicable @endif</td>
                            <th class="w-20">Occurence</th>
                            <td class="w-80">@if($data->occurence){{ $data->occurence }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Detection</th>
                            <td class="w-80">@if($data->detection){{ $data->detection }}@else Not Applicable @endif</td>
                            <th class="w-20">RPN</th>
                            <td class="w-80">@if($data->rpn){{ $data->rpn }}@else Not Applicable @endif</td>
                        </tr>
                    </table>
            </div> 

            <div class="block">
                <div class="block-head">
                    Activity Log
                </div>
                <table>
                    <tr>
                        <th class="w-20">Report Issued By
                        </th>
                        <td class="w-30">{{ $data->report_issued_by }}</td>
                        <th class="w-20">
                            Report Issued On</th>
                        <td class="w-30">{{ $data->report_issued_on }}</td>
                        <th class="w-20">
                            Report Issued Comment</th>
                        <td class="w-30">{{ $data->report_issued_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Approval Received By
                        </th>
                        <td class="w-30">{{ $data->approval_received_by }}</td>
                        <th class="w-20">
                            Approval Received On</th>
                        <td class="w-30">{{ $data->approval_received_on }}</td>
                        <th class="w-20">
                            Approval Received Comment</th>
                        <td class="w-30">{{ $data->approval_received_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">All CAPA Closed By
                        </th>
                        <td class="w-30">{{ $data->all_capa_closed_by }}</td>
                        <th class="w-20">
                            All CAPA Closed On</th>
                        <td class="w-30">{{ $data->all_capa_closed_on }}</td>
                        <th class="w-20">
                            All CAPA Closed On</th>
                        <td class="w-30">{{ $data->all_capa_closed_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Approve By
                        </th>
                        <td class="w-30">{{ $data->approve_by }}</td>
                        <th class="w-20">
                            Approve On</th>
                        <td class="w-30">{{ $data->approve_on }}</td>
                        <th class="w-20">
                            Approve Comment</th>
                        <td class="w-30">{{ $data->approve_comment }}</td>
                    </tr>
                </table>
            </div>        

            </div>
        </div>
    </div>                



</body>
</html>    

