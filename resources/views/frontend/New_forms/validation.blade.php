@extends('frontend.layout.main')
@section('container')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.js"></script>
<style>
    textarea.note-codable {
        display: none !important;
    }

    header {
        display: none;
    }
</style>

<script>
    $(document).ready(function() {
        // Calculate the due date 30 days from the initiation date
        function calculateDueDate(initiationDate) {
            let date = new Date(initiationDate);
            date.setDate(date.getDate() + 30);
            return date;
        }

        // Format date to DD-MMM-YYYY
        function formatDateToDisplay(date) {
            const options = {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            };
            return date.toLocaleDateString('en-GB', options).replace(/ /g, '-');
        }

        // Format date to YYYY-MM-DD
        function formatDateToISO(date) {
            return date.toISOString().split('T')[0];
        }

        // Get the initiation date value
        let initiationDate = $('#intiation_date').val();
        let dueDate = calculateDueDate(initiationDate);

        // Set the due date in the appropriate fields
        $('#assign_due_date_display').val(formatDateToDisplay(dueDate));
        $('#assign_due_date').val(formatDateToISO(dueDate));
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to format a date to DD-MMM-YYYY
        function formatDate(date) {
            const options = {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            };
            return new Date(date).toLocaleDateString('en-GB', options).replace(/ /g, '-');
        }

        // Set the initiation date display
        const initiationDate = document.getElementById('initiation_date').value;
        const formattedInitiationDate = formatDate(initiationDate);
        document.getElementById('initiation_date_display').value = formattedInitiationDate;

        // Set a sample due date for demonstration (you can modify this as per your requirements)
        const dueDate = new Date(); // You can set this to any date you want
        dueDate.setDate(dueDate.getDate() + 30); // Example: setting due date 30 days from today
        const formattedDueDate = formatDate(dueDate.toISOString().split('T')[0]);
        document.getElementById('assign_due_date_display').value = formattedDueDate;
        document.getElementById('assign_due_date').value = dueDate.toISOString().split('T')[0];
    });
</script>

<!-- <script>
    $(document).ready(function() {
        // Calculate the due date 30 days from the initiation date
        function calculateDueDate(initiationDate) {
            let date = new Date(initiationDate);
            date.setDate(date.getDate() + 30);
            return date;
        }

        // Format date to DD-MMM-YYYY
        function formatDateToDisplay(date) {
            const options = { day: '2-digit', month: 'short', year: 'numeric' };
            return date.toLocaleDateString('en-GB', options).replace(/ /g, '-');
        }

        // Format date to YYYY-MM-DD
        function formatDateToISO(date) {
            return date.toISOString().split('T')[0];
        }

        // Get the initiation date value
        let initiationDate = $('#validation_due_date').val();
        let dueDate = calculateDueDate(initiationDate);

        // Set the due date in the appropriate fields
        $('#due_date').val(formatDateToDisplay(dueDate));
        $('#validation_due_date').val(formatDateToISO(dueDate));
    });
</script> -->

@php
$users = DB::table('users')->get();
@endphp
<div class="form-field-head">
    {{-- <div class="pr-id">
            New Child
        </div> --}}
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        {{ Helpers::getDivisionName(session()->get('division')) }} / Validation
    </div>
</div>



