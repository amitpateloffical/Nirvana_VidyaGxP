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
            / EHS_Recurring Commitment
        </div>
    </div>

    <div id="change-control-fields">
        <div class="container-fluid">

            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Parent Information</button> -->
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Commitment Information</button>
                <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Action Approval</button> -->
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Signature</button>
            </div>

            <form action="{{ route('store-recurring-commitment') }}" method="POST" enctype="multipart/form-data">
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
                                        <label for="originator">Record Number</label>
                                        <input type="hidden" name="record" id="record" value="{{ $record_number }}" >
                                        <input disabled type="text" value="{{ $record_numbers }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="initiator_id">Initiator</label>
                                        <input type="text" value="{{ Auth::user()->name }}" name="initiator_id" id="initiator_id">
                                    </div>
                                </div>

                                @php
                                    // Calculate the due date (30 days from the initiation date)
                                    $initiationDate = date('Y-m-d'); // Current date as initiation date
                                    $dueDate = date('Y-m-d', strtotime($initiationDate . '+30 days')); // Due date
                                @endphp

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Opened">Date of Initiation</label>
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="initiation_date_hidden">
                                        <input readonly type="text" value="{{ date('d-M-Y') }}" name="initiation_date" id="initiation_date"
                                                style="background-color: light-dark(rgba(239, 239, 239, 0.3), rgba(59, 59, 59, 0.3))">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Assigned To <span class="text-danger"></span>
                                        </label>
                                        <select name="assign_to" id="assign_to">
                                            <option value="">Select a value</option>
                                            @if($users)                                            
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>



                                    </div>
                                </div>

                                <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date">Due Date <span class="text-danger"></span></label>
                                        <div class="calenderauditee">
                                            <input type="text" id="due_date" readonly placeholder="DD-MM-YYYY" />
                                            <input type="date" name="due_date"
                                                min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'due_date')" />
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    // Format the due date to DD-MM-YYYY
                                    // Your input date
                                    var dueDate = "{{ $dueDate }}"; // Replace {{ $dueDate }} with your actual date variable

                                    // Create a Date object
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

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars">255</span>
                                        characters remaining
                                        <input id="short_description" type="text" name="short_description" maxlength="255" placeholder="Enter Description" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Zone <span class="text-danger"></span>
                                        </label>
                                        <select id="zone" name="zone">
                                            <option value="">Select a value</option>
                                            <option value="Asia">Asia</option>
                                            <option value="Europe">Europe</option>
                                            <option value="Africa">Africa</option>
                                            <option value="Central America">Central America</option>
                                            <option value="South America">South America</option>
                                            <option value="Oceania">Oceania</option>
                                            <option value="North America">North America</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Country <span class="text-danger"></span>
                                        </label>
                                        <select name="country" class="form-select country" aria-label="Default select example" onchange="loadStates()">
                                            <option selected>Select Country</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            State/District <span class="text-danger"></span>
                                        </label>
                                        <select name="state" class="form-select state" aria-label="Default select example" onchange="loadCities()">
                                            <option selected>Select State/District</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            City <span class="text-danger"></span>
                                        </label>
                                        <select name="city" class="form-select city" aria-label="Default select example">
                                            <option selected>Select City</option>
                                        </select>
                                    </div>
                                </div>

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
                                

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            EPA Identification Number <span class="text-danger"></span>
                                        </label>
                                        <input id="epa_number" type="text" name="epa_number" placeholder="Enter EPA Identification">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Impact<span class="text-danger"></span>
                                        </label>
                                        <input id="impact" type="text" name="impact" placeholder="Enter Impact">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Responsible Department">Responsible Department</label>
                                    <select name="responsible_department" id="responsible_department">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="Quality Assurance-CQA">Quality Assurance-CQA</option>
                                        <option value="Research and Development">Research and Development</option>
                                        <option value="Regulatory Science">Regulatory Science</option>
                                        <option value="Supply Chain Management">Supply Chain Management</option>
                                        <option value="Finance">Finance</option>
                                        <option value="QA-Digital">QA-Digital</option>
                                        <option value="Central Engineering">Central Engineering</option>
                                        <option value="Projects">Projects</option>
                                        <option value="Marketing">Marketing</option>
                                        <option value="QCAT">QCAT</option>
                                        <option value="GMP Pilot Plant">GMP Pilot Plant</option>
                                        <option value="Manufacturing Sciences and Technology">Manufacturing Sciences and Technology</option>
                                        <option value="Environment, Health and Safety">Environment, Health and Safety</option>
                                        <option value="Business Relationship Management">Business Relationship Management</option>
                                        <option value="National Regulatory Affairs">National Regulatory Affairs</option>
                                        <option value="HR">HR</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Information Technology">Information Technology</option>
                                        <option value="Program Management QA Analytical">Program Management QA Analytical</option>
                                        <option value="QA Analytical">QA Analytical</option>
                                        <option value="QA Packaging Development">QA Packaging Development</option>
                                    </select>
                                </div>
                            </div>

                            <div class="sub-head">
                                Additional Information
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="file_attach">Related URL</label>
                                        <input type="text" id="related_url" name="related_url" placeholder="Enter URL">

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="file_attach">Permit Certificate</label>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="permit_certificate"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="permit_certificate[]"
                                                    oninput="addMultipleFiles(this, 'permit_certificate')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="file_attach">File Attachments</label>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="file_attachments"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="file_attachments[]"
                                                    oninput="addMultipleFiles(this, 'file_attachments')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a></button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <div id="CCForm3" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="row">
                    <div class="sub-head col-12">Commitment Details</div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="search">
                                Type Of Commitment <span class="text-danger"></span>
                            </label>
                            <select id="commitment_type" name="commitment_type">
                                <option value="">Select a value</option>
                                <option value="Type 1">Type 1</option>
                                <option value="Type 2">Type 2</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="search">
                                Commitment Frequency <span class="text-danger"></span>
                            </label>
                            <select id="commitment_frequency" name="commitment_frequency">
                                <option value="">Select a value</option>
                                <option value="Frequency 1">Frequency 1</option>
                                <option value="Frequency 2">Frequency 2</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="start_date">Commitment Start Date</label>
                            <div class="calenderauditee">
                                <input type="text" id="commitment_start_date" readonly  placeholder="DD-MMM-YYYY" />
                                <input type="date" name="commitment_start_date"
                                    max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'commitment_start_date')" />
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6  new-date-data-field">
                        <div class="group-input input-date">
                            <label for="end_date">Commitment End Date</lable>
                            <div class="calenderauditee">
                                <input type="text" id="commitment_end_date" readonly  placeholder="DD-MMM-YYYY" />
                                <input type="date" name="commitment_end_date"
                                    max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'commitment_end_date')" />
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6  new-date-data-field">
                        <div class="group-input input-date">
                            <label for="end_date">Next Commitment Date</lable>
                            <div class="calenderauditee">
                                <input type="text" id="next_commitment_date" readonly  placeholder="DD-MMM-YYYY" />
                                <input type="date" name="next_commitment_date"
                                    max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'next_commitment_date')" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="search">
                                Others Involved <span class="text-danger"></span>
                            </label>
                            <input id="other_involved" type="text" name="other_involved" placeholder="Enter Value">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="search">
                                Site <span class="text-danger"></span>
                            </label>
                            <input id="site" type="text" name="site" placeholder="Enter Site Name">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="search">
                                Site Contact <span class="text-danger"></span>
                            </label>
                            <input id="site_contact" type="text" name="site_contact" placeholder="Enter Site Contact">
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="group-input">
                            <label for="Comments">Description</label>
                            <textarea name="description" id="description" placeholder="Enter Description"></textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="group-input">
                            <label for="Comments">Comments</label>
                            <textarea name="comments" id="comments" placeholder="Enter Comment"></textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="group-input">
                            <label for="Comments">Commitment Action</label>
                            <textarea name="commitment_action" id="commitment_action" placeholder="Enter Commitment Action"></textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="group-input">
                            <label for="Comments">Commitment Notes</label>
                            <textarea name="commitment_notes" id="commitment_notes" placeholder="Enter Commitment Notes"></textarea>
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

        <div id="CCForm5" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="sub-head">
                    Electronic Signatures
                </div>
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
                            <label for="completed by">Commitment Approved By</label>
                            <div class="static"></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="completed on">Commitment Approved On</label>
                            <div class="Date"></div>
                        </div>
                    </div>

                </div>
                <div class="button-block">
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
        var maxLength = 255;
        $('#docname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);
        });
    </script>
@endsection
