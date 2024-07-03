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
$users = DB::table('users')->get();
@endphp

<script>
    function calculateRiskAnalysis(selectElement) {
        // Get the row containing the changed select element
        let row = selectElement.closest('tr');

        // Get values from select elements within the row
        let R = parseFloat(document.getElementById('analysisR').value) || 0;
        let P = parseFloat(document.getElementById('analysisP').value) || 0;
        let N = parseFloat(document.getElementById('analysisN').value) || 0;

        // Perform the calculation
        let result = R * P * N;

        // Update the result field within the row
        document.getElementById('analysisRPN').value = result;
    }
</script>

<div class="form-field-head">

    <div class="division-bar">
        <strong>Site Division/Project</strong> : {{ Helpers::getDivisionName(session()->get('division')) }}/Follow Up Task
    </div>
</div>

@php
$users = DB::table('users')->get();
@endphp
{{-- ======================================
                    DATA FIELDS
    ======================================= --}}
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
                                href="{{ route('followup_auditTrail', $task->id) }}"> Audit Trail </a> </button>

                                @if ($task->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                                <button class="button_theme1" data-bs-toggle="modal"  data-bs-target="#signature-modal">
                                    Submit
                                </button>
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                    Cancellation Request
                                </button>

                        @elseif($task->stage == 2 && (in_array(4, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1"data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Compliance Received
                            </button>
                            <button class="button_theme1"data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                                More Info from Open State
                            </button>
                       @elseif($task->stage == 3 && (in_array(4, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1"data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                                More Info from Compliance in Progress
                            </button>
                            <button class="button_theme1"data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Verification Complete
                            </button>
                        @endif
                        <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                            </a> </button>

                    </div>

                </div>
                <div class="status">
                    <div class="head">Current Status</div>
                    {{-- ------------------------------By Pankaj-------------------------------- --}}
                    @if ($task->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @else
                        <div class="progress-bars">
                            @if ($task->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($task->stage >= 2)
                                <div class="active">Compliance In-Progress </div>
                            @else
                                <div class="">Compliance In-Progress</div>
                            @endif

                            @if ($task->stage >= 3)
                                <div class="active">Compliance Verification</div>
                            @else
                                <div class="">Compliance Verification</div>
                            @endif

                            @if ($task->stage >= 4)
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
<div id="change-control-fields">
    <div class="container-fluid">




        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Compliance In-Progress</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Compliance Verification</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Activity log</button>
            <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Signatures</button> -->
        </div>

        <form action="{{ route('followup_update' ,$task->id) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div id="step-form">

                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-12">
                                <div class="sub-head">Parent record Information</div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Scheduled Start Date">(Parent) Date Opened</label>
                                    <div class="calenderauditee">
                                    @php
                                        $ParentDate = new \DateTime($task->parent_date);
                                    @endphp
                                    {{-- Format the date as desired --}}
                                    <input type="text" id="parent_date" readonly placeholder="DD-MMM-YYYY"
                                        value="{{ $ParentDate->format('j-F-Y') }}" />
                                    <input type="date" name="parent_date"
                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                        value="{{ $task->parent_date }}" class="hide-input"
                                        oninput="handleDateInput(this, 'parent_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Description">(Parent) Observation</label>
                                    <textarea name="Parent_observation" >{{old('Parent_observation', $task->Parent_observation) }}</textarea>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Description">(Parent) Classification</label>
                                    <select name="parent_classification">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="PC-1" @if ($task->parent_classification == 'PC-1') selected @endif>PC-1</option>
                                        <option value="PC-1" @if ($task->parent_classification == 'PC-2') selected @endif>PC-2</option>
                                        <option value="PC-1" @if ($task->parent_classification == 'PC-3')selected @endif>PC-3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Description">(Parent) CAPA Taken/Proposed</label>
                                    <textarea name="capa_taken" >{{ old('capa_taken', $task->capa_taken) }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Scheduled Start Date">(Parent) TCD for Closure of Audit Task</label>
                                    <div class="calenderauditee">
                                        {{-- <input type="text" id="parent_tcd_for_closure_of_audit_task" readonly placeholder="DD-MM-YYYY" /> --}}
                                        @php
                                        $ParentsDate = new \DateTime($task->tcd_date);
                                    @endphp
                                    {{-- Format the date as desired --}}
                                    <input type="text" id="tcd_date" readonly placeholder="DD-MMM-YYYY"
                                        value="{{ $ParentsDate->format('j-F-Y') }}" />
                                    <input type="date" name="tcd_date"
                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                        value="{{ $task->tcd_date }}" class="hide-input"
                                        oninput="handleDateInput(this, 'tcd_date')" />
                                        {{-- <input type="date" id="start_date_checkdate" name="tcd_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'tcd_date');checkDate('start_date_checkdate','end_date_checkdate')" /> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="sub-head">General Information</div>

                            {{-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Originator"><b>Record Number</b></label>
                                    <input  type="text" name="record_number"
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}/FU/{{ date('Y') }}/{{ $record_number }}">
                                </div>
                            </div> --}}

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Record Number</b></label>
                                    <input disabled type="text" name="record_number"
                                        value="{{ Helpers::getDivisionName($task->division_id) }}/FU/{{ date('Y') }}/{{$task->record_number }}">
                                    {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> --}}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="division_code"><b>Division Code</b></label>
                                    <input readonly type="text" name="division_code" id="division_code" value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                    {{-- <div class="static">QMS-North America</div> --}}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Originator"><b>Initiator</b></label>

                                    <input disabled type="text" name="originator_id"
                                        value="{{ $task->originator_id ?? Auth::user()->name }}">

                                    {{-- <input disabled type="text" name="Originator" value=""> --}}
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="date_opened">Date of Initiation</label>
                                    <input disabled type="text" value="{{ date('d-M-Y') }}" name="initiation_date">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" name="initiation_date">
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="If Others">Assigned To</label>
                                    <select name="assigned_to">
                                       <option value="">Select a value</option>
                                        <option value="">-- select --</option>
                                        @if ($users->isNotEmpty())
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" {{ $user->id == $task->assigned_to ? 'selected' : ''}}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        @endif

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span></label>
                                    <input id="docname" type="text" name="short_description"  value="{{ $task->short_description }}" maxlength="255" required>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Description">Follow-up Task Description</label>
                                    <textarea name="followup_Desc">{{ old('followup_Desc', $task->followup_Desc) }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Due Date">Date Due</label>

                                    <div class="calenderauditee">
                                        @php
                                            $followupDueDate = new \DateTime($task->due_date);
                                        @endphp
                                        {{-- Format the date as desired --}}
                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY"
                                            value="{{ $followupDueDate->format('j-F-Y') }}" />
                                        <input type="date" name="due_date"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            value="{{ $task->due_date }}" class="hide-input"
                                            oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div>



                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Attached File">Attached File</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">

                                        <div class="file-attachment-list" id="file_attachment">
                                            @if ($task->file_attachment)
                                                @foreach (json_decode($task->file_attachment) as $file)
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
                                            <input type="file" id="HOD_Attachments"
                                                name="file_attachment[]"value="{{ $task->file_attachment }}"
                                                oninput="addMultipleFiles(this, 'file_attachment')" multiple>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="button-block">
                            <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                            <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                            <button type="button"> <a class="text-white"> Exit </a> </button>
                        </div>
                    </div>
                </div>

                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-12">
                                <div class="sub-head">Compliance Execution</div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Compliance Execution Details">Compliance Execution Details</label>
                                    <textarea name="execution_details">{{ old('execution_details', $task->execution_details) }}</textarea>
                                </div>
                            </div>


                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Scheduled Start Date">Date of Completion</label>
                                    <div class="calenderauditee">

                                        @php
                                        $CompletionDate = new \DateTime($task->completion_date);
                                    @endphp
                                    {{-- Format the date as desired --}}
                                    <input type="text" id="completion_date" readonly placeholder="DD-MMM-YYYY"
                                        value="{{ $CompletionDate->format('j-F-Y') }}" />
                                    <input type="date" name="completion_date"
                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                        value="{{ $task->completion_date }}" class="hide-input"
                                        oninput="handleDateInput(this, 'completion_date')" />
                                    </div>
                                </div>
                            </div>




                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Initial Attachments">Execution Attachment</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                    {{-- <input type="file" id="myfile" name="Initial_Attachment" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}
                                        value="{{ $data->Initial_Attachment }}"> --}}
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="execution_attachment">
                                                @if ($task->execution_attachment)
                                                @foreach (json_decode($task->execution_attachment) as $file)
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
                                                <input type="file" id="myfile" name="execution_attachment[]"
                                                    oninput="addMultipleFiles(this, 'execution_attachment')" multiple>
                                            </div>
                                        </div>
                                </div>
                            </div>


                            {{-- <div class="group-input">
                                <label for="file_attchment_if_any">Execution Attachment</label>
                                <div><small class="text-primary">Please Attach all relevant or supporting
                                        documents</small></div>
                                <div class="file-attachment-task">
                                    <div class="file-attachment-list" id="file_attchment_if_any"></div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="myfile" name="execution_attachment"  oninput="addMultipleFiles(this, 'file_attchment_if_any')" multiple>
                                    </div>
                                </div>
                            </div> --}}


                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Description">Delay Justification</label>
                                    <textarea name="delay_justification">{{old('delay_justification', $task->delay_justification) }}</textarea>
                                </div>
                            </div>


                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white"> Exit </a> </button>
                        </div>
                    </div>
                </div>

                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">


                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Description">Verification Comments</label>
                                    <textarea name="varification_comments">{{old('varification_comments', $task->varification_comments) }}</textarea>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="file_attchment_if_any">Verification Attachment</label>
                                <div><small class="text-primary">Please Attach all relevant or supporting
                                        documents</small></div>
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="verification_attachment">
                                        @if ($task->verification_attachment)
                                                @foreach (json_decode($task->verification_attachment) as $file)
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
                                        <input type="file" id="myfile" name="verification_attachment[]"
                                                    oninput="addMultipleFiles(this, 'verification_attachment')" multiple>
                                </div>
                            </div>
                            </div>




                            <div class="sub-head">Cancellation</div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Description">Cancellation Remarks</label>
                                    <textarea name="cancellation_remarks">{{old('cancellation_remarks', $task->cancellation_remarks) }}</textarea>
                                </div>
                            </div>

                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white"> Exit </a> </button>
                        </div>
                    </div>
                </div>

                <div id="CCForm4" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-12">
                                <div class="sub-head">General Information</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Completed By">Submitted By</label>
                                        <div class="">{{ $task->submitted_by }}</div>
                                        {{-- <div class="static">Person datafield</div>/ --}}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Completed On">Submitted On</label>
                                        <div class="">{{ $task->submitted_on }}</div>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Completed On">Comment </label>
                                        <div class="">{{ $task->comment}}</div>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Completed By">Cancellation Request By</label>
                                        <div class="">{{ $task->cancel_by }}</div>
                                        {{-- <div class="static">Person datafield</div>/ --}}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Completed On">Cancellation Request On</label>
                                        <div class="">{{ $task->cancel_on }}</div>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Completed On">Comment </label>
                                        <div class="">{{ $task->cancellation_comment }}</div>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="sub-head">Compliance Execution</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Completed By">Compliance Received By</label>
                                        <div class="">{{ $task->compliance_by }}</div>
                                        {{-- <div class="static">Person datafield</div>/ --}}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Completed On">Compliance Received On</label>
                                        <div class="">{{ $task->compliance_on }}</div>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Completed On">Comment</label>
                                        <div class="">{{ $task->compliance_comment }}</div>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Completed By">More Info from Open State By</label>
                                        <div class="">{{ $task->open_state_by }}</div>
                                        {{-- <div class="static">Person datafield</div>/ --}}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Completed On">More Info from Open State On</label>
                                        <div class="">{{ $task->open_state_on }}</div>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Completed On">Comment</label>
                                        <div class="">{{ $task->open_state_comment }}</div>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="sub-head">Compliance Verification</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Completed By">Verification Complete By</label>
                                        <div class="">{{ $task->varification_by }}</div>
                                        {{-- <div class="static">Person datafield</div>/ --}}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Completed On">Verification Complete On</label>
                                        <div class="">{{ $task->varification_on }}</div>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Completed On">Comment</label>
                                        <div class="">{{ $task->varification_comment }}</div>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Completed By">More Info from Compliance in Progress By</label>
                                        <div class="">{{ $task->progress_by }}</div>
                                        {{-- <div class="static">Person datafield</div>/ --}}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Completed On">More Info from Compliance in Progress On</label>
                                        <div class="">{{ $task->progress_on }}</div>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Completed On">Comment</label>
                                        <div class="">{{ $task->progress_comment }}</div>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>

                            </div>




                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white"> Exit </a> </button>
                        </div>
                    </div>
                </div>

                <div id="CCForm5" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Completed_By">Completed By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Completed_On">Completed On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="QA_Approved_By">QA Approved By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="QA_Approved_On">QA Approved On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Final_Approval_By">Final Approval By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Final_Approval_On">Final Approval On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="submit">Submit</button>
                            <button type="button"> <a class="text-white" href="{{ url('dashboard') }}"> Exit </a>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </form>

    </div>
</div>

  {{-- Signature model --}}

<div class="modal fade" id="signature-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('followup_sends_stage', $task->id) }}" method="POST">
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


{{-- cancel model --}}
<div class="modal fade" id="cancel-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('followup_Cancel', $task->id) }}" method="POST">
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

{{-- more info  required--}}

 <!-- signature model -->

 <div class="modal fade" id="more-info-required-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('followup_qa_more_info', $task->id) }}" method="POST">
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


{{--     More info required  reject--}}

<div class="modal fade" id="more-info-required-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('followup_task_reject', $task->id) }}" method="POST">
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
        ele: '#Facility, #Group, #Audit, #Auditee'
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

{{-- file remove --}}

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



<script>
    $(document).ready(function() {
        $('#observation_table').click(function(e) {
            function generateTableRow(serialNumber) {
                var users = @json($users);
                console.log(users);
                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="action[]"></td>' +
                    '<td><select name="responsible[]">' +
                    '<option value="">Select a value</option>';

                for (var i = 0; i < users.length; i++) {
                    html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                }

                html += '</select></td>' +
                    // '<td><input type="date" name="deadline[]"></td>' +
                    '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"><input type="text" id="deadline' + serialNumber + '" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="deadline[]" class="hide-input" oninput="handleDateInput(this, `deadline' + serialNumber + '`)" /></div></div></div></td>' +

                    '<td><input type="text" name="item_status[]"></td>' +
                    '</tr>';



                return html;
            }

            var tableBody = $('#observation tbody');
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

@endsection
