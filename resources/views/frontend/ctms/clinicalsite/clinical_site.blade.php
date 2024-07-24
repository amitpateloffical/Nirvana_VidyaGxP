@extends('frontend.layout.main')
@section('container')
<style>
    textarea.note-codable {
        display: none !important;
    }

    header {
        display: none;
    }
</style>

<div class="form-field-head">
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        CTMS - clinical site
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#Drug_Accountability_Add').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="drugaccountability[serial]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="drugaccountability[ProductName]"></td>' +
                    '<td><input type="number" name="drugaccountability[BatchNumber]"></td>' +
                    '<td><input type="date" name="drugaccountability[ExpiryDate]"></td>' +
                    '<td><input type="text" name="drugaccountability[UnitsReceived]"></td>' +
                    '<td><input type="text" name="drugaccountability[UnitsDispensed]"></td>' +
                    '<td><input type="text" name="drugaccountability[UnitsDestroyed]"></td>' +
                    '<td><input type="date" name="drugaccountability[ManufacturedDate]"></td>' +
                    '<td><input type="text" name="drugaccountability[Strength]"></td>' +
                    '<td><input type="text" name="drugaccountability[Form]"></td>' +
                    '<td><input type="text" name="drugaccountability[Remarks]"></td>' +
                    '</tr>';
                return html;
            }

            var tableBody = $('#Drug_Accountability_Table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount);
            tableBody.append(newRow);
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#Equipment_Add').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="equipments[' + serialNumber + '][serial]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="equipments[' + serialNumber + '][Product_Name]"></td>' +
                    '<td><input type="number" name="equipments[' + serialNumber + '][Batch_Number]"></td>' +
                    '<td><input type="date" name="equipments[' + serialNumber + '][Expiry_Date]"></td>' +
                    '<td><input type="date" name="equipments[' + serialNumber + '][Manufactured_Date]"></td>' +
                    '<td><input type="number" name="equipments[' + serialNumber + '][Number_of_Items_Needed]"></td>' +
                    '<td><input type="text" name="equipments[' + serialNumber + '][Exist]"></td>' +
                    '<td><input type="text" name="equipments[' + serialNumber + '][Comment]"></td>' +
                    '<td><input type="text" name="equipments[' + serialNumber + '][Remarks]"></td>' +
                    '</tr>';
                return html;
            }

            var tableBody = $('#Equipment_Table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount);
            tableBody.append(newRow);
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('#Financial_Transactions_Add').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="financialTransactions[' + serialNumber + '][serial]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="financialTransactions[' + serialNumber + '][Transaction]"></td>' +
                    '<td><input type="text" name="financialTransactions[' + serialNumber + '][Transaction_Type]"></td>' +
                    '<td><input type="date" name="financialTransactions[' + serialNumber + '][Date]"></td>' +
                    '<td><input type="text" name="financialTransactions[' + serialNumber + '][Amount]"></td>' +
                    '<td><input type="text" name="financialTransactions[' + serialNumber + '][Currency_Used]"></td>' +
                    '<td><input type="text" name="financialTransactions[' + serialNumber + '][Remarks]"></td>' +
                    '</tr>';
                return html;
            }

            var tableBody = $('#Financial_Transactions_Table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount);
            tableBody.append(newRow);
        });
    });
</script>
@php
$users = DB::table('users')->get();
@endphp

