@extends('frontend.layout.main')
@section('container')
<style>
    textarea.note-codable {
        display: none !important;
    }

    header {
        display: none;
    }


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

    #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(9) {
        border-radius: 0px 20px 20px 0px;

    }
</style>
@php
$users = DB::table('users')->get();
@endphp


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

<div class="form-field-head">

    <div class="division-bar">
        <strong>Site Validation/Project</strong> :
        {{ Helpers::getDivisionName($validation->validation_id) }} / Validation
    </div>
</div>

{{-- ---------------------- --}}


{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">
        <div class="inner-block state-block">
            <div class="d-flex justify-content-between align-items-center">
                <div class="main-head">Record Workflow </div>

                <div class="d-flex" style="gap:20px;">
                    @php
                    $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => 7])->get();
                    $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                    @endphp

                    <button class="button_theme1"> <a class="text-white" href="{{ url('auditValidation', $validation->id) }}"> Audit Trail </a> </button>

                    @if ($validation->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Submit Protocol
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                        Cancel
                    </button>
                    @elseif($validation->stage == 2 && (in_array(4, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Review Approval
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target=" #cancel-modal">
                        Corrections Needed
                    </button>
                    <!-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button> -->
                    @elseif($validation->stage == 3 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Approval
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                        Reject
                    </button>

                    @elseif(
                    $validation->stage == 4 &&
                    (in_array(5, $userRoleIds) || in_array(18, $userRoleIds) || in_array(Auth::user()->id, $valuesArray)))

                    <button class="button_theme1" data-bs-toggle="modal" name="test_not_required" data-bs-target="#cancel-modal">
                        Tests Not Required
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                        Tests Performed - No Deviation
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Deviation Occurred
                    </button>

                    @elseif($validation->stage == 5 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Deviation Complete
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#hodsend">
                        Back to Testing
                    </button>
                    <!-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#qasend">
                                        Document Completed
                                    </button> -->
                    <!-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                        QA Final Review Complete
                                    </button>
                                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                        Child
                                    </button>  -->
                    @elseif($validation->stage == 6 && (in_array(39, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Document Completed
                    </button>
                    <!-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                    Report Reject
                                    </button>  -->
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                        Child
                    </button>

                    @elseif($validation->stage == 7 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Final Approval
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                        Report Reject
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Obsolete
                    </button>
                    <!-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                        Initiator Updated Complete
                                    </button> -->
                    @elseif($validation->stage == 8 && (in_array(39, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Obsolete
                    </button>

                    @endif
                    <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                        </a> </button>
                </div>
            </div>


            <div class="status">
                <div class="head">Current Status</div>
                @if ($validation->stage == 0)
                <div class="progress-bars ">
                    <div class="bg-danger">Closed-Cancelled</div>
                </div>
                @else
                <div class="progress-bars d-flex" style="font-size: 15px;">
                    @if ($validation->stage >= 1)
                    <div class="active">Opened</div>
                    @else
                    <div class="">Opened</div>
                    @endif

                    @if ($validation->stage >= 2)
                    <div class="active">Review </div>
                    @else
                    <div class="">Review</div>
                    @endif

                    @if ($validation->stage >= 3)
                    <div class="active">Protocol Approval</div>
                    @else
                    <div class="">Protocol Approval</div>
                    @endif

                    @if ($validation->stage >= 4)
                    <div class="active">Test in Progress</div>
                    @else
                    <div class="">Test in Progress</div>
                    @endif


                    @if ($validation->stage >= 5)
                    <div class="active">Deviation in Progress</div>
                    @else
                    <div class="">Deviation in Progress</div>
                    @endif
                    @if ($validation->stage >= 6)
                    <div class="active">Pending Completion</div>
                    @else
                    <div class="">Pending Completion</div>
                    @endif
                    @if ($validation->stage >= 7)
                    <div class="active">Pending Approval</div>
                    @else
                    <div class="">Pending Approval</div>
                    @endif
                    @if ($validation->stage >= 8)
                    <div class="active">Active Document</div>
                    @else
                    <div class="">Active Document</div>
                    @endif
                    @if ($validation->stage >= 9)
                    <div class="bg-danger">Closed - Done</div>
                    @else
                    <div class="">Closed - Done</div>
                    @endif
                    {{-- @endif --}}
                </div>
                @endif
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
        </div>

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Validation Document</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Test Results</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Signatures</button>
        </div>

        <form action="{{ route('validation.update', $validation->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

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
                                    <label for="Originator"><b>Initiator</b></label>
                                    <input disabled type="text" name="validation" value="{{ Auth::user()->name }}">
                                    <input type="hidden" name="validation" value="{{ Auth::user()->name }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number">Record Number</label>
                                    <!-- <input disabled type="text" name="record"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/DEMOVALIDATION/{{ date('Y') }}"> -->
                                    <input disabled type="text" name="record" value="{{ Helpers::getDivisionName($validation->division_id) }}/VALIDATION/{{ Helpers::year($validation->created_at) }}/{{ $validation->record }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Date Of Initiation</b></label>
                                    @if(isset($validation) && $validation->intiation_date)
                                    <input disabled type="text" value="{{ \Carbon\Carbon::parse($validation->initiation_date)->format('d-M-Y') }}" id="initiation_date_display">
                                    <input type="hidden" value="{{ $validation->intiation_date }}" id="initiation_date" name="intiation_date">
                                    @else
                                    <input disabled type="text" value="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" id="initiation_date_display">
                                    <input type="hidden" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="initiation_date" name="intiation_date">
                                    @endif
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span></label><span id="rchars">255</span>
                                    characters remaining
                                    <input id="docname" type="text" name="short_description" maxlength="255" value="{{ $validation->short_description }}" required>
                                </div>
                            </div>

                            <!-- <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assign_to">
                                        <option value="">Select a value</option>
                                        @foreach ($users as $datas)
                                        @if(Helpers::checkUserRolesassign_to($datas))
                                        <option value="{{ $datas->id }}" {{ $validation->assign_to == $datas->id ? 'selected' : '' }} {{-- @if ($data->assign_to == $datas->id) selected @endif --}}>
                                            {{ $datas->name }}
                                        </option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @error('assigned_user_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div> -->

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assign_to">
                                        <option value="assign_to">Select a value</option>
                                        @foreach ($users as $datas)
                                        @if(Helpers::checkUserRolesassign_to($datas))
                                        <option value="{{ $datas->name }}" {{ $validation->assign_to == $datas->name ? 'selected' : '' }}>
                                            {{ $datas->name }}
                                        </option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Date Due <span class="text-danger"></span></label>
                                    <div class="calenderauditee">
                                        <input readonly type="text" value="{{ Helpers::getdateFormat($validation->assign_due_date) }}" name="assign_due_date">
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Date Due <span class="text-danger"></span></label>
                                    <div class="calenderauditee">
                                        <input type="text" id="assign_due_date_display" readonly placeholder="DD-MM-YY" />
                                        <input type="date" name="assign_due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ \Helpers::getdateFormat($validation->assign_due_date) }}" class="hide-input" oninput="handleDateInput(this, 'assign_due_date_display')" />
                                    </div>
                                </div>
                            </div> -->

                            <!-- <script>
                                function handleDateInput(dateInput, displayId) {
                                    const date = new Date(dateInput.value);
                                    const formattedDate = `${String(date.getDate()).padStart(2, '0')}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getFullYear()).slice(-2)}`;
                                    document.getElementById(displayId).value = formattedDate;
                                }
                            </script> -->


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Validation Type</label>
                                    <select name="validation_type">
                                        <!-- <option value="">Enter Your Selection Here</option> -->
                                        <option value="1" @if ($validation->validation_type == 1) selected @endif>1</option>
                                        <option value="2" @if ($validation->validation_type == 2) selected @endif>2</option>
                                        <option value="3" @if ($validation->validation_type == 3) selected @endif>3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="validation_due_date">Date Due <span class="text-danger"></span></label>
                                    <div><small class="text-primary">Please mention expected date of completion</small></div>
                                    <div class="calenderauditee">
                                        <!-- <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="validation_due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" 
                                        value="{{ \Helpers::getdateFormat($validation->validation_due_date) }}" 
                                        class="hide-input" oninput="handleDateInput(this, 'due_date')" /> -->
                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="validation_due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ \Helpers::getdateFormat($validation->validation_due_date) }}" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="notify_type">Notify When Approved?</label>
                                    <select name="notify_type">
                                        <!-- <option value="">Enter Your Selection Here</option> -->
                                        <option value="1" @if ($validation->notify_type == 1) selected @endif>yes</option>
                                        <option value="2" @if ($validation->notify_type == 2) selected @endif>No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="phase_type">Phase Level</label>
                                    <select name="phase_type">
                                        <!-- <option value="">Enter Your Selection Here</option> -->
                                        <option value="1" @if ($validation->phase_type == 1) selected @endif>1</option>
                                        <option value="2" @if ($validation->phase_type == 2) selected @endif>2</option>
                                        <option value="3" @if ($validation->phase_type == 3) selected @endif>3</option>
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
                                        <!-- <option value="">Enter Your Selection Here</option> -->
                                        <option value="yes" @if ($validation->document_reason_type == 'yes') selected @endif>yes</option>
                                        <option value="No" @if ($validation->document_reason_type == 'No') selected @endif>No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Purpose</label>
                                    <textarea class="summernote" name="purpose" id="summernote-16" {{ $validation->stage == 0 || $validation->stage == 6 ? "disabled" : "" }}>{{ old('purpose', $validation->purpose) }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Outcome">Validation Category</label>
                                    <select name="validation_category">
                                        <!-- <option value="">Enter Your Selection Here</option> -->
                                        <option value="1" @if ($validation->validation_category == 1) selected @endif>1</option>
                                        <option value="2" @if ($validation->validation_category == 2) selected @endif>2</option>
                                        <option value="3" @if ($validation->validation_category == 3) selected @endif>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Patient_Involved">Validation Sub Category</label>
                                    <select name="validation_sub_category">
                                        <!-- <option value="">Enter Your Selection Here</option> -->
                                        <option value="1" @if ($validation->validation_sub_category == 1) selected @endif>1</option>
                                        <option value="2" @if ($validation->validation_sub_category == 2) selected @endif>2</option>
                                        <option value="3" @if ($validation->validation_sub_category == 3) selected @endif>3</option>
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
                                        <div class="file-attachment-list" id="file_attechment">
                                            @if ($validation->file_attechment)
                                            @foreach(json_decode($validation->file_attechment) as $file)
                                            <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                <b>{{ $file }}</b>
                                                <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                <a type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                            </h6>
                                            @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="file_attechment[]" value="{{$validation->file_attechment}}" oninput="addMultipleFiles(this, 'file_attechment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reference Recores"> Related Records</label>
                                    <select multiple id="reference_record" name="related_record" id="">
                                        <!-- <option value="">--Select---</option> -->
                                        <option value="1" @if ($validation->related_record==1 ) selected @endif>Pankaj</option>
                                        <option value="2" @if ($validation->related_record==2) selected @endif>Gourav</option>

                                        <!-- <option value="Pankaj">Pankaj</option>
                                        <option value="Gourav">Gourav</option> -->
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reporter">Document Link </label>
                                    <input type="text" name="document_link" value="{{$validation->document_link}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Tests Required</label>
                                    <select name="tests_required">
                                        <!-- <option value="">Enter Your Selection Here</option> -->
                                        <option value="1" @if ($validation->tests_required == 1) selected @endif>Yes</option>
                                        <option value="2" @if ($validation->tests_required == 2) selected @endif>No</option>
                                        <!-- <option value="Yes">Yes</option>
                                        <option value="No">No</option> -->
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Refrence Document</label>
                                    <select name="reference_document">
                                        <!-- <option value="">Enter Your Selection Here</option> -->
                                        <option value="1" @if ($validation->reference_document == 1) selected @endif>Yes</option>
                                        <option value="2" @if ($validation->reference_document == 2) selected @endif>Yes</option>
                                        <!-- <option value="Yes">yes</option>
                                        <option value="No">No</option> -->
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reporter">Refrence Link </label>
                                    <input type="text" name="reference_link" value="{{$validation->reference_link}}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Additional Refrences</label>
                                    <textarea class="summernote" name="additional_references" id="summernote-16">{{ $validation->additional_references }}</textarea>
                                </div>
                            </div>


                            <div class="sub-head">
                                Affected Items
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Affected Equipment({{ is_array($details) ? count($details) : 0 }})
                                    <button type="button" name="affected_equipments" id="Affected_equipment_add">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        Open
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Details-table">
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

                                            @if (is_array($details))
                                            @foreach($details as $index => $detail)
                                            <tr>
                                                <td><input disabled type="text" name="details[{{ $index }}][serial]" value="{{ $index + 1 }}"></td>
                                                <td><input type="text" name="details[{{ $index }}][equipment_name_code]" value="{{ $detail['equipment_name_code'] ?? '' }}"></td>
                                                <td><input type="text" name="details[{{ $index }}][equipment_id]" value="{{ $detail['equipment_id'] ?? ''}}"></td>
                                                <td><input type="text" name="details[{{ $index }}][asset_no]" value="{{ $detail['asset_no'] ?? ''}}"></td>
                                                <td><input type="text" name="details[{{ $index }}][remarks]" value="{{ $detail['remarks'] ?? ''}}"></td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <script>
                                document.getElementById('Affected_equipment_add').addEventListener('click', function() {
                                    var table = document.getElementById('Details-table').getElementsByTagName('tbody')[0];
                                    var rowCount = table.rows.length;
                                    var row = table.insertRow(rowCount);

                                    row.innerHTML = `
                                        <td><input disabled type="text" name="details[${rowCount}][serial]" value="${rowCount + 1}"></td>
                                        <td><input type="text" name="details[${rowCount}][equipment_name_code]"></td>
                                        <td><input type="text" name="details[${rowCount}][equipment_id]"></td>
                                        <td><input type="text" name="details[${rowCount}][asset_no]"></td>
                                        <td><input type="text" name="details[${rowCount}][remarks]"></td>
                                    `;
                                });
                            </script>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Affected Item(0)
                                    <button type="button" name="affected_equipments" id="Affected_item_add">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        Open
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Details-table">
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
                                            @if (is_array($details))
                                            @foreach($details as $index => $detail)
                                            <tr>
                                                <td><input disabled type="text" name="details[{{ $index }}][serial]" value="{{ $index + 1 }}"></td>
                                                <td><input type="text" name="details[{{ $index }}][item_type]" value="{{ $detail['item_type'] ?? ''}}"></td>
                                                <td><input type="text" name="details[{{ $index }}][item_name]" value="{{ $detail['item_name'] ?? ''}}"></td>
                                                <td><input type="text" name="details[{{ $index }}][item_no]" value="{{ $detail['item_no'] ?? ''}}"></td>
                                                <td><input type="text" name="details[{{ $index }}][item_remarks]" value="{{ $detail['item_remarks'] ?? ''}}"></td>
                                            </tr>
                                            @endforeach
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <script>
                                document.getElementById('Affected_item_add').addEventListener('click', function() {
                                    var table = document.getElementById('Details-table').getElementsByTagName('tbody')[0];
                                    var rowCount = table.rows.length;
                                    var row = table.insertRow(rowCount);

                                    row.innerHTML = `
                                        <td><input disabled type="text" name="details[${rowCount}][serial]" value="${rowCount + 1}"></td>
                                        <td><input type="text" name="details[${rowCount}][item_type]"></td>
                                        <td><input type="text" name="details[${rowCount}][item_name]"></td>
                                        <td><input type="text" name="details[${rowCount}][item_no]"></td>
                                        <td><input type="text" name="details[${rowCount}][item_remarks]"></td>
                                    `;
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
                                    <table class="table table-bordered" id="Details-table">
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
                                            @if (is_array($details))
                                            @foreach($details as $index => $detail)
                                            <tr>
                                                <td><input disabled type="text" name="details[{{ $index }}][serial]" value="{{ $index + 1 }}"></td>
                                                <td><input type="text" name="details[{{ $index }}][facility_location]" value="{{ $detail['facility_location'] ?? ''}}"></td>
                                                <td><input type="text" name="details[{{ $index }}][facility_type]" value="{{ $detail['facility_type'] ?? ''}}"></td>
                                                <td><input type="text" name="details[{{ $index }}][facility_name]" value="{{ $detail['facility_name'] ?? ''}}"></td>
                                                <td><input type="text" name="details[{{ $index }}][facility_remarks]" value="{{ $detail['facility_remarks'] ?? ''}}"></td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <script>
                                document.getElementById('Affected_facilities_add').addEventListener('click', function() {
                                    var table = document.getElementById('Details-table').getElementsByTagName('tbody')[0];
                                    var rowCount = table.rows.length;
                                    var row = table.insertRow(rowCount);

                                    row.innerHTML = `
                                        <td><input disabled type="text" name="details[${rowCount}][serial]" value="${rowCount + 1}"></td>
                                        <td><input type="text" name="details[${rowCount}][facility_location]"></td>
                                        <td><input type="text" name="details[${rowCount}][facility_type]"></td>
                                        <td><input type="text" name="details[${rowCount}][facility_name]"></td>
                                        <td><input type="text" name="details[${rowCount}][facility_remarks]"></td>
                                    `;
                                });
                            </script>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="closure attachment">Items Attachment </label>
                                    <div><small class="text-primary">
                                        </small>
                                    </div>
                                    <!-- <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="items_attachment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="items_attachment[]" value="{{$validation->items_attachment}}" oninput="addMultipleFiles(this, 'items_attachment')" multiple>
                                        </div>
                                    </div> -->

                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="items_attachment">
                                            @if ($validation->items_attachment)
                                            @foreach(json_decode($validation->items_attachment) as $file)
                                            <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                <b>{{ $file }}</b>
                                                <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                <a type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                            </h6>
                                            @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="items_attachment[]" value="{{$validation->items_attachment}}" oninput="addMultipleFiles(this, 'items_attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Additional Attachment Items</label>
                                    <textarea class="summernote" name="addition_attachment_items" id="summernote-16" {{ $validation->stage == 0 || $validation->stage == 6 ? "disabled" : "" }}>{{ $validation->addition_attachment_items }}</textarea>
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
                                        <option value="1" @if ($validation->data_successfully_type == 1) selected @endif>Yes</option>
                                        <option value="2" @if ($validation->data_successfully_type == 2) selected @endif>No</option>
                                        <!-- <option value="Yes">yes</option>
                                        <option value="No">No</option> -->
                                    </select>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Document Summary</label>
                                    <textarea class="summernote" name="documents_summary" id="summernote-16" {{ $validation->stage == 0 || $validation->stage == 6 ? "disabled" : "" }}>{{ $validation->documents_summary }}</textarea>
                                </div>
                            </div>


                            <div class="sub-head">
                                Document Comments
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Document Comments</label>
                                    <textarea class="summernote" name="document_comments" id="summernote-16" {{ $validation->stage == 0 || $validation->stage == 6 ? "disabled" : "" }}>{{ $validation->document_comments }}</textarea>
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
                                        <!-- <option value="">Enter Your Selection Here</option> -->
                                        <option value="1" @if ($validation->reference_document == 1) selected @endif>1</option>
                                        <option value="2" @if ($validation->reference_document == 2) selected @endif>2</option>
                                        <!-- <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option> -->
                                    </select>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="date_of_birth">Test Start Date</label>
                                    <input type="date" name="test_start_date" value="{{$validation->test_start_date}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="date_of_birth">Test End Date</label>
                                    <input type="date" name="test_end_date" value="{{$validation->test_end_date}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="gender">Test Responsible</label>
                                    <select name="test_responsible">
                                        <!-- <option value="">Enter Your Selection Here</option> -->
                                        <option value="1" @if ($validation->reference_document == 1) selected @endif>pankaj</option>
                                        <option value="2" @if ($validation->reference_document == 2) selected @endif>Gourav</option>
                                        <option value="2" @if ($validation->reference_document == 2) selected @endif>Mayank</option>
                                        <!-- <option value="No">pankaj</option>
                                        <option value="Gourav">Gourav</option>
                                        <option value="Mayank">Mayank</option> -->
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
                                        <div class="file-attachment-list" id="result_attachment">
                                            @if ($validation->result_attachment)
                                            @foreach(json_decode($validation->result_attachment) as $file)
                                            <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                <b>{{ $file }}</b>
                                                <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                <a type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                            </h6>
                                            @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="result_attachment[]" value="{{$validation->result_attachment}}" oninput="addMultipleFiles(this, 'result_attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Summary Of Results(0)
                                    <button type="button" name="audit-agenda-grid" id="SummaryOfResults_add">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Open)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Details-table">
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

                                            @if (is_array($details))
                                            @foreach($details as $index => $detail)
                                            <tr>
                                                <td><input disabled type="text" name="details[{{ $index }}][serial]" value="{{ $index + 1 }}"></td>
                                                <td><input type="text" name="details[{{ $index }}][deviation_occured]" value="{{ $detail['deviation_occured'] ?? ''}}"></td>
                                                <td><input type="text" name="details[{{ $index }}][test_name]" value="{{ $detail['test_name'] ?? ''}}"></td>
                                                <td><input type="text" name="details[{{ $index }}][test_number]" value="{{ $detail['test_number'] ?? ''}}"></td>
                                                <td><input type="text" name="details[{{ $index }}][test_method]" value="{{ $detail['test_method'] ?? ''}}"></td>
                                                <td><input type="text" name="details[{{ $index }}][test_result]" value="{{ $detail['test_result'] ?? ''}}"></td>
                                                <td><input type="text" name="details[{{ $index }}][test_accepted]" value="{{ $detail['test_accepted'] ?? ''}}"></td>
                                                <td><input type="text" name="details[{{ $index }}][remarks]" value="{{ $detail['remarks'] ?? ''}}"></td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            <script>
                                document.getElementById('SummaryOfResults_add').addEventListener('click', function() {
                                    var table = document.getElementById('Details-table').getElementsByTagName('tbody')[0];
                                    var rowCount = table.rows.length;
                                    var row = table.insertRow(rowCount);

                                    row.innerHTML = `
                                        <td><input disabled type="text" name="details[${rowCount}][serial]" value="${rowCount + 1}"></td>
                                        <td><input type="text" name="details[${rowCount}][facility_location]"></td>
                                        <td><input type="text" name="details[${rowCount}][facility_type]"></td>
                                        <td><input type="text" name="details[${rowCount}][facility_name]"></td>
                                        <td><input type="text" name="details[${rowCount}][facility_remarks]"></td>
                                    `;
                                });
                            </script>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Test Actions & Comments</label>
                                    <textarea class="summernote" name="test_action" id="summernote-16" {{ $validation->stage == 0 || $validation->stage == 6 ? "disabled" : "" }}>{{ $validation->test_action }}</textarea>
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
                                    <label for="submitted by">Submitted Protocol By</label>
                                    <div class="static">{{$validation->submitted_by}}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted on">Submitted Protocol On</label>
                                    <div class="Date">{{$validation->submitted_on}}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="cancelled by">Cancelled By</label>
                                    <div class="static">{{$validation->cancelled_by}}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled on">Cancelled On</label>
                                    <div class="Date">{{$validation->cancelled_on}}</div>
                                </div>
                            </div>

                            <div class="sub-head">Review</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reviewed by">Review By</label>
                                    <div class="static">{{$validation->review_by}}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Review on">Review On</label>
                                    <div class="Date">{{$validation->review_on}}</div>
                                </div>
                            </div>

                            <div class="sub-head">Final Approval</div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Plan_Approved_by1">1st Final Approval By</label>
                                    <div class="static">{{$validation->approved_by}}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Plan_Approved_on1">1st Final Approval On</label>
                                    <div class="Date">{{$validation->approved_on }}</div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Plan_Approved_by2">2nd Final Approval By</label>
                                    <div class="static">{{ $validation->final_approved_by}}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Plan_Approved_on2">2nd Final Approval On</label>
                                    <div class="Date">{{$validation->final_approved_on }}</div>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Report_by">Report Reject By</label>
                                    <div class="static">{{$validation->rejected_by}}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Report_on">Report Reject On</label>
                                    <div class="Date">{{$validation->rejected_on}}</div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Obsolete_by">Obsolete By</label>
                                    <div class="static">{{$validation->obsolete_by}}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Obsolete_on">Obsolete On</label>
                                    <div class="Date">{{$validation->obsolete_on}}</div>
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
    function handleDateInput(dateInput) {
        // Get the value of the date input
        const dateValue = dateInput.value;
        if (dateValue) {
            // Format the date as DD-MMM-YYYY
            const date = new Date(dateValue);
            const options = {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            };
            const formattedDate = date.toLocaleDateString('en-GB', options).replace(/ /g, '-');

            // Set the formatted date to the readonly input
            document.getElementById('assign_due_date').value = formattedDate;
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

<script>
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
</script>

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
</script>
<script>
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
</script>

<script>
    var maxLength = 255;
    $('#docname').keyup(function() {
        var textlen = maxLength - $(this).val().length;
        $('#rchars').text(textlen);
    });
</script>



<!--Model-->

{{-- <div class="modal" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div style="background: #f7f2f" class="modal-header">
        <h4 class="modal-title">Customers</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div  class="modal-body">
        <div style="backgorund: #e9e2e2;" class="modal-sub-head">
            <div class="sub-main-head">

            <div  class="left-box">

                <div class="Activity-type">
                    <label style="font-weight: bold;" for="">Customer ID :</label>
                    
                    <input type="text">
                </div>
                <div class="Activity-type ">
                    <label style="font-weight: bold;     margin-left: 30px;" for=""> Email ID :</label>
                    
                    <input type="text">
                </div>
                <div class="Activity-type ">
                    <label style="font-weight: bold;     margin-left: -20px;" for=""> Customer Type :</label>
                
                    <input type="text">
                </div>
                <div class="Activity-type ">
                    <label style="font-weight: bold;     margin-left: 42px;" for=""> Status :</label>
                    
                    <input type="text">
                </div>
            </div>


            <div class="right-box">
                
                <div class="Activity-type">
                    <label style="font-weight: bold; " for="">Customer Name :</label>
                    
                    <input type="text">
                    
                </div>
                
                <div class="Activity-type">
                    <label style="font-weight: bold;  margin-left: 36px;" for="">Contact No :</label>
                    
                    <input type="text">
                    
                </div>
                <div class="Activity-type">
                    <label style="font-weight: bold;     margin-left: 57px;" for="">Industry :</label>
                    
                    <input type="text">
                    
                </div>
                <div class="Activity-type">
                    <label style="font-weight: bold;     margin-left: 66px; " for="">Region :</label>
                    
                    <input type="text">
                    
                </div>
            </div>
            
            </div>
            </div>
            <div class="Activity-type">
                <textarea style="margin-left: 126px; margin-top: 15px; width: 79%;" placeholder="Remarks" name="" id="" cols="30" ></textarea>
                </div>
      </div>
    </div>
  </div>
</div> --}}
<!-- Modal body -->
{{-- <div class="modal-body">
    <!-- Customer creation form -->
    <form id="customerForm">
        <!-- Input fields for customer details -->
        <div class="form-group">
            <label for="customer_id">Customer ID:</label>
            <input type="text" class="form-control" id="customer_id" name="customer_id" required>
        </div>
        <div class="form-group">
            <label for="email">Customer Name:</label>
            <input type="text" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="email">Customer Type:</label>
            <input type="text" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="email">Status:</label>
            <input type="text" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="email">Contact No:</label>
            <input type="number" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="email">Industry:</label>
            <input type="text" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="email">Region:</label>
            <input type="text" class="form-control" id="region" name="region" required>
        </div>
        <div class="form-group">
            <label for="email">Remarks:</label>
            <textarea cols="30" class="form-control" id="remarks" name="remarks" required>
        </div>

        <!-- Add more input fields for other customer details -->

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary">Create Customer</button>
    </form>
</div> --}}

<!-- JavaScript to handle form submission -->
{{-- <script>
    $(document).ready(function(){
        $('#customerForm').submit(function(e){
            e.preventDefault(); // Prevent default form submission
            
            // Create data object from form fields
            var formData = {
                customer_id: $('#customer_id').val(),
                email: $('#email').val(),
                // Add more fields here
            };

            // AJAX request to store customer details
            $.ajax({
                url: '{{ url('/customer/store') }}', // URL for storing customer details
type: 'POST',
data: formData, // Send form data
success: function(response){
// Handle success
console.log(response); // Log success response for debugging
$('#myModal').modal('hide'); // Close the modal
},
error: function(xhr, status, error){
// Handle error
console.error(xhr.responseText); // Log error response
}
});
});
});
</script> --}}

<!-- -----------------------------------------------------end---------------------- -->

<style>
    #step-form>div {
        display: none
    }

    #step-form>div:nth-child(1) {
        display: block;
    }
</style>
<script>
    document.getElementById('myfile').addEventListener('change', function() {
        var fileListDiv = document.querySelector('.file-list');
        fileListDiv.innerHTML = ''; // Clear previous entries

        for (var i = 0; i < this.files.length; i++) {
            var file = this.files[i];
            var listItem = document.createElement('div');
            listItem.textContent = file.name;
            fileListDiv.appendChild(listItem);
        }
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
    VirtualSelect.init({
        ele: '#Facility, #Group, #Audit, #Auditee ,#reference_record'
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
    document.addEventListener('DOMContentLoaded', function() {
        const addRowButton = document.getElementById('new-button-icon');
        addRowButton.addEventListener('click', function() {
            const department = this.parentNode.innerText.trim(); // Get the department name

            // Create a new row and insert it after the current row
            const newRow = document.createElement('tr');
            newRow.innerHTML = `<td style="background: #e1d8d8">${department}</td>
                            <td><textarea name="Person"></textarea></td>
                            <td><textarea name="Impect_Assessment"></textarea></td>
                            <td><textarea name="Comments"></textarea></td>
                            <td><textarea name="sign&date"></textarea></td>
                            <td><textarea name="Remarks"></textarea></td>`;

            // Insert the new row after the current row
            const currentRow = this.parentNode.parentNode;
            currentRow.parentNode.insertBefore(newRow, currentRow.nextSibling);
        });
    });
</script>
<script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     document.getElementById('type_of_audit').addEventListener('change', function() {
    //         var typeOfAuditReqInput = document.getElementById('type_of_audit_req');
    //         if (typeOfAuditReqInput) {
    //             var selectedValue = this.value;
    //             if (selectedValue == 'others') {
    //                 typeOfAuditReqInput.setAttribute('required', 'required');
    //             } else {
    //                 typeOfAuditReqInput.removeAttribute('required');
    //             }
    //         } else {
    //             console.error("Element with id 'type_of_audit_req' not found");
    //         }
    //     });
    // });
</script>
<script>
    document.getElementById('initiator_group').addEventListener('change', function() {
        var selectedValue = this.value;
        document.getElementById('initiator_group_code').value = selectedValue;
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
    function addWhyField(con_class, name) {
        let mainBlock = document.querySelector('.why-why-chart')
        let container = mainBlock.querySelector(`.${con_class}`)
        let textarea = document.createElement('textarea')
        textarea.setAttribute('name', name);
        container.append(textarea)
    }
</script>
<div class="modal fade" id="child-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Child</h4>
            </div>
            <form action="{{ route('stageChange', $validation->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="group-input">
                        @if ($validation->stage == 6)
                        <label for="major">
                            <input type="radio" name="child_type" id="major" value="vd">
                            Validation Deviation
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
{{-- <div class="modal fade" id="child-modal1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
    
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Child</h4>
                </div>
                <form  method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="group-input">
                            <label for="major">
                                <input type="radio" name="rsa" id="major"
                                    value="rsa">
                                    RSA
                            </label>
                            <br>
                            <label for="major1">
                                <input type="radio" name="extension" id="major1"
                                    value="extension">
                                    Extension
                            </label>
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
    </div> --}}

<div class="modal fade" id="more-info-required-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('validation_reject', $validation->id) }}" method="POST">
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

<div class="modal fade" id="cancel-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('validationCancel', $validation->id) }}" method="POST">
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


<div class="modal fade" id="deviationIsCFTRequired">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ url('deviationIsCFTRequired', $validation->id) }}" method="POST">
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
<div class="modal fade" id="sendToInitiator">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('validation_check', $validation->id) }}" method="POST">
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
<div class="modal fade" id="hodsend">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('validation_check2', $validation->id) }}" method="POST">
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
<div class="modal fade" id="qasend">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('validation_check3', $validation->id) }}" method="POST">
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


<div class="modal fade" id="signature-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('validation_send_stage', $validation->id) }}" method="POST">
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
<div class="modal fade" id="cft-not-reqired">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('cftnotreqired', $validation->id) }}" method="POST">
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
<div class="modal fade" id="modal1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('deviation_qa_more_info', $validation->id) }}" method="POST">
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
        ele: '#Facility, #Group, #Audit, #Auditee ,#capa_related_record'
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
    document.getElementById('initiator_group').addEventListener('change', function() {
        var selectedValue = this.value;
        document.getElementById('initiator_group_code').value = selectedValue;
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

@endsection