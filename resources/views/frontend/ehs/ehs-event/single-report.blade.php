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
                    Ehs-Event Single Report
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
                    <strong>Ehs-Event No.</strong>
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

    <div class="inner-block">
        <div class="content-table">
            <div class="block">
                <div class="block-head">
                    General Information
                </div>
                <table>
                    <tr> {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">Record Number</th>
                        <td class="w-30">
                            @if ($data->record)
                                {{ $data->record }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-30">
                            @if ($data->division_code)
                                {{ $data->division_code }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ Helpers::getInitiatorName($data->initiator_id) }}</td>
                        <th class="w-20">Date Initiation</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->intiation_date) }}</td>
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
                        {{-- <td class="w-30">@if($data->assigned_to){{ Helpers::getInitiatorName($data->assigned_to) }} @else Not Applicable @endif</td> --}}
                        <th class="w-20">Due Date</th>
                        <td class="w-30">
                            @if ($data->date_due)
                                {{ $data->date_due }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        {{-- <td class="w-30">{{ Helpers::getdateFormat($data->date_due) }}</td> --}}
                    </tr>
                    <tr>
                        <th class="w-20">Short Description</th>
                        <td class="w-80" colspan="3">
                            @if ($data->short_description)
                                {{ $data->short_description }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Event type</th>
                        <td class="w-30">
                            @if ($data->event_type)
                                {{ $data->event_type }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Incident Sub-Type</th>
                        <td class="w-80" colspan="3">
                            @if ($data->incident_sub_type)
                                {{ $data->incident_sub_type }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Date Occurred</th>
                        <td class="w-30">
                            @if ($data->date_occurred)
                                {{ $data->date_occurred }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Time Occurred</th>
                        <td class="w-80" colspan="3">
                            @if ($data->time_occurred)
                                {{ $data->time_occurred }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Date of Reporting</th>
                        <td class="w-30">
                            @if ($data->date_of_reporting)
                                {{ $data->date_of_reporting }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Reporter</th>
                        <td class="w-80" colspan="3">
                            @if ($data->reporter)
                                {{ $data->reporter }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">File Attachments</th>
                        <td class="w-30">
                            @if ($data->file_attachment)
                                {{ $data->file_attachment }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Similar Incidents(s)</th>
                        <td class="w-80" colspan="3">
                            @if ($data->similar_incidents)
                                {{ $data->similar_incidents }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Description</th>
                        <td class="w-30">
                            @if ($data->description)
                                {{ $data->description }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Immediate Actions</th>
                        <td class="w-80" colspan="3">
                            @if ($data->immediate_actions)
                                {{ $data->immediate_actions }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
            </div>



            {{-- <div class="block">
            <div class="border-table">
                <div class="block-head">
                    Attached Files, if any
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Batch No</th>
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
        </div> --}}

            {{-- ---------------------------------------2nd tab start----------------------        --}}
            <div class="block">
                <div class="block-head">
                    Detailed Information
                </div>
                <table>
                    <tr>
                        <th class="w-20">Accident Type</th>
                        <td class="w-30">
                            @if ($data->accident_type)
                                {{ $data->accident_type }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">OSHA Reportable?</th>
                        <td class="w-80" colspan="3">
                            @if ($data->osha_reportable)
                                {{ $data->osha_reportable }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">First Lost Work Date</th>
                        <td class="w-30">
                            @if ($data->first_lost_work_date)
                                {{ $data->first_lost_work_date }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Last Lost Work Date</th>
                        <td class="w-80" colspan="3">
                            @if ($data->last_lost_work_date)
                                {{ $data->last_lost_work_date }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">First Restricted Work Date</th>
                        <td class="w-30">
                            @if ($data->first_restricted_work_date)
                                {{ $data->first_restricted_work_date }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Last Restricted Work Date</th>
                        <td class="w-80" colspan="3">
                            @if ($data->last_restricted_work_date)
                                {{ $data->last_restricted_work_date }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>



                    <tr>
                        <th class="w-20">Vehicle Type</th>
                        <td class="w-30">
                            @if ($data->vehicle_type)
                                {{ $data->vehicle_type }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Vehicle Number</th>
                        <td class="w-80" colspan="3">
                            @if ($data->vehicle_number)
                                {{ $data->vehicle_number }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Litigation</th>
                        <td class="w-30">
                            @if ($data->litigation)
                                {{ $data->litigation }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Department(s)</th>
                        <td class="w-80" colspan="3">
                            @if ($data->department)
                                {{ $data->department }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                {{-- ------------------- 2nd ------------------------------ --}}
                <div class="block-head">
                    Involved Persons
                </div>
                <table>
                    <tr>
                        <th class="w-20">Employee(s) Involved</th>
                        <td class="w-30">
                            @if ($data->employee_involved)
                                {{ $data->employee_involved }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Involved(s) Contractor(s)</th>
                        <td class="w-80" colspan="3">
                            @if ($data->involved_contractor)
                                {{ $data->involved_contractor }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Attorneys (s) Involved(s)</th>
                        <td class="w-30">
                            @if ($data->attorneys_involved)
                                {{ $data->attorneys_involved }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Lead Investigator</th>
                        <td class="w-30">
                            @if ($data->lead_investigator)
                                {{ $data->lead_investigator }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Line Operator</th>
                        <td class="w-80" colspan="3">
                            @if ($data->line_operator)
                                {{ $data->line_operator }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Reporter</th>
                        <td class="w-30">
                            @if ($data->detail_info_reporter)
                                {{ $data->detail_info_reporter }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Supervisor</th>
                        <td class="w-80" colspan="3">
                            @if ($data->supervisor)
                                {{ $data->supervisor }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                {{-- ------------------------grid-1--------------------------------------- --}}
                <div class="border-table mb-3">
                    <div class="block-head">
                        Witness(es) Information
                    </div>
                    <table>
                        <thead>
                            <tr class="table_bg">
                                <th>Row#</th>
                                <th>Witness Name</th>
                                <th>Witness Type</th>
                                <th>Item Descriptions</th>
                                <th>Comments</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ($grid_data1 && is_array($grid_data1))
                                @foreach ($grid_data1 as $grid)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ isset($grid['witness_name']) ? $grid['witness_name'] : '' }}
                                        </td>
                                        <td>{{ isset($grid['witness_type']) ? $grid['witness_type'] : '' }}
                                        </td>
                                        <td>{{ isset($grid['item_descriptions']) ? $grid['item_descriptions'] : '' }}
                                        </td>
                                        <td>{{ isset($grid['comments']) ? $grid['comments'] : '' }}
                                        </td>
                                        <td>{{ isset($grid['remarks']) ? $grid['remarks'] : '' }}
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

                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- -----------------------------3rd--------------------------------- --}}
                <div class="block-head">
                    Near Miss and Measures
                </div>
                <table>
                    <tr>
                        <th class="w-20">Unsafe Situation</th>
                        <td class="w-30">
                            @if ($data->unsafe_situation)
                                {{ $data->unsafe_situation }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Safeguarding Measure Taken</th>
                        <td class="w-80" colspan="3">
                            @if ($data->safeguarding_measure_taken)
                                {{ $data->safeguarding_measure_taken }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                </table>
                {{-- ----------------------------4rd------------------------------------------------- --}}
                <div class="block-head">
                    Enviromental Information
                </div>
                <table>
                    <tr>
                        <th class="w-20">Enviromental Category</th>
                        <td class="w-30">
                            @if ($data->enviromental_category)
                                {{ $data->enviromental_category }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Special Weather Conditions</th>
                        <td class="w-80" colspan="3">
                            @if ($data->Special_Weather_Conditions)
                                {{ $data->Special_Weather_Conditions }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Source Of Release or Spill</th>
                        <td class="w-30">
                            @if ($data->source_Of_release_or_spill)
                                {{ $data->source_Of_release_or_spill }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Special Weather Conditions</th>
                        <td class="w-80" colspan="3">
                            @if ($data->Special_Weather_Conditions)
                                {{ $data->Special_Weather_Conditions }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Environment Evacuation Ordered</th>
                        <td class="w-30">
                            @if ($data->environment_evacuation_ordered)
                                {{ $data->environment_evacuation_ordered }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Date Simples Taken</th>
                        <td class="w-80" colspan="3">
                            @if ($data->date_simples_taken)
                                {{ $data->date_simples_taken }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Agency(s) Notified</th>
                        <td class="w-30">
                            @if ($data->agency_notified)
                                {{ $data->agency_notified }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                </table>

                {{-- ------------------------grid-2--------------------------------------- --}}
                <div class="border-table mb-3">
                    <div class="block-head">
                        Materials Released
                    </div>
                    <table>
                        <thead>
                            <tr class="table_bg">
                                <th>Row#</th>
                                <th>Type of Material(s) Released</th>
                                <th>Quantity Of Materials Released</th>
                                <th> Medium Affected By Released</th>
                                <th> Health Risk?</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ($grid_data2 && is_array($grid_data2))
                                @foreach ($grid_data2 as $grid)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ isset($grid['type_of_material_released']) ? $grid['type_of_material_released'] : '' }}
                                        </td>
                                        <td>{{ isset($grid['quantity_Of_materials_released']) ? $grid['quantity_Of_materials_released'] : '' }}
                                        </td>
                                        <td>{{ isset($grid['medium_affected_by_released']) ? $grid['medium_affected_by_released'] : '' }}
                                        </td>
                                        <td>{{ isset($grid['health_risk']) ? $grid['health_risk'] : '' }}
                                        </td>
                                        <td>{{ isset($grid['remarks']) ? $grid['remarks'] : '' }}
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

                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- ---------------------------5th-------------------------------------------------- --}}
                <div class="block-head">Fire Incident</div>
                <table>
                    <tr>
                        <th class="w-20">Fire Category</th>
                        <td class="w-30">
                            @if ($data->fire_category)
                                {{ $data->fire_category }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Fire Evacuation Ordered?</th>
                        <td class="w-80" colspan="3">
                            @if ($data->fire_evacuation_ordered)
                                {{ $data->fire_evacuation_ordered }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Combat By</th>
                        <td class="w-30">
                            @if ($data->combat_by)
                                {{ $data->combat_by }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Fire Fighting Equipment Used</th>
                        <td class="w-80" colspan="3">
                            @if ($data->fire_fighting_equipment_used)
                                {{ $data->fire_fighting_equipment_used }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>


                {{-- --------------------6th------------------------------------------------------------------ --}}
                <div class="block-head">
                    Event Location
                </div>
                <table>
                    <tr>
                        <th class="w-20">Zone</th>
                        <td class="w-30">
                            @if ($data->zone)
                                {{ $data->zone }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Country</th>
                        <td class="w-80" colspan="3">
                            @if ($data->country)
                                {{ $data->country }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">City</th>
                        <td class="w-30">
                            @if ($data->city)
                                {{ $data->city }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">State/District</th>
                        <td class="w-80" colspan="3">
                            @if ($data->state)
                                {{ $data->state }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Site Name</th>
                        <td class="w-30">
                            @if ($data->site_name)
                                {{ $data->site_name }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Building</th>
                        <td class="w-80" colspan="3">
                            @if ($data->building)
                                {{ $data->building }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Floor</th>
                        <td class="w-30">
                            @if ($data->floor)
                                {{ $data->floor }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Room</th>
                        <td class="w-80" colspan="3">
                            @if ($data->room)
                                {{ $data->room }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Location</th>
                        <td class="w-30">
                            @if ($data->location)
                                {{ $data->location }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>


                {{-- -----------------------------tab-3  start--------------------------------- --}}
                <div class="block-head">
                    Victim Information
                </div>
                <table>
                    <tr>
                        <th class="w-20">Victim</th>
                        <td class="w-30">
                            @if ($data->victim)
                                {{ $data->victim }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Medical Treatment?(Y/N)</th>
                        <td class="w-80" colspan="3">
                            @if ($data->medical_treatment)
                                {{ $data->medical_treatment }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Victim Position</th>
                        <td class="w-30">
                            @if ($data->victim_position)
                                {{ $data->victim_position }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Victim Realation To Company</th>
                        <td class="w-80" colspan="3">
                            @if ($data->victim_realation)
                                {{ $data->victim_realation }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">>Hospitalization</th>
                        <td class="w-30">
                            @if ($data->hospitalization)
                                {{ $data->hospitalization }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Hospital Name</th>
                        <td class="w-80" colspan="3">
                            @if ($data->hospital_name)
                                {{ $data->hospital_name }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Date of Treatment</th>
                        <td class="w-30">
                            @if ($data->date_of_treatment)
                                {{ $data->date_of_treatment }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Victim Treated By</th>
                        <td class="w-80" colspan="3">
                            @if ($data->victim_treated_by)
                                {{ $data->victim_treated_by }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Medical Treatment Discription</th>
                        <td class="w-30">
                            @if ($data->medical_treatment_discription)
                                {{ $data->medical_treatment_discription }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="block-head">
                    Physical Damage
                </div>
                <table>
                    <tr>
                        <th class="w-20">Injury Type</th>
                        <td class="w-30">
                            @if ($data->injury_type)
                                {{ $data->injury_type }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Number of Injuries</th>
                        <td class="w-80" colspan="3">
                            @if ($data->number_of_injuries)
                                {{ $data->number_of_injuries }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Type of Illness</th>
                        <td class="w-30">
                            @if ($data->type_of_illness)
                                {{ $data->type_of_illness }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Permanent Disability?</th>
                        <td class="w-80" colspan="3">
                            @if ($data->permanent_disability)
                                {{ $data->permanent_disability }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="block-head">
                    Damage Information
                </div>
                <table>
                    <tr>
                        <th class="w-20">Damage Category</th>
                        <td class="w-30">
                            @if ($data->damage_category)
                                {{ $data->damage_category }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Related Equipment</th>
                        <td class="w-80" colspan="3">
                            @if ($data->related_equipment)
                                {{ $data->related_equipment }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Estimated Amount of Damage Equipment</th>
                        <td class="w-30">
                            @if ($data->estimated_amount)
                                {{ $data->estimated_amount }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Currency</th>
                        <td class="w-80" colspan="3">
                            @if ($data->currency)
                                {{ $data->currency }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Insurance Company Involved?</th>
                        <td class="w-30">
                            @if ($data->insurance_company_involved)
                                {{ $data->insurance_company_involved }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Denied By Insurance Company?</th>
                        <td class="w-80" colspan="3">
                            @if ($data->denied_by_insurance)
                                {{ $data->denied_by_insurance }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Damage Details</th>
                        <td class="w-30">
                            @if ($data->damage_details)
                                {{ $data->damage_details }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>


                <div class="block-head">
                    Investigation summary
                </div>
                <table>
                    <tr>
                        <th class="w-20">Actual Amount of Damage</th>
                        <td class="w-30">
                            @if ($data->actual_amount)
                                {{ $data->actual_amount }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Currency</th>
                        <td class="w-80" colspan="3">
                            @if ($data->currency)
                                {{ $data->currency }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Investigation summary</th>
                        <td class="w-30">
                            @if ($data->investigation_summary)
                                {{ $data->investigation_summary }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Conclusion</th>
                        <td class="w-80" colspan="3">
                            @if ($data->conclusion)
                                {{ $data->conclusion }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="block-head">
                    Risk Factors
                </div>
                <table>
                    <tr>
                        <th class="w-20">Safety Impact Probability</th>
                        <td class="w-30">
                            @if ($data->safety_impact_probability)
                                {{ $data->safety_impact_probability }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Safety Impact Severity</th>
                        <td class="w-80" colspan="3">
                            @if ($data->safety_impact_severity)
                                {{ $data->safety_impact_severity }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Legal Impact Probability</th>
                        <td class="w-30">
                            @if ($data->legal_impact_probability)
                                {{ $data->legal_impact_probability }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Legal Impact Severity</th>
                        <td class="w-80" colspan="3">
                            @if ($data->legal_impact_severity)
                                {{ $data->legal_impact_severity }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Business Impact Probability</th>
                        <td class="w-30">
                            @if ($data->business_impact_probability)
                                {{ $data->business_impact_probability }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Business Impact Severity</th>
                        <td class="w-80" colspan="3">
                            @if ($data->business_impact_severity)
                                {{ $data->business_impact_severity }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Revenue Impact Probability</th>
                        <td class="w-30">
                            @if ($data->revenue_impact_probability)
                                {{ $data->revenue_impact_probability }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Revenue Impact Severity</th>
                        <td class="w-80" colspan="3">
                            @if ($data->revenue_impact_severity)
                                {{ $data->revenue_impact_severity }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Brand Impact Probability</th>
                        <td class="w-30">
                            @if ($data->brand_impact_probability)
                                {{ $data->brand_impact_probability }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Brand Impact Severity</th>
                        <td class="w-80" colspan="3">
                            @if ($data->brand_impact_severity)
                                {{ $data->brand_impact_severity }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
                <div class="block-head">
                    Calculated Risk and Further Actions
                </div>
                <table>
                    <tr>
                        <th class="w-20">Safety Impact Risk</th>
                        <td class="w-30">
                            @if ($data->safety_impact_risk)
                                {{ $data->safety_impact_risk }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Legal Impact Risk</th>
                        <td class="w-80" colspan="3">
                            @if ($data->legal_impact_risk)
                                {{ $data->legal_impact_risk }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Business Impact Risk</th>
                        <td class="w-30">
                            @if ($data->business_impact_risk)
                                {{ $data->business_impact_risk }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Revenue Impact Risk</th>
                        <td class="w-80" colspan="3">
                            @if ($data->revenue_impact_risk)
                                {{ $data->revenue_impact_risk }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Brand Impact Risk</th>
                        <td class="w-30">
                            @if ($data->brand_impact_risk)
                                {{ $data->brand_impact_risk }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                </table>

                <div class="block-head">
                    General Risk Information
                </div>
                <table>
                    <tr>
                        <th class="w-20">Impact</th>
                        <td class="w-30">
                            @if ($data->impact)
                                {{ $data->impact }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Impact Analysis</th>
                        <td class="w-80" colspan="3">
                            @if ($data->impact_analysis)
                                {{ $data->impact_analysis }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Recommended Action</th>
                        <td class="w-30">
                            @if ($data->recommended_action)
                                {{ $data->recommended_action }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Comments</th>
                        <td class="w-80" colspan="3">
                            @if ($data->comments)
                                {{ $data->comments }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Direct Cause</th>
                        <td class="w-30">
                            @if ($data->direct_cause)
                                {{ $data->direct_cause }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Safeguarding Measure Taken</th>
                        <td class="w-80" colspan="3">
                            @if ($data->root_cause_safeguarding_measure_taken)
                                {{ $data->root_cause_safeguarding_measure_taken }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                {{-- ------------------------grid-3--------------------------------------- --}}
                <div class="border-table mb-3">
                    <div class="block-head">
                        Root Cause
                    </div>
                    <table>
                        <thead>
                            <tr class="table_bg">
                                <th>Row#</th>
                                <th>Root Cause Category</th>
                                <th> Root Cause Sub Category</th>
                                <th> Probability</th>
                                <th> Comments</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ($grid_data3 && is_array($grid_data3))
                                @foreach ($grid_data3 as $grid)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ isset($grid['root_cause_category']) ? $grid['root_cause_category'] : '' }}
                                        </td>
                                        <td>{{ isset($grid['root_cause_sub_category']) ? $grid['root_cause_sub_category'] : '' }}
                                        </td>
                                        <td>{{ isset($grid['probability']) ? $grid['probability'] : '' }}
                                        </td>
                                        <td>{{ isset($grid['comments']) ? $grid['comments'] : '' }}
                                        </td>
                                        <td>{{ isset($grid['remarks']) ? $grid['remarks'] : '' }}
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

                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="block-head">
                    Root Cause Analysis
                </div>
                <table>
                    <tr>
                        <th class="w-20">Root cause Methodlogy</th>
                        <td class="w-30">
                            @if ($data->root_cause_methodlogy)
                                {{ $data->root_cause_methodlogy }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Root cause Description</th>
                        <td class="w-80" colspan="3">
                            @if ($data->root_cause_description)
                                {{ $data->root_cause_description }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="block-head">
                    Risk Analysis
                </div>
                <table>
                    <tr>
                        <th class="w-20">Severity Rate</th>
                        <td class="w-30">
                            @if ($data->severity_rate)
                                {{ $data->severity_rate }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Occurrence</th>
                        <td class="w-80" colspan="3">
                            @if ($data->occurrence)
                                {{ $data->occurrence }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Detection</th>
                        <td class="w-30">
                            @if ($data->detection)
                                {{ $data->detection }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">RPN</th>
                        <td class="w-80" colspan="3">
                            @if ($data->rpn)
                                {{ $data->rpn }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Risk Analysis</th>
                        <td class="w-30">
                            @if ($data->risk_analysis)
                                {{ $data->risk_analysis }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Criticality</th>
                        <td class="w-80" colspan="3">
                            @if ($data->criticality)
                                {{ $data->criticality }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Inform Local Authority?</th>
                        <td class="w-30">
                            @if ($data->inform_local_authority)
                                {{ $data->inform_local_authority }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Authority Type</th>
                        <td class="w-80" colspan="3">
                            @if ($data->authority_type)
                                {{ $data->authority_type }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Authority(s) Notified</th>
                        <td class="w-30">
                            @if ($data->authority_notified)
                                {{ $data->authority_notified }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Other Authority</th>
                        <td class="w-80" colspan="3">
                            @if ($data->other_authority)
                                {{ $data->other_authority }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>


             
                <div class="block">
                    <div class="block-head">
                        Signatures
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Submission By</th>
                            <td class="w-30">
                                @if ($data->submitted_by)
                                    {{ $data->submitted_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Submission On</th>
                            <td class="w-30"> 
                             @if ($data->submitted_on)
                                 {{ $data->submitted_on }}
                               @else
                                Not Applicable
                              @endif
                            </td>
                            <th class="w-20">Submission Comment</th>
                            <td class="w-30">
                                @if ($data->submitted_comment)
                                    {{ $data->submitted_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Cancel By</th>
                            <td class="w-30">
                                @if ($data->cancel_by)
                                    {{ $data->cancel_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Cancel On</th>
                            <td class="w-30"> 
                             @if ($data->cancel_on)
                                 {{ $data->cancel_on }}
                               @else
                                Not Applicable
                              @endif
                            </td>
                            <th class="w-20">Cancel Comment</th>
                            <td class="w-30">
                                @if ($data->cancel_comment)
                                    {{ $data->cancel_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Review Complete By</th>
                            <td class="w-30">
                                @if ($data->review_complete_by)
                                    {{ $data->review_complete_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Review Complete On</th>
                            <td class="w-30"> 
                             @if ($data->review_complete_on)
                                 {{ $data->review_complete_on }}
                               @else
                                Not Applicable
                              @endif
                            </td>
                            <th class="w-20">Review Complete Comment</th>
                            <td class="w-30">
                                @if ($data->review_complete_comment)
                                    {{ $data->review_complete_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">More Information Required By</th>
                            <td class="w-30">
                                @if ($data->more_info_required_by)
                                    {{ $data->more_info_required_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">More Information Required On</th>
                            <td class="w-30"> 
                             @if ($data->more_info_required_on)
                                 {{ $data->more_info_required_on }}
                               @else
                                Not Applicable
                              @endif
                            </td>
                            <th class="w-20">More Information Required Comment</th>
                            <td class="w-30">
                                @if ($data->more_info_required_comment)
                                    {{ $data->more_info_required_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Complete Investigation By</th>
                            <td class="w-30">
                                @if ($data->complete_investigation_by)
                                    {{ $data->complete_investigation_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Complete Investigation On</th>
                            <td class="w-30"> 
                             @if ($data->complete_investigation_on)
                                 {{ $data->complete_investigation_on }}
                               @else
                                Not Applicable
                              @endif
                            </td>
                            <th class="w-20">Complete Investigation Comment</th>
                            <td class="w-30">
                                @if ($data->complete_investigation_comment)
                                    {{ $data->complete_investigation_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Analysis Complete By</th>
                            <td class="w-30">
                                @if ($data->analysis_complete_by)
                                    {{ $data->analysis_complete_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Analysis Complete On</th>
                            <td class="w-30"> 
                             @if ($data->analysis_complete_on)
                                 {{ $data->analysis_complete_on }}
                               @else
                                Not Applicable
                              @endif
                            </td>
                            <th class="w-20">Analysis Complete Comment</th>
                            <td class="w-30">
                                @if ($data->analysis_complete_comment)
                                    {{ $data->analysis_complete_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">More Investigation Required By</th>
                            <td class="w-30">
                                @if ($data->more_investig_required_by)
                                    {{ $data->more_investig_required_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">More Investigation Required On</th>
                            <td class="w-30"> 
                             @if ($data->more_investig_required_on)
                                 {{ $data->more_investig_required_on }}
                               @else
                                Not Applicable
                              @endif
                            </td>
                            <th class="w-20">More Investigation Required Comment</th>
                            <td class="w-30">
                                @if ($data->more_investig_required_comment)
                                    {{ $data->more_investig_required_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Propose Plan By</th>
                            <td class="w-30">
                                @if ($data->propose_plan_by)
                                    {{ $data->propose_plan_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Propose Plan On</th>
                            <td class="w-30"> 
                             @if ($data->propose_plan_on)
                                 {{ $data->propose_plan_on }}
                               @else
                                Not Applicable
                              @endif
                            </td>
                            <th class="w-20">Propose Plan Comment</th>
                            <td class="w-30">
                                @if ($data->propose_plan_comment)
                                    {{ $data->propose_plan_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Approve Plan By</th>
                            <td class="w-30">
                                @if ($data->approve_plan_by)
                                    {{ $data->approve_plan_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Approve Plan On</th>
                            <td class="w-30"> 
                             @if ($data->approve_plan_on)
                                 {{ $data->approve_plan_on }}
                               @else
                                Not Applicable
                              @endif
                            </td>
                            <th class="w-20">Approve Plan Comment</th>
                            <td class="w-30">
                                @if ($data->approve_plan_comment)
                                    {{ $data->approve_plan_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Reject By</th>
                            <td class="w-30">
                                @if ($data->reject_by)
                                    {{ $data->reject_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Reject On</th>
                            <td class="w-30"> 
                             @if ($data->reject_on)
                                 {{ $data->reject_on }}
                               @else
                                Not Applicable
                              @endif
                            </td>
                            <th class="w-20">Reject Comment</th>
                            <td class="w-30">
                                @if ($data->reject_comment)
                                    {{ $data->reject_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">All CAPA Closed By</th>
                            <td class="w-30">
                                @if ($data->all_capa_closed_by)
                                    {{ $data->all_capa_closed_by }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">All CAPA Closed On</th>
                            <td class="w-30"> 
                             @if ($data->all_capa_closed_on)
                                 {{ $data->all_capa_closed_on }}
                               @else
                                Not Applicable
                              @endif
                            </td>
                            <th class="w-20">All CAPA Closed Comment</th>
                            <td class="w-30">
                                @if ($data->all_capa_closed_comment)
                                    {{ $data->all_capa_closed_comment }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
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
                    {{--  <td class="w-30">
                    <strong>Page :</strong> 1 of 1
                </td>  --}}
                </tr>
            </table>
        </footer>

</body>

</html>
