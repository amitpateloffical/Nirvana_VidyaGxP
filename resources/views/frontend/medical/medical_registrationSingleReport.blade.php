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
                    Medical Device Registration Single Report
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
                    <strong>Medical Device Registration No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::divisionNameForQMS($data->division_id) }}/{{ Helpers::year($data->created_at) }}/MR/{{ str_pad($data->record_number, 4, '0', STR_PAD_LEFT) }}
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

                        <th class="w-20">Assigned To</th>
                        <td class="w-30">
                            @if ($data->assign_to)
                                {{ Helpers::getInitiatorName($data->assign_to) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Class (Risk Based)</th>
                        <td class="w-30">
                            @if ($data->risk_based_departments)
                                {{ $data->risk_based_departments }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Device Approval Type</th>
                        <td class="w-30">
                            @if ($data->device_approval_departments)
                                {{ $data->device_approval_departments }}
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
                        <th class="w-20">Registration Type</th>
                        <td class="w-30" >
                            @if ($data->registration_type_gi)
                                {{ $data->registration_type_gi}}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Date Due</th>
                        <td class="w-30">
                            @if ($data->due_date_gi)
                                {{ $data->due_date_gi}}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>


                    <tr>
                        <th class="w-20">(Parent) Trade Name</th>
                        <td class="w-30">
                            @if ($data->parent_record_number)
                                {{ $data->parent_record_number }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Local Trade Name</th>
                        <td class="w-30">
                            @if ($data->local_record_number)
                                {{ $data->local_record_number }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        </tr>



                        <tr>
                            <th class="w-20">Zone</th>
                            <td class="w-30">
                                @if ($data->zone_departments)
                                    {{ $data->zone_departments }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                            <th class="w-20">Country</th>
                            <td class="w-30">
                                @if ($data->country_number)
                                    {{ $data->country_number }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>


                        <tr>
                            <th class="w-20">Registration number</th>
                            <td class="w-30">
                                @if ($data->registration_number)
                                    {{ $data->registration_number }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                            <th class="w-20">Regulatory body</th>
                            <td class="w-30">
                                @if ($data->regulatory_departments)
                                    {{ $data->regulatory_departments }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </tr>

                    <tr>
                        <th class="w-20">Marketing Authorization Holder</th>
                        <td class="w-30">
                            @if ($data->marketing_auth_number)
                                {{ $data->marketing_auth_number }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Manufacturer</th>
                        <td class="w-30">
                            @if ($data->manufacturer_number)
                                {{ $data->manufacturer_number }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        </tr>



                        <tr>
                            <th class="w-20">Zone</th>
                            <td class="w-30">
                                @if ($data->zone_departments)
                                    {{ $data->zone_departments }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                            <th class="w-20">Country</th>
                            <td class="w-30">
                                @if ($data->country_number)
                                    {{ $data->country_number }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>


                        <tr>
                            <th class="w-20">Registration number</th>
                            <td class="w-30">
                                @if ($data->registration_number)
                                    {{ $data->registration_number }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                            <th class="w-20">Regulatory body</th>
                            <td class="w-30">
                                @if ($data->regulatory_departments)
                                    {{ $data->regulatory_departments }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </tr>

                    <tr>
                        <th class="w-20">Marketing Authorization Holder</th>
                        <td class="w-30">
                            @if ($data->marketing_auth_number)
                                {{ $data->marketing_auth_number }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Manufacturer</th>
                        <td class="w-30">
                            @if ($data->manufacturer_number)
                                {{ $data->manufacturer_number }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        </tr>

                        <tr>
                            <th class="w-20">Zone</th>
                            <td class="w-30">
                                @if ($data->zone_departments)
                                    {{ $data->zone_departments }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                            <th class="w-20">Country</th>
                            <td class="w-30">
                                @if ($data->country_number)
                                    {{ $data->country_number }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>


                        <tr>
                            <th class="w-20">Manufacturing Site</th>
                            <td class="w-30">
                                @if ($data->manufacturing_description)
                                    {{ $data->manufacturing_description }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                            <th class="w-20">Dossier Parts</th>
                            <td class="w-30">
                                @if ($data->dossier_number)
                                    {{ $data->dossier_number }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Related Dossier Document</th>
                            <td class="w-30">
                                @if ($data->dossier_departments)
                                    {{ $data->dossier_departments }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                            <th class="w-20">Description</th>
                            <td class="w-30">
                                @if ($data->description)
                                    {{ $data->description }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Planned Submission Date</th>
                            <td class="w-30">
                                @if ($data->planned_submission_date)
                                    {{ $data->planned_submission_date }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                            <th class="w-20">Actual Submission Date</th>
                            <td class="w-30">
                                @if ($data->actual_submission_date)
                                    {{ $data->actual_submission_date }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Actual Approval Date</th>
                            <td class="w-30">
                                @if ($data->actual_approval_date)
                                    {{ $data->actual_approval_date }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                            <th class="w-20">Actual Rejection Date</th>
                            <td class="w-30">
                                @if ($data->actual_rejection_date)
                                    {{ $data->actual_rejection_date }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Renewal Rule</th>
                            <td class="w-30">
                                @if ($data->renewal_departments)
                                    {{ $data->renewal_departments }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                            <th class="w-20">Next Renewal Date</th>
                            <td class="w-30">
                                @if ($data->next_renewal_date)
                                    {{ $data->next_renewal_date }}
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
                                @if ($data->file_attachment_gi)
                                    <a href="{{ asset('upload/document/', $data->file_attachment_gi) }}">
                                        {{ $data->file_attachment_gi }}</a>
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
                        <th class="w-20"> Assign Responsible By</th>
                        <td class="w-30">{{ $data->assign_by }}</td>
                        <th class="w-20">Assign Responsible On</th>
                        <td class="w-30">{{ $data->assign_on }}</td>
                        <th class="w-20">Comment</th>
                        <td class="w-30">{{ $data->comment }}</td>
                    </tr>


                    <tr>
                        <th class="w-20">Cancel By</th>
                        <td class="w-30">{{ $data->cancel_by }}</td>
                        <th class="w-20">Cancel On</th>
                        <td class="w-30">{{ $data->cancel_on}}</td>
                        <th class="w-20">Comment</th>
                        <td class="w-30">{{ $data->cancel_comment }}</td>

                    </tr>
                    <tr>
                        <th class="w-20">Classify By</th>
                        <td class="w-30">{{ $data->classify_by }}</td>
                        <th class="w-20">Classify On</th>
                        <td class="w-30">{{ $data->classify_on }}</td>
                        <th class="w-20">Comment</th>
                        <td class="w-30">{{ $data->classify_comment}}</td>

                    </tr>
                    <tr>
                        <th class="w-20">Reject By</th>
                        <td class="w-30">{{ $data->reject_by }}</td>
                        <th class="w-20">Reject On</th>
                        <td class="w-30">{{ $data->reject_on }}</td>
                        <th class="w-20">Comment</th>
                        <td class="w-30">{{ $data->reject_comment}}</td>

                    </tr>

                    <tr>
                        <th class="w-20">Submit To Regulator By</th>
                        <td class="w-30">{{ $data->submit_by }}</td>
                        <th class="w-20">Submit To Regulator On</th>
                        <td class="w-30">{{ $data->submit_on }}</td>
                        <th class="w-20">Comment</th>
                        <td class="w-30">{{ $data->submit_comment}}</td>

                    </tr>
                    <tr>
                        <th class="w-20">Cancelled By</th>
                        <td class="w-30">{{ $data->cancelled_by }}</td>
                        <th class="w-20">Cancelled On</th>
                        <td class="w-30">{{ $data->cancelled_on }}</td>
                        <th class="w-20">Comment</th>
                        <td class="w-30">{{ $data->cancelled_comment}}</td>

                    </tr>

                    <tr>
                        <th class="w-20">Refused By</th>
                        <td class="w-30">{{ $data->refused_by }}</td>
                        <th class="w-20">Refused On</th>
                        <td class="w-30">{{ $data->refused_on }}</td>
                        <th class="w-20">Comment</th>
                        <td class="w-30">{{ $data->refused_comment}}</td>

                    </tr>

                    <tr>
                        <th class="w-20">Approval Received By</th>
                        <td class="w-30">{{ $data->received_by }}</td>
                        <th class="w-20">Approval Received On</th>
                        <td class="w-30">{{ $data->received_on }}</td>
                        <th class="w-20">Comment</th>
                        <td class="w-30">{{ $data->received_comment}}</td>

                    </tr>

                    <tr>
                        <th class="w-20">Withdraw By</th>
                        <td class="w-30">{{ $data->withdraw_by }}</td>
                        <th class="w-20">Withdraw On</th>
                        <td class="w-30">{{ $data->withdraw_on }}</td>
                        <th class="w-20">Comment</th>
                        <td class="w-30">{{ $data->withdraw_comment}}</td>

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
