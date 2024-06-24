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
    textarea {
        width: 100%;
        height: auto;
        border: none;
        resize: none;
        box-sizing: border-box;
        padding: 5px;
        margin: 0;

        font-family: 'Roboto', 'sans-sarif';
    }
</style>

<body>

    <header>
        <table>
            <tr>
                <td class="w-70 head">
                    Field Inquiry Single Report
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
                    <strong>Field Inquiry No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::divisionNameForQMS($data->division_id) }}/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record_number, 4, '0', STR_PAD_LEFT) }}
                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($data->record_number, 4, '0', STR_PAD_LEFT) }}
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
                        <td class="w-30">{{ $data->originator }}</td>
                        <th class="w-20">Date Opened</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->created_at) }}</td>
                    </tr>
                    <tr>

                        <th class="w-20">Submitted By</th>
                        <td class="w-0">@if($data->submitted_by){{ $data->submitted_by }}@else Not Applicable @endif</td>


                        <th class="w-20">Assigned To</th>
                        <td class="w-30">
                            @if ($data->assigned_to)
                                {{ Helpers::getInitiatorName($data->assigned_to) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Customer Name</th>
                        <td class="w-0">@if($data->customer_name){{ $data->customer_name }}@else Not Applicable @endif</td>

                        <th class="w-20">Comments</th>
                        <td class="w-30">
                            @if ($data->comments)
                                {{ $data->comments }}
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
                        <th class="w-20">Record Number</th>
                        <td class="w-30">@if($data->record_number){{  str_pad($data->record_number, 4, '0', STR_PAD_LEFT) }} @else Not Applicable @endif</td>

                    </tr>
                    <tr>

                        <th class="w-20">Short Description</th>
                        <td class="w-30" colspan="3">
                            @if ($data->short_description)
                                {{ $data->short_description }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                    </tr>
                    <tr>
                        <th class="w-20">Zone</th>
                        <td class="w-30" >
                            @if ($data->zone_type)
                                {{ $data->zone_type}}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Date Due</th>
                        <td class="w-30">
                            @if ($data->due_date)
                                {{ $data->due_date}}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Priority Level</th>
                        <td class="w-30">
                            @if ($data->priority_level)
                                {{ $data->priority_level }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Type</th>
                        <td class="w-30">
                            @if ($data->type)
                                {{ $data->type }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <tr>
                            <th class="w-20">Related URLs</th>
                           <td class="w-30" >
                            @if ($data->related_urls)
                                {{ $data->related_urls}}
                            @else
                                Not Applicable
                            @endif
                        </td>

                            <th class="w-20">Country</th>
                            <td class="w-30">
                                @if ($data->country)
                                    {{ $data->country }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Related Inquiries</th>
                            <td class="w-30">
                                @if ($data->related_inquiries)
                                    {{ $data->related_inquiries }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                            <th class="w-20">City</th>
                            <td class="w-30">
                                @if ($data->city)
                                    {{ $data->city }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">State</th>
                            <td class="w-30">
                                @if ($data->state)
                                    {{ $data->state }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                            <th class="w-20">Devision code</th>
                            <td class="w-30">
                                @if ($data->division_code)
                                    {{ $data->division_code }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="w-20">Account Type</th>
                            <td class="w-30">
                                @if ($data->account_type)
                                    {{ $data->account_type }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                            <th class="w-20">Business Area</th>
                            <td class="w-30">
                                @if ($data->business_area)
                                    {{ $data->business_area }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>


                        <tr>
                            <th class="w-20">Category</th>
                            <td class="w-30">
                                @if ($data->category)
                                    {{ $data->category }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                            <th class="w-20">Sub- Category</th>
                            <td class="w-30">
                                @if ($data->sub_category)
                                    {{ $data->sub_category }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>


                        <tr>
                            <th class="w-20">Broker Id</th>
                            <td class="w-30">
                                @if ($data->broker_id)
                                    {{ $data->broker_id }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                            <th class="w-20">Action Taken</th>
                            <td class="w-30">
                                @if ($data->action_taken)
                                    {{ $data->action_taken }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </tr>

                </table>
            </div>

            <div class="block">
                <div class="head">

                    <table>

                        <tr>
                            <th class="w-20">Attached File</th>
                            <td class="w-30">
                                @if ($data->file_attachment)
                                    <a href="{{ asset('upload/document/', $data->file_attachment) }}">
                                        {{ $data->file_attachment }}</a>
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
                    Activity Log
                </div>
                <table>
                    <tr>
                        <th class="w-20">Completed By</th>
                        <td class="w-30">{{ $data->completed_by }}</td>
                        <th class="w-20">Completed On</th>
                        <td class="w-30">{{ $data->completed_on }}</td>
                        <th class="w-20">Comment</th>
                        <td class="w-30">{{ $data->comment }}</td>
                    </tr>


                    <tr>
                        <th class="w-20">Cancel on</th>
                        <td class="w-30">{{ $data->cancel_on }}</td>
                        <th class="w-20">Cancel By</th>
                        <td class="w-30">{{ $data->cancel_by }}</td>
                        <th class="w-20">Comment</th>
                        <td class="w-30">{{ $data->comment }}</td>

                    </tr>
                    <tr>
                        <th class="w-20">Begin Reviewed by</th>
                        <td class="w-30">{{ $data->begin_reviewed_by }}</td>
                        <th class="w-20">Begin Reviewed on</th>
                        <td class="w-30">{{ $data->begin_reviewed_by }}</td>
                        <th class="w-20">Comment</th>
                        <td class="w-30">{{ $data->reviewd_comment }}</td>

                    </tr>


                </table>
            </div>
            <div class="border-table">
                <table>
                    <tr class="table_bg">
                        <th style="width: 5%;">Sr.No.</th>
                        <th>Question</th>
                        <th>Response</th>
                        <th>Remarks</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td class="w-20">
                            <textarea name="question_1" value="">{{ $data->question_1 }}</textarea>
                        </td>
                        <td class="w-20">
                            <textarea name="response_1"value="">{{ $data->response_1 }}</textarea>
                        </td>
                        <td class="w-20">
                            <textarea name="remark_1"value="">{{ $data->remark_1 }}</textarea>
                        </td>

                    </tr>
                    <tr>
                        <td>2</td>
                        <td class="w-20">
                            <textarea name="question_2" value="">{{ $data->question_2 }}</textarea>
                        </td>
                        <td class="w-20">
                            <textarea name="response_2"value="">{{ $data->response_2 }}</textarea>
                        </td>
                        <td class="w-20">
                            <textarea name="remark_2"value="">{{ $data->remark_2 }}</textarea>
                        </td>

                    </tr>
                    <tr>
                        <td>3</td>
                        <td class="w-20">
                            <textarea name="question_3" value="">{{ $data->question_3 }}</textarea>
                        </td>
                        <td class="w-20">
                            <textarea name="response_3"value="">{{ $data->response_3 }}</textarea>
                        </td>
                        <td class="w-20">
                            <textarea name="remark_3">{{ $data->remark_3 }}</textarea>
                        </td>

                    </tr>
                    <tr>
                        <td>4</td>
                        <td class="w-20">
                            <textarea name="question_4" value="">{{ $data->question_4 }}</textarea>
                        </td>
                        <td class="w-20">
                            <textarea name="response_4">{{ $data->response_4 }}</textarea>
                        </td>
                        <td class="w-20">
                            <textarea name="remark_4">{{ $data->remark_4 }}</textarea>
                        </td>

                    </tr>
                    <tr>
                        <td>5</td>
                        <td class="w-20">
                            <textarea name="question_5" value="">{{ $data->question_5 }}</textarea>
                        </td>
                        <td class="w-20">
                            <textarea name="response_5">{{ $data->response_5 }}</textarea>
                        </td>
                        <td class="w-20">
                            <textarea name="remark_5">{{ $data->remark_5 }}</textarea>
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
                <td class="w-30">
                    <strong>Page :</strong> 1 of 1
                </td>
            </tr>
        </table>
    </footer>

</body>

</html>
