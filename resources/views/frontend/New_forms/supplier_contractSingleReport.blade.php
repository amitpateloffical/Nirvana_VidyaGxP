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
                    <strong>Supplier-Contract No.</strong>{{ $contract_data->id }}
                </td>
                <td class="w-40">
                       {{ Helpers::getDivisionName($contract_data->division_id) }}/Supplier_Contract/{{ Helpers::year($contract_data->created_at) }}/{{ str_pad($contract_data->record, 4, '0', STR_PAD_LEFT) }}
                    {{--{{ Helpers::divisionNameForQMS($study_data->division_id) }}/{{ Helpers::year($study_data->created_at) }}/{{ $study_data->record_number ? str_pad($study_data->record_number->record_number, 4, '0', STR_PAD_LEFT) : '' }}--}}
                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($contract_data->record, 4, '0', STR_PAD_LEFT) }}
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
                            @if ($contract_data->record)
                                {{ str_pad($contract_data->record, 4, '0', STR_PAD_LEFT) }}
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

                    <tr> {{ $contract_data->created_at }} added by {{ $contract_data->originator }}
                          <th class="w-20">Initiator</th>
                          <td class="w-30">{{ $contract_data->originator }}</td>

                          <th class="w-20">Date of Initiation</th>
                          <td class="w-30">{{ Helpers::getdateFormat($contract_data->created_at) }}</td>
                    </tr>

                    <tr>
                          <th class="w-20">Short Description</th>
                          <td class="w-30">
                                @if ($contract_data->short_description_gi)
                                    {{ $contract_data->short_description_gi }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                          <th class="w-20">Assign To</th>
                          <td class="w-80">{{ $contract_data->assign_to_gi }}</td>
                    </tr>

                    <tr>
                         <th class="w-20">Date Due</th>
                           <td class="w-80">{{ $contract_data->due_date }}</td>

                           <th class="w-20">Supplier List</th>
                           <td class="w-30">
                               @if ($contract_data->supplier_list_gi)
                                   {{ $contract_data->supplier_list_gi }}

                               @endif
                           </td>
                    </tr>

                    <tr>
                           <th class="w-20">Distribution List</th>
                           <td class="w-30">
                                @if ($contract_data->distribution_list_gi)
                                    {{ $contract_data->distribution_list_gi }}

                                @endif
                           </td>
                     </tr>
                </table>

                <table>
                      <tr>
                            <th class="w-10">Description</th>
                            <td class="w-90">
                                @if ($contract_data->description_gi)
                                    {{ $contract_data->description_gi }}

                                @endif
                            </td>
                      </tr>
                </table>

                <table>
                    <tr>
                        <th class="w-20">Manufacturer</th>
                            <td class="w-30">
                                @if ($contract_data->manufacturer_gi)
                                    {{ $contract_data->manufacturer_gi }}

                                @endif
                            </td>

                            <th class="w-20">Priority level</th>
                            <td class="w-30">
                                @if ($contract_data->priority_level_gi)
                                    {{ $contract_data->priority_level_gi }}

                                @endif
                            </td>
                      </tr>

                      <tr>
                            <th class="w-20">Zone</th>
                            <td class="w-30">
                                @if ($contract_data->zone_gi)
                                    {{ $contract_data->zone_gi }}

                                @endif
                            </td>

                            <th class="w-20">Country</th>
                            <td class="w-30">
                                @if ($contract_data->country)
                                    {{ $contract_data->country }}

                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">State/District</th>
                            <td class="w-30">
                                @if ($contract_data->state)
                                    {{ $contract_data->state }}

                                @endif
                            </td>

                            <th class="w-20">City</th>
                            <td class="w-30">
                                @if ($contract_data->city)
                                    {{ $contract_data->city }}

                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Type</th>
                            <td class="w-30">
                                @if ($contract_data->type_gi)
                                    {{ $contract_data->type_gi }}

                                @endif
                            </td>

                            <th class="w-20">Other type</th>
                            <td class="w-30">
                                @if ($contract_data->other_type)
                                    {{ $contract_data->other_type }}

                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="block">
                    <div class="block-head">
                        Contract Details
                    </div>
                    <table>

                        <tr>
                            <th class="w-20">Actual start Date</th>
                            <td class="w-80">{{ date('d-M-Y', strtotime($contract_data->actual_start_date_cd)) }}</td>

                            <th class="w-20">Actual end Date</th>
                            <td class="w-80">{{ date('d-M-Y', strtotime($contract_data->actual_end_date_cd)) }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">Suppplier List</th>
                            <td class="w-80">{{ $contract_data->suppplier_list_cd }}</td>
                        </tr>
                    </table>

                    <table>
                        <tr>
                            <th class="w-20">Negotiation Team</th>
                            <td class="w-80">{{ $contract_data->negotiation_team_cd }}</td>
                        </tr>

                        <tr>
                            <th class="w-10">Comments</th>
                            <td class="w-90">{{ $contract_data->comments_cd }}</td>

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
                            <th class="w-20">Transaction</th>
                            <th class="w-20">Transaction Type</th>
                            <th class="w-20">Date</th>
                            <th class="w-20">Amount</th>
                            <th class="w-20">Currency Used</th>
                            <th class="w-20">Remarks</th>
                        </tr>

                            @php
                            $data = $grid_Data->data ? json_decode($grid_Data->data, true) : null;
                            @endphp

                         @if ($data && is_array($data))
                             @foreach ($data as $index => $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}.</td>
                                    <td>{{ isset($item['Transaction']) ? $item['Transaction'] : '' }}
                                    </td>
                                    <td>{{ isset($item['TransactionType']) ? $item['TransactionType'] : '' }}</td>
                                    <td>{{ isset($item['Date']) ? $item['Date'] : '' }}</td>
                                    <td>{{ isset($item['Amount']) ? $item['Amount'] : '' }}</td>
                                    <td>{{ isset($item['CurrencyUsed']) ? $item['CurrencyUsed'] : '' }}</td>
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
