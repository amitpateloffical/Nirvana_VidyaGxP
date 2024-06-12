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
<style>
    .progress-bars div {
        flex: 1 1 auto;
        border: 1px solid grey;
        padding: 5px;
        text-align: center;
        position: relative;
        /* border-right: none; */
        background: white;
    }

    .state-block {
        padding: 20px;
        margin-bottom: 20px;
    }

    .progress-bars div.active {
        background: green;
        font-weight: bold;
    }

    #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(1) {
        border-radius: 20px 0px 0px 20px;
    }

    #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(5) {
        border-radius: 0px 20px 20px 0px;

    }

    .input_width {
            width: 100%;
            border-radius: 5px;
            margin-bottom: 11px;
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
                    '<td><input disabled type="text" name="drugaccountability['+ serialNumber +'][serial]" value="' + (serialNumber + 1) + '"></td>' +
                    '<td><input type="text" name="drugaccountability['+ serialNumber +'][ProductName]"></td>' +
                    '<td><input type="number" name="drugaccountability['+ serialNumber +'][BatchNumber]"></td>' +
                    '<td><input type="date" name="drugaccountability['+ serialNumber +'][ExpiryDate]"></td>' +
                    '<td><input type="text" name="drugaccountability['+ serialNumber +']UnitsReceived"></td>' +
                    '<td><input type="text" name="drugaccountability['+ serialNumber +'][UnitsDispensed]"></td>' +
                    '<td><input type="text" name="drugaccountability['+ serialNumber +'][UnitsDestroyed]"></td>' +
                    '<td><input type="date" name="drugaccountability['+ serialNumber +'][ManufacturedDate]"></td>' +
                    '<td><input type="text" name="drugaccountability['+ serialNumber +'][Strength]"></td>' +
                    '<td><input type="text" name="drugaccountability['+ serialNumber +'][Form]"></td>' +
                    '<td><input type="text" name="drugaccountability['+ serialNumber +'][Remarks]"></td>' +
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
                    '<td><input disabled type="text" name="equipment['+ serialNumber +'][serial]" value="' +( serialNumber+1) + '"></td>' +
                    '<td><input type="text" name="equipment['+ serialNumber +'][Product_Name]"></td>' +
                    '<td><input type="number" name="equipment['+ serialNumber +'][Batch_Number]"></td>' +
                    '<td><input type="date" name="equipment['+ serialNumber +'][Expiry_Date]"></td>' +
                    '<td><input type="date" name="equipment['+ serialNumber +'][Manufactured_Date]"></td>' +
                    '<td><input type="number" name="equipment['+ serialNumber +'][Number_of_Items_Needed]"></td>' +
                    '<td><input type="text" name="equipment['+ serialNumber +'][Exist]"></td>' +
                    '<td><input type="text" name="equipment['+ serialNumber +'][Comment]"></td>' +
                    '<td><input type="text" name="equipment['+ serialNumber +'][Remarks]"></td>' +
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
                    '<td><input disabled type="text" name="financialTransactions['+serialNumber +'][serial]" value="' + (serialNumber+1) + '"></td>' +
                    '<td><input type="text" name="financialTransactions['+serialNumber +'][Transaction]"></td>' +
                    '<td><input type="text" name="financialTransactions['+serialNumber +'][Transaction_Type]"></td>' +
                    '<td><input type="date" name="financialTransactions['+serialNumber +'][Date]"></td>' +
                    '<td><input type="text" name="financialTransactions['+serialNumber +'][Amount]"></td>' +
                    '<td><input type="text" name="financialTransactions['+serialNumber +'][Currency_Used]"></td>' +
                    '<td><input type="text" name="financialTransactions['+serialNumber +'][Remarks]"></td>' +
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

        <div class="inner-block state-block">
            <div class="d-flex justify-content-between align-items-center">
                <div class="main-head">Record Workflow</div>
                <div class="d-flex" style="gap:20px;">
                    {{-- @if(Auth::check() && isset($data)) --}}
                    @php
                    $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id])->get();
                    $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                    @endphp
                        <button class="button_theme1">
                            <a class="text-white" href="{{ route('clinicalsiteAuditReport', $data->id) }}">Audit Trail</a>
                        </button>
        
                        @if ($data->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">To Implementation Phase</button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#direct-modal">Archive</button> --}}
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#direct-modal">Archive</button>

                        @elseif($data->stage == 2 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#back-modal">Return</button>
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal1">Child</button> --}}
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">Received SR Approval</button>
                        @elseif($data->stage == 3 && (in_array(18, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">Received Confirmation</button>
                        @elseif($data->stage == 4 && (in_array(18, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">To SAE Storage</button>
                        @elseif($data->stage == 5 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#back-modal">Return</button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">Close</button>
                        @endif
                        <button class="button_theme1">
                            <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a>
                        </button>
                    {{-- @else
                        <p>User is not authenticated or data is not available.</p> --}}
                    {{-- @endif --}}
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
                    <div class="progress-bars d-flex">
                        @if ($data->stage >= 1)
                            <div class="active">Opened</div>
                        @else
                            <div class="">Opened</div>
                        @endif
        
                        @if ($data->stage >= 2)
                            <div class="active">Implementation Phase</div>
                        @else
                            <div class="">Implementation Phase</div>
                        @endif
        
                        @if ($data->stage >= 3)
                            <div class="active">Pending</div>
                        @else
                            <div class="">Pending</div>
                        @endif
        
                        @if ($data->stage >= 4)
                            <div class="active">In Effect</div>
                        @else
                            <div class="">In Effect</div>
                        @endif

        
                        @if ($data->stage >= 5)
                            <div class="bg-danger">Closed - Done</div>
                        @else
                            <div class="">Closed - Done</div>
                        @endif
                    </div>
                @endif
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
        </div>
        



        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Clinical Site</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Site Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Useful Tools</button>
        </div>

        <!-- Tab content -->

        <form action="{{ route('clinicupdate',$data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf 
            @method('PUT') 
        <div id="CCForm1" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="row">

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="RLS Record Number"><b>Record Number</b></label>
                            {{-- <input disabled type="text" name="record" value=""> --}}
                            {{-- <input disabled type="text" name="record" value=" {{ Helpers::getDivisionName(session()->get('division')) }}/LI/{{ date('Y') }}/{{ $record}}"> --}}
                            <input disabled type="text" name="record" id="record" 
                            value="">
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
                            <input type="text" disabled name="initiator" value="">
                        </div>
                    </div>
                    <div class="col-md-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="opened-date">Date of Initiation<span class="text-danger"></span></label>
                            <div class="calenderauditee">
                                <input type="text" disabled id="opened_date" placeholder="DD-MMM-YYYY" />
                                <input type="date" disabled name="intiation_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'opened_date')" />
                            </div>
                        </div>
                    </div>
                   
                    <div class="col-12">
                        <div class="group-input">
                            <label for="Short Description">Short Description<span class="text-danger">*</span></label>
                            <div><small >255 characters remaining</small></div>
                            <input id="short-description" type="text" name="short_description" maxlength="255" required value="{{ $data->short_description }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="assigned_to">
                                Assigned To <span class="text-danger"></span>
                            </label>
                            <div><small class="text-primary">Person Responsible</small></div>
                            <select id="select-state" placeholder="Select..." name="assign_to">
                                <option value="">Select a value</option>
                                <option value="">$1</option>
                                <option value="">$2</option>
                                <option value="">$3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="due-date">Due Date <span class="text-danger"></span></label>
                            <div><small class="text-primary">Please mention expected date of completion</small></div>
                            <div class="calenderauditee">
                                <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="type">
                                Type <span class="text-danger"></span>
                            </label>
                            <!-- <div><small class="text-primary">Select type of site</small></div> -->
                            <select id="select-state" placeholder="Select..." name="type">
                                <option value="">Enter your selection here</option>
                                <option value="">$1</option>
                                <option value="">$2</option>
                                <option value="">$3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Site Name"><b>Name of Site</b></label>
                            <input type="text" name="site_name" value="">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="group-input">
                            <label for="Source_Documents">Source Documents</label>
                            <div class="file-attachment-field">
                                <div class="file-attachment-list" id="source_documents">
                                    @if ($data->source_documents)
                                    @foreach (json_decode($data->source_documents) as $file)
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
                                    <input type="file" id="myfile" name="source_documents[]" oninput="addMultipleFiles(this, 'Source_Documents')" multiple>
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
                                <div class="file-attachment-list" id="attached_files">

                                    @if ($data->attached_files)
                                    @foreach (json_decode($data->attached_files) as $file)
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
                                <option value="">$1</option>
                                <option value="">$2</option>
                                <option value="">$3</option>
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
                                    @php
                                        $drugindex = 1;
                                    @endphp
                                @if (!@empty($drug_accou) && is_array($drug_accou->data))
                                @foreach ($drug_accou->data as $index=>$item)
                                    

                                <tr>
                                 <td><input disabled type="text" name="drugaccountability[{{ $index }}][serial]" value="{{ $drugindex++ }}"></td>
                                 <td><input type="text" name="drugaccountability[{{ $index }}][ProductName]" value="{{ $item['ProductName'] }}"></td>
                                 <td><input type="number" name="drugaccountability[{{ $index }}][BatchNumber]" value="{{ $item['BatchNumber'] }}"></td>
                                 <td><input type="date" name="drugaccountability[{{ $index }}][ExpiryDate]" value="{{ $item['ExpiryDate'] }}"></td>
                                 <td><input type="text" name="drugaccountability[{{ $index }}][UnitsReceived]" value="{{ $item['UnitsReceived'] }}"></td>
                                 <td><input type="text" name="drugaccountability[{{ $index }}][UnitsDispensed]" value="{{ $item['UnitsDispensed'] }}"></td>
                                 <td><input type="text" name="drugaccountability[{{ $index }}][UnitsDestroyed]" value="{{ $item['UnitsDestroyed'] }}"></td>
                                 <td><input type="date" name="drugaccountability[{{ $index }}][ManufacturedDate]" value="{{ $item['ManufacturedDate'] }}"></td>
                                 <td><input type="text" name="drugaccountability[{{ $index }}][Strength]" value="{{ $item['Strength'] }}"></td>
                                 <td><input type="text" name="drugaccountability[{{ $index }}][Form]" value="{{ $item['Form'] }}"></td>
                                 <td><input type="text" name="drugaccountability[{{ $index }}][Remarks]" value="{{ $item['Remarks'] }}"></td>
                                 
                             </tr>
                                @endforeach
                               @else
                            <tr>
                                <td> no found</td>
                            </tr>
                                @endif
                                    

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
                                    @php
                                    $equIndex = 1;
                                @endphp
                                
                                @if (!@empty($equipment) && is_array($equipment->data ))
                                    @foreach ($equipment->data as $index => $item)
                                        <tr>
                                            <td><input disabled type="text" name="[{{ $index }}][serial]" value="{{ $equIndex++ }}"></td>
                                            <td><input type="text" name="equipment[{{ $index }}][Product_Name]" value="{{ $item['Product_Name'] }}"></td>
                                            <td><input type="text" name="equipment[{{ $index }}][Batch_Number]" value="{{ $item['Batch_Number'] }}"></td>
                                            <td><input type="date" name="equipment[{{ $index }}][Expiry_Date]" value="{{ $item['Expiry_Date'] }}"></td>
                                            <td><input type="date" name="equipment[{{ $index }}][Manufactured_Date]" value="{{ $item['Manufactured_Date'] }}"></td>
                                            <td><input type="text" name="equipment[{{ $index }}][Number_of_Items_Needed]" value="{{ $item['Number_of_Items_Needed'] }}"></td>
                                            <td><input type="text" name="equipment[{{ $index }}][Exist]" value="{{ $item['Exist'] }}"></td>
                                            <td><input type="text" name="equipment[{{ $index }}][Comment]" value="{{ $item['Comment'] }}"></td>
                                            <td><input type="text" name="equipment[{{ $index }}][Remarks]" value="{{ $item['Remarks'] }}"></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9">No equipment data found</td>
                                    </tr>
                                @endif
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
                                <div class="file-attachment-list" id="consent_form">

                                    @if ($data->consent_form)
                                    @foreach (json_decode($data->consent_form) as $file)
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
                                    <input type="file" id="consent_form" name="consent_form[]" oninput="addMultipleFiles(this, 'consent_form')" multiple>
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
                                <div class="file-attachment-list" id="attached_payments">
                                    @if ($data->attached_payments)
                                    @foreach (json_decode($data->attached_payments) as $file)
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
                                    @php
                                        $finanIndex=1;
                                    @endphp
                                    @if(!@empty($finan_transa) && is_array($finan_transa->data))
                                    @foreach ($finan_transa->data as $index=>$item )
                                        
                                    <tr>
                                        <td><input disabled type="text" name="[{{ $index }}][serial]" value="{{  $finanIndex++ }}"></td>
                                        <td><input type="text" name="[{{ $index }}][Transaction]" value="{{ $item['Transaction'] }}"></td>
                                        <td><input type="text" name="[{{ $index }}][Transaction_Type]" value="{{ $item['Transaction_Type'] }}"></td>
                                        <td><input type="date" name="[{{ $index }}][Date]" value="{{ $item['Date'] }}"></td>
                                        <td><input type="text" name="[{{ $index }}][Amount]" value="{{ $item['Amount'] }}"></td>
                                        <td><input type="text" name="[{{ $index }}][Currency_Used]" value="{{ $item['Currency_Used'] }}"></td>
                                        <td><input type="text" name="[{{ $index }}][Remarks]" value="{{ $item['Remarks'] }}"></td>
                                    </tr>
                                    @endforeach
                                    @endif
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