{{-- ======================================
                    DATA FIELDS
    ======================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Clinical Site</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Site Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Useful Tools</button>
        </div>

        <!-- Tab content -->

        <form action="{{ route('clinicstore') }}" method="POST" enctype="multipart/form-data">
            @csrf   
        <div id="CCForm1" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="row">

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="RLS Record Number"><b>Record Number</b></label>
                            {{-- <input disabled type="text" name="record" value=""> --}}
                            <input disabled type="text" name="record" value=" {{ Helpers::getDivisionName(session()->get('division')) }}/CS/{{ date('y') }}/{{ $record}}">
                            {{-- <input disabled type="text" name="record" id="record" 
                            value=""> --}}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label disabled for="Short Description">Division Code<span class="text-danger"></span></label>
                            <input disabled type="text" name="division_code"
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                        </div>
                    </div>



                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="CTMS originator"><b>Initiator</b></label>
                            <input type="text" disabled name="initiator"  value="{{ Auth::user()->name }}">
                        </div>
                    </div>
                    {{-- <div class="col-md-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="opened-date">Date of Initiation<span class="text-danger"></span></label>
                            <div class="calenderauditee">
                                <input type="text" disabled id="opened_date" placeholder="DD-MMM-YYYY" />
                                <input type="date" disabled name="intiation_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'opened_date')" />
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-md-6 ">
                        <div class="group-input ">
                            <label for="due-date"> Date Of Initiation<span class="text-danger"></span></label>
                            <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                            <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                        </div>
                    </div> --}}
                    <div class="col-md-6 ">
                        <div class="group-input ">
                            <label for="due-date"> Date Of Initiation<span class="text-danger"></span></label>
                            <input disabled type="text" value="{{ date('d-M-Y') }}" name="initiation_date">
                            <input type="hidden" value="{{ date('Y-m-d') }}" name="initiation_date">
                        </div>
                    </div>
                   
                    {{-- <div class="col-12">
                        <div class="group-input">
                            <label for="Short Description">Short Description<span class="text-danger">*</span></label>
                            <div><small >255 characters remaining</small></div>
                            <input id="short-description" type="text" name="short_description" maxlength="255" required>
                        </div>
                    </div> --}}
                    <div class="col-md-12 mb-3">
                        <div class="group-input">
                            <label for="Short Description">Short Description<span
                                class="text-danger">*</span></label>
                                <span id="rchars">255</span>
                            <div><small class="text-primary">Please insert "NA" in the data field if it does
                                    not require completion</small></div>
                            <input  name="short_description" id="docname" maxlength="255" required >
                        
                        </div>
                    </div>
                    <script>
                        var maxLength = 255;
                        $('#docname').keyup(function() {
                            var textlen = maxLength - $(this).val().length;
                            $('#rchars').text(textlen);
                        });
                    </script>
                    {{-- <div class="col-md-6">
                        <div class="group-input">
                            <label for="assigned_to">
                                Assigned To <span class="text-danger"></span>
                            </label>
                            <div><small class="text-primary">Person Responsible</small></div>
                            <select id="select-state" placeholder="Select..." name="assign_to">
                                <option value="">Select a value</option>
                                <option value="$1">$1</option>
                                <option value="$1">$2</option>
                                <option value="$1">$3</option>
                            </select>
                        </div>
                    </div> --}}
                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="search">
                                Assigned To <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="assign_to">
                                <option value="">Select a value</option>
                                @foreach ($users as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                            @error('assign_to')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="col-md-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="due-date">Due Date <span class="text-danger"></span></label>
                            <div><small class="text-primary">Please mention expected date of completion</small></div>
                            <div class="calenderauditee">
                                <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                            </div>
                        </div>
                    </div> --}}

                    <div class="col-md-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="due-date">Due Date <span class="text-danger">*</span></label>
                            <div class="calenderauditee">
                                <!-- Display the formatted date in a readonly input -->
                                <input type="text" id="due_date_display" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getDueDate(30, true) }}" />
                               
                                <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ Helpers::getDueDate(30, false) }}" class="hide-input" readonly />
                            </div>
                        </div>
                    </div>
                    <script>
                        function handleDateInput(dateInput, displayId) {
                            const date = new Date(dateInput.value);
                            const options = { day: '2-digit', month: 'short', year: 'numeric' };
                            document.getElementById(displayId).value = date.toLocaleDateString('en-GB', options).replace(/ /g, '-');
                        }
                        
                        // Call this function initially to ensure the correct format is shown on page load
                        document.addEventListener('DOMContentLoaded', function() {
                            const dateInput = document.querySelector('input[name="due_date"]');
                            handleDateInput(dateInput, 'due_date_display');
                        });
                        </script>
                        
                        <style>
                        .hide-input {
                            display: none;
                        }
                        </style>
                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="type">
                                Type <span class="text-danger"></span>
                            </label>
                            <!-- <div><small class="text-primary">Select type of site</small></div> -->
                            <select id="select-state" placeholder="Select..." name="type">
                                <option value="">Enter your selection here</option>
                                <option value="$1">$1</option>
                                <option value="$2">$2</option>
                                <option value="$3">$3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Site Name"><b>Name of Site</b></label>
                            <input type="text" name="site_name" value="">
                        </div>
                    </div>
                    {{-- <div class="col-lg-12">
                        <div class="group-input">
                            <label for="Source_Documents">Source Documents</label>
                            <div class="file-attachment-field">
                                <div class="file-attachment-list" id="Source_Documents"></div>
                                <div class="add-btn">
                                    <div>Add</div>
                                    <input type="file" id="myfile" name="source_documents[]" oninput="addMultipleFiles(this, 'Source_Documents')" multiple>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <div class="col-12">
                        <div class="group-input">
                            <label for="Inv Attachments">Source Documents</label>
                            {{-- <div>
                                <small class="text-primary">
                                    Please Attach all relevant or supporting documents
                                </small>
                            </div> --}}
                            <div class="file-attachment-field">
                                <div class="file-attachment-list" id="source_documents">

                                  
                                </div>
                                <div class="add-btn">
                                    <div>Add</div>
                                    <input type="file" id="myfile" name="source_documents[]" oninput="addMultipleFiles(this,'source_documents')"
                                        multiple>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="group-input">

                            <label for="Sponsor"><b>Sponsor</b></label>
                            <input type="text" name="sponsor" value="">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="group-input">
                            <label for="Description">Description</label>
                            <textarea name="description"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="group-input">
                            <label for="attached_files">Attached Files</label>
                            <div class="file-attachment-field">
                                <div class="file-attachment-list" id="attached_files"></div>
                                <div class="add-btn">
                                    <div>Add</div>
                                    <input type="file" id="myfile" name="attached_files[]" oninput="addMultipleFiles(this, 'attached_files')" multiple>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="group-input">
                            <label for="Comments">Comments</label>
                            <textarea name="comments"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="group-input">
                            <label for="Version_no">
                                (Parent) Version No. <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="version_no">
                                <option value="">Enter your selection here</option>
                                <option value="$1">$1</option>
                                <option value="$2">$2</option>
                                <option value="$3">$3</option>
                            </select>
                        </div>
                    </div>
                    <div class="group-input">
                        <label for="audit-agenda-grid">
                            Drug Accountability Site (0)
                            <button type="button" name="audit-agenda-grid" id="Drug_Accountability_Add">+</button>
                        </label>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="Drug_Accountability_Table" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th> Row#</th>
                                        <th> Product Name</th>
                                        <th> Batch Number</th>
                                        <th> Expiry Date</th>
                                        <th> Units Received</th>
                                        <th> Units Dispensed</th>
                                        <th> Units Destroyed</th>
                                        <th> Manufactured Date</th>
                                        <th> Strength</th>
                                        <th> Form</th>
                                        <th> Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input disabled type="text" name="drugaccountability[0][serial]" value="1"></td>
                                        <td><input type="text" name="drugaccountability[0][ProductName]"></td>
                                        <td><input type="number" name="drugaccountability[0][BatchNumber]"></td>
                                        <td><input type="date" name="drugaccountability[0][ExpiryDate]"></td>
                                        <td><input type="text" name="drugaccountability[0][UnitsReceived]"></td>
                                        <td><input type="text" name="drugaccountability[0][UnitsDispensed]"></td>
                                        <td><input type="text" name="drugaccountability[0][UnitsDestroyed]"></td>
                                        <td><input type="date" name="drugaccountability[0][ManufacturedDate]"></td>
                                        <td><input type="text" name="drugaccountability[0][Strength]"></td>
                                        <td><input type="text" name="drugaccountability[0][Form]"></td>
                                        <td><input type="text" name="drugaccountability[0][Remarks]"></td>
                                        
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 sub-head">
                        Study Information
                    </div>
                    <div class="col-6">
                        <div class="group-input">
                            <label for="Admission Criteria">(Parent) Admission Criteria</label>
                            <textarea name="admission_criteria"></textarea>
                        </div>  
                    </div>
                    <div class="col-6">
                        <div class="group-input">
                            <label for="Clinical Significance">(Parent) Clinical Significance</label>
                            <textarea name="cinical_significance"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">

                            <label for="Trade Name"><b>(Root Parent) Trade Name</b></label>
                            <input type="text" name="trade_name" value="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">

                            <label for="Tracking Number"><b>(Parent) Tracking Number</b></label>
                            <input type="text" name="tracking_number" value="">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="group-input">
                            <label for="Phase of Study">(Parent) Phase of Study</label>
                            <select multiple name="phase_of_study" placeholder="" data-search="false" data-silent-initial-value-set="true" id="attendees">
                                <option value="piyush">-- Select --</option>
                                <option value="piyush">Amit Guru</option>
                                <option value="piyush">Amit Patel</option>
                                <option value="piyush">Anshul Patel</option>
                                <option value="piyush">Shaleen Mishra</option>
                                <option value="piyush">Vikas Prajapati</option>
                            </select>
                        </div>
                    </div>
                    <div class="group-input">
                        <label for="audit-agenda-grid">
                            Equipment (0)
                            <button type="button" name="audit-agenda-grid" id="Equipment_Add">+</button>
                        </label>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="Equipment_Table" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th> Row#</th>
                                        <th> Product Name</th>
                                        <th> Batch Number</th>
                                        <th> Expiry Date</th>
                                        <th> Manufactured Date</th>
                                        <th> Number of Items Needed</th>
                                        <th> Exist</th>
                                        <th> Comment</th>
                                        <th> Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input disabled type="text" name="equipments[0][serial]" value="1"></td>
                                        <td><input type="text" name="equipments[0][Product_Name]"></td>
                                        <td><input type="text" name="equipments[0][Batch_Number]"></td>
                                        <td><input type="date" name="equipments[0][Expiry_Date]"></td>
                                        <td><input type="date" name="equipments[0][Manufactured_Date]"></td>
                                        <td><input type="text" name="equipments[0][Number_of_Items_Needed]"></td>
                                        <td><input type="text" name="equipments[0][Exist]"></td>
                                        <td><input type="text" name="equipments[0][Comment]"></td>
                                        <td><input type="text" name="equipments[0][Remarks]"></td>
                                    </tr>
                                    
                                </tbody>

                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Type">
                                (Parent) Type <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="parent_type">
                                <option value="">Enter your selection here</option>
                                <option value="">$1</option>
                                <option value="">$2</option>
                                <option value="">$3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">

                            <label for="Other Type"><b>(Parent) Other Type</b></label>
                            <input type="text" name="par_oth_type" value="">
                        </div>
                    </div>
                    <div class="col-12 sub-head">
                        Location
                    </div>
                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Zone">
                                Zone <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="zone">
                                <option value="">Enter your selection here</option>
                                <option value="">$1</option>
                                <option value="">$2</option>
                                <option value="">$3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">

                            <label for="Country"><b>Country</b></label>
                            <select id="select-state" placeholder="Select..." name="country">
                                <option value="">Enter your selection here</option>
                                <option value="">$1</option>
                                <option value="">$2</option>
                                <option value="">$3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">

                            <label for="City"><b>City</b></label>
                            <input type="text" name="city" value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="State_District">
                                State/District <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="state_district">
                                <option value="">Enter your selection here</option>
                                <option value="">$1</option>
                                <option value="">$2</option>
                                <option value="">$3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="search">
                                Site Name <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="sel_site_name">
                                <option value="">Enter your selection here</option>
                                <option value="">$1</option>
                                <option value="">$2</option>
                                <option value="">$3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="search">
                                Building <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="building">
                                <option value="">Enter your selection here</option>
                                <option value="">$1</option>
                                <option value="">$2</option>
                                <option value="">$3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="search">
                                Floor <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="floor">
                                <option value="">Enter your selection here</option>
                                <option value="">$1</option>
                                <option value="">$2</option>
                                <option value="">$3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="search">
                                Room <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="room">
                                <option value="">Enter your selection here</option>
                                <option value="">$1</option>
                                <option value="">$2</option>
                                <option value="">$3</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="button-block">
                    <button type="submit" class="saveButton">Save</button>
                    <!-- <button type="button" class="backButton" onclick="previousStep()">Back</button> -->
                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>                            
                    <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a></button>
                </div>
            </div>
        </div>

        <div id="CCForm2" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="row">
                    <div class="col-12 sub-head">
                        Site Additional Information
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">

                            <label for="Site Name"><b>Name of Site</b></label>
                            <input type="text" name="site_name_sai" value="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">

                            <label for="Site Name"><b>Pharmacy</b></label>
                            <input type="text" name="pharmacy" value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="search">
                                Site Number <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="site_no">
                                <option value="">Enter your selection here</option>
                                <option value="">$1</option>
                                <option value="">$2</option>
                                <option value="">$3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="search">
                                Site Status <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="site_status">
                                <option value="">Enter your selection here</option>
                                <option value="">$1</option>
                                <option value="">$2</option>
                                <option value="">$3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="due-date">Activation Date <span class="text-danger"></span></label>
                            <div class="calenderauditee">
                                <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                <input type="date" name="acti_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="due-date">Date of Final Report <span class="text-danger"></span></label>
                            <div class="calenderauditee">
                                <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                <input type="date" name="date_final_report" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="due-date">Initial IRB Approval Date <span class="text-danger"></span></label>
                            <div class="calenderauditee">
                                <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                <input type="date" name="ini_irb_app_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="due-date">IMP Receipt at Site Date <span class="text-danger"></span></label>
                            <div class="calenderauditee">
                                <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                <input type="date" name="imp_site_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="search">
                                Lab/Department Name <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="lab_de_name">
                                <option value="">Enter your selection here</option>
                                <option value="">$1</option>
                                <option value="">$2</option>
                                <option value="">$3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="search">
                                Monitoring Performed By <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="moni_per_by">
                                <option value="">Enter your selection here</option>
                                <option value="">$1</option>
                                <option value="">$2</option>
                                <option value="">$3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">

                            <label for="Site Name"><b># Dropped/Withdrawn</b></label>
                            <input type="text" name="drop_withdreawn" value="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">

                            <label for="Site Name"><b># Enrolled</b></label>
                            <input type="text" name="enrolled" value="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">

                            <label for="Site Name"><b># Follow-Up</b></label>
                            <input type="text" name="follow-up" value="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">

                            <label for="Site Name"><b># Planned</b></label>
                            <input type="text" name="planned" value="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">

                            <label for="Site Name"><b># Screened</b></label>
                            <input type="text" name="screened" value="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">

                            <label for="Site Name"><b>Projected # of Annual MV</b></label>
                            <input type="text" name="project_annual_mv" value="">
                        </div>
                    </div>
                    <div class="col-md-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="due-date">Scheduled Start Date <span class="text-danger"></span></label>
                            <div class="calenderauditee">
                                <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                <input type="date" name="schedual_start_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="due-date">Scheduled End Date <span class="text-danger"></span></label>
                            <div class="calenderauditee">
                                <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                <input type="date" name="schedual_end_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="due-date">Actual Start Date <span class="text-danger"></span></label>
                            <div class="calenderauditee">
                                <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                <input type="date" name="actual_start_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="due-date">Actual End Date <span class="text-danger"></span></label>
                            <div class="calenderauditee">
                                <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                <input type="date" name="actual_end_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">

                            <label for="Site Name"><b>Lab Name</b></label>
                            <input type="text" name="lab_name" value="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">

                            <label for="Site Name"><b>Monitoring Performed By</b></label>
                            <input type="text" name="monitring_per_by_si" value="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="group-input">
                            <label for="search">
                                Control Group <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="control_group">
                                <option value="">Enter your selection here</option>
                                <option value="">$1</option>
                                <option value="">$2</option>
                                <option value="">$3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="group-input">
                            <label for="Consent_Form">Consent Form</label>
                            <div class="file-attachment-field">
                                <div class="file-attachment-list" id="Consent_Form"></div>
                                <div class="add-btn">
                                    <div>Add</div>
                                    <input type="file" id="HOD_Attachments" name="consent_form" oninput="addMultipleFiles(this, 'Consent_Form')" multiple>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 sub-head">
                        Finance
                    </div>
                    <div class="col-12">
                        <div class="group-input">
                            <label for="Budget">Budget</label>
                            <textarea name="budget"></textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="group-input">
                            <label for="Sites Project">Project # of Sites</label>
                            <textarea name="proj_sties_si"></textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="group-input">
                            <label for="Subjects Project">Project # of Subjects</label>
                            <textarea name="proj_subject_si"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Subjects in Site">
                                Subjects in Site <span class="text-danger"></span>
                            </label>
                            <div><small class="text-primary">Automatic Calculation</small></div>
                            <select id="select-state" placeholder="Select..." name="auto_calcultion">
                                <option value="">Enter your selection here</option>
                                <option value="">$1</option>
                                <option value="">$2</option>
                                <option value="">$3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="group-input">
                            <label for="Currency">
                                Currency <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="currency_si">
                                <option value="">Enter your selection here</option>
                                <option value="">$1</option>
                                <option value="">$2</option>
                                <option value="">$3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="group-input">
                            <label for="Attached_Payments">Attached Payments</label>
                            <div class="file-attachment-field">
                                <div class="file-attachment-list" id="attached_payments"></div>
                                <div class="add-btn">
                                    <div>Add</div>
                                    <input type="file" id="HOD_Attachments" name="attached_payments[]" oninput="addMultipleFiles(this, 'Attached_Payments')" multiple>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="group-input">
                        <label for="audit-agenda-grid">
                            Financial Transactions (0)
                            <button type="button" name="audit-agenda-grid" id="Financial_Transactions_Add">+</button>
                        </label>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="Financial_Transactions_Table" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th> Row#</th>
                                        <th> Transaction</th>
                                        <th> Transaction Type</th>
                                        <th> Date</th>
                                        <th> Amount</th>
                                        <th> Currency Used</th>
                                        <th> Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>

                                        <td><input disabled type="text" name="financialTransactions[0][serial]" value="1"></td>
                                        <td><input type="text" name="financialTransactions[0][Transaction]"></td>
                                        <td><input type="text" name="financialTransactions[0][Transaction_Type]"></td>
                                        <td><input type="date" name="financialTransactions[0][Date]"></td>
                                        <td><input type="text" name="financialTransactions[0][Amount]"></td>
                                        <td><input type="text" name="financialTransactions[0][Currency_Used]"></td>
                                        <td><input type="text" name="financialTransactions[0][Remarks]"></td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                    </div>
                    <div class="col-12 sub-head">
                        Persons Involved
                    </div>
                    <div class="col-lg-12">
                        <div class="group-input">

                            <label for="CRA"><b>CRA</b></label>
                            <div><small class="text-primary">Clinical Research Associate</small></div>
                            <input type="text" name="cra" value="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">

                            <label for="Lead Investigator"><b>Lead Investigator</b></label>
                            <input type="text" name="lead_investigator" value="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">

                            <label for="Reserve Team Associate"><b>Reserve Team Associate</b></label>
                            <input type="text" name="reserve_team_associate" value="">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="group-input">
                            <label for="Additional Investigators">Additional Investigators</label>
                            <textarea name="additional_investigators"></textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="group-input">
                            <label for="Clinical Research Coordinator">Clinical Research Coordinator</label>
                            <textarea name="clini_res_coordi"></textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="group-input">
                            <label for="Pharmacist">Pharmacist</label>
                            <textarea name="pharmacist"></textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="group-input">
                            <label for="Comments">Comments</label>
                            <textarea name="comments_si"></textarea>
                        </div>
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

        <div id="CCForm3" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="row">
                    <div class="col-12 sub-head">
                        Finance
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">

                            <label for="Budget"><b>Budget</b></label>
                            <input type="text" name="budget_ut" value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Currency">
                                Currency <span class="text-danger"></span>
                            </label>
                            <select id="select-state" placeholder="Select..." name="currency_ut">
                                <option value="">Enter your selection here</option>
                                <option value="">$1</option>
                                <option value="">$2</option>
                                <option value="">$3</option>
                            </select>
                        </div>
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
        </form>

    </div>
</div>

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
    VirtualSelect.init({
        ele: '#attendees'
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
    }
</script>
@endsection
