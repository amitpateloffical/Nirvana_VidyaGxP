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
                   Resampling Single Report
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
                    <strong>Resampling No.</strong>
                </td>
                <td class="w-40">
                   {{ Helpers::divisionNameForQMS($data->division_id) }}/Resampling/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
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
                        <th class="w-20">Initiator Group</th>
                        <td class="w-80">@if($data->initiator_Group){{ $data->initiator_Group }}@else Not Applicable @endif</td>
                        <th class="w-20">Initiator Group Code</th>
                        <td class="w-80">@if($data->initiator_group_code){{ $data->initiator_group_code }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">CQ Approver</th>
                        <td class="w-80">@if($data->cq_Approver){{ $data->cq_Approver }}@else Not Applicable @endif</td>
                        <th class="w-20">Supervisor</th>
                        <td class="w-80">@if($data->supervisor){{ $data->supervisor }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">API Material Product Name</th>
                        <td class="w-80">@if($data->api_Material_Product_Name){{ $data->api_Material_Product_Name }}@else Not Applicable @endif</td>
                        <th class="w-20">LOT Batch Number</th>
                        <td class="w-80">@if($data->lot_Batch_Number){{ $data->lot_Batch_Number }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">AR Number</th>
                        <td class="w-80">@if($data->ar_Number_GI){{ $data->ar_Number_GI }}@else Not Applicable @endif</td>
                        <th class="w-20">Test Name</th>
                        <td class="w-80">@if($data->test_Name_GI){{ $data->test_Name_GI }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Justification For Resampling</th>
                        <td class="w-80">@if($data->justification_for_resampling_GI){{ $data->justification_for_resampling_GI }}@else Not Applicable @endif</td>
                        <th class="w-20">Predetermined Sampling Strategies</th>
                        <td class="w-80">@if($data->predetermined_Sampling_Strategies_GI){{ $data->predetermined_Sampling_Strategies_GI }}@else Not Applicable @endif</td>
                    </tr>
                </table>
            </div>
            
            <div class="border-table">
                <div class="block-head">
                    Supporting Attachments
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Batch No</th>
                    </tr>
                        @if($data->supporting_attach)
                        @foreach(json_decode($data->supporting_attach) as $key => $file)
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
            </div><br> 
            
            <div class="block">
                <div class="block-head">
                    Hidden Field
                </div>
                <table>
                    <tr>
                        <th class="w-20">Parent-TCD(hid)</th>
                        <td class="w-80">@if($data->parent_tcd_hid){{ $data->parent_tcd_hid }}@else Not Applicable @endif</td>
                    </tr>
                </table>
            </div>

            <div class="block">
                <div class="block-head">
                    Parent Record Information
                </div>
                <table>
                    <tr>
                        <th class="w-20">(Parent) OOS No.</th>
                        <td class="w-80">@if($data->parent_oos_no){{ $data->parent_oos_no }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">(Parent) OOT No.</th>
                        <td class="w-80">@if($data->parent_oot_no){{ $data->parent_oot_no }}@else Not Applicable @endif</td>
                        <th class="w-20">(Parent) Lab Incident No</th>
                        <td class="w-80">@if($data->parent_lab_incident_no){{ $data->parent_lab_incident_no }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">(Parent)Date Opened</th>
                        <td class="w-80">@if($data->parent_date_opened){{ $data->parent_date_opened }}@else Not Applicable @endif</td>
                        <th class="w-20">(Parent)Short Description</th>
                        <td class="w-80">@if($data->parent_short_description){{ $data->parent_short_description }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">(Parent) Product/Material Name</th>
                        <td class="w-80">@if($data->parent_product_material_name){{ $data->parent_product_material_name }}@else Not Applicable @endif</td>
                        <th class="w-20">(Parent)Target Closure Date</th>
                        <td class="w-80">@if($data->parent_target_closure_date){{ $data->parent_target_closure_date }}@else Not Applicable @endif</td>
                    </tr>
                </table>
            </div>

            <div class="border-table">
                <div class="block-head">
                    Product/Material Information
                </div>
                <table>
                    <tr class="table_bg">
                        <th class="w-20">SR no.</th>
                        <th class="w-20">Product/Material Code</th>
                        <th class="w-20">Batch No.</th>
                        <th class="w-20">AR Number</th>
                        <th class="w-20">Test Name</th>
                        <th class="w-20">Instrument Name</th>
                        <th class="w-20">Instrument No.</th>
                        <th class="w-20">Instru. Caliberation Due Date</th>
                    </tr>
                    @if ($gridDatas1 && is_array($gridDatas1->data))
                            @foreach ($gridDatas1->data as $gridDatas1)
                                <tr>
                                    <td class="w-20">{{ $loop->index + 1 }}</td>
                                    <th class="w-20">{{ isset($gridDatas1['product_material']) ? $gridDatas1['product_material'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas1['batch_no']) ? $gridDatas1['batch_no'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas1['ar_no']) ? $gridDatas1['ar_no'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas1['test_name']) ? $gridDatas1['test_name'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas1['instrument_name']) ? $gridDatas1['instrument_name'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas1['instrument_no']) ? $gridDatas1['instrument_no'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas1['info_date']) ? $gridDatas1['info_date'] : '' }}</th>
                                </tr>
                            @endforeach
                    @else 
                        <tr>
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
            </div>  <br>

            <div class="border-table">
                <div class="block-head">
                    Info. On Product/Material
                </div>
                <table>
                    <tr class="table_bg">
                        <th class="w-20">SR no.</th>
                        <th class="w-20">Item/Product Code</th>
                        <th class="w-20">Lot/Batch Number</th>
                        <th class="w-20">A.R. Number</th>
                        <th class="w-20">Mfg. Date</th>
                        <th class="w-20">Expiry Date</th>
                        <th class="w-20">Label Claim </th>
                        <th class="w-20">Pack Size </th>
                    </tr>
                    @if ($gridDatas2 && is_array($gridDatas2->data))
                            @foreach ($gridDatas2->data as $gridDatas2)
                                <tr>
                                    <td class="w-20">{{ $loop->index + 1 }}</td>
                                    <th class="w-20">{{ isset($gridDatas2['item_product_code']) ? $gridDatas2['item_product_code'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas2['lot_batch_no']) ? $gridDatas2['lot_batch_no'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas2['ar_no']) ? $gridDatas2['ar_no'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas2['info_mfg_date']) ? $gridDatas2['info_mfg_date'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas2['info_expiry_date']) ? $gridDatas2['info_expiry_date'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas2['label_claim']) ? $gridDatas2['label_claim'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas2['pack_size']) ? $gridDatas2['pack_size'] : '' }}</th>
                                </tr>
                            @endforeach
                    @else 
                        <tr>
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
            </div>  <br>

            <div class="border-table">
                <div class="block-head">
                    OOS Details
                </div>
                <table>
                    <tr class="table_bg">
                        <th class="w-20">SR no.</th>
                        <th class="w-20">AR Number</th>
                        <th class="w-20">Test Name of OOS</th>
                        <th class="w-20">Results obtained</th>
                        <th class="w-20">Specification Limit</th>
                    </tr>
                    @if ($gridDatas3 && is_array($gridDatas3->data))
                            @foreach ($gridDatas3->data as $gridDatas3)
                                <tr>
                                    <td class="w-20">{{ $loop->index + 1 }}</td>
                                    <th class="w-20">{{ isset($gridDatas3['ar_no']) ? $gridDatas3['ar_no'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas3['test_name_of_OOS']) ? $gridDatas3['test_name_of_OOS'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas3['results_obtained']) ? $gridDatas3['results_obtained'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas3['specification_limit']) ? $gridDatas3['specification_limit'] : '' }}</th>
                                </tr>
                            @endforeach
                    @else 
                        <tr>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                    @endif
                </table>
            </div>  <br>

            <div class="border-table">
                <div class="block-head">
                    OOT Results
                </div>
                <table>
                    <tr class="table_bg">
                        <th class="w-20">SR no.</th>
                        <th class="w-20">AR Number</th>
                        <th class="w-20">Test Name of OOT</th>
                        <th class="w-20">Results Obtained</th>
                        <th class="w-20">Initial Interval Details</th>
                        <th class="w-20">Previous Interval Details</th>
                        <th class="w-20">%Difference of Results</th>
                        <th class="w-20">Initial Interview Details</th>
                        <th class="w-20">Trend Limit</th>
                    </tr>
                    @if ($gridDatas4 && is_array($gridDatas4->data))
                            @foreach ($gridDatas4->data as $gridDatas4)
                                <tr>
                                    <td class="w-20">{{ $loop->index + 1 }}</td>
                                    <th class="w-20">{{ isset($gridDatas4['ar_no_oot']) ? $gridDatas4['ar_no_oot'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas4['test_name_oot']) ? $gridDatas4['test_name_oot'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas4['results_obtained_oot']) ? $gridDatas4['results_obtained_oot'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas4['initial_Interval_Details_oot']) ? $gridDatas4['initial_Interval_Details_oot'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas4['previous_Interval_Details_oot']) ? $gridDatas4['previous_Interval_Details_oot'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas4['difference_of_Results_oot']) ? $gridDatas4['difference_of_Results_oot'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas4['initial_interview_Details_oot']) ? $gridDatas4['initial_interview_Details_oot'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas4['trend_Limit_oot']) ? $gridDatas4['trend_Limit_oot'] : '' }}</th>
                                </tr>
                            @endforeach
                    @else 
                        <tr>
                            <td>Not Applicable</td>
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
            </div>  <br>

            <div class="border-table">
                <div class="block-head">
                    Details of Stability Study
                </div>
                <table>
                    <tr class="table_bg">
                        <th class="w-20">SR no.</th>
                        <th class="w-20">AR Number</th>
                        <th class="w-20">Condition: Temperature & RH</th>
                        <th class="w-20">Interval</th>
                        <th class="w-20">Orientation</th>
                        <th class="w-20">Pack Details(if any)</th>
                    </tr>
                    @if ($gridDatas5 && is_array($gridDatas5->data))
                            @foreach ($gridDatas5->data as $gridDatas5)
                                <tr>
                                    <td class="w-20">{{ $loop->index + 1 }}</td>
                                    <th class="w-20">{{ isset($gridDatas5['ar_no_stability_stdy']) ? $gridDatas5['ar_no_stability_stdy'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas5['condition_temp_stability_stdy']) ? $gridDatas5['condition_temp_stability_stdy'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas5['interval_stability_stdy']) ? $gridDatas5['interval_stability_stdy'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas5['orientation_stability_stdy']) ? $gridDatas5['orientation_stability_stdy'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas5['pack_details_if_any_stability_stdy']) ? $gridDatas5['pack_details_if_any_stability_stdy'] : '' }}</th>
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
            </div>  <br>

            <div class="border-table">
                <div class="block-head">
                    Details of Stability Study
                </div>
                <table>
                    <tr class="table_bg">
                        <th class="w-20">SR no.</th>
                        <th>AR Number</th>
                        <th>Stability Condition</th>
                        <th>Stability Interval</th>
                        <th>Pack Details(if any)</th>
                        <th>Orientation</th>
                    </tr>
                    @if ($gridDatas6 && is_array($gridDatas6->data))
                            @foreach ($gridDatas6->data as $gridDatas6)
                                <tr>
                                    <td class="w-20">{{ $loop->index + 1 }}</td>
                                    <th class="w-20">{{ isset($gridDatas6['ar_no_stability_stdy2']) ? $gridDatas6['ar_no_stability_stdy2'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas6['stability_condition_stability_stdy2']) ? $gridDatas6['stability_condition_stability_stdy2'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas6['stability_interval_stability_stdy2']) ? $gridDatas6['stability_interval_stability_stdy2'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas6['pack_details_if_any_stability_stdy2']) ? $gridDatas6['pack_details_if_any_stability_stdy2'] : '' }}</th>
                                    <th class="w-20">{{ isset($gridDatas6['orientation_stability_stdy2']) ? $gridDatas6['orientation_stability_stdy2'] : '' }}</th>
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
            </div>  <br>

            <div class="block">
                <div class="block-head">
                    Under Sample Request Approval
                </div>
                <table>
                    <tr>
                        <th class="w-20">Sample Request Approval Comments</th>
                        <td class="w-80">@if($data->sample_Request_Approval_Comments){{ $data->sample_Request_Approval_Comments }}@else Not Applicable @endif</td>
                    </tr>
                </table>
            </div>

            <div class="border-table">
                <div class="block-head">
                    Sample Request Approval Attachment
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Batch No</th>
                    </tr>
                        @if($data->sample_Request_Approval_attachment)
                        @foreach(json_decode($data->sample_Request_Approval_attachment) as $key => $file)
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
            </div><br> 

            <div class="block">
                <div class="block-head">
                    Panding Sample Received
                </div>
                <table>
                    <tr>
                        <th class="w-20">Sample Received</th>
                        <td class="w-80">@if($data->sample_Received){{ $data->sample_Received }}@else Not Applicable @endif</td>
                        <th class="w-20">Sample Quantity</th>
                        <td class="w-80">@if($data->sample_Quantity){{ $data->sample_Quantity }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Sample Received Comments</th>
                        <td class="w-80">@if($data->sample_Received_Comments){{ $data->sample_Received_Comments }}@else Not Applicable @endif</td>
                        <th class="w-20">Delay Justification</th>
                        <td class="w-80">@if($data->delay_Justification){{ $data->delay_Justification }}@else Not Applicable @endif</td>
                    </tr>
                </table>
            </div>

            <div class="border-table">
                <div class="block-head">
                    File Attchment Pending Sample
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Batch No</th>
                    </tr>
                        @if($data->file_attchment_pending_sample)
                        @foreach(json_decode($data->file_attchment_pending_sample) as $key => $file)
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
            </div><br>

            <div class="block">
                <div class="block-head">
                    Activity Log
                </div>
                <table>
                    <tr>
                        <th class="w-20">Submit By </th>
                        <td class="w-30">{{ $data->submitted_by }}</td>
                        <th class="w-20">Submit On </th>
                        <td class="w-30">{{ $data->submitted_on }}</td>
                        <th class="w-20">Submit Comment </th>
                        <td class="w-30">{{ $data->submitted_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Sample Req. Approval Done By </th>
                        <td class="w-30">{{ $data->approval_done_by }}</td>
                        <th class="w-20">Sample Req. Approval Done On </th>
                        <td class="w-30">{{ $data->approval_done_on }}</td>
                        <th class="w-20">Sample Req. Approval Done Comment </th>
                        <td class="w-30">{{ $data->approval_done_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Sample Received Completed By </th>
                        <td class="w-30">{{ $data->sample_received_by }}</td>
                        <th class="w-20">Sample Received Completed On </th>
                        <td class="w-30">{{ $data->sample_received_on }}</td>
                        <th class="w-20">Sample Received Completed Comment </th>
                        <td class="w-30">{{ $data->sample_received_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Cancel Request By </th>
                        <td class="w-30">{{ $data->cancelled_by }}</td>
                        <th class="w-20">Cancel Request On </th>
                        <td class="w-30">{{ $data->cancelled_on }}</td>
                        <th class="w-20">Cancel Request Commet </th>
                        <td class="w-30">{{ $data->cancelled_comment }}</td>
                    </tr>
                </table>
            </div>        

            </div>
        </div>
    </div>                



</body>
</html>    

