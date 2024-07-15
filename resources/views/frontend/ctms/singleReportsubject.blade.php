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
                    Subject Single Report
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
                    <strong> Subject </strong>
                </td>
                <td class="w-40">
                    {{ Helpers::divisionNameForQMS($data->division_id) }}/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
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
                {{-- <td class="w-30">
                    <strong>Page :</strong> 1 of 1
                </td> --}}
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
                        <td class="w-30">{{ $data->originator }}</td>

                        <th class="w-20">Date of Initiation</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->created_at) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Record Number</th>
                        <td class="w-80">@if($data->record){{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }} @else Not
                            Applicable @endif</td>
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-80">@if($data->division_code){{ $data->division_code }} @else Not Applicable @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Short Description</th>
                        <td class="w-80">@if($data->short_description){{ $data->short_description }}@else Not Applicable
                            @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Phase Of Study</th>
                        <td class="w-30">@if($data->phase_of_study){{$data->phase_of_study}}
                            @else
                            Not Applicable @endif</td>
                        <th class="w-20">Study Num</th>
                        <td class="w-80"> @if($data->study_Num){{ $data->study_Num }} @else Not Applicable @endif</td>

                    </tr>
                    <tr>
                        <th class="w-20">Assigned To</th>
                        <td class="w-30">@if($data->assign_to){{$data->assign_to}} @else
                            Not Applicable @endif</td>

                        <th class="w-20">Due Date</th>
                        <td class="w-80"> @if($data->due_date){{ $data->due_date }} @else Not Applicable @endif</td>

                    </tr>
                    <tr>
                        <th class="w-20">Attached Files</th>
                        <td class="w-80">@if($data->file_attach){{ $data->file_attach }}@else Not Applicable
                            @endif</td>

                        <th class="w-20">Related URLs</th>
                        <td class="w-80">@if($data->related_urls){{ $data->related_urls }}@else Not
                            Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Description</th>
                        <td class="w-80">@if($data->Description_Batch){{ $data->Description_Batch }}@else Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Actual Cost </th>
                        <td class="w-80">@if($data->actual_cost){{ $data->actual_cost }}@else Not
                            Applicable @endif</td>
                        <th class="w-20">Currency</th>
                        <td class="w-80">@if($data->currency){{ $data->currency }}@else Not
                            Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Comments</th>
                        <td class="w-80">
                            @if($data->Comments_Batch){{$data->Comments_Batch}}@else
                            Not Applicable @endif</td>

                    </tr>
                    <tr>
                        <th class="w-20">Source Documents</th>
                        <td class="w-80">@if($data->document_attach){{ $data->document_attach }}@else Not
                            Applicable @endif</td>

                    </tr>
                </table>

                <div class="block-head">
                    Parent Information
                </div>
                <table>
                    <tr>
                        <th class="w-20">Subject Name</th>
                        <td class="w-80">@if($data->subject_name){{ $data->subject_name }}@else Not
                            Applicable @endif</td>
                        <th class="w-20">Subject Name</th>
                        <td class="w-80">@if($data->subject_date){{ $data->subject_date }}@else Not
                            Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Gender</th>
                        <td class="w-80">@if($data->gender){{ $data->gender }}@else Not
                            Applicable @endif</td>
                        <th class="w-20">Race</th>
                        <td class="w-80">@if($data->race){{ $data->race }}@else Not
                            Applicable @endif</td>
                    </tr>
                </table>
            </div>

            <div class="block">
                <div class="block-head">
                    Submission Information
                </div>
                <table>
                    <tr>
                        <th class="w-20">Screened Successfully</th>
                        <td class="w-80">@if($data->screened_successfully){{ $data->screened_successfully }}@else Not
                            Applicable
                            @endif</td>
                        <th class="w-20">Reason For Discontinuation</th>
                        <td class="w-80">@if($data->discontinuation){{ $data->discontinuation }}@else Not
                            Applicable
                            @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Comments</th>
                        <td class="w-30">@if($data->Disposition_Batch){{$data->Disposition_Batch}}
                            @else
                            Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Treatment Consent Version</th>
                        <td class="w-80">@if($data->treatment_consent){{ $data->treatment_consent }}@else Not
                            Applicable
                            @endif</td>
                        <th class="w-20">Screening Consent Version</th>
                        <td class="w-80">@if($data->screening_consent){{ $data->screening_consent }}@else Not
                            Applicable
                            @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Exception Number</th>
                        <td class="w-30">@if($data->exception_no){{$data->exception_no}} @else
                            Not Applicable @endif</td>

                    </tr>
                    <tr>
                        <th class="w-20">Signed Consent Form </th>
                        <td class="w-80">@if($data->signed_consent){{ $data->signed_consent }}@else Not Applicable
                            @endif</td>

                        <th class="w-20">Time Point</th>
                        <td class="w-80">@if($data->time_point){{ $data->time_point }}@else Not
                            Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Family History</th>
                        <td class="w-80">@if($data->family_history){{ $data->family_history }}@else Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Baseline Assessment</th>
                        <td class="w-80">@if($data->Baseline_assessment){{ $data->Baseline_assessment }}@else Not
                            Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Representive </th>
                        <td class="w-80">@if($data->representive){{ $data->representive }}@else Not
                            Applicable @endif</td>
                    </tr>

                </table>
                <div class="block-head">
                    Location
                </div>
                <table>
                    <tr>
                        <th class="w-20">Zone</th>
                        <td class="w-30">@if($data->zone){{ $data->zone }}@else Not
                            Applicable @endif</td>
                        <th class="w-20">Country</th>
                        <td class="w-30">@if($data->country){{ $data->country }}@else Not
                            Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">City</th>
                        <td class="w-80">@if($data->city){{ $data->city }}@else Not
                            Applicable @endif</td>
                        <th class="w-20">State/District</th>
                        <td class="w-80">@if($data->district){{ $data->district }}@else Not
                            Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Site Name</th>
                        <td class="w-80">@if($data->site){{ $data->site }}@else Not
                            Applicable @endif</td>
                        <th class="w-20">Building</th>
                        <td class="w-80">@if($data->building){{ $data->building }}@else Not
                            Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Floor</th>
                        <td class="w-80">@if($data->floor){{ $data->floor }}@else Not
                            Applicable @endif</td>
                        <th class="w-20">Room</th>
                        <td class="w-80">@if($data->room){{ $data->room }}@else Not
                            Applicable @endif</td>
                    </tr>
                </table>
            </div>

            <div class="block">
                <div class="block-head">
                    Important Dates
                </div>
                <table>
                    <tr>
                        <th class="w-20">Consent Form Signed On</th>
                        <td class="w-80">@if($data->consent_form){{ $data->consent_form }}@else Not
                            Applicable
                            @endif</td>
                        <th class="w-20">Date Granted</th>
                        <td class="w-80">@if($data->date_granted){{ $data->date_granted }}@else Not
                            Applicable
                            @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">System Start Date</th>
                        <td class="w-80">@if($data->system_start){{ $data->system_start }}@else Not
                            Applicable
                            @endif</td>
                        <th class="w-20">Consent Form Signed Date</th>
                        <td class="w-80">@if($data->consent_form_date){{ $data->consent_form_date }}@else Not
                            Applicable
                            @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Consent Form Signed Date</th>
                        <td class="w-80">@if($data->consent_form_date){{ $data->consent_form_date }}@else Not
                            Applicable
                            @endif</td>
                        <th class="w-20">Date Of First Treatment</th>
                        <td class="w-80">@if($data->first_treatment){{ $data->first_treatment }}@else Not
                            Applicable
                            @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Date Requested</th>
                        <td class="w-80">@if($data->date_requested){{ $data->date_requested }}@else Not
                            Applicable
                            @endif</td>
                        <th class="w-20">Date Screened</th>
                        <td class="w-80">@if($data->date_screened){{ $data->date_screened }}@else Not
                            Applicable
                            @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Date Signed Treatment Consent</th>
                        <td class="w-80">@if($data->date_signed_treatment){{ $data->date_signed_treatment }}@else Not
                            Applicable
                            @endif</td>

                        <th class="w-20">Effective From Date </th>
                        <td class="w-80">@if($data->date_effective_from){{ $data->date_effective_from }}@else Not
                            Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Effective To Date</th>
                        <td class="w-80">@if($data->date_effective_to){{ $data->date_effective_to }}@else Not
                            Applicable
                            @endif</td>

                        <th class="w-20">Effective From Date </th>
                        <td class="w-80">@if($data->date_effective_from){{ $data->date_effective_from }}@else Not
                            Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Effective To Date</th>
                        <td class="w-80">@if($data->date_effective_to){{ $data->date_effective_to }}@else Not
                            Applicable
                            @endif</td>

                        <th class="w-20">Effective From Date </th>
                        <td class="w-80">@if($data->date_effective_from){{ $data->date_effective_from }}@else Not
                            Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Last Active Treatment Date</th>
                        <td class="w-80">@if($data->last_active){{ $data->last_active }}@else Not
                            Applicable
                            @endif</td>

                        <th class="w-20">Last Follow-up Date </th>
                        <td class="w-80">@if($data->last_followup){{ $data->last_followup }}@else Not
                            Applicable @endif</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>




</body>

</html>