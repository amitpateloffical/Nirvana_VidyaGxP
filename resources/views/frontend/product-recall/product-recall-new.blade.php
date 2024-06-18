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
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        / Product Recall
    </div>
</div>


<div id="change-control-fields">
    <div class="container-fluid">

        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Recall</button>
            <button class="cctablinks " onclick="openCity(event, 'CCForm2')">Notification Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Signatures</button>
        </div>

        <form action="{{ route('store-product-recall') }}" method="POST" enctype="multipart/form-data">
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
                                    <label for="Originator"><b>Record Number</b></label>
                                    <input disabled type="text" name="record_number" value="{{$record_numbers}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Originator"><b>Initiator</b></label>
                                    <input disabled type="text" name="initiator_id" id="initiator_id" value="{{ Auth::user()->name }}">
                                </div>
                            </div>

                            @php
                                // Calculate the due date (30 days from the initiation date)
                                $initiationDate = date('Y-m-d'); // Current date as initiation date
                                $dueDate = date('Y-m-d', strtotime($initiationDate . '+30 days')); // Due date
                            @endphp

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Date Of Initiation</b></label>
                                    <input readonly type="text" value="{{ date('d-M-Y') }}"
                                            style="background-color: light-dark(rgba(239, 239, 239, 0.3), rgba(59, 59, 59, 0.3))">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" name="initiation_date_hidden">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Product<span class="text-danger">*</span></label>
                                    <input id="docname" type="text" name="product_name" id="product_name" required placeholder="Enter Product Detail">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span></label>
                                    <input id="docname" type="text" name="short_description" id="short_description" maxlength="255" required placeholder="Enter Short Description">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search"> Assigned To <span class="text-danger"></span></label>
                                    <select id="select-state" name="assign_to" id="assign_to">
                                        <option value="">Select a value</option>
                                        @if(!empty($users))
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
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

                                <script>
                                    var dueDate = "{{ $dueDate }}";
                                    var date = new Date(dueDate);

                                    // Array of month names
                                    var monthNames = [
                                        "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                                        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                                    ];

                                    // Extracting day, month, and year from the date
                                    var day = date.getDate().toString().padStart(2, '0'); // Ensuring two digits
                                    var monthIndex = date.getMonth();
                                    var year = date.getFullYear();

                                    // Formatting the date in "dd-MMM-yyyy" format
                                    var dueDateFormatted = `${day}-${monthNames[monthIndex]}-${year}`;

                                    // Set the formatted due date value to the input field
                                    document.getElementById('due_date').value = dueDateFormatted;
                                </script>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="recalled_from">Recalled From</label>
                                  <input name="recalled_from" type="text" id="recalled_from" placeholder="Recalled From" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="priority_level">Priority Level</label>
                                    <select id="priority_level" name="priority_level">
                                        <option value="">Select Your Selection Here</option>
                                        <option value="Low">Low</option>
                                        <option value="Medium">Medium</option>
                                        <option value="High">High</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="recalled_by">Recalled By</label>
                                    <select name="recalled_by" id="recalled_by">
                                        <option value="">-- Select --</option>
                                        @if(!empty($users))
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
        
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="contact_person">Contact Person</label>
                                    <select name="contact_person" id="contact_person">
                                        <option value="">-- Select --</option>
                                        @if(!empty($users))
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="related_product">Other Related Products</label>
                                    <select name="related_product" id="related_product">
                                        <option value="">-- Select --</option>
                                        <option value="1">P-1</option>
                                        <option value="2">P-2</option>
                                        <option value="3">P-3</option>
                                        <option value="4">P-4</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Reason For Recall</label>
                                    <textarea class="summernote" name="recall_reason" id="summernote-16"></textarea>
                                </div>
                            </div>


                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Audit Schedule End Date">Scheduled Start Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="schedule_start_date" readonly  placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="schedule_start_date"
                                        max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'schedule_start_date')" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 new-date-data-field mt-4">
                                <div class="group-input input-date">
                                    <label for="schedule_end_date">Scheduled End Date <span class="text-danger"></span></label>
                                    <div class="calenderauditee">
                                        <input type="text" id="schedule_end_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="schedule_end_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'schedule_end_date')" />
                                    </div>
                                </div>
                            </div>  

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="department_code">Departments</label>
                                    <select multiple id="department_code" name="department_code[]" >
                                        <option value="">--Select---</option>
                                        <option value="Department-1">Department 1</option>
                                        <option value="Department-2">Department 2</option>
                                        <option value="Department-3">Department 3</option>
                                        <option value="Department-4">Department 4</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="team_members">Team Members</label>
                                    <select multiple id="team_members" name="team_members[]">
                                        <option value="">--Select---</option>
                                        @if(!empty($users))
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="bussiness_area">Business Area</label>
                                    <select name="bussiness_area" id="bussiness_area">
                                        <option value="">-- Select --</option>
                                        <option value="Area-1">Area-1</option>
                                        <option value="Area-2">Area-2</option>
                                        <option value="Area-3">Area-3</option>
                                        <option value="Area-4">Area-4</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="estimate_man_hours">Estimated Man-Hours</label>
                                    <select name="estimate_man_hours" id="estimate_man_hours">
                                        <option value="">-- Select --</option>
                                        <option value="1">Hour 1</option>
                                        <option value="2">Hour 2</option>
                                        <option value="3">Hour 3</option>
                                        <option value="4">Hour 4</option>
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
                                        <div class="file-attachment-list" id="Attachment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="Attachment[]" oninput="addMultipleFiles(this, 'Attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="related_urls">Related URLs</label>
                                    <input type="text" name="related_urls"  id="related_urls" placeholder="Enter URL Here">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Reference Recores"> Related Records</label>
                                    <select multiple id="reference_record" name="reference_record[]" id="">
                                        <option value="">--Select---</option>
                                        <option value="1">Record 1</option>
                                        <option value="2">Record 2</option>
                                        <option value="3">Record 3</option>
                                        <option value="4">Record 4</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Comments"> Comments</label>
                                    <textarea class="summernote" name="comments" id="summernote-16"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit </a> </button>
                        </div>
                    </div>
                </div>

                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                           
                        <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="franchise_store_manager">Franchise Store Manager</label>
                                    <select name="franchise_store_manager" id="franchise_store_manager">
                                        <option value="">-- Select --</option>
                                        @if(!empty($users))
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Warehouse Manager">Warehouse Manager</label>
                                    <select name="warehouse_manager" id="warehouse_manager">
                                        <option value="">-- Select --</option>
                                        @if(!empty($users))
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="ena_store_manager">ENA Store Manager</label>
                                    <select name="ena_store_manager"  id="ena_store_manager">
                                        <option value="">-- Select --</option>
                                        @if(!empty($users))
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="ab_store_manager">AB Store Manager</label>
                                    <select name="ab_store_manager" id="ab_store_manager">
                                        <option value="">-- Select --</option>
                                        @if(!empty($users))
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>


                            <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>                            
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit </a> </button>
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


                            <div class="button-block mt-4">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a></button>
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
        const index = Array.from(cctablinks).findIndex(button => button === evt.currentTarget);
        currentStep = index;
    }

    const saveButtons = document.querySelectorAll(".saveButton");
    const nextButtons = document.querySelectorAll(".nextButton");
    const form = document.getElementById("step-form");
    const stepButtons = document.querySelectorAll(".cctablinks");
    const steps = document.querySelectorAll(".cctabcontent");
    let currentStep = 0;

    function nextStep() {
            /* Check if there is a next step */
        if (currentStep < steps.length - 1) {

            /* Hide current step  */
            steps[currentStep].style.display = "none";

            /* Show next step */
            steps[currentStep + 1].style.display = "block";

            /* Add active class to next button */
            stepButtons[currentStep + 1].classList.add("active");

            /* Remove active class from current button */
            stepButtons[currentStep].classList.remove("active");

            /* Update current step */
            currentStep++;
        }
    }

    function previousStep() {
            /* Check if there is a previous step */
        if (currentStep > 0) {

            /* Hide current step */
            steps[currentStep].style.display = "none";

            /* Show previous step */
            steps[currentStep - 1].style.display = "block";

            /* Add active class to previous button */
            stepButtons[currentStep - 1].classList.add("active");

            /* Remove active class from current button */
            stepButtons[currentStep].classList.remove("active");

            /* Update current step */
            currentStep--;
        }
    }
</script>

<script>
    VirtualSelect.init({
        ele: '#reference_record, #notify_to, #department_code, #team_members'
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