{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Validation Document</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Test Results</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Signatures</button>
        </div>

        <form action="{{ route('validation_store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div id="step-form">
                @if (!empty($parent_id))
                <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                @endif

                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="sub-head">General Information</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Site/Location Code</b></label>
                                    <input readonly type="text" name="divison_code" value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Originator"><b>Initiator</b></label>
                                    <input disabled type="text" name="validation" value="{{Auth::user()->name}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number">Record Number</label>
                                    <input disabled type="text" name="record" value="{{ Helpers::getDivisionName(session()->get('division')) }}/VALIDATION/{{ date('Y') }}/{{ $record_number }}">

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Date Of Initiation</b></label>
                                    <input disabled type="text" value="{{ date('d-M-Y') }}" id="initiation_date_display">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" id="intiation_date" name="intiation_date">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span></label><span id="rchars">255</span>
                                    characters remaining
                                    <input id="docname" type="text" name="short_description" maxlength="255" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assign_to">
                                        <option value="">Select a value</option>
                                        @foreach ($users as $key => $value)
                                        <option value="{{ $value->name }}">
                                            {{ $value->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('assigned_user_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 new-date-data-field">
                                <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date">Date Due <span class="text-danger"></span></label>
                                        <div>
                                            <small class="text-primary">If revising Due Date, kindly mention revision reason in "Due Date Extension Justification" data field.</small>
                                        </div>
                                        <div class="calenderauditee">
                                            {{-- <input type="text" id="assign_due_date_display" readonly placeholder="DD-MM-YYYY">
                                            <input type="hidden" name="assign_due_date" id="assign_due_date"> --}}

                                            <input type="hidden" value="{{$due_date}}" name="assign_due_date">
                                            <input disabled type="text" value="{{Helpers::getdateFormat($due_date)}}">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Validation Type</label>
                                    <select name="validation_type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="validation_due_date">Date Due <span class="text-danger"></span></label>
                                    <div><small class="text-primary">Please mention expected date of completion</small></div>
                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="validation_due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'due_date')" />

                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="notify_type">Notify When Approved?</label>
                                    <select name="notify_type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">yes</option>
                                        <option value="2">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="phase_type">Phase Level</label>
                                    <select name="phase_type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="sub-head">
                                Document Information
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Type">Document Reason</label>
                                    <select name="document_reason_type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="yes">yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Purpose</label>
                                    <textarea class="summernote" name="purpose" id="summernote-16"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Outcome">Validation Category</label>
                                    <select name="validation_category">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Patient_Involved">Validation Sub Category</label>
                                    <select name="validation_sub_category">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="closure attachment">Download Templates </label>
                                    <div><small class="text-primary">
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attechment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="file_attechment[]" oninput="addMultipleFiles(this, 'file_attechment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reference Recores"> Related Records</label>
                                    <select multiple id="reference_record" name="related_record" id="">
                                        <option value="">--Select---</option>
                                        <option value="Pankaj">Pankaj</option>
                                        <option value="Gourav">Gourav</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reporter">Document Link </label>
                                    <input type="text" name="document_link">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Tests Required</label>
                                    <select name="tests_required">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="Yes">yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Refrence Document</label>
                                    <select name="reference_document">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="Yes">yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reporter">Refrence Link </label>
                                    <input type="text" name="reference_link">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Additional Refrences</label>
                                    <textarea class="summernote" name="additional_references" id="summernote-16"></textarea>
                                </div>
                            </div>


                            <div class="sub-head">
                                Affected Items
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Affected Equipment(0)
                                    <button type="button" name="details" id="Affected_equipment_add">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        Open
                                    </span>
                                </label>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Details-table-equipment">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Equipment Name/Code</th>
                                                <th style="width: 16%">Equipment ID</th>
                                                <th style="width: 16%">Asset No</th>
                                                <th style="width: 16%">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input disabled type="text" name="details[0][serial]" value="1"></td>
                                                <td><input type="text" name="details[0][equipment_name_code]"></td>
                                                <td><input type="text" name="details[0][equipment_id]"></td>
                                                <td><input type="text" name="details[0][asset_no]"></td>
                                                <td><input type="text" name="details[0][remarks]"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Affected Item(0)
                                    <button type="button" name="affected_equipments" id="Affected_item_add">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        Open
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Details-table-item">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Item Type</th>
                                                <th style="width: 16%">Item Name</th>
                                                <th style="width: 16%">Item No</th>
                                                <th style="width: 16%"> Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input disabled type="text" name="affected_equipments[0][serial]" value="1"></td>
                                                <td><input type="text" name="affected_equipments[0][item_type]"></td>
                                                <td><input type="text" name="affected_equipments[0][item_name]"></td>
                                                <td><input type="text" name="affected_equipments[0][item_no]"></td>
                                                <td><input type="text" name="affected_equipments[0][item_remarks]"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    $('#Affected_equipment_add').click(function(e) {
                                        function generateEquipmentRow(serialNumber) {
                                            var html = '';
                                            html += '<tr>' +
                                                '<td><input disabled type="text" name="details[' + serialNumber + '][serial]" value="' + serialNumber + '"></td>' +
                                                '<td><input type="text" name="details[' + serialNumber + '][equipment_name_code]"></td>' +
                                                '<td><input type="text" name="details[' + serialNumber + '][equipment_id]"></td>' +
                                                '<td><input type="text" name="details[' + serialNumber + '][asset_no]"></td>' +
                                                '<td><input type="text" name="details[' + serialNumber + '][remarks]"></td>' +
                                                '</tr>';
                                            return html;
                                        }

                                        var tableBody = $('#Details-table-equipment tbody');
                                        var rowCount = tableBody.children('tr').length;
                                        var newRow = generateEquipmentRow(rowCount + 1);
                                        tableBody.append(newRow);
                                    });

                                    $('#Affected_item_add').click(function(e) {
                                        function generateItemRow(serialNumber) {
                                            var html = '';
                                            html += '<tr>' +
                                                '<td><input disabled type="text" name="affected_equipments[' + serialNumber + '][serial]" value="' + serialNumber + '"></td>' +
                                                '<td><input type="text" name="affected_equipments[' + serialNumber + '][item_type]"></td>' +
                                                '<td><input type="text" name="affected_equipments[' + serialNumber + '][item_name]"></td>' +
                                                '<td><input type="text" name="affected_equipments[' + serialNumber + '][item_no]"></td>' +
                                                '<td><input type="text" name="affected_equipments[' + serialNumber + '][item_remarks]"></td>' +
                                                '</tr>';
                                            return html;
                                        }

                                        var tableBody = $('#Details-table-item tbody');
                                        var rowCount = tableBody.children('tr').length;
                                        var newRow = generateItemRow(rowCount + 1);
                                        tableBody.append(newRow);
                                    });
                                });
                            </script>


                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Affected Facilities(0)
                                    <button type="button" name="affected_facilities" id="Affected_facilities_add">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        Open
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Details-table-facilities">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Facility-Location</th>
                                                <th style="width: 16%">Facility-Type</th>
                                                <th style="width: 16%">Facility-Name</th>
                                                <th style="width: 16%">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input disabled type="text" name="affected_facilities[0][serial]" value="1"></td>
                                            <td><input type="text" name="affected_facilities[0][facility_location]"></td>
                                            <td><input type="text" name="affected_facilities[0][facility_type]"></td>
                                            <td><input type="text" name="affected_facilities[0][facility_name]"></td>
                                            <td><input type="text" name="affected_facilities[0][facility_remarks]"></td>

                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    $('#Affected_facilities_add').click(function(e) {
                                        function generateTableRow(serialNumber) {
                                            var html = '';
                                            html += '<tr>' +
                                                '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                                                '"></td>' +
                                                '<td><input type="text" name="affected_facilities[' + serialNumber +
                                                '][facility_location]"></td>' +
                                                '<td><input type="text" name="affected_facilities[' + serialNumber + '][facility_type]"></td>' +
                                                '<td><input type="text" name="affected_facilities[' + serialNumber + '][facility_name]"></td>' +
                                                '<td><input type="text" name="affected_facilities[' + serialNumber + '][facility_remarks]"></td>' +
                                                // '<td><button type="text" class="removeRowBtn" >Remove</button></td>' +
                                                '</tr>';


                                            return html;
                                        }

                                        var tableBody = $('#Details-table-facilities tbody');
                                        var rowCount = tableBody.children('tr').length;
                                        var newRow = generateTableRow(rowCount + 1);
                                        tableBody.append(newRow);
                                    });
                                });
                            </script>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="closure attachment">Items Attachment </label>
                                    <div><small class="text-primary">
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="items_attachment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="items_attachment[]" oninput="addMultipleFiles(this, 'items_attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Additional Attachment Items</label>
                                    <textarea class="summernote" name="addition_attachment_items" id="summernote-16"></textarea>
                                </div>
                            </div>


                            <div class="sub-head">
                                Document Decision
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Type">Data Successfully Closed?</label>
                                    <select name="data_successfully_type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="Yes">yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Document Summary</label>
                                    <textarea class="summernote" name="documents_summary" id="summernote-16"></textarea>
                                </div>
                            </div>


                            <div class="sub-head">
                                Document Comments
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Document Comments</label>
                                    <textarea class="summernote" name="document_comments" id="summernote-16"></textarea>
                                </div>
                            </div>


                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                    Exit </a> </button>
                        </div>
                    </div>
                </div>

                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div>Test Information</div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Patient_Involved">Test Required?</label>
                                    <select name="test_required">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="date_of_birth">Test Start Date</label>
                                    <input type="date" name="test_start_date">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="date_of_birth">Test End Date</label>
                                    <input type="date" name="test_end_date">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="gender">Test Responsible</label>
                                    <select name="test_responsible">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="No">pankaj</option>
                                        <option value="Gourav">Gourav</option>
                                        <option value="Mayank">Mayank</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="closure attachment">Results Attachment </label>
                                    <div><small class="text-primary">
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="result_attachment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="result_attachment[]" oninput="addMultipleFiles(this, 'result_attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Summary Of Results(0)
                                    <button type="button" name="audit_agenda_grid" id="SummaryOfResults_add">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Open)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Details-table-agenda">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Deviation Occured</th>
                                                <th style="width: 16%">Test-Name</th>
                                                <th style="width: 16%">Test-Number</th>
                                                <th style="width: 16%">Test-Method</th>
                                                <th style="width: 15%">Test-Result</th>
                                                <th style="width: 15%">Test-Accepted</th>
                                                <th style="width: 15%">Remarks</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <td><input disabled type="text" name="audit_agenda_grid[0][serial]" value="1"></td>
                                            <td><input type="text" name="audit_agenda_grid[0][deviation_occured]"></td>
                                            <td><input type="text" name="audit_agenda_grid[0][test_name]"></td>
                                            <td><input type="text" name="audit_agenda_grid[0][test_number]"></td>
                                            <td><input type="text" name="audit_agenda_grid[0][test_method]"></td>
                                            <td><input type="text" name="audit_agenda_grid[0][test_result]"></td>
                                            <td><input type="text" name="audit_agenda_grid[0][test_accepted]"></td>
                                            <td><input type="text" name="audit_agenda_grid[0][remarks]"></td>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    $('#SummaryOfResults_add').click(function(e) {
                                        function generateTableRow(serialNumber) {
                                            var html = '';
                                            html += '<tr>' +
                                                '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                                                '"></td>' +
                                                '<td><input type="text" name="audit_agenda_grid[' + serialNumber +
                                                '][deviation_occured]"></td>' +
                                                '<td><input type="text" name="audit_agenda_grid[' + serialNumber + '][test_name]"></td>' +
                                                '<td><input type="text" name="audit_agenda_grid[' + serialNumber + '][test_number]"></td>' +
                                                '<td><input type="text" name="audit_agenda_grid[' + serialNumber + '][test_method]"></td>' +
                                                '<td><input type="text" name="audit_agenda_grid[' + serialNumber + '][test_result]"></td>' +
                                                '<td><input type="text" name="audit_agenda_grid[' + serialNumber + '][test_accepted]"></td>' +
                                                '<td><input type="text" name="audit_agenda_grid[' + serialNumber + '][remarks]"></td>' +
                                                // '<td><button type="text" class="removeRowBtn" >Remove</button></td>' +
                                                '</tr>';



                                            return html;
                                        }

                                        var tableBody = $('#Details-table-agenda tbody');
                                        var rowCount = tableBody.children('tr').length;
                                        var newRow = generateTableRow(rowCount + 1);
                                        tableBody.append(newRow);
                                    });
                                });
                            </script>



                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Test Actions & Comments</label>
                                    <textarea class="summernote" name="test_action" id="summernote-16"></textarea>
                                </div>
                            </div>

                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>
                </div>



                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">
                                Record Type History
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted_by">Submitted Protocol By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted_on">Submitted Protocol On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="cancelled_by">Cancelled By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled_on">Cancelled On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>

                            <div class="sub-head">Review</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="review_by">Review By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="review_on">Review On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>

                            <div class="sub-head">Final Approval</div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="approved_by">1st Final Approval By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="approved_on">1st Final Approval On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Plan_Approved_by2">2nd Final Approval By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Plan_Approved_on2">2nd Final Approval On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Report_by">Report Reject By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Report_on">Report Reject On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Obsolete_by">Obsolete By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Obsolete_on">Obsolete On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>

                            <div class="button-block">

                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                                    </a> </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

