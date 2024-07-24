<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vidyagxp - Software</title>
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
                    Supplier-Contract Single Report
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
                    <strong>Correspondence No.</strong>{{ $correspondence_data->id }}
                </td>
                <td class="w-40">
                       {{ Helpers::getDivisionName($correspondence_data->division_id) }}/Correspondence/{{ Helpers::year($correspondence_data->created_at) }}/{{ str_pad($correspondence_data->record, 4, '0', STR_PAD_LEFT) }}
                    {{--{{ Helpers::divisionNameForQMS($study_data->division_id) }}/{{ Helpers::year($study_data->created_at) }}/{{ $study_data->record_number ? str_pad($study_data->record_number->record_number, 4, '0', STR_PAD_LEFT) : '' }}--}}
                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($correspondence_data->record, 4, '0', STR_PAD_LEFT) }}
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
                {{--<td class="w-30">
                    <strong>Page :</strong> 1 of 1
                </td>--}}
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

                    <tr>
                        <th class="w-20">Record Number</th>
                        <td class="w-30">
                            @if ($correspondence_data->record)
                                {{ str_pad($correspondence_data->record, 4, '0', STR_PAD_LEFT) }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Site/Location Code</th>
                        <td class="w-30">
                            @if ( Helpers::getDivisionName(session()->get('division')) )
                            {{ Helpers::getDivisionName(session()->get('division')) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr> {{ $correspondence_data->created_at }} added by {{ $correspondence_data->originator }}
                        <th class="w-20">Initiator</th>
                         <td class="w-30">{{ $correspondence_data->originator }}</td>

                        <th class="w-20">Date of Initiation</th>
                         <td class="w-30">{{ Helpers::getdateFormat($correspondence_data->created_at) }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Short Description</th>
                            <td class="w-30">
                                @if ($correspondence_data->short_description)
                                    {{ $correspondence_data->short_description }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                        <th class="w-20">Assign To</th>
                          <td class="w-80">{{ $correspondence_data->assign_to_gi }}</td>
                    </tr>

                    <tr>
                         <th class="w-20">Date Due</th>
                           <td class="w-80">{{ date('d-M-Y', strtotime($correspondence_data->due_date)) }}</td>

                           <th class="w-20">Process/Application</th>
                           <td class="w-80">{{ $correspondence_data->process_application }}</td>
                    </tr>

                    <tr>
                         <th class="w-20">Trade Name</th>
                            <td class="w-30">
                                @if ($correspondence_data->trade_name)
                                    {{ $correspondence_data->trade_name }}

                                @endif
                            </td>

                         <th class="w-20">How Initiated</th>
                            <td class="w-30">
                                @if ($correspondence_data->how_initiated)
                                    {{ $correspondence_data->how_initiated }}

                                @endif
                            </td>
                     </tr>

                      <tr>
                         <th class="w-20">Type</th>
                            <td class="w-30">
                                @if ($correspondence_data->type)
                                    {{ $correspondence_data->type }}

                                @endif
                            </td>
                         <th class="w-20">Authority Type</th>
                            <td class="w-30">
                                @if ($correspondence_data->authority_type)
                                    {{ $correspondence_data->authority_type }}

                                @endif
                            </td>
                      </tr>

                      <tr>
                         <th class="w-20">Authority</th>
                            <td class="w-30">
                                @if ($correspondence_data->authority)
                                    {{ $correspondence_data->authority }}

                                @endif
                            </td>

                            <th class="w-20">Commitment Required</th>
                            <td class="w-30">
                                @if ($correspondence_data->commitment_required)
                                    {{ $correspondence_data->commitment_required }}

                                @endif
                            </td>
                        </tr>
                    </table>

                    <table>
                        <tr>
                            <th class="w-10">Description</th>
                            <td class="w-90">
                                @if ($correspondence_data->description)
                                    {{ $correspondence_data->description }}

                                @endif
                            </td>
                        </tr>
                    </table>

                    <table>
                        <tr>
                            <th class="w-20">Priority Level</th>
                            <td class="w-30">
                                @if ($correspondence_data->priority_level)
                                    {{ $correspondence_data->priority_level }}

                                @endif
                            </td>

                            <th class="w-20">Date Due to Authority</th>
                            <td class="w-30">
                                @if ($correspondence_data->date_due_to_authority)
                                    {{ date('d-M-Y', strtotime($correspondence_data->date_due_to_authority)) }}

                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Scheduled Start date</th>
                            <td class="w-30">{{ date('d-M-Y', strtotime($correspondence_data->scheduled_start_date)) }}
                            </td>

                            <th class="w-20">Scheduled End Date</th>
                            <td class="w-30">
                                @if ($correspondence_data->scheduled_end_date)
                                    {{ date('d-M-Y', strtotime($correspondence_data->scheduled_end_date)) }}

                                @endif
                            </td>
                        </tr>

                    </table>
                </div>


            <div class="block">
                {{-- <div class="block"> --}}
                {{-- <div class="block-head"> --}}
                <div style="font-weight: 200">Financial Transaction</div>
                {{-- </div> --}}
                <div class="border-table">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Sr. No.</th>
                            <th class="w-20">Action</th>
                            <th class="w-20">Responsible</th>
                            <th class="w-20">Deadline</th>
                            <th class="w-20">Item Status</th>
                            <th class="w-20">Remarks</th>
                        </tr>

                            @php
                            $data = $grid_Data->data ? json_decode($grid_Data->data, true) : null;
                            @endphp

                         @if ($data && is_array($data))
                             @foreach ($data as $index => $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}.</td>
                                    <td>{{ isset($item['Action']) ? $item['Action'] : '' }}</td>
                                    <td>{{ isset($item['Responsible']) ? $item['Responsible'] : '' }}</td>
                                    <td>{{ isset($item['Deadline']) ? $item['Deadline'] : '' }}</td>
                                    <td>{{ isset($item['ItemStatus']) ? $item['ItemStatus'] : '' }}</td>
                                    <td>{{ isset($item['Remarks']) ? $item['Remarks'] : '' }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>Not Applicable</td>
                                <td>Not Applicable</td>
                                <td>Not Applicable</td>
                                <td>Not Applicable</td>
                                <td>Not Applicable</td>
                            </tr>
                        @endif
                    </table>
                </div>
                {{-- </div> --}}
            </div>
        <div>

</body>

</html>
