@extends('frontend.layout.main')
@section('container')
<style>
    textarea.note-codable {
        display: none !important;
    }

    header {
        display: none;
    }


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

@php
$users = DB::table('users')->get();
@endphp

<div class="form-field-head">
    {{-- <div class="pr-id">
            New Child
        </div> --}}
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        / Monthly Working
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

                <div class="d-flex" style="gap:20px;">
                    @php
                    $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => 7])->get();
                    $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                    @endphp

                    <button class="button_theme1"> <a class="text-white" href="{{ url('audit_trail_monthly_working', $monthly->id) }}"> Audit Trail </a> </button>

                    @if ($monthly->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                    <!-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Send Translation
                    </button> -->
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                        Close
                    </button>
                    @elseif($monthly->stage == 2 && (in_array(39, $userRoleIds) || in_array(18, $userRoleIds)))
                    <!-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Obsolete
                    </button> -->

                    @endif
                    <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                        </a> </button>
                </div>
            </div>


            <div class="status">
                <div class="head">Current Status</div>
                @if ($monthly->stage == 0)
                <div class="progress-bars">
                    <div class="bg-danger">Closed-Cancelled</div>
                </div>

                @else
                <div class="progress-bars d-flex" style="font-size: 15px;">
                    @if ($monthly->stage >= 1)
                    <div class="active">Opened</div>
                    @else
                    <div class="">Opened</div>
                    @endif


                    @if ($monthly->stage >= 2)
                    <div class="bg-danger">Closed</div>
                    @else
                    <div class="">Closed</div>
                    @endif
                    {{-- @endif --}}
                </div>
                @endif
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
        </div>


        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Monthly Working Hours</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Activity Log</button>
        </div>

        <script>
            $(document).ready(function() {
                <?php if (in_array($monthly->stage, [2])) : ?>
                    $("#target :input").prop("disabled", true);
                <?php endif; ?>
            });
        </script>

        <form id="target" action="{{ route('monthly_working.update', $monthly->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div id="step-form">
                @if (!empty($parent_id))
                <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                @endif
                <!-- Tab content -->
                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="sub-head">
                            <!-- General Information -->
                        </div> <!-- RECORD NUMBER -->


                        <div class="row">
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Originator</b></label>
                                    <input disabled type="text" name="initiator" value="">

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiation"><b>Date of Initiation</b></label>
                                    @if(isset($monthly) && $monthly->initiation_date)
                                    <input disabled type="text" value="{{ \Carbon\Carbon::parse($monthly->initiation_date)->format('d-M-Y') }}" id="initiation_date_display">
                                    <input type="hidden" value="{{ $monthly->initiation_date }}" id="initiation_date" name="initiation_date">
                                    @else
                                    <input disabled type="text" value="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" id="initiation_date_display">
                                    <input type="hidden" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="initiation_date" name="initiation_date">
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number">Record Number</label>
                                    <input disabled type="text" name="record" value="{{ Helpers::getDivisionName($monthly->division_id) }}/MW/{{ Helpers::year($monthly->created_at) }}/{{ $monthly->record }}">
                                </div>
                            </div>



                            {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Due Date">Due Date</label>

                                        @if (!empty($cc->due_date))
                                        <div class="static"></div>
                                        @endif
                                    </div>
                                </div> --}}


                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Date Due <span class="text-danger"></span></label>
                                    <p class="text-primary"> last date this record should be closed by</p>

                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" value="{{$monthly->due_date}}" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{$monthly->due_date}}" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assign_to">
                                        <option value="assign_to">Select a value</option>
                                        @foreach ($users as $datas)
                                        @if(Helpers::checkUserRolesassign_to($datas))
                                        <option value="{{ $datas->id }}" {{ $monthly->assign_to == $datas->id ? 'selected' : '' }}>
                                            {{ $datas->name }}
                                        </option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span></label><span id="rchars">255</span>
                                    characters remaining
                                    <input id="docname" type="text" name="short_description" maxlength="255" value="{{$monthly->short_description}}" required>
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Description"> Description<span class="text-danger"></span></label>
                                    <textarea name="description" value="">{{$monthly->description}}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Zone">Zone</label>
                                    <select name="zone">
                                        <!-- <option value="">Enter Your Selection Here</option> -->
                                        <option value="Asia" @if ($monthly->zone == "Asia") selected @endif>Asia</option>
                                        <option value="Europe" @if ($monthly->zone == "Europe") selected @endif>Europe</option>
                                        <option value="Africa" @if ($monthly->zone == "Africa") selected @endif>Africa</option>
                                        <option value="Central-America" @if ($monthly->zone == "Central-America") selected @endif>Central America</option>
                                        <option value="South-America" @if ($monthly->zone == "South-America") selected @endif>South America</option>
                                        <option value="Oceania" @if ($monthly->zone == "Oceania") selected @endif>Oceania</option>
                                        <option value="North-America" @if ($monthly->zone == "North-America") selected @endif>North America</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Country">Country</label>
                                    <select name="country" class="form-select country" value="" aria-label="Default select example" onchange="loadStates()">
                                        <option value="{{$monthly->country}}" selected>{{$monthly->country}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="State">State</label>
                                    <select name="state" class="form-select state" aria-label="Default select example" onchange="loadCities()">
                                        <option value="{{$monthly->state}}" selected>{{$monthly->state}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="City">City</label>
                                    <select name="city" class="form-select city" aria-label="Default select example">
                                        <option value="{{$monthly->city}}" selected>{{$monthly->city}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">

                                    <label for="Year"> Year<span class="text-danger"></span></label>
                                    <select name="year">
                                        <option value="2024" @if ($monthly->year == 2024) selected @endif>2024</option>
                                        <option value="2025" @if ($monthly->year == 2025) selected @endif>2025</option>
                                        <option value="2026" @if ($monthly->year == 2026) selected @endif>2026</option>
                                        <option value="2027" @if ($monthly->year == 2027) selected @endif>2027</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">

                                    <label for="Month"> Month<span class="text-danger"></span></label>
                                    <select name="month">
                                        <option value="Jan" @if ($monthly->month == "Jan") selected @endif>Jan</option>
                                        <option value="Feb" @if ($monthly->month == "Feb") selected @endif>Feb</option>
                                        <option value="March" @if ($monthly->month == "March") selected @endif>March</option>
                                        <option value="April" @if ($monthly->month == "April") selected @endif>April</option>
                                        <option value="May" @if ($monthly->month == "May") selected @endif>May</option>
                                        <option value="June" @if ($monthly->month == "June") selected @endif>June</option>
                                        <option value="July" @if ($monthly->month == "July") selected @endif>July</option>
                                        <option value="Aug" @if ($monthly->month == "Aug") selected @endif>Aug</option>
                                        <option value="Sept" @if ($monthly->month == "Sept") selected @endif>Sept</option>
                                        <option value="Oct" @if ($monthly->month == "Oct") selected @endif>Oct</option>
                                        <option value="Nov" @if ($monthly->month == "Nov") selected @endif>Nov</option>
                                        <option value="Dec" @if ($monthly->month == "Dec") selected @endif>Dec</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label>Number Of Own Employess</label>
                                    <input type="number" name="number_of_own_emp" value="{{$monthly->number_of_own_emp}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label>Hours Own Employess</label>
                                    <input type="number" name="hours_own_emp" value="{{$monthly->hours_own_emp}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label>Number Of Contractors</label>
                                    <input type="number" name="number_of_contractors" value="{{$monthly->number_of_contractors}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label>Hours Of Contractors</label>
                                    <input type="number" name="hours_of_contractors" value="{{$monthly->hours_of_contractors}}">
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

                <div id="CCForm5" class="inner-block cctabcontent">
                    <div class="inner-block-content">

                        <div class="row">

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="cancelled by">Closed By</label>
                                    <div class="static">{{ $monthly->closed_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Closed on">Closed On</label>
                                    <div class="Date">{{$monthly->closed_on}}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Closed on">Comment</label>
                                    <div class="Date">{{$monthly->close_comment}}</div>
                                </div>
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


<!-- zone / country / state / api -->
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



<!-- signature model -->

<div class="modal fade" id="cancel-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('monthlyCancel', $monthly->id) }}" method="POST">
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



<div class="modal fade" id="signature-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('monthly_send_stage', $monthly->id) }}" method="POST">
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
<div class="modal fade" id="cft-not-reqired">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST">
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
<div class="modal fade" id="modal1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST">
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

@endsection