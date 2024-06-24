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
                    Lab Test Single Report
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
                    <strong>Lab Test No.</strong>
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
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ $data->originator }}</td>
                        <th class="w-20">Date Opened</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->created_at) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Product</th>
                        <td class="w-30">
                            @if ($data->product)
                                {{ $data->division_code }}
                            @else
                                Not Applicable
                            @endif
                        </td>
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
                        <th class="w-20">Type of Product</th>
                        <td class="w-0">@if($data->type_of_product){{ $data->type_of_product }}@else Not Applicable @endif</td>
                        <th class="w-20">Internal Product Test Info</th>
                        <td class="w-30">
                            @if ($data->internal_product_test_info)
                                {{ $data->internal_product_test_info }}
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
                        <th class="w-20">Record Number</th>
                        <td class="w-30">@if($data->record){{  str_pad($data->record, 4, '0', STR_PAD_LEFT) }} @else Not Applicable @endif</td>

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
                        <th class="w-20">Date Due</th>
                        <td class="w-30" colspan="3">
                            @if ($data->due_date)
                                {{ $data->due_date }}
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
                        <th class="w-20">Internal Test Conclusion</th>
                        <td class="w-30">
                            @if ($data->internal_test_conclusion)
                                {{ $data->internal_test_conclusion }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <tr>
                            <th class="w-20">Action Summary</th>
                            <td class="w-30">
                                @if ($data->action_summary)
                                    {{ $data->action_summary }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Lab Test Summary</th>
                            <td class="w-30">
                                @if ($data->lab_test_summary)
                                    {{ $data->lab_test_summary }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Related URLs</th>
                            <td class="w-30">
                                @if ($data->related_urls)
                                    {{ $data->related_urls }}
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
                            <th class="w-20">Reviewer Comments</th>
                            <td class="w-30">
                                @if ($data->reviewer_comments)
                                    {{ $data->reviewer_comments }}
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
                        <th class="w-20">Completed on</th>
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
                        <th class="w-20"> Complete by</th>
                        <td class="w-30">{{ $data->completed_by }}</td>
                        <th class="w-20"> Complete on</th>
                        <td class="w-30">{{ $data->completed_on }}</td>
                        <th class="w-20">Comment</th>
                        <td class="w-30">{{ $data->comment }}</td>

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
