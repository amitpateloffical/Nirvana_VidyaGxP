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



<!-- <div class="form-field-head">
    {{-- <div class="pr-id">
            New Child
        </div> --}}
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        / CTA Subject
    </div>


</div> -->

<!---<script>
    function addMultipleFiles(input, fieldName) {
    const fileList = document.getElementById('File_Attachment');
    fileList.innerHTML = ''; // Clear previous file list

    for (const file of input.files) {
    const fileItem = document.createElement('div');
    fileItem.textContent = file.name;
    fileList.appendChild(fileItem);
    }
    }
    </script>-->




<div class="form-field-head">

    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        {{ Helpers::getDivisionName(session()->get('division')) }} / Subject
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

        <form action="{{ route('subjectStore') }}" method="POST" enctype="multipart/form-data">
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
                                    <label for="Record Number"><b>Record Number</b></label>
                                    <input disabled type="text" name="record_number"
                                        value="{{ Helpers::getDivisionName(session()->get('division')) }}/SUB/{{ date('Y') }}/{{ $record_number }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Site Location"><b>Site/Location Code</b></label>
                                    <input disabled type="text" name="division_code"
                                        value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"><b>Initiator</b></label>
                                    <input disabled type="text" name="initiator_name" value="{{ Auth::user()->name }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date of Initiation"><b>Date Of Initiation</b></label>
                                    <input disabled type="text" value="{{ date('d-M-Y') }}" name="initiation_date">
                                    <input type="hidden" value="{{ date('d-m-Y') }}" name="initiation_date">

                                </div>
                            </div>


                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span
                                            class="text-danger">*</span></label>
                                    <p>255 characters remaining</p>
                                    <input id="docname" type="text" name="short_description" maxlength="255" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="phase_of_study">
                                        (Parent) Phase of Study
                                    </label>
                                    <select id="select-state" name="phase_of_study">
                                        <option value="">Select a value</option>
                                        <option value="one">one</option>
                                        <option value="two">two</option>
                                        <option value="three">three</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reference Recores"> (Parent) Study Num</label>
                                    <input type="text" name="study_Num">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="assign_to">
                                        Assigned To
                                    </label>
                                    <select id="select-state" name="assign_to">
                                        <option value="">Select a value</option>
                                        @foreach ($user as $users)
                                        <option value="{{ $users->name }}">{{ $users->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Date Due <span class="text-danger"></span></label>
                                    <div><small class="text-primary">Please mention expected date of
                                            completion</small>
                                    </div>

                                    <div class="calenderauditee">
                                        <input type="hidden" id="due_date" value="{{$due_date}}" name="due_date" />
                                        <input disabled type="text" name="due_date"
                                            value="{{Helpers::getdateFormat($due_date)}}" />
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="closure attachment">Attached Files </label>
                                    <div>
                                        <small class="text-primary"></small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attach"></div>
                                        <div class=" add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="file_attach[]"
                                                oninput=" addMultipleFiles(this, 'file_attach' )" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class=" col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Related URLs</label>
                                    <select name="related_urls">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="P-1">P-1</option>
                                        <option value="P-2">P-2</option>
                                        <option value="P-3">P-3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Description</label>
                                    <textarea class="summernote" name="Description_Batch" id="summernote-16"></textarea>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Actual Cost </label>
                                    <input type="text" id="actual_cost" name="actual_cost">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Currency</label>
                                    <select name="currency">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="Dollar">Dollar</option>
                                        <option value="Rupees">Rupees</option>
                                    </select>
                                </div>
                            </div>



                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Comments</label>
                                    <textarea class="summernote" name="Comments_Batch" id="summernote-16"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="closure attachment">Source Documents </label>
                                    <div><small class="text-primary">
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="document_attach"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="document_attach[]"
                                                oninput=" addMultipleFiles(this, 'document_attach' )" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class=" sub-head">Parent Information
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Subject Name</label>
                                    <input type="text" name="subject_name" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Subject Date</label>
                                    <input type="date" name="subject_date" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Gender</label>
                                    <select name="gender">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="others">Others</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Race</label>
                                    <select name="race">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="R-1">R-1</option>
                                        <option value="R-2">R-2</option>
                                        <option value="R-3">R-3</option>
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

                <!-- Tab-2 -->
                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">Submission Information</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Screened Successfully </label>
                                    <select name="screened_successfully">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="AT-1">AT-1</option>
                                        <option value="AT-2">AT-2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Reason For Discontinuation </label>
                                    <select name="discontinuation">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="AT-1">AT-1</option>
                                        <option value="AT-2">AT-2</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments">Comments</label>
                                    <textarea class="summernote" name="Disposition_Batch" id="summernote-16"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Treatment Consent Version</label>
                                    <input type="text" name="treatment_consent" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Screening Consent Version</label>
                                    <input type="text" name="screening_consent" />
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Type">Exception Number </label>
                                    <input type="text" name="exception_no" />
                                </div>
                            </div>

                            <div class=" col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Signed Consent Form </label>
                                    <select name="signed_consent">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Time Point </label>
                                    <select name="time_point">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="T-1">T-1</option>
                                        <option value="T-2">T-2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments">Family History</label>
                                    <textarea class="summernote" name="family_history" id="summernote-16"></textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments">Baseline
                                        Assessment</label>
                                    <textarea class="summernote" name="Baseline_assessment"
                                        id="summernote-16"></textarea>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Representive </label>
                                    <input type="text" name="representive" />
                                </div>
                            </div>


                            <div class="sub-head">Location</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Zone</label>
                                    <select name="zone">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="P-1">P-1</option>
                                        <option value="P-2">P-2</option>
                                        <option value="P-3">P-3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Country</label>
                                    <select name="country" class="form-select country"
                                        aria-label="Default select example" onchange="loadStates()">
                                        <option value="">Select Country</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">State/District</label>
                                    <select name="district" class="form-select state"
                                        aria-label="Default select example" onchange="loadCities()">
                                        <option value="">Select State/District</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">City</label>
                                    <select name="city" class="form-select city" aria-label="Default select example">
                                        <option value="">Select City</option>
                                    </select>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Site Name</label>
                                    <select name="site">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="Indore">Indore</option>
                                        <option value="Bhopal">Bhopal</option>
                                        <option value="Dewas">Dewas</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Building</label>
                                    <select name="building">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Floor</label>
                                    <select name="floor">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Room</label>
                                    <select name="room">
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


                            <div class="sub-head">Important Dates</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Consent Form Signed On </label>
                                    <input type="date" name="consent_form" />
                                </div>
                            </div>

                            <div class=" col-lg-6">
                                <div class="group-input">
                                    <label for="Type"> Date Granted</label>
                                    <input type="date" name="date_granted" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type"> System Start Date</label>
                                    <input type="date" name="system_start" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Consent Form Signed Date </label>
                                    <input type="date" name="consent_form_date" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type"> Date Of First Treatment</label>
                                    <input type="date" name="first_treatment" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Date Requested</label>
                                    <input type="date" name="date_requested" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Date Screened </label>
                                    <input type="date" name="date_screened" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type"> Date Signed Treatment Consent</label>
                                    <input type="date" name="date_signed_treatment" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Effective From Date </label>
                                    <input type="date" name="date_effective_from" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type"> Effective To Date</label>
                                    <input type="date" name="date_effective_to" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Last Active Treatment Date </label>
                                    <input type="date" name="last_active" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type"> Last Follow-up Date</label>
                                    <input type="date" name="last_followup" />
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

                <!-- <div id="CCForm4" class="inner-block cctabcontent">
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
                            </div> -->
                <!-- </div> -->
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

{{-- Country Statecity API --}}
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
{{-- Country Statecity API End --}}
@endsection