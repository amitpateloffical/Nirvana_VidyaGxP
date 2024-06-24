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
            Verification Document Single Report
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
                    <strong>Verification Document No.</strong>{{ Helpers::divisionNameForQMS($data->division_id) }}/{{ Helpers::year($data->created_at) }}/{{ $data->record_number ? str_pad($data->record_number, 4, '0', STR_PAD_LEFT) : '' }}
                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($data->record_number, 4, '0', STR_PAD_LEFT) }}
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
                        <td class="w-30">{{ $data->root_parent_oos_number }}</td>
                        <th class="w-20">(Parent) OOT No.</th>
                        <td class="w-30">{{ $data->root_parent_oot_number }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">(Parent) Date Opened</th>
                        <td class="w-30">{{ $data->parent_date_opened }}</td>
                        <th class="w-20">(Parent) Short Description</th>
                        <td class="w-30">{{ $data->parent_short_description }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">(Parent) Target Closure Date</th>
                        <td class="w-30">{{ $data->parent_target_closure_date }}</td>
                    <tr>
                        <th class="w-20">(Parent) Product/Material Name</th>
                        <td class="w-30">{{ $data->parent_product_mat_name }}</td>
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
                        <td class="w-30">{{ $data->initiator_id }}</td>
                        <th class="w-20">Date of Initiation</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->intiation_date) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Record Number</th>
                        <td class="w-30">@if($data->record_number){{  str_pad($data->record_number, 4, '0', STR_PAD_LEFT) }} @else Not Applicable @endif</td>
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-30">@if($data->division_code){{ $data->division_code }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        {{-- <th class="w-20">Due Date</th>
                        <td class="w-30">@if($data->due_date){{  str_pad($data->due_date, 4, '0', STR_PAD_LEFT) }} @else Not Applicable @endif</td> --}}
                        <th class="w-20">Short Description</th>
                        <td class="w-80">@if($data->short_description){{ $data->short_description }}@else Not Applicable @endif</td>

                    <tr>
                        <th class="w-20">Target Closure Date</th>
                        <td class="w-30">@if($data->target_closure_date_gi){{ Helpers::getInitiatorName($data->assign_to) }} @else Not Applicable @endif</td>
                        <th class="w-20">Short Description</th>
                        <td class="w-80">{{ $data->short_description }}</td>
                    </tr>
                    <tr>
                       <th class="w-20">Assignee</th>
                        <td class="w-80">@if($data->assignee){{ $data->assignee }}@else Not Applicable @endif</td>
                        <th class="w-20">Supervisor </th>
                        <td class="w-80">@if($data->supervisor){{ $data->supervisor }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">AQA Reviewer</th>
                         <td class="w-80">@if($data->aqa_reviewer){{ $data->aqa_reviewer }}@else Not Applicable @endif</td>
                         <th class="w-20">Recommended Actions </th>
                         <td class="w-80">@if($data->description){{ $data->description }}@else Not Applicable @endif</td>
                     </tr>
                     <tr>
                        <th class="w-20">Specify If Any Other Action</th>
                         <td class="w-80">@if($data->aqa_reviewer){{ $data->aqa_reviewer }}@else Not Applicable @endif</td>
                         <th class="w-20">Justification For Actions </th>
                         <td class="w-80">@if($data->description){{ $data->description }}@else Not Applicable @endif</td>
                     </tr>
                    {{-- <tr>
                        <th class="w-20">Analyst Interview Parts</th>
                        <td class="w-80">@if($data->dossier_parts){{ $data->dossier_parts }}@else Not Applicable @endif</td>
                    </tr> --}}
                </table>
            </div>
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
            <th style="width: 8%">Lot/Batch Number</th>
            </tr>
            <tr>
                @foreach($gridDatas02->data as $datas)

                <td></td>
                <td>{{$datas['product_code']}}</td>
                <td>{{$datas['batch_no']}}</td>
                <td>{{$datas['ar_number']}}</td>
                <td>{{$datas['mfg_date']}}</td>
                <td>{{$datas['expiry_date']}}</td>
                <td>{{$datas['label']}}</td>
                <td>{{$datas['pack_size']}}</td>
                <td>{{$datas['lot_batch_no']}}</td>


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
        <th style="width: 8%">AR Number.</th>
        <th style="width: 8%"> Mfg.Date</th>
        <th style="width: 8%">Expiry Date</th>
        <th style="width: 8%"> Label Claim.</th>


        </tr>
        <tr>
            @foreach($gridDatas01->data as $datas)

            <td></td>
            <td>{{$datas['product_code']}}</td>
            <td>{{$datas['ar_number']}}</td>
            <td>{{$datas['mfg_date']}}</td>
            <td>{{$datas['expiry_date']}}</td>
            <td>{{$datas['name']}}</td>
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

<div class="sub-head"><strong> Details of Stability Study </strong></div>
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
                @foreach($gridDatas05->data as $datas)

                <td>1</td>
                <td>{{$datas['ar_number']}}</td>
                <td>{{$datas['temperature_rh']}}</td>
                <td>{{$datas['interval']}}</td>
                <td>{{$datas['orientation']}}</td>
                <td>{{$datas['pack_details']}}</td>
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
                <td>1</td>
                <td>{{$datas['ar_number']}}</td>
                <td>{{$datas['test_name_of_oos']}}</td>
                <td>{{$datas['result_obtained']}}</td>
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
                    <th style="width: 8%">AR Number.</th>
                    <th style="width: 8%">Test Name of OOT</th>
                    <th style="width: 8%">Results Obtained</th>
                    <th style="width: 8%">Previous Interval Details</th>
                    <th style="width: 8%">% Difference of Results</th>
                    <th style="width: 8%">Initial Interview Details</th>
                    <th style="width: 8%">Trend Limit</th>

            </tr>
            @foreach($gridDatas04->data as $datas)

            <tr>
                <td>1</td>
                <td>{{$datas['AR_Number']}}</td>
                <td>{{$datas['Test_Name_Of_OOT']}}</td>
                <td>{{$datas['Result_Obtained']}}</td>
                <td>{{$datas['Previous_Interval_Details']}}</td>
                <td>{{$datas['Previous_Interval_Details']}}</td>
                <td>{{$datas['Difference_Of_Results']}}</td>
                <td>{{$datas['Trend_Limit']}}</td>

            </tr>
            @endforeach
            {{-- @endif --}}
        </table>
</div>

<div class="inner-block">
    <div class="content-table">
        <div class="block">

            <div class="block-head">Analysis in Progress </div>
            <table>
                   <tr>  {{ $data->created_at }} added by {{ $data->originator }}
                    <th class="w-20">Results of Recommended Actions</th>
                    <td class="w-30">{{ $data->results_of_recommended_actions }}</td>
                    <th class="w-20">Date of Completion</th>
                    <td class="w-30">{{ Helpers::getdateFormat($data->date_of_completion) }}</td>
                </tr>
                <tr>
                    <th class="w-20">Execution Attachment</th>
                    <td class="w-30">@if($data->execution_attachment){{  str_pad($data->execution_attachment, 4, '0', STR_PAD_LEFT) }} @else Not Applicable @endif</td>
                    <th class="w-20">Delay Justification</th>
                    <td class="w-30">@if($data->delay_justification){{ $data->delay_justification }} @else Not Applicable @endif</td>
                </tr>
            </table>
        </div>
    </div>
</div>


<div class="inner-block">
    <div class="content-table">
        <div class="block">

            <div class="block-head">QC Verification </div>
            <table>
                   <tr>  {{ $data->created_at }} added by {{ $data->originator }}
                    <th class="w-20">Supervisor Observations</th>
                    <td class="w-30">{{ $data->supervisor_observation }}</td>
                    <th class="w-20">Verification Attachment</th>
                    <td class="w-30">{{ Helpers::getdateFormat($data->verification_attachment) }}</td>
                </tr>

            </table>
        </div>
    </div>
</div>


<div class="inner-block">
    <div class="content-table">
        <div class="block">

            <div class="block-head">AQA Verification </div>
            <table>
                   <tr>  {{ $data->created_at }} added by {{ $data->originator }}
                    <th class="w-20">AQA Comments</th>
                    <td class="w-30">{{ $data->aqa_comments2 }}</td>
                    <th class="w-20">AQA Attachment</th>
                    <td class="w-30">{{ Helpers::getdateFormat($data->aqa_attachment) }}</td>
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
