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
                    Product Recall Report
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
                    <strong>Product Recall No.</strong>
                </td>
                <td class="w-40">
                    {{  Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
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
                    Product Recall
                </div>
                <table>
                    <tr>
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-30"> Not Applicable</td>
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ Helpers::getInitiatorName($data->initiator_id) }}</td>
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Date of Initiation</th>
                        <td class="w-30">{{ $data->created_at ? $data->created_at->format('d-M-Y') : '' }} </td>

                        <th class="w-20">Due Date</th>
                        <td class="w-30">
                            @if ($data->due_date)
                                {{ $data->due_date }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Product</th>
                        <td class="w-30">
                            @if ($data->product_name)
                                {{ $data->product_name }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Short Description</th>
                        <td class="w-30">
                            @if ($data->short_description)
                                {{ strip_tags($data->short_description) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Recalled From</th>
                        <td class="w-30">
                            @if ($data->recalled_from)
                                {{ $data->recalled_from }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Priority Level</th>
                        <td class="w-30">
                            @if ($data->priority_level)
                                {{ $data->priority_level }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Recalled By</th>
                        <td class="w-30">
                            @if ($data->recalled_by)
                                {{ Helpers::getInitiatorName($data->recalled_by) }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Contact Person</th>
                        <td class="w-30">
                            @if ($data->contact_person)
                                {{ Helpers::getInitiatorName($data->contact_person) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Other Related Products</th>
                        <td class="w-30">
                            @if ($data->related_product)
                                {{ $data->related_product }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Recall Reason</th>
                        <td class="w-30">
                            @if ($data->recall_reason)
                                {{ $data->recall_reason }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Schedule Start Date</th>
                        <td class="w-30">
                            @if ($data->schedule_start_date)
                                {{ Helpers::getdateFormat($data->schedule_start_date) }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Schedule End Date</th>
                        <td class="w-30">
                            @if ($data->schedule_end_date)
                                {{ Helpers::getdateFormat($data->schedule_end_date) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Department</th>
                        <td class="w-30">
                            @if ($data->department_code)
                                {{ $data->department_code }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        @php 
                            $getRecall = DB::table('product_recalls')->where(['id' => $data->id])->first();
                            $userIds = explode(',', $getRecall->team_members);
                            $userName =  DB::table('users')->whereIn('id', $userIds)->get();
                            $userNames = $userName->pluck('name')->implode(', ');
                        @endphp
                        <th class="w-20">Team Members</th>
                        <td class="w-30">
                            @if ($data->team_members)
                                {{ $userNames }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Bussiness Area</th>
                        <td class="w-30">
                            @if ($data->bussiness_area)
                                {{ $data->bussiness_area }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Estimated Man-Hours</th>
                        <td class="w-30">
                            @if ($data->estimate_man_hours)
                                {{ $data->estimate_man_hours }}
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
                            @if ($data->reference_record)
                                {{ $data->reference_record }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Attachment</th>
                        <td class="w-30">
                            @if ($data->Attachment)
                                @foreach (json_decode($data->Attachment) as $key => $file)
                                    <tr>
                                        <td class="w-20"><a href="{{ asset('upload/' . $file) }}"
                                                target="_blank"><b>{{ $file }}</b></a> </td>
                                    </tr>
                                @endforeach
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">Comments</th>
                        <td class="w-30">
                            @if ($data->comments)
                                {{ strip_tags($data->comments) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                </table>
            </div>


            <div class="block">
                <div class="block-head">
                    Notification Information
                </div>
                <table>
                    <tr>
                        <th class="w-20">Franchise Store Manager</th>
                        <td class="w-30">
                            @if ($data->franchise_store_manager)
                                {{ $data->franchise_store_manager }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">Warehouse Manager</th>
                        <td class="w-30">
                            @if ($data->warehouse_manager)
                                {{ $data->warehouse_manager }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th class="w-20">ENA Store Manager</th>
                        <td class="w-30">
                            @if ($data->ena_store_manager)
                                {{ $data->ena_store_manager }}
                            @else
                                Not Applicable
                            @endif
                        </td>

                        <th class="w-20">AB Store Manager</th>
                        <td class="w-30">
                            @if ($data->ena_store_manager)
                                {{ $data->ena_store_manager }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
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
