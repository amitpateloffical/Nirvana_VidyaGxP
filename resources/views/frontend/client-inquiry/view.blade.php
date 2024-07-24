@extends('frontend.layout.main')
@section('container')
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }

        .input_width {
            width: 100%;
            border-radius: 5px;
            margin-bottom: 11px;
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
            {{ Helpers::getDivisionName(session()->get('division')) }}/ Client Inquiry
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
                                href="{{ route('ClientInquiry_AuditTrial', $data->id) }}"> Audit Trail </a> </button>

                        @if ($data->stage == 1)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Submit for Review
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($data->stage == 2)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Simple Resolution
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#direct-modal">
                                Legal Issue Relations/Operational Issue
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#person-modal">
                                Relations/Operational Issue
                            </button>
                        @elseif($data->stage == 3)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Complete
                            </button>
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                Request More Info
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button> --}}
                        @elseif($data->stage == 4)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#direct-modal">
                                Resolution
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button>
                        @elseif($data->stage == 5)
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Review
                            </button> --}}
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#person-modal">
                                Resolution
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button>
                        @elseif($data->stage == 6)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#direct-modal">
                                No Analysis Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#person-modal">
                                Analysis Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button>
                        @elseif($data->stage == 7)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#person-modal">
                                Pending Action Completion
                            </button>
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                Return to QA Review
                            </button> --}}
                            <!-- <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                Exit
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </a> </button> -->
                        @elseif($data->stage == 8)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#person-modal">
                                Approve
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                Reject
                            </button>
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
                                <div class="active">Supervisor Review </div>
                            @else
                                <div class="">Supervisor Review</div>
                            @endif

                            @if ($data->stage >= 3)
                                <div class="active">Resolution in Progress</div>
                            @else
                                <div class="">Resolution in Progress</div>
                            @endif

                            @if ($data->stage >= 4)
                                <div class="active">Case Review</div>
                            @else
                                <div class="">Case Review</div>
                            @endif
                            @if ($data->stage >= 5)
                                <div class="active">Work in Progress</div>
                            @else
                                <div class="">Work in Progress</div>
                            @endif
                            @if ($data->stage >= 6)
                                <div class="active">Root Cause Analysis</div>
                            @else
                                <div class="">Root Cause Analysis</div>
                            @endif
                            @if ($data->stage >= 7)
                                <div class="active">Pending Preventing Action</div>
                            @else
                                <div class="">Pending Preventing Action</div>
                            @endif
                            @if ($data->stage >= 8)
                                <div class="active">Pending Approval</div>
                            @else
                                <div class="">Pending Approval</div>
                            @endif
                            @if ($data->stage >= 9)
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
                    var data = @json($grid_Data);
                    var html = '';
                    html += '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="product_material[' + serialNumber +
                        '][Product_name]"></td>' +
                        '<td><input type="text" name="product_material[' + serialNumber +
                        '][Batch_number]"></td>' +
                        '<td><input type="text" name="product_material[' + serialNumber +
                        '][Expiry_date]"></td>' +
                        '<td><input type="text" name="product_material[' + serialNumber +
                        '][Manufactured_date]"></td>' +
                        '<td><input type="text" name="product_material[' + serialNumber +
                        '][disposition]"></td>' +
                        '<td><input type="text" name="product_material[' + serialNumber +
                        '][Comment]"></td>' +

                        '<td><button type="text" class="removeRowBtn">remove</button></td>' +
                        '</tr>';
                    for (var i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                    }

                    html += '</select></td>' +
                        '</tr>';

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

    {{-- <script>
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

                var tableBody = $('#product_material-first-table tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script> --}}




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

            <form action="{{ route('client_update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

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
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="RLS Record Number"><b>Record Number</b></label>
                                            <input disabled type="text" name="record_number"
                                                value="{{ Helpers::getDivisionName(session()->get('division')) }}/CI/{{ date('Y') }}/{{ $data->record }}">
                                            {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> --}}
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Division Code"><b>Site/Location Code</b></label>
                                            <input disabled type="text" name="division_code"
                                                value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                            <input type="hidden" name="division_id"
                                                value="{{ session()->get('division') }}">
                                            {{-- <div class="static">QMS-North America</div> --}}
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="originator">Originator</label>
                                            <input disabled type="text" name="originator"
                                                value="{{ Auth::user()->name }}" />
                                        </div>
                                    </div>

                                    {{-- <div class="col-lg-6">
                                        <div class="group-input ">
                                            <label for="Date Due"><b>Date Opened</b></label>
                                            <input disabled type="text" value="{{ date('d-M-Y') }}"
                                                name="intiation_date">
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

                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="Initiator Group Code">Short Description <span
                                                    class="text-danger">*</span></label><span id="rchars">255</span>
                                            characters remaining
                                            <input type="text" name="short_description" id="docname"
                                                value="{{ $data->short_description }}"maxlength="255" required>
                                        </div>
                                    </div>

                                    {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="initiator_group_code">255</span>
                                        characters remaining
                                        <input id="initiator_group_code" type="text" name="short_description" maxlength="255" required>
                                    </div>
                                </div>   --}}

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="If Others">Assigned To</label>
                                            <select name="assigned_to" onchange="">
                                                <option value="">Select a value</option>
                                                @if ($users->isNotEmpty())
                                                    @foreach ($users as $value)
                                                        <option {{ $data->assigned_to == $value->name ? 'selected' : '' }}
                                                            value='{{ $value->name }}'>{{ $value->name }}</option>
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
                                                    value="{{ $data->due_date }}" />

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

                                                <option value="">Select a value</option>
                                                {{-- <option value="">-- select --</option> --}}
                                    {{--  @if ($users->isNotEmpty())
                                                    @foreach ($users as $value)
                                                        <option {{ $data->Customer_Name == $value->id ? 'selected' : '' }}
                                                            value='{{ $value->id }}'>{{ $value->name }}</option>
                                                    @endforeach
                                                @endif
                                         

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
                                                        <option
                                                            {{ $data->Customer_Name == $value->name ? 'selected' : '' }}
                                                            value='{{ $value->name }}'>{{ $value->name }}</option>
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
                                        <option value="A" {{ $data->Submitted_By == 'A' ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ $data->Submitted_By == 'B' ? 'selected' : '' }}>B</option>

                                    </select>
                                </div>
                            </div> --}}

                                    {{-- <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="If Others">Submitted By</label>
                                            <select name="Submit_By" onchange="">

                                                <option value="">Select a value</option>
                                                {{-- <option value="">-- select --</option> --}}
                                    {{-- @if ($users->isNotEmpty())
                                                    @foreach ($users as $value)
                                                        <option {{ $data->Submit_By == $value->id ? 'selected' : '' }}
                                                            value='{{ $value->id }}'>{{ $value->name }}</option>
                                                    @endforeach
                                                @endif --}}
                                    {{-- <option value="">-- select --</option>
                                        <option value=""></option> --}}

                                    {{-- </select>
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="If Others">Submitted By</label>
                                            <select name="Submit_By" onchange="">
                                                <option value="">Select a value</option>
                                                @if ($users->isNotEmpty())
                                                    @foreach ($users as $value)
                                                        <option {{ $data->Submit_By == $value->name ? 'selected' : '' }}
                                                            value='{{ $value->name }}'>{{ $value->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="group-input">
                                            <label for="Description">Description</label>
                                            <textarea class="" name="Description" id="Description">{{ $data->Description }}</textarea>
                                        </div>
                                    </div>


                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Zone">Zone</label>
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
                                            <label for="Country">Country</label>
                                            <select name="country" class="form-select country"
                                                aria-label="Default select example" onchange="loadStates()">
                                                <option value="{{ $data->country }}" selected>
                                                    {{ $data->country }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="City">State</label>
                                            <select name="state" class="form-select state"
                                                aria-label="Default select example" onchange="loadCities()">
                                                <option value="{{ $data->state }}" selected>{{ $data->state }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="State/District">City</label>
                                            <select name="city" class="form-select city"
                                                aria-label="Default select example">
                                                <option value="{{ $data->city }}" selected>{{ $data->city }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Type">Type</label>
                                            <select name="type" onchange="">
                                                <option value="">-- select --</option>
                                                <option value="Type A" {{ $data->type == 'Type A' ? 'selected' : '' }}>
                                                    Type A</option>
                                                <option value="Type B" {{ $data->type == 'Type B' ? 'selected' : '' }}>
                                                    Type B</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Priority Level">Priority Level</label>
                                            <select name="priority_level" onchange="">
                                                <option value="">-- select --</option>
                                                <option value="Priority Level A"
                                                    {{ $data->priority_level == 'Priority Level A' ? 'selected' : '' }}>
                                                    Priority Level A</option>
                                                <option value="Priority Level B"
                                                    {{ $data->priority_level == 'Priority Level B' ? 'selected' : '' }}>
                                                    Priority Level B</option>

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
                                                            <td>1</td>
                                                            <td style="background: #DCD8D8">
                                                                <textarea name="question_1" value="">{{ $data->question_1 }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="response_1"value="">{{ $data->response_1 }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="remark_1"value="">{{ $data->remark_1 }}</textarea>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td style="background: #DCD8D8">
                                                                <textarea name="question_2" value="">{{ $data->question_2 }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="response_2"value="">{{ $data->response_2 }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="remark_2"value="">{{ $data->remark_2 }}</textarea>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>3</td>
                                                            <td style="background: #DCD8D8">
                                                                <textarea name="question_3" value="">{{ $data->question_3 }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="response_3"value="">{{ $data->response_3 }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="remark_3">{{ $data->remark_3 }}</textarea>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>4</td>
                                                            <td style="background: #DCD8D8">
                                                                <textarea name="question_4" value="">{{ $data->question_4 }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="response_4">{{ $data->response_4 }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="remark_4">{{ $data->remark_4 }}</textarea>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>5</td>
                                                            <td style="background: #DCD8D8">
                                                                <textarea name="question_5" value="">{{ $data->question_5 }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="response_5">{{ $data->response_5 }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="remark_5">{{ $data->remark_5 }}</textarea>
                                                            </td>

                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="File Attachments">File Attachments</label>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="file_Attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="file_Attachment[]"
                                                    oninput="addMultipleFiles(this, 'file_Attachment')" multiple>
                                            </div>
                                        </div>

                                    </div>
                                </div> --}}
                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="File Attachments">File Attachments</label>
                                            <div><small class="text-primary">Please Attach all relevant or supporting
                                                    documents</small></div>
                                            {{-- <input type="file" id="myfile" name="file_Attachment" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}
                                            value="{{ $data->file_Attachment }}"> --}}
                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="file_Attachment">
                                                    @if ($data->file_Attachment)
                                                        @foreach (json_decode($data->file_Attachment) as $file)
                                                            <h6 type="button" class="file-container text-dark"
                                                                style="background-color: rgb(243, 242, 240);">
                                                                <b>{{ $file }}</b>
                                                                <a href="{{ asset('upload/' . $file) }}"
                                                                    target="_blank"><i class="fa fa-eye text-primary"
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
                                                        type="file" id="myfile" name="file_Attachment[]"
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
                                                <option value="Related URLs 1"
                                                    {{ $data->Related_URLs == 'Related URLs 1' ? 'selected' : '' }}>Related
                                                    URLs 1</option>
                                                <option value="Related URLs 2"
                                                    {{ $data->Related_URLs == 'Related URLs 2' ? 'selected' : '' }}>Related
                                                    URLs 2</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="sub-head">Product Details</div>


                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Product Type">Product Type</label>
                                            <select name="Product_Type" onchange="">
                                                <option value="">-- select --</option>
                                                <option value="Yes"
                                                    {{ $data->Product_Type == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                <option value="No"
                                                    {{ $data->Product_Type == 'No' ? 'selected' : '' }}>No</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Manufacturer">Manufacturer</label>
                                            <select name="Manufacturer" onchange="">
                                                <option value="">-- select --</option>
                                                <option value="Manufacturer 1"
                                                    {{ $data->Manufacturer == 'Manufacturer 1' ? 'selected' : '' }}>
                                                    Manufacturer 1</option>
                                                <option value="Manufacturer 2"
                                                    {{ $data->Manufacturer == 'Manufacturer 2' ? 'selected' : '' }}>
                                                    Manufacturer 2</option>
                                            </select>
                                        </div>
                                    </div>


                                    {{-- <div class="col-12"> --}}
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
                                                    @if ($grid_Data && is_array($grid_Data->data))
                                                        @foreach ($grid_Data->data as $grid_Data)
                                                            <tr>
                                                                {{-- <td>
                                                                    <input type="text" value="AnkitSharma">
                                                                </td> --}}
                                                                <td>
                                                                    <input disabled type="text"
                                                                        name="product_material[{{ $loop->index }}][serial_number]"
                                                                        value="{{ $loop->index + 1 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        name="product_material[{{ $loop->index }}][Product_name]"
                                                                        value="{{ isset($grid_Data['Product_name']) ? $grid_Data['Product_name'] : '' }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        name="product_material[{{ $loop->index }}][Batch_number]"
                                                                        value="{{ isset($grid_Data['Batch_number']) ? $grid_Data['Batch_number'] : '' }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        name="product_material[{{ $loop->index }}][Expiry_date]"
                                                                        value="{{ isset($grid_Data['Expiry_date']) ? $grid_Data['Expiry_date'] : '' }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        name="product_material[{{ $loop->index }}][Manufactured_date]"
                                                                        value="{{ isset($grid_Data['Manufactured_date']) ? $grid_Data['Manufactured_date'] : '' }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        name="product_material[{{ $loop->index }}][disposition]"
                                                                        value="{{ isset($grid_Data['disposition']) ? $grid_Data['disposition'] : '' }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        name="product_material[{{ $loop->index }}][Comment]"
                                                                        value="{{ isset($grid_Data['Comment']) ? $grid_Data['Comment'] : '' }}">
                                                                </td>
                                                                <td>
                                                                    <button type="button"
                                                                        class="removeRowBtn">remove</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    {{-- @if ($grid_Data && is_array($grid_Data->data))
                                                        @foreach ($grid_Data->data as $grid_Data)
                                                            <tr>
                                                    <td><input disabled type="text"
                                                            name="product_material[0][serial_number]" value="1">
                                                    </td>
                                                    <td><input type="text" name="product_material[0][Product_name]">
                                                    </td>
                                                    <td><input type="text" name="product_material[0][Batch_number]">
                                                    </td>
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
                                                            </tr>
                                                               @endforeach
                                                    @endif --}}
                                                </tbody>



                                            </table>
                                        </div>
                                    </div>
                                    {{-- </div> --}}

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

                                {{-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Supervisor">Supervisor</label>
                                    <select name="Supervisor" onchange="">
                                        <option value="">-- select --</option>
                                        <option value="Supervisor 1st">Supervisor 1st</option>
                                        <option value="Supervisor 2nd">Supervisor 2nd</option>

                                    </select>
                                </div>
                            </div> --}}
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Supervisor">Supervisor</label>
                                        <input type="text" name="Supervisor"
                                            id="Supervisor"value="{{ $data->Supervisor }}">
                                    </div>
                                </div>
                                {{-- 
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Inquiry Date">Inquiry Date</label>

                                        <div class="calenderauditee">
                                            @php
                                                $Date = new \DateTime($data->Inquiry_ate);
                                            @endphp
                                            <input type="text" id="Inquiry_ate" readonly placeholder="DD-MMM-YYYY"
                                                value="{{ $data->Inquiry_ate }}" />
                                            <input type="date" name="Inquiry_ate"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                class="hide-input"value="{{ $data->Inquiry_ate }}"
                                                oninput="handleDateInput(this, 'Inquiry_ate')" />
                                        </div>


                                    </div>
                                </div> --}}

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Inquiry Date">Inquiry Date</label>

                                        <div class="calenderauditee">
                                            @php
                                                $Date = isset($data->Inquiry_ate)
                                                    ? new \DateTime($data->Inquiry_ate)
                                                    : null;
                                            @endphp
                                            {{-- Format the date as desired --}}
                                            <input type="text" id="Inquiry_ate" readonly placeholder="DD-MMM-YYYY"
                                                value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                            <input type="date" name="Inquiry_ate"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                value="{{ $data->Inquiry_ate ?? '' }}" class="hide-input"
                                                oninput="handleDateInput(this, 'Inquiry_ate')" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Inquiry Source">Inquiry Source</label>
                                        <select name="Inquiry_Source" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="Source 1"
                                                {{ $data->Inquiry_Source == 'Source 1' ? 'selected' : '' }}>Source 1
                                            </option>
                                            <option value="Source 2"
                                                {{ $data->Inquiry_Source == 'Source 2' ? 'selected' : '' }}>Source 2
                                            </option>

                                        </select>
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Inquiry Method">Inquiry Method</label>
                                        <select name="Inquiry_method" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="Method 1"
                                                {{ $data->Inquiry_method == 'Method 1' ? 'selected' : '' }}>Method 1
                                            </option>
                                            <option value="Method 2"
                                                {{ $data->Inquiry_method == 'Method 2' ? 'selected' : '' }}>Method 2
                                            </option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Branch">Branch</label>
                                        <select name="branch" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="Indore" {{ $data->branch == 'Indore' ? 'selected' : '' }}>
                                                Indore</option>
                                            <option value="Jabalpure" {{ $data->branch == '2' ? 'selected' : '' }}>
                                                Jabalpure</option>
                                            <option value="Bhopal" {{ $data->branch == 'Bhopal' ? 'selected' : '' }}>
                                                Bhopal</option>
                                            <option value="Dewas" {{ $data->branch == 'Dewas' ? 'selected' : '' }}>Dewas
                                            </option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Branch Manager">Branch Manager</label>
                                        <select name="Branch_manager" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="Manager 1"
                                                {{ $data->Branch_manager == 'Manager 1' ? 'selected' : '' }}>Manager 1
                                            </option>
                                            <option value="Manager 2"
                                                {{ $data->Branch_manager == 'Manager 2' ? 'selected' : '' }}>Manager 2
                                            </option>
                                            <option value="Manager 3"
                                                {{ $data->Branch_manager == 'Manager 3' ? 'selected' : '' }}>Manager 3
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                {{-- 
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Customer Name">Customer Name</label>
                                    <select name="Customer_names" onchange="">
                                        <option value="">-- select --</option>
                                        <option value="1" {{ $data->Customer_names == '1' ? 'selected' : '' }}>A</option>
                                        <option value="2" {{ $data->Customer_names == '2' ? 'selected' : '' }}>B</option>

                                    </select>
                                </div>
                            </div> --}}


                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Customer Name">Customer Name</label>
                                        <select name="Customer_names" onchange="">

                                            <option value="">Select a value</option>
                                                                              @if ($users->isNotEmpty())
                                                @foreach ($users as $value)
                                                    <option {{ $data->Customer_names == $value->name ? 'selected' : '' }}
                                                        value='{{ $value->name }}'>{{ $value->name }}</option>
                                                @endforeach
                                            @endif
                                          

                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="If Others">Customer Name</label>
                                        <select name="Customer_names" onchange="">
                                            <option value="">Select a value</option>
                                            @if ($users->isNotEmpty())
                                                @foreach ($users as $value)
                                                    <option {{ $data->Customer_names == $value->name ? 'selected' : '' }}
                                                        value='{{ $value->name }}'>{{ $value->name }}</option>
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
                                            <option value="Area 1"
                                                {{ $data->Business_area == 'Area 1' ? 'selected' : '' }}>Area 1</option>
                                            <option value="Area 2"
                                                {{ $data->Business_area == 'Area 2' ? 'selected' : '' }}>Area 2</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Account Type">Account Type</label>
                                        <select name="account_type" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="Saving"
                                                {{ $data->account_type == 'Saving' ? 'selected' : '' }}>Saving</option>
                                            <option value="Current"
                                                {{ $data->account_type == 'Current' ? 'selected' : '' }}>Current</option>
                                            <option value="International"
                                                {{ $data->account_type == 'International' ? 'selected' : '' }}>
                                                International</option>


                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Account Number">Account Number</label>
                                        <select name="account_number" onchange="">
                                            <option value="">--Select---</option>
                                            <option value="09876543"
                                                {{ $data->account_number == '09876543' ? 'selected' : '' }}>09876543
                                            </option>
                                            <option value="12345678"
                                                {{ $data->account_number == '12345678' ? 'selected' : '' }}>12345678
                                            </option>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Dispute Amount">Dispute Amount</label>
                                        <select name="dispute_amount" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="Amount 1"
                                                {{ $data->dispute_amount == 'Amount 1' ? 'selected' : '' }}>Amount 1
                                            </option>
                                            <option value="Amount 2"
                                                {{ $data->dispute_amount == 'Amount 2' ? 'selected' : '' }}>Amount 2
                                            </option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Currency">Currency</label>
                                        <select name="currency" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="rupee ⟨₹⟩"
                                                {{ $data->currency == 'rupee ⟨₹⟩' ? 'selected' : '' }}>rupee ⟨₹⟩</option>
                                            <option value="United States Dollar	$"
                                                {{ $data->currency == 'United States Dollar $' ? 'selected' : '' }}>United
                                                States Dollar $</option>
                                            <option value="Euro	€" {{ $data->currency == 'Euro €' ? 'selected' : '' }}>
                                                Euro €</option>
                                            <option value="British Pound £"
                                                {{ $data->currency == 'British Pound £' ? 'selected' : '' }}>British Pound
                                                £</option>



                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Category">Category</label>
                                        <select name="category" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="Category 1"
                                                {{ $data->category == 'Category 1' ? 'selected' : '' }}>Category 1
                                            </option>
                                            <option value="Category 2"
                                                {{ $data->category == 'Category 2' ? 'selected' : '' }}>Category 2
                                            </option>


                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sub Category">Sub Category</label>
                                        <select name="sub_category" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="Sub Category 1"
                                                {{ $data->sub_category == 'Sub Category 1' ? 'selected' : '' }}>Sub
                                                Category 1</option>
                                            <option value="Sub Category 2"
                                                {{ $data->sub_category == 'Sub Category 2' ? 'selected' : '' }}>Sub
                                                Category 2</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="Allegation language">Allegation language</label>
                                        <textarea class="" name="allegation_language" id="allegation_language"> {{ $data->allegation_language }}
                                    </textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="Action Taken">Action Taken</label>
                                        <textarea class="" name="action_taken" id="action_taken">{{ $data->action_taken }}</textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Broker Id">Broker Id</label>
                                        <input type="text" name="broker_id" id="broker_id"
                                            value="{{ $data->broker_id }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Related Inquiries">Related Inquiries</label>
                                        <select name="related_inquiries" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="Inquiries 1"
                                                {{ $data->related_inquiries == 'Inquiries 1' ? 'selected' : '' }}>
                                                Inquiries 1</option>
                                            <option value="Inquiries 2"
                                                {{ $data->related_inquiries == 'Inquiries 2' ? 'selected' : '' }}>
                                                Inquiries 2</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="sub-head">Problem Details</div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Problem Name">Problem Name</label>
                                        <input type="text" name="problem_name"
                                            id="problem_name"value="{{ $data->problem_name }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Problem Type">Problem Type</label>
                                        <select name="problem_type" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="Type 1"
                                                {{ $data->problem_type == 'Type 1' ? 'selected' : '' }}>Type 1</option>
                                            <option value="Type 2"
                                                {{ $data->problem_type == 'Type 2' ? 'selected' : '' }}>Type 2</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Problem Code">Problem Code</label>
                                        <select name="problem_code" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="Code 101"
                                                {{ $data->problem_code == 'Code 101' ? 'selected' : '' }}>Code 101
                                            </option>
                                            <option value="Code 102"
                                                {{ $data->problem_code == 'Code 102' ? 'selected' : '' }}>Code 102
                                            </option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="Comments">Comments</label>
                                        <textarea class="" name="comments" id="comments">{{ $data->comments }}</textarea>
                                    </div>
                                </div>
                                {{-- </div> --}}
                                <div class="button-block">
                                    <button type="submit" class="saveButton">Save</button>
                                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                    <button type="button"> <a class="text-white"
                                            href="{{ url('rcms/qms-dashboard') }}">
                                            Exit </a> </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="sub-head">
                                Signature
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Submited By">Submited By</label>
                                        <div class="static">{{ $data->Submitted_By }}</div>

                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Submited">Submited on </label>
                                        <div class="static">{{ $data->submitted_on }}</div>

                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Comment">Comment </label>
                                        <div class="static">{{ $data->Submited_Comment }}</div>

                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Cancel By">Cancel By</label>
                                        <div class="static">{{ $data->cancel_by }}</div>

                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Cancel">Cancel on </label>
                                        <div class="static">{{ $data->cancel_on }}</div>

                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Comment">Comment </label>
                                        <div class="static">{{ $data->cancel_Comment }}</div>

                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Simple Resolution by">Simple Resolution by</label>
                                        <div class="static">{{ $data->resolution_progress_completed_by }}</div>
                                    </div>
                                </div>

                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Simple Resolution on"> Simple Resolution on </label>
                                        <div class="static">{{ $data->resolution_progress_completed_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Comment">Comment </label>
                                        <div class="static">{{ $data->simple_resol_omment }}</div>

                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Legal Issue Relations/Operational Issue by">Legal Issue
                                            Relations/Operational Issue by</label>
                                        <div class="static">{{ $data->resolution_in_progress_completed_by }}</div>
                                    </div>
                                </div>

                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Legal Issue Relations/Operational Issue on"> Legal Issue
                                            Relations/Operational Issue on </label>
                                        <div class="static">{{ $data->resolution_in_progress_completed_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Comment">Comment </label>
                                        <div class="static">{{ $data->resolution_progress_Comment }}</div>

                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Relations/Operational Issue by">Relations/Operational Issue
                                            by</label>
                                        <div class="static">{{ $data->work_in_progress_completed_by }}</div>
                                    </div>
                                </div>

                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Relations/Operational Issue on"> Relations/Operational Issue on
                                        </label>
                                        <div class="static">{{ $data->work_in_progress_completed_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Comment">Comment </label>
                                        <div class="static">{{ $data->work_in_progress_Comment }}</div>

                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Completed By">Completed By</label>
                                        <div class="static">{{ $data->cash_review_completed_by }}</div>

                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Completedon">Completed on </label>
                                        <div class="static">{{ $data->cash_review_completed_on }}</div>

                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Comment">Comment </label>
                                        <div class="static">{{ $data->completed_Comment }}</div>

                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Resolution by">Resolution by</label>
                                        <div class="static">{{ $data->root_cause_completed_by }}</div>
                                    </div>
                                </div>

                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Resolution on"> Resolution on </label>
                                        <div class="static">{{ $data->root_cause_completed_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Comment">Comment </label>
                                        <div class="static">{{ $data->resolution_Comment }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Resolution By">Resolution By</label>
                                        <div class="static">{{ $data->root_cause_analysis_completed_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Resolution">Resolution on </label>
                                        <div class="static">{{ $data->root_cause_analysis_completed_on }}</div>

                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Comment">Comment </label>
                                        <div class="static">{{ $data->resol_Comment }}</div>

                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="No Analysis Required By">No Analysis Required By</label>
                                        <div class="static">{{ $data->pending_approval_completed_by }}</div>

                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="No Analysis Required">No Analysis Required on </label>
                                        <div class="static">{{ $data->pending_approval_completed_on }}</div>

                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Comment">Comment </label>
                                        <div class="static">{{ $data->no_analysis_Comment }}</div>

                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Analysis Complete By">Analysis Complete By</label>
                                        <div class="static">{{ $data->pending_preventing_action_completed_by }}</div>

                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Analysis Complete">Analysis Complete on </label>
                                        <div class="static">{{ $data->pending_preventing_action_completed_on }}</div>

                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Comment">Comment </label>
                                        <div class="static">{{ $data->analysis_Comment }}</div>

                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Pending Action Completion By">Pending Action Completion By</label>
                                        <div class="static">{{ $data->pending_approval_completed_by }}</div>

                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Pending Action Completion">Pending Action Completion on </label>
                                        <div class="static">{{ $data->pending_approval_completed_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Comment">Comment </label>
                                        <div class="static">{{ $data->pending_approval_Comment }}</div>

                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Reject By">Reject By</label>
                                        <div class="static">{{ $data->rejected_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Reject">Reject on </label>
                                        <div class="static">{{ $data->rejected_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Comment">Comment </label>
                                        <div class="static">{{ $data->reject_Comment }}</div>

                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Approve By">Approve By</label>
                                        <div class="static">{{ $data->approval_completed_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Approve">Approve on </label>
                                        <div class="static">{{ $data->approval_completed_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Comment">Comment </label>
                                        <div class="static">{{ $data->approve_Comment }}</div>
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
                <form action="{{ route('CIStage_change', $data->id) }}" method="POST">
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
                    <!-- <div class="modal-footer">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <button type="submit" data-bs-dismiss="modal">Submit</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <button>Close</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div> -->
                    <div class="modal-footer">
                        <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="direct-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('CIStages_change', $data->id) }}" method="POST">
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
                            <input class="input_width" type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input class="input_width" type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment</label>
                            <input class="input_width" type="comment" name="comment">
                        </div>
                    </div>


                    <!-- Modal footer -->
                    <!-- <div class="modal-footer">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <button type="submit" data-bs-dismiss="modal">Submit</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <button>Close</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div> -->
                    <div class="modal-footer">
                        <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal2">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="person-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('CIStages_changes', $data->id) }}" method="POST">
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
                            <input class="input_width" type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input class="input_width" type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment</label>
                            <input class="input_width" type="comment" name="comment">
                        </div>
                    </div>


                    <!-- Modal footer -->
                    <!-- <div class="modal-footer">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <button type="submit" data-bs-dismiss="modal">Submit</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <button>Close</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div> -->
                    <div class="modal-footer">
                        <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal2">Close</button>
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

                <form action="{{ route('CNStages_change', $data->id) }}" method="POST">
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
                    <div class="modal-footer">
                        <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rejection-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ url('RStages_change', $data->id) }}" method="POST">
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
                    <!-- <div class="modal-footer">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <button type="submit" data-bs-dismiss="modal">Submit</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <button>Close</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div> -->
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
                <form action="{{ route('action_item_show', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="group-input">
                            <label for="major">
                                <input type="radio" name="revision" id="major" value="Action-Item">
                                Action Item
                            </label>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <!-- <div class="modal-footer">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <button type="button" data-bs-dismiss="modal">Close</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <button type="submit">Continue</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div> -->
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

            const selectedCountryName = countrySelect.value;

            $.ajax({
                url: `${config.cUrl}/countries/${selectedCountryName}/states`,
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

            const selectedCountryName = countrySelect.value;
            const selectedStateName = stateSelect.value;

            $.ajax({
                url: `${config.cUrl}/countries/${selectedCountryName}/states/${selectedStateName}/cities`,
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

        function saveSelection() {
            const selectedCountryName = countrySelect.options[countrySelect.selectedIndex].text;
            const selectedStateName = stateSelect.options[stateSelect.selectedIndex].text;
            const selectedCityName = citySelect.options[citySelect.selectedIndex].text;

            console.log('Selected Country:', selectedCountryName);
            console.log('Selected State:', selectedStateName);
            console.log('Selected City:', selectedCityName);

            // Save or use the names as needed
        }

        $(document).ready(function() {
            loadCountries();

            countrySelect.addEventListener('change', loadStates);
            stateSelect.addEventListener('change', loadCities);
            citySelect.addEventListener('change', saveSelection);
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const removeButtons = document.querySelectorAll('.remove-file');

            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const fileName = this.getAttribute('data-file-name');
                    const fileContainer = this.closest('.file-container');

                    // Hide the file container
                    if (fileContainer) {
                        fileContainer.style.display = 'none';
                    }
                });
            });
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
        var maxLength = 240;
        $('#duedoc').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchar').text(textlen);
        });
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