<style>
    #step-form>div {
        display: none
    }

    #step-form>div:nth-child(1) {
        display: block;
    }
</style>

<script>
    VirtualSelect.init({
        ele: '#related_records, #hod'
    });

    function openCity(evt, cityName) {
        var i, cctabcontent, cctablinks;
        cctabcontent = document.getElementsByClassName("cctabcontent");
        for (i = 0; i < cctabcontent.length; i++) {
            cctabcontent[i].style.display = "none";
        }
        cctablinks = document.getElementsByClassName("cctablinks");
        for (i = 0; i < cctablinks.length; i++) {
            cctablinks[i].className = cctablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";

        // Find the index of the clicked tab button
        const index = Array.from(cctablinks).findIndex(button => button === evt.currentTarget);

        // Update the currentStep to the index of the clicked tab
        currentStep = index;
    }

    const saveButtons = document.querySelectorAll(".saveButton");
    const nextButtons = document.querySelectorAll(".nextButton");
    const form = document.getElementById("step-form");
    const stepButtons = document.querySelectorAll(".cctablinks");
    const steps = document.querySelectorAll(".cctabcontent");
    let currentStep = 0;

    function nextStep() {
        // Check if there is a next step
        if (currentStep < steps.length - 1) {
            // Hide current step
            steps[currentStep].style.display = "none";

            // Show next step
            steps[currentStep + 1].style.display = "block";

            // Add active class to next button
            stepButtons[currentStep + 1].classList.add("active");

            // Remove active class from current button
            stepButtons[currentStep].classList.remove("active");

            // Update current step
            currentStep++;
        }
    }

    function previousStep() {
        // Check if there is a previous step
        if (currentStep > 0) {
            // Hide current step
            steps[currentStep].style.display = "none";

            // Show previous step
            steps[currentStep - 1].style.display = "block";

            // Add active class to previous button
            stepButtons[currentStep - 1].classList.add("active");

            // Remove active class from current button
            stepButtons[currentStep].classList.remove("active");

            // Update current step
            currentStep--;
        }
    }
</script>
<script>
    $(document).ready(function() {
        $('#Treatment_of_Adverse_Reaction').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '</tr>';

                return html;
            }

            var tableBody = $('#Treatment_of_Adverse_Reaction-instruction-modal tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>
<script>
    VirtualSelect.init({
        ele: '#reference_record, #notify_to'
    });

    $('#summernote').summernote({
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear', 'italic']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });

    $('.summernote').summernote({
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear', 'italic']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });

    let referenceCount = 1;

    function addReference() {
        referenceCount++;
        let newReference = document.createElement('div');
        newReference.classList.add('row', 'reference-data-' + referenceCount);
        newReference.innerHTML = `
            <div class="col-lg-6">
                <input type="text" name="reference-text">
            </div>
            <div class="col-lg-6">
                <input type="file" name="references" class="myclassname">
            </div><div class="col-lg-6">
                <input type="file" name="references" class="myclassname">
            </div>
        `;
        let referenceContainer = document.querySelector('.reference-data');
        referenceContainer.parentNode.insertBefore(newReference, referenceContainer.nextSibling);
    }
</script>
<script>
    $(document).ready(function() {
        $('#SummaryOfResults_add').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="DeviationOccured[]"></td>' +
                    '<td><input type="text" name="Test-Name[]"></td>' +
                    '<td><input type="text" name="Test-Number[]"></td>' +
                    '<td><input type="text" name="Test-Method[]"></td>' +
                    '<td><input type="text" name="Test-Result[]"></td>' +
                    '<td><input type="text" name="Test-Accepted[]"></td>' +
                    '<td><input type="text" name="Remarks[]"></td>' +

                    '</tr>';

                return html;
            }

            var tableBody = $('#SummaryOfResults_Table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>

<!-- <script>
    $(document).ready(function() {
        $('#Affected_equipment_add').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="EquipmentName/Code[]"></td>' +
                    '<td><input type="text" name="EquipmentID[]"></td>' +
                    '<td><input type="text" name="AssetNo[]"></td>' +
                    '<td><input type="text" name="Remarks[]"></td>' +

                    '</tr>';

                return html;
            }

            var tableBody = $('#Affected_equipment_Table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script> -->
<!-- 
<script>
    $(document).ready(function() {
        $('#Affected_item_add').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="ItemType[]"></td>' +
                    '<td><input type="text" name="ItemName[]"></td>' +
                    '<td><input type="text" name="ItemNo[]"></td>' +
                    '<td><input type="text" name="Remarks[]"></td>' +

                    '</tr>';

                return html;
            }

            var tableBody = $('#Affected_item_Table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script> -->
<!-- <script>
    $(document).ready(function() {
        $('#Affected_facilities_add').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="Facility-Location[]"></td>' +
                    '<td><input type="text" name="Facility-Type[]"></td>' +
                    '<td><input type="text" name="Facility-Name[]"></td>' +
                    '<td><input type="text" name="Remarks[]"></td>' +

                    '</tr>';

                return html;
            }

            var tableBody = $('#Affected_facilities_Table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script> -->

<script>
    var maxLength = 255;
    $('#docname').keyup(function() {
        var textlen = maxLength - $(this).val().length;
        $('#rchars').text(textlen);
    });
</script>
@endsection