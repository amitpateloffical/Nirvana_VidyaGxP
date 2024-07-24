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
                    Medical Device Single Report
                </td>
                <td class="w-30">
                    <div class="logo">
                        <img src="https://navin.mydemosoftware.com/public/user/images/logo.png" alt=""
                            class="w-100">
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
                    {{ Helpers::divisionNameForQMS($data->division_id) }}/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->id, 4, '0', STR_PAD_LEFT) }}
                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($data->id, 4, '0', STR_PAD_LEFT) }}
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
                    <tr> {{ $data->initiator }} added by {{ $data->initiator }}
                        <th class="w-20">Initiator</th>
                        <td class="w-30">
                            @if($data->initiator)
                                {{ $data->initiator }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Date of Initiation</th>
                        <td class="w-30">
                            @if($data->date_of_initiation)
                                {{ $data->date_of_initiation }}
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
                            <th class="w-20">Record No.</th>
                            <td class="w-30">
                                @if ($data->record)
                                    {{ $data->record }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
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
                        <th class="w-20">Other Type</th>
                        <td class="w-30">
                            @if ($data->other_type)
                                {{ $data->other_type }}
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
                        <th class="w-20">Date Due</th>
                        <td class="w-30">
                            @if ($data->due_date)
                                {{ $data->due_date }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Related URLs</th>
                        <td class="w-30">
                            @if ($data->URLs)
                                {{ $data->URLs }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                         <div class="border-table">
                        <div class="block-head">
                            Attachment
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-100">Batch No</th>
                            </tr>
                            @if ($data->attachment)
                                @foreach (json_decode($data->attachment) as $key => $file)
                                    <tr>
                                        <td class="w-20">{{ $key + 1 }}</td>
                                        <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a> </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="w-20">1</td>
                                    <td class="w-20">Not Applicable</td>
                                </tr>
                            @endif

                        </table>
                     </div>


                    </table>
                    <div class="block">
                        <div class="block-head">
                            Product Information
                        </div>
                        <table>
                            <tr>
                                <th class="w-20">Trade Name</th>
                                <td class="w-30">
                                    @if ($data->trade_name)
                                        {!! $data->trade_name !!}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>

                                <th class="w-20">Manufacturer</th>
                                <td class="w-30">
                                    @if ($data->manufacturer)
                                        {!! $data->manufacturer !!}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th class="w-30">TheraPeutic Area</th>
                                <td class="w-20">
                                    @if ($data->therapeutic_area)
                                        {{ $data->therapeutic_area }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>

                                <th class="w-20">Prooduct Code</th>
                                    <td class="w-80">

                                        @if ($data->prooduct_code)
                                        <p>{!! $data->prooduct_code !!}</p>
                                        @else
                                            Not Applicable
                                        @endif
                                    </td>

                            </tr>
                        </table>

                    </div>
            </div>
                <table>
                     <tr>
                        <th class="w-20">Intended Use</th>
                        <td class="w-80">
                            @if ($data->intended_use)
                                {{ $data->intended_use }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <div class="block">
                        <div class="block-head">
                            Activity Log
                        </div>
                        <table>
                            <tr>
                                <th class="w-20">Started by </th>
                                <td class="w-30">{{ Auth::user()->name }}</td>
                                <th class="w-20">Started On</th>
                                {{-- <td class="w-30">{{  }}</td> --}}
                            </tr>
                            <tr>
                                <th class="w-20">Retired By</th>
                                <td class="w-30">{{ Auth::user()->name }}</td>
                                <th class="w-20">Retired On</th>
                                {{-- <td class="w-30">{{ }}</td> --}}

                            </tr>

                        </table>
                    </div>

                </table>
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
    </div>
</body>

</html>
