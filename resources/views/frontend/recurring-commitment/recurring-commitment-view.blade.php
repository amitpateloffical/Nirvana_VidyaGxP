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
                        <button class="button_theme1"> <a class="text-white" href="{{ url('DeviationAuditTrial', $data->id) }}"> Audit Trail </a> </button>

                        @if ($data->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Submit
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($data->stage == 2 && (in_array(4, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                                More Info Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                HOD Review Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($data->stage == 3 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                                More Info Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                QA Initial Review Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cft-not-reqired">
                                CFT Review Not Required
                            </button>
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button> --}}
                        @elseif(
                            $data->stage == 4 &&
                                (in_array(5, $userRoleIds) || in_array(18, $userRoleIds) || in_array(Auth::user()->id, $valuesArray)))
                            @if (!$cftCompleteUser)
                                <button class="button_theme1" data-bs-toggle="modal"
                                    data-bs-target="#more-info-required-modal">
                                    More Info Required
                                </button>
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                    CFT Review Complete
                                </button>
                            @endif
                        @elseif($data->stage == 5 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#sendToInitiator">
                                Send to Initiator
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#hodsend">
                                Send to HOD
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#qasend">
                                Send to QA Initial Review
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                QA Final Review Complete
                            </button>
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button> --}}
                        @elseif($data->stage == 6 && (in_array(39, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                                More Info Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Approved
                            </button>
                        @elseif($data->stage == 7 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#sendToInitiator">
                                Send to Opened
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#hodsend">
                                Send to HOD Review
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#qasend">
                                Send to QA Initial Review
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Initiator Updated Complete
                            </button>
                        @elseif($data->stage == 8 && (in_array(39, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#sendToInitiator">
                                Send to Opened
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#hodsend">
                                Send to HOD Review
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#qasend">
                                Send to QA Initial Review
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#pending-initiator-update">
                            Send to Pending Initiator Update
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            QA Final Review Complete
                            </button>
                        @endif
                        <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                            </a> </button>


                    </div>

                </div>
                <div class="status">
                    <div class="head">Current Status</div>
                    @if ($data->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @else
                        <div class="progress-bars" style="font-size: 15px;">
                            @if ($data->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($data->stage >= 2)
                                <div class="active">HOD Review </div>
                            @else
                                <div class="">HOD Review</div>
                            @endif

                            @if ($data->stage >= 3)
                                <div class="active">QA Initial Review</div>
                            @else
                                <div class="">QA Initial Review</div>
                            @endif

                            @if ($data->stage >= 4)
                                <div class="active">CFT Review</div>
                            @else
                                <div class="">CFT Review</div>
                            @endif


                            @if ($data->stage >= 5)
                                <div class="active">QA Final Review</div>
                            @else
                                <div class="">QA Final Review</div>
                            @endif
                            @if ($data->stage >= 6)
                                <div class="active">QA Head/Manager Designee Approval</div>
                            @else
                                <div class="">QA Head/Manager Designee Approval</div>
                            @endif
                            @if ($data->stage >= 7)
                                <div class="active">Pending Initiator Update</div>
                            @else
                                <div class="">Pending Initiator Update</div>
                            @endif
                            @if ($data->stage >= 8)
                                <div class="active">QA Final Approval</div>
                            @else
                                <div class="">QA Final Approval</div>
                            @endif
                            @if ($data->stage >= 9)
                                <div class="bg-danger">Closed - Done</div>
                            @else
                                <div class="">Closed - Done</div>
                            @endif
                    @endif


                </div>
            </div>

            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Parent Information</button> -->
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Commitment Information</button>
                <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Action Approval</button> -->
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Signature</button>
            </div>

            <form action="{{ route('update-recurring-commitment', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div id="step-form">
                    <!-- @if (!empty($parent_id))
                        <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                        <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                    @endif -->
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
                                        <input readonly type="text" value="{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="initiator_id">Initiator</label>
                                        <input readonly type="text" disable value="{{ Helpers::getInitiatorName($data->initiator_id) }}">
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
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="initiation_date_hidden" readonly>
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
                                                    <option value="{{ $user->id }}"  @if($user->id == $data->assign_to) selected @endif>{{ $user->name }}</option>
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
                                            <input type="date" name="due_date" readonly
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
                                        <input id="short_description" value="{{ $data->short_description }}" type="text" name="short_description" maxlength="255" placeholder="Enter Description" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Zone <span class="text-danger"></span>
                                        </label>
                                        <select id="zone" name="zone">
                                            <option value="">Select a value</option>
                                            <option value="Asia" @if($data->zone == "Asia") selected @endif>Asia</option>
                                            <option value="Europe" @if($data->zone == "Europe") selected @endif>Europe</option>
                                            <option value="Africa" @if($data->zone == "Africa") selected @endif>Africa</option>
                                            <option value="Central America" @if($data->zone == "Central America") selected @endif>Central America</option>
                                            <option value="South America" @if($data->zone == "South America") selected @endif>South America</option>
                                            <option value="Oceania" @if($data->zone == "Oceania") selected @endif>Oceania</option>
                                            <option value="North America" @if($data->zone == "North America") selected @endif>North America</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Country <span class="text-danger"></span>
                                        </label>
                                        <select name="country" class="form-select country" aria-label="Default select example" onchange="loadStates()">
                                            <option value="{{  $data->country }}" selected>{{ $data->country }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            State/District <span class="text-danger"></span>
                                        </label>
                                        <select name="state" class="form-select state" aria-label="Default select example" onchange="loadCities()">
                                            <option value="{{ $data->state }}" selected>{{ $data->state }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            City <span class="text-danger"></span>
                                        </label>
                                        <select name="city" class="form-select city" aria-label="Default select example">
                                            <option value="{{ $data->city }}" selected>{{ $data->city }}</option>
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
                                        <input id="epa_number" type="text" name="epa_number"  value="{{ $data->epa_number }}" placeholder="Enter EPA Identification">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Impact<span class="text-danger"></span>
                                        </label>
                                        <input id="impact" type="text" value="{{ $data->impact }}" name="impact" placeholder="Enter Impact">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Responsible Department">Responsible Department</label>
                                    <select name="responsible_department" id="responsible_department">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="Quality Assurance-CQA" @if($data->responsible_department == "Quality Assurance-CQA") selected @endif>Quality Assurance-CQA</option>
                                        <option value="Research and Development" @if($data->responsible_department == "Research and Development") selected @endif>Research and Development</option>
                                        <option value="Regulatory Science" @if($data->responsible_department == "Regulatory Science") selected @endif>Regulatory Science</option>
                                        <option value="Supply Chain Management" @if($data->responsible_department == "Supply Chain Management") selected @endif>Supply Chain Management</option>
                                        <option value="Finance" @if($data->responsible_department == "Finance") selected @endif>Finance</option>
                                        <option value="QA-Digital" @if($data->responsible_department == "QA-Digital") selected @endif>QA-Digital</option>
                                        <option value="Central Engineering" @if($data->responsible_department == "Central Engineering") selected @endif>Central Engineering</option>
                                        <option value="Projects" @if($data->responsible_department == "Projects") selected @endif>Projects</option>
                                        <option value="Marketing" @if($data->responsible_department == "Marketing") selected @endif>Marketing</option>
                                        <option value="QCAT" @if($data->responsible_department == "QCAT") selected @endif>QCAT</option>
                                        <option value="GMP Pilot Plant" @if($data->responsible_department == "GMP Pilot Plant") selected @endif>GMP Pilot Plant</option>
                                        <option value="Manufacturing Sciences and Technology" @if($data->responsible_department == "Manufacturing Sciences and Technology") selected @endif>Manufacturing Sciences and Technology</option>
                                        <option value="Environment, Health and Safety" @if($data->responsible_department == "Environment, Health and Safety") selected @endif>Environment, Health and Safety</option>
                                        <option value="Business Relationship Management" @if($data->responsible_department == "Business Relationship Management") selected @endif>Business Relationship Management</option>
                                        <option value="National Regulatory Affairs" @if($data->responsible_department == "National Regulatory Affairs<") selected @endif>National Regulatory Affairs</option>
                                        <option value="HR" @if($data->responsible_department == "HR") selected @endif>HR</option>
                                        <option value="Admin" @if($data->responsible_department == "Admin") selected @endif>Admin</option>
                                        <option value="Information Technology" @if($data->responsible_department == "Information Technology") selected @endif>Information Technology</option>
                                        <option value="Program Management QA Analytical"  @if($data->responsible_department == "HR") selected @endif>Program Management QA Analytical</option>
                                        <option value="QA Analytical" @if($data->responsible_department == "HR") selected @endif>QA Analytical</option>
                                        <option value="QA Packaging Development" @if($data->responsible_department == "QA Packaging Development") selected @endif>QA Packaging Development</option>
                                    </select>
                                </div>
                            </div>

                            <div class="sub-head">
                                Additional Information
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="related_url">Related URL</label>
                                        <input type="text" value="{{ $data->related_url }}" id="related_url" name="related_url" placeholder="Enter URL">

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="file_attach">Permit Certificate</label>
                                        <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="permit_certificate">
                                            @if ($data->permit_certificate)
                                                @foreach (json_decode($data->permit_certificate) as $file)
                                                    <h6 class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a class="remove-file" data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
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
                                            <div disabled class="file-attachment-list" id="file_attachments">
                                                @if ($data->file_attachments)
                                                    @foreach (json_decode($data->file_attachments) as $file)
                                                        <h6 class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                            <b>{{ $file }}</b>
                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary"
                                                                    style="font-size:20px; margin-right:-10px;"></i></a>
                                                            <a class="remove-file" data-file-name="{{ $file }}"><i
                                                                    class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                        </h6>
                                                    @endforeach
                                                @endif
                                            </div>
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
                                <option value="Type 1" @if($data->commitment_type == "Type 1") selected @endif>Type 1</option>
                                <option value="Type 2" @if($data->commitment_type == "Type 2") selected @endif>Type 2</option>
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
                                <option value="Frequency 1" @if($data->commitment_frequency == "Frequency 1") selected @endif>Frequency 1</option>
                                <option value="Frequency 2" @if($data->commitment_frequency == "Frequency 2") selected @endif>Frequency 2</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="commitment_start_date">Commitment Start Date</label>
                            <div class="calenderauditee"> 
                                <input type="text" id="commitment_start_date" readonly  placeholder="DD-MMM-YYYY"  value="{{ Helpers::getdateFormat($data->commitment_start_date) }}" />
                                <input type="date" name="commitment_start_date" value="{{ $data->commitment_start_date }}"
                                    max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'commitment_start_date')" />
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6  new-date-data-field">
                        <div class="group-input input-date">
                            <label for="commitment_end_date">Commitment End Date</lable>
                            <div class="calenderauditee">
                                <input type="text" id="commitment_end_date" readonly  placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($data->commitment_end_date) }}" />
                                <input type="date" name="commitment_end_date" value="{{ $data->commitment_end_date }}"
                                    max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'commitment_end_date')" />
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6  new-date-data-field">
                        <div class="group-input input-date">
                            <label for="next_commitment_date">Next Commitment Date</lable>
                            <div class="calenderauditee">
                                <input type="text" id="next_commitment_date" readonly  placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($data->next_commitment_date) }}" />
                                <input type="date" name="next_commitment_date" value="{{ $data->next_commitment_date }}"
                                    max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'next_commitment_date')" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="search">
                                Others Involved <span class="text-danger"></span>
                            </label>
                            <input id="other_involved" type="text" value="{{ $data->other_involved }}" name="other_involved" placeholder="Enter Value">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="search">
                                Site <span class="text-danger"></span>
                            </label>
                            <input id="site" type="text" name="site" value="{{ $data->site }}" placeholder="Enter Site Name">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="search">
                                Site Contact <span class="text-danger"></span>
                            </label>
                            <input id="site_contact" type="text" value="{{ $data->site_contact }}" name="site_contact" placeholder="Enter Site Contact">
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="group-input">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" value="{{ $data->description }}" placeholder="Enter Description">{{ $data->description }}</textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="group-input">
                            <label for="comments">Comments</label>
                            <textarea name="comments" id="comments" value="{{ $data->comments }}" placeholder="Enter Comment">{{ $data->comments }}</textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="group-input">
                            <label for="commitment_action">Commitment Action</label>
                            <textarea name="commitment_action" id="commitment_action" value="{{ $data->commitment_action }}" placeholder="Enter Commitment Action">{{ $data->commitment_action }}</textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="group-input">
                            <label for="commitment_notes">Commitment Notes</label>
                            <textarea name="commitment_notes" id="commitment_notes" value="{{ $data->commitment_notes }}" placeholder="Enter Commitment Notes">{{ $data->commitment_notes }}</textarea>
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
