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
        font-family: 'Roboto', 'sans-serif';
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
        height: auto;
        resize: none;
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

    .Summer {
        font-weight: bold;
        font-size: 14px;
    }

    .bold-small {
        font-weight: bold;
        font-size: 14px;
        /* Adjust the size as needed */
    }
</style>


<body>

    <header>
        <table>
            <tr>
                <td class="w-70 head">
                    Additional Information Single Report
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
                    <strong>Additional Information No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::divisionNameForQMS($data->division_id) }}/AI/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
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
                <td class="w-30">
                    <strong>Page :</strong> 1 of 1
                </td>
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
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-30"> {{ Helpers::getDivisionName(session()->get('division')) }}</td>
                        <th class="w-20">(Parent) Date Opened</th>
                        <td class="w-30">
                            @if ($data->parent_date)
                                {{ \Carbon\Carbon::parse($data->parent_date)->format('d-M-Y') }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">(Parent) Market Complaint No.</th>
                        <td class="w-30">
                            @if ($data->market_complaint)
                                {{ $data->market_complaint }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">(Parent) Target Closure Date</th>
                        <td class="w-30">
                            @if ($data->due_date)
                                {{ \Carbon\Carbon::parse($data->due_date)->format('d-M-Y') }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Short Description</th>
                        <td class="w-80" colspan="3">
                            @if ($data->short_description)
                                {{ $data->short_description }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div class="block">
                <div class="head">
                    <div class="block-head">
                        General Information
                    </div>

                    <table>
                        <tr> {{ $data->created_at }} added by {{ $data->originator }}
                            <th class="w-20">Originator</th>
                            <td class="w-30">{{ Auth::user()->name }}</td>
                            <th class="w-20">Date of Initiation</th>
                            <td class="w-30">{{ Helpers::getdateFormat($data->created_at) }}</td>


                        </tr>
                        <tr>
                            <th class="w-20">Target Closure Date</th>
                            <td class="w-30">
                                @if ($data->closure_date)
                                    {{ \Carbon\Carbon::parse($data->closure_date)->format('d-M-Y') }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Short Description</th>
                            <td class="w-80" colspan="3">
                                @if ($data->Short)
                                    {{ $data->Short }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </table>
                    {{-- <tr>
                            <th class="w-20">
                                Description</th>
                            <td class="w-30">
                                @if ($data->description)
                                    {{ $data->description }}
                                @else
                                    Not Applicable
                                @endif
                            </td>


                        </tr> --}}
                    {{-- <label class="Summer" for="">Description</label>
                    <div>
                        @if ($data->description)
                            {!! $data->description !!}
                        @else
                            Not Applicable
                        @endif
                    </div> --}}
                    <div class="inner-block">
                        <label class="Summer" style="font-weight: bold; font-size: 14px;">Description
                        </label>
                        <div style="font-size: 0.9rem">
                            @if ($data->description)
                                {{ $data->description }}
                            @else
                                Not Applicable
                            @endif
                        </div>
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Assignee</th>
                            <td class="w-30">
                                @if ($data->assigned_to)
                                    {{ $data->assigned_to }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Initiating Department</th>
                            <td class="w-30">
                                @if ($data->initiating_department)
                                    {{ $data->initiating_department }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Initial Attachment</th>
                            <td class="w-30">
                                @if ($data->file_attach)
                                    {{ $data->file_attach }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="block">
                <div class="block-head">
                    Check Parameter

                </div>
                <table>
                    <tr>
                        <th class="w-20">Patient Age</th>
                        <td class="w-30">
                            @if ($data->patient_age)
                                {{ $data->patient_age }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                </table>

                {{-- <th class="w-20">Precription Details</th>
                <td class="w-30">
                    @if ($data->Precription_Details)
                        {{ $data->Precription_Details }}
                    @else
                        Not Applicable
                    @endif
                </td> --}}
                <div class="inner-block">
                    <label class="Summer" style="font-weight: bold; font-size: 14px;">Precription Details
                    </label>
                    <div style="font-size: 0.9rem">
                        @if ($data->Precription_Details)
                            {!! $data->Precription_Details !!}
                        @else
                            Not Applicable
                        @endif
                    </div>
                </div>


                {{-- <tr>
                    <th class="w-20">Pack Details</th>
                    <td class="w-30">
                        @if ($data->Pack_Details)
                            {{ $data->Pack_Details }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                </tr>
                <tr> --}}
                <div class="inner-block">
                    <label class="Summer" style="font-weight: bold; font-size: 14px;">Pack Details
                    </label>
                    <div style="font-size: 0.9rem">
                        @if ($data->Pack_Details)
                            {!! $data->Pack_Details !!}
                        @else
                            Not Applicable
                        @endif
                    </div>
                </div>

                {{-- <th class="w-20">Container Opening Date</th>
                <td class="w-30">
                    @if ($data->Container_Opening_Date)
                        {{ $data->Container_Opening_Date }}
                    @else
                        Not Applicable
                    @endif
                </td>
                </tr> --}}
                <div class="inner-block">
                    <label class="Summer" style="font-weight: bold; font-size: 14px;">Container Opening Date
                    </label>
                    <div style="font-size: 0.9rem">
                        @if ($data->Container_Opening_Date)
                            {!! $data->Container_Opening_Date !!}
                        @else
                            Not Applicable
                        @endif
                    </div>
                </div>
                <div class="inner-block">
                    <label class="Summer" style="font-weight: bold; font-size: 14px;">Storage Condition
                    </label>
                    <div style="font-size: 0.9rem">
                        @if ($data->Storage_Location)
                            {!! $data->Storage_Location !!}
                        @else
                            Not Applicable
                        @endif
                    </div>
                </div>
                {{-- <label class="Summer" for="">Storage Condition</label>
                <div>
                    @if ($data->Storage_Condition)
                        {!! $data->Storage_Condition !!}
                    @else
                        Not Applicable
                    @endif
                </div> --}}
                <div class="inner-block">
                    <label class="Summer" style="font-weight: bold; font-size: 14px;">Storage Location
                    </label>
                    <div style="font-size: 0.9rem">
                        @if ($data->Storage_Location)
                            {!! $data->Storage_Location !!}
                        @else
                            Not Applicable
                        @endif
                    </div>
                </div>
                {{-- <tr>
                    <th class="w-20"> Piercing Details</th>
                    <td class="w-30">
                        @if ($data->Piercing_Details)
                            {{ $data->Piercing_Details }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                </tr> --}}
                <div class="inner-block">
                    <label class="Summer" style="font-weight: bold; font-size: 14px;">Piercing Details
                    </label>
                    <div style="font-size: 0.9rem">
                        @if ($data->Piercing_Details)
                            {!! $data->Piercing_Details !!}
                        @else
                            Not Applicable
                        @endif
                    </div>
                </div>
                {{-- <tr>
                    <th class="w-20">Consuption Details-Product</th>
                    <td class="w-30">
                        @if ($data->Consuption_Details_Product)
                            {{ $data->Consuption_Details_Product }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                </tr> --}}
                <div class="inner-block">
                    <label class="Summer" style="font-weight: bold; font-size: 14px;">Consuption Details-Product
                    </label>
                    <div style="font-size: 0.9rem">
                        @if ($data->Consuption_Details_Product)
                            {!! $data->Consuption_Details_Product !!}
                        @else
                            Not Applicable
                        @endif
                    </div>
                </div>
                {{-- <tr>
                    <th class="w-20"> Complainant Medication History</th>
                    <td class="w-30">
                        @if ($data->Complainant_Medication_History)
                            {{ $data->Complainant_Medication_History }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                </tr> --}}
                <div class="inner-block">
                    <label class="Summer" style="font-weight: bold; font-size: 14px;">Complainant Medication History
                    </label>
                    <div style="font-size: 0.9rem">
                        @if ($data->Complainant_Medication_History)
                            {!! $data->Complainant_Medication_History !!}
                        @else
                            Not Applicable
                        @endif
                    </div>
                </div>
                {{-- <tr>
                    <th class="w-20">Other Medication</th>
                    <td class="w-30">
                        @if ($data->Other_Medication)
                            {{ $data->Other_Medication }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                </tr> --}}
                <div class="inner-block">
                    <label class="Summer" style="font-weight: bold; font-size: 14px;">Other Medication
                    </label>
                    <div style="font-size: 0.9rem">
                        @if ($data->Other_Medication)
                            {!! $data->Other_Medication !!}
                        @else
                            Not Applicable
                        @endif
                    </div>
                </div>

                <div class="inner-block">
                    <label class="Summer" style="font-weight: bold; font-size: 14px;">Other Details
                    </label>
                    <div style="font-size: 0.9rem">
                        @if ($data->Other_Details)
                            {{ $data->Other_Details }}
                        @else
                            Not Applicable
                        @endif
                    </div>
                </div>

                <div class="inner-block">
                    <label class="Summer" style="font-weight: bold; font-size: 14px;">Delay Justification
                    </label>
                    <div style="font-size: 0.9rem">
                        @if ($data->Delay_Justification)
                            {{ $data->Delay_Justification }}
                        @else
                            Not Applicable
                        @endif
                    </div>
                </div>
                <table>
                    <tr>
                        <th class="w-20">File Attachment</th>
                        <td class="w-30">
                            @if ($data->file_attachement)
                                {{ $data->file_attachement }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="block">
            <div class="block-head">
                Activity Log
            </div>
            <table>
                <tr>
                    <th class="w-20">Submited By</th>
                    <td class="w-30">{{ $data->Submitted_By }}</td>
                    <th class="w-20">Submited On</th>
                    <td class="w-30">{{ $data->Submitted_on }}</td>
                    <th class="w-20">Submited Comment</th>
                    <td class="w-30">{{ $data->Submitted_comment }}</td>
                </tr>
                <tr>
                    <th class="w-20">Cancel By</th>
                    <td class="w-30">{{ $data->cancel_by }}</td>
                    <th class="w-20">Cancel On</th>
                    <td class="w-30">{{ $data->cancel_on }}</td>
                    <th class="w-20">Cancel Comment</th>
                    <td class="w-30">{{ $data->Cancel_comment }}</td>
                </tr>
                <tr>
                    <th class="w-20">Execution Complete By
                    </th>
                    <td class="w-30">{{ $data->Execution_Complete_by }}</td>
                    <th class="w-20">Execution Complete On</th>
                    <td class="w-30">{{ $data->Execution_Complete_on }}</td>
                    <th class="w-20">Execution Complete Comment</th>
                    <td class="w-30">{{ $data->Execution_Complete_comment }}</td>
                </tr>
                <tr>
                    <th class="w-20">More Info request By
                    </th>
                    <td class="w-30">{{ $data->moreinformation_by }}</td>
                    <th class="w-20">More Info request On</th>
                    <td class="w-30">{{ $data->moreinformation_on }}</td>
                    <th class="w-20">More Info request Comment</th>
                    <td class="w-30">{{ $data->moreinformation_comment }}</td>
                </tr>
            </table>

        </div>
        {{-- </table> --}}

    </div>

    </div>



</body>

</html>
