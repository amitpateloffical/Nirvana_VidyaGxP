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

    #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(6) {
        border-radius: 0px 20px 20px 0px;

    }
</style>

<div class="form-field-head">
    {{-- <div class="pr-id">
            New Child
        </div> --}}
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        / Variation
    </div>
</div>



{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">
        <div class="inner-block state-block">
            <div class="d-flex justify-content-between align-items-center">
                <div class="main-head">Record Workflow </div>
                @php
                    $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $data->division_id])->get();
                    $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                @endphp
                <div class="d-flex" style="gap:20px;">
                    {{-- <button class="button_theme1" onclick="window.print();return false;"
                        class="new-doc-btn">Print</button> --}}
                    <button class="button_theme1"> <a class="text-white"
                            href="{{ route('variation-audittrail', $data->id) }}"> Audit Trail </a> </button>

                    {{-- @if ($data->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds))) --}}
                    @if ($data->stage == 1)
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Start
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Cancel
                        </button>
                    {{-- @elseif($data->stage == 2 && (in_array(4, $userRoleIds) || in_array(18, $userRoleIds) || in_array(13, $userRoleIds))) --}}
                    @elseif ($data->stage == 2)
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Submit for Review
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#moreinfo-modal">
                            Request more info.
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Cancel
                        </button>
                    {{-- @elseif($data->stage == 3 && (in_array(10, $userRoleIds) || in_array(18, $userRoleIds) || in_array(13, $userRoleIds))) --}}
                    @elseif ($data->stage == 3)
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Submit
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#moreinfo-modal">
                        Request more info.
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                        Cancel
                    </button>
                    @elseif ($data->stage == 4)
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Approval Received
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#refused-modal">
                        Refused
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#withdraw-modal">
                        Withdraw
                    </button>
                    @elseif ($data->stage == 5)
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Registration Updated
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#retired-modal">
                        Registration Retired
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
                @elseif ($data->stage == -1)
                    <div class="progress-bars">
                        <div class="bg-danger">Closed-Withdrawn</div>
                    </div>
                @elseif ($data->stage == -2)
                    <div class="progress-bars">
                        <div class="bg-danger">Closed-Not Approved</div>
                    </div>
                @elseif ($data->stage == -3)
                    <div class="progress-bars">
                        <div class="bg-danger">Closed-Retired</div>
                    </div>
                @else
                    <div class="progress-bars d-flex">
                        @if ($data->stage >= 1)
                            <div class="active">Opened</div>
                        @else
                            <div class="">Opened</div>
                        @endif

                        @if ($data->stage >= 2)
                            <div class="active">Submission Preparation</div>
                        @else
                            <div class="">Submission Preparation</div>
                        @endif

                        @if ($data->stage >= 3)
                            <div class="active">Pending Submission Review</div>
                        @else
                            <div class="">Pending Submission Review</div>
                        @endif

                        @if ($data->stage >= 4)
                            <div class="active">Authority Assessment</div>
                        @else
                            <div class="">Authority Assessment</div>
                        @endif

                        @if ($data->stage >= 5)
                            <div class="active">Pending Registration Update</div>
                        @else
                            <div class="">Pending Registration Update</div>
                        @endif

                        @if ($data->stage >= 6)
                            <div class="bg-danger">Approved</div>
                        @else
                            <div class="">Approved</div>
                        @endif
                    </div>
                @endif


            </div>
            {{-- @endif --}}
            {{-- ---------------------------------------------------------------------------------------- --}}
        </div>
        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Variation</button>
            <button class="cctablinks " onclick="openCity(event, 'CCForm2')">Variation Plan</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Product Details</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Registration Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Signatures</button>

        </div>
        <script>
            $(document).ready(function() {
                <?php if ($data->stage == 6): ?>
                    $("#target :input").prop("disabled", true);
                <?php endif; ?>
            });
        </script>
        <form id="target" action="{{ route('variation-update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div id="step-form">
                @if (!empty($parent_id))
                <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                @endif
                @php
                    $users = DB::table('users')->get();
                @endphp
                <!-- Tab-1 -->

                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">General Information</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="trade_name"><b>(Root Parent) Trade Name</b></label>
                                    <input type="text" name="trade_name" value="{{ $data->trade_name }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="member_state">
                                        (Parent) Member State <span class="text-danger"></span>
                                    </label>
                                    <select id="member_state" placeholder="Select..." name="member_state">
                                        <option value="">Select a value</option>
                                        <option value="MP" @if ($data->member_state == 'MP') selected @endif>MP</option>
                                        <option value="UP" @if ($data->member_state == 'UP') selected @endif>UP</option>
                                        <option value="GJ" @if ($data->member_state == 'GJ') selected @endif>GJ</option>
                                    </select>

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="initiator"><b>Initiator</b></label>
                                    <input disabled type="text" name="initiator" value="{{ Auth::user()->name }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input ">
                                    <label for="date_of_initiation"><b>Date of Initiation</b></label>
                                    <input readonly type="text"
                                    value="{{ Helpers::getdateFormat($data->date_of_initiation) }}"
                                    name="date_of_initiation"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : ''}}>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="group-input">
                                    <label for="short_description">Short Description<span class="text-danger">*</span></label>
                                    <p>255 characters remaining</p>
                                    <input id="docname" value="{{ $data->short_description }}" type="text" name="short_description" maxlength="255" required>
                                </div>
                            </div>

                            <div class="col-md-6 pt-3">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select id="assigned_to" placeholder="Select..." name="assigned_to">
                                        <option value="">--Select--</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" @if ($user->id == $data->assigned_to) selected @endif>{{ $user->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="date_due">Date Due <span class="text-danger"></span></label>
                                    <div><small class="text-primary">Please mention expected date of completion</small></div>

                                    <div class="calenderauditee">
                                        {{-- <input type="text" id="date_due" readonly placeholder="DD-MMM-YYYY" /> --}}
                                        <input readonly type="text"
                                            value="{{ Helpers::getdateFormat($data->date_due) }}"
                                            name="date_due">
                                        {{-- <input type="date" name="date_due" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'date_due')" /> --}}
                                    </div>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="type">Type</label>
                                    <select id="type" name="type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="T-1" @if ($data->type == 'T-1') selected @endif>T-1</option>
                                        <option value="T-2" @if ($data->type == 'T-2') selected @endif>T-2</option>
                                        <option value="T-3" @if ($data->type == 'T-3') selected @endif>T-3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="related_change_control"> Related Change Control</label>
                                    <select  id="related_change_control" name="related_change_control">
                                        <option value="">--Select---</option>
                                        <option value="RCC-1" @if ($data->related_change_control == 'RCC-1') selected @endif>RCC-1</option>
                                        <option value="RCC-2" @if ($data->related_change_control == 'RCC-2') selected @endif>RCC-2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments">Variation Description</label>
                                    <input type="text" name="variation_description" value="{{ $data->variation_description }}">
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="variation_code">Variation Code</label>
                                    <select name="variation_code">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="P-1" @if ($data->variation_code == 'P-1') selected @endif>P-1</option>
                                        <option value="P-2" @if ($data->variation_code == 'P-2') selected @endif>P-2</option>
                                        <option value="P-3" @if ($data->variation_code == 'P-3') selected @endif>P-3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="closure attachment">Attached Files </label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="attached_files">
                                            @if ($data->attached_files)
                                            @foreach(json_decode($data->attached_files) as $file)
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
                                            <input type="file" id="myfile" name="attached_files[]"
                                                oninput="addMultipleFiles(this, 'attached_files')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="change_from"><b>Change From</b></label>
                                    <input type="text" name="change_from" value="{{ $data->change_from }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="change_to"><b>Change To</b></label>
                                    <input type="text" name="change_to" value="{{ $data->change_to }}">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="description">Description<span class="text-danger"></span></label>
                                    <textarea placeholder="" name="description">{{ $data->description }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="documents"><b>Documents</b></label>
                                    <input type="text" name="documents" value="{{ $data->documents }}">
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

                <!-- Tab-2 -->
                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">Registration Plan</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="registration_status">Registration Status </label>
                                    <select name="registration_status">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="Done" @if ($data->registration_status == 'Done') selected @endif>Done</option>
                                        <option value="Progress" @if ($data->registration_status == 'Progress') selected @endif>Progress</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="registration_number">Registration Number</label>
                                    <input type="text" name="registration_number" value="{{ $data->registration_number }}">
                                </div>
                            </div>

                            <div class="sub-head">Important Date</div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="planned_submission_date">Planned Submission Date</label>
                                    <div class="calenderauditee">
                                        <input readonly type="text" id="planned_submission_date" value="{{ Helpers::getdateFormat($data->planned_submission_date) }}" name="planned_submission_date" placeholder="DD-MMM-YYYY">
                                        <input type="date" name="planned_submission_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $data->planned_submission_date }}" class="hide-input" oninput="handleDateInput(this, 'planned_submission_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="actual_submission_date">Actual Submission Date</label>
                                    <div class="calenderauditee">
                                        <input readonly type="text" id="actual_submission_date" value="{{ Helpers::getdateFormat($data->actual_submission_date) }}" name="actual_submission_date" placeholder="DD-MMM-YYYY">
                                        <input type="date" name="actual_submission_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $data->actual_submission_date }}" class="hide-input" oninput="handleDateInput(this, 'actual_submission_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="planned_approval_date">Planned Approval Date</label>
                                    <div class="calenderauditee">
                                        <input readonly type="text" id="planned_approval_date" value="{{ Helpers::getdateFormat($data->planned_approval_date) }}" name="planned_approval_date" placeholder="DD-MMM-YYYY">
                                        <input type="date" name="planned_approval_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $data->planned_approval_date }}" class="hide-input" oninput="handleDateInput(this, 'planned_approval_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="actual_approval_date">Actual Approval Date</label>
                                    <div class="calenderauditee">
                                        <input readonly type="text" id="actual_approval_date" value="{{ Helpers::getdateFormat($data->actual_approval_date) }}" name="actual_approval_date" placeholder="DD-MMM-YYYY">
                                        <input type="date" name="actual_approval_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $data->actual_approval_date }}" class="hide-input" oninput="handleDateInput(this, 'actual_approval_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="actual_withdrawn_date">Actual Withdrawn Date</label>
                                    <div class="calenderauditee">
                                        <input readonly type="text" id="actual_withdrawn_date" value="{{ Helpers::getdateFormat($data->actual_withdrawn_date) }}" name="actual_withdrawn_date" placeholder="DD-MMM-YYYY">
                                        <input type="date" name="actual_withdrawn_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $data->actual_withdrawn_date }}" class="hide-input" oninput="handleDateInput(this, 'actual_withdrawn_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="actual_rejection_date">Actual Rejection Date</label>
                                    <div class="calenderauditee">
                                        <input readonly type="text" id="actual_rejection_date" value="{{ Helpers::getdateFormat($data->actual_rejection_date) }}" name="actual_rejection_date" placeholder="DD-MMM-YYYY">
                                        <input type="date" name="actual_rejection_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $data->actual_rejection_date }}" class="hide-input" oninput="handleDateInput(this, 'actual_rejection_date')" />
                                    </div>
                                </div>
                            </div>




                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="comments">Comments<span class="text-danger"></span></label>
                                    <textarea placeholder="" name="comments">{{ $data->comments }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="related_countries"> Related Countries</label>
                                    <select id="related_countries" name="related_countries" id="">
                                        <option value="">--Select---</option>
                                        <option value="India" @if ($data->related_countries == 'India') selected @endif>India</option>
                                        <option value="USA"  @if ($data->related_countries == 'USA') selected @endif>USA</option>
                                    </select>
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
                </div>
                <!-- Tab-3 -->

                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="product_trade_name">(Root Parent ) Trade Name</label>
                                    <input type="text" name="product_trade_name" value="{{ $data->product_trade_name }}"/>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="local_trade_name">(Parent) Local Trade Name</label>
                                    <input type="text" name="local_trade_name" value="{{ $data->local_trade_name }}"/>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="manufacturer">(Parent) Manufacturer </label>
                                    <input type="text" name="manufacturer" value="{{ $data->manufacturer }}"/>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Packaging Information (0)
                                    <button type="button" name="audit-agenda-grid" id="PackagingAdd">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        Open
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Packaging-Table">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Primary Packaging</th>
                                                <th style="width: 14%">Material</th>
                                                <th style="width: 14%">Pack Size</th>
                                                <th style="width: 14%">Shelf Life</th>
                                                <th style="width: 15%">Storage Condition</th>
                                                <th style="width: 15%">Secondary Packaging</th>
                                                <th style="width: 15%">Remarks</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($packaging && is_array($packaging->data))
                                                @foreach ($packaging->data as $index => $gridData)
                                                    <tr>
                                                        <td><input disabled type="text" name="packaging[{{ $loop->index }}][serial]" value="{{ $loop->index+1 }}"></td>
                                                        <td><input type="text" name="packaging[{{ $loop->index }}][PrimaryPackaging]" value="{{ array_key_exists('PrimaryPackaging', $gridData) ? $gridData['PrimaryPackaging'] : '' }}"></td>
                                                        <td><input type="text" name="packaging[{{ $loop->index }}][Material]" value="{{ array_key_exists('Material', $gridData) ? $gridData['Material'] : '' }}"></td>
                                                        <td><input type="text" name="packaging[{{ $loop->index }}][PackSize]" value="{{ array_key_exists('PackSize', $gridData) ? $gridData['PackSize'] : '' }}"></td>
                                                        <td><input type="text" name="packaging[{{ $loop->index }}][ShelfLife]" value="{{ array_key_exists('ShelfLife', $gridData) ? $gridData['ShelfLife'] : '' }}"></td>
                                                        <td><input type="text" name="packaging[{{ $loop->index }}][StorageCondition]" value="{{ array_key_exists('StorageCondition', $gridData) ? $gridData['StorageCondition'] : '' }}"></td>
                                                        <td><input type="text" name="packaging[{{ $loop->index }}][SecondaryPackaging]" value="{{ array_key_exists('SecondaryPackaging', $gridData) ? $gridData['SecondaryPackaging'] : '' }}"></td>
                                                        <td><input type="text" name="packaging[{{ $loop->index }}][Remarks]" value="{{ array_key_exists('Remarks', $gridData) ? $gridData['Remarks'] : '' }}"></td>
                                                        <td></td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <td><input disabled type="text" name="packaging[0][serial]" value="1"></td>
                                                <td><input type="text" name="packaging[0][PrimaryPackaging]"></td>
                                                <td><input type="text" name="packaging[0][Material]"></td>
                                                <td><input type="text" name="packaging[0][PackSize]"></td>
                                                <td><input type="text" name="packaging[0][ShelfLife]"></td>
                                                <td><input type="text" name="packaging[0][StorageCondition]"></td>
                                                <td><input type="text" name="packaging[0][SecondaryPackaging]"></td>
                                                <td><input type="text" name="packaging[0][Remarks]"></td>
                                                <td></td>
                                            @endif
                                        </tbody>
                                    </table>
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
                </div>
                <!-- Tab-4 -->
                <div id="CCForm4" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>

                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>

                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                                    </a> </button>
                            </div>


                            <!-- <div class="button-block">
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                                    </a> </button>
                            </div> -->
                        </div>
                    </div>
                </div>
                <!-- Tab-5 -->
                <div id="CCForm5" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="col-3">
                                <div class="group-input">
                                    <label for="started_by">Started by :</label>
                                    <div class="static">{{ $data->started_by }}</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="group-input">
                                    <label for="started_on"><b>Started on :</b></label>
                                    <div class="date">{{ $data->started_on }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="started_on"><b>Comments :</b></label>
                                    <div class="date">{{ $data->started_comment }}</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="group-input">
                                    <label for="submitted_by ">Submitted for Review by :</label>
                                    <div class="static">{{ $data->review_submitted_by }}</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="group-input">
                                    <label for="submitted_on"><b>Submitted for Review on :</b></label>
                                    <div class="date">{{ $data->review_submitted_on }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="started_on"><b>Comments :</b></label>
                                    <div class="date">{{ $data->review_submitted_comment }}</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="group-input">
                                    <label for="submitted_by ">Submitted by :</label>
                                    <div class="static">{{ $data->submitted_by }}</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="group-input">
                                    <label for="submitted_on"><b>Submitted on :</b></label>
                                    <div class="date">{{ $data->submitted_on }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="started_on"><b>Comments :</b></label>
                                    <div class="date">{{ $data->submitted_comment }}</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="group-input">
                                    <label for="approved_by ">Approval Received by :</label>
                                    <div class="static">{{ $data->approved_by }}</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="group-input">
                                    <label for="approved_on"><b>Approval Received on :</b></label>
                                    <div class="date">{{ $data->approved_on }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="started_on"><b>Comments :</b></label>
                                    <div class="date">{{ $data->approved_comment }}</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="group-input">
                                    <label for="withdrawn_by ">Withdrawn by :</label>
                                    <div class="static">{{ $data->withdrawn_by }}</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="group-input">
                                    <label for="withdrawn_on"><b>Withdrawn on :</b></label>
                                    <div class="date">{{ $data->withdrawn_on }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="started_on"><b>Comments :</b></label>
                                    <div class="date">{{ $data->withdrawn_comment }}</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="group-input">
                                    <label for="refused_by ">Refused by :</label>
                                    <div class="static">{{ $data->refused_by }}</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="group-input">
                                    <label for="refused_on"><b>Refused on :</b></label>
                                    <div class="date">{{ $data->refused_on }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="started_on"><b>Comments :</b></label>
                                    <div class="date">{{ $data->refused_comment }}</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="group-input">
                                    <label for="approved_by ">Registration Updated by :</label>
                                    <div class="static">{{ $data->registration_updated_by }}</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="group-input">
                                    <label for="approved_on"><b>Registration Updated on :</b></label>
                                    <div class="date">{{ $data->registration_updated_on }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="started_on"><b>Comments :</b></label>
                                    <div class="date">{{ $data->registration_updated_comment }}</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="group-input">
                                    <label for="approved_by ">Registration Retired by :</label>
                                    <div class="static">{{ $data->registration_retired_by }}</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="group-input">
                                    <label for="approved_on"><b>Registration Retired on :</b></label>
                                    <div class="date">{{ $data->registration_retired_on }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="started_on"><b>Comments :</b></label>
                                    <div class="date">{{ $data->registration_retired_comment }}</div>
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
            <form action="{{ route('variation-sendStage', $data->id) }}" method="POST">
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

<div class="modal fade" id="cancel-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('variation-cancel', $data->id) }}" method="POST">
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

<div class="modal fade" id="withdraw-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('variation-withdraw', $data->id) }}" method="POST">
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

<div class="modal fade" id="refused-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('variation-refused', $data->id) }}" method="POST">
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

<div class="modal fade" id="retired-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('variation-retired', $data->id) }}" method="POST">
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

<div class="modal fade" id="moreinfo-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('variation-moreinfo', $data->id) }}" method="POST">
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
    $(document).ready(function() {
        $('#PackagingAdd').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="packaging[' + serialNumber + '][serial]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="packaging[' + serialNumber + '][PrimaryPackaging]"></td>' +
                    '<td><input type="text" name="packaging[' + serialNumber + '][Material]"></td>' +
                    '<td><input type="text" name="packaging[' + serialNumber + '][PackSize]"></td>' +
                    '<td><input type="text" name="packaging[' + serialNumber + '][ShelfLife]"></td>' +
                    '<td><input type="text" name="packaging[' + serialNumber + '][StorageCondition]"></td>' +
                    '<td><input type="text" name="packaging[' + serialNumber + '][SecondaryPackaging]"></td>' +
                    '<td><input type="text" name="packaging[' + serialNumber + '][Remarks]"></td>' +
                    '<td><button type="text" class="removeRowBtn" ">Remove</button></td>' +
                    '</tr>';
                '</tr>';

                return html;
            }

            var tableBody = $('#Packaging-Table tbody');
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
