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
    textarea {
        width: 100%;
        height: auto;
        border: none;
        resize: none;
        box-sizing: border-box;
        padding: 5px;
        margin: 0;

        font-family: 'Roboto', 'sans-sarif';
    }
</style>

<body>

    <header>
        <table>
            <tr>
                <td class="w-70 head">
                    Follow Up Task Single Report
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
                    <strong>Field Inquiry No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::divisionNameForQMS($data->division_id) }}/{{ Helpers::year($data->created_at) }}/FU/{{ str_pad($data->record_number, 4, '0', STR_PAD_LEFT) }}
                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($data->record_number, 4, '0', STR_PAD_LEFT) }}
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
                        <td class="w-30">{{ $data->originator }}</td>
                        <th class="w-20">Date Opened</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->created_at) }}</td>
                    </tr>
                    <tr>

                        <th class="w-20">(Parent) Date Opened</th>

                         <td class="w-30">@if($data->parent_date)
                                        {{ $data->parent_date }}
                                        @else Not Applicable @endif
                        </td>


                        <th class="w-20">Assigned To</th>
                        <td class="w-30">
                            @if ($data->assigned_to)
                                {{ Helpers::getInitiatorName($data->assigned_to) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">(Parent) Observation</th>
                        <td class="w-30">
                            @if ($data->Parent_observation)
                                {{ $data->Parent_observation}}
                            @else
                                Not Applicable
                            @endif
                        </td>


                        <th class="w-20">(Parent) Classification</th>
                        <td class="w-30">
                            @if ($data->parent_classification)
                                {{ $data->parent_classification }}
                            @else
                                Not Applicable
                            @endif
                        </td>


                    </tr>
                    <tr>
                        <th class="w-20">(Parent) CAPA Taken/Proposed</th>
                        <td class="w-30">
                            @if ($data->capa_taken)
                                {{ $data->capa_taken }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">(Parent) TCD for Closure of Audit Task</th>
                        <td class="w-30">
                            @if ($data->tcd_date)
                                {{ $data->tcd_date }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>

                    <tr>

                        <th class="w-20">Short Description</th>
                        <td class="w-30" >
                            @if ($data->short_description)
                                {{ $data->short_description }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Record Number</th>
                        <td class="w-30">@if($data->record_number){{ str_pad($data->record_number, 4, '0', STR_PAD_LEFT) }} @else Not Applicable @endif</td>


                    </tr>

                    <tr>
                        <th class="w-20">Division Code</th>
                        <td class="w-30" >
                            @if ($data->division_code)
                                {{ $data->division_code}}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Date Due</th>
                        <td class="w-30">
                            @if ($data->due_date)
                                {{ $data->due_date}}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>


                    <tr>
                        <th class="w-20">Follow-up Task Description</th>
                        <td class="w-30">
                            @if ($data->followup_Desc)
                                {{ $data->followup_Desc }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Compliance Execution Details</th>
                        <td class="w-30">
                            @if ($data->execution_details)
                                {{ $data->execution_details }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        </tr>



                        <tr>
                            <th class="w-20">Date of Completion</th>
                            <td class="w-30">
                                @if ($data->completion_date)
                                    {{ $data->completion_date }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                            <th class="w-20">Delay Justification</th>
                            <td class="w-30">
                                @if ($data->delay_justification)
                                    {{ $data->delay_justification }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>


                        <tr>
                            <th class="w-20">Verification Comments</th>
                            <td class="w-30">
                                @if ($data->varification_comments)
                                    {{ $data->varification_comments }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                            <th class="w-20">Cancellation Remarks</th>
                            <td class="w-30">
                                @if ($data->cancellation_remarks)
                                    {{ $data->cancellation_remarks }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </tr>

                </table>
            </div>

            <div class="block">
                <div class="head">

                    <table>

                        <tr>
                            <th class="w-20">Attached File</th>
                            <td class="w-30">
                                @if ($data->file_attachment)
                                    <a href="{{ asset('upload/document/', $data->file_attachment) }}">
                                        {{ $data->file_attachment }}</a>
                                @else
                                    Not Applicable
                                @endif
                            </td>

                        </tr>

                        <tr>
                            <th class="w-20">Execution Attachment</th>
                            <td class="w-30">
                                @if ($data->execution_attachment)
                                    <a href="{{ asset('upload/document/', $data->execution_attachment) }}">
                                        {{ $data->execution_attachment }}</a>
                                @else
                                    Not Applicable
                                @endif
                            </td>

                        </tr>

                        <tr>
                            <th class="w-20">Verification Attachment</th>
                            <td class="w-30">
                                @if ($data->verification_attachment)
                                    <a href="{{ asset('upload/document/', $data->verification_attachment) }}">
                                        {{ $data->verification_attachment }}</a>
                                @else
                                    Not Applicable
                                @endif
                            </td>

                        </tr>

                    </table>
                </div>
            </div>

            <div class="block">
                {{-- <div class="block-head">
                    Activity Log
                </div> --}}
                <div class="block-head">General Information</div>
                <table>
                    <tr>
                        <th class="w-20"> Submitted By</th>
                        <td class="w-30">{{ $data->submitted_by }}</td>
                        <th class="w-20"> Submitted On</th>
                        <td class="w-30">{{ $data->submitted_on }}</td>
                        <th class="w-20">Comment</th>
                        <td class="w-30">{{ $data->comment }}</td>
                    </tr>


                    <tr>
                        <th class="w-20">Cancellation Request By</th>
                        <td class="w-30">{{ $data->cancel_by }}</td>
                        <th class="w-20">Cancellation Request On</th>
                        <td class="w-30">{{ $data->cancel_on}}</td>
                        <th class="w-20">Comment</th>
                        <td class="w-30">{{ $data->cancellation_comment }}</td>

                    </tr>
                    <tr>
                        <th class="w-20">Compliance Received By</th>
                        <td class="w-30">{{ $data->compliance_by }}</td>
                        <th class="w-20">Compliance Received On</th>
                        <td class="w-30">{{ $data->compliance_on }}</td>
                        <th class="w-20">Comment</th>
                        <td class="w-30">{{ $data->compliance_comment}}</td>

                    </tr>
                    <tr>
                        <th class="w-20">More Info from Open State By</th>
                        <td class="w-30">{{ $data->open_state_by }}</td>
                        <th class="w-20">Compliance Received On</th>
                        <td class="w-30">{{ $data->open_state_on }}</td>
                        <th class="w-20">Comment</th>
                        <td class="w-30">{{ $data->open_state_comment}}</td>

                    </tr>

                    <tr>
                        <th class="w-20">Verification Complete By</th>
                        <td class="w-30">{{ $data->varification_by }}</td>
                        <th class="w-20">Verification Complete On</th>
                        <td class="w-30">{{ $data->varification_on }}</td>
                        <th class="w-20">Comment</th>
                        <td class="w-30">{{ $data->varification_comment}}</td>

                    </tr>

                    <tr>
                        <th class="w-20">More Info from Compliance in Progress By</th>
                        <td class="w-30">{{ $data->progress_by }}</td>
                        <th class="w-20">More Info from Compliance in Progress On</th>
                        <td class="w-30">{{ $data->progress_on }}</td>
                        <th class="w-20">Comment</th>
                        <td class="w-30">{{ $data->progress_comment}}</td>

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
                <td class="w-30">
                    <strong>Page :</strong> 1 of 1
                </td>
            </tr>
        </table>
    </footer>

</body>

</html>
