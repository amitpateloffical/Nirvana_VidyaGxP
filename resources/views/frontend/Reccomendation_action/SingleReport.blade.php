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
                    Recomended Action  Single Report
                </td>
                <td class="w-30">
                    <div class="logo">
                        <img src="" alt="" class="w-100">
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="w-30">
                    <strong>Recomended Action Audit No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::divisionNameForQMS($data->division_id) }}/IA{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
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
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{Helpers::getInitiatorName($data->initiator_id)}}</td>
                        <th class="w-20">Date of Initiation</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->created_at) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20"></th>

                        <th class="w-20">Division Id</th>
                        <td class="w-30">
                            @if ($data->division_id)
                            {{ Helpers::getDivisionName(session()->get('division')) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">(Parent) OOS No.</th>
                        <td class="w-30">
                            @if ($data->parent_oos_no)
                                {{ Helpers::getInitiatorName($data->parent_oos_no) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">(Parent) OOT No.</th>
                        <td class="w-30">
                            @if ($data->division_id)
                                {{ $data->division_id }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">(Parent) Date Opened</th>
                        <td class="w-30">
                            @if ($data->parent_date_opened)
                            {{ Helpers::getdateFormat($data->parent_date_opened) }}
                            @else
                                Not Applicable
                            @endif

                        </td>
                        <th class="w-20">(Parent) Short Desecription </th>
                        <td class="w-30">
                            @if ($data->parent_short_desecription)
                            {{ $data->parent_short_desecription }}
                        @else
                            Not Applicable
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">(Parent) Target Closure Date</th>
                        <td class="w-30">
                            @if ($data->target_closure_date)
                            {{ Helpers::getdateFormat($data->target_closure_date) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">(Parent) Product/Material Name</th>
                        <td class="w-30">
                            @if ($data->parent_product_material_name)
                                {{ $data->parent_product_material_name }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Date of Initiation</th>
                        <td class="w-30">
                            @if ($data->date_of_initiation)
                                {{ $data->date_of_initiation }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Assignee</th>
                        <td class="w-30">
                            @if ($data->assignee)
                            {{ $data->assignee }}
                        @else
                            Not Applicable
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">

                            AQA Approver</th>
                        <td class="w-30">
                            @if ($data->aqa_approver)
                                {{ $data->aqa_approver }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Supervisor</th>
                        <td class="w-30">
                            @if ($data->supervisor)
                            {{ $data->supervisor }}
                        @else
                            Not Applicable
                        @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">

                            Due Date</th>
                        <td class="w-30">
                            @if ($data->due_date)
                            {{ Helpers::getdateFormat($data->due_date) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Recommended Action</th>
                        <td class="w-30">
                            @if ($data->recommended_action)
                            {{ $data->recommended_action }}
                        @else
                            Not Applicable
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">

                            AQA Approver</th>
                        <td class="w-30">
                            @if ($data->aqa_approver)
                                {{ $data->aqa_approver }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Justify-Recommended Actions</th>
                        <td class="w-30">
                            @if ($data->aqa_review_attachment)
                            {{ $data->aqa_review_attachment }}
                        @else
                            Not Applicable
                        @endif
                        </td>
                    </tr>
                        </table>
                        <div class="border-table">
                            <div class="block-head">
                                File Attechment
                            </div>
                            <table>

                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-100">Batch No</th>
                                </tr>
                                @if ($data->inv_attachment)
                                    @foreach (json_decode($data->inv_attachment) as $key => $file)
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
        <table
                        <th class="w-20">

                            AQA Review Comments</th>
                        <td class="w-30">
                            @if ($data->aqa_review_comments)
                                {{ $data->aqa_review_comments }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
    <div class="inner-block">
        <div class="content-table">
            <div class="block">
                <div class="block-head">
                    AQA Comments
                </div>
                <table>
                    <tr>
                        <th class="w-20">

                            AQA Review Comments</th>
                        <td class="w-30">
                            @if ($data->aqa_review_comments)
                                {{ $data->aqa_review_comments }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>

                {{-- <div class="border-table">
                    <div class="block-head">
                        AQA Review Attachment
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-100">Batch No</th>
                        </tr>
                        @if ($data->aqa_review_comments)
                            @foreach (json_decode($data->aqa_review_comments) as $key => $file)
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
                </div> --}}
                <div class="border-table">
                    <div class="block-head">
                        AQA Review Attachment
                    </div>
                    <table>
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-100">Batch No</th>
                        </tr>
                        @if ($data->file_attchment_if_any1)
                            @foreach (json_decode($data->file_attchment_if_any1) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-100">
                                        <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                            <b>{{ $file }}</b>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="w-20">1</td>
                                <td class="w-100">Not Applicable</td>
                            </tr>
                        @endif
                    </table>
                </div>

                        </div>
        </div>


        <div class="inner-block">
            <div class="content-table">
                <div class="block">
                    <div class="block-head">
                        Review Comment
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">

                                Review Comments</th>
                            <td class="w-30">
                                @if ($data->aqa_review_comments)
                                    {{ $data->aqa_review_comments }}
                                @else
                                    Not Applicable
                                @endif
                            </td>



                        </tr>
                    </table>
                    <div class="border-table">
                        <div class="block-head">
                            File Attechment
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-100">Batch No</th>
                            </tr>
                            @if ($data->file_attchment_if1)
                                @foreach (json_decode($data->file_attchment_if1) as $key => $file)
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
                    <div class="head">
                    <div class="block-head">
                        Action Execution Comments

                    </div>
                    <table>
                    <tr>
                        <th class="w-20">

                            AQA Approver</th>
                        <td class="w-30">
                            @if ($data->aqa_approver)
                                {{ $data->aqa_approver }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Summary of Rec.Actions</th>
                        <td class="w-30">
                            @if ($data->summary_of_recommended_actions)
                            {{ $data->summary_of_recommended_actions }}
                        @else
                            Not Applicable
                        @endif
                        </td>
                    </tr>
                    <>
                        <th class="w-20">

                            Results & Conclusion</th>
                        <td class="w-30">
                            @if ($data->results_conclusion)
                                {{ $data->results_conclusion }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    <tr>
                        <th class="w-20">

                            Delay Justification</th>
                        <td class="w-30">
                            @if ($data->delay_justification)
                                {{ $data->delay_justification }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Review Comments</th>
                        <td class="w-30">
                            @if ($data->review_comments)
                            {{ $data->review_comments }}
                        @else
                            Not Applicable
                        @endif
                        </td>
                    </tr>

                    {{-- <tr>  --}}

{{-- </tr> --}}
        </table>
        <div class="border-table">
            <div class="block-head">
                Execution Attachment
            </div>
            <table>

                <tr class="table_bg">
                    <th class="w-20">S.N.</th>
                    <th class="w-100">Batch No</th>
                </tr>
                @if ($data->execution_attchment_if_any)
                    @foreach (json_decode($data->execution_attchment_if_any) as $key => $file)
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

    <div class="inner-block">
        <div class="content-table">
            <div class="block">
                <div class="block-head">
                    Activity log
                </div>
                <table>
                    <tr>
                        <th class="w-20">Submit By</th>

                        <td class="w-30">{{ $data->cancellation_request_by }}</td>
                        <th class="w-20">Submit On</th>
                        <td class="w-30">{{ $data->cancellation_request_on }}</td>
                    </tr>

                    <tr>
                        <th class="w-20">Action Review by AQA Approver Complete Bybc</th>
                        <td class="w-30">{{ $data->approver_complete_by }}</td>
                        <th class="w-20">Action Review by AQA Approver Complete On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->approver_complete_on) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Action Execution Complete By</th>
                        <td class="w-30">{{ $data->action_execution_complete_by }}</td>
                        <th class="w-20">Action Execution Complete On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->action_execution_complete_on) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Recommendation Action Execution Review By</th>
                        <td class="w-30">{{ $data->action_execution_complete_by }}</td>
                        <th class="w-20">More Information Required On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->action_execution_complete_on) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">More Info from Rec Action Execution By</th>
                        <td class="w-30">{{ $data->more_info_by }}</td>
                        <th class="w-20">More Info from Rec Action Execution On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->more_info_on) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Action Execution Review Complete By
                        </th>
                        <td class="w-30">{{ $data->rec_action_execution_by }}</td>
                        <th class="w-20">Action Execution Review Complete By</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->rec_action_execution_on) }}</td>
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
