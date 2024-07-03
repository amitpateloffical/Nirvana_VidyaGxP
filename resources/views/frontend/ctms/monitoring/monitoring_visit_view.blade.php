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
            / CTMS_Monitoring Visit
        </div>
    </div>

    {{-- ---------------------- --}}

    <div id="change-control-view">
        <div class="container-fluid">

            <div class="inner-block state-block">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="main-head">Record Workflow </div>

                    <div class="d-flex" style="gap:20px;">
                        @php
                            $userRoles = DB::table('user_roles')
                                ->where(['user_id' => Auth::user()->id])
                                ->get();
                            $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                        @endphp
                        {{-- <button class="button_theme1" onclick="window.print();return false;"
                            class="new-doc-btn">Print</button> --}}
                        <button class="button_theme1"> <a class="text-white"
                                href="{{ route('Monitoring_Visit_AuditTrial', $data->id) }}"> Audit Trail </a>
                        </button>

                        @if ($data->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Schedule Site Visit
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($data->stage == 2 && (in_array(18, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Close Out Visit Scheduled </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button>
                        @elseif($data->stage == 3 && (in_array(18, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Approve Close Out
                            </button>
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                Request More Info
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button> --}}
                        @endif
                        <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                            </a> </button>

                    </div>

                </div>
                <div class="status">
                    <div class="head">Current Status</div>
                    {{-- ------------------------------By Pankaj-------------------------------- --}}
                    @if ($data->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @else
                        <div class="progress-bars">
                            @if ($data->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($data->stage >= 2)
                                <div class="active">Visit in Progress </div>
                            @else
                                <div class="">Visit in Progress</div>
                            @endif

                            @if ($data->stage >= 3)
                                <div class="active">Close Out Visit In Progress</div>
                            @else
                                <div class="">Close Out Visit In Progress</div>
                            @endif

                            @if ($data->stage >= 4)
                                <div class="bg-danger">Closed - Done</div>
                            @else
                                <div class="">Closed - Done</div>
                            @endif
                    @endif



                </div>
                {{-- @endif --}}
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            $('#Monitor_Information').click(function(e) {
                function generateTableRow(serialNumber) {
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text"Monitor_Information_details[' + serialNumber +
                        '][serial]" value="' + serialNumber +
                        '"></td>' +

                        '<td>' +
                        '<div class="new-date-data-field">' +
                        '<div class="group-input input-date">' +
                        '<div class="calenderauditee">' +
                        '<input class="click_date" id="Date_' + serialNumber +
                        '" type="text" name="Monitor_Information_details[' + serialNumber +
                        '][Date]" placeholder="DD-MMM-YYYY" readonly />' +
                        '<input type="date" name="Monitor_Information_details[' + serialNumber +
                        '][Date]"  id="closed_input_' +
                        serialNumber +
                        '" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" onchange="handleDateInput(this, \'Date_' +
                        serialNumber + '\')">' +
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
                        '<input class="click_date" id="Sent_Date_' + serialNumber +
                        '" type="text" name="Monitor_Information_details[' + serialNumber +
                        '][Sent_Date]" placeholder="DD-MMM-YYYY" readonly />' +
                        '<input type="date" name="Monitor_Information_details[' + serialNumber +
                        '][Sent_Date]"  id="closed_input_' +
                        serialNumber +
                        '" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" onchange="handleDateInput(this, \'Sent_Date_' +
                        serialNumber + '\')">' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +

                        '<td>' +
                        '<div class="new-date-data-field">' +
                        '<div class="group-input input-date">' +
                        '<div class="calenderauditee">' +
                        '<input class="click_date" id="Return_Date_' + serialNumber +
                        '" type="text" name="Monitor_Information_details[' + serialNumber +
                        '][Return_Date]" placeholder="DD-MMM-YYYY" readonly />' +
                        '<input type="date" name="Monitor_Information_details[' + serialNumber +
                        '][Return_Date]"  id="closed_input_' +
                        serialNumber +
                        '" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" onchange="handleDateInput(this, \'Return_Date_' +
                        serialNumber + '\')">' +
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
            });
        });


        $(document).on('click', '.removeBtnMI', function() {
            $(this).closest('tr').remove();
        })
    </script>


    <script>
        $(document).ready(function() {
            $('#Product_Material').click(function(e) {
                function generateTableRow(serialNumber) {
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text"Product_Material_details[' + serialNumber +
                        '][serial]" value="' + serialNumber +
                        '"></td>' +

                        '<td><input type="text" name="Product_Material_details[' + serialNumber +
                        '][ProductName]"></td>' +
                        '<td><input type="number" name="Product_Material_details[' + serialNumber +
                        '][ReBatchNumber]"></td>' +

                        '<td>' +
                        '<div class="new-date-data-field">' +
                        '<div class="group-input input-date">' +
                        '<div class="calenderauditee">' +
                        '<input class="click_date" id="ExpiryDate_' + serialNumber +
                        '" type="text" name="Product_Material_details[' + serialNumber +
                        '][ExpiryDate]" placeholder="DD-MMM-YYYY" readonly />' +
                        '<input type="date" name="Product_Material_details[' + serialNumber +
                        '][ExpiryDate]"  id="closed_input_' +
                        serialNumber +
                        '" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" onchange="handleDateInput(this, \'ExpiryDate_' +
                        serialNumber + '\')">' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +

                        '<td>' +
                        '<div class="new-date-data-field">' +
                        '<div class="group-input input-date">' +
                        '<div class="calenderauditee">' +
                        '<input class="click_date" id="ManufacturedDate_' + serialNumber +
                        '" type="text" name="Product_Material_details[' + serialNumber +
                        '][ManufacturedDate]" placeholder="DD-MMM-YYYY" readonly />' +
                        '<input type="date" name="Product_Material_details[' + serialNumber +
                        '][ManufacturedDate]"  id="closed_input_' +
                        serialNumber +
                        '" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" onchange="handleDateInput(this, \'ManufacturedDate_' +
                        serialNumber + '\')">' +
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
            });
        });
        $(document).on('click', '.removeBtnPM', function() {
            $(this).closest('tr').remove();
        })
    </script>

    <script>
        $(document).ready(function() {
            $('#Equipment').click(function(e) {
                function generateTableRow(serialNumber) {
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text"Equipment_details[' + serialNumber +
                        '][serial]" value="' + serialNumber +
                        '"></td>' +

                        '<td><input type="text" name="Equipment_details[' + serialNumber +
                        '][ProductName]"></td>' +
                        '<td><input type="number" name="Equipment_details[' + serialNumber +
                        '][BatchNumber]"></td>' +

                        '<td>' +
                        '<div class="new-date-data-field">' +
                        '<div class="group-input input-date">' +
                        '<div class="calenderauditee">' +
                        '<input class="click_date" id="ExpiryDate1_' + serialNumber +
                        '" type="text" name="Equipment_details[' + serialNumber +
                        '][ExpiryDate1]" placeholder="DD-MMM-YYYY" readonly />' +
                        '<input type="date" name="Equipment_details[' + serialNumber +
                        '][ExpiryDate1]"  id="closed_input_' +
                        serialNumber +
                        '" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" onchange="handleDateInput(this, \'ExpiryDate1_' +
                        serialNumber + '\')">' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +

                        '<td>' +
                        '<div class="new-date-data-field">' +
                        '<div class="group-input input-date">' +
                        '<div class="calenderauditee">' +
                        '<input class="click_date" id="ManufacturedDate1_' + serialNumber +
                        '" type="text" name="Equipment_details[' + serialNumber +
                        '][ManufacturedDate1]" placeholder="DD-MMM-YYYY" readonly />' +
                        '<input type="date" name="Equipment_details[' + serialNumber +
                        '][ManufacturedDate1]"  id="closed_input_' +
                        serialNumber +
                        '" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" onchange="handleDateInput(this, \'ManufacturedDate1_' +
                        serialNumber + '\')">' +
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
            });
        });
        $(document).on('click', '.removeBtnEQ', function() {
            $(this).closest('tr').remove();
        })
    </script>

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

            <form action="{{ route('monitoring_visit_update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')

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
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/CTMS/{{ date('Y') }}/{{ $data->record }}">
                                        {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Site/Location Code</b></label>
                                        {{-- <input disabled type="text" name="division_code" value=""> --}}
                                        <input readonly type="text" name="division_code"
                                            value="{{ Helpers::getDivisionName($data->division_id) }}">

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    {{-- @if (!empty($cc->id))
                                        <input type="hidden" name="ccId" value="{{ $cc->id }}">
                                    @endif --}}
                                    <div class="group-input">
                                        <label for="Initiator">Initiator</label>
                                        <input disabled type="text" name="initiator_id" value="{{ Auth::user()->name }}">
                                    </div>
                                </div>
                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Opened">Date of Initiation</label>
                                        
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                    </div>
                                </div> --}}

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Opened">Date of Initiation</label>
                                        @if (isset($data) && $data->intiation_date)
                                            <input disabled type="text"
                                                value="{{ \Carbon\Carbon::parse($data->intiation_date)->format('d-M-Y') }}"
                                                name="intiation_date_display">
                                        @else
                                            <input disabled type="text" value="" name="intiation_date_display">
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <div class="group-input">
                                        <label for="search">
                                            Assigned To <span class="text-danger"></span>
                                        </label>
                                        <select name="assign_to" onchange="">
                                            <option value="">Select a value</option>
                                            {{-- @foreach ($data as $user)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach --}}
                                            @if ($users->isNotEmpty())
                                                @foreach ($users as $value)
                                                    <option {{ $data->assign_to == $value->name ? 'selected' : '' }}
                                                        value='{{ $value->name }}'>{{ $value->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('assign_to')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date">Due Date <span class="text-danger"></span></label>
                                        <p class="text-primary">Please mention expected date of completion</p>
                                        <div class="calenderauditee">
                                            @php
                                                $Date = isset($data->due_date) ? new \DateTime($data->due_date) : null;
                                            @endphp

                                            <input type="text" id="due_date" readonly placeholder="DD-MM-YYYY"
                                                value="{{ $Date ? $Date->format('d-M-Y') : '' }}" />
                                            <input type="date" name="due_date" value="{{ $data->due_date ?? '' }}"
                                                class="hide-input" min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}"
                                                oninput="handleDateInput(this, 'due_date')" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars">255</span>
                                        characters remaining
                                        <input id="docname" type="text" name="short_description"
                                            value="{{ $data->short_description }}" maxlength="255" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Type <span class="text-danger"></span>
                                        </label>
                                        <select name="type" value="{{ $data->type }}">
                                            <option value="0">-- Select type --</option>
                                            <option value="Other"{{ $data->type == 'Other' ? 'selected' : '' }}>Other
                                            </option>
                                            <option value="Training"{{ $data->type == 'Training' ? 'selected' : '' }}>
                                                Training</option>
                                            <option value="Finance"{{ $data->type == 'Finance' ? 'selected' : '' }}>
                                                Finance</option>
                                            <option value="Follow Up"{{ $data->type == 'Follow Up' ? 'selected' : '' }}>
                                                Follow Up</option>
                                            <option value="Marketing"{{ $data->type == 'Marketing' ? 'selected' : '' }}>
                                                Marketing</option>
                                            <option value="Sales"{{ $data->type == 'Sales' ? 'selected' : '' }}>Sales
                                            </option>
                                            <option
                                                value="Account Service"{{ $data->type == 'Account Service' ? 'selected' : '' }}>
                                                Account Service</option>
                                            <option
                                                value=" Recent Product Launch"{{ $data->type == ' Recent Product Launch' ? 'selected' : '' }}>
                                                Recent Product Launch</option>
                                            <option value="IT"{{ $data->type == 'IT' ? 'selected' : '' }}>IT
                                            </option>
                                        </select>

                                    </div>
                                </div>


                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Initial Attachments">Initial Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>

                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="file_attach">
                                                @if ($data->file_attach)
                                                    @foreach (json_decode($data->file_attach) as $file)
                                                        <h6 type="button" class="file-container text-dark"
                                                            style="background-color: rgb(243, 242, 240);">
                                                            <b>{{ $file }}</b>
                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                    class="fa fa-eye text-primary"
                                                                    style="font-size:20px; margin-right:-10px;"></i></a>
                                                            <a type="button" class="remove-file"
                                                                data-file-name="{{ $file }}"><i
                                                                    class="fa-solid fa-circle-xmark"
                                                                    style="color:red; font-size:20px;"></i></a>
                                                        </h6>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}
                                                    type="file" id="myfile" name="file_attach[]"
                                                    oninput="addMultipleFiles(this, 'file_attach')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Description</label>

                                        <textarea name="description" id="docname" type="text">{{ $data->description }}</textarea>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="comments">Comments</label>

                                        <textarea name="comments" type="text">{{ $data->comments }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Source Documents <span class="text-danger"></span>
                                        </label>
                                        <select name="source_documents">
                                            <option value="">--select--</option>
                                            <option
                                                value="Source Documents 1"{{ $data->source_documents == 'Source Documents 1' ? 'selected' : '' }}>
                                                Source Documents
                                                1</option>
                                            <option
                                                value="Source Documents 2"{{ $data->source_documents == 'Source Documents 2' ? 'selected' : '' }}>
                                                Source Documents
                                                2</option>
                                            <option
                                                value="Source Documents 3"{{ $data->source_documents == 'Source Documents 3' ? 'selected' : '' }}>
                                                Source Documents
                                                3</option>
                                        </select>

                                    </div>
                                </div>


                                <div class="sub-head">
                                    Location
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="zone">Zone</label>
                                        <select name="zone">
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="Asia" @if ($data->zone == 'Asia') selected @endif>
                                                Asia</option>
                                            <option value="Europe" @if ($data->zone == 'Europe') selected @endif>
                                                Europe</option>
                                            <option value="Africa" @if ($data->zone == 'Africa') selected @endif>
                                                Africa</option>
                                            <option value="Central America"
                                                @if ($data->zone == 'Central America') selected @endif>Central America
                                            </option>
                                            <option value="South America"
                                                @if ($data->zone == 'South America') selected @endif>South America
                                            </option>
                                            <option value="Oceania" @if ($data->zone == 'Oceania') selected @endif>
                                                Oceania</option>
                                            <option value="North America"
                                                @if ($data->zone == 'North America') selected @endif>North America
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="country">Country</label>
                                        <select name="country" class="form-select country"
                                            aria-label="Default select example" onchange="loadStates()">
                                            <option value="{{ $data->country }}">
                                                {{ $data->country }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="state">State</label>
                                        <select name="state" class="form-select state"
                                            aria-label="Default select example" onchange="loadCities()">
                                            <option value="{{ $data->state }}">{{ $data->state }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="city">City</label>
                                        <select name="city" class="form-select city"
                                            aria-label="Default select example">
                                            <option value="{{ $data->city }}">{{ $data->city }}
                                            </option>
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
                                            <option
                                                value="Parent Site 1"{{ $data->name_on_site == 'Parent Site 1' ? 'selected' : '' }}>
                                                Parent Site 1
                                            </option>
                                            <option
                                                value="Parent Site 2"{{ $data->name_on_site == 'Parent Site 2' ? 'selected' : '' }}>
                                                Parent Site 2
                                            </option>
                                            <option
                                                value="Parent Site 3"{{ $data->name_on_site == 'Parent Site 3' ? 'selected' : '' }}>
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
                                            <option
                                                value="Building 1"{{ $data->building == 'Building 1' ? 'selected' : '' }}>
                                                Building 1
                                            </option>
                                            <option
                                                value="Building2"{{ $data->building == 'Building 2' ? 'selected' : '' }}>
                                                Building 2
                                            </option>
                                            <option
                                                value="Building 3"{{ $data->building == 'Building 3' ? 'selected' : '' }}>
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
                                            <option value="Floor 1"{{ $data->floor == 'Floor 1' ? 'selected' : '' }}>Floor
                                                1</option>
                                            <option value="Floor 2"{{ $data->floor == 'Floor 2' ? 'selected' : '' }}>Floor
                                                2</option>
                                            <option value="Floor 3"{{ $data->floor == 'Floor 3' ? 'selected' : '' }}>Floor
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
                                            <option value="Room 1"{{ $data->room == 'Room 1' ? 'selected' : '' }}>Room 1
                                            </option>
                                            <option value="Room 2"{{ $data->room == 'Room 2' ? 'selected' : '' }}>Room 2
                                            </option>
                                            <option value="Room 3"{{ $data->room == 'Room 3' ? 'selected' : '' }}>Room 3
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
                                            <option value="Site 1"{{ $data->site == 'Site 1' ? 'selected' : '' }}>Site 1
                                            </option>
                                            <option value="Site 2"{{ $data->site == 'Site 2' ? 'selected' : '' }}>Site 2
                                            </option>
                                            <option value="Site 3"{{ $data->site == 'Site 3' ? 'selected' : '' }}>Site 3
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
                                            <option
                                                value="Site Contact 1"{{ $data->site_contact == 'Site Contact 1' ? 'selected' : '' }}>
                                                Site Contact 1
                                            </option>
                                            <option
                                                value="Site Contact 2"{{ $data->site_contact == 'Site Contact 2' ? 'selected' : '' }}>
                                                Site Contact 2
                                            </option>
                                            <option
                                                value="Site Contact 3"{{ $data->site_contact == 'Site Contact 3' ? 'selected' : '' }}>
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
                                            <option
                                                value="Lead Investigator 1"{{ $data->lead_investigator == 'Lead Investigator 1' ? 'selected' : '' }}>
                                                Lead Investigator 1</option>
                                            <option
                                                value="Lead Investigator 2"{{ $data->lead_investigator == 'Lead Investigator 2' ? 'selected' : '' }}>
                                                Lead Investigator 2</option>
                                            <option
                                                value="Lead Investigator 3"{{ $data->lead_investigator == 'Lead Investigator 3' ? 'selected' : '' }}>
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
                                            <option
                                                value="Manufacturer 1"{{ $data->manufacturer == 'Manufacturer 1' ? 'selected' : '' }}>
                                                Manufacturer 1
                                            </option>
                                            <option
                                                value="Manufacturer 2"{{ $data->manufacturer == 'Manufacturer 2' ? 'selected' : '' }}>
                                                Manufacturer 2
                                            </option>
                                            <option
                                                value="Manufacturer 3"{{ $data->manufacturer == 'Manufacturer 3' ? 'selected' : '' }}>
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
                                            data-bs-target="#document-details-field-instruction-modal"
                                            style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="Monitor_Information_details"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 4%">Row#</th>
                                                    <th style="width: 12%">Date</th>
                                                    <th style="width: 16%"> Responsible</th>
                                                    <th style="width: 16%"> Item Description</th>
                                                    <th style="width: 16%"> Sent Date</th>
                                                    <th style="width: 16%"> Return Date</th>
                                                    <th style="width: 16%"> Comments</th>
                                                    <th style="width: 16%"> Remarks</th>
                                                    <th style="width: 6%"> Action</th>

                                                </tr>
                                            </thead>

                                            <tbody>
                                                @if ($grid_Data && is_array($grid_Data->data))
                                                    @foreach ($grid_Data->data as $grid_Data)
                                                        <tr>

                                                            <td><input type="text"
                                                                    name="Monitor_Information_details{{ $loop->index }}][serial]"
                                                                    value="{{ $loop->index + 1 }}"></td>
                                                            <td>
                                                                <div class="new-date-data-field">
                                                                    <div class="group-input input-date">
                                                                        <div class="calenderauditee">
                                                                            <input class="click_date"
                                                                                id="Date_{{ $loop->index }}"
                                                                                type="text"
                                                                                name="Monitor_Information_details[{{ $loop->index }}][Date]"
                                                                                value="{{ isset($grid_Data['Date']) ? \Carbon\Carbon::parse($grid_Data['Date'])->format('d-M-Y') : '' }}"
                                                                                placeholder="DD-MMM-YYYY" readonly />
                                                                            <input type="date"
                                                                                name="Monitor_Information_details[{{ $loop->index }}][Date]"
                                                                                id="Date_{{ $loop->index }}"
                                                                                value="{{ isset($grid_Data['Date']) ? $grid_Data['Date'] : '' }}"
                                                                                class="hide-input show_date"
                                                                                style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                                onchange="handleDateInput(this, 'Date_{{ $loop->index }}')" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <td><input type="text"
                                                                    name="Monitor_Information_details[{{ $loop->index }}][Responsible]"
                                                                    value="{{ isset($grid_Data['Responsible']) ? $grid_Data['Responsible'] : '' }}">
                                                            </td>
                                                            <td><input type="text"
                                                                    name="Monitor_Information_details[{{ $loop->index }}][Item_Description]"
                                                                    value="{{ isset($grid_Data['Item_Description']) ? $grid_Data['Item_Description'] : '' }}">
                                                            </td>

                                                            <td>
                                                                <div class="new-date-data-field">
                                                                    <div class="group-input input-date">
                                                                        <div class="calenderauditee">
                                                                            <input class="click_date"
                                                                                id="Sent_Date_{{ $loop->index }}"
                                                                                type="text"
                                                                                name="Monitor_Information_details[{{ $loop->index }}][Sent_Date]"
                                                                                value="{{ isset($grid_Data['Sent_Date']) ? \Carbon\Carbon::parse($grid_Data['Sent_Date'])->format('d-M-Y') : '' }}"
                                                                                placeholder="DD-MMM-YYYY" readonly />
                                                                            <input type="date"
                                                                                name="Monitor_Information_details[{{ $loop->index }}][Sent_Date]"
                                                                                id="Sent_Date_{{ $loop->index }}"
                                                                                value="{{ isset($grid_Data['Sent_Date']) ? $grid_Data['Sent_Date'] : '' }}"
                                                                                class="hide-input show_date"
                                                                                style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                                onchange="handleDateInput(this, 'Sent_Date_{{ $loop->index }}')" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="new-date-data-field">
                                                                    <div class="group-input input-date">
                                                                        <div class="calenderauditee">
                                                                            <input class="click_date"
                                                                                id="Return_Date_{{ $loop->index }}"
                                                                                type="text"
                                                                                name="Monitor_Information_details[{{ $loop->index }}][Return_Date]"
                                                                                value="{{ isset($grid_Data['Return_Date']) ? \Carbon\Carbon::parse($grid_Data['Return_Date'])->format('d-M-Y') : '' }}"
                                                                                placeholder="DD-MMM-YYYY" readonly />
                                                                            <input type="date"
                                                                                name="Monitor_Information_details[{{ $loop->index }}][Return_Date]"
                                                                                id="Return_Date_{{ $loop->index }}"
                                                                                value="{{ isset($grid_Data['Return_Date']) ? $grid_Data['Return_Date'] : '' }}"
                                                                                class="hide-input show_date"
                                                                                style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                                onchange="handleDateInput(this, 'Return_Date_{{ $loop->index }}')" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <td><input type="text"
                                                                    name="Monitor_Information_details[{{ $loop->index }}][Comments]"
                                                                    value="{{ isset($grid_Data['Comments']) ? $grid_Data['Comments'] : '' }}">
                                                            </td>
                                                            <td><input type="text"
                                                                    name="Monitor_Information_details[{{ $loop->index }}][Remarks]"
                                                                    value="{{ isset($grid_Data['Remarks']) ? $grid_Data['Remarks'] : '' }}">
                                                            </td>
                                                            <td><button type="text" class="removeBtnMI">remove</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                            </tbody>

                                        </table>
                                    </div>
                                </div>

                                <div class="group-input">
                                    <label for="Product_Material_grid">
                                        Product/Material
                                        <button type="button" name="product_material" id="Product_Material">+</button>
                                        <span class="text-primary" data-bs-toggle="modal"
                                            data-bs-target="#document-details-field-instruction-modal"
                                            style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="Product_Material_details"
                                            style="width: 100%;">
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
                                                @if ($grid_Data1 && is_array($grid_Data1->data))
                                                    @foreach ($grid_Data1->data as $grid_Data1)
                                                        <tr>

                                                            <td><input type="text"
                                                                    name="Product_Material_details{{ $loop->index }}][serial]"
                                                                    value="{{ $loop->index + 1 }}"></td>
                                                            <td><input type="text"
                                                                    name="Product_Material_details[{{ $loop->index }}][ProductName]"
                                                                    value="{{ isset($grid_Data1['ProductName']) ? $grid_Data1['ProductName'] : '' }}">
                                                            </td>

                                                            <td><input type="number"
                                                                    name="Product_Material_details[{{ $loop->index }}][ReBatchNumber]"
                                                                    value="{{ isset($grid_Data1['ReBatchNumber']) ? $grid_Data1['ReBatchNumber'] : '' }}">
                                                            </td>

                                                            <td>
                                                                <div class="new-date-data-field">
                                                                    <div class="group-input input-date">
                                                                        <div class="calenderauditee">
                                                                            <input class="click_date"
                                                                                id="ExpiryDate_{{ $loop->index }}"
                                                                                type="text"
                                                                                name="Product_Material_details[{{ $loop->index }}][ExpiryDate]"
                                                                                value="{{ isset($grid_Data1['ExpiryDate']) ? \Carbon\Carbon::parse($grid_Data1['ExpiryDate'])->format('d-M-Y') : '' }}"
                                                                                placeholder="DD-MMM-YYYY" readonly />
                                                                            <input type="date"
                                                                                name="Product_Material_details[{{ $loop->index }}][ExpiryDate]"
                                                                                id="ExpiryDate_{{ $loop->index }}"
                                                                                value="{{ isset($grid_Data1['ExpiryDate']) ? $grid_Data1['ExpiryDate'] : '' }}"
                                                                                class="hide-input show_date"
                                                                                style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                                onchange="handleDateInput(this, 'ExpiryDate_{{ $loop->index }}')" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>


                                                            <td>
                                                                <div class="new-date-data-field">
                                                                    <div class="group-input input-date">
                                                                        <div class="calenderauditee">
                                                                            <input class="click_date"
                                                                                id="ManufacturedDate_{{ $loop->index }}"
                                                                                type="text"
                                                                                name="Product_Material_details[{{ $loop->index }}][ManufacturedDate]"
                                                                                value="{{ isset($grid_Data1['ManufacturedDate']) ? \Carbon\Carbon::parse($grid_Data1['ManufacturedDate'])->format('d-M-Y') : '' }}"
                                                                                placeholder="DD-MMM-YYYY" readonly />
                                                                            <input type="date"
                                                                                name="Product_Material_details[{{ $loop->index }}][ManufacturedDate]"
                                                                                id="ManufacturedDate_{{ $loop->index }}"
                                                                                value="{{ isset($grid_Data1['ManufacturedDate']) ? $grid_Data1['ManufacturedDate'] : '' }}"
                                                                                class="hide-input show_date"
                                                                                style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                                onchange="handleDateInput(this, 'ManufacturedDate_{{ $loop->index }}')" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <td><input type="text"
                                                                    name="Product_Material_details[{{ $loop->index }}][Disposition]"
                                                                    value="{{ isset($grid_Data1['Disposition']) ? $grid_Data1['Disposition'] : '' }}">
                                                            </td>
                                                            <td><input type="text"
                                                                    name="Product_Material_details[{{ $loop->index }}][Comments]"
                                                                    value="{{ isset($grid_Data1['Comments']) ? $grid_Data1['Comments'] : '' }}">
                                                            </td>
                                                            <td><input type="text"
                                                                    name="Product_Material_details[{{ $loop->index }}][Remarks]"
                                                                    value="{{ isset($grid_Data1['Remarks']) ? $grid_Data1['Remarks'] : '' }}">
                                                            </td>
                                                            <td><button type="text" class="removeBtnPM">remove</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif

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
                                            <option
                                                value="Additional Investigators 1"{{ $data->additional_investigators == 'Additional Investigators 1' ? 'selected' : '' }}>
                                                Additional Investigators 1
                                            </option>
                                            <option
                                                value="Additional Investigators 2"{{ $data->additional_investigators == 'Additional Investigators 2' ? 'selected' : '' }}>
                                                Additional Investigators 2
                                            </option>
                                            <option
                                                value="Additional Investigators 3"{{ $data->additional_investigators == 'Additional Investigators 3' ? 'selected' : '' }}>
                                                Additional Investigators 3
                                            </option>
                                        </select>

                                    </div>

                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="comment">Comments</label>
                                        <textarea name="comment">{{ $data->comment }}</textarea>
                                    </div>
                                </div>

                                <div class="group-input">
                                    <label for="Equipment_grid">
                                        Equipment
                                        <button type="button" name="equipment" id="Equipment">+</button>
                                        <span class="text-primary" data-bs-toggle="modal"
                                            data-bs-target="#document-details-field-instruction-modal"
                                            style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="Equipment_details" style="width: 100%;">
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
                                                @if ($grid_Data2 && is_array($grid_Data2->data))
                                                    @foreach ($grid_Data2->data as $grid_Data2)
                                                        <tr>

                                                            <td><input type="text"
                                                                    name="Equipment_details{{ $loop->index }}][serial]"
                                                                    value="{{ $loop->index + 1 }}"></td>
                                                            <td><input type="text"
                                                                    name="Equipment_details[{{ $loop->index }}][ProductName]"
                                                                    value="{{ isset($grid_Data2['ProductName']) ? $grid_Data2['ProductName'] : '' }}">
                                                            </td>

                                                            <td><input type="number"
                                                                    name="Equipment_details[{{ $loop->index }}][BatchNumber]"
                                                                    value="{{ isset($grid_Data2['BatchNumber']) ? $grid_Data2['BatchNumber'] : '' }}">
                                                            </td>

                                                            <td>
                                                                <div class="new-date-data-field">
                                                                    <div class="group-input input-date">
                                                                        <div class="calenderauditee">
                                                                            <input class="click_date"
                                                                                id="ExpiryDate1_{{ $loop->index }}"
                                                                                type="text"
                                                                                name="Equipment_details[{{ $loop->index }}][ExpiryDate1]"
                                                                                value="{{ isset($grid_Data2['ExpiryDate1']) ? \Carbon\Carbon::parse($grid_Data2['ExpiryDate1'])->format('d-M-Y') : '' }}"
                                                                                placeholder="DD-MMM-YYYY" readonly />
                                                                            <input type="date"
                                                                                name="Equipment_details[{{ $loop->index }}][ExpiryDate1]"
                                                                                id="ExpiryDate1_{{ $loop->index }}"
                                                                                value="{{ isset($grid_Data2['ExpiryDate1']) ? $grid_Data2['ExpiryDate1'] : '' }}"
                                                                                class="hide-input show_date"
                                                                                style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                                onchange="handleDateInput(this, 'ExpiryDate1_{{ $loop->index }}')" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <div class="new-date-data-field">
                                                                    <div class="group-input input-date">
                                                                        <div class="calenderauditee">
                                                                            <input class="click_date"
                                                                                id="ManufacturedDate1_{{ $loop->index }}"
                                                                                type="text"
                                                                                name="Equipment_details[{{ $loop->index }}][ManufacturedDate1]"
                                                                                value="{{ isset($grid_Data2['ManufacturedDate1']) ? \Carbon\Carbon::parse($grid_Data2['ManufacturedDate1'])->format('d-M-Y') : '' }}"
                                                                                placeholder="DD-MMM-YYYY" readonly />
                                                                            <input type="date"
                                                                                name="Equipment_details[{{ $loop->index }}][ManufacturedDate1]"
                                                                                id="ManufacturedDate1_{{ $loop->index }}"
                                                                                value="{{ isset($grid_Data2['ManufacturedDate1']) ? $grid_Data2['ManufacturedDate1'] : '' }}"
                                                                                class="hide-input show_date"
                                                                                style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                                onchange="handleDateInput(this, 'ManufacturedDate1_{{ $loop->index }}')" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <td><input type="number"
                                                                    name="Equipment_details[{{ $loop->index }}][NumberOfItemsNeeded]"
                                                                    value="{{ isset($grid_Data2['NumberOfItemsNeeded']) ? $grid_Data2['NumberOfItemsNeeded'] : '' }}">
                                                            </td>
                                                            <td><input type="text"
                                                                    name="Equipment_details[{{ $loop->index }}][Exist]"
                                                                    value="{{ isset($grid_Data2['Exist']) ? $grid_Data2['Exist'] : '' }}">
                                                            </td>
                                                            <td><input type="text"
                                                                    name="Equipment_details[{{ $loop->index }}][Comments]"
                                                                    value="{{ isset($grid_Data2['Comments']) ? $grid_Data2['Comments'] : '' }}">
                                                            </td>
                                                            <td><input type="text"
                                                                    name="Equipment_details[{{ $loop->index }}][Remarks]"
                                                                    value="{{ isset($grid_Data2['Remarks']) ? $grid_Data2['Remarks'] : '' }}">
                                                            </td>
                                                            <td><button type="text" class="removeBtnEQ">remove</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif

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
                                            <option
                                                value="Monitoring Report 1"{{ $data->monitoring_report == 'Monitoring Report 1' ? 'selected' : '' }}>
                                                Monitoring Report 1
                                            </option>
                                            <option
                                                value="Monitoring Report 2"{{ $data->monitoring_report == 'Monitoring Report 2' ? 'selected' : '' }}>
                                                Monitoring Report 2
                                            </option>
                                            <option
                                                value="Monitoring Report 3"{{ $data->monitoring_report == 'Monitoring Report 3' ? 'selected' : '' }}>
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
                                            {{-- Format the date as desired --}}
                                            <input type="text" id="follow_up_start_date" readonly
                                                placeholder="DD-MMM-YYYY"
                                                value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                            <input type="date" name="follow_up_start_date"
                                                value="{{ $data->follow_up_start_date ?? '' }}" class="hide-input"
                                                oninput="handleDateInput(this, 'follow_up_start_date')" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="follow_up_end_date">Date Follow-Up Completed</label>

                                        <div class="calenderauditee">
                                            @php
                                                $Date = isset($data->follow_up_end_date)
                                                    ? new \DateTime($data->follow_up_end_date)
                                                    : null;
                                            @endphp
                                            {{-- Format the date as desired --}}
                                            <input type="text" id="follow_up_end_date" readonly
                                                placeholder="DD-MMM-YYYY"
                                                value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                            <input type="date" name="follow_up_end_date"
                                                value="{{ $data->follow_up_end_date ?? '' }}" class="hide-input"
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
                                            {{-- Format the date as desired --}}
                                            <input type="text" id="visit_start_date" readonly
                                                placeholder="DD-MMM-YYYY"
                                                value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                            <input type="date" name="visit_start_date"
                                                value="{{ $data->visit_start_date ?? '' }}" class="hide-input"
                                                oninput="handleDateInput(this, 'visit_start_date')" />
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="visit_end_date">Date Return From Visit</label>

                                        <div class="calenderauditee">
                                            @php
                                                $Date = isset($data->visit_end_date)
                                                    ? new \DateTime($data->visit_end_date)
                                                    : null;
                                            @endphp
                                            {{-- Format the date as desired --}}
                                            <input type="text" id="visit_end_date" readonly placeholder="DD-MMM-YYYY"
                                                value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                            <input type="date" name="visit_end_date"
                                                value="{{ $data->visit_end_date ?? '' }}" class="hide-input"
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
                                            <input type="date" name="report_complete_start_date"
                                                value="{{ $data->report_complete_start_date ?? '' }}" class="hide-input"
                                                oninput="handleDateInput(this, 'report_complete_start_date')" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="report_complete_end_date">Site Final Close-Out Date</label>

                                        <div class="calenderauditee">
                                            @php
                                                $Date = isset($data->report_complete_end_date)
                                                    ? new \DateTime($data->report_complete_end_date)
                                                    : null;
                                            @endphp
                                            <input type="text" id="report_complete_end_date" readonly
                                                placeholder="DD-MMM-YYYY"
                                                value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                            <input type="date" name="report_complete_end_date"
                                                value="{{ $data->report_complete_end_date ?? '' }}" class="hide-input"
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
                                        <div class="static">{{ $data->Schedule_Site_Visit_By }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Schedule_Site_Visit_On">Schedule Site Visit On</label>
                                        <div class="Date">{{ $data->Schedule_Site_Visit_On }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="comment">Comment</label>
                                        <div class="static">{{ $data->Schedule_Site_Visit_Comment }}</div>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="cancelled_by">Cancelled By</label>
                                        <div class="static">{{ $data->cancelled_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="cancelled_on">Cancelled On</label>
                                        <div class="Date">{{ $data->cancelled_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="comment">Comment</label>
                                        <div class="static">{{ $data->Cancelled_Comment }}</div>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Close_Out_Visit_Scheduled_By">Close Out Visit Scheduled By</label>
                                        <div class="static">{{ $data->Close_Out_Visit_Scheduled_By }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Close_Out_Visit_Scheduled_On">Close Out Visit Scheduled On</label>
                                        <div class="Date">{{ $data->Close_Out_Visit_Scheduled_On }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="comment">Comment</label>
                                        <div class="static">{{ $data->Close_Out_Visit_Scheduled_Comment }}</div>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Approve_Close_Out_By">Approve Close Out By</label>
                                        <div class="static">{{ $data->Approve_Close_Out_By }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Approve_Close_Out_On">Approve Close Out On</label>
                                        <div class="Date">{{ $data->Approve_Close_Out_On }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="comment">Comment</label>
                                        <div class="static">{{ $data->Approve_Close_Out_Comment }}</div>
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
    <div class="modal fade" id="signature-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('MVStage_Change', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment</label>
                            <input type="comment" name="comment">
                        </div>
                    </div>


                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="cancel-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('MVstages_change', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment <span class="text-danger">*</span></label>
                            <input type="comment" name="comment" required>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="child-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Child</h4>
                </div>
                <form action="{{ route('violation_item_show', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="group-input">
                            <label for="major">
                                <input type="radio" name="revision" id="major" value="Action-Item">
                                Violation
                            </label>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
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
@endsection
