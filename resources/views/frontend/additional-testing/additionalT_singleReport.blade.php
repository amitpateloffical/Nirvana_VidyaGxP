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
    <div>
      <header>
        <table>
            <tr>
                <td class="w-70 head">
                Additional Testing Single Report
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
                    <strong>Additional Testing No.</strong>{{ Helpers::divisionNameForQMS($data->division_id) }}/{{ Helpers::year($data->created_at) }}/{{ $data->record_number ? str_pad($data->record_number, 4, '0', STR_PAD_LEFT) : '' }}
                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                </td>
            </tr>
        </table>
        </header>
    </div>


    <div class="inner-block">
        <div class="content-table">
            <div class="block">

                <div class="block-head"> Parent Record Information </div>
                <table>
                       <tr>  {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">(Parent) OOS No.</th>
                        <td class="w-30">@if($data->root_parent_oos_number){{ $data->root_parent_oos_number }}@else Not Applicable @endif</td>
                        <th class="w-20">(Parent) OOT No.</th>
                        <td class="w-80">@if($data->root_parent_oot_number){{ $data->root_parent_oot_number }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">(Parent) Date Opened</th>
                        <td class="w-30">@if($data->parent_date_opened){{ $data->parent_date_opened }}@else Not Applicable @endif</td>
                        <th class="w-20">(Parent) Short Description</th>
                        <td class="w-80">@if($data->parent_short_description){{ $data->parent_short_description }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">(Parent) Target Closure Date</th>
                        <td class="w-80">@if($data->parent_target_closure_date){{ $data->parent_target_closure_date }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">(Parent) Product/Material Name</th>
                        <td class="w-30">@if($data->parent_product_mat_name){{ $data->parent_product_mat_name }}@else Not Applicable @endif</td>
                        <th class="w-20">(Root Parent) Product/Material Name</th>
                        <td class="w-80">@if($data->root_parent_prod_mat_name){{ $data->root_parent_prod_mat_name }}@else Not Applicable @endif</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="inner-block">
        <div class="content-table">
            <div class="block">

                <div class="block-head"> General Information </div>
                <table>
                       <tr>  {{ $data->created_at }} added by {{ $data->initiator_id }}
                        <th class="w-20">Initiator</th>
                        <td class="w-30">@if($data->initiator){{ $data->initiator }}@else Not Applicable @endif</td>
                        <th class="w-20">Date of Initiation</th>
                        <td class="w-30">@if($data->intiation_date){{ $data->intiation_date }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Record Number</th>
                        <td class="w-30">@if($data->record_number){{  str_pad($data->record_number, 4, '0', STR_PAD_LEFT) }} @else Not Applicable @endif</td>
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-30">@if($data->division_code){{ $data->division_code }} @else Not Applicable @endif</td>
                    </tr>
                    {{-- <tr>
                        {{-- <th class="w-20">Due Date</th>
                        <td class="w-30">@if($data->due_date){{  str_pad($data->due_date, 4, '0', STR_PAD_LEFT) }} @else Not Applicable @endif</td> --}}
                        {{-- <th class="w-20">Short Description</th> --}}
                        {{-- <td class="w-80">@if($data->short_description){{ $data->short_description }}@else Not Applicable @endif</td> --}}

                    <tr>
                        <th class="w-20">Target Closure Date</th>
                        <td class="w-30">@if($data->gi_target_closure_date){{ Helpers::getInitiatorName($data->gi_target_closure_date) }} @else Not Applicable @endif</td>
                        <th class="w-20">Short Description</th>
                        <td class="w-80">@if($data->short_description){{ $data->short_description }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                       <th class="w-20">QC Approver</th>
                        <td class="w-80">@if($data->assignee){{ $data->qc_approver }}@else Not Applicable @endif</td>
                        {{-- <th class="w-20">Description </th> --}}
                        {{-- <td class="w-80">@if($data->description){{ $data->description }}@else Not Applicable @endif</td> --}}
                    </tr>
                    {{-- <tr>
                        <th class="w-20">Analyst Interview Parts</th>
                        <td class="w-80">@if($data->dossier_parts){{ $data->dossier_parts }}@else Not Applicable @endif</td>
                    </tr> --}}
                </table>
            </div>
        </div>
    </div>
    <div class="inner-block">
        <div class="content-table">
            <div class="block">
                <div class="block-head"> Analyst Interview </div>
                <table>
                    <tr>
                        <th class="w-30">Analyst Qualification Date</th>
                        <td class="w-80">@if($data->analyst_qualification_date){{ $data->analyst_qualification_date }}@else Not Applicable @endif</td>
                        {{-- <th class="w-20">(Root Parent) Product Code</th>
                        <td class="w-80">@if($data->root_parent_product_code){{ $data->root_parent_product_code }}@else Not Applicable @endif</td> --}}
                    </tr>
                    </div>
                </table>
            </div>
        </div>


        <div class="block"><strong>
            Info. On Product/ Material</strong>
    <hr style="width: 100%; height: 3px; background-color: black; border: none;">
        <div class="border-table">
            <table>
                <tr class="table_bg">
                {{-- <th colspan="1">SR no.</th> --}}
                <th style="width: 4%">Row#</th>
                <th style="width: 8%">Item/Product Code</th>
                <th style="width: 8%"> Batch No*.</th>
                <th style="width: 8%">AR Number.</th>
                <th style="width: 8%"> Mfg.Date</th>
                <th style="width: 8%">Expiry Date</th>
                <th style="width: 8%"> Label Claim.</th>

                </tr>
                <tr>
                    {{-- @php
                        dd($gridDatas01);
                    @endphp --}}
                    @foreach($gridDatas01->data as $datas)

                    <td>{{$loop->index+1}}</td>
                    <td>{{$datas['item_product_code']}}</td>
                    <td>{{$datas['lot_batch_number']}}</td>
                    <td>{{$datas['ar_number']}}</td>
                    <td>{{$datas['mfg_date']}}</td>
                    <td>{{$datas['exp_date']}}</td>
                    <td>{{$datas['label_claim']}}</td>

                </tr>
                @endforeach
                {{-- @endif --}}
            </table>
        </div>
    </div>


    <div class="block"><strong>
        Info. On Product/ Material</strong>
<hr style="width: 100%; height: 3px; background-color: black; border: none;">
    <div class="border-table">
        <table>
            <tr class="table_bg">
            {{-- <th colspan="1">SR no.</th> --}}
            <th style="width: 4%">Row#</th>
            <th style="width: 8%">Item/Product Code</th>
            <th style="width: 8%"> Batch No*.</th>
            <th style="width: 8%">AR Number.</th>
            <th style="width: 8%"> Mfg.Date</th>
            <th style="width: 8%">Expiry Date</th>
            <th style="width: 8%"> Label Claim.</th>
            <th style="width: 8%">Pack Size</th>

            </tr>
            <tr>
                @foreach($gridDatas02->data as $datas)

                <td>{{$loop->index+1}}</td>
                <td>{{$datas['item_product_code']}}</td>
                <td>{{$datas['batch_no']}}</td>
                <td>{{$datas['ar_number']}}</td>
                <td>{{$datas['mfg_date']}}</td>
                <td>{{$datas['exp_date']}}</td>
                <td>{{$datas['label_claim']}}</td>
                <td>{{$datas['pack_size']}}</td>

            </tr>
            @endforeach
            {{-- @endif --}}
        </table>
    </div>
</div>

    {{-- <div class="border-table">
        <table>
            <tr class="table_bg">
            <th colspan="1">SR no.</th>
            <th style="width: 8%">Pack Size</th>
            <th style="width: 8%">Analyst Name</th>
            <th style="width: 10%">Others (Specify)</th>
            <th style="width: 10%"> In- Process Sample Stage.</th>
            <th style="width: 12% pt-3">Packing Material Type</th>
            <th style="width: 16% pt-2"> Stability for</th>
            </tr>
            <tr>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            @endif
        </table>
    </div> --}}

    <div class="sub-head"><strong>(Parent) Details of Stability Study </strong></div>
    <hr style="width: 100%; height: 3px; background-color: black; border: none;">

        <div class="border-table">
            <table>
                <tr class="table_bg">
                {{-- <th colspan="1">SR no.</th> --}}
                <th style="width: 4%">Row#</th>
                        <th style="width: 1%">AR Number</th>
                        <th style="width: 1%">Condition: Temperature & RH</th>
                        <th style="width: 1%">Interval</th>
                        <th style="width: 2%">Orientation</th>
                        <th style="width: 8%">Pack Details (if any)</th>
                </tr>
                <tr>
                    @php
                        // dd($gridDatas05);
                    @endphp
                    @foreach($gridDatas05->data as $datas)

                    <td>{{$loop->index+1}}</td>
                    <td>{{$datas['ar_number']}}</td>
                    <td>{{$datas['condition_temp_and_rh']}}</td>
                    <td>{{$datas['interval']}}</td>
                    <td>{{$datas['orientation']}}</td>
                    <td>{{$datas['pack_details_if_any']}}</td>
                </tr>
                @endforeach
            </table>
    </div>
    {{-- <div class="border-table">
        <table>
            <tr class="table_bg">
            <th colspan="1">SR no.</th>
                    <th style="width: 10%">Specification No.</th>
                    <th style="width: 10%">Sample Description</th>
            </tr>
            <tr>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
        </table>
</div> --}}
    <div class="sub-head"><strong>OOS Details </strong></div>
    <hr style="width: 100%; height: 3px; background-color: black; border: none;">
        <div class="border-table">
            <table>
                <tr class="table_bg">
                {{-- <th colspan="1">SR no.</th> --}}
                <th style="width: 4%">Row#</th>
                        <th style="width: 8%">AR Number.</th>
                        <th style="width: 8%">Test Name of OOS</th>
                        <th style="width: 12%">Results Obtained</th>
                        <th style="width: 16%">Specification Limit</th>
                </tr>
                @foreach($gridDatas03->data as $datas)
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$datas['ar_number']}}</td>
                    <td>{{$datas['test_name_of_oos']}}</td>
                    <td>{{$datas['results_obtained']}}</td>
                    <td>{{$datas['specification_limit']}}</td>
                </tr>
                @endforeach

                {{-- @endif --}}
            </table>
    </div>

    <div class="sub-head"><strong>OOT Details </strong></div>
    <hr style="width: 100%; height: 3px; background-color: black; border: none;">
        <div class="border-table">
            <table>
                <tr class="table_bg">
                {{-- <th colspan="1">SR no.</th> --}}
                <th style="width: 4%">Row#</th>
                        <th style="width: 2%">AR Number.</th>
                        <th style="width: 2%">Test Name of OOT</th>
                        <th style="width: 4%">Results Obtained</th>
                        <th style="width: 4%">Previous Interval Details</th>
                        <th style="width: 4%">% Difference of Results</th>
                        <th style="width: 4%">Initial Interview Details</th>
                        <th style="width: 2%">Trend Limit</th>

                </tr>
                @foreach($gridDatas04->data as $datas)

                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$datas['ar_number']}}</td>
                    <td>{{$datas['test_number_of_oot']}}</td>
                    <td>{{$datas['results_obtained']}}</td>
                    <td>{{$datas['prev_interval_details']}}</td>
                    <td>{{$datas['diff_of_results']}}</td>
                    <td>{{$datas['initial_interview_details']}}</td>
                    <td>{{$datas['trend_limit']}}</td>
                </tr>
                @endforeach
                {{-- @endif --}}
            </table>
    </div>

    <div class="inner-block">
        <div class="content-table">
            <div class="block">

                <div class="block-head">Add. Test Proposal Comment</div>
                <table>
                       <tr>  {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20"> CQ Approver
                            Comments</th>
                        <td class="w-30">{{ $data->cq_approver_comments }}@if($data->Quality_review){{ $data->Quality_review }}@else Not Applicable @endif</td>
                        <th class="w-20">Resampling Required</th>
                        <td class="w-80">{{ $data->resampling_required }}@if($data->Quality_review){{ $data->Quality_review }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Resample Reference</th>
                        <td class="w-30">@if($data->resampling_reference){{  str_pad($data->resampling_reference, 4, '0', STR_PAD_LEFT) }} @else Not Applicable @endif</td>
                        <th class="w-20">Assignee</th>
                        <td class="w-80">@if($data->assignee){{ $data->assignee }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">AQA Apporover</th>
                        <td class="w-30">@if($data->aqa_approver){{  str_pad($data->aqa_approver, 4, '0', STR_PAD_LEFT) }} @else Not Applicable @endif</td>
                        <th class="w-20">CQ Apporver</th>
                        <td class="w-80">@if($data->cq_approver){{ $data->cq_approver }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Additional Test Attachment</th>
                        <td class="w-80">@if($data->add_test_attachment){{  str_pad($data->add_test_attachment, 4, '0', STR_PAD_LEFT) }} @else Not Applicable @endif</td>

                    </tr>
                </table>
            </div>
        </div>
    </div>


    <div class="inner-block">
        <div class="content-table">
            <div class="block">
                <div class="block-head"> CQ Approval Comment</div>
                <table>
                       <tr>  {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20"> CQ Approval Comment</th>
                        <td class="w-80">@if($data->cq_approval_comment){{ $data->cq_approval_comment }}@else Not Applicable @endif</td>
                        <th class="w-20">CQ Approval Attachment</th>
                        <td class="w-80">@if($data->cq_approval_attachment){{ $data->cq_approval_attachment }}@else Not Applicable @endif</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>


    <div class="inner-block">
        <div class="content-table">
            <div class="block">

                <div class="block-head">Add. Testing Execution Comment </div>
                <table>
                       <tr>  {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">Comments (if any)</th>
                        <td class="w-30">@if($data->add_testing_execution_comment){{ $data->add_testing_execution_comment }}@else Not Applicable @endif</td>
                        <th class="w-20">Delay Justification</th>
                        <td class="w-30">@if($data->delay_justifictaion){{  str_pad($data->delay_justifictaion, 4, '0', STR_PAD_LEFT) }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Additional Test Exe. Attachment</th>
                        <td class="w-30">@if($data->add_test_exe_attachment){{ $data->add_test_exe_attachment }}@else Not Applicable @endif</td>
                        {{-- <th class="w-20">Assignee</th> --}}
                        {{-- <td class="w-30">@if($data->assignee){{ $data->assignee }} @else Not Applicable @endif</td> --}}
                    </tr>

                </table>
            </div>
        </div>
    </div>



    <div class="inner-block">
        <div class="content-table">
            <div class="block">

                <div class="block-head"> Add. Testing QC Comment</div>
                <table>
                       <tr>  {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">QC Comments on Addl. Testing</th>
                        <td class="w-30">{{ $data->qc_comments_on_addl_testing }}@if($data->qc_comments_on_addl_testing){{ $data->qc_comments_on_addl_testing }}@else Not Applicable @endif</td>
                        <th class="w-20">QC Review Attachment</th>
                        <td class="w-30">{{ $data->qc_review_attachment }}@if($data->qc_review_attachment){{ $data->qc_comments_on_addl_testing }}@else Not Applicable @endif</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="inner-block">
        <div class="content-table">
            <div class="block">

                <div class="block-head"> Additional Testing AQA Comment</div>
                <table>
                       <tr>  {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">Summary of Exp./Hyp.</th>
                        <td class="w-30">@if($data->summary_of_exp_hyp){{ $data->summary_of_exp_hyp }}@else Not Applicable @endif</td>
                        <th class="w-20">AQA Review Attachment</th>
                        <td class="w-30">@if($data->aqa_review_attachment){{ $data->aqa_review_attachment }}@else Not Applicable @endif</td>
                    </tr>
                </table>
            </div>
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

            </tr>
        </table>
    </footer>

</body>

</html>
