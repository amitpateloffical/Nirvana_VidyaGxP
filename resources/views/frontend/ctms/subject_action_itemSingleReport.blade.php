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
                    Subject Action Item Single Report
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
                    <strong>Subject Action Item No.</strong>{{ $item_data->id }}
                </td>
                <td class="w-40">
                       {{ Helpers::getDivisionName($item_data->division_id) }}/Subject_Action_Item/{{ Helpers::year($item_data->created_at) }}/{{ $item_data->record }}
                    {{--{{ Helpers::divisionNameForQMS($item_data->division_id) }}/{{ Helpers::year($item_data->created_at) }}/{{ $item_data->record_number ? str_pad($item_data->record_number->record_number, 4, '0', STR_PAD_LEFT) : '' }}--}}
                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($item_data->record, 4, '0', STR_PAD_LEFT) }}
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
                            @if ($item_data->record)
                                {{ str_pad($item_data->record, 4, '0', STR_PAD_LEFT) }}
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
                    <tr> {{ $item_data->created_at }} added by {{ $item_data->originator }}
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ $item_data->originator }}</td>

                        <th class="w-20">Date of Initiation</th>
                        <td class="w-30">{{ Helpers::getdateFormat($item_data->created_at) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Short Description</th>
                        <td class="w-30">
                            @if ($item_data->short_description_ti)
                                {{ $item_data->short_description_ti }}

                            @endif
                        </td>

                        <th class="w-20">Assign To</th>
                        <td class="w-80">{{ $item_data->a_originator }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Date Due</th>
                        <td class="w-80">{{ date('d-M-Y', strtotime($item_data->due_date)) }}</td>
                    </tr>
                </table>
            </div>
            <div class="block">
                <div class="block-head">
                    Study Details
                </div>
                <table>

                    <tr>
                        <th class="w-20">Trade Name</th>
                        <td class="w-30">
                            @if ($item_data->trade_name_sd)
                                {{ $item_data->trade_name_sd }}

                            @endif
                        </td>

                        <th class="w-20">Assigned To</th>
                        <td class="w-30">
                            @if ($item_data->assign_to_sd)
                                {{ $item_data->assign_to_sd }}

                            @endif
                        </td>
                    </tr>

                    </tr>
                </table>
            </div>
            <div class="block">
                <div class="block-head">
                    Subject Details
                </div>
                <table>

                    <tr>
                        <th class="w-20">Subject Name</th>
                        <td class="w-30">
                            @if ($item_data->subject_name_sd)
                                {{ $item_data->subject_name_sd }}

                            @endif
                        </td>

                        <th class="w-20">Gender</th>
                        <td class="w-30">
                            @if ($item_data->gender_sd)
                                {{ $item_data->gender_sd }}

                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Date Of Birth</th>
                        <td class="w-30">
                            @if ($item_data->date_of_birth_sd)
                                {{ date('d-M-Y', strtotime($item_data->date_of_birth_sd)) }}

                            @endif
                        </td>

                        <th class="w-20">Race</th>
                        <td class="w-30">
                            @if ($item_data->race_sd)
                                {{ $item_data->race_sd }}

                            @endif
                        </td>

                    </tr>

                </table>
            </div>
            <div class="block">
                <div class="block-head">
                    Treatment Information
                </div>
                <table>

                    <tr>
                        <th class="w-20">Clinical Efficacy</th>
                        <td class="w-30">
                            @if ($item_data->clinical_efficacy_ti)
                                {{ $item_data->clinical_efficacy_ti }}

                            @endif
                        </td>

                        <th class="w-20">Carry Over Effect</th>
                        <td class="w-30">
                            @if ($item_data->carry_over_effect_ti)
                                {{ $item_data->carry_over_effect_ti }}

                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Last Monitered</th>
                        <td class="w-30">
                            @if ($item_data->last_monitered_ti)
                                {{ $item_data->last_monitered_ti }}

                            @endif
                        </td>

                        <th class="w-20">Total Doses Recieved</th>
                        <td class="w-30">
                            @if ($item_data->total_doses_recieved_ti)
                                {{ $item_data->total_doses_recieved_ti }}

                            @endif
                        </td>

                    </tr>

                    <tr>
                        <th class="w-20">Treatment Effect</th>
                        <td class="w-30">
                            @if ($item_data->treatment_effect_ti)
                                {{ $item_data->treatment_effect_ti }}

                            @endif
                        </td>
                    </tr>

                </table>

                <table>
                    <tr>
                        <th class="w-20">Comments</th>
                        <td class="w-80">
                            @if ($item_data->comments_ti)
                                {{ $item_data->comments_ti }}

                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Summary</th>
                        <td class="w-80">
                            @if ($item_data->summary_ti)
                                {{ $item_data->summary_ti }}

                            @endif
                        </td>
                      </tr>
                </table>
            </div>

            <div class="block">
                {{-- <div class="block"> --}}
                {{-- <div class="block-head"> --}}
                <div style="font-weight: 200">DCF</div>
                {{-- </div> --}}
                <div class="border-table">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Sr. no.</th>
                            <th class="w-10">Number</th>
                            <th class="w-20"> Date</th>
                            <th class="w-20">Sent Date</th>
                            <th class="w-20">Returned Date</th>
                            <th class="w-20">Data Collection Method </th>
                            <th class="w-20">Comment</th>
                            <th class="w-20">Remarks</th>
                        </tr>
                            @php
                            $data = isset($grid_DataD) && $grid_DataD->data ? json_decode($grid_DataD->data, true) : null;
                            @endphp

                            @if ($data && is_array($data))
                              @foreach ($data as $index => $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}.</td>
                                    <td>{{ isset($item['Number']) ? $item['Number'] : '' }}</td>
                                    <td>{{ isset($item['Date']) ? $item['Date'] : '' }}</td>
                                    <td>{{ isset($item['SentDate']) ? $item['SentDate'] : '' }}</td>
                                    <td>{{ isset($item['ReturnedDate']) ? $item['ReturnedDate'] : '' }}</td>
                                    <td>{{ isset($item['DataCollectionMethod']) ? $item['DataCollectionMethod'] : '' }}</td>
                                    <td>{{ isset($item['Comment']) ? $item['Comment'] : '' }}</td>
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

            <div class="block">
                {{-- <div class="block"> --}}
                {{-- <div class="block-head"> --}}
                    <div style="font-weight: 200">Minor Protocol Voilation</div>
                    {{-- </div> --}}
                    <div class="border-table">
                        <table>
                            <tr class="table_bg">
                                <th class="w-10">SR no.</th>
                                <th class="w-20">Item Description</th>
                                <th class="w-20"> Date</th>
                                <th class="w-20">Sent Date</th>
                                <th class="w-20">Returned Date</th>
                                <th class="w-20">Comment</th>
                            </tr>
                            @php
                                $data = isset($grid_DataM) && $grid_DataM->data ? json_decode($grid_DataM->data, true) : null;
                            @endphp

                             @if ($data && is_array($data))
                                @foreach ($data as $index => $item)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}.</td>
                                        <td>{{ isset($item['ItemDescription']) ? $item['ItemDescription'] : '' }}</td>
                                        <td>{{ isset($item['Date']) ? $item['Date'] : '' }}</td>
                                        <td>{{ isset($item['SentDate']) ? $item['SentDate'] : '' }}</td>
                                        <td>{{ isset($item['ReturnedDate']) ? $item['ReturnedDate'] : '' }}</td>
                                        <td>{{ isset($item['Comment']) ? $item['Comment'] : '' }}</td>
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
