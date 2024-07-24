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
                    PSUR Single Report
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
                        </td>
                        {{-- <th class="w-20">Department Code</th>
                        <td class="w-30">
                            @if ($data->initiator_group_code)
                                {{ $data->initiator_group_code }}
                            @else
                                Not Applicable
                            @endif
                        </td> --}}
                    </tr>
                    <tr>
                        <th class="w-20">Assigned To</th>
                        <td class="w-30">
                            @if ($data->assigned_to)
                                {{ $data->assigned_to }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20"> Date Due</th>
                        <td class="w-30">
                            @if ($data->due_date)
                                {{ $data->due_date }}
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
                    <div class="border-table">
                        <div class="block-head">
                            Attached Files
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-100">Batch No</th>
                            </tr>
                            @if ($data->file_attachment)
                                @foreach (json_decode($data->file_attachment) as $key => $file)
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
                        <th class="w-20">Type</th>
                        <td class="w-30">
                            @if ($data->type)
                                {{ $data->type }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20"> Year</th>
                        <td class="w-30">
                            @if ($data->year)
                                {{ $data->year }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Actual Start Date</th>
                        <td class="w-30">
                            @if ($data->actual_start_date)
                                {{ $data->actual_start_date }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Actual End Date</th>
                        <td class="w-30">
                            @if ($data->actual_end_date)
                                {{ $data->actual_end_date }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">(Parent)Authority Type</th>
                        <td class="w-30">
                            @if ($data->authority_type)
                                {{ $data->authority_type }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Authority</th>
                        <td class="w-30">
                            @if ($data->authority)
                                {{ $data->authority }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Introduction</th>
                        <td class="w-30">
                            @if ($data->introduction)
                                {{ $data->introduction }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Related Records</th>
                        <td class="w-30">
                            @if ($data->related_records)
                                {{ $data->related_records }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    </table>
                    <div class="block">
                        <div class="block-head">
                            Action Taken
                        </div>
                        <table>
                            <tr>
                                <th class="w-20">World MA Status</th>
                                <td class="w-80">
                                    @if ($data->world_ma_status)
                                        {!! $data->world_ma_status !!}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>

                                <th class="w-20">RA Actions Taken</th>
                                <td class="w-80">
                                    @if ($data->ra_actions_taken)
                                        {!! $data->ra_actions_taken !!}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th class="w-30">MAH Actions Taken</th>
                                <td class="w-80">
                                    @if ($data->mah_actions_taken)
                                        {{ $data->mah_actions_taken }}
                                    @else
                                        Not Applicable
                                    @endif
                                </td>

                            </tr>
                        </table>

                    </div>
            </div>

            <div class="block">
                <div class="block-head">
                    Findings and Analysis
                </div>
                <table>
                    <tr>
                        <th class="w-20">Changes To Safety Information</th>
                        <td class="w-80">

                            @if ($data->changes_to_safety_information)
                            <p>{!! $data->changes_to_safety_information !!}</p>
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                     <tr>
                        <th class="w-20">Patient Exposure</th>
                        <td class="w-80">
                            @if ($data->patient_exposure)
                                {!! $data->patient_exposure !!}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    {{-- <tr>
                        <th class="w-20">Patient Exposure</th>
                        <td class="w-80">
                            @if ($data->patient_exposure)
                                {!! $data->patient_exposure !!}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr> --}}

                    <tr>
                        <th class="w-20">Analysis of Individual Case</th>
                        <td class="w-80">
                            @if ($data->analysis_of_individual_case)
                                {!! $data->analysis_of_individual_case !!}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Newly Analyzed Studies</th>
                        <td class="w-80">
                            @if ($data->newly_analyzed_studies)
                                {!! $data->newly_analyzed_studies !!}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Target and New Safety Studies</th>
                        <td class="w-80">
                            @if ($data->target_and_new_safety_studies)
                                {{ $data->target_and_new_safety_studies }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Publish Safety Studies</th>
                        <td class="w-80">
                            @if ($data->publish_safety_studies)
                                {{ $data->publish_safety_studies }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Efficacy-Related Information</th>
                        <td class="w-80">
                            @if ($data->efficiency_related_info)
                                {{ $data->efficiency_related_info }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Late-Breaking Information</th>
                        <td class="w-80">
                            @if ($data->late_breaking_information)
                                {{ $data->late_breaking_information }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>

                </table>
            </div>

            <div class="border">
                <div class="block-head">
                    Conclusion
                </div>
                <table>
                    <tr>
                        <th class="w-20">Overall Safety Evaluation</th>
                        <td class="w-80">
                            @if ($data->overall_safety_evaluation)
                                {{ $data->overall_safety_evaluation }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Conclusion</th>
                        <td class="w-80">
                            @if ($data->conclusion)
                                {{ $data->conclusion }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>

                </table>


            </div>
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Product Information
                    </div>

                    <table>
                        <tr>
                            <th class="w-20">(Root Parent) Manufacturer</th>
                            <td class="w-30">
                                @if ($data->root_parent_manufaturer)
                                    {{ $data->root_parent_manufaturer }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">(Root Parent) Product Type</th>
                            <td class="w-30">
                                @if ($data->root_parent_product_type)
                                    {{ $data->root_parent_product_type }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">(Root Parent)Trade Name</th>
                            <td class="w-30">
                                @if ($data->root_parent_trade_name)
                                    {{ $data->root_parent_trade_name }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">(Root Parent)International Birth Date</th>
                            <td class="w-30">
                                @if ($data->international_birth_date)
                                    {{ $data->international_birth_date }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">(Root Parent)API</th>
                            <td class="w-30">
                                @if ($data->root_parent_api)
                                    {{ $data->root_parent_api }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">(Root Parent)Product Strength</th>
                            <td class="w-30">
                                @if ($data->root_parent_product_strength)
                                    {{ $data->root_parent_product_strength }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">(Root Parent)Route of Administration</th>
                            <td class="w-30">
                                @if ($data->route_of_administration)
                                    {{ $data->route_of_administration }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">(Root Parent)Dosage Form</th>
                            <td class="w-30">
                                @if ($data->root_parent_product_dosage_form)
                                    {{ $data->root_parent_product_dosage_form }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">(Root Parent)Therapeutic Area</th>
                            <td class="w-30">
                                @if ($data->therapeutic_Area)
                                    {{ $data->therapeutic_Area }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">(Root Parent) Product Type</th>
                            <td class="w-30">
                                @if ($data->root_parent_product_type)
                                    {{ $data->root_parent_product_type }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                    </table>
                </div>
                <div class="border">
                    <div class="block-head">
                        Registration Plan
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Registration Status</th>
                            <td class="w-30">
                                @if ($data->registration_status)
                                    {{ $data->registration_status }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Registration Number</th>
                            <td class="w-30">
                                @if ($data->registration_number)
                                    {{ $data->registration_number }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Planned Submission Date </th>
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
                            <th class="w-20">Comments</th>
                            <td class="w-30">
                                @if ($data->comments)
                                    {{ $data->comments }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="block">
                    <div class="head">
                        <div class="block-head">
                            Local Information/Procedure
                        </div>
                    </div>
                </div>
                <table>
                    <tr>
                        <th class="w-20">(Parent) Procedure Type </th>
                        <td class="w-30">
                            @if ($data->procedure_type)
                                {{ $data->procedure_type }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">(Parent) Procedure Number</th>
                        <td class="w-30">
                            @if ($data->procedure_number)
                                {{ $data->procedure_number }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">(Parent) Reference Member State(RMS)</th>
                        <td class="w-30">
                            @if ($data->reference_member_state)
                                {{ $data->reference_member_state }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">(Parent)Renewal Rule</th>
                        <td class="w-30">
                            @if ($data->renewal_rule)
                                {{ $data->renewal_rule }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">(Parent)Concerned Member States (CMSs)</th>
                        <td class="w-30">
                            @if ($data->concerned_member_states)
                                {{ $data->concerned_member_states }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>

                </table>


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
                            <th class="w-20">Submitted By</th>
                            <td class="w-30">{{ Auth::user()->name }}</td>
                            <th class="w-20">Submitted On</th>
                            {{-- <td class="w-30">{{ }}</td> --}}

                        </tr>
                        <tr>
                            <th class="w-20">Approved By</th>
                            <td class="w-30">{{ Auth::user()->name }} </td>

                            <th class="w-20">Approved On</th>
                            {{-- <td class="w-30">{{  }} --}}
                            </td>

                        </tr>
                        <tr>
                            <th class="w-20">Approved By</th>
                            <td class="w-30"> {{ Auth::user()->name }}</td>
                            <th class="w-20">Approved On</th>
                            {{-- <td class="w-30">{{  }} --}}
                            </td>

                        </tr>
                        <tr>
                            <th class="w-20">Withdrawn By</th>
                            <td class="w-30">{{ Auth::user()->name }}</td>
                            <th class="w-20">Withdrawn on</th>
                            {{-- <td class="w-30">{{ }}</td> --}}


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
