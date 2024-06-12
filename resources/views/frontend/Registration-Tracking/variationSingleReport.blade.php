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
                    Variation Report
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
                    <strong> Variation No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::divisionNameForQMS($data->ootc_id) }}/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                </td>
            </tr>
        </table>
    </header>

    <div class="inner-block">
        <div class="content-table">
            <div class="inner-block">
                <div class="content-table">
                    <div class="block">
                        <div class="block-head">
                            Variation
                        </div>
                        <div class="block-head">
                            General Information
                        </div>
                        <table>
                            <tr>
                                <th class="w-20">(Root Parent) Trade Name</th>
                                <td class="w-30">
                                    @if ($data->trade_name)
                                        {{ $data->trade_name }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">(Parent) Member State</th>
                                <td class="w-30">
                                    @if ($data->member_state)
                                        {{ $data->member_state }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Initiator</th>
                                <td class="w-30">{{ Helpers::getInitiatorName($data->initiator) }}</td>
                                <th class="w-20">Date of Initiation</th>
                                <td class="w-30">{{ $data->created_at ? $data->created_at->format('d-M-Y') : '' }} </td>
                            </tr>
                            <tr>
                                <th class="w-20">Short Description</th>
                                <td class="w-80">
                                    @if ($data->short_description)
                                        {{ $data->short_description }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Assigned To</th>
                                <td class="w-30">{{ Helpers::getInitiatorName($data->assigned_to) }}</td>
                                <th class="w-20">Due Date</th>
                                <td class="w-30">
                                    @if ($data->date_due)
                                        {{ Helpers::getdateFormat($data->date_due) }}
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
                                <th class="w-20">Related Change Control</th>
                                <td class="w-30">
                                    @if ($data->related_change_control)
                                        {{ $data->related_change_control }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Variation Description</th>
                                <td class="w-80">
                                    @if ($data->variation_description)
                                        {{ $data->variation_description }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20"> Variation Code</th>
                                <td class="w-30">
                                    @if ($data->variation_code)
                                        {{ $data->variation_code }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <div class="border-table">
                            <div class="block-">
                               File Attachment
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data->attached_files)
                                    @foreach (json_decode($data->attached_files) as $key => $file)
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
                        <table>
                            <tr>
                                <th class="w-20">Change From </th>
                                <td class="w-30">
                                    @if ($data->change_from)
                                        {{ $data->change_from }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20"> Change To</th>
                                <td class="w-30">
                                    @if ($data->change_to)
                                        {{ $data->change_to }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Description</th>
                                <td class="w-80">
                                    @if ($data->description)
                                        {{ $data->description }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Documents</th>
                                <td class="w-30">
                                    @if ($data->documents)
                                        {{ $data->documents }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <div class="block">
                            <div class="head">
                                <div class="block-head">
                                    Variation Plan
                                </div>
                                <div class="block-head">
                                    Registration Plan
                                </div>
                                <table>
                                    <tr>
                                        <th class="w-20">Registration Status</th>
                                        <td class="w-30">
                                            <div>
                                                @if ($data->registration_status)
                                                    {{ $data->registration_status }}
                                                @else
                                                    Not Applicable
                                                @endif
                                            </div>
                                        </td>
                                        <th class="w-20">Registration Number</th>
                                        <td class="w-30">
                                            <div>
                                                @if ($data->registration_number)
                                                    {{ $data->registration_number }}
                                                @else
                                                    Not Applicable
                                                @endif
                                            </div>
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
                                        <th class="w-20">Planned Submission Date</th>
                                        <td class="w-30">
                                            <div>
                                                @if ($data->planned_submission_date)
                                                    {{ Helpers::getdateFormat($data->planned_submission_date) }}
                                                @else
                                                    Not Applicable
                                                @endif
                                            </div>
                                        </td>
                                        <th class="w-20">Actual Submission Date</th>
                                        <td class="w-30">
                                            <div>
                                                @if ($data->actual_submission_date)
                                                    {{ Helpers::getdateFormat($data->actual_submission_date) }}
                                                @else
                                                    Not Applicable
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-20">Planned Approval Date</th>
                                        <td class="w-30">
                                            <div>
                                                @if ($data->planned_approval_date)
                                                    {{ Helpers::getdateFormat($data->planned_approval_date) }}
                                                @else
                                                    Not Applicable
                                                @endif
                                            </div>
                                        </td>
                                        <th class="w-20">Actual Approval Date</th>
                                        <td class="w-30">
                                            <div>
                                                @if ($data->actual_approval_date)
                                                    {{ Helpers::getdateFormat($data->actual_approval_date) }}
                                                @else
                                                    Not Applicable
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-20">Actual Withdrawn Date</th>
                                        <td class="w-30">
                                            <div>
                                                @if ($data->actual_withdrawn_date)
                                                    {{ Helpers::getdateFormat($data->actual_withdrawn_date) }}
                                                @else
                                                    Not Applicable
                                                @endif
                                            </div>
                                        </td>
                                        <th class="w-20">Actual Rejection Date</th>
                                        <td class="w-30">
                                            <div>
                                                @if ($data->actual_rejection_date)
                                                    {{ Helpers::getdateFormat($data->actual_rejection_date) }}
                                                @else
                                                    Not Applicable
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-20">Comments</th>
                                        <td class="w-80">
                                            <div>
                                                @if ($data->comments)
                                                    {{ $data->comments }}
                                                @else
                                                    Not Applicable
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-20">Related Countries</th>
                                        <td class="w-30">
                                            <div>
                                                @if ($data->related_countries)
                                                    {{ $data->related_countries }}
                                                @else
                                                    Not Applicable
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="block">
                            <div class="head">
                                <div class="block-head">
                                    Product Details
                                </div>
                                <table>
                                    <tr>
                                        <th class="w-20">(Root Parent ) Trade Name</th>
                                        <td class="w-30">
                                            <div>
                                                @if ($data->product_trade_name)
                                                    {{ $data->product_trade_name }}
                                                @else
                                                    Not Applicable
                                                @endif
                                            </div>
                                        </td>
                                        <th class="w-20">(Parent) Local Trade Name</th>
                                        <td class="w-30">
                                            <div>
                                                @if ($data->local_trade_name)
                                                    {{ $data->local_trade_name }}
                                                @else
                                                    Not Applicable
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="w-20">(Parent) Manufacturer</th>
                                        <td class="w-30">
                                            <div>
                                                @if ($data->manufacturer)
                                                    {{ $data->manufacturer }}
                                                @else
                                                    Not Applicable
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    <div class="block">
                        <div class="head">
                            <div class="block">
                                <div class="head">
                                    <div class="block-head">
                                        Packaging Information (0)
                                    </div>
                                    <div class="border-table">
                                        <table>
                                            <tr class="table_bg">
                                                <th >Sr. No.</th>
                                                <th >Primary Packaging</th>
                                                <th >Material</th>
                                                <th >Pack Size</th>
                                                <th >Shelf Life</th>
                                                <th >Storage Condition</th>
                                                <th >Secondary Packaging</th>
                                                <th >Remarks</th>

                                            </tr>
                                             @if ($packaging && is_array($packaging->data))
                                            @php
                                                $serialNumber = 1;
                                            @endphp
                                                @foreach ($packaging->data as $gridData)
                                                    <tr>
                                                        <td >{{ $serialNumber++ }}</td>
                                                        <td >{{ isset($gridData['PrimaryPackaging']) ? $gridData['PrimaryPackaging'] : 'Not Applicable' }} </td>
                                                        <td >{{ isset($gridData['Material']) ? $gridData['Material'] : 'Not Applicable' }} </td>
                                                        <td >{{ isset($gridData['PackSize']) ? $gridData['PackSize'] : 'Not Applicable' }} </td>
                                                        <td >{{ isset($gridData['ShelfLife']) ? $gridData['ShelfLife'] : 'Not Applicable' }} </td>
                                                        <td >{{ isset($gridData['StorageCondition']) ? $gridData['StorageCondition'] : 'Not Applicable' }}
                                                        <td >{{ isset($gridData['SecondaryPackaging']) ? $gridData['SecondaryPackaging'] : 'Not Applicable' }}
                                                        <td >{{ isset($gridData['Remarks']) ? $gridData['Remarks'] : 'Not Applicable' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>1</td>
                                                    <td>Not Applicable</td>
                                                    <td>Not Applicable</td>
                                                    <td>Not Applicable</td>
                                                    <td>Not Applicable</td>
                                                    <td>Not Applicable</td>
                                                    <td>Not Applicable</td>
                                                    <td>Not Applicable</td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
            </tr>
        </table>
    </footer>
</body>

</html>
