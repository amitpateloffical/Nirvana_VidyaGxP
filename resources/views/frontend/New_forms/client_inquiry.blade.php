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


    @php
        $users = DB::table('users')->select('id', 'name')->get();
    @endphp



    <div class="form-field-head">
        {{-- <div class="pr-id">
            New Child
        </div> --}}
        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName(session()->get('division')) }} / Client Inquiry
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#test').click(function(e) {
                function generateTableRow(serialNumber) {


                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="Question[]"></td>' +
                        ' <td><input type="text" name="Answer[]"></td>' +
                        '<td><input type="text" name="Result[]"></td>' +
                        '<td><input type="text" name="Comment[]"></td>' +


                        '</tr>';

                    // for (var i = 0; i < users.length; i++) {
                    //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    // }

                    // html += '</select></td>' + 

                    //     '</tr>';

                    return html;
                }

                var tableBody = $('#test-first-table tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#tests').click(function(e) {
                function generateTableRow(serialNumber) {


                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="Question[]"></td>' +
                        ' <td><input type="text" name="Answer[]"></td>' +
                        '<td><input type="text" name="Result[]"></td>' +
                        '<td><input type="text" name="Comment[]"></td>' +


                        '</tr>';

                    // for (var i = 0; i < users.length; i++) {
                    //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    // }

                    // html += '</select></td>' + 

                    //     '</tr>';

                    return html;
                }

                var tableBody = $('#tests-first-table tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#survey').click(function(e) {
                function generateTableRow(serialNumber) {


                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '   <td><input type="text" name="Subject[]"></td>' +
                        '<td><input type="text" name="Topic[]"></td>' +
                        '<td><input type="text" name="Rating[]"></td>' +
                        '<td><input type="text" name="Comment[]"></td>' +


                        '</tr>';

                    // for (var i = 0; i < users.length; i++) {
                    //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    // }

                    // html += '</select></td>' + 

                    //     '</tr>';

                    return html;
                }

                var tableBody = $('#survey-first-table tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#product_material').click(function(e) {
                function generateTableRow(serialNumber) {


                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="product_material[0][Product_name]"></td>' +
                        '<td><input type="text" name="product_material[0][Batch_number]"></td>' +
                        '<td><input type="text" name="product_material[0][Expiry_date]"></td>' +
                        '<td><input type="text" name="product_material[0][Manufactured_date]"></td>' +
                        '<td><input type="text" name="product_material[0][disposition]"></td>' +
                        '<td><input type="text" name="product_material[0][Comment]"></td>' +
                        '<td><button type="text" class="removeRowBtn">remove</button></td>' +


                        '</tr>';

                    // for (var i = 0; i < users.length; i++) {
                    //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    // }

                    // html += '</select></td>' + 

                    //     '</tr>';

                    return html;
                }

                var tableBody = $('#product_material-first-table tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>

    <script>
        $(document).on('click', '.removeRowBtn', function() {
            $(this).closest('tr').remove();
        })
    </script>

    <script>
        $(document).ready(function() {
            $('#Equipment').click(function(e) {
                function generateTableRow(serialNumber) {


                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
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
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Client Inquiry</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Inquiry Details</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Signature</button>

            </div>

            <form action="{{ route('client_inquiry_store') }}" method="POST" enctype="multipart/form-data">
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
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" name="record_number"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/CI/{{ date('Y') }}/{{ $record_number }}">
                                        {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Site/Location Code</b></label>
                                        <input disabled type="text" name="division_code"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                        <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                        {{-- <div class="static">QMS-North America</div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="originator">Originator</label>
                                        <input disabled type="text" name="originator" value="{{ Auth::user()->name }}" />
                                    </div>
                                </div>

                                {{-- <div class="col-lg-6">
                                    <div class="group-input ">
                                        <label for="Date Due"><b>Date Opened</b></label>
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                    </div>
                                </div> --}}

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Opened">Date Opened</label>
                                        @if (isset($data) && $data->intiation_date)
                                            <input disabled type="text"
                                                value="{{ \Carbon\Carbon::parse($data->intiation_date)->format('d-M-Y') }}"
                                                name="intiation_date_display">
                                            <input type="hidden" value="{{ $data->intiation_date }}"
                                                name="intiation_date">
                                        @else
                                            <input disabled type="text" value="{{ date('d-M-Y') }}"
                                                name="intiation_date_display">
                                            <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                        @endif
                                    </div>
                                </div>

                                {{-- <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Initiator Group Code">Short Description</label>
                                    <input type="text" name="short_description" id="initiator_group_code" value="">
                                </div>
                            </div> --}}
                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span
                                            id="initiator_group_code">255</span>
                                        characters remaining
                                        <input id="initiator_group_code" type="text" name="short_description"
                                            maxlength="255" required>
                                    </div>
                                </div> --}}
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars">255</span>
                                        characters remaining
                                        <input id="docname" type="text" value="" name="short_description"
                                            maxlength="255" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="If Others">Assigned To</label>
                                        <select name="assigned_to" onchange="">

                                            <option value="">Select a value</option>
                                            @if ($users->isNotEmpty())
                                                @foreach ($users as $value)
                                                    <option value='{{ $value->name }}'>{{ $value->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>


                                {{-- <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Due Date">Date Due</label>

                                        <div class="calenderauditee">

                                            <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY"
                                                value="" />

                                            <input type="date" name="due_date"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'due_date')" />
                                        </div>


                                    </div>
                                </div> --}}
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Due Date"> Due Date </label>
                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY"
                                            value="{{ \Carbon\Carbon::parse($due_date)->format('d-M-Y') }}" />
                                        <input type="hidden" name="due_date" id="due_date_input"
                                            value="{{ $due_date }}" />

                                        {{-- <input type="hidden" value="{{ $due_date }}" name="due_date">
                                        <input disabled type="text" value="{{ Helpers::getdateFormat($due_date) }}"> --}}
                                        {{-- <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            value="" name="due_date"> --}}
                                    </div>

                                </div>

                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Customer Name">Customer Name</label>
                                        <select name="Customer_Name" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="Customer 1">Customer 1</option>
                                            <option value="Customer 1">Customer 1</option>

                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="If Others">Customer Name</label>
                                        <select name="Customer_Name" onchange="">

                                            <option value="">Select a value</option>
                                            @if ($users->isNotEmpty())
                                                @foreach ($users as $value)
                                                    <option value='{{ $value->name }}'>{{ $value->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                {{-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Submitted By">Submitted By</label>
                                    <select name="Submitted_By" onchange="">
                                        <option value="">-- select --</option>
                                        <option value=""></option>

                                    </select>
                                </div>
                            </div> --}}
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="If Others">Submitted By</label>
                                        <select name="Submit_By" onchange="">

                                            <option value="">Select a value</option>
                                            @if ($users->isNotEmpty())
                                                @foreach ($users as $value)
                                                    <option value='{{ $value->name }}'>{{ $value->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description">Description</label>
                                            <textarea name="Description" id="Description" value=""></textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Zone">Zone</label>
                                            <select name="zone">
                                                <option value="">Enter Your Selection Here</option>
                                                <option value="Asia">Asia</option>
                                                <option value="Europe">Europe</option>
                                                <option value="Africa">Africa</option>
                                                <option value="Central America">Central America</option>
                                                <option value="South America">South America</option>
                                                <option value="Oceania">Oceania</option>
                                                <option value="North America">North America</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Country">Country</label>
                                            <select name="country" class="form-select country"
                                                aria-label="Default select example" onchange="loadStates()">
                                                <option selected>Select Country</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="State/District">State</label>
                                            <select name="state" class="form-select state"
                                                aria-label="Default select example" onchange="loadCities()">
                                                <option selected>Select State/District</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="City">City</label>
                                            <select name="city" class="form-select city"
                                                aria-label="Default select example">
                                                <option selected>Select City</option>
                                            </select>
                                        </div>
                                    </div>



                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Type">Type</label>
                                            <select name="type" onchange="">
                                                <option value="">-- select --</option>
                                                <option value="Type A">Type A</option>
                                                <option value="Type B">Type B</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Priority Level">Priority Level</label>
                                            <select name="priority_level" onchange="">
                                                <option value="">-- select --</option>
                                                <option value="Priority Leve A">Priority Level A</option>
                                                <option value="Priority Level B">Priority Level B</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="group-input">
                                            <div class="why-why-chart">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 5%;">Sr.No.</th>
                                                            <th style="width: 30%;">Question</th>
                                                            <th>Response</th>
                                                            <th>Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1.</td>
                                                            <td style="background: #DCD8D8">
                                                                <textarea name="question_1"></textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="response_1"></textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="remark_1"></textarea>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>2.</td>
                                                            <td style="background: #DCD8D8">
                                                                <textarea name="question_2"></textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="response_2"></textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="remark_2"></textarea>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>3.</td>
                                                            <td style="background: #DCD8D8">
                                                                <textarea name="question_3"></textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="response_3"></textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="remark_3"></textarea>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>4.</td>
                                                            <td style="background: #DCD8D8">
                                                                <textarea name="question_4"></textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="response_4"></textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="remark_4"></textarea>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>5.</td>
                                                            <td style="background: #DCD8D8">
                                                                <textarea name="question_5"></textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="response_5"></textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="remark_5"></textarea>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="File Attachments">File Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        {{-- <input type="file" id="myfile" name="Initial_Attachment"> 
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="file_Attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="file_Attachment[]"
                                                    oninput="addMultipleFiles(this, 'file_Attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  --}}
                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="File Attachments">File Attachments</label>
                                            <div>
                                                <small class="text-primary">Please Attach all relevant or supporting
                                                    documents</small>
                                            </div>
                                            {{-- <input type="file" id="myfile" name="file_Attachment" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} value="{{ $data->file_Attachment }}"> --}}
                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="file_Attachment"></div>
                                                <div class="add-btn">
                                                    <div>Add</div>
                                                    <input type="file" id="myfile" name="file_Attachment[]"
                                                        oninput="addMultipleFiles(this, 'file_Attachment')" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Related URLs">Related URLs</label>
                                            <select name="Related_URLs" onchange="">
                                                <option value="">-- select --</option>
                                                <option value="Related URLs 1">Related URLs 1</option>
                                                <option value="Related URLs 2">Related URLs 2</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="sub-head">Product Details</div>


                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Product Type">Product Type</label>
                                            <select name="Product_Type" onchange="">
                                                <option value="">-- select --</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Manufacturer">Manufacturer</label>
                                            <select name="Manufacturer" onchange="">
                                                <option value="">-- select --</option>
                                                <option value="Manufacturer 1">Manufacturer 1</option>
                                                <option value="Manufacturer 2">Manufacturer 2</option>

                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="root_cause">
                                                Product/Material(0)
                                                <button type="button" onclick="" id="product_material">+</button>
                                                <span class="text-primary" data-bs-toggle="modal"
                                                    data-bs-target="#document-details-field-instruction-modal"
                                                    style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                    (Launch Instruction)
                                                </span>
                                            </label>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="product_material-first-table">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 60px;">Row #</th>
                                                            <th>Product Name</th>
                                                            <th>Batch Number</th>
                                                            <th>Expiry Date</th>
                                                            <th>Manufactured Date</th>
                                                            <th>Disposition</th>
                                                            <th>Comment</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <td><input disabled type="text"
                                                                name="product_material[0][serial_number]" value="1">
                                                        </td>
                                                        <td><input type="text"
                                                                name="product_material[0][Product_name]"></td>
                                                        <td><input type="text"
                                                                name="product_material[0][Batch_number]"></td>
                                                        <td><input type="text" name="product_material[0][Expiry_date]">
                                                        </td>
                                                        <td><input type="text"
                                                                name="product_material[0][Manufactured_date]"></td>
                                                        <td><input type="text" name="product_material[0][disposition]">
                                                        </td>
                                                        <td><input type="text" name="product_material[0][Comment]">
                                                        </td>
                                                        <td><button type="text" class="removeRowBtn">remove</button>
                                                        </td>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-block">

                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a class="text-white"
                                                href="{{ url('rcms/qms-dashboard') }}">Exit
                                            </a> </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head col-12">Inquiry Details</div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Supervisor">Supervisor</label>
                                        <input type="text" name="Supervisor" id="Supervisor"value="">
                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Inquiry Date">Inquiry Date</label>

                                        <div class="calenderauditee">
                                            <input type="text" id="Inquiry_ate" readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="Inquiry_ate"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="" />
                                        </div>


                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Inquiry Source">Inquiry Source</label>
                                        <select name="Inquiry_Source" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="Source 1">Source 1</option>
                                            <option value="Source 2">Source 2</option>

                                        </select>
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Inquiry Method">Inquiry Method</label>
                                        <select name="Inquiry_method" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="Method 1">Method 1</option>
                                            <option value="Method 2">Method 2</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Branch">Branch</label>
                                        <select name="branch" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="Indore">Indore</option>
                                            <option value="Jabalpure">Jabalpure</option>
                                            <option value="Bhopal">Bhopal</option>
                                            <option value="Dewas">Dewas</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Branch Manager">Branch Manager</label>
                                        <select name="Branch_manager" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="Manager 1">Manager 1</option>
                                            <option value="Manager 2">Manager 2</option>
                                            <option value="Manager 3">Manager 3</option>

                                        </select>
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="If Others">Customer Name</label>
                                        <select name="Customer_names" onchange="">

                                            <option value="">Select a value</option>
                                            @if ($users->isNotEmpty())
                                                @foreach ($users as $value)
                                                    <option value='{{ $value->name }}'>{{ $value->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Business Area">Business Area</label>
                                        <select name="Business_area" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="Area 1">Area 1</option>
                                            <option value="Area 2">Area 2</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Account Type">Account Type</label>
                                        <select name="account_type" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="Saving">Saving</option>
                                            <option value="Current">Current</option>
                                            <option value="International">International</option>


                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Account Number">Account Number</label>
                                        <select multiple id="account_number" name="" id="">
                                            <option value="">--Select---</option>
                                            <option value="09876543">09876543</option>
                                            <option value="12345678">12345678</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Dispute Amount">Dispute Amount</label>
                                        <select name="dispute_amount" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="Amount 1">Amount 1</option>
                                            <option value="Amount 2">Amount 2</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Currency">Currency</label>
                                        <select name="currency" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="rupee ⟨₹⟩">rupee ⟨₹⟩</option>
                                            <option value="United States Dollar	$">United States Dollar $</option>
                                            <option value="Euro	€">Euro €</option>
                                            <option value="British Pound £">British Pound £</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Category">Category</label>
                                        <select name="category" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="Category 1">Category 1</option>
                                            <option value="Category 2">Category 2</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sub Category">Sub Category</label>
                                        <select name="sub_category" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="Sub Category 1">Sub Category 1</option>
                                            <option value="Sub Category 2">Sub Category 2</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="Allegation language">Allegation language</label>
                                        <textarea class="" name="allegation_language" id="">
                                    </textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="Action Taken">Action Taken</label>
                                        <textarea class="" name="action_taken" id="">
                                    </textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Broker Id">Broker Id</label>
                                        <input type="text" name="broker_id" id="broker_id" value="">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Related Inquiries">Related Inquiries</label>
                                        <select name="related_inquiries" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="Inquiries 1">Inquiries 1</option>
                                            <option value="Inquiries 2">Inquiries 2</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="sub-head">Problem Details</div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Problem Name">Problem Name</label>
                                        <input type="text" name="problem_name" id="problem_name" value="">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Problem Type">Problem Type</label>
                                        <select name="problem_type" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="Type 1">Type 1</option>
                                            <option value="Type 2">Type 2</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Problem Code">Problem Code</label>
                                        <select name="problem_code" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="Code 101">Code 101</option>
                                            <option value="Code 102">Code 102</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="Comments">Comments</label>
                                        <textarea class="" name="comments" id="comments">
                                    </textarea>
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
                                Signature
                            </div>
                            <div class="row">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Submited By">Submited By</label>

                                        </div>
                                    </div>
                                    <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Submited">Submited on </label>

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Cancel By">Cancel By</label>

                                        </div>
                                    </div>
                                    <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Cancel">Cancel on </label>

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Simple Resolution by">Simple Resolution by</label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Simple Resolution on"> Simple Resolution on </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Legal Issue Relations/Operational Issue by">Legal Issue
                                                Relations/Operational Issue by</label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Legal Issue Relations/Operational Issue on"> Legal Issue
                                                Relations/Operational Issue on </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Relations/Operational Issue by">Relations/Operational Issue
                                                by</label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Relations/Operational Issue on"> Relations/Operational Issue on
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Completed By">Completed By</label>

                                        </div>
                                    </div>
                                    <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Completedon">Completed on </label>

                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Resolution by">Resolution by</label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Resolution on"> Resolution on </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Resolution By">Resolution By</label>

                                        </div>
                                    </div>
                                    <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Resolution">Resolution on </label>

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="No Analysis Required By">No Analysis Required By</label>

                                        </div>
                                    </div>
                                    <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="No Analysis Required">No Analysis Required on </label>

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Analysis Complete By">Analysis Complete By</label>

                                        </div>
                                    </div>
                                    <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Analysis Complete">Analysis Complete on </label>

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Pending Action Completion By">Pending Action Completion By</label>

                                        </div>
                                    </div>
                                    <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Pending Action Completion">Pending Action Completion on </label>

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Reject By">Reject By</label>

                                        </div>
                                    </div>
                                    <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Reject">Reject on </label>

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Approve By">Approve By</label>

                                        </div>
                                    </div>
                                    <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Approve">Approve on </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="button-block">
                                    {{-- <button type="submit" class="saveButton">Save</button> --}}
                                    <button type="button" class="backButton" onclick="previousStep()">Back</button>

                                    <button type="button"> <a class="text-white"
                                            href="{{ url('rcms/qms-dashboard') }}">Exit
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
        function addMultipleFiles(input, listId) {
            const fileList = document.getElementById(listId);
            fileList.innerHTML = ""; // Clear the list
            Array.from(input.files).forEach(file => {
                const listItem = document.createElement('div');
                listItem.className = 'file-item';
                listItem.textContent = file.name;
                fileList.appendChild(listItem);
            });
        }
    </script>

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
        $(document).ready(function() {
            loadCountries();
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
        var maxLength = 255;
        $('#docname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);
        });
    </script>
@endsection
