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
                <!-- <td class="w-40">
                    {{ Helpers::divisionNameForQMS($data->division_id) }}/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                </td> -->
                <!-- <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                </td> -->
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
                        <!-- <th class="w-20">Severity Level</th>
                        <td class="w-80">{{ $data->severity_level_form }}</td> -->


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
                        <!-- <th class="w-20">Repeat Nature</th>
                        <td class="w-80">@if($data->repeat_nature){{ $data->repeat_nature }}@else Not Applicable @endif
                        </td> -->
                    </tr>
                    <tr>
                        <th class="w-20">Actual Cost </th>
                        <td class="w-80">@if($data->actual_cost){{ $data->actual_cost }}@else Not
                            Applicable @endif</td>
                        <th class="w-20">Currency</th>
                        <td class="w-80">@if($data->currency){{ $data->currency }}@else Not
                            Applicable @endif</td>
                    </tr>
                    <!-- <tr>
                        <th class="w-20"></th>
                        <td class="w-80">@if($data->capa_team){{ Helpers::getInitiatorName($data->capa_team) }}@else
                            Not Applicable @endif</td>
                    </tr> -->
                    <tr>
                        <th class="w-20">Comments</th>
                        <td class="w-80">
                            @if($data->Comments_Batch){{$data->Comments_Batch}}@else
                            Not Applicable @endif</td>

                    </tr>
                    <!-- <tr>
                        <th class="w-20">Initial Observation</th>
                        <td class="w-80">@if($data->initial_observation){{ $data->initial_observation}}@else Not
                            Applicable @endif</td>
                        <th class="w-20">Interim Containnment</th>
                        <td class="w-80">@if($data->interim_containnment){{ $data->interim_containnment }}@else Not
                            Applicable @endif</td>
                    </tr> -->
                    <tr>
                        <th class="w-20">Source Documents</th>
                        <td class="w-80">@if($data->document_attach){{ $data->document_attach }}@else Not
                            Applicable @endif</td>

                    </tr>
                </table>
                <!-- <tr>
                        <th class="w-20">QA Comments</th>
                        <td class="w-80">@if($data->capa_qa_comments){{ $data->capa_qa_comments }}@else Not Applicable
                            @endif</td>
                    </tr> -->


                <div class="block-head">
                    Parent Information
                </div>
                <table>
                    <tr>
                        <th class="w-20">Subject Name</th>
                        <td class="w-30">@if($data->subject_name){{ $data->subject_name }}@else Not
                            Applicable @endif</td>
                        <th class="w-20">Subject Name</th>
                        <td class="w-30">@if($data->subject_date){{ $data->subject_date }}@else Not
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
                    Material Details
                </div>
                <div class="border-table">
                    <table>
                        <tr class="table_bg">
                            <th class="w-20">SR no.</th>
                            <th class="w-20">Material Name</th>
                            <th class="w-20">Batch Number</th>
                            <th class="w-20">Date Of Manufacturing</th>
                            <th class="w-20">Date Of Expiry</th>
                            <th class="w-20">Batch Disposition</th>
                            <th class="w-20">Remark</th>
                            <th class="w-20">Batch Status</th>
                        </tr>

                    </table>
                </div>
            </div>
            <div class="block">
                <div class="block-head">
                    Equipment/Instruments Details
                </div>
                <div class="border-table">
                    <table>
                        <tr class="table_bg">
                            <th class="w-25">SR no.</th>
                            <th class="w-25">Equipment/Instruments Name</th>
                            <th class="w-25">Equipment/Instruments ID</th>
                            <th class="w-25">Equipment/Instruments Comments</th>
                        </tr>


                    </table>
                </div>
            </div>

            </table>
        </div>

        <div class="block">
            <div class="block-head">
                Other type CAPA Details
            </div>
            <table>
                <tr>
                    <th class="w-20">Details</th>
                    <td class="w-80">@if($data->details_new){{ $data->details_new }}@else Not Applicable @endif</td>
                </tr>
                <tr>
                    <th class="w-20">CAPA QA Comments
                    </th>
                    <td class="w-80">@if($data->capa_qa_comments){{ $data->capa_qa_comments }}@else Not Applicable
                        @endif</td>
                </tr>
                <tr>
                    <th class="w-20">CAPA Type</th>
                    <td class="w-80">@if($data->capa_type){{ $data->capa_type }}@else Not Applicable @endif</td>
                </tr>
                <tr>
                    <th class="w-20">Corrective Action</th>
                    <td class="w-80">@if($data->corrective_action){{ $data->corrective_action }}@else Not Applicable
                        @endif</td>
                </tr>
                <tr>
                    <th class="w-20">Preventive Action</th>
                    <td class="w-80">@if($data->preventive_action){{ $data->preventive_action }}@else Not Applicable
                        @endif</td>

                </tr>
                <tr>
                    <th class="w-20">Supervisor Review Comments
                    </th>
                    <td class="w-80">@if($data->supervisor_review_comments){{ $data->supervisor_review_comments }}@else
                        Not Applicable @endif</td>
                </tr>

                <div class="block-head">
                    CAPA Closure
                </div>
                <table>
                    <tr>
                        <th class="w-20">QA Review & Closure</th>
                        <td class="w-80">@if($data->qa_review){{ $data->qa_review }}@else Not Applicable @endif</td>
                        <th class="w-20">Due Date Extension Justification</th>
                        <td class="w-80">@if($data->due_date_extension){{ $data->due_date_extension }}@else Not
                            Applicable @endif</td>
                    </tr>
                    {{-- <tr>
                        <th class="w-20">Closure Attachment</th>
                        <td class="w-80">@if($data->closure_attachment)<a href="{{asset('upload/document/',$data->closure_attachment)}}">{{ $data->closure_attachment }}</a>@else
                    Not Applicable @endif</td>

                    </tr> --}}

                    <div class="block-head">
                        Closure Attachment
                    </div>
                    <div class="border-table">
                        <table>
                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">File </th>
                            </tr>
                            @if($data->closure_attachment)
                            @foreach(json_decode($data->closure_attachment) as $key => $file)
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
        </div>
        </table>
    </div>
    </div>


    <div class="block">
        <div class="block-head">
            Activity Log
        </div>
        <table>
            <tr>
                <th class="w-20">Plan Proposed By
                </th>
                <td class="w-30">{{ $data->plan_proposed_by }}</td>
                <th class="w-20">
                    Plan Proposed On</th>
                <td class="w-30">{{ $data->plan_proposed_on }}</td>
            </tr>
            <tr>
                <th class="w-20">Plan Approved By
                </th>
                <td class="w-30">{{ $data->plan_approved_by }}</td>
                <th class="w-20">
                    Plan Approved On</th>
                <td class="w-30">{{ $data->Plan_approved_on }}</td>
            </tr>
            <tr>
                <th class="w-20">QA More Info Required By
                </th>
                <td class="w-30">{{ $data->qa_more_info_required_by }}</td>
                <th class="w-20">
                    QA More Info Required On</th>
                <td class="w-30">{{ $data->qa_more_info_required_on }}</td>
            </tr>
            <tr>
                <th class="w-20">Cancelled By
                </th>
                <td class="w-30">{{ $data->cancelled_by }}</td>
                <th class="w-20">
                    Cancelled On</th>
                <td class="w-30">{{ $data->cancelled_on }}</td>
            </tr>
            <tr>
                <th class="w-20">Completed By
                </th>
                <td class="w-30">{{ $data->completed_by }}</td>
                <th class="w-20">
                    Completed On</th>
                <td class="w-30">{{ $data->completed_on }}</td>
            </tr>
            <tr>
                <th class="w-20">Approved By</th>
                <td class="w-30">{{ $data->approved_by }}</td>
                <th class="w-20">Approved On</th>
                <td class="w-30">{{ $data->approved_on }}</td>
            </tr>

            <tr>
                <th class="w-20">Rejected By</th>
                <td class="w-30">{{ $data->rejected_by }}</td>
                <th class="w-20">Rejected On</th>
                <td class="w-30">{{ $data->rejected_on }}</td>
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
                {{-- <td class="w-30">
                    <strong>Page :</strong> 1 of 1
                </td> --}}
            </tr>
        </table>
    </footer>

</body>

</html>