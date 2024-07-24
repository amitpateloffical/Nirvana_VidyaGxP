@extends('frontend.layout.main')
@section('container')
    @php
        $users = DB::table('users')->get();
    @endphp
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

        #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(9) {
            border-radius: 0px 20px 20px 0px;

        }
    </style>
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }

        .sub-main-head {
            display: flex;
            justify-content: space-evenly;
        }

        .Activity-type {
            margin-bottom: 7px;
        }

        /* .sub-head {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            margin-left: 280px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            margin-right: 280px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            color: #4274da;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            border-bottom: 2px solid #4274da;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            padding-bottom: 5px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            margin-bottom: 20px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            font-weight: bold;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            font-size: 1.2rem;

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        } */
        .launch_extension {
            background: #4274da;
            color: white;
            border: 0;
            padding: 4px 15px;
            border: 1px solid #4274da;
            transition: all 0.3s linear;
        }

        .main_head_modal li {
            margin-bottom: 10px;
        }

        .extension_modal_signature {
            display: block;
            width: 100%;
            border: 1px solid #837f7f;
            border-radius: 5px;
        }

        .extension_modal_moreinfo {
            display: block;
            width: 100%;
            border: 1px solid #837f7f;
            border-radius: 5px;
        }

        .main_head_modal {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .create-entity {
            background: #323c50;
            padding: 10px 15px;
            color: white;
            margin-bottom: 20px;

        }

        .bottom-buttons {
            display: flex;
            justify-content: flex-end;
            margin-right: 300px;
            margin-top: 50px;
            gap: 20px;
        }

        .text-danger {
            margin-top: -22px;
            padding: 4px;
            margin-bottom: 3px;
        }

        /* .saveButton:disabled{
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                background: black!important;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                border:  black!important;

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } */

        .main-danger-block {
            display: flex;
        }

        .swal-modal {
            scale: 0.7 !important;
        }

        .swal-icon {
            scale: 0.8 !important;
        }
    </style>



    <!-- --------------------------------------button--------------------- -->

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







    <div class="form-field-head">
        <!-- <div class="pr-id">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            New Document
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div> -->
        <div class="division-bar pt-3">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName(session()->get('division')) }} /Audit Task
        </div>
        <!-- <div class="button-bar">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <button type="button">Save</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <button type="button">Cancel</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <button type="button">New</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <button type="button">Copy</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <button type="button">Child</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <button type="button">Check Spelling</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <button type="button">Change Project</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div> -->
    </div>

    {{-- ======================================
                    DATA FIELDS
    ======================================= --}}
    <div id="change-control-fields">
        <div class="container-fluid">

            <div class="inner-block state-block">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="main-head">Record Workflow </div>

                    <div class="d-flex" style="gap:20px;">
                        @php
                            $userRoles = DB::table('user_roles')
                                ->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => 1])
                                ->get();
                            $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                        @endphp
                        <button class="button_theme1"> <a class="text-white"
                                href="{{ route('audit_task_AuditTrial', $dataas->id) }}"> Audit Trail </a>
                        </button>

                        @if ($dataas->stage == 1)
                            <button class="button_theme1"
                                data-bs-toggle="modal"data-bs-target="#signature-modal">Submit</button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal"> Cancel
                            </button>
                        @elseif($dataas->stage == 2 && (in_array([4, 14], $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#moreinfo-modal">More Info
                                from Open</button>
                            <button class="button_theme1" data-bs-toggle="modal"
                                data-bs-target="#signature-modal">Compliance Verification Complete </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button>
                        @elseif($dataas->stage == 3 && (in_array(9, $userRoleIds) || in_array(18, $userRoleIds)))
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">Request More Info</button> --}}
                            {{-- <button class="button_theme1" data-bs-toggle="modal"data-bs-target="#signature-modal">Approval</button> --}}
                        @endif
                        <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                            </a> </button>
                    </div>

                </div>
                <div class="status">
                    <div class="head">Current Status</div>
                    @if ($dataas->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @else
                        <div class="progress-bars d-flex">
                            @if ($dataas->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($dataas->stage >= 2)
                                <div class="active">Compliance Verification</div>
                            @else
                                <div class="">Compliance Verification</div>
                            @endif

                            @if ($dataas->stage >= 3)
                                <div class="bg-danger">Close Done</div>
                            @else
                                <div class="">Close Done</div>
                            @endif
                        </div>
                    @endif


                </div>
                {{-- @endif --}}
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
        </div>
        <!-- Tab links -->
        <div class="cctab">

            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Compliance Verification</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm17')">Activity Log</button>
        </div>

        <!-- General Information -->

        <form action="{{ route('update', $dataas->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div id="CCForm1" class="inner-block cctabcontent">
                <div class="inner-block-content">

                    <div class="sub-head">Parent Record Information</div>
                    <div class="row">

                        {{-- <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Initiator"> (parent) Date Opened </label>
                                <input type="date" name="open_date">
                            </div>
                        </div> --}}
                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="Scheduled Start Date">Date Opened</label>
                                <div class="calenderauditee">
                                    @php
                                        $Date = isset($dataas->open_date) ? new \DateTime($dataas->open_date) : null;
                                    @endphp
                                    <input type="text" id="open_date" readonly placeholder="DD-MMM-YYYY"
                                        value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                    <input type="date" name="open_date" {{-- min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" --}}
                                        value="{{ $dataas->open_date ?? '' }}" class="hide-input"
                                        oninput="handleDateInput(this, 'open_date')" />
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Initiator"> (parent) CTL Audit No. </label>
                                <input type="text" name="audit_nu"value="{{ $dataas->audit_nu }}">
                            </div>
                        </div>
                        {{-- <div class="col-lg-6">
                            <div class="group-input">
                                <label for="RLS Record Number"><b>Record Number</b></label>
                                <input disabled type="text" name="record_number"
                                    value="{{ Helpers::getDivisionName(session()->get('')) }}/AT/{{ date('Y') }}/{{ $dataas->record }}">
                                {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> 
                    </div>
                </div> --}}

                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Initiator"> (parent) Audit Report Ref. No. </label>
                                <input type="text" name="audit_report_nu"value="{{ $dataas->audit_nu }}">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Initiator"> (parent) Name of Contract Testing Lab </label>
                                <input type="text"
                                    name="name_contract_testing"value="{{ $dataas->name_contract_testing }}">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Initiator"> (parent) Final Responce Received on </label>
                                <input type="text" name="final_responce_on"value="{{ $dataas->final_responce_on }}">
                            </div>
                        </div>


                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Initiator"> (parent) TCD For CAPA Implimention </label>
                                <input type="text"
                                    name="tcd_capa_implimention"value="{{ $dataas->tcd_capa_implimention }}">
                            </div>
                        </div>

                        <div class="sub-head">General Information</div>

                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="RLS Record Number"><b>Record Number</b></label>
                                <input disabled type="text" name="record"
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}/CI/{{ date('Y') }}/{{ $record }}">
                                {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> --}}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Division Code"><b>Site/Location Code</b></label>
                                <input disabled type="text" name="division_code"
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="group-input">
                                <label for="Initiator Group Code"> Initiator </label>
                                <input disabled type="text" value="{{ Auth::user()->name }}">

                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Initiator"> Date of Opened </label>
                                <input disabled type="text" value="{{ date('d-M-Y') }}" name="date_opened">
                                <input type="hidden" value="{{ date('Y-m-d') }}" name="date_opened">

                            </div>
                        </div>

                        <div class="col-12">
                            <div class="group-input">
                                <label for="Short Description">Short Description</label>
                                {{-- <textarea name="short_description" id="docname" type="text"  maxlength="255" ></textarea> --}}
                                <input type="text" name="short_description" value="{{ $dataas->short_description }}">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="group-input">
                                <label for="Short Description">Classification</label>
                                <select name="classification" id="">
                                    <option value=""></option>
                                    <option value="Classification 1"
                                        {{ $dataas->classification == 'Classification 1' ? 'selected' : '' }}>
                                        Classification
                                        1</option>
                                    <option value="Classification 2"
                                        {{ $dataas->classification == 'Classification 2' ? 'selected' : '' }}>
                                        Classification
                                        2</option>
                                </select>
                            </div>
                        </div>

                        {{-- <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Initiator Group">TCD For Clouser Of Audit Task</label>
                                <input type="text" name="closure_of_task" value="{{ $dataas->closure_of_task }}">
                            </div>
                        </div> --}}
                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="TCD For Clouser Of Audit Task"> TCD For Clouser Of Audit Task </label>
                                <input type="text" id="closure_of_task" readonly placeholder="DD-MMM-YYYY"
                                    value="{{ \Carbon\Carbon::parse($closure_of_task)->format('d-M-Y') }}" />
                                <input type="hidden" name="closure_of_task" id="closure_of_task_input"
                                    value="{{ $closure_of_task }}" />

                                {{-- <input type="hidden" value="{{ $due_date }}" name="due_date">
                                        <input disabled type="text" value="{{ Helpers::getdateFormat($due_date) }}"> --}}
                                {{-- <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            value="" name="due_date"> --}}
                            </div>

                        </div>



                        <div class="col-6">
                            <div class="group-input">
                                <label for="Initiator Group Code"> Assignee </label>
                                <select id="select-state" placeholder="Select..." name="assignee">
                                    <option value="">Select a value</option>
                                    @foreach ($users as $value)
                                        <option {{ $dataas->assignee == $value->name ? 'selected' : '' }}
                                            value="{{ $value->name }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-lg-12 ">
                            <div class="group-input">
                                <label for="Initiator Group">Observation</label>
                                <textarea class="summernote" name="observation" value="">{{ $dataas->observation }}</textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="group-input">
                                <label for="Short Description">Complience Details</label>
                                <textarea class="summernote" name="complience_details" value="">{{ $dataas->complience_details }}</textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="group-input">
                                <label for="Short Description">Identified Reasons/ Root cause</label>
                                <textarea class="summernote" name="identified_reasons">{{ $dataas->identified_reasons }}</textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="group-input">
                                <label for="Short Description">Capa Taken/ Resposed</label>
                                <textarea class="summernote" name="capa_respond">{{ $dataas->capa_respond }}</textarea>
                            </div>
                        </div>

                        {{-- <div class="col-6">
                            <div class="group-input">
                                <label for="Short Description">TimeLine Proposed By Auditee</label>
                                <input name="timeline_by_auditee" id="" type="date"
                                    value="{{ $dataas->timeline_by_auditee }}"></input>
                            </div>
                        </div> --}}
                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="Scheduled Start Date">TimeLine Proposed By Auditee</label>
                                <div class="calenderauditee">
                                    @php
                                        $Date = isset($dataas->timeline_by_auditee)
                                            ? new \DateTime($dataas->timeline_by_auditee)
                                            : null;
                                    @endphp
                                    <input type="text" id="timeline_by_auditee" readonly placeholder="DD-MMM-YYYY"
                                        value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                    <input type="date" name="timeline_by_auditee" {{-- min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" --}}
                                        value="{{ $dataas->timeline_by_auditee ?? '' }}" class="hide-input"
                                        oninput="handleDateInput(this, 'timeline_by_auditee')" />
                                </div>
                            </div>
                        </div>



                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="closure attachment">Audit Task Attachment </label>
                                <div><small class="text-primary">
                                    </small>
                                </div>
                                <div class="file-attachment-field">
                                    <div disabled class="file-attachment-list" id="audit_task_attach">
                                        @if ($dataas->audit_task_attach)
                                            @foreach (json_decode($dataas->audit_task_attach) as $file)
                                                <h6 class="file-container text-dark"
                                                    style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                            class="fa fa-eye text-primary"
                                                            style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a class="remove-file" data-file-name="{{ $file }}"><i
                                                            class="fa-solid fa-circle-xmark"
                                                            style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="myfile" name="audit_task_attach[]"
                                            value="{{ $dataas->audit_task_attach }}"
                                            oninput="addMultipleFiles(this, 'audit_task_attach')" multiple>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <!-- <button type="button" class="backButton" onclick="previousStep()">Back</button> -->
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit
                                </a> </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Compliance Verification -->
            <div id="CCForm2" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="sub-head">Compliance Verification </div>
                    <div class="row">

                        <div class="col-lg-12 mb-4">
                            <div class="group-input">
                                <label for="Audit Schedule Start Date"> Compliance Execution Details </label>
                                <div class="col-md-12 4">
                                    <div class="group-input">
                                        <!-- <label for="Description Deviation">Description of Deviation</label> -->
                                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                                        <textarea class="summernote" name="compliance_details" id="summernote-1"> {{ $dataas->compliance_details }} </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Audit Schedule End Date">Date Of Implementation</label>
                                <input type="date" name="date_of_implemetation"
                                    value="{{ $dataas->date_of_implemetation }}" id="">
                            </div>
                        </div> --}}
                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="Scheduled Start Date">Date Of Implementation</label>
                                <div class="calenderauditee">
                                    @php
                                        $Date = isset($dataas->date_of_implemetation)
                                            ? new \DateTime($dataas->date_of_implemetation)
                                            : null;
                                    @endphp
                                    <input type="text" id="date_of_implemetation" readonly placeholder="DD-MMM-YYYY"
                                        value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                    <input type="date" name="date_of_implemetation" {{-- min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" --}}
                                        value="{{ $dataas->date_of_implemetation ?? '' }}" class="hide-input"
                                        oninput="handleDateInput(this, 'date_of_implemetation')" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-4">
                            <div class="group-input">
                                <label for="Description Deviation">Verification Comments</label>
                                <textarea class="summernote" name="verification_comments" id="summernote-1"> {{ $dataas->verification_comments }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="group-input">
                                <label for="Description Deviation">Dealy Justification for Implementation</label>
                                <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                                <textarea class="summernote" name="dealy_justification_for_implementation" id="summernote-1">{{ $dataas->dealy_justification_for_implementation }}
                                    </textarea>
                            </div>
                        </div>

                        <div class="col-md-12 mb-4">
                            <div class="group-input">
                                <label for="Description Deviation">Delay Just For Task Closure</label>
                                <textarea class="summernote" name="delay_just_closure" id="summernote-1"> {{ $dataas->delay_just_closure }}</textarea>
                            </div>
                        </div>



                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="followUp ">Follow-Up Task Required</label>
                                <select name="followup_task">
                                    <option value="">Enter Your Selection Here</option>
                                    <option value="yes" @if ($dataas->followup_task == 'yes') selected @endif>Yes
                                    </option>
                                    <option value="no" @if ($dataas->followup_task == 'no') selected @endif>No
                                    </option>
                                </select>
                            </div>
                        </div>

                        {{-- <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Product/Material Name"> Ref. No. Of Follow-Up Task</label>
                                <select name="ref_of_followup">
                                    <option value="">Enter Your Selection Here</option>
                                    <option value="Task 1" @if ($dataas->ref_of_followup == 'Task 1') selected @endif>Task 1
                                    </option>
                                    <option value="Task 2" @if ($dataas->ref_of_followup == 'Task 2') selected @endif>Task 2
                                    </option>

                                </select>
                            </div>
                        </div> --}}
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Ref. No. Of Follow-Up Task"> Ref. No. Of Follow-Up Task </label>
                                <input type="text" name="ref_of_followup"value="{{ $dataas->ref_of_followup }}">
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="closure attachment">Execution Attachment </label>
                                <div><small class="text-primary">
                                    </small>
                                </div>
                                <div class="file-attachment-field">
                                    <div disabled class="file-attachment-list" id="exe_attechment">
                                        @if ($dataas->exe_attechment)
                                            @foreach (json_decode($dataas->exe_attechment) as $file)
                                                <h6 class="file-container text-dark"
                                                    style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                            class="fa fa-eye text-primary"
                                                            style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a class="remove-file" data-file-name="{{ $file }}"><i
                                                            class="fa-solid fa-circle-xmark"
                                                            style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="myfile" name="exe_attechment[]"
                                            value="{{ $dataas->exe_attechment }}"
                                            oninput="addMultipleFiles(this, 'exe_attechment')" multiple>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="closure attachment">Verification Attachment </label>
                                <div><small class="text-primary">
                                    </small>
                                </div>
                                <div class="file-attachment-field">
                                    <div disabled class="file-attachment-list" id="verification_attechment">
                                        @if ($dataas->verification_attechment)
                                            @foreach (json_decode($dataas->verification_attechment) as $file)
                                                <h6 class="file-container text-dark"
                                                    style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                            class="fa fa-eye text-primary"
                                                            style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a class="remove-file" data-file-name="{{ $file }}"><i
                                                            class="fa-solid fa-circle-xmark"
                                                            style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="myfile" name="verification_attechment[]"
                                            value="{{ $dataas->verification_attechment }}"
                                            oninput="addMultipleFiles(this, 'verification_attechment')" multiple>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-lg-6">
                            <div class="group-input">
                                <label for="closure attachment"> Verification Attachment</label>
                                <div><small class="text-primary"></small></div>
                                <div class="file-attachment-field">
                                    <div disabled class="file-attachment-list" id="verification_attechment">
                                        @if (!empty($dataas->verification_attechment))
                                            @php
                                                // Decode the JSON data into an associative array
                                                $attachments = json_decode($dataas->verification_attechment, true);
                                            @endphp
                                            @if (is_array($verification_attechment))
                                                @foreach ($verification_attechment as $file)
                                                    @if (is_string($file))
                                                        <h6 class="file-container text-dark"
                                                            style="background-color: rgb(243, 242, 240);">
                                                            <b>{{ htmlspecialchars($file) }}</b>
                                                            <a href="{{ asset('upload/' . htmlspecialchars($file)) }}"
                                                                target="_blank">
                                                                <i class="fa fa-eye text-primary"
                                                                    style="font-size:20px; margin-right:-10px;"></i>
                                                            </a>
                                                            <a class="remove-file"
                                                                data-file-name="{{ htmlspecialchars($file) }}">
                                                                <i class="fa-solid fa-circle-xmark"
                                                                    style="color:red; font-size:20px;"></i>
                                                            </a>
                                                        </h6>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endif
                                    </div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="verification_attechment" name="verification_attechment[]"
                                            value="{{ $dataas->verification_attechment }}"
                                            oninput="addMultipleFiles(this, 'verification_attechment')" multiple>
                                    </div>
                                </div>
                            </div>
                        </div> --}}


                        <div class="button-block">
                            <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" id="ChangeNextButton" class="nextButton"
                                onclick="nextStep()">Next</button>
                            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                    Exit </a> </button>
                        </div>
                    </div>
                </div>

            </div>

            {{-- </div> --}}


            <!----- Signature ----->

            <div id="CCForm17" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="sub-head">
                        Activity Log
                    </div>
                    <div class="row">

                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="Initiator Group">Submit By : </label>
                                <div class="static">{{ $dataas->submited_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="Initiator Group">static On : </label>
                                <div class="static"> {{ $dataas->submited_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="Initiator Group">Comments : </label>
                                <div class="static"> {{ $dataas->submit_comment }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="cancelled by">More Info from Open By :</label>
                                <div class="static"> {{ $dataas->open_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="cancelled on">More Info from Open On :</label>
                                <div class="static">{{ $dataas->open_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="cancelled on">Comments :</label>
                                <div class="static">{{ $dataas->open_comment }}</div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="Initiator Group">Compliance Verification Complete By : </label>
                                <div class="static">{{ $dataas->com_verification_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="Initiator Group">Compliance Verification Complete On: </label>
                                <div class="static"> {{ $dataas->com_verification_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="cancelled on">Comments :</label>
                                <div class="static">{{ $dataas->come_verification_comment }}</div>
                            </div>
                        </div>

                        <!-- ====================================================================== -->


                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="cancelled by">Cancelled By :</label>
                                <div class="static"> {{ $dataas->cancellation_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="cancelled on">Cancelled On :</label>
                                <div class="static">{{ $dataas->cancellation_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="cancelled on">Comments :</label>
                                <div class="static">{{ $dataas->cancellation_comment }}</div>
                            </div>
                        </div>

                    </div>

                    <div class="button-block">
                        {{-- <button type="submit" id="ChangesaveButton" class="saveButton">Save</button> --}}
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        {{-- <button type="button" id="ChangeNextButton" class="nextButton"
                                onclick="nextStep()">Next</button> --}}
                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
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
                <form action="{{ route('ATStage_change', $dataas->id) }}" method="POST">
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
                <form action="{{ route('follow_up_show', $dataas->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="group-input">
                            <label for="major">
                                <input type="radio" name="revision" id="major" value="Action-Item">
                                Follow Up Task
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

    <div class="modal fade" id="cancel-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('ATCNStages_change', $dataas->id) }}" method="POST">
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
                            <input type="text" name="a_l_comments" required>
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

    {{-- <div class="modal fade" id="moreinfo-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('MoreInfostage_change', $dataas->id) }}" method="POST">
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
                            <input type="comment" name="comment"required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
    <div class="modal fade" id="moreinfo-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('MoreInfostage_change', $dataas->id) }}" method="POST">
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
                    <div class="modal-footer">
                        <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
            ele: '#facility_name, #group_name, #auditee, #audit_team'
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
