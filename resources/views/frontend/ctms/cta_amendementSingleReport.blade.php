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
                    CTA-Amendement Single Report
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
                    <strong>CTA-Amendement No.</strong>{{ $amendement_data->id }}
                </td>
                <td class="w-40">
                       {{ Helpers::getDivisionName($amendement_data->division_id) }}/CTA_Amendement/{{ Helpers::year($amendement_data->created_at) }}/{{ $amendement_data->record }}
                    {{--{{ Helpers::divisionNameForQMS($study_data->division_id) }}/{{ Helpers::year($study_data->created_at) }}/{{ $study_data->record_number ? str_pad($study_data->record_number->record_number, 4, '0', STR_PAD_LEFT) : '' }}--}}
                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($amendement_data->record, 4, '0', STR_PAD_LEFT) }}
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
                            @if ($amendement_data->record)
                                {{ str_pad($amendement_data->record, 4, '0', STR_PAD_LEFT) }}
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
                    <tr> {{ $amendement_data->created_at }} added by {{ $amendement_data->originator }}
                        <th class="w-20">Initiator</th>
                         <td class="w-30">{{ $amendement_data->originator }}</td>

                        <th class="w-20">Date of Initiation</th>
                         <td class="w-30">{{ Helpers::getdateFormat($amendement_data->created_at) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Short Description</th>
                            <td class="w-30">
                                @if ($amendement_data->short_description)
                                    {{ $amendement_data->short_description }}
                                @endif
                            </td>

                        <th class="w-20">Assign To</th>
                          <td class="w-80">{{ $amendement_data->assign_to_gi }}</td>

                    </tr>

                    <tr>
                         <th class="w-20">Date Due</th>
                           <td class="w-80">{{ date('d-M-Y', strtotime($amendement_data->due_date)) }}</td>

                           <th class="w-20">Type</th>
                           <td class="w-30">
                               @if ($amendement_data->type)
                                   {{ $amendement_data->type }}

                               @endif
                           </td>
                    </tr>

                    <tr>
                         <th class="w-20">Other Type</th>
                            <td class="w-30">
                                @if ($amendement_data->other_type)
                                    {{ $amendement_data->other_type }}

                                @endif
                            </td>
                    </tr>
                    </table>

                    <table>
                        <tr>
                            <th class="w-15">Description</th>
                            <td class="w-85">
                                @if ($amendement_data->description)
                                    {{ $amendement_data->description }}

                                @endif
                            </td>
                        </tr>
                    </table>

                    <table>
                        <tr>
                            <th class="w-20">Zone</th>
                            <td class="w-30">
                                @if ($amendement_data->zone)
                                    {{ $amendement_data->zone }}

                                @endif
                            </td>

                            <th class="w-20">Country</th>
                            <td class="w-30">
                                @if ($amendement_data->country)
                                    {{ $amendement_data->country }}

                                @endif
                            </td>
                      </tr>
                      <tr>
                            <th class="w-20">State/District</th>
                            <td class="w-30">
                                @if ($amendement_data->state)
                                    {{ $amendement_data->state }}

                                @endif
                            </td>

                            <th class="w-20">City</th>
                            <td class="w-30">
                                @if ($amendement_data->city)
                                    {{ $amendement_data->city }}

                                @endif
                            </td>
                        </tr>

                    </table>
                </div>

                <div class="block">
                    <div class="block-head">
                        Amendement Information
                    </div>
                    <table>

                        <tr>
                            <th class="w-20">Procedure Number</th>
                            <td class="w-80">{{ $amendement_data->procedure_number }}</td>

                            <th class="w-20">Project Code</th>
                            <td class="w-80">{{ $amendement_data->project_code }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">Registration Number</th>
                            <td class="w-80">{{ $amendement_data->registration_number }}</td>

                            <th class="w-20">Other Authority</th>
                            <td class="w-80">{{ $amendement_data->other_authority }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">Authority Type</th>
                            <td class="w-80">{{ $amendement_data->authority_type }}</td>

                            <th class="w-20">Authority</th>
                            <td class="w-80">{{ $amendement_data->authority }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">Year</th>
                            <td class="w-80">{{ $amendement_data->year }}</td>

                            <th class="w-20">Registration Status</th>
                            <td class="w-80">{{ $amendement_data->registration_status }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">CAR Clouser Time Weight</th>
                            <td class="w-80">{{ $amendement_data->car_clouser_time_weight }}</td>

                            <th class="w-20">Outcome</th>
                            <td class="w-80">{{ $amendement_data->outcome }}</td>
                        </tr>

                        <tr>
                            <th class="w-20">Trade Name</th>
                            <td class="w-80">{{ $amendement_data->trade_name }}</td>

                            <th class="w-20">Estimated Man-Hours</th>
                            <td class="w-80">{{ $amendement_data->estimated_man_hours }}</td>
                        </tr>
                    </table>

                    <table>
                        <tr>
                            <th class="w-15">Comments</th>
                            <td class="w-85">{{ $amendement_data->comments }}</td>

                        </tr>
                    </table>

                    <table>
                        <tr>
                            <th class="w-20">Manufacturer</th>
                            <td class="w-80">{{ $amendement_data->manufacturer }}</td>
                        </tr>
                    </table>
                </div>


            <div class="block">
                {{-- <div class="block"> --}}
                {{-- <div class="block-head"> --}}
                <div style="font-weight: 200">Product/Material</div>
                {{-- </div> --}}
                <div class="border-table">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">Sr. No.</th>
                            <th class="w-20">Product Name</th>
                            <th class="w-10">Batch Number</th>
                            <th class="w-10">Expiry Date</th>
                            <th class="w-10">Manufactured Date</th>
                            <th class="w-20">Disposition</th>
                            <th class="w-20">Comments</th>
                            <th class="w-20">Remarks</th>
                        </tr>

                            @php
                              $data = isset($grid_Data) && $grid_Data->data ? json_decode($grid_Data->data, true) : null;
                            @endphp
                             @if ($data && is_array($data))
                               @foreach ($data as $index => $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}.</td>
                                    <td>{{ isset($item['ProductName']) ? $item['ProductName'] : '' }}
                                    </td>
                                    <td>{{ isset($item['BatchNumber']) ? $item['BatchNumber'] : '' }}</td>
                                    <td>{{ isset($item['ExpiryDate']) ? $item['ExpiryDate'] : '' }}</td>
                                    <td>{{ isset($item['ManufacturedDate']) ? $item['ManufacturedDate'] : '' }}</td>
                                    <td>{{ isset($item['Disposition']) ? $item['Disposition'] : '' }}</td>
                                    <td>{{ isset($item['Comments']) ? $item['Comments'] : '' }}</td>
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
                <div class="block-head">
                    Important Dates
                </div>
                <table>

                    <tr>
                        <th class="w-20">Actual Submission Date</th>
                        <td class="w-30">{{ date('d-M-Y', strtotime($amendement_data->actual_submission_date)) }}</td>

                        <th class="w-20">Actual Rejection Date</th>
                        <td class="w-30">{{ date('d-M-Y', strtotime($amendement_data->actual_rejection_date)) }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Actual Withdrawn Date</th>
                        <td class="w-30">{{ date('d-M-Y', strtotime($amendement_data->actual_withdrawn_date)) }}</td>

                        <th class="w-20">Inquiry Date</th>
                        <td class="w-30">{{ date('d-M-Y', strtotime($amendement_data->inquiry_date)) }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Planned Submission Date</th>
                        <td class="w-30">{{ date('d-M-Y', strtotime($amendement_data->planned_submission_date)) }}</td>

                        <th class="w-20">Planned Date Sent To Affiliate</th>
                        <td class="w-30">{{ date('d-M-Y', strtotime($amendement_data->planned_date_sent_to_affiliate)) }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Effective Date</th>
                        <td class="w-30">{{ date('d-M-Y', strtotime($amendement_data->effective_date)) }}</td>
                    </tr>
                </table>
            </div>

            <div class="block">
                <div class="block-head">
                    Person Involved
                </div>
                <table>

                    <tr>
                        <th class="w-20">Additional Assignees</th>
                        <td class="w-80">{{ $amendement_data->additional_assignees }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Additional Investigators</th>
                        <td class="w-80">{{ $amendement_data->additional_investigators }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Approvers</th>
                        <td class="w-80">{{ $amendement_data->approvers }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Negotiation Team</th>
                        <td class="w-80">{{ $amendement_data->negotiation_team }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Trainer</th>
                        <td class="w-80">{{ $amendement_data->trainer }}</td>

                    </tr>

                </table>
            </div>


            <div class="block">
                <div class="block-head">
                    Root Cause
                </div>
                <table>

                    <tr>
                        <th class="w-20">Root Cause Description</th>
                        <td class="w-80">{{ $amendement_data->root_cause_description }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Reason for Non-Approval</th>
                        <td class="w-80">{{ $amendement_data->reason_for_non_approval }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Reason for Withdrawal</th>
                        <td class="w-80">{{ $amendement_data->reason_for_withdrawal }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Justification/Rationale</th>
                        <td class="w-80">{{ $amendement_data->justification_rationale }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Meeting Minutes</th>
                        <td class="w-80">{{ $amendement_data->meeting_minutes }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Rejection Reason</th>
                        <td class="w-80">{{ $amendement_data->rejection_reason }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Effectiveness Check Summary</th>
                        <td class="w-80">{{ $amendement_data->effectiveness_check_summary }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Decision</th>
                        <td class="w-80">{{ $amendement_data->decision }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Summary</th>
                        <td class="w-80">{{ $amendement_data->summary }}</td>
                    </tr>
                </table>

                <table>
                    <tr>
                        <th class="w-20">Documents Affected</th>
                        <td class="w-80">{{ $amendement_data->documents_affected }}</td>

                        <th class="w-20">Actual Time Spend</th>
                        <td class="w-80">{{ $amendement_data->actual_time_spend }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Documents</th>
                        <td class="w-80">{{ $amendement_data->documents }}</td>
                    </tr>

                </table>
            </div>

</body>

</html>
