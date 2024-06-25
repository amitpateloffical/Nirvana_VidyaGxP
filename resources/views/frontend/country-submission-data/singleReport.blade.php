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
                   Country Submission Data Single Report
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
                    <strong>Country Submission Data No.</strong>
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
                    Country Submission Data
                </div>
                <table>
                    <tr>  {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">Initiator</th>
                        <td class="w-80">{{ Helpers::getInitiatorName($data->initiator_id) }}</td>
                        <th class="w-20">Date Initiation</th>
                        <td class="w-80">{{ Helpers::getdateFormat($data->created_at) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Record Number</th>
                        <td class="w-80">@if($data->record){{ $data->record }} @else Not Applicable @endif</td>
                        <th class="w-20">Short Description</th>
                        <td class="w-80" colspan="3">
                            @if($data->short_description){{ $data->short_description }}@else Not Applicable @endif</td>
                    </tr>
                </table>
            </div>
            
            <div class="block">
                <table>
                    <tr>
                        <th class="w-20">Due Date</th>
                        <td class="w-80"> @if($data->due_date){{ $data->due_date }} @else Not Applicable @endif</td>
                        <th class="w-20">Assigned To</th>
                        <td class="w-80">@if($data->assign_to){{ Helpers::getInitiatorName($data->assign_to) }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Type</th>
                        <td class="w-80">@if($data->type){{ $data->type }}@else Not Applicable @endif</td>
                        <th class="w-20">Other Type</th>
                        <td class="w-80">@if($data->other_type){{ $data->other_type }}@else Not Applicable @endif</td>
                    </tr>
                </table>
            </div>

            <div class="border-table">
                <div class="block-head">
                    Attached Files
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Batch No</th>
                    </tr>
                        @if($data->attached_files)
                        @foreach(json_decode($data->attached_files) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
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
            
            <div class="block">
                <table>
                    <tr>
                        <th class="w-20">Related URLs</th>
                        <td class="w-80">@if($data->related_urls){{ $data->related_urls }}@else Not Applicable @endif</td>
                        <th class="w-20">Descriptions</th>
                        <td class="w-80">@if($data->descriptions){{ $data->descriptions }}@else Not Applicable @endif</td>
                    </tr>
                </table>
            </div>

            <div class="block">
                <div class="block-head">
                    Location
                </div>
                    <table>
                        <tr>
                            <th class="w-20">Zone</th>
                            <td class="w-80">@if($data->zone){{ $data->zone }}@else Not Applicable @endif</td>
                            <th class="w-20">Country</th>
                            <td class="w-80">@if($data->country){{ $data->country }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">City</th>
                            <td class="w-80">@if($data->city){{ $data->city }}@else Not Applicable @endif</td>
                            <th class="w-20">State/District</th>
                            <td class="w-80">@if($data->state_district){{ $data->state_district }}@else Not Applicable @endif</td>
                        </tr>
                    </table>
            </div> 

            <div class="block">
                <div class="block-head">
                    Product Information
                </div>
                    <table>
                        <tr>
                            <th class="w-20">Manufacturer</th>
                            <td class="w-80">@if($data->manufacturer){{ $data->manufacturer }}@else Not Applicable @endif</td>
                        </tr>
                    </table>
            </div>
            <div class="border-table">
                <div class="block-head">
                    Product/Material
                </div>
                <table>
                    <tr class="table_bg">
                        <th class="w-20">SR no.</th>
                        <th class="w-20">Product Name</th>
                        <th class="w-20">Batch Number</th>
                        <th class="w-20">Manufactured Date</th>
                        <th class="w-20">Expiry Date</th>
                        <th class="w-20">Disposition</th>
                        <th class="w-20">Comments</th>
                        <th class="w-20">Remarks</th>
                    </tr>
                    @if ($grid_Data && is_array($grid_Data->data))
                            @foreach ($grid_Data->data as $grid_Data)
                                <tr>
                                    <td class="w-20">{{ $loop->index + 1 }}</td>
                                    <td class="w-20">{{ isset($grid_Data['info_product_name']) ? $grid_Data['info_product_name'] : '' }}
                                    </td>
                                    <td class="w-20">{{ isset($grid_Data['info_batch_number']) ? $grid_Data['info_batch_number'] : '' }}</td>
                                    <td class="w-20">{{ isset($grid_Data['info_mfg_date']) ? $grid_Data['info_mfg_date'] : '' }}</td>
                                    <td class="w-20">{{ isset($grid_Data['info_expiry_date']) ? $grid_Data['info_expiry_date'] : '' }}</td>
                                    <td class="w-20">{{ isset($grid_Data['info_disposition']) ? $grid_Data['info_disposition'] : '' }}</td>
                                    <td class="w-20">{{ isset($grid_Data['info_comments']) ? $grid_Data['info_comments'] : '' }}</td>
                                    <td class="w-20">{{ isset($grid_Data['info_remarks']) ? $grid_Data['info_remarks'] : '' }}</td>
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
            
            <div class="block">
                <div class="block-head">
                    Country Submission Information
                </div>
                    <table>
                        <tr>
                            <th class="w-20">Number (Id)</th>
                            <td class="w-80">@if($data->number_id){{ $data->number_id }}@else Not Applicable @endif</td>
                            <th class="w-20">Project Code</th>
                            <td class="w-80">@if($data->project_code){{ $data->project_code }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Authority Type</th>
                            <td class="w-80">@if($data->authority_type){{ $data->authority_type }}@else Not Applicable @endif</td>
                            <th class="w-20">Authority</th>
                            <td class="w-80">@if($data->authority){{ $data->authority }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Priority Level</th>
                            <td class="w-80">@if($data->priority_level){{ $data->priority_level }}@else Not Applicable @endif</td>
                            <th class="w-20">Other Authority</th>
                            <td class="w-80">@if($data->other_authority){{ $data->other_authority }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Approval Status</th>
                            <td class="w-80">@if($data->approval_status){{ $data->approval_status }}@else Not Applicable @endif</td>
                            <th class="w-20">Managed by Company</th>
                            <td class="w-80">@if($data->managed_by_company){{ $data->managed_by_company }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Marketing Status</th>
                            <td class="w-80">@if($data->marketing_status){{ $data->marketing_status }}@else Not Applicable @endif</td>
                            <th class="w-20">Therapeutic Area</th>
                            <td class="w-80">@if($data->therapeutic_area){{ $data->therapeutic_area }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">End of Trial Date Status</th>
                            <td class="w-80">@if($data->end_of_trial_date_status){{ $data->end_of_trial_date_status }}@else Not Applicable @endif</td>
                            <th class="w-20">Protocol Type</th>
                            <td class="w-80">@if($data->protocol_type){{ $data->protocol_type }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Registration Status</th>
                            <td class="w-80">@if($data->registration_status){{ $data->registration_status }}@else Not Applicable @endif</td>
                            <th class="w-20">Unblinded SUSAR to CEC</th>
                            <td class="w-80">@if($data->unblinded_SUSAR_to_CEC){{ $data->unblinded_SUSAR_to_CEC }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Trade Name</th>
                            <td class="w-80">@if($data->trade_name){{ $data->trade_name }}@else Not Applicable @endif</td>
                            <th class="w-20">Dosage Form</th>
                            <td class="w-80">@if($data->dosage_form){{ $data->dosage_form }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Photocure Trade Name</th>
                            <td class="w-80">@if($data->photocure_trade_name){{ $data->photocure_trade_name }}@else Not Applicable @endif</td>
                            <th class="w-20">Currency</th>
                            <td class="w-80">@if($data->currency){{ $data->currency }}@else Not Applicable @endif</td>
                        </tr>
                    </table>
            </div> 
            
            <div class="border-table">
                <div class="block-head">
                    Attached Payments
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Batch No</th>
                    </tr>
                        @if($data->attacehed_payments)
                        @foreach(json_decode($data->attacehed_payments) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
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

            <div class="block">
                    <table>
                        <tr>
                            <th class="w-20">Follow Up Documents</th>
                            <td class="w-80">@if($data->follow_up_documents){{ $data->follow_up_documents }}@else Not Applicable @endif</td>
                            <th class="w-20">Hospitals</th>
                            <td class="w-80">@if($data->hospitals){{ $data->hospitals }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Vendors</th>
                            <td class="w-80">@if($data->vendors){{ $data->vendors }}@else Not Applicable @endif</td>
                            <th class="w-20">INN(s)</th>
                            <td class="w-80">@if($data->INN){{ $data->INN }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Route of Administration</th>
                            <td class="w-80">@if($data->route_of_administration){{ $data->route_of_administration }}@else Not Applicable @endif</td>
                            <th class="w-20">1st IB Version</th>
                            <td class="w-80">@if($data->first_IB_version){{ $data->first_IB_version }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">1st Protocol Version</th>
                            <td class="w-80">@if($data->first_protocol_version){{ $data->first_protocol_version }}@else Not Applicable @endif</td>
                            <th class="w-20">EudraCT Number</th>
                            <td class="w-80">@if($data->eudraCT_number){{ $data->eudraCT_number }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Budget</th>
                            <td class="w-80">@if($data->budget){{ $data->budget }}@else Not Applicable @endif</td>
                            <th class="w-20">Phase of Study</th>
                            <td class="w-80">@if($data->phase_of_study){{ $data->phase_of_study }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Related Clinical Trials</th>
                            <td class="w-80">@if($data->related_clinical_trials){{ $data->related_clinical_trials }}@else Not Applicable @endif</td>
                            <th class="w-20">Data Safety Notes</th>
                            <td class="w-80">@if($data->data_safety_notes){{ $data->data_safety_notes }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Comments</th>
                            <td class="w-80">@if($data->comments){{ $data->comments }}@else Not Applicable @endif</td>
                        </tr>
                    </table>
            </div>  
            
            <div class="border-table">
                <div class="block-head">
                    Financial Transactions
                </div>
                <table>
                    <tr class="table_bg">
                        <th class="w-20">SR no.</th>
                        <th class="w-20">Transaction</th>
                        <th class="w-20">Transaction Type</th>
                        <th class="w-20">Date</th>
                        <th class="w-20">Amount</th>
                        <th class="w-20">Currency Used</th>
                        <th class="w-20">Comments</th>
                        <th class="w-20">Remarks</th>
                    </tr>
                    @if ($second_grid && is_array($second_grid->data))
                            @foreach ($second_grid->data as $second_grid)
                                <tr>
                                    <td class="w-20">{{ $loop->index + 1 }}</td>
                                    <td class="w-20">{{ isset($second_grid['info_transaction']) ? $second_grid['info_transaction'] : '' }}
                                    </td>
                                    <td class="w-20">{{ isset($second_grid['info_transaction_type']) ? $second_grid['info_transaction_type'] : '' }}</td>
                                    <td class="w-20">{{ isset($second_grid['info_date']) ? $second_grid['info_date'] : '' }}</td>
                                    <td class="w-20">{{ isset($second_grid['info_amount']) ? $second_grid['info_amount'] : '' }}</td>
                                    <td class="w-20">{{ isset($second_grid['info_currency_used']) ? $second_grid['info_currency_used'] : '' }}</td>
                                    <td class="w-20">{{ isset($second_grid['info_comments']) ? $second_grid['info_comments'] : '' }}</td>
                                    <td class="w-20">{{ isset($second_grid['info_remarks']) ? $second_grid['info_remarks'] : '' }}</td>
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
            
            <div class="block">
                <div class="block-head">
                    important Dates And Persons
                </div>
                    <table>
                        <tr>
                            <th class="w-20">Annual IB Update Date Due</th>
                            <td class="w-80">@if($data->annual_IB_update_date_due){{ $data->annual_IB_update_date_due }}@else Not Applicable @endif</td>
                            <th class="w-20">Date of 1st IB</th>
                            <td class="w-80">@if($data->date_of_first_IB){{ $data->date_of_first_IB }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Date of 1st Protocol</th>
                            <td class="w-80">@if($data->date_of_first_protocol){{ $data->date_of_first_protocol }}@else Not Applicable @endif</td>
                            <th class="w-20">Date Safety Report</th>
                            <td class="w-80">@if($data->date_safety_report){{ $data->date_safety_report }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Date Trial Active</th>
                            <td class="w-80">@if($data->date_trial_active){{ $data->date_trial_active }}@else Not Applicable @endif</td>
                            <th class="w-20">End of Study Report Date</th>
                            <td class="w-80">@if($data->end_of_study_report_date){{ $data->end_of_study_report_date }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">End of Study Synopsis Date</th>
                            <td class="w-80">@if($data->end_of_study_synopsis_date){{ $data->end_of_study_synopsis_date }}@else Not Applicable @endif</td>
                            <th class="w-20">End of Trial Date</th>
                            <td class="w-80">@if($data->end_of_trial_date){{ $data->end_of_trial_date }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Last Visit</th>
                            <td class="w-80">@if($data->last_visit){{ $data->last_visit }}@else Not Applicable @endif</td>
                            <th class="w-20">Next Visit</th>
                            <td class="w-80">@if($data->next_visit){{ $data->next_visit }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Ethics Commitee Approval</th>
                            <td class="w-80">@if($data->ethics_commitee_approval){{ $data->ethics_commitee_approval }}@else Not Applicable @endif</td>
                        </tr>
                    </table>
            </div>

            <div class="block">
                <div class="block-head">
                    Persons Involved
                </div>
                    <table>
                        <tr>
                            <th class="w-20">Safety Impact Risk</th>
                            <td class="w-80">@if($data->safety_impact_risk){{ $data->safety_impact_risk }}@else Not Applicable @endif</td>
                            <th class="w-20">CROM</th>
                            <td class="w-80">@if($data->CROM){{ $data->CROM }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Lead Investigator</th>
                            <td class="w-80">@if($data->lead_investigator){{ $data->lead_investigator }}@else Not Applicable @endif</td>
                            <th class="w-20">Sponsor</th>
                            <td class="w-80">@if($data->sponsor){{ $data->sponsor }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Additional Investigators</th>
                            <td class="w-80">@if($data->additional_investigators){{ $data->additional_investigators }}@else Not Applicable @endif</td>
                            <th class="w-20">Clinical Events Committee</th>
                            <td class="w-80">@if($data->clinical_events_committee){{ $data->clinical_events_committee }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Clinical Research Team</th>
                            <td class="w-80">@if($data->clinical_research_team){{ $data->clinical_research_team }}@else Not Applicable @endif</td>
                            <th class="w-20">Data Safety Monitoring Board</th>
                            <td class="w-80">@if($data->data_safety_monitoring_board){{ $data->data_safety_monitoring_board }}@else Not Applicable @endif</td>
                        </tr>
                        <tr>
                            <th class="w-20">Distribution List</th>
                            <td class="w-80">@if($data->distribution_list){{ $data->distribution_list }}@else Not Applicable @endif</td>
                        </tr>
                    </table>
            </div>

            <div class="block">
                <div class="block-head">
                    Activity Log
                </div>
                <table>
                    <tr>
                        <th class="w-20">Activate By
                        </th>
                        <td class="w-30">{{ $data->activate_by }}</td>
                        <th class="w-20">
                            Activate On</th>
                        <td class="w-30">{{ $data->activate_on }}</td>
                        <th class="w-20">
                            Activate Comment</th>
                        <td class="w-30">{{ $data->activate_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Close By
                        </th>
                        <td class="w-30">{{ $data->close_by }}</td>
                        <th class="w-20">
                            Close On</th>
                        <td class="w-30">{{ $data->close_on }}</td>
                        <th class="w-20">
                            Close Comment</th>
                        <td class="w-30">{{ $data->close_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Cancel By
                        </th>
                        <td class="w-30">{{ $data->cancel_by }}</td>
                        <th class="w-20">
                            Cancel On</th>
                        <td class="w-30">{{ $data->cancel_on }}</td>
                        <th class="w-20">
                            Cancel Comment</th>
                        <td class="w-30">{{ $data->cancel_comment }}</td>
                    </tr>
                </table>
            </div>        

            </div>
        </div>
    </div>                



</body>
</html>    

