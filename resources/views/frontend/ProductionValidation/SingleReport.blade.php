<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vidyagxp - Software</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

@php
$users = DB::table('users')->get();
@endphp
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
                    First Production Validation Single Report
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
                    <strong>Internal Audit No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::divisionNameForQMS($data->division_id) }}/IA{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
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
                        <td class="w-30"> {{ Helpers::getInitiatorName($data->initiator_id) }}</td>
                        <th class="w-20">Date of Initiation</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->created_at) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Record Number</th>
                        <td class="w-30">
                            @if ($data->record)
                                {{ $data->record }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Division Id</th>
                        <td class="w-30">
                            @if ($data->division_id)
                                {{ $data->division_id }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Assigned To</th>
                        <td class="w-30">
                            @if ($data->assign_to)
                                {{ $data->assign_to }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Product</th>
                        <td class="w-30">
                            @if ($data->product)
                                {{ $data->product }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Short Description</th>
                        <td class="w-30">
                            @if ($data->short_description)
                                {{ $data->short_description }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Date Due </th>
                        <td class="w-30">
                            @if ($data->due_date)
                            {{ $data->due_date }}
                        @else
                            Not Applicable
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Type Of Product</th>
                        <td class="w-30">
                            @if ($data->product_type)
                                {{ $data->product_type }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Priority Level</th>
                        <td class="w-30">
                            @if ($data->priority_level)
                                {{ $data->priority_level }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Description</th>
                        <td class="w-30">
                            @if ($data->discription)
                                {{ $data->discription }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Comments</th>
                        <td class="w-30">
                            @if ($data->comments)
                            {{ $data->comments }}
                        @else
                            Not Applicable
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">

                            Related URL</th>
                        <td class="w-30">
                            @if ($data->related_record)
                                {{ $data->related_record }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Related Records</th>
                        <td class="w-30">
                            @if ($data->related_url)
                            {{ $data->related_url }}
                        @else
                            Not Applicable
                        @endif
                        </td>
                    </tr>
                    </tbody>
        </table>
        <div class="border-table">
            <div class="block-head">
                File Attachment
            </div>
            <table>
                <tr class="table_bg">
                    <th class="w-20">S.N.</th>
                    <th class="w-100">Batch No</th>
                </tr>
                @if ($data->inv_attachment)
                    @foreach (json_decode($data->inv_attachment) as $key => $file)
                        <tr>
                            <td class="w-20">{{ $key + 1 }}</td>
                            <td class="w-100">
                                <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                    <b>{{ $file }}</b>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="w-20">1</td>
                        <td class="w-100">Not Applicable</td>
                    </tr>
                @endif
            </table>
        </div>
            </div>
    <div class="inner-block">
        <div class="content-table">
            <div class="block">
                <div class="block-head">
                    Validation Information
                </div>
                <table>
                    <tr>
                        <th class="w-20">Sample Scheduled To</th>
                        <td class="w-30">{{ $data->start_date }}</td>
                        <th class="w-20">Sample details</th>
                        <td class="w-30">{{ $data->sample_details }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Sample Validation Summary</th>
                        <td class="w-30">{{ $data->validation_summary }}</td>
                        <th class="w-20">Send to external lab?</th>
                        <td class="w-30">{{ $data->externail_lab}}</td>

                    </tr>
                    <tr>
                        <th class="w-20">Lab Comments</th>
                        <td class="w-30">{{ $data->lab_commnets }}</td>
                        <th class="w-20">Product Release Summary</th>
                        <td class="w-30">{{ $data->product_release }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Product Recall Details</th>
                        <td class="w-30">{{ $data->product_recelldetails }}</td>


                </table>
            </div>
        </div>
    </div>
</table>






    <div class="inner-block">
        <div class="content-table">
            <div class="block">
                <div class="block-head">
                    Activity log
                </div>
                <table>
                    <tr>
                        <th class="w-20">Submit By</th>
                        <td class="w-30">{{ $data->acknowledge_by }}</td>
                        <th class="w-20">Submit On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->acknowledge_on) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Schedule & Send Sample
                            By</th>
                        <td class="w-30">{{ $data->Schedule_Send_Sample_by }}</td>
                        <th class="w-20">Schedule & Send Sample
                            On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->Schedule_Send_Sample_on) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Reject Sample By</th>
                        <td class="w-30">{{ $data->Reject_Sample_by }}</td>
                        <th class="w-20">Reject Sample On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->Reject_Sample_on) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Send For Analysis By</th>
                        <td class="w-30">{{ $data->Send_For_Analysis_by }}</td>
                        <th class="w-20">Send For Analysis On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->Send_For_Analysis_on) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Approve Sample By</th>
                        <td class="w-30">{{ $data->Approve_Sample_by }}</td>
                        <th class="w-20">Approve Sample On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->Approve_Sample_on) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Release By</th>
                        <td class="w-30">{{ $data->Release_by }}</td>
                        <th class="w-20">Release On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->Release_on) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Start Production By
                        </th>
                        <td class="w-30">{{ $data->audit_lead_more_info_reqd_by }}</td>
                        <th class="w-20">Start Production on</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->audit_lead_more_info_reqd_on) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Analyze By</th>
                        <td class="w-30">{{ $data->Analyzee_by }}</td>
                        <th class="w-20">Analyze On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->Analyzee_on) }}</td>
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
                {{-- <td class="w-30">
                    <strong>Page :</strong> 1 of 1
                </td> --}}
            </tr>
        </table>
    </footer>

</body>

</html>
