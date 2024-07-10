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
                    GCP-Study Single Report
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
                    <strong>GCP-Study No.</strong>{{ $study_data->id }}
                </td>
                <td class="w-40">
                       {{ Helpers::getDivisionName($study_data->division_id) }}/GCP_Study/{{ Helpers::year($study_data->created_at) }}/{{ $study_data->record }}
                    {{--{{ Helpers::divisionNameForQMS($study_data->division_id) }}/{{ Helpers::year($study_data->created_at) }}/{{ $study_data->record_number ? str_pad($study_data->record_number->record_number, 4, '0', STR_PAD_LEFT) : '' }}--}}
                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($study_data->record, 4, '0', STR_PAD_LEFT) }}
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
                    <strong>Page :</strong> 1 of 2
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
                            @if ($study_data->record_number)
                                {{ str_pad($study_data->record_number->record_number, 4, '0', STR_PAD_LEFT) }}
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
                    <tr> {{ $study_data->created_at }} added by {{ $study_data->originator }}
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ $study_data->originator }}</td>

                        <th class="w-20">Date of Initiation</th>
                        <td class="w-30">{{ Helpers::getdateFormat($study_data->created_at) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Short Description</th>
                        <td class="w-30">
                            @if ($study_data->short_description_gi)
                                {{ $study_data->short_description_gi }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Assign To</th>

                        <td class="w-80">{{ $study_data->assign_to_gi }}</td>


                    </tr>

                    <tr>
                        <th class="w-20">Date Due</th>
                        <td class="w-80">{{ date('d-M-Y', strtotime($study_data->due_date)) }}</td>

                        <th class="w-20">Department</th>
                        <td class="w-80">{{ $study_data->department_gi }}</td>

                    </tr>

                    </tr>
                </table>
            </div>
            <div class="block">
                <div class="block-head">
                    Study Details
                </div>
                <table>

                    <tr>
                        <th class="w-20">Study Number</th>
                        <td class="w-30">
                            @if ($study_data->study_number_sd)
                                {{ $study_data->study_number_sd }}

                            @endif
                        </td>

                        <th class="w-20">Name of Product</th>
                        <td class="w-30">
                            @if ($study_data->name_of_product_sd)
                                {{ $study_data->name_of_product_sd }}

                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Study Title</th>
                        <td class="w-30">
                            @if ($study_data->study_title_sd)
                                {{ $study_data->study_title_sd }}

                            @endif
                        </td>
                        <th class="w-20">Study type</th>
                        <td class="w-30">
                            @if ($study_data->study_type_sd)
                                {{ $study_data->study_type_sd }}

                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Study Protocol Number</th>
                        <td class="w-80">{{ $study_data->study_protocol_number_sd }}</td>
                    </tr>
                </table>


                <table>
                    <tr>
                        <th class="w-10">Description</th>
                        <td class="w-90">{{ $study_data->description_sd }}</td>
                    </tr>

                    <tr>
                        <th class="w-10">Comments</th>
                        <td class="w-90">{{ $study_data->comments_sd }}</td>
                    </tr>
                </table>
            </div>

            <div class="block">
                <div class="block-head">
                    Additional Information
                </div>
                <table>

                    <tr>
                        <th class="w-20">Related studies</th>
                        <td class="w-30">
                            @if ($study_data->related_studies_ai)
                                {{ $study_data->related_studies_ai }}

                            @endif
                        </td>

                        <th class="w-20">Document Link</th>
                        <td class="w-30">
                            @if ($study_data->document_link_ai)
                                {{ $study_data->document_link_ai }}

                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Appendiceis</th>
                        <td class="w-30">
                            @if ($study_data->appendiceis_ai)
                                {{ $study_data->appendiceis_ai }}

                            @endif
                        </td>

                        <th class="w-20">Related Audits</th>
                        <td class="w-30">
                            @if ($study_data->related_audits_ai)
                                {{ $study_data->related_audits_ai }}

                            @endif
                        </td>

                    </tr>

                </table>
            </div>
            <div class="block">
                <div class="block-head">
                    GCP Details
                </div>
                <table>

                    <tr>
                        <th class="w-20">Generic Product Name</th>
                        <td class="w-30">
                            @if ($study_data->generic_product_name_gcpd)
                                {{ $study_data->generic_product_name_gcpd }}

                            @endif
                        </td>

                        <th class="w-20">Indication Name</th>
                        <td class="w-30">
                            @if ($study_data->indication_name_gcpd)
                                {{ $study_data->indication_name_gcpd }}

                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Clinical Study Manager</th>
                        <td class="w-30">
                            @if ($study_data->clinical_study_manager_gcpd)
                                {{ $study_data->clinical_study_manager_gcpd }}

                            @endif
                        </td>

                        <th class="w-20">Clinical Expert</th>
                        <td class="w-30">
                            @if ($study_data->clinical_expert_gcpd)
                                {{ $study_data->clinical_expert_gcpd }}

                            @endif
                        </td>

                    </tr>

                    <tr>
                        <th class="w-20">Phase Level</th>
                        <td class="w-30">
                            @if ($study_data->phase_level_gcpd)
                                {{ $study_data->phase_level_gcpd }}

                            @endif
                        </td>

                        <th class="w-20">Therapeutic Area</th>
                        <td class="w-30">
                            @if ($study_data->therapeutic_area_gcpd)
                                {{ $study_data->therapeutic_area_gcpd }}

                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">IND No.</th>
                        <td class="w-30">
                            @if ($study_data->ind_no_gcpd)
                                {{ $study_data->ind_no_gcpd }}

                            @endif
                        </td>

                        <th class="w-20">Number of Centers</th>
                        <td class="w-30">
                            @if ($study_data->number_of_centers_gcpd)
                                {{ $study_data->number_of_centers_gcpd }}

                            @endif
                        </td>

                    </tr>
                    <tr>
                        <th class="w-20">#of Subjects</th>
                        <td class="w-30">
                            @if ($study_data->of_subjects_gcpd)
                                {{ $study_data->of_subjects_gcpd }}

                            @endif
                        </td>

                    </tr>
                </table>
            </div>

            <div class="block">
                {{-- <div class="block"> --}}
                {{-- <div class="block-head"> --}}
                <div style="font-weight: 200">Audit Site Information</div>
                {{-- </div> --}}
                <div class="border-table">
                    <table>
                        <tr class="table_bg">
                            <th class="w-10">SR no.</th>
                            <th class="w-10">Number</th>
                            <th class="w-20">Audit Frequency</th>
                            <th class="w-20">Current</th>
                            <th class="w-20">CRO</th>
                            <th class="w-20">Remark</th>
                        </tr>
                        @if ($grid_DataA && is_array($grid_DataA->data))
                            @foreach ($grid_DataA->data as $grid_Data)
                                <tr>
                                    <td>{{ $loop->index + 1 }}.</td>
                                    <td>{{ isset($grid_Data['Number']) ? $grid_Data['Number'] : '' }}
                                    </td>
                                    <td>{{ isset($grid_Data['AuditFrequency']) ? $grid_Data['AuditFrequency'] : '' }}</td>
                                    <td>{{ isset($grid_Data['Current']) ? $grid_Data['Current'] : '' }}</td>
                                    <td>{{ isset($grid_Data['CRO']) ? $grid_Data['CRO'] : '' }}</td>
                                    <td>{{ isset($grid_Data['Remark']) ? $grid_Data['Remark'] : '' }}</td>
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
                {{-- <div class="block"> --}}
                {{-- <div class="block-head"> --}}
                    <div style="font-weight: 200">Study Site Information</div>
                    {{-- </div> --}}
                    <div class="border-table">
                        <table>
                            <tr class="table_bg">
                                <th class="w-10">SR no.</th>
                                <th class="w-20">Audit Site</th>
                                <th class="w-10">Site No.</th>
                                <th class="w-20">Investigator</th>
                                <th class="w-20">First Patient in Date</th>
                                <th class="w-10">Enrolled No.</th>
                                <th class="w-20">Current</th>
                                <th class="w-20">Remark</th>
                            </tr>
                            @if ($grid_DataS && is_array($grid_DataS->data))
                                @foreach ($grid_DataS->data as $grid_Data)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}.</td>
                                        <td>{{ isset($grid_Data['AuditSite']) ? $grid_Data['AuditSite'] : '' }}</td>
                                        <td>{{ isset($grid_Data['SiteNo']) ? $grid_Data['SiteNo'] : '' }}</td>
                                        <td>{{ isset($grid_Data['Investigator']) ? $grid_Data['Investigator'] : '' }}</td>
                                        <td>{{ isset($grid_Data['FirstPatientInDate']) ? $grid_Data['FirstPatientInDate'] : '' }}</td>
                                        <td>{{ isset($grid_Data['EnrolledNo']) ? $grid_Data['EnrolledNo'] : '' }}</td>
                                        <td>{{ isset($grid_Data['Current']) ? $grid_Data['Current'] : '' }}</td>
                                        <td>{{ isset($grid_Data['Remark']) ? $grid_Data['Remark'] : '' }}</td>
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
                    Important Date
                </div>
                <table>
                    <tr>
                        <th class="w-20">Initiation Date</th>
                        <td class="w-30">
                            @if ($study_data->initiation_date_i)
                                {{ $study_data->initiation_date_i }}

                            @endif
                        </td>

                        <th class="w-20">Study Start Date</th>
                        <td class="w-30">
                            @if ($study_data->study_start_date)
                                {{ $study_data->study_start_date }}

                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Study End Date</th>
                        <td class="w-30">
                            @if ($study_data->study_end_date)
                                {{ $study_data->study_end_date }}

                            @endif
                        </td>

                        <th class="w-20">Study Protocol</th>
                        <td class="w-30">
                            @if ($study_data->study_protocol)
                                {{ $study_data->study_protocol }}

                            @endif
                        </td>

                    </tr>

                    <tr>
                        <th class="w-20">First Subject in(FSI)</th>
                        <td class="w-30">
                            @if ($study_data->first_subject_in)
                                {{ $study_data->first_subject_in }}

                            @endif
                        </td>

                        <th class="w-20">Last Subject Out</th>
                        <td class="w-30">
                            @if ($study_data->last_subject_out)
                                {{ $study_data->last_subject_out }}

                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Data Base Lock(DBL)</th>
                        <td class="w-30">
                            @if ($study_data->databse_lock)
                                {{ $study_data->databse_lock }}

                            @endif
                        </td>

                        <th class="w-20">Integrated CTR</th>
                        <td class="w-30">
                            @if ($study_data->integrated_ctr)
                                {{ $study_data->integrated_ctr }}

                            @endif
                        </td>

                    </tr>

                </table>
            </div>
        </div>
    </div>


</body>

</html>
