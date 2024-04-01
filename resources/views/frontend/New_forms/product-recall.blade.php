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
        / Product Recall
    </div>
</div>



{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Recall</button>
            <button class="cctablinks " onclick="openCity(event, 'CCForm2')">Notification Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Signatures</button>
        </div>

        <form action="{{ route('actionItem.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div id="step-form">
                @if (!empty($parent_id))
                <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                @endif

                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Originator"><b>Originator</b></label>
                                    <input disabled type="text" name="Originator" value="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Date Opened</b></label>
                                    <input  type="date" name="Date Opened" value="">
                                 
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Product<span class="text-danger">*</span></label>
                                  
                                    <input id="docname" type="text" name="short_description" maxlength="255" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span></label>
                                    <input id="docname" type="text" name="short_description" maxlength="255" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assign_to">
                                        <option value="">Select a value</option>
                                        <option value=""></option>

                                    </select>

                                </div>
                            </div>

                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Date Due <span class="text-danger"></span></label>
                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Recalled From</label>
                                  <input name="Recalled"/>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Priority Level</label>
                                    <select name="Type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Recalled By</label>
                                    <select name="Type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">Pankaj</option>
                                        <option value="2">Gaurav</option>
                                        <option value="3">Manish</option>
                                    </select>
                                </div>
                            </div>
        
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Contact Person</label>
                                    <select name="Type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">Pankaj</option>
                                        <option value="2">Gaurav</option>
                                        <option value="3">Manish</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Other Related Products</label>
                                    <select name="Type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">P-1</option>
                                        <option value="2">P-2</option>
                                        <option value="3">P-3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Reason For Recall</label>
                                    <textarea class="summernote" name="Disposition_Batch" id="summernote-16"></textarea>
                                </div>
                            </div>
                         


                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Scheduled Start Date <span class="text-danger"></span></label>
                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div>        

                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Scheduled End Date <span class="text-danger"></span></label>
                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div>       
                            
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reference Recores">Departments</label>
                                    <select multiple id="reference_record" name="PhaseIIQCReviewProposedBy[]" id="">
                                        <option value="">--Select---</option>
                                        <option value="">Pankaj</option>
                                        <option value="">Gourav</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reference Recores">Team Members</label>
                                    <select multiple id="reference_record" name="PhaseIIQCReviewProposedBy[]" id="">
                                        <option value="">--Select---</option>
                                        <option value="">Pankaj</option>
                                        <option value="">Gourav</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Business Area</label>
                                    <select name="Type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">P-1</option>
                                        <option value="2">P-2</option>
                                        <option value="3">P-3</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Estimated Man-Hours</label>
                                    <select name="Type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">P-1</option>
                                        <option value="2">P-2</option>
                                        <option value="3">P-3</option>
                                    </select>
                                </div>
                            </div>

                           
                           

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="closure attachment">Attached Files </label>
                                    <div><small class="text-primary">
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="File_Attachment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="Attachment[]" oninput="addMultipleFiles(this, 'Attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Related URLs</label>
                                    <select name="Type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">URL1</option>
                                        <option value="2">URL2</option>
                                        <option value="3">URL3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Reference Recores"> Related Records</label>
                                    <select multiple id="reference_record" name="PhaseIIQCReviewProposedBy[]" id="">
                                        <option value="">--Select---</option>
                                        <option value="">Pankaj</option>
                                        <option value="">Gourav</option>
                                    </select>
                                </div>
                            </div>


                          
                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Comments</label>
                                    <textarea class="summernote" name="Disposition_Batch" id="summernote-16"></textarea>
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
                           
                        <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Franchise Store Manager</label>
                                    <select name="Type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">Pankaj</option>
                                        <option value="2">Gaurav</option>
                                        <option value="3">Mayank</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Warehouse Manager</label>
                                    <select name="Type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">Pankaj</option>
                                        <option value="2">Gaurav</option>
                                        <option value="3">Mayank</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">ENA Store Manager</label>
                                    <select name="Type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">Pankaj</option>
                                        <option value="2">Gaurav</option>
                                        <option value="3">Mayank</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">AB Store Manager</label>
                                    <select name="Type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">Pankaj</option>
                                        <option value="2">Gaurav</option>
                                        <option value="3">Mayank</option>>
                                    </select>
                                </div>
                            </div>


                            <div class="button-block">
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                                    </a> </button>
                            </div>
                        </div>
                    </div>
                </div>
                

                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                           
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted by">Submitted By</label>
                                    <div class="static"></div>
                                </div>  
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted on">Submitted On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reviewed by">Approved By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Approved on">Approved On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>


                            <div class="button-block">
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="submit" class="saveButton">Save</button>
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