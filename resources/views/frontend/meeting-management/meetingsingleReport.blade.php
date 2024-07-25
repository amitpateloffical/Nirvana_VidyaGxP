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
                    Meeting Management Single Report
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
                    <strong>Meeting Management No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::divisionNameForQMS($data->division_id) }}/MM/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
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
                    General Information
                </div>
                <table>
                    <tr> {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ Auth::user()->name }}</td>
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-30"> {{ Helpers::getDivisionName(session()->get('division')) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Date of Initiation</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->created_at) }}</td>
                        <th class="w-20">Assigned To</th>
                        <td class="w-30">
                            @if ($data->assigned_to)
                                {{ $data->assigned_to }}
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
                    <tr>
                        <th class="w-20">Due Date</th>
                        <td class="w-30">
                            @if ($data->due_date)
                                {{ \Carbon\Carbon::parse($data->due_date)->format('d-M-Y') }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Initiator Group</th>
                        <td class="w-30">
                            @if ($data->initiator_group)
                                {{ $data->initiator_group }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Initiator Group Code</th>
                        <td class="w-30">
                            @if ($data->initiator_group_code)
                                {{ $data->initiator_group_code }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Type</th>
                        <td class="w-40 description-cell" colspan="3">
                            @if ($data->type)
                                {{ $data->type }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    {{--  <tr>
                        <th class="w-20">Supporting Documents</th>
                        <td class="w-80" colspan="3">Document_Name.pdf</td>
                    </tr>  --}}
                    <tr>
                        <th class="w-20">Priority Level
                        </th>
                        <td class="w-30">
                            @if ($data->priority_level)
                                {{ $data->priority_level }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Scheduled Start Date</th>
                        <td class="w-30">
                            @if ($data->start_date)
                                {{ \Carbon\Carbon::parse($data->start_date)->format('d-M-Y') }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                    <tr>
                        <th class="w-20">Scheduled end Date</th>
                        <td class="w-30">
                            @if ($data->end_date)
                                {{ \Carbon\Carbon::parse($data->end_date)->format('d-M-Y') }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">File Attachment</th>
                        <td class="w-30">
                            @if ($data->Attached_File)
                                {{ $data->Attached_File }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
                {{-- <tr>
                        <th class="w-20">Attendess</th>
                        <td class="w-30">
                            @if ($data->attendees)
                                {{ $data->attendees }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> --}}
                <div class="inner-block">
                    <label class="Summer" style="font-weight: bold; font-size: 14px;">Attendess</label>
                    <div style="font-size: 0.9rem">
                        @if ($data->attendees)
                            {{ $data->attendees }}
                        @else
                            Not Applicable
                        @endif
                    </div>
                </div>

                {{-- <tr>
                    <th class="w-20">Description</th>
                    <td class="w-30">
                        @if ($data->description)
                            {{ $data->description }}
                        @else
                            Not Applicable
                        @endif
                    </td>

                </tr> --}}
                <div class="inner-block">
                    <label class="Summer" style="font-weight: bold; font-size: 14px;">Description</label>
                    <div style="font-size: 0.9rem">
                        @if ($data->description)
                            {{ $data->description }}
                        @else
                            Not Applicable
                        @endif
                    </div>
                </div>

            </div>

            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Operational Planning & Control
                    </div>


                    {{-- <tr>
                        <th class="w-20">Operations</th>
                        <td class="w-30">
                            @if ($data->operations)
                                {{ $data->operations }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr> --}}
                    <div class="inner-block">
                        <label class="Summer" style="font-weight: bold; font-size: 14px;">Operations</label>
                        <div style="font-size: 0.9rem">
                            @if ($data->operations)
                                {{ $data->operations }}
                            @else
                                Not Applicable
                            @endif
                        </div>
                    </div>
                    {{-- <tr>
                        <th class="w-20">Requirements for Products and Services </th>
                        <td class="w-30">
                            @if ($data->Requirements_for_Products)
                                {{ $data->Requirements_for_Products }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> --}}
                    <div class="inner-block">
                        <label class="Summer" style="font-weight: bold; font-size: 14px;">Requirements for Products and
                            Services </label>
                        <div style="font-size: 0.9rem">
                            @if ($data->Requirements_for_Products)
                                {{ $data->Requirements_for_Products }}
                            @else
                                Not Applicable
                            @endif
                        </div>
                    </div>
                    {{-- <tr>
                        <th class="w-20">Design and Development of Products and Services</th>
                        <td class="w-30">
                            @if ($data->Design_and_Development)
                                {{ $data->Design_and_Development }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> --}}
                    <div class="inner-block">
                        <label class="Summer" style="font-weight: bold; font-size: 14px;">Design and Development of
                            Products and Services</label>
                        <div style="font-size: 0.9rem">
                            @if ($data->Design_and_Development)
                                {{ $data->Design_and_Development }}
                            @else
                                Not Applicable
                            @endif
                        </div>
                    </div>
                    {{-- <tr>
                        <th class="w-20">Control of Externally Provided Processes, Products and Services </th>
                        <td class="w-30">
                            @if ($data->Control_of_Externally)
                                {{ $data->Control_of_Externally }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> --}}
                    <div class="inner-block">
                        <label class="Summer" style="font-weight: bold; font-size: 14px;">Control of Externally Provided
                            Processes, Products and Services</label>
                        <div style="font-size: 0.9rem">
                            @if ($data->Control_of_Externally)
                                {{ $data->Control_of_Externally }}
                            @else
                                Not Applicable
                            @endif
                        </div>
                    </div>
                    {{-- <tr>
                        <th class="w-20">
                            Production and Service Provision</th>
                        <td class="w-30">
                            @if ($data->Production_and_Service)
                                {{ $data->Production_and_Service }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr> --}}
                    <div class="inner-block">
                        <label class="Summer" style="font-weight: bold; font-size: 14px;">Production and Service
                            Provision</label>
                        <div style="font-size: 0.9rem">
                            @if ($data->Production_and_Service)
                                {{ $data->Production_and_Service }}
                            @else
                                Not Applicable
                            @endif
                        </div>
                    </div>
                    {{-- <tr>
                        <th class="w-20">Release of Products and Services </th>
                        <td class="w-30">
                            @if ($data->Release_of_Products)
                                {{ $data->Release_of_Products }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> --}}
                    <div class="inner-block">
                        <label class="Summer" style="font-weight: bold; font-size: 14px;">Release of Products and
                            Services</label>
                        <div style="font-size: 0.9rem">
                            @if ($data->Release_of_Products)
                                {{ $data->Release_of_Products }}
                            @else
                                Not Applicable
                            @endif
                        </div>
                    </div>
                    {{-- <tr>
                        <th class="w-20">Control of Non-conforming Outputs </th>
                        <td class="w-30">
                            @if ($data->Control_of_Non)
                                {{ $data->Control_of_Non }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> --}}
                    <div class="inner-block">
                        <label class="Summer" style="font-weight: bold; font-size: 14px;">Control of Non-conforming
                            Outputs </label>
                        <div style="font-size: 0.9rem">
                            @if ($data->Control_of_Non)
                                {{ $data->Control_of_Non }}
                            @else
                                Not Applicable
                            @endif
                        </div>
                    </div>

                </div>
                <div class="block">
                    <div class="head">
                        <div class="block-head">
                            Meetings & Summary
                        </div>

                        {{-- <tr>
                            <th class="w-20">Risk & Opportunities</th>
                            <td class="w-30">
                                @if ($data->Risk_Opportunities)
                                    {{ $data->Risk_Opportunities }}
                                @else
                                    Not Applicable
                                @endif
                            </td>


                        </tr> --}}
                        <div class="inner-block">
                            <label class="Summer" style="font-weight: bold; font-size: 14px;">Risk &
                                Opportunities</label>
                            <div style="font-size: 0.9rem">
                                @if ($data->Risk_Opportunities)
                                    {{ $data->Risk_Opportunities }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </div>
                        {{-- <tr>
                            <th class="w-20">External Supplier Performance</th>
                            <td class="w-30">
                                @if ($data->External_Supplier_Performance)
                                    {{ $data->External_Supplier_Performance }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr> --}}
                        <div class="inner-block">
                            <label class="Summer" style="font-weight: bold; font-size: 14px;">External Supplier
                                Performance</label>
                            <div style="font-size: 0.9rem">
                                @if ($data->External_Supplier_Performance)
                                    {{ $data->External_Supplier_Performance }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </div>
                        {{-- <tr>
                            <th class="w-20">
                                Customer Satisfaction Level</th>
                            <td class="w-30">
                                @if ($data->Customer_Satisfaction_Level)
                                    {{ $data->Customer_Satisfaction_Level }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                        </tr> --}}
                        <div class="inner-block">
                            <label class="Summer" style="font-weight: bold; font-size: 14px;">Customer Satisfaction
                                Level</label>
                            <div style="font-size: 0.9rem">
                                @if ($data->Customer_Satisfaction_Level)
                                    {{ $data->Customer_Satisfaction_Level }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </div>
                        {{-- <tr>
                            <th class="w-20">Budget Estimates
                            </th>
                            <td class="w-30">
                                @if ($data->Budget_Estimates)
                                    {{ $data->Budget_Estimates }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr> --}}
                        <div class="inner-block">
                            <label class="Summer" style="font-weight: bold; font-size: 14px;">Budget Estimates</label>
                            <div style="font-size: 0.9rem">
                                @if ($data->Budget_Estimates)
                                    {{ $data->Budget_Estimates }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </div>
                        {{-- <tr>
                            <th class="w-20">Completion of Previous Tasks</th>
                            <td class="w-30">
                                @if ($data->Completion_of_Previous_Tasks)
                                    {{ $data->Completion_of_Previous_Tasks }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                        </tr> --}}
                        <div class="inner-block">
                            <label class="Summer" style="font-weight: bold; font-size: 14px;">Completion of Previous
                                Tasks</label>
                            <div style="font-size: 0.9rem">
                                @if ($data->Completion_of_Previous_Tasks)
                                    {{ $data->Completion_of_Previous_Tasks }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </div>
                        {{-- <tr>
                            <th class="w-20">Production</th>
                            <td class="w-30">
                                @if ($data->Production)
                                    {{ $data->Production }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr> --}}
                        <div class="inner-block">
                            <label class="Summer" style="font-weight: bold; font-size: 14px;">Production</label>
                            <div style="font-size: 0.9rem">
                                @if ($data->Production)
                                    {{ $data->Production }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </div>
                        {{-- <tr>
                            <th class="w-20">Plans</th>
                            <td class="w-30">
                                @if ($data->Plans)
                                    {{ $data->Plans }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                        </tr> --}}
                        <div class="inner-block">
                            <label class="Summer" style="font-weight: bold; font-size: 14px;">Plans</label>
                            <div style="font-size: 0.9rem">
                                @if ($data->Plans)
                                    {{ $data->Plans }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </div>
                        {{-- <tr>
                            <th class="w-20">Forecast</th>
                            <td class="w-30">
                                @if ($data->Forecast)
                                    {{ $data->Forecast }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr> --}}
                        <div class="inner-block">
                            <label class="Summer" style="font-weight: bold; font-size: 14px;">Forecast</label>
                            <div style="font-size: 0.9rem">
                                @if ($data->Forecast)
                                    {{ $data->Forecast }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </div>
                        {{-- <tr>
                            <th class="w-20">Any Additional Support Required
                            </th>
                            <td class="w-30">
                                @if ($data->Any_Additional_Support_Required)
                                    {{ $data->Any_Additional_Support_Required }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                        </tr> --}}
                        <div class="inner-block">
                            <label class="Summer" style="font-weight: bold; font-size: 14px;">Any Additional Support
                                Required</label>
                            <div style="font-size: 0.9rem">
                                @if ($data->Any_Additional_Support_Required)
                                    {{ $data->Any_Additional_Support_Required }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </div>
                        <table>
                            <tr>
                                <th class="w-20">File Attachment, if any</th>
                                <td class="w-30">
                                    @if ($data->file_attach)
                                        {{ $data->file_attach }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                        </table>
                    </div>
                </div>
                <div class="block">
                    <div class="block-head">
                        Closure

                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Next Management Review Date
                            </th>
                            <td class="w-30">
                                @if ($data->Date_Due)
                                    {{ \Carbon\Carbon::parse($data->Date_Due)->format('d-M-Y') }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                        </tr>
                    </table>
                    {{-- <tr>
                            <th class="w-20">Summary & Recommendation
                            </th>
                            <td class="w-30">
                                @if ($data->Summary_Recommendation)
                                    {{ $data->Summary_Recommendation }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr> --}}
                    <div class="inner-block">
                        <label class="Summer" style="font-weight: bold; font-size: 14px;">Summary &
                            Recommendation</label>
                        <div style="font-size: 0.9rem">
                            @if ($data->Summary_Recommendation)
                                {{ $data->Summary_Recommendation }}
                            @else
                                Not Applicable
                            @endif
                        </div>
                    </div>
                    {{-- <tr>
                            <th class="w-20">Conclusion</th>
                            <td class="w-30">
                                @if ($data->Conclusion)
                                    {{ $data->Conclusion }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                        </tr> --}}
                    <div class="inner-block">
                        <label class="Summer" style="font-weight: bold; font-size: 14px;">Conclusion</label>
                        <div style="font-size: 0.9rem">
                            @if ($data->Conclusion)
                                {{ $data->Conclusion }}
                            @else
                                Not Applicable
                            @endif
                        </div>
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Closure Attachments</th>
                            <td class="w-30">
                                @if ($data->file_Attachment)
                                    {{ $data->file_Attachment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Extension Justification

                    </div>
                    {{-- <table>
                        <tr>
                            <th class="w-20">Due Date Extension Justification
                            </th>
                            <td class="w-30">
                                @if ($data->Due_Date_Extension_Justification)
                                    {{ $data->Due_Date_Extension_Justification }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </table> --}}
                    <div class="inner-block">
                        <label class="Summer" style="font-weight: bold; font-size: 14px;">Due Date Extension
                            Justification</label>
                        <div style="font-size: 0.9rem">
                            @if ($data->Due_Date_Extension_Justification)
                                {{ $data->Due_Date_Extension_Justification }}
                            @else
                                Not Applicable
                            @endif
                        </div>
                    </div>
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
                    </tr>
                    <tr>
                        <th class="w-20">Comment</th>
                        <td class="w-30">{{ $data->Submitted_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Completed By
                        </th>
                        <td class="w-30">{{ $data->completed_by }}</td>
                        <th class="w-20">Completed On</th>
                        <td class="w-30">{{ $data->completed_on }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Comment</th>
                        <td class="w-30">{{ $data->completed_comment }}</td>
                    </tr>
                </table>

            </div>
            {{-- </table> --}}
            {{-- <div class="block">
                <div class="block-head">
                    Agenda
                </div>
                <div class="border-table">
                    <table style="margin-top: 20px; width:100%;table-layout:fixed">
                        <tr class="table_bg">
                            <th style="width: 5%">Row#</th>
                            <th>Date</th>
                            <th>Topic</th>
                            <th>Responsible</th>
                            <th>Shelf Life</th>
                            <th>Time Start</th>
                            <th>Time End</th>
                            <th>Comments</th>
                            <th>Remarks</th>
                        </tr>

                        @if ($grid_Data && is_array($grid_Data->data))
                            @foreach ($grid_Data->data as $grid_Data)
                                <tr>
                                    <td>
                                        {{ $loop->index + 1 }}
                                    </td>
                                    <td>
                                        {{ isset($grid_Data['info_mfg_date']) ? \Carbon\Carbon::parse($grid_Data['info_mfg_date'])->format('d-M-Y') : 'N/A' }}
                                    </td>

                                    <td>
                                        {{ isset($grid_Data['Topic']) ? $grid_Data['Topic'] : 'N/A' }}
                                    </td>
                                    <td>
                                        {{ isset($grid_Data['Responsible']) ? $grid_Data['Responsible'] : 'N/A' }}
                                    </td>
                                    <td>
                                        {{ isset($grid_Data['Shelf_Life']) ? $grid_Data['Shelf_Life'] : 'N/A' }}
                                    </td>
                                    <td>
                                        {{ isset($grid_Data['Time_Start']) ? $grid_Data['Time_Start'] : 'N/A' }}
                                    </td>
                                    <td>
                                        {{ isset($grid_Data['Time_End']) ? $grid_Data['Time_End'] : 'N/A' }}
                                    </td>
                                    <td>
                                        {{ isset($grid_Data['Comments']) ? $grid_Data['Comments'] : 'N/A' }}
                                    </td>
                                    <td>
                                        {{ isset($grid_Data['Remarker']) ? $grid_Data['Remarker'] : 'N/A' }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>N/A</td>
                                <td>N/A</td>
                                <td>N/A</td>
                                <td>N/A</td>
                                <td>N/A</td>
                                <td>N/A</td>
                                <td>N/A</td>
                                <td>N/A</td>
                                <td>N/A</td>
                            </tr>

                        @endif

                    </table>
                </div>
            </div> --}}
            <div class="block">
                <div class="block-head">
                    Agenda - Part 1
                </div>
                <div class="border-table">
                    <table style="margin-top: 20px; width:100%;table-layout:fixed;">
                        <thead>
                            <tr class="table_bg">
                                <th style="width: 8%">Row#</th>
                                <th style="width: 10%">Date</th>
                                <th>Topic</th>
                                <th>Responsible</th>
                                <th>Shelf Life</th>
                            </tr>

                        </thead>
                        <?php if ($grid_Data && is_array($grid_Data->data)): ?>
                        <?php foreach ($grid_Data->data as $index => $data): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo isset($data['info_mfg_date']) ? \Carbon\Carbon::parse($data['info_mfg_date'])->format('d-M-Y') : 'N/A'; ?></td>
                            <td><?php echo isset($data['Topic']) ? $data['Topic'] : 'N/A'; ?></td>
                            <td><?php echo isset($data['Responsible']) ? $data['Responsible'] : 'N/A'; ?></td>
                            <td><?php echo isset($data['Shelf_Life']) ? $data['Shelf_Life'] : 'N/A'; ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td>N/A</td>
                            <td>N/A</td>
                            <td>N/A</td>
                            <td>N/A</td>
                            <td>N/A</td>

                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
            <div class="block">
                <div class="block-head">
                    Agenda - Part 2
                </div>
                <div class="border-table">
                    <table style="margin-top: 20px; width:100%; table-layout: fixed;">
                        <thead>
                            <tr class="table_bg">
                                <th style="width: 8%">Row#</th>
                                <th style="width: 10%">Time Start</th>
                                <th style="width: 10%">Time End</th>
                                <th>Comments</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($grid_Data && is_array($grid_Data->data)): ?>
                            <?php $index = 0; ?>
                            <?php foreach ($grid_Data->data as $data): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo isset($data['Time_Start']) ? $data['Time_Start'] : 'N/A'; ?></td>
                                <td><?php echo isset($data['Time_End']) ? $data['Time_End'] : 'N/A'; ?></td>
                                <td><?php echo isset($data['Comments']) ? $data['Comments'] : 'N/A'; ?></td>
                                <td><?php echo isset($data['Remarker']) ? $data['Remarker'] : 'N/A'; ?></td>
                            </tr>
                            <?php $index++; ?>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="5">N/A</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>



            <div class="block">
                <div class="block-head">
                    Management Review Participants Part-1
                </div>
                <div class="border-table">
                    <table style="margin-top: 20px; width:100%; table-layout: fixed;">

                        <thead>
                            <tr class="table_bg">
                                <th style="width: 8%">Row#</th>
                                <th>Invite Person</th>
                                <th>Designee</th>
                                <th>Department</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($grid_Data1 && is_array($grid_Data1->data)): ?>
                            <?php $index = 0; ?>
                            <?php foreach ($grid_Data1->data as $data): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo isset($data['Invite_Person']) ? $data['Invite_Person'] : 'N/A'; ?></td>
                                <td><?php echo isset($data['Designee']) ? $data['Designee'] : 'N/A'; ?></td>
                                <td><?php echo isset($data['Department']) ? $data['Department'] : 'N/A'; ?></td>
                            </tr>
                            <?php $index++; ?>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="4">N/A</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>



            <div class="block">
                <div class="block-head">
                    Management Review Participants Part-2
                </div>
                <div class="border-table">
                    <table style="margin-top: 20px; width:100%; table-layout: fixed;">
                        <thead>
                            <tr class="table_bg">
                                <th style="width: 8%">Row#</th>
                                <th>Meeting Attended</th>
                                <th>Designee Name</th>
                                <th>Designee / Designation</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($grid_Data1 && is_array($grid_Data1->data)): ?>
                            <?php $index = 0; ?>
                            <?php foreach ($grid_Data1->data as $data): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo isset($data['Meeting_Attended']) ? $data['Meeting_Attended'] : 'N/A'; ?></td>
                                <td><?php echo isset($data['Designee_Name']) ? $data['Designee_Name'] : 'N/A'; ?></td>
                                <td><?php echo isset($data['Designee_Department_Designation']) ? $data['Designee_Department_Designation'] : 'N/A'; ?></td>
                                <td><?php echo isset($data['manage_remark']) ? $data['manage_remark'] : 'N/A'; ?></td>
                            </tr>
                            <?php $index++; ?>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="5">N/A</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="block">
                <div class="block-head">
                    Performance Evaluation Part-1
                </div>
                <div class="border-table">
                    <table style="margin-top: 20px; width:100%; table-layout: fixed;">
                        <thead>
                            <tr class="table_bg">
                                <th style="width: 8%">Row#</th>
                                <th>Monitoring</th>
                                <th>Measurement</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($grid_Data2 && is_array($grid_Data2->data)): ?>
                            <?php $index1 = 0; ?>
                            <?php foreach ($grid_Data2->data as $data): ?>
                            <tr>
                                <td><?php echo $index1 + 1; ?></td>
                                <td><?php echo isset($data['Monitoring']) ? $data['Monitoring'] : 'N/A'; ?></td>
                                <td><?php echo isset($data['Measurement']) ? $data['Measurement'] : 'N/A'; ?></td>
                            </tr>
                            <?php $index1++; ?>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="3">N/A</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="block">
                <div class="block-head">
                    Performance Evaluation Part-2
                </div>
                <div class="border-table">
                    <table style="margin-top: 20px; width:100%; table-layout: fixed;">
                        <thead>
                            <tr class="table_bg">
                                <th style="width: 8%">Row#</th>
                                <th>Analysis</th>
                                <th>Evaluation</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($grid_Data2 && is_array($grid_Data2->data)): ?>
                            <?php $index2 = 0; ?>
                            <?php foreach ($grid_Data2->data as $data): ?>
                            <tr>
                                <td><?php echo $index2 + 1; ?></td>
                                <td><?php echo isset($data['Analysis']) ? $data['Analysis'] : 'N/A'; ?></td>
                                <td><?php echo isset($data['Evalutaion']) ? $data['Evalutaion'] : 'N/A'; ?></td>
                                <td><?php echo isset($data['Remarks']) ? $data['Remarks'] : 'N/A'; ?></td>
                            </tr>
                            <?php $index2++; ?>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="4">N/A</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="block">
                <div class="block-head">
                    Action Item Details Part-1
                </div>
                <div class="border-table">
                    <table style="margin-top: 20px; width:100%;table-layout:fixed;">
                        <thead>
                            <tr class="table_bg">
                                <th style="width: 8%">Row#</th>
                                <th style="width: 12%">Short Description</th>
                                <th style="width: 15%">Due Date</th>
                                <th style="width: 15%">Site / Division</th>
                            </tr>
                        </thead>
                        <?php if ($grid_Data3 && is_array($grid_Data3->data)): ?>
                        <?php $index2 = 0; ?>
                        <?php foreach ($grid_Data3->data as $data): ?>
                        <tr>
                            <td><?php echo $index2 + 1; ?></td>
                            <td><?php echo isset($data['Short_Description']) ? $data['Short_Description'] : 'N/A'; ?></td>
                            <td><?php echo isset($data['Due_Date']) ? \Carbon\Carbon::parse($data['Due_Date'])->format('d-M-Y') : 'N/A'; ?></td>
                            <td><?php echo isset($data['Site_Division']) ? $data['Site_Division'] : 'N/A'; ?></td>
                        </tr>
                        <?php $index2++; ?>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="4">N/A</td>
                        </tr>
                        <?php endif; ?>

                    </table>
                </div>
            </div>
            <div class="block">
                <div class="block-head">
                    Action Item Details Part-2
                </div>
                <div class="border-table">
                    <table style="margin-top: 20px; width:100%;table-layout:fixed;">
                        <thead>
                            <tr class="table_bg">
                                <th style="width: 8%">Row#</th>
                                <th style="width: 15%"> Person Responsible</th>
                                <th style="width: 15%">Current Status</th>
                                <th style="width: 15%">Date Closed</th>
                                <th style="width: 15%">Remarks</th>
                            </tr>
                        </thead>
                        <?php if ($grid_Data3 && is_array($grid_Data3->data)): ?>
                        <?php $index2 = 0; ?>
                        <?php foreach ($grid_Data3->data as $data): ?>
                        <tr>
                            <td><?php echo $index2 + 1; ?></td>
                            <td><?php echo isset($data['Person_Responsible']) ? $data['Person_Responsible'] : 'N/A'; ?></td>
                            <td><?php echo isset($data['current_status']) ? $data['current_status'] : 'N/A'; ?></td>
                            <td><?php echo isset($data['Date_Closed']) ? \Carbon\Carbon::parse($data['Date_Closed'])->format('d-M-Y') : 'N/A'; ?></td>
                            <td><?php echo isset($data['Remarking']) ? $data['Remarking'] : 'N/A'; ?></td>
                        </tr>
                        <?php $index2++; ?>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="4">N/A</td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
            <div class="block">
                <div class="block-head">
                    CAPA Details Part-1
                </div>
                <div class="border-table">
                    <table style="margin-top: 20px; width:100%;table-layout:fixed;">
                        <thead>
                            <tr class="table_bg">
                                <th style="width: 8%">Row#</th>
                                <th style="width: 12%">CAPA Details</th>
                                <th style="width: 15%">CAPA Type</th>
                                <th style="width: 15%">Site / Division</th>
                            </tr>
                        </thead>
                        <?php if ($grid_Data4 && is_array($grid_Data4->data)): ?>
                        <?php $index2 = 0; ?>
                        <?php foreach ($grid_Data4->data as $data): ?>
                        <tr>
                            <td><?php echo $index2 + 1; ?></td>
                            <td><?php echo isset($data['CAPA_Details']) ? $data['CAPA_Details'] : 'N/A'; ?></td>
                            <td><?php echo isset($data['CAPA_Type']) ? $data['CAPA_Type'] : 'N/A'; ?></td>
                            <td><?php echo isset($data['Site_Division']) ? $data['Site_Division'] : 'N/A'; ?></td>
                        </tr>
                        <?php $index2++; ?>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="4">N/A</td>
                        </tr>
                        <?php endif; ?>

                    </table>
                </div>
            </div>
            <div class="block">
                <div class="block-head">
                    CAPA Details
                </div>
                <div class="border-table">
                    <table style="margin-top: 20px; width:100%;table-layout:fixed;">
                        <thead>
                            <tr class="table_bg">
                                <th style="width: 8%">Row#</th>
                                <th style="width: 15%">Person Responsible</th>
                                <th style="width: 15%">Current Status</th>
                                <th style="width: 15%">Date Closed</th>
                                <th style="width: 16%">Remarks</th>
                            </tr>
                        </thead>
                        <?php if ($grid_Data3 && is_array($grid_Data3->data)): ?>
                        <?php $index2 = 0; ?>
                        <?php foreach ($grid_Data3->data as $data): ?>
                        <tr>
                            <td><?php echo $index2 + 1; ?></td>
                            <td><?php echo isset($data['person_responsible']) ? $data['person_responsible'] : 'N/A'; ?></td>
                            <td><?php echo isset($data['Current_Status']) ? $data['Current_Status'] : 'N/A'; ?></td>
                            <td><?php echo isset($data['date_Closed']) ? \Carbon\Carbon::parse($data['date_Closed'])->format('d-M-Y') : 'N/A'; ?></td>
                            <td><?php echo isset($data['Remarking']) ? $data['Remarking'] : 'N/A'; ?></td>
                        </tr>
                        <?php $index2++; ?>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="4">N/A</td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>

        </div>

    </div>



</body>

</html>
