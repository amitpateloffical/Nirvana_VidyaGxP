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
        table-layout: fixed;
        /* Fix the table layout to ensure all columns are shown */
        border-collapse: collapse;

    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    .border-table table,
    .border-table th,
    .border-table td {
        font-size: 0.7rem;

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
                    Monitoring Visit Single Report
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
                    <strong>Monitoring Visit No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::getDivisionName($data->division_id) }}/CTMS-MV/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->id, 4, '0', STR_PAD_LEFT) }}
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
                <td class="w-50">
                    <strong>Printed On :</strong> {{ date('d-M-Y') }}
                </td>
                <td class="w-50">
                    <strong>Printed By :</strong> {{ Auth::user()->name }}
                </td>
                {{-- <td class="w-30">
                    <strong>Page :</strong>
                    1 of 1
                </td> --}}
            </tr>
        </table>
    </footer>

    <div class="inner-block">
        <div class="content-table">
            <div class="block">
                <div class="block-head">
                    Monitoring Visit
                </div>
                <table>
                    <tr>
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ $data->originator }}</td>
                        <th class="w-20">Date Initiation</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->created_at) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-30">
                            @if ($data->division_id)
                                {{ Helpers::getDivisionName($data->division_id) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Assigned To</th>
                        <td class="w-30">
                            @if ($data->assign_to)
                                {{ $data->assign_to }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Due Date</th>
                        <td class="w-80" colspan="3">
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
                    <tr>
                        <th class="w-20">Type</th>
                        <td class="w-30">
                            @if ($data->type)
                                {{ $data->type }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Initial Attachment</th>
                        <td class="w-30">
                            @if ($data->file_attach)
                                <a href="{{ asset('upload/document/', $data->file_attach) }}">
                                    {{ $data->file_attach }} </a>
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Description</th>
                        <td class="w-80" colspan="3">
                            @if ($data->description)
                                {{ $data->description }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Comments</th>
                        <td class="w-80" colspan="3">
                            @if ($data->comments)
                                {{ $data->comments }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Source Documents</th>
                        <td class="w-80">
                            @if ($data->source_documents)
                                {{ $data->source_documents }}
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
                        Location
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Zone</th>
                            <td class="w-30">
                                @if ($data->zone)
                                    {{ $data->zone }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Country</th>
                            <td class="w-30">
                                @if ($data->country)
                                    {{ $data->country }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">State</th>
                            <td class="w-30">
                                @if ($data->state)
                                    {{ $data->state }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">City</th>
                            <td class="w-30">
                                @if ($data->city)
                                    {{ $data->city }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">(Parent) Name On Site</th>
                            <td class="w-30">
                                @if ($data->name_on_site)
                                    {{ $data->name_on_site }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Building</th>
                            <td class="w-30">
                                @if ($data->building)
                                    {{ $data->building }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Floor</th>
                            <td class="w-30">
                                @if ($data->floor)
                                    {{ $data->floor }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Room</th>
                            <td class="w-30">
                                @if ($data->room)
                                    {{ $data->room }}
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
                        Monitoring Visit Information
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Site</th>
                            <td class="w-30">
                                @if ($data->site)
                                    {{ $data->site }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                            <th class="w-20">Site Contact</th>
                            <td class="w-30">
                                @if ($data->site_contact)
                                    {{ $data->site_contact }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                        </tr>
                        <tr>
                            <th class="w-20">Lead Investigator</th>
                            <td class="w-30">
                                @if ($data->lead_investigator)
                                    {{ $data->lead_investigator }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Manufacturer</th>
                            <td class="w-30">
                                @if ($data->manufacturer)
                                    {{ $data->manufacturer }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Additional Investigators</th>
                            <td class="w-80">
                                @if ($data->additional_investigators)
                                    {{ $data->additional_investigators }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Comments</th>
                            <td class="w-80" colspan="3">
                                @if ($data->comment)
                                    {{ $data->comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Monitoring Report</th>
                            <td class="w-80">
                                @if ($data->monitoring_report)
                                    {{ $data->monitoring_report }}
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
                        Important Date
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Date Follow-Up Letter Sent</th>
                            <td class="w-30">
                                @if ($data->follow_up_start_date)
                                    {{ \Carbon\Carbon::parse($data->follow_up_start_date)->format('d-M-Y') }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Date Follow-Up Completed</th>
                            <td class="w-30">
                                @if ($data->follow_up_end_date)
                                    {{ \Carbon\Carbon::parse($data->follow_up_end_date)->format('d-M-Y') }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Date Of Visit</th>
                            <td class="w-30">
                                @if ($data->visit_start_date)
                                    {{ \Carbon\Carbon::parse($data->visit_start_date)->format('d-M-Y') }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Date Return From Visit</th>
                            <td class="w-30">
                                @if ($data->visit_end_date)
                                    {{ \Carbon\Carbon::parse($data->visit_end_date)->format('d-M-Y') }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Date Report Completed</th>
                            <td class="w-30">
                                @if ($data->report_complete_start_date)
                                    {{ \Carbon\Carbon::parse($data->report_complete_start_date)->format('d-M-Y') }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Site Final Close-Out Date</th>
                            <td class="w-30">
                                @if ($data->report_complete_end_date)
                                    {{ \Carbon\Carbon::parse($data->report_complete_end_date)->format('d-M-Y') }}
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
                        Activity Log
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Schedule Site Visit By</th>
                            <td class="w-30">
                                @if ($data->Schedule_Site_Visit_By)
                                    {{ $data->Schedule_Site_Visit_By }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Schedule Site Visit On</th>
                            <td class="w-30">
                                @if ($data->Schedule_Site_Visit_On)
                                    {{ $data->Schedule_Site_Visit_On }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Close Out Visit Scheduled By</th>
                            <td class="w-30">
                                @if ($data->Close_Out_Visit_Scheduled_By)
                                    {{ $data->Close_Out_Visit_Scheduled_By }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Close Out Visit Scheduled On</th>
                            <td class="w-30">
                                @if ($data->Close_Out_Visit_Scheduled_On)
                                    {{ $data->Close_Out_Visit_Scheduled_On }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Approve Close Out By</th>
                            <td class="w-30">
                                @if ($data->Approve_Close_Out_By)
                                    {{ $data->Approve_Close_Out_By }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Approve Close Out On</th>
                            <td class="w-30">
                                @if ($data->Approve_Close_Out_On)
                                    {{ $data->Approve_Close_Out_On }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Cancelled By</th>
                            <td class="w-30">
                                @if ($data->cancelled_by)
                                    {{ $data->cancelled_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Cancelled On</th>
                            <td class="w-30">
                                @if ($data->cancelled_on)
                                    {{ $data->cancelled_on }}
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
                        Monitoring Information (Part 1)
                    </div>
                    <div class="border-table">
                        <table style="margin-top: 20px; width: 100%; table-layout: fixed;">
                            <tr class="table_bg">

                                <th style="width: 10%">Row#</th>
                                <th style="width: 15%">Date</th>
                                <th>Responsible</th>
                                <th>Item Description</th>

                            </tr>

                            @if ($grid_Data && is_array($grid_Data->data))
                                @foreach ($grid_Data->data as $index => $item)
                                    @if ($index < ceil(count($grid_Data->data) / 2))
                                        <tr>

                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                {{ isset($item['Date']) ? \Carbon\Carbon::parse($item['Date'])->format('d-M-Y') : 'N/A' }}
                                            </td>
                                            <td>
                                                {{ isset($item['Responsible']) ? $item['Responsible'] : 'N/A' }}
                                            </td>
                                            <td>
                                                {{ isset($item['Item_Description']) ? $item['Item_Description'] : 'N/A' }}
                                            </td>

                                        </tr>
                                    @endif
                                @endforeach
                            @endif

                        </table>
                    </div>
                </div>
            </div>
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Monitoring Information (Part 2)
                    </div>
                    <div class="border-table">
                        <table style="margin-top: 20px; width: 100%; table-layout: fixed;">
                            <tr class="table_bg">

                                <th style="width: 10%">Row#</th>
                                <th style="width: 15%">Sent Date</th>
                                <th style="width: 15%">Return Date</th>
                                <th>Comments</th>
                                <th>Remarks</th>

                            </tr>

                            @if ($grid_Data && is_array($grid_Data->data))
                                @foreach ($grid_Data->data as $index => $item)
                                    @if ($index < ceil(count($grid_Data->data) / 2))
                                        <tr>

                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                {{ isset($item['Sent_Date']) ? \Carbon\Carbon::parse($item['Sent_Date'])->format('d-M-Y') : 'N/A' }}
                                            </td>
                                            <td>
                                                {{ isset($item['Return_Date']) ? \Carbon\Carbon::parse($item['Return_Date'])->format('d-M-Y') : 'N/A' }}
                                            </td>
                                            <td>
                                                {{ isset($item['Comments']) ? $item['Comments'] : 'N/A' }}
                                            </td>
                                            <td>
                                                {{ isset($item['Remarks']) ? $item['Remarks'] : 'N/A' }}
                                            </td>

                                        </tr>
                                    @endif
                                @endforeach
                            @endif

                        </table>
                    </div>
                </div>
            </div>

            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Product/Material (Part 1)
                    </div>
                    <div class="border-table">
                        <table style="margin-top: 20px; width: 100%; table-layout: fixed;">
                            <tr class="table_bg">

                                <th style="width: 10%">Row#</th>
                                <th>Product Name</th>
                                <th style="width: 15%"> ReBatch Number</th>
                                <th style="width: 15%"> Expiry Date</th>
                                <th style="width: 15%"> Manufactured Date</th>

                            </tr>
                            @if ($grid_Data1 && is_array($grid_Data1->data))
                                @foreach ($grid_Data1->data as $index => $item)
                                    @if ($index < ceil(count($grid_Data1->data) / 2))
                                        <tr>

                                            <td>
                                                {{ $loop->index + 1 }}
                                            </td>
                                            <td>
                                                {{ isset($item['ProductName']) ? $item['ProductName'] : 'N/A' }}
                                            </td>
                                            <td>
                                                {{ isset($item['ReBatchNumber']) ? $item['ReBatchNumber'] : 'N/A' }}
                                            </td>
                                            <td>
                                                {{ isset($item['ExpiryDate']) ? \Carbon\Carbon::parse($item['ExpiryDate'])->format('d-M-Y') : 'N/A' }}
                                            </td>
                                            <td>
                                                {{ isset($item['ManufacturedDate']) ? \Carbon\Carbon::parse($item['ManufacturedDate'])->format('d-M-Y') : 'N/A' }}
                                            </td>

                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Product/Material (Part 2)
                    </div>
                    <div class="border-table">
                        <table style="margin-top: 20px; width: 100%; table-layout: fixed;">
                            <tr class="table_bg">

                                <th style="width: 10%">Row#</th>
                                <th> Disposition</th>
                                <th> Comment</th>
                                <th> Remarks</th>

                            </tr>

                            @if ($grid_Data1 && is_array($grid_Data1->data))
                                @foreach ($grid_Data1->data as $index => $item)
                                    @if ($index < ceil(count($grid_Data1->data) / 2))
                                        <tr>

                                            <td>
                                                {{ $loop->index + 1 }}
                                            </td>
                                            <td>
                                                {{ isset($item['Disposition']) ? $item['Disposition'] : 'N/A' }}
                                            </td>
                                            <td>
                                                {{ isset($item['Comments']) ? $item['Comments'] : 'N/A' }}
                                            </td>
                                            <td>
                                                {{ isset($item['Remarks']) ? $item['Remarks'] : 'N/A' }}
                                            </td>

                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Equipment (Part 1)
                    </div>
                    <div class="border-table">
                        <table style="margin-top: 20px; width: 100%; table-layout: fixed;">
                            <tr class="table_bg">

                                <th style="width: 10%">Row#</th>
                                <th>Product Name</th>
                                <th style="width: 15%"> Batch Number</th>
                                <th style="width: 15%"> Expiry Date</th>
                                <th style="width: 15%"> Manufactured Date</th>

                            </tr>

                            @if ($grid_Data2 && is_array($grid_Data2->data))
                                @foreach ($grid_Data2->data as $index => $item)
                                    @if ($index < ceil(count($grid_Data2->data) / 2))
                                        <tr>

                                            <td>
                                                {{ $loop->index + 1 }}
                                            </td>
                                            <td class="td">
                                                {{ isset($item['ProductName']) ? $item['ProductName'] : 'N/A' }}
                                            </td>
                                            <td class="td">
                                                {{ isset($item['BatchNumber']) ? $item['BatchNumber'] : 'N/A' }}
                                            </td>

                                            <td class="td">
                                                {{ isset($item['ExpiryDate1']) ? \Carbon\Carbon::parse($item['ExpiryDate1'])->format('d-M-Y') : 'N/A' }}
                                            </td>
                                            <td class="td">
                                                {{ isset($item['ManufacturedDate1']) ? \Carbon\Carbon::parse($item['ManufacturedDate1'])->format('d-M-Y') : 'N/A' }}
                                            </td>

                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Equipment (Part 2)
                    </div>
                    <div class="border-table">
                        <table style="margin-top: 20px; width: 100%; table-layout: fixed;">
                            <tr class="table_bg">

                                <th style="width: 10%">Row#</th>
                                <th style="width: 15%"> Number of Items Needed</th>
                                <th> Exist</th>
                                <th> Comment</th>
                                <th> Remarks</th>

                            </tr>

                            @if ($grid_Data2 && is_array($grid_Data2->data))
                                @foreach ($grid_Data2->data as $index => $item)
                                    @if ($index < ceil(count($grid_Data2->data) / 2))
                                        <tr>

                                            <td>
                                                {{ $loop->index + 1 }}
                                            </td>
                                            <td class="td">
                                                {{ isset($item['NumberOfItemsNeeded']) ? $item['NumberOfItemsNeeded'] : 'N/A' }}
                                            </td>
                                            <td class="td">
                                                {{ isset($item['Exist']) ? $item['Exist'] : 'N/A' }}
                                            </td>
                                            <td class="td">
                                                {{ isset($item['Comments']) ? $item['Comments'] : 'N/A' }}
                                            </td>
                                            <td class="td">
                                                {{ isset($item['Remarks']) ? $item['Remarks'] : 'N/A' }}
                                            </td>

                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
