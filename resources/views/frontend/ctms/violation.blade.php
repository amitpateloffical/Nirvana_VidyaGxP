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
    {{-- <div class="pr-id">
            New Child
        </div> --}}
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        / CTMS_Violation
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#Monitor_Information').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="date" name="date[]"></td>' +
                    ' <td><input type="text" name="Responsible[]"></td>' +
                    '<td><input type="text" name="ItemDescription[]"></td>' +
                    '<td><input type="date" name="SentDate[]"></td>' +
                    '<td><input type="date" name="ReturnDate[]"></td>' +
                    '<td><input type="text" name="Comment[]"></td>' +
                    '<td><input type="text" name="Remarks[]"></td>' +


                    '</tr>';

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                // html += '</select></td>' +

                //     '</tr>';

                return html;
            }

            var tableBody = $('#Monitor_Information_details tbody');
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
                    '<td><input type="text" name="product_material[' + serialNumber + '][Comment]"></td>' +
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

            var tableBody = $('#Product_Material_details tbody');
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
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Protocol Violation</button>
            {{--<button class="cctablinks" onclick="openCity(event, 'CCForm2')">Parent Information</button>--}}
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Violation Information</button>
            {{--<button class="cctablinks" onclick="openCity(event, 'CCForm4')">Action Approval</button>--}}
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Signatures</button>
        </div>

        <form action="{{ route('violation.store') }}" method="POST" enctype="multipart/form-data">
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
                            Monitor Visit
                        </div> <!-- RECORD NUMBER -->
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"> Record Number </label>
                                    <input disabled type="text" name="record"
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}/Violation/{{ date('Y') }}/{{ $record_number }}">
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
                                @if (!empty($cc->id))
                                <input type="hidden" name="ccId" value="{{ $cc->id }}">
                                @endif
                                <div class="group-input">
                                    <label for="originator">Initiator</label>
                                    <input disabled type="text" name="initiator_id" value="{{ auth()->user()->name }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date Opened">Date of Initiation</label>
                                    <input readonly type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                </div>
                            </div>

                        <div class="col-12">
                            <div class="group-input">
                                <label for="Short Description">Short Description<span class="text-danger">*</span></label><span id="rchars">255</span>
                                characters remaining
                                <input id="short_description" type="text" name="short_description" maxlength="255" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Assigned To <span class="text-danger"></span>
                                </label>
                                <select id="assign_to" placeholder="Select..." name="assign_to">
                                    <option value="">Select a value</option>
                                    @if($users->isNotEmpty())
                                        @foreach($users as $user)
                                        <option value='{{ $user->id }}'>{{ $user->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="due-date">Due Date <span class="text-danger"></span></label>
                                <p class="text-primary">Please mention expected date of completion</p>
                                  <div class="calenderauditee">
                                    <input  type="hidden" value="{{ $due_date }}" name="due_date">
                                    <input disabled type="text" value="{{ Helpers::getdateFormat($due_date) }}">
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Type <span class="text-danger"></span>
                                </label>
                                <select id="type" placeholder="Select..." name="type">
                                    <option value="">Enter Your Selection Here</option>
                                    <option value="supplier-type">Supplier Type</option>
                                    <option value="payment-type">Payment Type</option>
                                    <option value="risk-type">Risk Type</option>
                                    <option value="quality-assurance-type">Quality Assurance Type</option>
                                    <option value="relationship-type">Relationship Type</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Other Type <span class="text-danger"></span>
                                </label>
                                <select id="other_type" placeholder="Select..." name="other_type">
                                    <option value="">Select a value</option>
                                    <option value="good-manufacturing-practice">Good Manufacturing Practice</option>
                                    <option value="good-clinical-practice">Good Clinical Practice</option>
                                    <option value="good-laboratory-practice">Good Laboratory Practice</option>
                                    <option value="good-distribution-practice ">Good Distribution Practice </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="search">
                                    Related URL <span class="text-danger"></span>
                                </label>
                                <select id="related_url" placeholder="Select..." name="related_url">
                                    <option value="">Select a value</option>
                                    <option value="fda-gmp-guidelines">FDA GMP Guidelines</option>
                                    <option value="who-gmp-guidelines">WHO GMP Guidelines</option>
                                    <option value="fda-gcp-guidelines">FDA GCP Guidelines</option>
                                    <option value="ich-gmp-guidelines">ICH GCP Guidelines</option>
                                    <option value="fda-glp-guidelines">FDA GLP Regulations</option>
                                    <option value="oecd-glp-guidelines">OECD GLP Principles</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="closure attachment">File Attachments </label>
                                <div><small class="text-primary">
                                    </small>
                                </div>
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="file_attach"></div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="myfile" name="file_attachments[]" oninput="addMultipleFiles(this, 'file_attach')" multiple>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="group-input">
                                <label for="Short Description">Description</label>
                                 <textarea name="description"></textarea>
                            </div>
                        </div>


                        <div class="sub-head">
                            Location
                        </div>

                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Zone <span class="text-danger"></span>
                                </label>
                                <select name="zone">
                                    <option value="">Enter Your Selection Here</option>
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
                                <p class="text-primary">Auto filter according to selected zone</p>

                                <select name="country_id" class="form-select country" aria-label="Default select example"
                                    onchange="loadStates()">
                                    <option value="">Select Country</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    State/District <span class="text-danger"></span>
                                </label>
                                <p class="text-primary">Auto selected according to City</p>

                                <select name="state_id" class="form-select state" aria-label="Default select example"
                                    onchange="loadCities()">
                                    <option value="">Select State/District</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    City <span class="text-danger"></span>
                                </label>
                                <p class="text-primary">Auto filter according to selected country</p>
                                    <select name="city_id" class="form-select city" aria-label="Default select example" onchange="loadSites()">
                                        <option value="">Select City</option>
                                    </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Site Name <span class="text-danger"></span>
                                </label>
                                <select name="site_name_id" class="form-select siteName" aria-label="Default select example" onchange="loadBuildings()">
                                    <option value="">Select Site</option>
                                    <option value="site-A">Site A</option>
                                    <option value="site-B">Site B</option>
                                    <option value="site-C">Site C</option>
                                    <option value="site-D">Site D</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Building <span class="text-danger"></span>
                                </label>
                                <select name="building_id" class="form-select building" aria-label="Default select example" onchange="loadFloors()">
                                    <option value="">Select Building</option>
                                    <option value="building-X">Building X</option>
                                    <option value="building-Y">Building Y</option>
                                    <option value="building-Z">Building Z</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Floor <span class="text-danger"></span>
                                </label>
                                <select name="flore_id" class="form-select floor" aria-label="Default select example" onchange="loadRooms()">
                                    <option value="">Select Floor</option>
                                    <option value="floor-1">Floor 1</option>
                                    <option value="floor-2">Floor 2</option>
                                    <option value="floor-3">Floor 3</option>
                                    <option value="floor-4">Floor 4</option>
                                    <option value="floor-5">Floor 5</option>
                                    <option value="floor-6">Floor 6</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Room <span class="text-danger"></span>
                                </label>
                                <select name="room_id" class="form-select room" aria-label="Default select example">
                                    <option value="">Select Room</option>
                                    <option value="room-101">Room 101</option>
                                    <option value="room-102">Room 102</option>
                                    <option value="room-201">Room 201</option>
                                    <option value="room-202">Room 202</option>
                                    <option value="room-301">Room 301</option>
                                    <option value="room-302">Room 302</option>
                                    <option value="room-401">Room 401</option>
                                    <option value="room-402">Room 402</option>
                                    <option value="room-501">Room 501</option>
                                    <option value="room-502">Room 502</option>
                                    <option value="room-601">Room 601</option>
                                    <option value="room-602">Room 602</option>
                                </select>
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

            <div id="CCForm3" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="row">
                        <div class="sub-head col-12">Violation Information</div>

                        <div class="col-lg-6  new-date-data-field">
                            <div class="group-input input-date">
                                <label for="date_occured">Date Occured</lable>
                                    <div class="calenderauditee">
                                        <input type="text" id="date_occured" name="date_occured" placeholder="DD-MMM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="date_occured" name="date_occured" class="hide-input" oninput="handleDateInput(this, 'date_occured');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>
                              </div>
                        </div>

                        <div class="col-lg-6  new-date-data-field">
                            <div class="group-input input-date">
                                <label for="notification_date">Notification Date</lable>
                                    <div class="calenderauditee">
                                        <input type="text" id="notification_date" placeholder="DD-MMM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="notification_date" name="notification_date" class="hide-input" oninput="handleDateInput(this, 'notification_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>
                              </div>
                        </div>

                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Severity Rate <span class="text-danger"></span>
                                </label>
                                <select id="select-state" placeholder="Select..." name="severity_rate">
                                    <option value="">Select a value</option>
                                    <option value="critical">Critical</option>
                                    <option value="major">Major</option>
                                    <option value="minor">Minor</option>
                                    <option value="moderate">Moderate</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Occurance <span class="text-danger"></span>
                                </label>
                                <select id="select-state" placeholder="Select..." name="occurance">
                                    <option value="">Select a value</option>
                                    <option value="frequent">Frequent</option>
                                    <option value="occasional">Occasional</option>
                                    <option value="rare">Rare</option>
                                    <option value="single-occurrence">Single Occurrence</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Detection <span class="text-danger"></span>
                                </label>
                                <select id="select-state" placeholder="Select..." name="detection">
                                    <option value="">Select a value</option>
                                    <option value="internal-audit">Internal Audit</option>
                                    <option value="external-audit">External Audit</option>
                                    <option value="routine-monitoring">Routine Monitoring</option>
                                    <option value="incident-reporting">Incident Reporting</option>
                                    <option value="customer-complaints">Customer Complaints</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    RPN <span class="text-danger"></span>
                                </label>
                                <select id="select-state" placeholder="Select..." name="rpn">
                                    <option value="">Select a value</option>
                                    <option value="occurrence-scale">Occurrence(O)Scale</option>
                                    <option value="severity-scale">Severity(S)Scale</option>
                                    <option value="detection-scale">Detection(D)Scale</option>
                                </select>



                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="search">
                                    Manufacturer <span class="text-danger"></span>
                                </label>
                                <input type="text" name="manufacturer">
                            </div>
                        </div>

                        <div class="group-input">
                            <label for="audit-agenda-grid">
                                Product/Material
                                <button type="button" name="product_material" id="Product_Material">+</button>
                                <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                    (Launch Instruction)
                                </span>
                            </label>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="Product_Material_details" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 4%">Row#</th>
                                            <th style="width: 12%">Product Name</th>
                                            <th style="width: 16%">Batch Number</th>
                                            <th style="width: 16%">Expiry Date</th>
                                            <th style="width: 16%">Manufactured Date</th>
                                            <th style="width: 16%">Disposition</th>
                                            <th style="width: 10%">Comment</th>
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
                                        <td><input type="text" name="product_material[0][Comment]"></td>
                                        <td><input type="text" name="product_material[0][Remarks]"></td>
                                        <td><button type="text" class="removeRowBtn">Remove</button></td>
                                    </tbody>

                                </table>
                            </div>
                        </div>

                        <div class="col-lg-6  new-date-data-field">
                            <div class="group-input input-date">
                                <label for="date_sent">Date Sent</lable>
                                    <div class="calenderauditee">
                                        <input type="text" id="date_sent" placeholder="DD-MMM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="date_sent" name="date_sent" class="hide-input" oninput="handleDateInput(this, 'date_sent');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>


                            </div>
                        </div>

                        <div class="col-lg-6  new-date-data-field">
                            <div class="group-input input-date">
                                <label for="date_returned">Date Returned</lable>
                                    <div class="calenderauditee">
                                        <input type="text" id="date_returned" placeholder="DD-MMM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="date_returned" name="date_returned" class="hide-input" oninput="handleDateInput(this, 'date_returned');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="group-input">
                                <label for="followUp">Follow Up</label>
                                <textarea name="follow_up"></textarea>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="group-input">
                                <label for="summary">Summary</label>
                                <textarea name="summary"></textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="group-input">
                                <label for="Comments">Comments</label>
                                <textarea name="Comments"></textarea>
                            </div>
                        </div>


                        {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="Support_doc">Supporting Documents</label>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Support_doc"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Support_doc[]"
                                                    oninput="addMultipleFiles(this, 'Support_doc')" multiple>
                                            </div>
                                        </div>

                                    </div>
                                </div> --}}
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
            <!--
            <div id="CCForm4" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="row">
                        <div class="sub-head">Action Approval</div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="qa_comments">QA Review Comments</label>
                                <textarea name="qa_comments"></textarea>
                            </div>
                        </div>
                        {{--
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="file_attach">Final Attachments</label>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="final_attach"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="final_attach[]"
                                                    oninput="addMultipleFiles(this, 'final_attach')" multiple>
                                            </div>
                                        </div>

                                    </div>
                                </div> --}}
                        <div class="col-12 sub-head">
                            Extension Justification
                        </div>

                        <div class="col-12">
                            <div class="group-input">
                                <label for="due-dateextension">Due Date Extension Justification</label>
                                <textarea name="due_date_extension"></textarea>
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
            </div> -->

            <div id="CCForm4" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Actual_Amount ">Closed By :</label>
                                    <div class="date"></div>

                                </div>
                            </div>
                            <div class="col-6 pb-3">
                                <div class="group-input">

                                    <label for="Division Code"><b>Closed On :</b></label>
                                    <div class="date"></div>



                                </div>
                            </div>





                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>

                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                    Exit </a> </button>
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
    $(document).on('click', '.removeRowBtn', function() {
        $(this).closest('tr').remove();
    })
</script>

<script>
    var maxLength = 255;
    $('#docname').keyup(function() {
        var textlen = maxLength - $(this).val().length;
        $('#rchars').text(textlen);
    });
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
        siteSelect = document.querySelector('.siteName'),
        buildingSelect = document.querySelector('.building'),
        floorSelect = document.querySelector('.floor'),
        roomSelect = document.querySelector('.room');

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
                    option.value = city.id;
                    option.textContent = city.name;
                    citySelect.appendChild(option);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading cities:', error);
            }
        });
    }

    //function loadSites() {
    //        siteSelect.disabled = false;
    //        siteSelect.innerHTML = '<option value="">Select Site</option>';

    //        const selectedCountryCode = countrySelect.value;
    //        const selectedStateCode = stateSelect.value;
    //        const selectedCityId = citySelect.value;

    //        $.ajax({
    //            url: `${config.cUrl}/countries/${selectedCountryCode}/states/${selectedStateCode}/cities/${selectedCityId}/sites`, // Your endpoint to get sites by city ID
    //            headers: {
    //            "X-CSCAPI-KEY": config.ckey
    //        },
    //            success: function(data) {
    //                data.forEach(site => {
    //                    const option = document.createElement('option');
    //                    option.value = site.id;
    //                    option.textContent = site.name;
    //                    siteSelect.appendChild(option);
    //                });
    //            },
    //            error: function(xhr, status, error) {
    //                console.error('Error loading sites:', error);
    //            }
    //        });
    //    }

    //    function loadBuildings() {
    //        buildingSelect.disabled = false;
    //        buildingSelect.innerHTML = '<option value="">Select Building</option>';

    //        const selectedCountryCode = countrySelect.value;
    //        const selectedStateCode = stateSelect.value;
    //        const selectedCityId = citySelect.value;
    //        const selectedSiteId = siteSelect.value;

    //        $.ajax({
    //            url: `${config.cUrl}/countries/${selectedCountryCode}/states/${selectedStateCode}/cities/${selectedCityId}/sites/${selectedSiteId}/buildings`, // Your endpoint to get buildings by site ID
    //            headers: {
    //            "X-CSCAPI-KEY": config.ckey
    //        },
    //            success: function(data) {
    //                data.forEach(building => {
    //                    const option = document.createElement('option');
    //                    option.value = building.id;
    //                    option.textContent = building.name;
    //                    buildingSelect.appendChild(option);
    //                });
    //            },
    //            error: function(xhr, status, error) {
    //                console.error('Error loading buildings:', error);
    //            }
    //        });
    //    }

    //    function loadFloors() {
    //        floorSelect.disabled = false;
    //        floorSelect.innerHTML = '<option value="">Select Floor</option>';

    //        const selectedCountryCode = countrySelect.value;
    //        const selectedStateCode = stateSelect.value;
    //        const selectedCityId = citySelect.value;
    //        const selectedSiteId = siteSelect.value;
    //        const selectedBuildingId = buildingSelect.value;

    //        $.ajax({
    //            url: `${config.cUrl}/countries/${selectedCountryCode}/states/${selectedStateCode}/cities/${selectedCityId}/sites/${selectedSiteId}/buildings/${selectedBuildingId}/floors`, // Your endpoint to get floors by building ID
    //            headers: {
    //            "X-CSCAPI-KEY": config.ckey
    //        },
    //            success: function(data) {
    //                data.forEach(floor => {
    //                    const option = document.createElement('option');
    //                    option.value = floor.id;
    //                    option.textContent = floor.name;
    //                    floorSelect.appendChild(option);
    //                });
    //            },
    //            error: function(xhr, status, error) {
    //                console.error('Error loading floors:', error);
    //            }
    //        });
    //    }

    //    function loadRooms() {
    //        roomSelect.disabled = false;
    //        roomSelect.innerHTML = '<option value="">Select Room</option>';

    //        const selectedCountryCode = countrySelect.value;
    //        const selectedStateCode = stateSelect.value;
    //        const selectedCityId = citySelect.value;
    //        const selectedSiteId = siteSelect.value;
    //        const selectedBuildingId = buildingSelect.value;
    //        const selectedFloorId = floorSelect.value;

    //        $.ajax({
    //            url: `${config.cUrl}/countries/${selectedCountryCode}/states/${selectedStateCode}/cities/${selectedCityId}/sites/${selectedSiteId}/buildings/${selectedBuildingId}/floors/${selectedFloorId}/rooms`, // Your endpoint to get rooms by floor ID
    //            headers: {
    //            "X-CSCAPI-KEY": config.ckey
    //        },
    //            success: function(data) {
    //                data.forEach(room => {
    //                    const option = document.createElement('option');
    //                    option.value = room.id;
    //                    option.textContent = room.name;
    //                    roomSelect.appendChild(option);
    //                });
    //            },
    //            error: function(xhr, status, error) {
    //                console.error('Error loading rooms:', error);
    //            }
    //        });
    //    }

    $(document).ready(function() {
        loadCountries();
    });
</script>
{{--Country Statecity API End--}}


@endsection
