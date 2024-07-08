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
            {{ Helpers::getDivisionName(session()->get('division')) }} / CTMS_Monitoring Visit
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#Monitor_Information').click(function(e) {
                e.preventDefault();

                function generateTableRow(serialNumber) {
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="Monitor_Information_details[' +
                        serialNumber + '][serial]" value="' + serialNumber +
                        '"></td>' +
                        '<td>' +
                        '<div class="new-date-data-field">' +
                        '<div class="group-input input-date">' +
                        '<div class="calenderauditee">' +
                        '<input class="click_date" id="date_' + serialNumber +
                        '_Date" type="text" name="Monitor_Information_details[' + serialNumber +
                        '][Date]" placeholder="DD-MMM-YYYY" readonly />' +
                        '<input type="date" name="Monitor_Information_details[' + serialNumber +
                        '][Date]" min="" id="closed_input_' +
                        serialNumber +
                        '" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" onchange="handleDateInput(this, \'date_' +
                        serialNumber + '_Date\')">' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '<td><input type="text" name="Monitor_Information_details[' + serialNumber +
                        '][Responsible]"></td>' +
                        '<td><input type="text" name="Monitor_Information_details[' + serialNumber +
                        '][Item_Description]"></td>' +
                        '<td>' +
                        '<div class="new-date-data-field">' +
                        '<div class="group-input input-date">' +
                        '<div class="calenderauditee">' +
                        '<input class="click_date" id="date_' + serialNumber +
                        '_Sent_Date" type="text" name="Monitor_Information_details[' + serialNumber +
                        '][Sent_Date]" placeholder="DD-MMM-YYYY" readonly />' +
                        '<input type="date" name="Monitor_Information_details[' + serialNumber +
                        '][Sent_Date]" min="" id="closed_input_' +
                        serialNumber +
                        '" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" onchange="handleDateInput(this, \'date_' +
                        serialNumber + '_Sent_Date\')">' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '<td>' +
                        '<div class="new-date-data-field">' +
                        '<div class="group-input input-date">' +
                        '<div class="calenderauditee">' +
                        '<input class="click_date" id="date_' + serialNumber +
                        '_Return_Date" type="text" name="Monitor_Information_details[' + serialNumber +
                        '][Return_Date]" placeholder="DD-MMM-YYYY" readonly />' +
                        '<input type="date" name="Monitor_Information_details[' + serialNumber +
                        '][Return_Date]" min="" id="closed_input_' +
                        serialNumber +
                        '" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" onchange="handleDateInput(this, \'date_' +
                        serialNumber + '_Return_Date\')">' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '<td><input type="text" name="Monitor_Information_details[' + serialNumber +
                        '][Comments]"></td>' +
                        '<td><input type="text" name="Monitor_Information_details[' + serialNumber +
                        '][Remarks]"></td>' +

                        '<td><button type="text" class="removeBtnMI">remove</button></td>' +

                        '</tr>';

                    return html;
                }

                var tableBody = $('#Monitor_Information_details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);

                // Reattach date picker event listeners for newly added rows
                $('.click_date').off('click').on('click', function() {
                    $(this).siblings('.show_date').click();
                });
            });

            // Attach date picker event listeners for the initial row
            $('.click_date').off('click').on('click', function() {
                $(this).siblings('.show_date').click();
            });
        });

        function handleDateInput(input, displayId) {
            var dateValue = input.value;
            var displayInput = document.getElementById(displayId);
            if (displayInput) {
                displayInput.value = dateValue;
            }
        }
        $(document).on('click', '.removeBtnMI', function() {
            $(this).closest('tr').remove();
        })
    </script>
    {{-- <script>
        $(document).on('click', '.removeBtn', function() {
            $(this).closest('tr').remove();
        })
    </script> --}}


    <script>
        $(document).ready(function() {
            $('#Product_Material').click(function(e) {
                e.preventDefault();

                function generateTableRow(serialNumber) {
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="Product_Material_details[' +
                        serialNumber + '][serial]" value="' + serialNumber +
                        '"></td>' +

                        '<td><input type="text" name="Product_Material_details[' + serialNumber +
                        '][ProductName]"></td>' +
                        '<td><input type="number" name="Product_Material_details[' + serialNumber +
                        '][ReBatchNumber]"></td>' +

                        '<td>' +
                        '<div class="new-date-data-field">' +
                        '<div class="group-input input-date">' +
                        '<div class="calenderauditee">' +
                        '<input class="click_date" id="date_' + serialNumber +
                        '_ExpiryDate" type="text" name="Product_Material_details[' + serialNumber +
                        '][ExpiryDate]" placeholder="DD-MMM-YYYY" readonly />' +
                        '<input type="date" name="Product_Material_details[' + serialNumber +
                        '][ExpiryDate]" min="" id="closed_input_' +
                        serialNumber +
                        '" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" onchange="handleDateInput(this, \'date_' +
                        serialNumber + '_ExpiryDate\')">' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +

                        '<td>' +
                        '<div class="new-date-data-field">' +
                        '<div class="group-input input-date">' +
                        '<div class="calenderauditee">' +
                        '<input class="click_date" id="date_' + serialNumber +
                        '_ManufacturedDate" type="text" name="Product_Material_details[' + serialNumber +
                        '][ManufacturedDate]" placeholder="DD-MMM-YYYY" readonly />' +
                        '<input type="date" name="Product_Material_details[' + serialNumber +
                        '][ManufacturedDate]" min="" id="closed_input_' +
                        serialNumber +
                        '" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" onchange="handleDateInput(this, \'date_' +
                        serialNumber + '_ManufacturedDate\')">' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '<td><input type="text" name="Product_Material_details[' + serialNumber +
                        '][Disposition]"></td>' +
                        '<td><input type="text" name="Product_Material_details[' + serialNumber +
                        '][Comments]"></td>' +
                        '<td><input type="text" name="Product_Material_details[' + serialNumber +
                        '][Remarks]"></td>' +
                        '<td><button type="text" class="removeBtnPM">remove</button></td>' +
                        '</tr>';

                    return html;
                }

                var tableBody = $('#Product_Material_details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);

                // Reattach date picker event listeners for newly added rows
                $('.click_date').off('click').on('click', function() {
                    $(this).siblings('.show_date').click();
                });
            });

            // Attach date picker event listeners for the initial row
            $('.click_date').off('click').on('click', function() {
                $(this).siblings('.show_date').click();
            });
        });

        function handleDateInput(input, displayId) {
            var dateValue = input.value;
            var displayInput = document.getElementById(displayId);
            if (displayInput) {
                displayInput.value = dateValue;
            }
        }
        $(document).on('click', '.removeBtnPM', function() {
            $(this).closest('tr').remove();
        })
    </script>

    <script>
        $(document).ready(function() {
            $('#Equipment').click(function(e) {
                e.preventDefault();

                function generateTableRow(serialNumber) {
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="Equipment_details[' +
                        serialNumber + '][serial]" value="' + serialNumber +
                        '"></td>' +

                        '<td><input type="text" name="Equipment_details[' + serialNumber +
                        '][ProductName]"></td>' +
                        '<td><input type="number" name="Equipment_details[' + serialNumber +
                        '][BatchNumber]"></td>' +

                        '<td>' +
                        '<div class="new-date-data-field">' +
                        '<div class="group-input input-date">' +
                        '<div class="calenderauditee">' +
                        '<input class="click_date" id="date_' + serialNumber +
                        '_ExpiryDate1" type="text" name="Equipment_details[' + serialNumber +
                        '][ExpiryDate1]" placeholder="DD-MMM-YYYY" readonly />' +
                        '<input type="date" name="Equipment_details[' + serialNumber +
                        '][ExpiryDate1]" min="" id="closed_input_' +
                        serialNumber +
                        '" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" onchange="handleDateInput(this, \'date_' +
                        serialNumber + '_ExpiryDate1\')">' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +

                        '<td>' +
                        '<div class="new-date-data-field">' +
                        '<div class="group-input input-date">' +
                        '<div class="calenderauditee">' +
                        '<input class="click_date" id="date_' + serialNumber +
                        '_ManufacturedDate1" type="text" name="Equipment_details[' + serialNumber +
                        '][ManufacturedDate1]" placeholder="DD-MMM-YYYY" readonly />' +
                        '<input type="date" name="Equipment_details[' + serialNumber +
                        '][ManufacturedDate1]" min="" id="closed_input_' +
                        serialNumber +
                        '" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" onchange="handleDateInput(this, \'date_' +
                        serialNumber + '_ManufacturedDate1\')">' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '<td><input type="number" name="Equipment_details[' + serialNumber +
                        '][NumberOfItemsNeeded]"></td>' +
                        '<td><input type="text" name="Equipment_details[' + serialNumber +
                        '][Exist]"></td>' +
                        '<td><input type="text" name="Equipment_details[' + serialNumber +
                        '][Comments]"></td>' +
                        '<td><input type="text" name="Equipment_details[' + serialNumber +
                        '][Remarks]"></td>' +
                        '<td><button type="text" class="removeBtnEQ">remove</button></td>' +
                        '</tr>';

                    return html;
                }

                var tableBody = $('#Equipment_details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);

                // Reattach date picker event listeners for newly added rows
                $('.click_date').off('click').on('click', function() {
                    $(this).siblings('.show_date').click();
                });
            });

            // Attach date picker event listeners for the initial row
            $('.click_date').off('click').on('click', function() {
                $(this).siblings('.show_date').click();
            });
        });

        function handleDateInput(input, displayId) {
            var dateValue = input.value;
            var displayInput = document.getElementById(displayId);
            if (displayInput) {
                displayInput.value = dateValue;
            }
        }
        $(document).on('click', '.removeBtnEQ', function() {
            $(this).closest('tr').remove();
        })
    </script>

    {{-- <script>
        $(document).on('click', '.removeRowBtn', function() {
            $(this).closest('tr').remove();
        })
    </script> --}}

    {{-- ! ========================================= --}}
    {{-- !               DATA FIELDS                 --}}
    {{-- ! ========================================= --}}
    <div id="change-control-fields">
        <div class="container-fluid">

            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Monitoring Visit</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Monitoring Visit Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Signature</button>
            </div>

            <form action="{{ route('monitoring_visit_store') }}" method="POST" enctype="multipart/form-data">
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
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" name="record"
                                            value="Division/MV/{{ date('Y') }}/{{ $record_number }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Site/Location Code</b></label>
                                        {{-- <input readonly type="text" name="division_code" value="">
                                        <input type="hidden" name="division_id" value="{{ session()->get('division') }}"> --}}
                                        <input readonly type="text" name="division_code"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                        <input type="hidden" name="division_id" value="{{ session()->get('division') }}">

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    {{-- @if (!empty($cc->id))
                                        <input type="hidden" name="ccId" value="{{ $cc->id }}">
                                    @endif --}}
                                    <div class="group-input">
                                        <label for="Initiator">Initiator</label>
                                        <input disabled type="text" name="initiator_id"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            value="{{ Auth::user()->name }}">
                                    </div>
                                </div>

                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Opened">Date of Initiation</label>
                                        
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                    </div>
                                </div> --}}

                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Opened">Date of Initiation</label>
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
                                </div> --}}

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Opened">Date of Initiation</label>
                                        @if (isset($data) && $data->intiation_date)
                                            <input disabled type="text"
                                                value="{{ \Carbon\Carbon::parse($data->intiation_date)->format('d-M-Y') }}"
                                                name="intiation_date_display">
                                            <input type="hidden" value="{{ $data->intiation_date }}" name="intiation_date"
                                                id="initiation_date">
                                        @else
                                            <input disabled type="text" value="{{ date('d-M-Y') }}"
                                                name="intiation_date_display">
                                            <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date"
                                                id="initiation_date">
                                        @endif
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="group-input">
                                        <div class="group-input">
                                            <label for="assign_to">Assigned To</label>
                                            <select name="assign_to" onchange="">

                                                <option value="">Select a value</option>
                                                @if ($users->isNotEmpty())
                                                    @foreach ($users as $value)
                                                        <option value='{{ $value->name }}'>{{ $value->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date">Due Date <span class="text-danger"></span></label>
                                        <p class="text-primary">Please mention expected date of completion</p>
                                        <!-- <input type="date" min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}"value="" name="due_date"> -->
                                        <div class="calenderauditee">
                                            <input type="text" id="due_date" readonly placeholder="DD-MM-YYYY" />
                                            <input type="date" name="due_date" value="" class="hide-input"
                                                oninput="handleDateInput(this, 'due_date')" />
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date">Due Date <span class="text-danger"></span></label>
                                        <p class="text-primary">Please mention expected date of completion</p>
                                        <!-- <input type="date" min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}"value="" name="due_date"> -->
                                        <div class="calenderauditee">
                                            <input type="text" id="due_date_display" readonly placeholder="DD-MM-YYYY" />
                                            <input type="date" name="due_date" value="" class="hide-input"
                                                oninput="handleDateInput(this, 'due_date')" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars">255</span>
                                        characters remaining
                                        <input id="docname" type="text" name="short_description" maxlength="255"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Type <span class="text-danger"></span>
                                        </label>

                                        <select name="type" value="">
                                            <option value="0">-- Select type --</option>
                                            <option value="Other">Other
                                            </option>
                                            <option value="Training">
                                                Training</option>
                                            <option value="Finance">
                                                Finance</option>
                                            <option value="Follow Up">
                                                Follow Up</option>
                                            <option value="Marketing">
                                                Marketing</option>
                                            <option value="Sales">Sales
                                            </option>
                                            <option value="Account Service">
                                                Account Service</option>
                                            <option value=" Recent Product Launch">
                                                Recent Product Launch</option>
                                            <option value="IT">IT
                                            </option>
                                        </select>

                                        {{-- <select id="type" placeholder="Select..." name="type">
                                            <option value="">Select a value</option>
                                            <option value="type_a">Type A</option>
                                            <option value="type_b">Type B</option>
                                        </select> --}}
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="file_attach">File Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="file_attach"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="file_attach[]"
                                                    oninput="addMultipleFiles(this, 'file_attach')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Description</label>

                                        <textarea name="description"></textarea>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="comments">Comments</label>

                                        <textarea name="comments"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Source Documents <span class="text-danger"></span>
                                        </label>
                                        <select name="source_documents">
                                            <option value="">--select--</option>
                                            <option value="Source Documents 1">
                                                Source Documents
                                                1</option>
                                            <option value="Source Documents 2">
                                                Source Documents
                                                2</option>
                                            <option value="Source Documents 3">
                                                Source Documents
                                                3</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="sub-head">
                                    Location
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="zone">Zone</label>
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
                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="country">Country</label>
                                        <select name="country" class="form-select country"
                                            aria-label="Default select example" onchange="loadStates()">
                                            <option>Select Country</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="state">State</label>
                                        <select name="state" class="form-select state"
                                            aria-label="Default select example" onchange="loadCities()">
                                            <option>Select State</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="city">City</label>
                                        <select name="city" class="form-select city"
                                            aria-label="Default select example">
                                            <option>Select City</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            (Parent) Name On Site <span class="text-danger"></span>
                                        </label>
                                        <select name="name_on_site">
                                            <option value="">--select--</option>
                                            <option value="Parent Site 1">
                                                Parent Site 1
                                            </option>
                                            <option value="Parent Site 2">
                                                Parent Site 2
                                            </option>
                                            <option value="Parent Site 3">
                                                Parent Site 3
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Building <span class="text-danger"></span>
                                        </label>
                                        <select name="building">
                                            <option value="">--select--</option>
                                            <option value="Building 1">
                                                Building 1
                                            </option>
                                            <option value="Building 2">
                                                Building 2
                                            </option>
                                            <option value="Building 3">
                                                Building 3
                                            </option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Floor <span class="text-danger"></span>
                                        </label>
                                        <select name="floor">
                                            <option value="">--select--</option>
                                            <option value="Floor 1">Floor
                                                1</option>
                                            <option value="Floor 2">Floor
                                                2</option>
                                            <option value="Floor 3">Floor
                                                3</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Room <span class="text-danger"></span>
                                        </label>
                                        <select name="room">
                                            <option value="">--select--</option>
                                            <option value="Room 1">Room 1
                                            </option>
                                            <option value="Room 2">Room 2
                                            </option>
                                            <option value="Room 3">Room 3
                                            </option>
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
                                <div class="sub-head col-12">Monitoring Visit Information</div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Site <span class="text-danger"></span>
                                        </label>
                                        <select name="site">
                                            <option value="">--select--</option>
                                            <option value="Site 1">Site 1
                                            </option>
                                            <option value="Site 2">Site 2
                                            </option>
                                            <option value="Site 3">Site 3
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Site Contact <span class="text-danger"></span>
                                        </label>
                                        <select name="site_contact">
                                            <option value="">--select--</option>
                                            <option value="Site Contact 1">
                                                Site Contact 1
                                            </option>
                                            <option value="Site Contact 2">
                                                Site Contact 2
                                            </option>
                                            <option value="Site Contact 3">
                                                Site Contact 3
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Lead Investigator <span class="text-danger"></span>
                                        </label>
                                        <select name="lead_investigator">
                                            <option value="">--select--</option>
                                            <option value="Lead Investigator 1">
                                                Lead Investigator 1</option>
                                            <option value="Lead Investigator 2">
                                                Lead Investigator 2</option>
                                            <option value="Lead Investigator 3">
                                                Lead Investigator 3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Manufacturer <span class="text-danger"></span>
                                        </label>
                                        <select name="manufacturer">
                                            <option value="">--select--</option>
                                            <option value="Manufacturer 1">
                                                Manufacturer 1
                                            </option>
                                            <option value="Manufacturer 2">
                                                Manufacturer 2
                                            </option>
                                            <option value="Manufacturer 3">
                                                Manufacturer 3
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="group-input">
                                    <label for="Monitor_Information_grid">
                                        Monitoring Information
                                        <button type="button" name="monitor_information"
                                            id="Monitor_Information">+</button>
                                        <span class="text-primary" data-bs-toggle="modal"
                                            data-bs-target="#observation-field-instruction-modal"
                                            style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="Monitor_Information_details">
                                            <thead>
                                                <tr>
                                                    <th style="width: 4%">Row#</th>
                                                    <th style="width: 12%">Date</th>
                                                    <th style="width: 13%"> Responsible</th>
                                                    <th style="width: 13%"> Item Description</th>
                                                    <th style="width: 13%"> Sent Date</th>
                                                    <th style="width: 13%"> Return Date</th>
                                                    <th style="width: 13%"> Comments</th>
                                                    <th style="width: 13%"> Remarks</th>
                                                    <th style="width: 6%"> Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <td><input disabled type="text"
                                                        name="Monitor_Information_details[0][serial]" value="1">
                                                </td>
                                                <td>
                                                    <div class="new-date-data-field">
                                                        <div class="group-input input-date">
                                                            <div class="calenderauditee">
                                                                <input class="click_date" id="Date" type="text"
                                                                    name="Monitor_Information_details[0][Date]"
                                                                    placeholder="DD-MMM-YYYY" />
                                                                <input type="date"
                                                                    name="Monitor_Information_details[0][Date]"
                                                                    min="" id="Date"
                                                                    class="hide-input show_date"
                                                                    style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                    oninput="handleDateInput(this, 'Date')" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><input type="text"
                                                        name="Monitor_Information_details[0][Responsible]"></td>
                                                <td><input type="text"
                                                        name="Monitor_Information_details[0][Item_Description]">
                                                </td>

                                                <td>
                                                    <div class="new-date-data-field">
                                                        <div class="group-input input-date">
                                                            <div class="calenderauditee">
                                                                <input class="click_date" id="Sent_Date" type="text"
                                                                    name="Monitor_Information_details[0][Sent_Date]"
                                                                    placeholder="DD-MMM-YYYY" />
                                                                <input type="date"
                                                                    name="Monitor_Information_details[0][Sent_Date]"
                                                                    min="" id="Sent_Date"
                                                                    class="hide-input show_date"
                                                                    style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                    oninput="handleDateInput(this, 'Sent_Date')" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="new-date-data-field">
                                                        <div class="group-input input-date">
                                                            <div class="calenderauditee">
                                                                <input class="click_date" id="Return_Date" type="text"
                                                                    name="Monitor_Information_details[0][Return_Date]"
                                                                    placeholder="DD-MMM-YYYY" />
                                                                <input type="date"
                                                                    name="Monitor_Information_details[0][Return_Date]"
                                                                    min="" id="Return_Date"
                                                                    class="hide-input show_date"
                                                                    style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                    oninput="handleDateInput(this, 'Return_Date')" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td><input type="text" name="Monitor_Information_details[0][Comments]">
                                                </td>
                                                <td><input type="text" name="Monitor_Information_details[0][Remarks]">
                                                </td>

                                                <td><button type="text" class="removeBtnMI">remove</button>
                                                </td>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>

                                <div class="group-input">
                                    <label for="Product_Material_grid">
                                        Product/Material
                                        <button type="button" name="product_material" id="Product_Material">+</button>
                                        <span class="text-primary" data-bs-toggle="modal"
                                            data-bs-target="#observation-field-instruction-modal"
                                            style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="Product_Material_details">
                                            <thead>
                                                <tr>
                                                    <th style="width: 4%">Row#</th>
                                                    <th style="width: 12%">Product Name</th>
                                                    <th style="width: 13%"> ReBatch Number</th>
                                                    <th style="width: 13%"> Expiry Date</th>
                                                    <th style="width: 13%"> Manufactured Date</th>
                                                    <th style="width: 13%"> Disposition</th>
                                                    <th style="width: 13%"> Comment</th>
                                                    <th style="width: 13%"> Remarks</th>
                                                    <th style="width: 6%"> Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <td><input disabled type="text"
                                                        name="Product_Material_details[0][serial]" value="1">
                                                </td>
                                                <td><input type="text" name="Product_Material_details[0][ProductName]">
                                                </td>
                                                <td><input type="number"
                                                        name="Product_Material_details[0][ReBatchNumber]">
                                                </td>
                                                <td>
                                                    <div class="new-date-data-field">
                                                        <div class="group-input input-date">
                                                            <div class="calenderauditee">
                                                                <input class="click_date" id="ExpiryDate" type="text"
                                                                    name="Product_Material_details[0][ExpiryDate]"
                                                                    placeholder="DD-MMM-YYYY" />
                                                                <input type="date"
                                                                    name="Product_Material_details[0][ExpiryDate]"
                                                                    min="" id="ExpiryDate"
                                                                    class="hide-input show_date"
                                                                    style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                    oninput="handleDateInput(this, 'ExpiryDate')" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="new-date-data-field">
                                                        <div class="group-input input-date">
                                                            <div class="calenderauditee">
                                                                <input class="click_date" id="ManufacturedDate"
                                                                    type="text"
                                                                    name="Product_Material_details[0][ManufacturedDate]"
                                                                    placeholder="DD-MMM-YYYY" />
                                                                <input type="date"
                                                                    name="Product_Material_details[0][ManufacturedDate]"
                                                                    min="" id="ManufacturedDate"
                                                                    class="hide-input show_date"
                                                                    style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                    oninput="handleDateInput(this, 'ManufacturedDate')" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="Product_Material_details[0][Disposition]">
                                                </td>


                                                <td><input type="text" name="Product_Material_details[0][Comments]">
                                                </td>
                                                <td><input type="text" name="Product_Material_details[0][Remarks]">
                                                </td>
                                                <td><button type="text" class="removeBtnPM">remove</button>
                                                </td>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>

                                <div class="col-6">

                                    <div class="group-input">
                                        <label for="search">
                                            Additional Investigators <span class="text-danger"></span>
                                        </label>
                                        <select name="additional_investigators">
                                            <option value="">--select--</option>
                                            <option value="Additional Investigators 1">
                                                Additional Investigators 1
                                            </option>
                                            <option value="Additional Investigators 2">
                                                Additional Investigators 2
                                            </option>
                                            <option value="Additional Investigators 3">
                                                Additional Investigators 3
                                            </option>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="comment">Comments</label>
                                        <textarea name="comment"></textarea>
                                    </div>
                                </div>

                                <div class="group-input">
                                    <label for="Equipment_grid">
                                        Equipment
                                        <button type="button" name="equipment" id="Equipment">+</button>
                                        <span class="text-primary" data-bs-toggle="modal"
                                            data-bs-target="#observation-field-instruction-modal"
                                            style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="Equipment_details">
                                            <thead>
                                                <tr>
                                                    <th style="width: 4%">Row#</th>
                                                    <th style="width: 12%">Product Name</th>
                                                    <th style="width: 16%"> Batch Number</th>
                                                    <th style="width: 16%"> Expiry Date</th>
                                                    <th style="width: 16%"> Manufactured Date</th>
                                                    <th style="width: 8%"> Number of Items Needed</th>
                                                    <th style="width: 16%"> Exist</th>
                                                    <th style="width: 16%"> Comment</th>
                                                    <th style="width: 16%"> Remarks</th>
                                                    <th style="width: 6%"> Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <td><input disabled type="text" name="Equipment_details[0][serial]"
                                                        value="1">
                                                </td>
                                                <td><input type="text" name="Equipment_details[0][ProductName]">
                                                </td>
                                                <td><input type="number" name="Equipment_details[0][BatchNumber]">
                                                </td>
                                                <td>
                                                    <div class="new-date-data-field">
                                                        <div class="group-input input-date">
                                                            <div class="calenderauditee">
                                                                <input class="click_date" id="ExpiryDate1" type="text"
                                                                    name="Equipment_details[0][ExpiryDate1]"
                                                                    placeholder="DD-MMM-YYYY" />
                                                                <input type="date"
                                                                    name="Equipment_details[0][ExpiryDate1]"
                                                                    min="" id="ExpiryDate1"
                                                                    class="hide-input show_date"
                                                                    style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                    oninput="handleDateInput(this, 'ExpiryDate1')" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="new-date-data-field">
                                                        <div class="group-input input-date">
                                                            <div class="calenderauditee">
                                                                <input class="click_date" id="ManufacturedDate1"
                                                                    type="text"
                                                                    name="Equipment_details[0][ManufacturedDate1]"
                                                                    placeholder="DD-MMM-YYYY" />
                                                                <input type="date"
                                                                    name="Equipment_details[0][ManufacturedDate1]"
                                                                    min="" id="ManufacturedDate1"
                                                                    class="hide-input show_date"
                                                                    style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                    oninput="handleDateInput(this, 'ManufacturedDate1')" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><input type="number"
                                                        name="Equipment_details[0][NumberOfItemsNeeded]">
                                                </td>
                                                <td><input type="text" name="Equipment_details[0][Exist]">
                                                </td>
                                                <td><input type="text" name="Equipment_details[0][Comments]">
                                                </td>
                                                <td><input type="text" name="Equipment_details[0][Remarks]">
                                                </td>
                                                <td><button type="text" class="removeBtnEQ">remove</button>
                                                </td>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Monitoring Report <span class="text-danger"></span>
                                        </label>
                                        <select name="monitoring_report">
                                            <option value="">--select--</option>
                                            <option value="Monitoring Report 1">
                                                Monitoring Report 1
                                            </option>
                                            <option value="Monitoring Report 2">
                                                Monitoring Report 2
                                            </option>
                                            <option value="Monitoring Report 3">
                                                Monitoring Report 3
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="sub-head"> Important Date</div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="follow_up_start_date">Date Follow-Up Letter Sent</label>

                                        <div class="calenderauditee">
                                            @php
                                                $Date = isset($data->follow_up_start_date)
                                                    ? new \DateTime($data->follow_up_start_date)
                                                    : null;
                                            @endphp
                                            <input type="text" id="follow_up_start_date" readonly
                                                placeholder="DD-MMM-YYYY"
                                                value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                            <input type="date" name="follow_up_start_date" class="hide-input"
                                                oninput="handleDateInput(this, 'follow_up_start_date')" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6  new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="follow_up_end_date">Date Follow-Up Completed</lable>

                                            <div class="calenderauditee">
                                                @php
                                                    $Date = isset($data->follow_up_end_date)
                                                        ? new \DateTime($data->follow_up_end_date)
                                                        : null;
                                                @endphp

                                                <input type="text" id="follow_up_end_date" readonly
                                                    placeholder="DD-MMM-YYYY"
                                                    value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                                <input type="date" name="follow_up_end_date" class="hide-input"
                                                    oninput="handleDateInput(this, 'follow_up_end_date')" />
                                            </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="visit_start_date">Date Of Visit</label>

                                        <div class="calenderauditee">
                                            @php
                                                $Date = isset($data->visit_start_date)
                                                    ? new \DateTime($data->visit_start_date)
                                                    : null;
                                            @endphp
                                            <input type="text" id="visit_start_date" readonly
                                                placeholder="DD-MMM-YYYY"
                                                value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                            <input type="date" name="visit_start_date" class="hide-input"
                                                oninput="handleDateInput(this, 'visit_start_date')" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6  new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="visit_end_date">Date Return From Visit</lable>
                                            <div class="calenderauditee">
                                                @php
                                                    $Date = isset($data->visit_end_date)
                                                        ? new \DateTime($data->visit_end_date)
                                                        : null;
                                                @endphp
                                                <input type="text" id="visit_end_date" readonly
                                                    placeholder="DD-MMM-YYYY"
                                                    value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                                <input type="date" name="visit_end_date" class="hide-input"
                                                    oninput="handleDateInput(this, 'visit_end_date')" />
                                            </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="report_complete_start_date">Date Report Completed</label>

                                        <div class="calenderauditee">
                                            @php
                                                $Date = isset($data->report_complete_start_date)
                                                    ? new \DateTime($data->report_complete_start_date)
                                                    : null;
                                            @endphp
                                            <input type="text" id="report_complete_start_date" readonly
                                                placeholder="DD-MMM-YYYY"
                                                value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                            <input type="date" name="report_complete_start_date" class="hide-input"
                                                oninput="handleDateInput(this, 'report_complete_start_date')" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6  new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="report_complete_end_date">Site Final Close-Out Date</lable>
                                            <div class="calenderauditee">
                                                @php
                                                    $Date = isset($data->report_complete_end_date)
                                                        ? new \DateTime($data->report_complete_end_date)
                                                        : null;
                                                @endphp
                                                <input type="text" id="report_complete_end_date" readonly
                                                    placeholder="DD-MMM-YYYY"
                                                    value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                                <input type="date" name="report_complete_end_date" class="hide-input"
                                                    oninput="handleDateInput(this, 'report_complete_end_date')" />
                                            </div>
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

                    <div id="CCForm5" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="sub-head">
                                Electronic Signatures
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Schedule_Site_Visit_By">Schedule Site Visit By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Schedule_Site_Visit_On">Schedule Site Visit On</label>
                                        <div class="Date"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="comment">Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="cancelled_by">Cancelled By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="cancelled_on">Cancelled On</label>
                                        <div class="Date"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="comment">Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Close_Out_Visit_Scheduled_By">Close Out Visit Scheduled By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Close_Out_Visit_Scheduled_On">Close Out Visit Scheduled On</label>
                                        <div class="Date"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="comment">Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Approve_Close_Out_By">Approve Close Out By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Approve_Close_Out_On">Approve Close Out On</label>
                                        <div class="Date"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="comment">Comment</label>
                                        <div class="static"></div>
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
        var maxLength = 255;
        $('#docname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const initiationDateInput = document.getElementById("initiation_date");
            const dueDateDisplay = document.getElementById("due_date_display");
            const dueDateInput = document.querySelector("input[name='due_date']");

            if (initiationDateInput && initiationDateInput.value) {
                const initiationDate = new Date(initiationDateInput.value);
                const dueDate = new Date(initiationDate);
                dueDate.setDate(dueDate.getDate() + 30);

                const formattedDueDate = dueDate.toISOString().split('T')[0];
                const displayDueDate = dueDate.toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                }).replace(/ /g, '-');

                dueDateDisplay.value = displayDueDate;
                dueDateInput.value = formattedDueDate;
            }
        });
    </script>
@endsection
