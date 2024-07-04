@extends('frontend.layout.main')
@section('container')
@php 
$users = DB::table('users')->select('id', 'name')->get();
@endphp
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
        / SCAR 
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
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Activity Log</button>

        </div>

        <form action="{{ route('actionItem.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div id="step-form">
                @if (!empty($parent_id))
                <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                @endif
                <!-- Tab content -->
                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">
                                General Information
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Record Number</b></label>
                                    <input type="text" name="record" value="">

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"><b>Division</b></label>
                                    <input disabled type="text" name="division_id" value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"><b>Initiator</b></label>
                                    <input disabled type="text" name="initiator_id" id="initiator_id" value="{{Auth::user()->name}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiation"><b>Initiation Date</b></label>
                                    <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                </div>
                            </div>
                            
                            
                          
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Date Due</label>
                                    {{-- <div><small class="text-primary">Please mention expected date of completion</small></div> --}}
                                    <div class="calenderauditee">
                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" readonly placeholder="DD-MM-YYYY" />
                                        <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" name="assign_to">
                                        <option value="">Select a value</option>
                                        @if(!empty($users))
                                            @foreach($users as $user)
                                                <option value="{{$user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        @endif                                    
                                    </select>
                                </div>
                            </div>
                       
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span></label><span id="rchars">255</span>
                                    characters remaining
                                    <input id="docname" type="text" name="short_description" maxlength="255" required>
                                </div>
                            </div>
                            <script>
                                var maxLength = 255;
                                $('#docname').keyup(function() {
                                    var textlen = maxLength - $(this).val().length;
                                    $('#rchars').text(textlen);});
                            </script>
                             
                            

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="SCAR Name">SCAR Name</label>
                                    <input type="text" name="scar_name" value="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Owner">Owner</label>
                                    <input type="text" name="owner_name" value="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Follow Up Date</label>
                                    <input type="text" name="followup_date" value="">
                                </div>
                            </div>
                          
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Supplier Site</label>
                                    <select name="supplier_site">
                                        <option value="">Enter Your Selection Here</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Supplier Product</label>
                                    <select name="supplier_product">
                                        <option value="">Enter Your Selection Here</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Supplier Site Contact Email</label>
                                 <input type="text" name="supplier_site_contact_email" value="">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Responsible Department">Description</label>
                                   <textarea name="description" id="description" cols="30" value="" name=""></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Responsible Department">Recommended Action</label>
                                   <textarea name="" id="" cols="30" value="" name="recommended_action"></textarea>
                                </div>
                            </div>
                            <div class="sub-head">
                                Supplier Responce
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Nonconformance</label>
                                    <select name="non_conformance">
                                        <option value="">Enter Your Selection Here</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Expected Closure Date</label>
                                   <input type="date" name="expected_closure_date" value="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Expected Closure Time</label>
                                   <input type="time" name="expected_closure_time" value="">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Responsible Department">Root Cause</label>
                                   <textarea name="" id="" cols="30" value="" name="root_cause"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Responsible Department">Risk Analysis</label>
                                   <textarea name="" id="" cols="30" value="risk_analysis" name=""></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Responsible Department">Effectiveness Check Summary</label>
                                   <textarea name="" id="" cols="30" value="" name="effectiveness_check_summary"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Responsible Department">CAPA Plan</label>
                                   <textarea name="" id="" cols="30" value="" name="capa_plan"></textarea>
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
                </div>
            </div>
            <!-- ============================================================================================================== -->
           


         

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
                    $('#AuditSiteInformation').click(function(e) {
                        function generateTableRow(serialNumber) {

                            var html =
                                '<tr>' +
                                '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                                '<td><input type="text" name="WitnessName[]"></td>' +
                                '<td><input type="text" name="WitnessType[]"></td>' +
                                '<td><input type="text" name="ItemDescriptions[]"></td>' +
                                '<td><input type="text" name="Comments[]"></td>' +
                                '<td><input type="text" name="Remarks[]"></td>' +
                                '</tr>';

                            return html;
                        }

                        var tableBody = $('#AuditSiteInformation_details tbody');
                        var rowCount = tableBody.children('tr').length;
                        var newRow = generateTableRow(rowCount + 1);
                        tableBody.append(newRow);
                    });
                });
            </script>
            <script>
                $(document).ready(function() {
                    $('#StudySiteInformation').click(function(e) {
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

                        var tableBody = $('#StudySiteInformation_details tbody');
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