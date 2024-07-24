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
        font-family: 'Roboto', 'sans-serif';
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
        height: auto;
        resize: none;
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

    .bold-small {
        font-weight: bold;
        font-size: 14px;
        /* Adjust the size as needed */
    }
</style>


<body>

    <header>
        <table>
            <tr>
                <td class="w-70 head">
                    Client Inquiry Single Report
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
                    <strong>Client Inquiry No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::divisionNameForQMS($data->division_id) }}/CI/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
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
                <td class="w-30">
                    <strong>Page :</strong> 1 of 1
                </td>
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
                    <tr> {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">Originator</th>
                        <td class="w-30">{{ Auth::user()->name }}</td>
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-30"> {{ Helpers::getDivisionName(session()->get('division')) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Date Opened</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->created_at) }}</td>
                        <th class="w-20">Assigned To</th>
                        <td class="w-30">
                            @if ($data->assigned_to)
                                {{ $data->assigned_to }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Short Description</th>
                        <td class="w-80" colspan="3">
                            @if ($data->short_description)
                                {{ $data->short_description }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Due Date</th>
                        <td class="w-30">
                            @if ($data->due_date)
                                {{ \Carbon\Carbon::parse($data->due_date)->format('d-M-Y') }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Customer Name</th>
                        <td class="w-30">
                            @if ($data->Customer_Name)
                                {{ $data->Customer_Name }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Submitted By</th>
                        <td class="w-30">
                            @if ($data->Submitted_By)
                                {{ $data->Submitted_By }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        {{-- <th class="w-20">Description</th>
                        <td class="w-40 description-cell" colspan="3">
                            @if ($data->Description)
                                {{ $data->Description }}
                            @else
                                Not Applicable
                            @endif
                        </td> --}}
                    </tr>
                </table>
                <div class="inner-block">
                    <label class="Summer" style="font-weight: bold; font-size: 14px;">Description</label>
                    <div style="font-size: 0.9rem">
                        @if ($data->Description)
                            {{ $data->Description }}
                        @else
                            Not Applicable
                        @endif
                    </div>
                </div>
                {{--  <tr>
                        <th class="w-20">Supporting Documents</th>
                        <td class="w-80" colspan="3">Document_Name.pdf</td>
                    </tr>  --}}
                <table>
                    <tr>
                        <th class="w-20">Zone</th>
                        <td class="w-30">
                            @if ($data->zone)
                                {{ $data->zone }}
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
                        <th class="w-20">City</th>
                        <td class="w-30">
                            @if ($data->city)
                                {{ $data->city }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">State/District</th>
                        <td class="w-30">
                            @if ($data->state)
                                {{ $data->state }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Type</th>
                        <td class="w-30">
                            @if ($data->type)
                                {{ $data->type }}
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
                    </tr>
                    <tr>
                        <th class="w-20">File Attachment</th>
                        <td class="w-30">
                            @if ($data->file_Attachment)
                                {{ $data->file_Attachment }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Related URLs</th>
                        <td class="w-30">
                            @if ($data->Related_URLs)
                                {{ $data->Related_URLs }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Product Details
                    </div>

                    <table>
                        <tr>
                            <th class="w-20">Product Type</th>
                            <td class="w-30">
                                @if ($data->Product_Type)
                                    {{ $data->Product_Type }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Manufacturer</th>
                            <td class="w-30">
                                @if ($data->Manufacturer)
                                    {{ $data->Manufacturer }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Inquiry Details
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Supervisor</th>
                            <td class="w-30">
                                @if ($data->Supervisor)
                                    {{ $data->Supervisor }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Inquiry Date</th>
                            <td class="w-30">
                                @if ($data->Inquiry_ate)
                                    {{ \Carbon\Carbon::parse($data->Inquiry_ate)->format('d-M-Y') }}
                                @else
                                    Not Applicable
                                @endif
                            </td>

                        </tr>
                        <tr>
                            <th class="w-20">
                                Inquiry Source</th>
                            <td class="w-30">
                                @if ($data->Inquiry_Source)
                                    {{ $data->Inquiry_Source }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Inquiry Method</th>
                            <td class="w-30">
                                @if ($data->Inquiry_method)
                                    {{ $data->Inquiry_method }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Branch</th>
                            <td class="w-30">
                                @if ($data->branch)
                                    {{ $data->branch }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Branch Manager</th>
                            <td class="w-30">
                                @if ($data->Branch_manager)
                                    {{ $data->Branch_manager }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Customer Name</th>
                            <td class="w-30">
                                @if ($data->Customer_names)
                                    {{ $data->Customer_names }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Business Area</th>
                            <td class="w-30">
                                @if ($data->Business_area)
                                    {{ $data->Business_area }}
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
                            <th class="w-20">Account Number</th>
                            <td class="w-30">
                                @if ($data->account_number)
                                    {{ $data->account_number }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Dispute Amount</th>
                            <td class="w-30">
                                @if ($data->dispute_amount)
                                    {{ $data->dispute_amount }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Currency</th>
                            <td class="w-30">
                                @if ($data->currency)
                                    {{ $data->currency }}
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
                            <th class="w-20">Sub Category</th>
                            <td class="w-30">
                                @if ($data->sub_category)
                                    {{ $data->sub_category }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                        </tr>
                    </table>
                    {{-- <tr>
                            <th class="w-20">Allegation language</th>
                            <td class="w-30">
                                @if ($data->allegation_language)
                                    {{ $data->allegation_language }}
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
                        </tr> --}}
                    <div class="inner-block">
                        <label class="Summer" style="font-weight: bold; font-size: 14px;">Allegation language</label>
                        <div style="font-size: 0.9rem">
                            @if ($data->allegation_language)
                                {{ $data->allegation_language }}
                            @else
                                Not Applicable
                            @endif
                        </div>
                    </div>
                    <div class="inner-block">
                        <label class="Summer" style="font-weight: bold; font-size: 14px;">Action Taken</label>
                        <div style="font-size: 0.9rem">
                            @if ($data->action_taken)
                                {{ $data->action_taken }}
                            @else
                                Not Applicable
                            @endif
                        </div>
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Broker Id</th>
                            <td class="w-30">
                                @if ($data->broker_id)
                                    {{ $data->broker_id }}
                                @else
                                    Not Applicable
                                @endif
                            </td>
                            <th class="w-20">Related Inquiries</th>
                            <td class="w-30">
                                @if ($data->related_inquiries)
                                    {{ $data->related_inquiries }}
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
                    Problem Details
                </div>
                <table>
                    <tr>
                        <th class="w-20">Problem Name</th>
                        <td class="w-30">
                            @if ($data->problem_name)
                                {{ $data->problem_name }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Problem Type</th>
                        <td class="w-30">
                            @if ($data->problem_type)
                                {{ $data->problem_type }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Problem Code</th>
                        <td class="w-30">
                            @if ($data->problem_code)
                                {{ $data->problem_code }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        {{-- <th class="w-20">Comments</th>
                        <td class="w-30">
                            @if ($data->comments)
                                {{ $data->comments }}
                            @else
                                Not Applicable
                            @endif
                        </td> --}}
                    </tr>
                </table>
                <div class="inner-block">
                    <label class="Summer" style="font-weight: bold; font-size: 14px;">Comments</label>
                    <div style="font-size: 0.9rem">
                        @if ($data->comments)
                            {{ $data->comments }}
                        @else
                            Not Applicable
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="block">
            <div class="block-head">
                Activity Log
            </div>
            <table>
                <tr>
                    <th class="w-20">Submited By</th>
                    <td class="w-30">{{ $data->Submitted_By }}</td>
                    <th class="w-20">Submited On</th>
                    <td class="w-30">{{ $data->submitted_on }}</td>
                </tr>
                <tr>
                    <th class="w-20">Comment</th>
                    <td class="w-30">{{ $data->Submited_Comment }}</td>
                </tr>
                <tr>
                    <th class="w-20">Cancel By</th>
                    <td class="w-30">{{ $data->cancel_by }}</td>
                    <th class="w-20">Cancel On</th>
                    <td class="w-30">{{ $data->cancel_on }}</td>
                </tr>
                <tr>
                    <th class="w-20">Comment</th>
                    <td class="w-30">{{ $data->cancel_Comment }}</td>
                </tr>
                <tr>
                    <th class="w-20">Simple Resolution by</th>
                    <td class="w-30">{{ $data->resolution_progress_completed_by }}</td>
                    <th class="w-20">Simple Resolution On</th>
                    <td class="w-30">{{ $data->resolution_progress_completed_on }}</td>
                </tr>
                <tr>
                    <th class="w-20">Comment</th>
                    <td class="w-30">{{ $data->simple_resol_omment }}</td>
                </tr>
                <tr>
                    <th class="w-20">Legal Issue Relations/Operational Issue by</th>
                    <td class="w-30">{{ $data->resolution_in_progress_completed_by }}</td>
                    <th class="w-20">Legal Issue Relations/Operational Issue On</th>
                    <td class="w-30">{{ $data->resolution_in_progress_completed_on }}</td>
                </tr>
                <tr>
                    <th class="w-20">Comment</th>
                    <td class="w-30">{{ $data->resolution_progress_Comment }}</td>
                </tr>
                <tr>
                    <th class="w-20">Relations/Operational Issue by
                    </th>
                    <td class="w-30">{{ $data->work_in_progress_completed_by }}</td>
                    <th class="w-20">Relations/Operational Issue by On</th>
                    <td class="w-30">{{ $data->work_in_progress_completed_on }}</td>
                </tr>
                <tr>
                    <th class="w-20">Comment</th>
                    <td class="w-30">{{ $data->work_in_progress_Comment }}</td>
                </tr>
                <tr>
                    <th class="w-20">Completed By</th>
                    <td class="w-30">{{ $data->cash_review_completed_by }}</td>
                    <th class="w-20">Completed On</th>
                    <td class="w-30">{{ $data->cash_review_completed_on }}</td>
                </tr>
                <tr>
                    <th class="w-20">Comment</th>
                    <td class="w-30">{{ $data->completed_Comment }}</td>
                </tr>
                <tr>
                    <th class="w-20">Resolution by</th>
                    <td class="w-30">{{ $data->root_cause_completed_by }}</td>
                    <th class="w-20">Resolution On</th>
                    <td class="w-30">{{ $data->root_cause_completed_on }}</td>
                </tr>
                <tr>
                    <th class="w-20">Comment</th>
                    <td class="w-30">{{ $data->resolution_Comment }}</td>
                </tr>
                <tr>
                    <th class="w-20">Resolution By</th>
                    <td class="w-30">{{ $data->root_cause_analysis_completed_by }}</td>
                    <th class="w-20">
                        Resolution On</th>
                    <td class="w-30">{{ $data->root_cause_analysis_completed_on }}</td>
                </tr>
                <tr>
                    <th class="w-20">Comment</th>
                    <td class="w-30">{{ $data->resol_Comment }}</td>
                </tr>
                <tr>
                    <th class="w-20">No Analysis Required By</th>
                    <td class="w-30">{{ $data->pending_approval_completed_by }}</td>
                    <th class="w-20">No Analysis Required On</th>
                    <td class="w-30">{{ $data->pending_approval_completed_on }}</td>
                </tr>
                <tr>
                    <th class="w-20">Comment</th>
                    <td class="w-30">{{ $data->no_analysis_Comment }}</td>
                </tr>
                <tr>
                    <th class="w-20">Analysis Complete By</th>
                    <td class="w-30">{{ $data->pending_preventing_action_completed_by }}</td>
                    <th class="w-20">Analysis Complete On</th>
                    <td class="w-30">{{ $data->pending_preventing_action_completed_on }}</td>
                </tr>
                <tr>
                    <th class="w-20">Comment</th>
                    <td class="w-30">{{ $data->analysis_Comment }}</td>
                </tr>
                <tr>
                    <th class="w-20">Pending Action Completion By</th>
                    <td class="w-30">{{ $data->pending_approval_completed_by }}</td>
                    <th class="w-20">Pending Action Completion On</th>
                    <td class="w-30">{{ $data->pending_approval_completed_on }}</td>
                </tr>
                <tr>
                    <th class="w-20">Comment</th>
                    <td class="w-30">{{ $data->pending_approval_Comment }}</td>
                </tr>
                <tr>
                    <th class="w-20">Reject By
                    </th>
                    <td class="w-30">{{ $data->rejected_by }}</td>
                    <th class="w-20">
                        Reject On</th>
                    <td class="w-30">{{ $data->rejected_on }}</td>
                </tr>
                <tr>
                    <th class="w-20">Comment</th>
                    <td class="w-30">{{ $data->reject_Comment }}</td>
                </tr>
                <tr>
                    <th class="w-20">Approve By</th>
                    <td class="w-30">{{ $data->approval_completed_by }}</td>
                    <th class="w-20">Approve On</th>
                    <td class="w-30">{{ $data->approval_completed_on }}</td>
                </tr>
                <tr>
                    <th class="w-20">Comment</th>
                    <td class="w-30">{{ $data->approve_Comment }}</td>
                </tr>
            </table>

        </div>
        <div class="block">
            <div class="border-table">
                <table>
                    <tr class="table_bg">
                        <th style="width: 5%;">Sr.No.</th>
                        <th>Question</th>
                        <th>Response</th>
                        <th>Remarks</th>
                    </tr>
                    @for ($i = 1; $i <= 5; $i++)
                        <tr>
                            <td>{{ $i }}</td>
                            <td class="w-20">
                                <textarea name="question_{{ $i }}">{{ $data->{'question_' . $i} ?? 'N/A' }}</textarea>
                            </td>
                            <td class="w-20">
                                <textarea name="response_{{ $i }}">{{ $data->{'response_' . $i} ?? 'N/A' }}</textarea>
                            </td>
                            <td class="w-20">
                                <textarea name="remark_{{ $i }}">{{ $data->{'remark_' . $i} ?? 'N/A' }}</textarea>
                            </td>
                        </tr>
                    @endfor
                </table>
            </div>
        </div>

        {{-- </table> --}}
        <div class="block">
            <div class="block-head">
                Product/Material(0) Part-1
            </div>
            <div class="border-table">
                <table style="margin-top: 20px">
                    <tr class="table_bg">
                        <th style="width: 5%">Row #</th>
                        <th>Product Name</th>
                        <th>Batch Number</th>
                        <th>Expiry Date</th>
                    </tr>
                    <?php if ($grid_Data && is_array($grid_Data->data)): ?>
                    <?php $index2 = 0; ?>
                    <?php foreach ($grid_Data->data as $data): ?>
                    <tr>
                        <td><?php echo $index2 + 1; ?></td>
                        <td><?php echo isset($data['Product_name']) ? $data['Product_name'] : 'N/A'; ?></td>
                        <td><?php echo isset($data['Batch_number']) ? $data['Batch_number'] : 'N/A'; ?></td>
                        <td><?php echo isset($data['Expiry_date']) ? $data['Expiry_date'] : 'N/A'; ?></td>
                    </tr>
                    <?php $index2++; ?>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="4">N/A</td>
                    </tr>
                    <?php endif; ?>

                </table>
            </div>
        </div>
        <div class="block">
            <div class="block-head">
                Product/Material(0) Part-2
            </div>
            <div class="border-table">
                <table style="margin-top: 20px">
                    <tr class="table_bg">
                        <th style="width: 5%">Row #</th>
                        <th>Manufactured Date</th>
                        <th>Disposition</th>
                        <th>Comment</th>
                    </tr>
                    <?php if ($grid_Data && is_array($grid_Data->data)): ?>
                    <?php $index2 = 0; ?>
                    <?php foreach ($grid_Data->data as $data): ?>
                    <tr>
                        <td><?php echo $index2 + 1; ?></td>
                        <td><?php echo isset($data['Manufactured_date']) ? $data['Manufactured_date'] : 'N/A'; ?></td>
                        <td><?php echo isset($data['disposition']) ? $data['disposition'] : 'N/A'; ?></td>
                        <td><?php echo isset($data['Comment']) ? $data['Comment'] : 'N/A'; ?></td>
                    </tr>
                    <?php $index2++; ?>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="4">N/A</td>
                    </tr>
                    <?php endif; ?>

                </table>
            </div>
        </div>
    </div>


    </div>



</body>

</html>
