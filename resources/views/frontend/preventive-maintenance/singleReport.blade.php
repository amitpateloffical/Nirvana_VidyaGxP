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
                Preventive Maintenance Single Report
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
                    <strong>Preventive Maintenance No.</strong>{{ Helpers::divisionNameForQMS($data->division_id) }}/{{ Helpers::year($data->created_at) }}/{{ $data->record_number ? str_pad($data->record_number, 4, '0', STR_PAD_LEFT) : '' }}
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
                <div class="block-head"> General Information </div>
                <table>
                   <tr>
                        <th class="w-20">Record Number</th>
                        <td class="w-30">@if($data->record_number){{  str_pad($data->record_number, 4, '0', STR_PAD_LEFT) }} @else Not Applicable @endif</td>
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-30">@if($data->division_code){{ $data->division_code }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>  {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ $data->originator }}</td>
                        <th class="w-20">Date of Initiation</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->created_at) }}</td>
                    </tr>
                    <tr>  {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">Division Code</th>
                        <td class="w-30">{{ Helpers::getDivisionName(session()->get('division')) }}</td>
                        <th class="w-20">Assigned To</th>
                        <td class="w-30">@if($data->assign_to){{ Helpers::getInitiatorName($data->assign_to) }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Due Date</th>
                        <td class="w-30">@if($data->due_date){{  str_pad($data->due_date, 4, '0', STR_PAD_LEFT) }} @else Not Applicable @endif</td>
                        <th class="w-20">Short Description</th>
                        <td class="w-80">@if($data->short_description){{ $data->short_description }}@else Not Applicable @endif</td>
                    </tr>
                    <tr><div class="block-head"> PM Details </div></tr>

                    <tr>
                        <th class="w-20">Additional Information</th>
                        <td class="w-30">{{ $data->additional_information }}</td>
                        <th class="w-20">Related URLs</th>
                        <td class="w-80">{{ $data->related_urls }}</td>
                    </tr>
                    <tr>
                       <th class="w-20">PM Frequency</th>
                        <td class="w-80">@if($data->PM_frequency){{ $data->PM_frequency }}@else Not Applicable @endif</td>
                        <th class="w-20">(Parent) Site Name </th>
                        <td class="w-80">@if($data->parent_site_name){{ $data->parent_site_name }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">(Parent) Building</th>
                        <td class="w-80">@if($data->parent_building){{ $data->parent_building }}@else Not Applicable @endif</td>
                        <th class="w-20">(Parent) Floor</th>
                        <td class="w-80">@if($data->parent_floor){{ $data->parent_floor }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">(Parent) Room</th>
                        <td class="w-80">@if($data->parent_room){{ $data->parent_room }}@else Not Applicable @endif</td>
                        <th class="w-20">Comments</th>
                        <td class="w-80">@if($data->comments){{ $data->comments }}@else Not Applicable @endif</td>
                    </tr>
                </table>
                <div class="block">
                <div class="block-head"> Action Plan </div>
                   <div class="border-table">
                    <table>
                        <tr class="table_bg">
                            <th style="width: 4%">Row#</th>
                            <th style="width: 8%">Action</th>
                            <th style="width: 10%">Responsible</th>
                            <th style="width: 10%">Deadline</th>
                            <th style="width: 12% pt-3">Item Status	</th>
                            <th style="width: 16% pt-2"> Remarks </th>
                        </tr>
                        {{-- @if($data->info_product_materials)
                        @foreach ($data->info_product_materials->data as $key => $datagridI)
                        <tr>
                            <td class="w-15">{{ $datagridI ? $key + 1  : "Not Applicable" }}</td>
                            <td class="w-15">{{ $datagridI['info_analyst_name'] ?  $datagridI['info_analyst_name']: "Not Applicable"}}</td>
                            <td class="w-15">{{ $datagridI['info_others_specify'] ?  $datagridI['info_others_specify']: "Not Applicable"}}</td>
                            <td class="w-15">{{ $datagridI['info_process_sample_stage'] ?  $datagridI['info_process_sample_stage']: "Not Applicable"}}</td>
                            <td class="w-15">{{ $datagridI['info_packing_material_type'] ?  $datagridI['info_packing_material_type']: "Not Applicable"}}</td>
                            <td class="w-15">{{ $datagridI['info_stability_for'] ?  $datagridI['info_stability_for']: "Not Applicable"}}</td>
                         </tr>
                        @endforeach
                        @else --}}
                        <tr>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                        {{-- @endif --}}
                    </table>
                 </div>
                </div>
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
