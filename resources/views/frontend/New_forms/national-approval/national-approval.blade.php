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

<div class="form-field-head">
    {{-- <div class="pr-id">
            New Child
        </div> --}}
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        /National Approval
    </div>
</div>



{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">National Approval</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Approval Plan</button>
            <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Manufacturer detail</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Registration information</button> -->
            <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Signatures</button>
        </div>

        <form action="{{ route('national_approval.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div id="step-form">
                @if (!empty($parent_id))
                <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                @endif

                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">
                                General Information
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Manufacturer">(Root Parent) Manufacturer</label>
                                    <input type="text" name="manufacturer" id="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Trade Name">(Root Parent) Trade Name</label>
                                    <input type="text" name="trade_name" id="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"><b>Initiator</b></label>
                                    <input disabled type="text" name="initiator" value="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiation"><b>Date of Initiation</b></label>
                                    <!-- <input disabled type="date" name="Date_of_Initiation" value="">
                                    <input type="hidden" name="initiation_date" value=""> -->
                                    <input disabled type="text" value="{{ date('d-M-Y') }}" id="initiation_date_display">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" id="intiation_date" name="initiation_date">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number">Record Number</label>
                                    <input disabled type="text" name="record" value="{{ Helpers::getDivisionName(session()->get('division')) }}/NP/{{ date('Y')}}/{{$record_number}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assign_to">
                                        <option value="">Select a value</option>
                                        @foreach ($users as $key => $value)
                                        <option value="{{ $value->id }}">
                                            {{ $value->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('assigned_user_id')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Date Due</label>
                                    <div><small class="text-primary">Please mention expected date of completion</small></div>
                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Procedure Type">(Parent) Procedure Type</label>
                                    <select name="procedure_type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="type-1">type-1</option>
                                        <option value="type-2">type-2</option>
                                        <option value="type-3">type-3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Procedure Type">Planned Subnission Date</label>
                                    <input type="date" name="planned_subnission_date" id="">

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span></label><span id="rchars">255</span>
                                    characters remaining
                                    <input id="docname" type="text" name="short_description" maxlength="255" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Member State">Member State</label>
                                    <input type="text" name="member_state" id="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Local Trade Name</label>
                                    <input type="text" name="local_trade_name" id="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Registration Number</label>
                                    <input type="text" name="registration_number" id="">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Renewal Rule">Renewal Rule</label>
                                    <select name="renewal_rule">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="rule-1">rule-1</option>
                                        <option value="rule-2">rule-2</option>
                                        <option value="rule-3">rule-3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Dossier Parts">Dossier Parts</label>
                                    <textarea name="dossier_parts" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Related Dossier Documents">Related Dossier Documents</label>
                                    <select name="related_dossier_documents">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="doc-1">doc-1</option>
                                        <option value="doc-2">doc-2</option>
                                        <option value="doc-3">doc-3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Pack Size">Pack Size</label>
                                    <input type="text" name="pack_size">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Shelf Life">Shelf Life</label>
                                    <select name="shelf_life">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="test-1">test-1</option>
                                        <option value="test-2">test-2</option>
                                        <option value="test-3">test-3</option>
                                    </select>
                                </div>
                            </div>



                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Packaging Information(0)
                                    <button type="button" name="details" id="Details-add">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Details-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Primary Packaging</th>
                                                <th style="width: 16%">Material</th>
                                                <th style="width: 16%">Pack Size</th>
                                                <th style="width: 16%">Shelf Life</th>
                                                <th style="width: 15%">Storage Condition</th>
                                                <th style="width: 15%">Secondary Packaging</th>
                                                <th style="width: 15%">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input disabled type="text" name="details[0][serial]" value="1"></td>
                                            <td><input type="text" name="details[0][primary_packaging]"></td>
                                            <td><input type="text" name="details[0][material]"></td>
                                            <td><input type="text" name="details[0][pack_size]"></td>
                                            <td><input type="text" name="details[0][shelf_life]"></td>
                                            <td><input type="text" name="details[0][storage_condition]"></td>
                                            <td><input type="text" name="details[0][secondary_packaging]"></td>
                                            <td><input type="text" name="details[0][remarks]"></td>
                                            <!-- <td><button type="text" class="removeRowBtn">Remove</button></td> -->
                                        </tbody>

                                    </table>
                                </div>
                            </div>


                            <script>
                                $(document).ready(function() {
                                    $('#Details-add').click(function(e) {
                                        function generateTableRow(serialNumber) {
                                            var html = '';
                                            html += '<tr>' +
                                                '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                                                '"></td>' +
                                                '<td><input type="text" name="details[' + serialNumber +
                                                '][primary_packaging]"></td>' +
                                                '<td><input type="text" name="details[' + serialNumber + '][material]"></td>' +
                                                '<td><input type="text" name="details[' + serialNumber + '][pack_size]"></td>' +
                                                '<td><input type="text" name="details[' + serialNumber + '][shelf_life]"></td>' +
                                                '<td><input type="text" name="details[' + serialNumber + '][storage_condition]"></td>' +
                                                '<td><input type="text" name="details[' + serialNumber + '][secondary_packaging]"></td>' +
                                                '<td><input type="text" name="details[' + serialNumber + '][remarks]"></td>' +
                                                // '<td><button type="text" class="removeRowBtn" >Remove</button></td>' +
                                                '</tr>';

                                            // for (var i = 0; i < users.length; i++) {
                                            //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                                            // }

                                            // html += '</select></td>' +

                                            '</tr>';

                                            return html;
                                        }

                                        var tableBody = $('#Details-table tbody');
                                        var rowCount = tableBody.children('tr').length;
                                        var newRow = generateTableRow(rowCount + 1);
                                        tableBody.append(newRow);
                                    });
                                });
                            </script>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="PSUP Cycle">PSUP Cycle</label>
                                    <select name="psup_cycle">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Expiration Date">Expiration Date</label>
                                    <input type="date" name="expiration_date">
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
                            <div class="sub-head">
                                Approval Plan
                            </div>
                            <!-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Patient_Involved">Assigned To</label>
                                    <input type="text" name="ap_assigned_to" id="">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date Due">Date Due</label>
                                    <input type="date" name="ap_date_due">
                                </div>
                            </div> -->

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Auditee">Approval Status</label>
                                    <select multiple name="approval_status" placeholder="Select Auditee" data-search="false" data-silent-initial-value-set="true" id="Auditee">
                                        <option value="">cfgg</option>
                                        <option value="">cfggsd</option>
                                        <option value="">cfgsdg</option>
                                        <option value="">cfgasasg</option>
                                        <option value="">cdsfgg</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Marketing Authorization Holder">Marketing Authorization Holder</label>
                                    <input type="text" name="marketing_authorization_holder">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Planned Submission Date">Planned Submission Date</label>
                                    <input type="date" name="planned_submission_date">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actual Submission Date">Actual Submission Date</label>
                                    <input type="date" name="actual_submission_date">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Planned Approval Date">Planned Approval Date</label>
                                    <input type="date" name="planned_approval_date">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actual Approval Date">Actual Approval Date</label>
                                    <input type="date" name="actual_approval_date">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actual Withdrawn Date">Actual Withdrawn Date</label>
                                    <input type="date" name="actual_withdrawn_date">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actual Rejection Date">Actual Rejection Date</label>
                                    <input type="date" name="actual_rejection_date">
                                </div>
                            </div>

                            <div class="col-lg-12 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Comments">Comments</label>
                                    <textarea name="comments" id="" cols="30" rows="3"></textarea>
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
                </div>

                <!-- <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                    Exit </a> </button>
                        </div>
                    </div>
                </div> -->

                <!-- <div id="CCForm4" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                    Exit </a> </button>
                        </div>
                    </div>
                </div> -->

                <div id="CCForm5" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Started by">Started By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Started on">Started On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Submitted by">Submitted By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Submitted on">Submitted On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Approved by">Approved By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Approved on">Approved On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Refused by">Refused By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Refused On">Refused On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Withdrawn by">Withdrawn By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Withdrawn On">Withdrawn On</label>
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
        if (currentStep < steps.length - 1) {
            steps[currentStep].style.display = "none";
            steps[currentStep + 1].style.display = "block";
            stepButtons[currentStep + 1].classList.add("active");
            stepButtons[currentStep].classList.remove("active");
            currentStep++;
        }
    }

    function previousStep() {
        if (currentStep > 0) {
            steps[currentStep].style.display = "none";
            steps[currentStep - 1].style.display = "block";
            stepButtons[currentStep - 1].classList.add("active");
            stepButtons[currentStep].classList.remove("active");
            currentStep--;
        }
    }
</script>

<script>
    $(document).ready(function() {
        $('#Packaging_Information').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '</tr>';

                return html;
            }

            var tableBody = $('#Packaging_Information-field-instruction-modal tbody');
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