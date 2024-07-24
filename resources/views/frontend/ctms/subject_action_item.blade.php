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
        / Subject Action Item
    </div>
</div>



{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Treatment Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Signatures</button>

        </div>

        <form action="{{ route('subject_action_item.store') }}" method="POST" enctype="multipart/form-data">
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
                                    <label for="Initiator">Record Number </label>
                                    <input disabled type="text" name="record"
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}/Subject-Action-Item/{{ date('Y') }}/{{ $record_number }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Site/Location Code</b></label>
                                    <input readonly type="text" name="division_code"
                                        value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Initiator</b></label>
                                    <input disabled type="text" disabled name="initiation_id" value="{{ auth()->user()->name }}">
                                </div>
                            </div>

                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Date of Initiation<span class="text-danger"></span></label>
                                    <div class="calenderauditee">
                                        <input readonly type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="cancelled by">Short Description<span class="text-danger">*</span>
                                    <input type="text" name="short_description_ti" maxlength="255" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Assigned To</b></label>
                                    <select name="assign_to_gi">
                                        <option value="">Select a value</option>
                                            @if(!empty($users))
                                                @foreach ($users as $user)
                                                  <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date"> Date Due <span class="text-danger"></span></label>
                                    <p class="text-primary">Please mention expected date of completion</p>
                                    <div class="calenderauditee">
                                        <input  type="hidden" value="{{ $due_date }}" name="due_date">
                                        <input disabled type="text" value="{{ Helpers::getdateFormat($due_date) }}" >
                                        {{--<input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'due_date')" />--}}
                                    </div>
                                </div>
                            </div>

                            <div class="sub-head">Study Details</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>(Root Parent) Trade Name</b></label>
                                    <input  type="text" name="trade_name_sd">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>(Root Parent) Assigned To</b></label>
                                    <select name="assign_to_sd">
                                        <option value="">--Select--</option>
                                        <option value="manish">Manish</option>
                                        <option value="pankaj">Pankaj</option>
                                    </select>
                                </div>
                            </div>

                            <div class="sub-head">Subject Details</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>( Parent) Subject Name</b></label>
                                    <input  type="text" name="subject_name_sd">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>( Parent) Gender</b></label>
                                    <select name="gender_sd">
                                        <option value="">--Select--</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="others">Others</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>( Parent) Date Of Birth</b></label>
                                    <input  type="date" name="date_of_birth_sd">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>( Parent) Race</b></label>
                                    <select name="race_sd">
                                        <option value="">--Select--</option>
                                        <option value="23">23</option>
                                        <option value="24">24</option>
                                        <option value="25">25</option>
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


                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Clinical Efficacy</b></label>
                                    <select name="clinical_efficacy_ti">
                                        <option value="">--Select--</option>
                                        <option value="efficacy-analysis">Efficacy Analysis</option>
                                        <option value="interim-efficacy-assessment">Interim Efficacy Assessment</option>
                                        <option value="efficacy-monitoring">Efficacy Monitoring</option>
                                        <option value="efficacy-data-collection">Efficacy Data Collection</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Carry Over Effect</b></label>
                                    <select name="carry_over_effect_ti">
                                        <option value="">--Select--</option>
                                        <option value="data-collection-protocols">Data Collection Protocols</option>
                                        <option value="statistical-analysis">Statistical Analysis</option>
                                        <option value="regulatory-compliance">Regulatory Compliance</option>
                                        <option value="pilot-studies">Pilot Studies</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Last Monitered (Days)</b></label>
                                    <select name="last_monitered_ti">
                                        <option value="">--Select--</option>
                                        <option value="1Days">1Days</option>
                                        <option value="2Days">2Days</option>
                                        <option value="3Days">3Days</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="cancelled by">Total Doses Recieved</label>
                                    <input name="total_doses_recieved_ti" />
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="cancelled by">Treatment Effect</label>
                                    <input name="treatment_effect_ti" />
                                </div>
                            </div>


                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    DCF
                                    <button type="button" name="dfc_grid" id="DCFadd">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        Open
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="DCF">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Number</th>
                                                <th style="width: 16%"> Date</th>
                                                <th style="width: 15%">Sent Date</th>
                                                <th style="width: 15%">Returned Date</th>
                                                <th style="width: 15%">Data Collection Method </th>
                                                <th style="width: 15%">Comment</th>
                                                <th style="width: 15%">Remarks</th>
                                                <th style="width: 15%">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input disabled type="text" name="dfc_grid[0][serial]" value="1"></td>
                                            <td><input type="text" name="dfc_grid[0][Number]"></td>
                                            <td><input type="date" name="dfc_grid[0][Date]"></td>
                                            <td><input type="date" name="dfc_grid[0][SentDate]"></td>
                                            <td><input type="date" name="dfc_grid[0][ReturnedDate]"></td>
                                            <td><input type="text" name="dfc_grid[0][DataCollectionMethod]"></td>
                                            <td><input type="text" name="dfc_grid[0][Comment]"></td>
                                            <td><input type="text" name="dfc_grid[0][Remarks]"></td>
                                            <td><button readonly type="text" class="removeRowBtn">Remove</button></td>
                                            {{--<td><input readonly type="text"></td>--}}
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Minor Protocol Voilation
                                    <button type="button" name="minor_protocol_voilation" id="ObservationAdd">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        Open
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="minor-protocol-voilation">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Item Description</th>
                                                <th style="width: 16%">Date</th>
                                                <th style="width: 15%">Sent Date</th>
                                                <th style="width: 15%">Returned Date</th>
                                                <th style="width: 15%">Comment</th>
                                                <th style="width: 15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input disabled type="text" name="minor_protocol_voilation[0][serial]" value="1"></td>
                                            <td><input type="text" name="minor_protocol_voilation[0][ItemDescription]"></td>
                                            <td><input type="date" name="minor_protocol_voilation[0][Date]"></td>
                                            <td><input type="date" name="minor_protocol_voilation[0][SentDate]"></td>
                                            <td><input type="date" name="minor_protocol_voilation[0][ReturnedDate]"></td>
                                            <td><input type="text" name="minor_protocol_voilation[0][Comment]"></td>
                                            <td><button readonly type="text" class="removeRowBtn">Remove</button></td>
                                            {{--<td><input readonly type="text"></td>--}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <Label>Comments</Label>
                                    <textarea name="comments_ti"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <Label>Summary </Label>
                                    <textarea name="summary_ti"></textarea>
                                </div>
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

                <div id="CCForm5" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="cancelled by">Closed By</label>
                                    <div class="static"></div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Closed on">Closed On</label>
                                    <div class="Date"></div>
                                </div>
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
    $(document).ready(function() {
        $('#DCFadd').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="dfc_grid[' + serialNumber + '][Number]"></td>' +
                    '<td><input type="date" name="dfc_grid[' + serialNumber + '][Date]"></td>' +
                    '<td><input type="date" name="dfc_grid[' + serialNumber + '][SentDate]"></td>' +
                    '<td><input type="date" name="dfc_grid[' + serialNumber + '][ReturnedDate]"></td>' +
                    '<td><input type="text" name="dfc_grid[' + serialNumber + '][DataCollectionMethod]"></td>' +
                    '<td><input type="date" name="dfc_grid[' + serialNumber + '][Comment]"></td>' +
                    '<td><input type="text" name="dfc_grid[' + serialNumber + '][Remarks]"></td>' +
                    '<td><button type="text" class="removeRowBtn" ">Remove</button></td>' +

                    '</tr>';

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                // html += '</select></td>' +

                '</tr>';

                return html;
            }

            var tableBody = $('#DCF tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#ObservationAdd').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="minor_protocol_voilation[' + serialNumber + '][ItemDescription]"></td>' +
                    '<td><input type="date" name="minor_protocol_voilation[' + serialNumber + '][Date]"></td>' +
                    '<td><input type="date" name="minor_protocol_voilation[' + serialNumber + '][SentDate]"></td>' +
                    '<td><input type="date" name="minor_protocol_voilation[' + serialNumber + '][ReturnedDate]"></td>' +
                    '<td><input type="text" name="minor_protocol_voilation[' + serialNumber + '][Comment]"></td>' +
                    '<td><button type="text" class="removeRowBtn" ">Remove</button></td>' +

                    '</tr>';

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                // html += '</select></td>' +

                '</tr>';

                return html;
            }


            var tableBody = $('#minor-protocol-voilation tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>

<script>
    $(document).on('click', '.removeRowBtn', function() {
        $(this).closest('tr').remove();
    })
</script>


<script>
    var maxLength = 255;
    $('#docname').keyup(function() {
        var textlen = maxLength - $(this).val().length;
        $('#rchars').text(textlen);
    });
</script>
@endsection
