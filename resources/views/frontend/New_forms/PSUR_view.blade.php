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
</style>

<div class="form-field-head">
    {{-- <div class="pr-id">
            New Child
        </div> --}}
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        /RT- PSUR
    </div>
</div>


<script>
    $(document).ready(function() {
        let parentDataIndex = {{ $parentData && is_array($parentData) ? count($parentData) : 1 }};
        $('#ATC_codes').click(function(e) {
            function generateTableRow(serialNumber) {
                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                    '"></td>' +
                    '<td><input type="text" name="ATCCodes[' + parentDataIndex + '][atc_Search]"></td>' +
                    '<td><input type="text" name="ATCCodes[' + parentDataIndex + '][1st_Level]"></td>' +
                    '<td><input type="text" name="ATCCodes[' + parentDataIndex + '][2nd_Level]"></td>' +
                    '<td><input type="text" name="ATCCodes[' + parentDataIndex + '][3rd_Level]"></td>' +
                    '<td><input type="text" name="ATCCodes[' + parentDataIndex + '][4th_Level]"></td>' +
                    '<td><input type="text" name="ATCCodes[' + parentDataIndex + '][5th_Level]"></td>' +
                    '<td><input type="text" name="ATCCodes[' + parentDataIndex + '][atc_Code]"></td>' +
                    '<td><input type="text" name="ATCCodes[' + parentDataIndex + '][substance]"></td>' +
                    '<td><input type="text" name="ATCCodes[' + parentDataIndex + '][remarks]"></td>' +
                    '<td><button type="text" class="removeRowBtn">Remove</button></td>' +
                    '</tr>';
                '</tr>';
                parentDataIndex++;
                return html;
            }

            var tableBody = $('#ATC_codes-table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>


{{-- <script>
    $(document).ready(function() {
        let $ingridentDataIndex = {{ $ingridentData && is_array($ingridentData) ? count($ingridentData) : 1 }};
        $('#Ingredients').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + (serialNumber+1) + '"></td>' +
                        '<td><input type="text" name="ingridents[' + $ingridentDataIndex + '][ingredient_Type]"></td>' +
                        '<td><input type="text" name="ingridents[' + $ingridentDataIndex + '][ingredient_Name]"></td>' +
                        '<td><input type="text" name="ingridents[' + $ingridentDataIndex + '][ingredient_Strength]"></td>' +
                        '<td><input type="text" name="ingridents[' + $ingridentDataIndex + '][Specification_Date]"></td>' +
                        '<td><input type="text" name="ingridents[' + $ingridentDataIndex + '][Remarks]"></td>' +
                       '<td><button type="text" class="removeRowBtn">Remove</button></td>' +

                '</tr>';
                        ingridentDataIndex++;

                return html;
            }

            var tableBody = $('#Ingredients-first-table');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script> --}}


<script>
    $(document).ready(function() {
        let ingridentDataIndex = {{ $ingridentData && is_array($ingridentData) ? count($ingridentData) : 1 }};

        $('#Ingredients').click(function(e) {
            function generateTableRow(serialNumber) {
                var html =
                    '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                    '"></td>' +
                        // '<td><input disabled type="text" name="serial[]" value="' + (serialNumber + 1) + '"></td>' +
                        '<td><input type="text" name="ingridents[' + ingridentDataIndex + '][ingredient_Type]"></td>' +
                        '<td><input type="text" name="ingridents[' + ingridentDataIndex + '][ingredient_Name]"></td>' +
                        '<td><input type="text" name="ingridents[' + ingridentDataIndex + '][ingredient_Strength]"></td>' +
                        '<td><input type="text" name="ingridents[' + ingridentDataIndex + '][Specification_Date]"></td>' +
                        '<td><input type="text" name="ingridents[' + ingridentDataIndex + '][Remarks]"></td>' +
                        '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                    '</tr>';
                ingridentDataIndex++;
                return html;
            }

            var tableBody = $('#Ingredients-first-table');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount);
            tableBody.append(newRow);
        });

        // // Event delegation for dynamically added "Remove" buttons
        // $('#Ingredients-first-table').on('click', '.removeRowBtn', function(e) {
        //     $(this).closest('tr').remove();
        // });
    });
</script>

<script>
    $(document).ready(function() {
        let ProductDataIndex = {{ $ProductData && is_array($ProductData) ? count($ProductData) : 1 }};

        $('#productAdd').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value=value="' + (serialNumber+1) +
                        '"></td>' +
                        '<td><input type="text" name="Product[' + ProductDataIndex + '][Batch_number]"></td>' +
                        '<td><input type="text" name="Product[' + ProductDataIndex+ '][Expiry_date]"></td>' +
                        '<td><input type="text" name="Product[' + ProductDataIndex+ '][Manufactured_date]"></td>' +
                        '<td><input type="text" name="Product[' + ProductDataIndex+ '][Disposition_date]"></td>' +
                        '<td><input type="text" name="Product[' + ProductDataIndex+ '][Comments_date]"></td>' +
                        '<td><input type="text" name="Product[' + ProductDataIndex+ '][Remarks]"></td>' +
                        '<td><button type="text" class="removeRowBtn">Remove</button></td>' +
                        '</tr>';

                productDataIndex++;
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
        let informationDataindex = {{  $informationData && is_array( $informationData) ? count( $informationData) : 1 }};
        $('#Packaging_Information').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + (serialNumber+1) +
                        '"></td>' +

                     '<td><input type="text" name="Packaging Information[' +  informationDataindex + '][Primary_Packaging]"></td>'
                     '<td><input type="text" name="Packaging Information[' +  informationDataindex + '][Material]"></td>' +
                     '<td><input type="text" name="Packaging Information[' +  informationDataindex + '][Pack_Size]"></td>' +
                     '<td><input type="text" name="Packaging Information[' +  informationDataindex + '][Shelf_Life]"></td>' +
                     '<td><input type="text" name="Packaging Information[' +  informationDataindex + '][Storage_Condition]"></td>' +
                     '<td><input type="text" name="Packaging Information[' +  informationDataindex + '][Secondary_Packaging]"></td>' +
                     '<td><input type="text" name="Packaging Information[' +  informationDataindex + '][Remarks]"></td>' +
                    '<td><button type="text" class="removeRowBtn">Remove</button></td>' +
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


{{-- <script>
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


                return html;
            }

            var tableBody = $('#Equipment_details tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script> --}}

{{-- ! ========================================= --}}
{{-- !               Record workflow             --}}
{{-- ! ========================================= --}}


<div id="change-control-fields">
    <div class="container-fluid">
        <div class="inner-block state-block">
            <div class="d-flex justify-content-between align-items-center">
                <div class="main-head">Record Workflow </div>

                <div class="d-flex" style="gap:20px;">
                     @php
                        $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id])->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();

                    @endphp
                    <button class="button_theme1" onclick="window.print();return false;"
                        class="new-doc-btn">Print</button>
                        <button class="button_theme1"> <a class="text-white" href="{{ route('psur_audittrail', $PSUR->id) }}">
                            Audit Trail </a> </button>

                    @if ($PSUR->stage == 1)
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Start
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                            Cancel
                        </button>
                         {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                            Child --}}
                    @elseif($PSUR->stage == 2 )

                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                            Child
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                            Request More info
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Submit for Review
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Cancel
                        </button>

                        @elseif($PSUR->stage == 3 )

                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Submit
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                            Request More info
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Cancel
                        </button>
                        @elseif($PSUR->stage == 4 )

                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                            Child
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Withdraw
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            PSUR Accepted
                        </button>

                        @endif

                    <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                        </a> </button>


                </div>

            </div>
            <div class="status">
                <div class="head">Current Status</div>
                 @if ($PSUR->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                        @elseif ($PSUR->stage == -1)
                        <div class="progress-bars">
                            <div class="bg-danger"> Closed – Withdrawn
                            </div>
                        </div>

                        @else
                        <div class="progress-bars d-flex">
                            @if ($PSUR->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($PSUR->stage >= 2)
                                <div class="active">Submission Preparation</div>
                            @else
                                <div class="">Submission Preparation</div>
                            @endif

                            @if ($PSUR->stage >= 3)
                               <div class="active">Pending Submission Review</div>
                            @else
                               <div class="">Pending Submission Review</div>
                             @endif
                            @if ($PSUR->stage >= 4)
                              <div class="active">Authority Assesment</div>
                             @else
                              <div class="">Authority Assesment</div>
                             @endif
                        @if ($PSUR->stage >= 5)
                        <div class="bg-danger">Closed Done</div>
                       @else
                        <div class="">Closed Done</div>
                    @endif
                    @endif
                        </div>



        </div>
    </div>
    <div class="control-list">
        @php
            $users = DB::table('users')->get();
        @endphp

{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}

<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">PSUR</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Analysis and Conclusions</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Product Information</button>
            {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Manufacture Details</button> --}}
            <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Registration Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Activity Log</button>

        </div>

        <form action="{{ route('PSUR_Update',$PSUR->id) }}" method="POST" enctype="multipart/form-data">
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
                                    <label for="Initiator">Initiator</label>
                                    <input type="hidden" name="initiator" value="{{ auth()->id() }}">
                                    <input disabled type="text" name="initiator " value="{{ auth()->user()->name }}">

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input ">
                                    <label for="Date Of Initiation"><b>Date Of Initiation</b></label>
                                    <input readonly type="text" value="{{ date('d-m-Y') }}" name="date_of_initiation">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" name="date_of_initiation">

                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Initiator Group Code">Short Description<span class="text-danger">*</span></label>
                                    {{-- <p class="text-primary">PSUR Short Description to be presented on dekstop</p> --}}
                                    <input type="text" name="short_description" id="initiator_group_code" value="{{ $PSUR->short_description}}">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Record">Record no.</label>
                                    <input disabled type="text" name="record"
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}PSUR/{{ date('Y') }}/{{ $PSUR->record }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="If Others">Assigned To</label>
                                    <select name="assigned_to" onchange="">
                                        <option value="">-- select --</option>
                                        <option value="1"{{ $PSUR->assigned_to == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $PSUR->assigned_to == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $PSUR->assigned_to == '3' ? 'selected':''}}>3</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Due Date">Date Due</label>
                                    <p class="text-primary"> last date this record should be closed by</p>
                                        <div class="calenderauditee">
                                            <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" name="due_date" value="{{ Helpers::getdateFormat($PSUR->due_date) }}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" />
                                            <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ \Carbon\Carbon::now()->addDays(30)->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                        </div>

                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Documents">Documents</label>
                                    <input type="text" name="documents" id="initiator_group_code" value="{{ $PSUR->documents}}">
                                </div>
                            </div>


                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Inv Attachments"> Attached Files</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="file_attachment">
                                            @if ($PSUR->file_attachment)
                                                @foreach(json_decode($PSUR->file_attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                            @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                                <input value="{{ $PSUR->file_attachment }}" type="file" id="myfile" name="file_attachment[]" oninput="addMultipleFiles(this, 'file_attachment')" multiple>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const removeButtons = document.querySelectorAll('.remove-file');

                                    removeButtons.forEach(button => {
                                        button.addEventListener('click', function () {
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

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Type</label>
                                    <select name="type_new" onchange="">
                                        <option value="">-- select --</option>
                                        <option value="1"{{ $PSUR->type_new == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $PSUR->type_new == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $PSUR->type_new == '3' ? 'selected':''}}>3</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Year">Year</label>
                                    <select name="year" onchange="">
                                        <option value="">-- select --</option>
                                        <option value="Jan"{{ $PSUR->year == 'Jan' ? 'selected':''}}>jan</option>
                                        <option value="Feb"{{ $PSUR->year == 'Feb' ? 'selected':''}}>fab</option>
                                        <option value="Mar"{{ $PSUR->year == 'Mar' ? 'selected':''}}>mar</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Actual Start Date">Actual Start Date</label>

                                    <div class="calenderauditee">
                                        <input type="text" id="actual_start_date" readonly placeholder="DD-MMM-YYYY" name="actual_start_date" value="{{ Helpers::getdateFormat($PSUR->actual_start_date) }}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" />
                                        <input type="date" name="actual_start_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'actual_start_date')" />
                                    </div>


                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Actual End Date">Actual End Date</label>

                                    <div class="calenderauditee">
                                        <input type="text" id="actual_end_date" readonly placeholder="DD-MMM-YYYY" name="actual_end_date" value="{{ Helpers::getdateFormat($PSUR->actual_end_date) }}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" />
                                        <input type="date" name="actual_end_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'actual_end_date')" />
                                    </div>


                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Authority Type">(Parent)Authority Type</label>
                                    <select name="authority_type" onchange="">
                                        <option value="">-- select --</option>
                                        <option value="1"{{ $PSUR->authority_type == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $PSUR->authority_type == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $PSUR->authority_type == '3' ? 'selected':''}}>3</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Authority">Authority</label>
                                    <p class="text-primary"> Enity responsible for report</p>
                                    <select name="authority" onchange="">
                                        <option value="">-- select --</option>
                                        <option value="1"{{ $PSUR->authority == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $PSUR->authority == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $PSUR->authority == '3' ? 'selected':''}}>3</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="group-input">
                                    <label for="Introduction">Introduction</label>
                                    <textarea class="text" name="introduction" id="text" value="">{{ $PSUR->introduction}}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Related Records">Related Records</label>
                                    <select name="related_records" onchange="">
                                        <option value="">{{ $PSUR->related_records}}</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>

                                    </select>
                                </div>
                            </div>

                            <div class="sub-head">Action Taken</div>

                            <div class="col-md-12">
                                <div class="group-input">
                                    <label for="World MA Status">World MA Status</label> <textarea class="" name="world_ma_status" id="" value="">{{ $PSUR->world_ma_status}}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="RA Actions Taken">RA Actions Taken</label>
                                    <textarea class="" name="ra_actions_taken" id="" value="">{{ $PSUR->ra_actions_taken}}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="MAH Actions Taken">MAH Actions Taken</label>
                                    <textarea class="" name="mah_actions_taken" id="" value="">{{ $PSUR->mah_actions_taken}}
                                    </textarea>
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
                            <div class="sub-head col-12">Findings and Analysis</div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Changes To SafetyInformation">Changes To Safety Information</label>
                                    <textarea class="" name="changes_to_safety_information" id="" value="">{{ $PSUR->changes_to_safety_information}}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Patient Exposure">Patient Exposure</label>
                                    <textarea class="" name="patient_exposure" id="" value="">{{ $PSUR->patient_exposure}}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Analysis of Individual Case">Analysis of Individual Case</label>
                                    <textarea class="" name="analysis_of_individual_case" id="" value="">{{ $PSUR->analysis_of_individual_case}}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Newly Analyzed Studies">Newly Analyzed Studies</label>
                                    <textarea class="" name="newly_analyzed_studies" id="" value="">{{ $PSUR->newly_analyzed_studies}}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Target and New Safety Studies">Target and New Safety Studies</label>
                                    <textarea class="" name="target_and_new_safety_studies" id="" value="">{{ $PSUR->target_and_new_safety_studies}}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Publish Safety Studies">Publish Safety Studies</label>
                                    <textarea class="" name="publish_safety_studies" id="" value="">{{ $PSUR->publish_safety_studies}}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Efficacy-Related Information">Efficacy-Related Information</label>
                                    <textarea class="" name="efficiency_related_info" id="" value="">{{ $PSUR->efficiency_related_info}}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Late-Breaking Information">Late-Breaking Information</label>
                                    <textarea class="" name="late_breaking_information" id="" value="">{{ $PSUR->late_breaking_information}}
                                    </textarea>
                                </div>
                            </div>

                            <div class="sub-head">Conclusion</div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Overall Safety Evaluation">Overall Safety Evaluation</label>
                                    <textarea class="" name="overall_safety_evaluation" id="" value="">{{ $PSUR->overall_safety_evaluation}}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Conclusion">Conclusion</label>
                                    <textarea class="" name="conclusion" id="" value="">{{ $PSUR->conclusion}}
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
                            Product Information
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Manufaturer">(Root Parent) Manufacturer</label>
                                    <select name="root_parent_manufaturer" onchange="">
                                        <option value="">-- select --</option>
                                        <option value="a"{{ $PSUR->root_parent_manufaturer == 'a' ? 'selected':''}}>a</option>
                                        <option value="b"{{ $PSUR->root_parent_manufaturer == 'b' ? 'selected':''}}>b</option>
                                        <option value="c"{{ $PSUR->root_parent_manufaturer == 'c' ? 'selected':''}}>c</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Product Type">(Root Parent) Product Type</label>
                                    <select name="root_parent_product_type" onchange="">
                                        <option value="">--select--</option>
                                        <option value="a"{{ $PSUR->root_parent_product_type == 'a' ? 'selected':''}}>a</option>
                                        <option value="b"{{ $PSUR->root_parent_product_type == 'b' ? 'selected':''}}>b</option>
                                        <option value="c"{{ $PSUR->root_parent_product_type == 'c' ? 'selected':''}}>c</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Trade Name">(Root Parent)Trade Name</label>
                                    <select name="root_parent_trade_name" onchange="">
                                        <option value="">-- select --</option>
                                        <option value="a"{{ $PSUR->root_parent_trade_name == 'a' ? 'selected':''}}>a</option>
                                        <option value="b"{{ $PSUR->root_parent_trade_name == 'b' ? 'selected':''}}>b</option>
                                        <option value="c"{{ $PSUR->root_parent_trade_name == 'c' ? 'selected':''}}>c</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="International Birth Date">(Root Parent)International Birth Date</label>

                                    <div class="calenderauditee">
                                        <input type="text" id="international_birth_date" readonly placeholder="DD-MMM-YYYY" name="international_birth_date" value="{{ Helpers::getdateFormat($PSUR->international_birth_date) }}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" />
                                        <input type="date" name="international_birth_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'international_birth_date')" />
                                    </div>


                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Route of API">(Root Parent)API</label>

                                    <select name="root_parent_api" onchange="">
                                        <option value="">--select--</option>
                                        <option value="a"{{ $PSUR->root_parent_api == 'a' ? 'selected':''}}>a</option>
                                        <option value="b"{{ $PSUR->root_parent_api == 'b' ? 'selected':''}}>b</option>
                                        <option value="c"{{ $PSUR->root_parent_api == 'c' ? 'selected':''}}>c</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Product Strength">(Root Parent)Product Strength</label>
                                    <select name="root_parent_product_strength" onchange="">
                                        <option value="">-- select --</option>
                                        <option value="a"{{ $PSUR->root_parent_product_strength == 'a' ? 'selected':''}}>a</option>
                                        <option value="b"{{ $PSUR->root_parent_product_strength == 'b' ? 'selected':''}}>b</option>
                                        <option value="c"{{ $PSUR->root_parent_product_strength == 'c' ? 'selected':''}}>c</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Route of Administration">(Root Parent)Route of Administration</label>

                                    <select name="route_of_administration" onchange="">
                                        <option value="">-- select --</option>
                                        <option value="a"{{ $PSUR->route_of_administration == 'a' ? 'selected':''}}>a</option>
                                        <option value="b"{{ $PSUR->route_of_administration == 'b' ? 'selected':''}}>b</option>
                                        <option value="c"{{ $PSUR->route_of_administration == 'c' ? 'selected':''}}>c</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Dosage Form">(Root Parent)Dosage Form</label>
                                    <select name="root_parent_product_dosage_form" onchange="">
                                        <option value="">-- select --</option>
                                        <option value="a"{{ $PSUR->root_parent_product_dosage_form == 'a' ? 'selected':''}}>a</option>
                                        <option value="b"{{ $PSUR->root_parent_product_dosage_form == 'b' ? 'selected':''}}>b</option>
                                        <option value="c"{{ $PSUR->root_parent_product_dosage_form == 'c' ? 'selected':''}}>c</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="ATC_codes">
                                        (Root Parent) ATC Codes (0)
                                        <button type="button" id="ATC_codes">+</button>
                                        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="ATC_codes-table">
                                            <thead>
                                                <tr>
                                                    <th>Row #</th>
                                                    <th>ATC Search</th>
                                                    <th>1st Level</th>
                                                    <th>2nd Level</th>
                                                    <th>3rd Level</th>
                                                    <th>4th Level</th>
                                                    <th>5th Level</th>
                                                    <th>ATC Code</th>
                                                    <th>Substance</th>
                                                    <th>Remarks</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @if ($parentData && is_array($parentData))
                                                                @foreach ($parentData as $gridData)
                                                                    <tr>
                                                                        <td> <input disabled type="text" name="ATCCodes[{{ $loop->index }}][serial]" value="{{ $loop->index+1 }}"></td>
                                                                        <td>
                                                                            <input class="currentDocNumber" type="text" name="ATCCodes[{{ $loop->index }}][atc_Search]" value="{{ isset($gridData['atc_Search']) ? $gridData['atc_Search'] : '' }}">
                                                                        </td>
                                                                        <td>
                                                                            <input class="currentVersionNumber" type="text" name="ATCCodes[{{ $loop->index }}][1st_Level]" value="{{ isset($gridData['1st_Level']) ? $gridData['1st_Level'] : '' }}">
                                                                        </td>
                                                                        <td>
                                                                            <input class="newDocNumber" type="text" name="ATCCodes[{{ $loop->index }}][2nd_Level]" value="{{ isset($gridData['2nd_Level']) ? $gridData['2nd_Level'] : '' }}">
                                                                        </td>
                                                                        <td>
                                                                            <input class="newVersionNumber" type="text" name="ATCCodes[{{ $loop->index }}][3rd_Level]" value="{{ isset($gridData['3rd_Level']) ? $gridData['3rd_Level'] : '' }}">
                                                                        </td>
                                                                        <td>
                                                                            <input class="newVersionNumber" type="text" name="ATCCodes[{{ $loop->index }}][4th_Level]" value="{{ isset($gridData['4th_Level']) ? $gridData['4th_Level'] : '' }}">
                                                                        </td>
                                                                        <td>
                                                                            <input class="newVersionNumber" type="text" name="ATCCodes[{{ $loop->index }}][5th_Level]" value="{{ isset($gridData['5th_Level']) ? $gridData['5th_Level'] : '' }}">
                                                                        </td>
                                                                        <td>
                                                                            <input class="newVersionNumber" type="text" name="ATCCodes[{{ $loop->index }}][atc_Code]" value="{{ isset($gridData['atc_Code']) ? $gridData['atc_Code'] : '' }}">
                                                                        </td>
                                                                        <td>
                                                                            <input class="newVersionNumber" type="text" name="ATCCodes[{{ $loop->index }}][substance]" value="{{ isset($gridData['substance']) ? $gridData['substance'] : '' }}">
                                                                        </td>
                                                                        <td>
                                                                            <input class="newVersionNumber" type="text" name="ATCCodes[{{ $loop->index }}][remarks]" value="{{ isset($gridData['remarks']) ? $gridData['remarks'] : '' }}">
                                                                        </td>
                                                                        <td><input type="button"><button class="removeRowBtn">remove</button></td>
                                                                    </tr>
                                                                @endforeach
                                                                {{-- @else
                                                                    <td><input type="text" name="ATCCodes[0][serial]" value="1" readonly></td>
                                                                    <td><input type="text" name="ATCCodes[0][atc_Search]"></td>
                                                                    <td><input type="text" name="ATCCodes[0][1st_Level]"></td>
                                                                    <td><input type="text" name="ATCCodes[0][2nd_Level]"></td>
                                                                    <td><input type="text" name="ATCCodes[0][3rd_Level]"></td>
                                                                    <td><input type="text" name="ATCCodes[0][4th_Level]"></td>
                                                                    <td><input type="text" name="ATCCodes[0][5th_Level]"></td>
                                                                    <td><input type="text" name="ATCCodes[0][atc_Code]"></td>
                                                                    <td><input type="text" name="ATCCodes[0][substance]"></td>
                                                                    <td><input type="text" name="ATCCodes[0][remarks]"></td>
                                                                    <td><input type="text" class="Action" name="" readonly></td> --}}

                                                 @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <script>
                                $(document).on('click', '.removeRowBtn', function() {
                                    $(this).closest('tr').remove();
                                })
                            </script>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Ingredients">
                                        (Root Parent) Ingredients (0)
                                        <button type="button" onclick="add4Input('Ingredients-first-table')">+</button>
                                        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="Ingredients-first-table">
                                            <thead>
                                                <tr>
                                                    <th>Row #</th>
                                                    <th>IngredientType</th>
                                                    <th>Ingredient Name</th>
                                                    <th>Ingredient Strength</th>
                                                    <th>Specification Date</th>
                                                    <th>Remarks</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($ingridentData && is_array($ingridentData))


                                                @foreach ($ingridentData as $gridData)
                                                    <tr>
                                                        <td> <input disabled type="text" name="ingridents[{{ $loop->index }}][serial]" value="{{ $loop->index+1 }}"></td>
                                                        <td>
                                                            <input class="currentDocNumber" type="text" name="ingridents[{{ $loop->index }}][ingredient_Type]" value="{{ isset($gridData['ingredient_Type']) ? $gridData['ingredient_Type'] : '' }}">
                                                        </td>
                                                        <td>
                                                            <input class="currentVersionNumber" type="text" name="ingridents[{{ $loop->index }}][ingredient_Name]" value="{{ isset($gridData['ingredient_Name']) ? $gridData['ingredient_Name'] : '' }}">
                                                        </td>
                                                        <td>
                                                            <input class="newDocNumber" type="text" name="ingridents[{{ $loop->index }}][ingredient_Strength]" value="{{ isset($gridData['ingredient_Strength']) ? $gridData['ingredient_Strength'] : '' }}">
                                                        </td>
                                                        <td>
                                                            <input class="newVersionNumber" type="text" name="ingridents[{{ $loop->index }}][Specification_Date]" value="{{ isset($gridData['Specification_Date']) ? $gridData['Specification_Date'] : '' }}">
                                                        </td>
                                                        <td>
                                                            <input class="newVersionNumber" type="text" name="ingridents[{{ $loop->index }}][Remarks]" value="{{ isset($gridData['Remarks']) ? $gridData['Remarks'] : '' }}">
                                                        </td>
                                                        <td><input type="button"><button class="removeRowBtn">remove</button></td>
                                                    </tr>
                                                @endforeach
                                                {{-- @else
                                                <td><input disabled type="text" name="ingridents[0][serial_number]"
                                                    value="1">
                                            </td> --}}
                                            {{-- <td><input type="text" name="ingridents[0][ingredient_Type]"></td>
                                            <td><input type="text" name="ingridents[0][ingredient_Name]"></td>
                                            <td><input type="text" name="ingridents[0][ingredient_Strength]"></td>
                                            <td><input type="text" name="ingridents[0][Specification_Date]"></td>
                                            <td><input type="text" name="ingridents[0][Remarks]"></td>
                                            <td><input type="text" class="Action" name="" readonly></td> --}}

                                            @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <script>
                                function removeRow(button) {
                                    // Find the row containing the button
                                    var row = button.parentNode.parentNode;
                                    // Remove the row from the table
                                    row.parentNode.removeChild(row);
                                }
                            </script>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Therapeutic Area">(Root Parent)Therapeutic Area</label>
                                    <select name="therapeutic_Area" onchange="">
                                        <option value="">-- select --</option>
                                        <option value="a"{{ $PSUR->therapeutic_Area == 'a' ? 'selected':''}}>a</option>
                                        <option value="b"{{ $PSUR->therapeutic_Area == 'b' ? 'selected':''}}>b</option>
                                        <option value="c"{{ $PSUR->therapeutic_Area == 'c' ? 'selected':''}}>c</option>

                                    </select>
                                </div>
                            </div>
                            {{-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Therapeutic Area">(Root Parent)Therapeutic Area</label>
                                        <select name="Root_therapeutic_area" id="therapeutic_area">
                                        <option value="">-- select --</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                        <option value="na">NA</option>
                                        </select>
                                </div>
                                {{-- <div>
                                    <div class="container">
                                        <input type="radio" class="radio-input" name="option" value="option1">
                                        <label class="radio-label">Yes</label>
                                    </div>

                                    <div class="container">
                                        <input type="radio" class="radio-input" name="option" value="option2">
                                        <label class="radio-label">NO</label>
                                    </div>

                                    <div class="container">
                                        <input type="radio" class="radio-input" name="option" value="option3">
                                        <label class="radio-label">NA</label>
                                    </div>
                                    <a href="#" id="clearSelection" class="container text-primary">Clear Selection</a>
                                </div> --}}

                            {{-- </div> --}}

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
                {{-- <div id="CCForm4" class="inner-block cctabcontent">
                    <div class="button-block">
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                        <button type="submit" class="saveButton">Save</button>
                        <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                            </a> </button>
                    </div>
                </div> --}}

                <div id="CCForm5" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="sub-head">
                            Registration Plan
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Registration Status">Registration Status</label>
                                    <select name="registration_status" onchange="">
                                        <option value="">-- select --</option>
                                        <option value="A"{{ $PSUR->registration_status == 'A' ? 'selected':''}}>A</option>
                                        <option value="B"{{ $PSUR->registration_status == 'B' ? 'selected':''}}>B</option>
                                        <option value="C"{{ $PSUR->registration_status == 'C' ? 'selected':''}}>C</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Registration Number">Registration Number</label>
                                    <input type="text" name="registration_number" id="registration_number" value="{{ $PSUR->registration_number}}">
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Planned Submission Date"> Planned Submission Date </label>

                                    <div class="calenderauditee">
                                        <input type="text" id="planned_submission_date" readonly placeholder="DD-MMM-YYYY" name="planned_submission_date"  value="{{ $PSUR->planned_submission_date}}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"/>
                                        <input type="date" name="planned_submission_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'planned_submission_date')" />
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Actual Submission Date"> Actual Submission Date </label>

                                    <div class="calenderauditee">
                                        <input type="text" id="actual_submission_date" readonly placeholder="DD-MMM-YYYY" name="actual_submission_date" value="{{ $PSUR->actual_submission_date}}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"/>
                                        <input type="date" name="actual_submission_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'actual_submission_date')" />
                                    </div>


                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="group-input">
                                    <label for="Comments">Comments</label>
                                    <textarea class="" name="comments" id="" value="">{{ $PSUR->comments}}
                                    </textarea>
                                </div>
                            </div>

                            <div class="sub-head">Local Information/Procedure</div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="(Parent) Procedure Type">(Parent) Procedure Type</label>
                                    <input type="text" name="procedure_type" value="{{ $PSUR->procedure_type}}">

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="(Parent) Procedure Number">(Parent) Procedure Number</label>
                                    <input type="text" name="procedure_number" id="procedure_number" value="{{ $PSUR->procedure_number}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="(Parent) Reference Member State(RMS)">(Parent) Reference Member State(RMS)</label>
                                    <select name="reference_member_state" onchange="">
                                        <option value="">-- select --</option>
                                        <option value="A"{{ $PSUR->reference_member_state == 'A' ? 'selected':''}}>A</option>
                                        <option value="B"{{ $PSUR->reference_member_state == 'B' ? 'selected':''}}>B</option>
                                        <option value="C"{{ $PSUR->reference_member_state == 'C' ? 'selected':''}}>C</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="(Parent)Renewal Rule">(Parent)Renewal Rule</label>
                                    <select name="renewal_rule" onchange="">
                                        <option value="{{ $PSUR->renewal_rule}}">-- select --</option>
                                        <option value="A"{{ $PSUR->renewal_rule == 'A' ? 'selected':''}}>A</option>
                                        <option value="B"{{ $PSUR->renewal_rule == 'B' ? 'selected':''}}>B</option>
                                        <option value="C"{{ $PSUR->renewal_rule == 'C' ? 'selected':''}}>C</option>

                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="(Parent)Concerned Member States (CMSs)">(Parent)Concerned Member States (CMSs)</label>
                                    <select multiple id="reference_system_document" name="concerned_member_states" >
                                        <option value="">--Select---</option>
                                        <option value="A"{{ $PSUR->concerned_member_states == 'A' ? 'selected':''}}>A</option>
                                        <option value="B"{{ $PSUR->concerned_member_states == 'B' ? 'selected':''}}>B</option>
                                        <option value="C"{{ $PSUR->concerned_member_states == 'C' ? 'selected':''}}>C</option>



                                    </select>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Product_Material">
                                        (Root Parent) Product/Material (0)
                                        <button type="button" onclick="add4Input('Product_Material-first-table tbody')">+</button>

                                        {{-- <button type="button" id="productAdd">+</button> --}}
                                        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="Product_Material-first-table tbody">
                                            <thead>
                                                <tr>
                                                    <th>Row #</th>
                                                    <th>Product Name</th>
                                                    <th>Batch Number</th>
                                                    <th>Expiry Date</th>
                                                    <th>Manufactured Date</th>
                                                    <th>Disposition</th>
                                                    <th>Comments</th>
                                                    <th>Remarks</th>
                                                    <th>Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ( $ProductData && is_array( $ProductData))
                                                @foreach ( $ProductData as $gridData)
                                                    <tr>
                                                        <td> <input disabled type="text" name="Product[{{ $loop->index }}][serial]" value="{{ $loop->index+1 }}"></td>
                                                        <td>
                                                            <input class="currentDocNumber" type="text" name="Product[{{ $loop->index }}][Product_Type]" value="{{ isset($gridData['Product_Type']) ? $gridData['Product_Type'] : '' }}">
                                                        </td>
                                                        <td>
                                                            <input class="currentVersionNumber" type="text" name="Product[{{ $loop->index }}][Batch_number]" value="{{ isset($gridData['Batch_number']) ? $gridData['Batch_number'] : '' }}">
                                                        </td>
                                                        <td>
                                                            <input class="newDocNumber" type="text" name="Product[{{ $loop->index }}][Expiry_date]" value="{{ isset($gridData['Expiry_date']) ? $gridData['Expiry_date'] : '' }}">
                                                        </td>
                                                        <td>
                                                            <input class="newVersionNumber" type="text" name="Product[{{ $loop->index }}][Manufactured_date]" value="{{ isset($gridData['Manufactured_date']) ? $gridData['Manufactured_date'] : '' }}">
                                                        </td>
                                                        <td>
                                                            <input class="newVersionNumber" type="text" name="Product[{{ $loop->index }}][Disposition_date]" value="{{ isset($gridData['Disposition_date']) ? $gridData['Disposition_date'] : '' }}">
                                                        </td>
                                                        <td>
                                                            <input class="newVersionNumber" type="text" name="Product[{{ $loop->index }}][Comments_date ]" value="{{ isset($gridData['Comments_date ']) ? $gridData['Comments_date '] : '' }}">
                                                        </td>
                                                        <td>
                                                            <input class="newVersionNumber" type="text" name="Product[{{ $loop->index }}][Remarks]" value="{{ isset($gridData['Remarks']) ? $gridData['Remarks'] : '' }}">
                                                        </td>

                                                        <td><input type="text"><button class="removeRowBtn">remove</button></td>

                                                    </tr>
                                                @endforeach
                                                @else
                                                <td><input disabled type="text" name="Product[0][serial]" value="1"></td>
                                              <td><input type="text" name="Product[0][Product_Type]"></td>
                                              <td><input type="text" name="Product[0][Batch_number]"></td>
                                              <td><input type="text" name="Product[0][Expiry_date]"></td>
                                              <td><input type="text" name="Product[0][Manufactured_date]"></td>
                                              <td><input type="text" name="Product[0][Disposition_date]"></td>
                                              <td><input type="text" name="Product[0][Comments_date]"></td>
                                              <td><input type="text" name="Product[0][Remarks]"></td>
                                              @endif


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Packaging_Information">
                                        (Root Parent) Packaging Information (0)
                                        <button type="button" onclick="add4Input('Packaging_Information-first-table')">+</button>
                                        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="Packaging_Information-first-table">
                                            <thead>
                                                <tr>
                                                    <th>Row #</th>
                                                    <th>Primary Packaging</th>
                                                    <th>Material</th>
                                                    <th>Pack Size</th>
                                                    <th>Shelf Life</th>
                                                    <th>Storage Condition</th>
                                                    <th>Secondary Packaging</th>
                                                    <th>Remarks</th>
                                                    <th>Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($informationData && is_array($informationData))
                                                @foreach ($informationData as $gridData)
                                                    <tr>
                                                        <td> <input disabled type="text" name="pacaging_information[{{ $loop->index }}][serial]" value="{{ $loop->index+1 }}"></td>
                                                        <td>
                                                            <input class="currentDocNumber" type="text" name="pacaging_information[{{ $loop->index }}][Primary_Packaging]" value="{{ isset($gridData['Primary_Packaging']) ? $gridData['Primary_Packaging'] : '' }}">
                                                        </td>
                                                        <td>
                                                            <input class="currentVersionNumber" type="text" name="pacaging_information[{{ $loop->index }}][Material]" value="{{ isset($gridData['Material']) ? $gridData['Material'] : '' }}">
                                                        </td>
                                                        <td>
                                                            <input class="newDocNumber" type="text" name="pacaging_information[{{ $loop->index }}][Pack_Size]" value="{{ isset($gridData['Pack_Size']) ? $gridData['Pack_Size'] : '' }}">
                                                        </td>
                                                        <td>
                                                            <input class="newVersionNumber" type="text" name="pacaging_information[{{ $loop->index }}][Shelf_Life]" value="{{ isset($gridData['Shelf_Life']) ? $gridData['Shelf_Life'] : '' }}">
                                                        </td>
                                                        <td>
                                                            <input class="newVersionNumber" type="text" name="pacaging_information[{{ $loop->index }}][Storage_Condition]" value="{{ isset($gridData['Storage_Condition']) ? $gridData['Storage_Condition'] : '' }}">
                                                        </td>
                                                        <td>
                                                            <input class="newVersionNumber" type="text" name="pacaging_information[{{ $loop->index }}][Secondary_Packaging ]" value="{{ isset($gridData['Secondary_Packaging ']) ? $gridData['Secondary_Packaging '] : '' }}">
                                                        </td>
                                                        <td>
                                                            <input class="newVersionNumber" type="text" name="pacaging_information[{{ $loop->index }}][Remarks]" value="{{ isset($gridData['Remarks']) ? $gridData['Remarks'] : '' }}">
                                                        </td>

                                                        <td><input type="text"><button class="removeRowBtn">remove</button></td>
                                                    </tr>
                                                @endforeach
                                                @else
                                                <td><input disabled type="text" name="pacaging_information[0][serial_number]"
                                                    value="1">
                                             </td>
                                              <td><input type="text" name="pacaging_information[0][Primary_Packaging]"></td>
                                              <td><input type="text" name="pacaging_information[0][Material]"></td>
                                              <td><input type="text" name="pacaging_information[0][Pack_Size]"></td>
                                              <td><input type="text" name="pacaging_information[0][Shelf_Life]"></td>
                                              <td><input type="text" name="pacaging_information[0][Storage_Condition]"></td>
                                              <td><input type="text" name="pacaging_information[0][Secondary_Packaging]"></td>
                                              <td><input type="text" name="pacaging_information[0][Remarks]"></td>
                                              @endif

                                            </tbody>
                                        </table>
                                    </div>
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

                <div id="CCForm6" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="sub-head">
                            Activity Log
                        </div>
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Started by">Started By : </label>
                                    <div class="static">{{ $PSUR->started_by}}</div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Started on"> Started On : </label>
                                    <div class="static">{{ $PSUR->started_on}}</div>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Submitted By">Submitted By :</label>
                                    <div class="static">{{ $PSUR->submitted_by}}</div>

                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Submittedon">Submitted On :</label>
                                    <div class="static">{{ $PSUR->submitted_on}}</div>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Approved  By">Approved By :</label>
                                    <div class="static">{{ $PSUR->approved_by}}</div>

                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Approved on">Approved On :</label>
                                    <div class="static">{{ $PSUR->approved_on}}</div>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Withdrawn By">Withdrawn By :</label>
                                    <div class="static">{{ $PSUR->withdrawn_by}}</div>

                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Withdrawn">Withdrawn on :</label>
                                    <div class="static">{{ $PSUR->withdrawn_on}}</div>


                                </div>
                            </div>
                        </div>
                        <div class="button-block">
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            {{-- <button type="submit" class="saveButton">Save</button> --}}
                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                                </a> </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

{{-- ---------------------------------------------signature modal ----------------------------------------------}}
<div class="modal fade" id="signature-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('psur.stageChange', $PSUR->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="mb-3 text-justify">
                        Please select a meaning and a outcome for this task and enter your username
                        and password for this task. You are performing an electronic signature,
                        which is legally binding equivalent of a hand written signature.
                    </div>
                    <div class="group-input">
                        <label for="username">Username</label>
                        <input type="text" name="username" required>
                    </div>
                    <div class="group-input">
                        <label for="password">Password</label>
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

{{-- ---------------------------------------------Child modal ----------------------------------------------}}

<div class="modal fade" id="child-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Child</h4>
            </div>
            <form action="{{ route('psur.stageChange', $PSUR->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="group-input">
                        @if ($PSUR->stage == 2)
                        <label style="display: flex;" for="major">
                            <input  type="radio" name="child_type" id="major" value="PSUR">
                             Dossier Document
                        </label>
                        @endif

                        @if ($PSUR->stage == 4)

                        <label for="major">
                            <input type="radio" name="child_type" id="major" value="PSUR Registration">
                            Correspondence
                        </label>
                        @endif
                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" data-bs-dismiss="modal">Close</button>
                    <button type="submit">Continue</button>
                </div>
            </form>

        </div>
    </div>
</div>

{{-- ------------------------------rejection modal---------------------------- --}}
<div class="modal fade" id="rejection-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('psur.stagereject', $PSUR->id) }}" method="POST">
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
                    <button type="submit" data-bs-dismiss="modal">Submit</button>
                    <button type="button" data-bs-dismiss="modal">Close</button>
                    {{-- <button>Close</button> --}}
                </div>
            </form>
        </div>
    </div>
</div>

{{-- --------------------------------------cancel modal---------------------------------- --}}
<div class="modal fade" id="cancel-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('psur_cancel', $PSUR->id) }}" method="POST">
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
                    <button type="submit" data-bs-dismiss="modal">Submit</button>
                    <button type="button" data-bs-dismiss="modal">Close</button>
                    {{-- <button>Close</button> --}}
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
    document.querySelectorAll('.removeRowBtn').forEach(button => {
    button.addEventListener('click', function() {
        const row = this.closest('tr'); // Find the closest <tr> (table row) element
        row.remove(); // Remove the row
    });
});

</script>

<script>
    VirtualSelect.init({
         ele: '#Facility, #Group, #Audit,#reference_system_document, #Auditee ,#reference_record,#root_parent'
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
        ele: '#reference_record, #notify_to,#reference_system_document ,#root_parent'
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
@endsection
