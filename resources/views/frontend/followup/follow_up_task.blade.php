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
<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Compliance In-Progress</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Compliance Verification</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Activity log</button>
            <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Signatures</button> -->
        </div>

        <form action="{{ route('followup_store') }}" method="post" enctype="multipart/form-data">
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


                                    {{-- Format the date as desired --}}
                                    <input type="text" id="parent_date" readonly placeholder="DD-MMM-YYYY"/>
                                    <input type="date" name="parent_date"
                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                         class="hide-input"
                                        oninput="handleDateInput(this, 'parent_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Description">(Parent) Observation</label>
                                    <textarea name="Parent_observation" ></textarea>
                                </div>
                            </div>



                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Description">(Parent) Classification</label>
                                    <select name="parent_classification">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="PC-1">PC-1</option>
                                        <option value="PC-1">PC-2</option>
                                        <option value="PC-1">PC-3</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Description">(Parent) CAPA Taken/Proposed</label>
                                    <textarea name="capa_taken"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Scheduled Start Date">(Parent) TCD for Closure of Audit Task</label>
                                    <div class="calenderauditee">
                                        {{-- <input type="text" id="parent_tcd_for_closure_of_audit_task" readonly placeholder="DD-MM-YYYY" /> --}}

                                    {{-- Format the date as desired --}}
                                    <input type="text" id="tcd_date" readonly placeholder="DD-MMM-YYYY" />
                                    <input type="date" name="tcd_date"
                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                         class="hide-input"
                                        oninput="handleDateInput(this, 'tcd_date')" />
                                        {{-- <input type="date" id="start_date_checkdate" name="tcd_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'tcd_date');checkDate('start_date_checkdate','end_date_checkdate')" /> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="sub-head">General Information</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Record Number</b></label>
                                    <input type="text" name="record_number"  value="{{ Helpers::getDivisionName(session()->get('division')) }}/FU/{{ date('Y') }}/{{ $record_number }}">
                                 </div>

                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Division Code</b></label>
                                    <input readonly type="text" name="division_code" value="{{ Helpers::getDivisionName(session()->get('division')) }}">
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
                                    <select name="assigned_to" onchange="">

                                        <option value="">Select a value</option>
                                        <option value="">-- select --</option>
                                            @if ($users->isNotEmpty())
                                                @foreach ($users as $user)
                                                    <option value='{{ $user->id }}'>{{ $user->name }}</option>
                                                @endforeach
                                            @endif
                                        {{-- <option value="">-- select --</option>
                                        <option value=""></option> --}}

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span></label>
                                    <input id="docname" type="text" name="short_description" maxlength="255" required>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Description">Follow-up Task Description</label>
                                    <textarea name="followup_Desc"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Date Due <span class="text-danger"></span></label>
                                    <div><small class="text-primary">Please mention expected date of completion</small></div>

                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div>



                                <div class="group-input">
                                    <label for="Attached File">Attached File</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attachment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="HOD_Attachments" name="file_attachment[]"
                                                oninput="addMultipleFiles(this, 'file_attachment')" multiple>

                                            {{-- <input type="file" id="myfile" name="file_attachment" oninput="" multiple> --}}
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
                                    <textarea name="execution_details"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Scheduled Start Date">Date of Completion</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="date_of_completion" readonly placeholder="DD-MM-YYYY" />
                                        <input type="date" id="start_date_checkdate" name="date_of_completion" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'date_of_completion');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="Attached File">Execution Attachment</label>
                                <div>
                                    <small class="text-primary">
                                        Please Attach all relevant or supporting documents
                                    </small>
                                </div>
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="execution_attachment">


                                    </div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="HOD_Attachments" name="execution_attachment[]"
                                            oninput="addMultipleFiles(this, 'execution_attachment')" multiple>

                                        {{-- <input type="file" id="myfile" name="file_attachment" oninput="" multiple> --}}
                                    </div>
                                </div>
                            </div>



                            {{-- <div class="group-input">
                                <label for="file_attchment_if_any">Execution Attachment</label>
                                <div><small class="text-primary">Please Attach all relevant or supporting
                                        documents</small></div>
                                <div class="file-attachment-field">
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
                                    <textarea name="delay_justification"></textarea>
                                </div>
                            </div>


<!--

                        <div class="group-input">
                            <label for="comments">Comments</label>
                            <textarea name="comments"></textarea>
                        </div>
                    </div> -->
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
                                    <textarea name="varification_comments"></textarea>
                                </div>
                            </div>



                                <div class="group-input">
                                    <label for="Attached File">Verification Attachment</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="verification_attachment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="HOD_Attachments" name="verification_attachment[]"
                                                oninput="addMultipleFiles(this, 'verification_attachment')" multiple>

                                            {{-- <input type="file" id="myfile" name="file_attachment" oninput="" multiple> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <div class="sub-head">Cancellation</div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Cancellation Remarks">Cancellation Remarks</label>
                                    <textarea name="cancellation_remarks"></textarea>
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
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed By">Follow-up Task Submit By</label>
                                        {{-- <div class="static">Person datafield</div>/ --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed On">Follow-up Task Submit On</label>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="sub-head">Compliance Execution</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed By">Execution Complete By</label>
                                        {{-- <div class="static">Person datafield</div>/ --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed On">Execution Complete On</label>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="sub-head">Compliance Verification</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed By">Verification Completed By</label>
                                        {{-- <div class="static">Person datafield</div>/ --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed On">Verification Completed On</label>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed By">Cancellation Done By</label>
                                        {{-- <div class="static">Person datafield</div>/ --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed On">Cancellation Done On</label>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>
                            </div>







                            <!-- {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="actual_start_date">Actual Start Date</label>
                                        <input type="date" name="actual_start_date">
                                    </div>
                                </div> --}}
                <div class="col-lg-6 new-date-data-field">
                    <div class="group-input input-date">
                        <label for="actual_start_date">Actual Start Date</label>
                        <div class="calenderauditee">
                            <input type="text" id="actual_start_date" readonly placeholder="DD-MMM-YYYY" />
                            <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="actual_start_date_checkdate" name="actual_start_date" class="hide-input" oninput="handleDateInput(this, 'actual_start_date');checkDate('actual_start_date_checkdate','actual_end_date_checkdate')" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6  new-date-data-field">
                    <div class="group-input input-date">
                        <label for="actual_end_date">Actual End Date</lable>
                            <div class="calenderauditee">
                                <input type="text" id="actual_end_date" placeholder="DD-MMM-YYYY" />
                                <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="actual_end_date_checkdate" name="actual_end_date" class="hide-input" oninput="handleDateInput(this, 'actual_end_date');checkDate('actual_start_date_checkdate','actual_end_date_checkdate')" />
                            </div>


                    </div>
                </div>
                <div class="col-12">
                    <div class="group-input">
                        <label for="action_taken">Action Taken</label>
                        <textarea name="action_taken"></textarea>
                    </div>
                </div>
                <div class="col-12">
                    <div class="sub-head">Response Summary</div>
                </div>
                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="date_response_due">Date Response Due</label>
                                        <input type="date" name="date_response_due1">
                                    </div>
                                </div> --}}
                {{-- <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date ">
                                        <label for="date_response_due">Date Response Due</label>
                                        <div class="calenderauditee">
                                            <input type="text" name="date_response_due1" id="date_response_due1" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                oninput="handleDateInput(this, 'date_response_due1')" />
            </div>
        </div>
    </div> --}}
    {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="response_date">Date of Response</label>
                                        <input type="date" name="response_date">
                                    </div>
                                </div> --}}
    {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="attach_files">Attached Files</label>
                                        <input type="file" name="attach_files2">
                                    </div>
                                </div> --}}
    <div class="col-12">
        <div class="group-input">
            <label for="attach_files">Attached Files</label>
            <div><small class="text-primary">Please Attach all relevant or supporting
                    documents</small></div>
            <div class="file-attachment-field">
                <div class="file-attachment-list" id="attach_files2"></div>
                <div class="add-btn">
                    <div>Add</div>
                    <input type="file" id="myfile" name="attach_files2[]" oninput="addMultipleFiles(this, 'attach_files2')" multiple>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="group-input">
            <label for="related_url">Related URL</label>
            <input type="url" name="related_url">
        </div>
    </div>
    <div class="col-12">
        <div class="group-input">
            <label for="response_summary">Response Summary</label>
            <textarea name="response_summary"></textarea>
        </div>
    </div> -->
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
