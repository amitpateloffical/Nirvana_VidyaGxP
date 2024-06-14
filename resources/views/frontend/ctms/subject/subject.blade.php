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

<div class="form-field-head">
    {{-- <div class="pr-id">
            New Child
        </div> --}}
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        / CTA Subject
    </div>
</div>



{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">


        


        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Subject</button>
            <button class="cctablinks " onclick="openCity(event, 'CCForm2')">Additional Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Important Dates</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Signatures</button>
        </div>

        <form action="{{ route('subjectstore') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div id="step-form">
                @if (!empty($parent_id))
                <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                @endif
                <!-- Tab-1 -->

                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="record_number"><b>Record Number</b></label>
                                    <input type="text" name="record_number" id="record_number"> 
                                    {{-- value="{{ Helpers::getDivisionName(session()->get('division')) }}/LI/{{ date('Y') }}/{{ $record }}" disabled> --}}
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="division_code"><b>Division Code</b></label>
                                    <input type="text" name="division_code" id="division_code" value="{{ Helpers::getDivisionName(session()->get('division')) }}" disabled>
                                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="initiator"><b>Initiator</b></label>
                                    <input type="text" name="initiator" id="initiator" value="{{ Auth::user()->name }}" disabled>
                                </div>
                            </div>
                
                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="initiation_date"><b>Date Of Initiation</b></label>
                                    <input type="text" value="{{ date('d-M-Y') }}" disabled>
                                    <input type="hidden" name="initiation_date" value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="short_description"><b>Short Description</b> <span class="text-danger">*</span></label>
                                    <p>255 characters remaining</p>
                                    <input id="short_description" type="text" name="short_description" maxlength="255" required>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="phase_of_study">(Parent) Phase Of Study</label>
                                    <select multiple id="phase_of_study" name="phase_of_study">
                                        <option value="">--Select---</option>
                                        <option value="Pankaj">Pankaj</option>
                                        <option value="Gaurav">Gaurav</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="study_num">(Parent) Study Num</label>
                                    <input type="text" name="study_num" id="study_num">
                                </div>
                            </div>
                
                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="assign_to">Assigned To <span class="text-danger"></span></label>
                                    <select id="assign_to" name="assign_to">
                                        <option value="">Select a value</option>
                                        <option value="Pankaj Jat">Pankaj Jat</option>
                                        <option value="Gaurav">Gaurav</option>
                                        <option value="Manish">Manish</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due_date">Date Due <span class="text-danger"></span></label>
                                    <div><small class="text-primary">Please mention expected date of completion</small></div>
                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY">
                                        <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'due_date')">
                                    </div>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="attached_files">Attached Files</label>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="Attachment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="attached_files" name="Attachment[]" multiple oninput="addMultipleFiles(this, 'Attachment')">
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="related_urls">Related URLs</label>
                                    <select name="Related_URLs" id="related_urls">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">P-1</option>
                                        <option value="2">P-2</option>
                                        <option value="3">P-3</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="description">Description</label>
                                    <textarea class="summernote" name="description" id="description"></textarea>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="actual_cost">Actual Cost</label>
                                    <input type="text" name="actual_cost" id="actual_cost">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="currency">Currency</label>
                                    <select name="Currency" id="currency">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">Dollar</option>
                                        <option value="2">Rupees</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="comments">Comments</label>
                                    <textarea class="summernote" name="comments" id="comments"></textarea>
                                </div>
                            </div>
                
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="source_documents">Source Documents</label>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="Source_Documents"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="source_documents" name="Source_Documents[]" multiple oninput="addMultipleFiles(this, 'Source_Documents')">
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                            <div class="sub-head">Parent Information</div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="subject_name">Subject Name</label>
                                    <input type="text" name="subject_name" id="subject_name">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="subject_dob">Date of Birth</label>
                                    <input type="date" name="subject_dob" id="subject_dob">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="gender">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                        <option value="3">Others</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="race">Race</label>
                                    <select name="race" id="race">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">R-1</option>
                                        <option value="2">R-2</option>
                                        <option value="3">R-3</option>
                                    </select>
                                </div>
                            </div>
                
                        </div>
                
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button">
                                <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a>
                            </button>
                        </div>
                    </div>
                </div>
                

                <!-- Tab-2 -->
                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">Submission Information</div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="screened_successfully">Screened Successfully?</label>
                                    <select name="screened_successfully" id="screened_successfully">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">AT-1</option>
                                        <option value="2">AT-2</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="reason_discontinuation">Reason For Discontinuation</label>
                                    <select name="reason_discontinuation" id="reason_discontinuation">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">AT-1</option>
                                        <option value="2">AT-2</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="comments">Comments</label>
                                    <textarea class="summernote" name="comments2" id="comments"></textarea>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="treatment_consent_version">Treatment Consent Version</label>
                                    <input type="text" name="treatment_consent_version" id="treatment_consent_version">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="screening_consent_version">Screening Consent Version</label>
                                    <input type="text" name="screening_consent_version" id="screening_consent_version">
                                </div>
                            </div>
                
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="exception_number">Exception Number</label>
                                    <input type="text" name="exception_number" id="exception_number">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="signed_consent_form">Signed Consent Form</label>
                                    <select name="screening_consent_version" id="signed_consent_form">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">01</option>
                                        <option value="2">02</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="time_point">Time Point</label>
                                    <select name="time_point" id="time_point">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">T-1</option>
                                        <option value="2">T-2</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="family_history">Family History</label>
                                    <textarea class="summernote" name="family_history" id="family_history"></textarea>
                                </div>
                            </div>
                
                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="baseline_assessment">Baseline Assessment</label>
                                    <textarea class="summernote" name="baseline_assessment" id="baseline_assessment"></textarea>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="representative">Representative</label>
                                    <input type="text" name="representative" id="representative">
                                </div>
                            </div>
                
                            <div class="sub-head">Location</div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="zone">Zone</label>
                                    <select name="zone" id="zone">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">P-1</option>
                                        <option value="2">P-2</option>
                                        <option value="3">P-3</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="country">Country</label>
                                    <select name="country" id="country">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">India</option>
                                        <option value="2">UK</option>
                                        <option value="3">USA</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="city">City</label>
                                    <select name="city" id="city">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">Indore</option>
                                        <option value="2">Bhopal</option>
                                        <option value="3">Dewas</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="state_district">State/District</label>
                                    <select name="state_district" id="state_district">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">Dewas</option>
                                        <option value="2">Harda</option>
                                        <option value="3">Sehore</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="site_name">Site Name</label>
                                    <select name="site_name" id="site_name">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">Indore</option>
                                        <option value="2">Bhopal</option>
                                        <option value="3">Dewas</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="building">Building</label>
                                    <select name="building" id="building">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="floor">Floor</label>
                                    <select name="floor" id="floor">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="room">Room</label>
                                    <select name="room" id="room">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button">
                                    <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tab-3 -->

                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">Important Dates</div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="consent_form_signed_on">Consent Form Signed On</label>
                                    <input type="date" name="consent_form_signed_on" id="consent_form_signed_on">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="date_granted">Date Granted</label>
                                    <input type="date" name="date_granted" id="date_granted">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="system_start_date">System Start Date</label>
                                    <input type="date" name="system_start_date" id="system_start_date">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="consent_form_signed_date">Consent Form Signed Date</label>
                                    <input type="date" name="consent_form_signed_date" id="consent_form_signed_date">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="date_first_treatment">Date Of First Treatment</label>
                                    <input type="date" name="date_first_treatment" id="date_first_treatment">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="date_requested">Date Requested</label>
                                    <input type="date" name="date_requested" id="date_requested">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="date_screened">Date Screened</label>
                                    <input type="date" name="date_screened" id="date_screened">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="date_signed_treatment_consent">Date Signed Treatment Consent</label>
                                    <input type="date" name="date_signed_treatment_consent" id="date_signed_treatment_consent">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="effective_from_date">Effective From Date</label>
                                    <input type="date" name="effective_from_date" id="effective_from_date">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="effective_to_date">Effective To Date</label>
                                    <input type="date" name="effective_to_date" id="effective_to_date">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="last_active_treatment_date">Last Active Treatment Date</label>
                                    <input type="date" name="last_active_treatment_date" id="last_active_treatment_date">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="last_followup_date">Last Follow-up Date</label>
                                    <input type="date" name="last_followup_date" id="last_followup_date">
                                </div>
                            </div>
                
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button">
                                    <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tab-4 -->

                <div id="CCForm4" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">Approval</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted by">Enrolled By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Enrolled on">Enrolled On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="sub-head">Close Out</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted by">Withdrawn By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Withdrawn on">Withdrawn On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted by">Closed By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Closed on">Closed On</label>
                                    <div class="Date"></div>
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