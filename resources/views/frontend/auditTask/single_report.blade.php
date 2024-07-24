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

    .bold-small {
        font-weight: bold;
        font-size: 14px;
        /* Adjust the size as needed */
    }
</style>

<body>

    <header>
        <table>
            <tr>
                <td class="w-70 head">
                    Audit Task Single Report
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
                    <strong> Audit Task No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::divisionNameForQMS($data->division_id) }}/AT/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
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
            </tr>
        </table>
    </footer>

    <div class="inner-block">
        <div class="content-table">
            <div class="inner-block">
                <div class="content-table">
                    <div class="block">
                        <div class="block-head">
                            Parent Record Information
                        </div>
                        <table>
                            <tr>
                                <th class="w-20">Date of Opened </th>
                                <td class="w-30">{{ $data->created_at ? $data->created_at->format('d-M-Y') : '' }}
                                </td>

                                <th class="w-20">(parent) CTL Audit No.</th>
                                <td class="w-30">
                                    @if ($data->audit_nu)
                                        {{ $data->audit_nu }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>


                            </tr>
                            <tr>
                                <th class="w-20">(parent) Audit Report Ref. No. </th>
                                <td class="w-30">
                                    @if ($data->audit_report_nu)
                                        {{ $data->audit_report_nu }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>

                                <th class="w-20">(parent) Name of Contract Testing Lab</th>
                                <td class="w-30">
                                    @if ($data->name_contract_testing)
                                        {{ $data->name_contract_testing }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>


                            </tr>
                            <tr>
                                <th class="w-20">(parent) Final Responce Received on </th>
                                <td class="w-30">
                                    @if ($data->final_responce_on)
                                        {{ $data->final_responce_on }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>

                                <th class="w-20">(parent) TCD For CAPA Implimention</th>
                                <td class="w-30">
                                    @if ($data->tcd_capa_implimention)
                                        {{ $data->tcd_capa_implimention }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>


                            </tr>
                        </table>

                        <div class="block-head">
                            General Information
                        </div>
                        <table>

                            <tr> {{ $data->created_at }} added by {{ $data->originator }}
                                <th class="w-20">Site/Location Code</th>
                                <td class="w-30"> {{ Helpers::getDivisionName(session()->get('division')) }}</td>
                                <th class="w-20">Initiator</th>
                                <td class="w-30">{{ Helpers::getInitiatorName($data->initiator_id) }}</td>
                                </td>
                            </tr>
                            <tr>
                                <th class="w-20">Assignee</th>
                                <td class="w-30">
                                    @if ($data->assignee)
                                        {{ $data->assignee }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">TCD For Clouser Of Audit Task</th>
                                <td class="w-30">
                                    @if ($data->closure_of_task)
                                        {{ $data->closure_of_task }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th class="w-20">Classification</th>
                                <td class="w-30">
                                    @if ($data->classification)
                                        {{ $data->classification }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                {{-- <th class="w-20">TimeLine Proposed By Auditee</th>
                                <td class="w-30">
                                    @if ($data->timeline_by_auditee)
                                        {{ $data->timeline_by_auditee }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td> --}}
                                <th class="w-20">TimeLine Proposed By Auditee</th>
                                <td class="w-80" colspan="3">
                                    @if ($data->timeline_by_auditee)
                                        {{ \Carbon\Carbon::parse($data->timeline_by_auditee)->format('d-M-Y') }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                            <tr>

                                <th class="w-20">Short Description</th>
                                <td class="w-80" colspan="3">
                                    @if ($data->short_description)
                                        {{ strip_tags($data->short_description) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>



                            </tr>
                        </table>
                        {{-- <tr>
                                <th class="w-20">Observation</th>
                                <td class="w-80" colspan="3">
                                    @if ($data->observation)
                                        {{ $data->observation }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr> --}}

                        <div class="inner-block">
                            <label class="Summer" style="font-weight: bold; font-size: 14px;">Observation</label>
                            <div style="font-size: 0.9rem">
                                @if ($data->observation)
                                    {{ $data->observation }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </div>
                        <div class="inner-block">
                            <label class="Summer" style="font-weight: bold; font-size: 14px;">Complience Details</label>
                            <div style="font-size: 0.9rem">
                                @if ($data->complience_details)
                                    {{ $data->complience_details }}
                                @else
                                    Not Applicable
                                @endif
                            </div>

                        </div>


                        <div class="inner-block">
                            <label class="Summer" style="font-weight: bold; font-size: 14px;">Identified Reasons/ Root
                                cause</label>
                            <div style="font-size: 0.9rem">
                                @if ($data->identified_reasons)
                                    {{ $data->identified_reasons }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </div>
                        <div class="inner-block">
                            <label class="Summer" style="font-weight: bold; font-size: 14px;"
                                style="font-weight: bold; font-size: 14px;">Capa Taken/ Responded</label>
                            <div style="font-size: 0.9rem">
                                @if ($data->capa_respond)
                                    {{ $data->capa_respond }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </div>





                        {{-- <tr>
                                <th class="w-20"> Complience Details</th>
                                <td class="w-80" colspan="3">
                                    @if ($data->complience_details)
                                        {{ $data->complience_details }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr> --}}


                        {{-- <tr>

                                <th class="w-20">Identified Reasons/ Root cause</th>
                                <td class="w-80" colspan="3">
                                    @if ($data->identified_reasons)
                                        {{ strip_tags($data->identified_reasons) }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr> --}}

                        {{-- <tr>
                                <th class="w-20">Capa Taken/ Resposed </th>
                                <td class="w-80" colspan="3">
                                    @if ($data->capa_respond)
                                        {{ $data->capa_respond }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>

                            </tr> --}}

                    </div>


                    <div class="block">
                        <div class="block-head">
                            Complience Verification
                        </div>

                        <div class="inner-block">
                            <label class="Summer" style="font-weight: bold; font-size: 14px;">Complience Details</label>
                            <div style="font-size: 0.9rem">
                                @if ($data->compliance_details)
                                    {{ $data->compliance_details }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </div>

                        {{-- <tr>

                                <th class="w-20">Complience Details</th>
                                <td class="w-80" colspan="3">
                                    @if ($data->compliance_details)
                                        {{ $data->compliance_details }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr> --}}
                        <table>
                            <tr>
                                <th class="w-20">Date Of Implementation</th>
                                <td class="w-80" colspan="3">
                                    @if ($data->date_of_implemetation)
                                        {{ \Carbon\Carbon::parse($data->date_of_implemetation)->format('d-M-Y') }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>
                        </table>
                        {{-- <tr>

                            <th class="w-20">Verification Comments</th>
                            <td class="w-80" colspan="3">
                                @if ($data->verification_comments)
                                    {{ $data->verification_comments }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr> --}}

                        <div class="inner-block">
                            <label class="Summer" style="font-weight: bold; font-size: 14px;">Verification
                                Comments</label>
                            <div style="font-size: 0.9rem">
                                @if ($data->verification_comments)
                                    {{ $data->verification_comments }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </div>
                        {{-- <tr>

                            <th class="w-20">Dealy Justification for Implementation</th>
                            <td class="w-80" colspan="3">
                                @if ($data->dealy_justification_for_implementation)
                                    {{ $data->dealy_justification_for_implementation }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr> --}}
                        <div class="inner-block">
                            <label class="Summer" style="font-weight: bold; font-size: 14px;">Justification for
                                Implementation</label>
                            <div style="font-size: 0.9rem">
                                @if ($data->dealy_justification_for_implementation)
                                    {{ $data->dealy_justification_for_implementation }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </div>

                        <div class="inner-block">
                            <label class="Summer" style="font-weight: bold; font-size: 14px;">Delay Just For Task
                                Closure</label>
                            <div style="font-size: 0.9rem">
                                @if ($data->delay_just_closure)
                                    {{ $data->delay_just_closure }}
                                @else
                                    Not Applicable
                                @endif
                            </div>
                        </div>
                        <table>
                            <tr>
                                <th class="w-20">Follow-Up Task Required</th>
                                <td class="w-30">
                                    @if ($data->followup_task)
                                        {{ $data->followup_task }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                                <th class="w-20">Ref. No. Of Follow-Up Task
                                </th>
                                <td class="w-30">
                                    @if ($data->ref_of_followup)
                                        {{ $data->ref_of_followup }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>

                        </table>


                    </div>

                    <div class="block">
                        <div class="border-table">
                            <div class="block-head">
                                Audit Attechment
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data->audit_task_attach)
                                    @foreach (json_decode($data->audit_task_attach) as $key => $file)
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

                    <div class="block">
                        <div class="border-table">
                            <div class="block-head">
                                Execution Attachment
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data->exe_attechment)
                                    @foreach (json_decode($data->exe_attechment) as $key => $file)
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

                    <div class="block">
                        <div class="border-table">
                            <div class="block-head">
                                Execution Attachment
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                @if ($data->verification_attechment)
                                    @foreach (json_decode($data->verification_attechment) as $key => $file)
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

                </div>
            </div>
        </div>

    </div>

</body>

</html>
