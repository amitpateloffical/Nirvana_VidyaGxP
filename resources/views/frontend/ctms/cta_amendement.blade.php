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

{{--<img src="https://vidyagxp.com/vidyaGxp_logo.png" alt="" class="w-100">--}}




<div class="form-field-head">
    {{-- <div class="pr-id">
            New Child
        </div> --}}
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        /CTMS - CTA Amendement
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#ATC_codes').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="atc_Search[]"></td>' +
                    '<td><input type="text" name="1st_Level[]"></td>' +
                    '<td><input type="text" name="2nd_Level[]"></td>' +
                    '<td><input type="text" name="3rd_Level[]"></td>' +
                    '<td><input type="text" name="4th_Level[]"></td>' +
                    '<td><input type="text" name="5th_Level[]"></td>' +
                    '<td><input type="text" name="atc_Code[]"></td>' +
                    '<td><input type="text" name="substance[]"></td>' +
                    '<td><input type="text" name="remarks[]"></td>' +


                    '</tr>';

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                // html += '</select></td>' +

                //     '</tr>';

                return html;
            }

            var tableBody = $('#ATC_codes-table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#Ingredients').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="ingredient_Type[]"></td>' +
                    ' <td><input type="text" name="ingredient_Name[]"></td>' +
                    '<td><input type="text" name="ingredient_Strength[]"></td>' +
                    '<td><input type="text" name="Specification_Date[]"></td>' +
                    '<td><input type="text" name="Remarks[]"></td>' +



                    '</tr>';

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                // html += '</select></td>' +

                //     '</tr>';

                return html;
            }

            var tableBody = $('#Ingredients-first-table');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#Product_Material').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                        '<tr>' +
                            '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                            '<td><input type="text" name="product_material[' + serialNumber + '][ProductName]"></td>' +
                            '<td><input type="number" name="product_material[' + serialNumber + '][BatchNumber]"></td>' +
                            '<td><input type="date" name="product_material[' + serialNumber + '][ExpiryDate]"></td>' +
                            '<td><input type="date" name="product_material[' + serialNumber + '][ManufacturedDate]"></td>' +
                            '<td><input type="text" name="product_material[' + serialNumber + '][Disposition]"></td>' +
                            '<td><input type="text" name="product_material[' + serialNumber + '][Comments]"></td>' +
                            '<td><input type="text" name="product_material[' + serialNumber + '][Remarks]"></td>' +
                            '<td><button type="text" class="removeRowBtn" ">Remove</button></td>' +
                        '</tr>';

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                // html += '</select></td>' +

                //     '</tr>';

                return html;
            }

            var tableBody = $('#Product_Material-first-table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#Packaging_Information').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +

                    '<td><input type="text" name="Primary_Packaging[]"></td>'
                '<td><input type="text" name="Material[]"></td>' +
                '<td><input type="text" name="Pack_Size[]"></td>' +
                '<td><input type="text" name="Shelf_Life[]"></td>' +
                '<td><input type="text" name="Storage_Condition[]"></td>' +
                '<td><input type="text" name="Secondary_Packaging[]"></td>' +
                '<td><input type="text" name="Remarks[]"></td>' +

                '</tr>';

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                // html += '</select></td>' +

                //     '</tr>';

                return html;
            }

            var tableBody = $('#Packaging_Information-first-table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('#Equipment').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="ProductName[]"></td>' +
                    '<td><input type="number" name="BatchNumber[]"></td>' +
                    '<td><input type="date" name="ExpiryDate[]"></td>' +
                    '<td><input type="date" name="ManufacturedDate[]"></td>' +
                    '<td><input type="number" name="NumberOfItemsNeeded[]"></td>' +
                    '<td><input type="text" name="Exist[]"></td>' +
                    '<td><input type="text" name="Comment[]"></td>' +


                    '</tr>';

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                // html += '</select></td>' +

                //     '</tr>';

                return html;
            }

            var tableBody = $('#Equipment_details tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>




{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">CTA Amendement</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">CTA Amendement Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Root Cause Analysis</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Signatures</button>

        </div>

        <form action="{{ route('cta_amendement.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div id="step-form">
                @if (!empty($parent_id))
                <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                @endif
                <!-- Tab content -->
                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="sub-head">
                            General Information
                        </div> <!-- RECORD NUMBER -->
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator">Record Number </label>
                                    <input disabled type="text" name="record"
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}/CTA-Amendement/{{ date('Y') }}/{{ $record_number }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Site/Location Code</b></label>
                                    <input readonly type="text" name="division_code"
                                        value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                    {{-- <div class="static">QMS-North America</div> --}}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator">Initiator</label>
                                    <input disabled type="text" name="initiator_id" value="{{ auth()->user()->name }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input ">
                                    <label for="Date Of Initiation"><b>Date Of Initiation</b></label>
                                    <input readonly type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Initiator Group Code">Short Description<span class="text-danger">*</span></label>
                                    <p class="text-primary">PSUR Short Description to be presented on dekstop</p>
                                    <input type="text" name="short_description" id="initiator_group_code" value="">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="If Others">Assigned To</label>
                                    <select name="assigned_to">
                                     <option value="">Select a value</option>
                                        @if($users->isNotEmpty())
                                            @foreach($users as $user)
                                            <option value='{{ $user->id }}'>{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Due Date">Date Due</label>
                                    <p class="text-primary"> last date this record should be closed by</p>
                                    <div class="calenderauditee">
                                        <input  type="hidden" value="{{ $due_date }}" name="due_date">
                                        <input disabled type="text" value="{{ Helpers::getdateFormat($due_date) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Type</label>
                                    <select name="type">
                                        <option value="">-- select --</option>
                                        <option value="administrative-amendment">Administrative Amendment</option>
                                        <option value="budget-amendment">Budget Amendment</option>
                                        <option value="scope-of-work-amendment">Scope of Work Amendment</option>
                                        <option value="regulatory-amendment">Regulatory Amendment</option>
                                        <option value="milestone-amendment">Milestone Amendment</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Other Type">Other Type</label>
                                    <select name="other_type">
                                        <option value="">-- select --</option>
                                        <option value="data-management-amendment">Data Management Amendment</option>
                                        <option value="logistical-amendment">Logistical Amendment</option>
                                        <option value="communication-amendment">Communication Amendment</option>
                                        <option value="quality-assurance-amendment">Quality Assurance Amendment</option>
                                        <option value="equipment-amendment">Equipment Amendment</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Attached Files">Attached Files</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attach"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="attached_files[]" oninput="addMultipleFiles(this, 'file_attach')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="group-input">
                                    <label for="Description">Description</label>
                                    <small class="text-primary">
                                        Amendment detailled description
                                    </small>
                                    <textarea name="description"></textarea>
                                </div>
                            </div>


                            <div class="sub-head">Location</div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">Zone</label>
                                    <select name="zone">
                                        <option value="">Select a value</option>
                                        <option value="asia">Asia</option>
                                        <option value="europe">Europe</option>
                                        <option value="africa">Africa</option>
                                        <option value="central-america">Central America</option>
                                        <option value="south-america">South America</option>
                                        <option value="oceania">Oceania</option>
                                        <option value="north-america">North America</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Country <span class="text-danger"></span>
                                    </label>
                                    <select name="country" class="form-select country" aria-label="Default select example" onchange="loadStates()">
                                        <option value="">Select Country</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        State/District <span class="text-danger"></span>
                                    </label>
                                    <select name="state" class="form-select state" aria-label="Default select example" onchange="loadCities()">
                                        <option value="">Select State/District</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        City <span class="text-danger"></span>
                                    </label>
                                    <select name="city" class="form-select city" aria-label="Default select example">
                                        <option value="">Select City</option>
                                    </select>
                                </div>
                            </div>

                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                                    </a> </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head col-12">Amendement Information</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Procedure Number">Procedure Number</label>
                                    <input type="number" name="procedure_number" id="procedure_number" value="">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Project Code">Project Code</label>
                                    <input type="text" name="project_code" id="project_code" value="">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Registration Number">Registration Number</label>
                                    <input type="number" name="registration_number" id="registration_number" value="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Other Authority">Other Authority</label>
                                    <input type="text" name="other_authority" id="other_authority" value="">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Authority Type">Authority Type</label>
                                    <select name="authority_type">
                                        <option value="">-- select --</option>
                                        <option value="ethics-committee">Ethics Committee/Institutional Review Board </option>
                                        <option value="regulatory-authority">Regulatory Authority</option>
                                        <option value="sponsor-investigator">Sponsor/Investigator</option>
                                        <option value="data-safety-monitoring-board">Data Safety Monitoring Board</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Authority">Authority</label>
                                    <select name="authority">
                                        <option value="">-- select --</option>
                                        <option value="national-competent-authority">National Competent Authority</option>
                                        <option value="ethics-committee">Ethics Committee</option>
                                        <option value="local-ethics-committees">Local Ethics Committees</option>
                                        <option value="national-health-authorities">National Health Authorities</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Year">Year</label>
                                    <select name="year">
                                        <option value="">-- select --</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                        <option value="2027">2027</option>
                                        <option value="2028">2028</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Registration Status">Registration Status</label>
                                    <select name="registration_status">
                                        <option value="">-- select --</option>
                                        <option value="pending-submission">Pending Submission</option>
                                        <option value="submitted">Submitted</option>
                                        <option value="under-review">Under Review</option>
                                        <option value="approved">Approved</option>
                                        <option value="rejected">Rejected</option>
                                        <option value="withdrawn">Withdrawn</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CAR Clouser Time Weight">CAR Clouser Time Weight</label>
                                    <select name="car_clouser_time_weight">
                                        <option value="">-- select --</option>
                                        <option value="high-priority">High Priority</option>
                                        <option value="medium-high-priority">Medium-High Priority</option>
                                        <option value="medium-priority">Medium Priority</option>
                                        <option value="medium-low-priority">Medium-Low Priority</option>
                                        <option value="low-priority">Low Priority</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Outcome">Outcome</label>
                                    <select name="outcome">
                                        <option value="">-- select --</option>
                                        <option value="approved">Approved</option>
                                        <option value="pending-approval">Pending Approval</option>
                                        <option value="under-review">Under Review</option>
                                        <option value="pending-approval">modification-required</option>
                                        <option value="superseded">superseded</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Trade Name">Trade Name</label>
                                    <input type="text" name="trade_name" id="trade_name" value="">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Estimated Man-Hours">Estimated Man-Hours</label>
                                    <input type="time" name="estimated_man_hours" id="estimated_man_hours" value="">
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="group-input">
                                    <label for="Comments">Comments</label>
                                    <textarea name="comments"></textarea>
                                </div>
                            </div>

                            <div class="sub-head">Product Information</div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="manufacturer">Manufacturer</label>
                                    <select name="manufacturer">
                                        <option value="">-- select --</option>
                                        <option value="sponsor-manufacturer">Sponsor Manufacturer</option>
                                        <option value="contract-manufacturing-organization">Contract Manufacturing Organization</option>
                                        <option value="in-house-manufacturing">In-house Manufacturing</option>
                                        <option value="academic-institution">Academic Institution</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Product_Material">
                                        (Root Parent) Product/Material
                                        <button type="button" name="product_material" id="Product_Material">+</button>
                                        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="Product_Material-first-table" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 4%">Row #</th>
                                                    <th style="width: 12%">Product Name</th>
                                                    <th style="width: 16%">Batch Number</th>
                                                    <th style="width: 16%">Expiry Date</th>
                                                    <th style="width: 16%">Manufactured Date</th>
                                                    <th style="width: 16%">Disposition</th>
                                                    <th style="width: 16%">Comments</th>
                                                    <th style="width: 16%">Remarks</th>
                                                    <th style="width: 16%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <td><input disabled type="text" name="product_material[0][serial]" value="1"></td>
                                                <td><input type="text" name="product_material[0][ProductName]"></td>
                                                <td><input type="number" name="product_material[0][BatchNumber]"></td>
                                                <td><input type="date" name="product_material[0][ExpiryDate]"></td>
                                                <td><input type="date" name="product_material[0][ManufacturedDate]"></td>
                                                <td><input type="text" name="product_material[0][Disposition]"></td>
                                                <td><input type="text" name="product_material[0][Comments]"></td>
                                                <td><input type="text" name="product_material[0][Remarks]"></td>
                                                <td><button readonly type="text" class="removeRowBtn">Remove</button></td>
                                                {{--<td><input readonly type="text"></td>--}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="sub-head">Important Dates</div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Actual Submission Date">Actual Submission Date </label>
                                    <div class="calenderauditee">
                                        <input type="text" id="actual_submission_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="actual_submission_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'actual_submission_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Actual Rejection Date">Actual Rejection Date </label>
                                    <div class="calenderauditee">
                                        <input type="text" id="actual_rejection_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="actual_rejection_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'actual_rejection_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Actual Withdrawn Date">Actual Withdrawn Date </label>
                                    <div class="calenderauditee">
                                        <input type="text" id="actual_withdrawn_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="actual_withdrawn_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'actual_withdrawn_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Inquiry Date">Inquiry Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="inquiry_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="inquiry_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'inquiry_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Planened Submission Date">Planned Submission Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="planned_submission_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="planned_submission_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'planned_submission_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Planned DateSent To Affiliate">Planned Date Sent To Affiliate</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="planned_date_sent_to_affiliate" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="planned_date_sent_to_affiliate" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'planned_date_sent_to_affiliate')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Effective Date">Effective Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="effective_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="effective_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'effective_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="sub-head">
                                Person Involved
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Additional Assignees">Additional Assignees</label>
                                    <textarea name="additional_assignees"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Additional Investigators">Additional Investigators</label>
                                    <textarea name="additional_investigators"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Approvers">Approvers</label>
                                    <textarea name="approvers"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Negotiation Team">Negotiation Team</label>
                                    <textarea name="negotiation_team"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Trainer">Trainer</label>
                                    <select name="trainer" onchange="">
                                        <option value="">-- select --</option>
                                        <option value="internal-trainer">Internal Trainer</option>
                                        <option value="external-trainer">External Trainer</option>
                                        <option value="contract-research-organization-trainer">Contract Research Organization Trainer</option>
                                        <option value="subject-matter-expert ">Subject Matter Expert</option>
                                        <option value="clinical-educator">Clinical Educator</option>
                                    </select>
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
                        <div class="sub-head">
                            Root Cause
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Root Cause Description">Root Cause Description</label>
                                    <textarea name="root_cause_description"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Reason(s) for Non-Approval">Reason(s) for Non-Approval</label>
                                    <textarea name="reason_for_non_approval"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Reason(s) for Withdrawal">Reason(s) for Withdrawal</label>
                                    <textarea name="reason_for_withdrawal"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Justification/Rationale">Justification/Rationale</label>
                                    <textarea name="justification_rationale"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Meeting Minutes">Meeting Minutes</label>
                                    <textarea name="meeting_minutes"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Rejection Reason">Rejection Reason</label>
                                    <textarea name="rejection_reason"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Effectiveness Check Summary">Effectiveness Check Summary</label>
                                    <textarea name="effectiveness_check_summary"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Decision">Decision</label>
                                    <textarea name="decision"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Summary">Summary</label>
                                    <textarea name="summary"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Documents Affected">Documents Affected</label>
                                    <select id="documents_affected" name="" id="">
                                        <option value="">--Select---</option>
                                        <option value="protocol">Protocol</option>
                                        <option value="informed-consent-form">Informed Consent Form</option>
                                        <option value="investigators-brochure">Investigators Brochure</option>
                                        <option value="case-report-forms">Case Report Forms</option>
                                        <option value="clinical-study-report">Clinical Study Report</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actual Time Spend">Actual Time Spend</label>
                                    <input type="time" name="actual_time_spend" id="actual_time_spend">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Documents">Documents</label>
                                    <input type="text" name="documents" id="documents">
                                </div>
                            </div>
                        </div>

                        <div class="button-block">
                        <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                                </a> </button>
                        </div>
                    </div>
                </div>

                <div id="CCForm4" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="sub-head">
                            Activity Log
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Approved  By">Approved By :</label>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Approved on">Approved on :</label>
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
    document.getElementById('clearSelection').addEventListener('click', function() {
        var radios = document.querySelectorAll('input[type="radio"]');
        for (var i = 0; i < radios.length; i++) {
            radios[i].checked = false;
        }
    });
</script>


<script>
    var maxLength = 255;
    $('#docname').keyup(function() {
        var textlen = maxLength - $(this).val().length;
        $('#rchars').text(textlen);
    });
</script>


<script>
    $(document).on('click', '.removeRowBtn', function() {
        $(this).closest('tr').remove();
    })
</script>

     {{--Country Statecity API--}}
    <script>
        var config = {
            cUrl: 'https://api.countrystatecity.in/v1',
            ckey: 'NHhvOEcyWk50N2Vna3VFTE00bFp3MjFKR0ZEOUhkZlg4RTk1MlJlaA=='
        };

        var countrySelect = document.querySelector('.country'),
            stateSelect = document.querySelector('.state'),
            citySelect = document.querySelector('.city');

        function loadCountries() {
            let apiEndPoint = `${config.cUrl}/countries`;

            $.ajax({
                url: apiEndPoint,
                headers: {
                    "X-CSCAPI-KEY": config.ckey
                },
                success: function(data) {
                    data.forEach(country => {
                        const option = document.createElement('option');
                        option.value = country.iso2;
                        option.textContent = country.name;
                        countrySelect.appendChild(option);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error loading countries:', error);
                }
            });
        }

        function loadStates() {
            stateSelect.disabled = false;
            stateSelect.innerHTML = '<option value="">Select State</option>';

            const selectedCountryCode = countrySelect.value;

            $.ajax({
                url: `${config.cUrl}/countries/${selectedCountryCode}/states`,
                headers: {
                    "X-CSCAPI-KEY": config.ckey
                },
                success: function(data) {
                    data.forEach(state => {
                        const option = document.createElement('option');
                        option.value = state.iso2;
                        option.textContent = state.name;
                        stateSelect.appendChild(option);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error loading states:', error);
                }
            });
        }

        function loadCities() {
            citySelect.disabled = false;
            citySelect.innerHTML = '<option value="">Select City</option>';

            const selectedCountryCode = countrySelect.value;
            const selectedStateCode = stateSelect.value;

            $.ajax({
                url: `${config.cUrl}/countries/${selectedCountryCode}/states/${selectedStateCode}/cities`,
                headers: {
                    "X-CSCAPI-KEY": config.ckey
                },
                success: function(data) {
                    data.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.name;
                        option.textContent = city.name;
                        citySelect.appendChild(option);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error loading cities:', error);
                }
            });
        }
        $(document).ready(function() {
            loadCountries();
        });
    </script>
{{--Country Statecity API End--}}



@endsection
