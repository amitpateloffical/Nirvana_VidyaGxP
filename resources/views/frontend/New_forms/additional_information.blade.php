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
        $users = DB::table('users')->select('id', 'name')->get();
    @endphp

    <div class="form-field-head">
        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName(session()->get('division')) }}/ Additional Information
        </div>
    </div>

    {{-- ! ========================================= --}}
    {{-- !               DATA FIELDS                 --}}
    {{-- ! ========================================= --}}
    <div id="change-control-fields">
        <div class="container-fluid">

            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Check Parameter</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Activity Log</button>
            </div>

            <form action="{{ route('additional_information_create') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div id="step-form">
                    @if (!empty($parent_id))
                        <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                        <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                    @endif
                    <!-- ==========================================General Information============================================ -->
                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">
                                    Parent Record Information
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" name="record_number"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/AI/{{ date('Y') }}/{{ $record_number }}">
                                        {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Site/Location Code</b></label>
                                        <input disabled type="text" name="division_code"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                        <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                    </div>
                                </div>
                                <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date">(Parent) Date Opened</label>
                                        <div>
                                        </div>
                                        <div class="calenderauditee">
                                            <input type="text" id="parent_date" readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="parent_date"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                                class="hide-input" oninput="handleDateInput(this, 'parent_date')" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="(Parent) Market Complaint No.">(Parent) Market Complaint No.
                                            <input id="market_complaint" type="text" name="market_complaint">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">(Parent) Short Description<span
                                                class="text-danger">*</span></label>

                                        <input id="initiator_group_code" type="text" name="short_description"
                                            maxlength="255" required>
                                    </div>
                                </div>
                                <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date">(Parent) Target Closure Date</label>
                                        <div><small class="text-primary">Please mention expected date of
                                                completion</small>
                                        </div>
                                        <div class="calenderauditee">
                                            <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="due_date"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                                class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">
                                    General Information
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Originator">Originator</label>
                                        <input disabled type="text" name="initiator" value="{{ Auth::user()->name }}" />
                                    </div>
                                </div>
                                {{-- <div class="col-lg-6">
                                    <div class="group-input ">
                                        <label for="Date Due"><b>Date Opened</b></label>
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                    </div>
                                </div> --}}
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Opened">Date Opened</label>
                                        @if (isset($data) && $data->intiation_date)
                                            <input disabled type="text"
                                                value="{{ \Carbon\Carbon::parse($data->intiation_date)->format('d-M-Y') }}"
                                                name="intiation_date_display">
                                            <input type="hidden" value="{{ $data->intiation_date }}"
                                                name="intiation_date">
                                        @else
                                            <input disabled type="text" value="{{ date('d-M-Y') }}"
                                                name="intiation_date_display">
                                            <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                        @endif
                                    </div>
                                </div>
                                {{-- <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date">Target Closure Date</label>
                                        <div><small class="text-primary">Please mention expected date of
                                                completion</small>
                                        </div>
                                        <div class="calenderauditee">
                                            <input type="text" id="closure_date" readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="closure_date"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                                class="hide-input" oninput="handleDateInput(this, 'closure_date')" />
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Target Closure Date"> Target Closure Date </label>
                                        <input type="text" id="closure_date" readonly placeholder="DD-MMM-YYYY"
                                            value="{{ \Carbon\Carbon::parse($closure_date)->format('d-M-Y') }}" />
                                        <input type="hidden" name="closure_date" id="closure_date_input"
                                            value="{{ $closure_date }}" />

                                        {{-- <input type="hidden" value="{{ $due_date }}" name="due_date">
                                        <input disabled type="text" value="{{ Helpers::getdateFormat($due_date) }}"> --}}
                                        {{-- <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            value="" name="due_date"> --}}
                                    </div>

                                </div>
                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span
                                            id="initiator_group_code">255</span>
                                        characters remaining
                                        <input id="initiator_group_code" type="text" name="Short" maxlength="255"
                                            required>
                                    </div>
                                </div> --}}
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars">255</span>
                                        characters remaining
                                        <input id="docname" type="text" name="Short" maxlength="255" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Description</label>

                                        <textarea name="description" id="description" type="text"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="If Others">Assignee</label>
                                        <select name="assigned_to" onchange="">

                                            <option value="">Select a value</option>
                                            @if ($users->isNotEmpty())
                                                @foreach ($users as $value)
                                                    <option value='{{ $value->name }}'>{{ $value->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="If Others">Initiating Department</label>
                                        <select name="initiating_department" onchange="">

                                            <option value="">Select a value</option>
                                            @if ($users->isNotEmpty())
                                                @foreach ($users as $value)
                                                    <option value='{{ $value->name }}'>{{ $value->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Inv Attachments">Initial Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="file_attach"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="file_attach[]"
                                                    oninput="addMultipleFiles(this, 'file_attach')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="button-block">
                                    <button type="submit" class="saveButton">Save</button>
                                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                    <button type="button"> <a class="text-white"
                                            href="{{ url('rcms/qms-dashboard') }}">
                                            Exit </a> </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ==========================================Operational Planning & Control============================================ -->
                    <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Patient Age">Patient Age
                                            <input id="patient_age" type="text" name="patient_age">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for=" Precription Details">
                                            Precription Details
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#management-review-production_service_provision-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <textarea name=" Precription_Details" id="" type="text"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for=" Pack Details">
                                            Pack Details
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#management-review-production_service_provision-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <textarea name="Pack_Details" id="" type="text"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Container Opening Date">
                                            Container Opening Date
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#management-review-control_externally_provide_services-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <textarea name="Container_Opening_Date" id="" type="text"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Storage Condition">
                                            Storage Condition
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#management-review-production_service_provision-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <textarea name="Storage_Condition" id="" type="text"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Storage Location">
                                            Storage Location
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#management-review-release_product_services-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <textarea name="Storage_Location" id="" type="text"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Piercing Details">
                                            Piercing Details
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#management-review-control_nonconforming_outputs-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <textarea name="Piercing_Details" id="" type="text"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Consuption Details-Product">
                                            Consuption Details-Product
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#management-review-release_product_services-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <textarea name="Consuption_Details_Product" id="" type="text"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Complainant Medication History">
                                            Complainant Medication History
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#management-review-production_service_provision-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <textarea name="Complainant_Medication_History" id="" type="text"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Other Medication">
                                            Other Medication
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#management-review-production_service_provision-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <textarea name="Other_Medication" id="" type="text"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Other Details">
                                            Other Details
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#management-review-production_service_provision-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <textarea name="Other_Details" id="" type="text"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Delay Justification">
                                            Delay Justification
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#management-review-production_service_provision-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <textarea name="Delay_Justification" id="" type="text"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Inv Attachments">File Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="file_attachement"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="file_attachement[]"
                                                    oninput="addMultipleFiles(this, 'file_attachement')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="button-block">
                                    <button type="submit" class="saveButton">Save</button>
                                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                    <button type="button"> <a class="text-white"
                                            href="{{ url('rcms/qms-dashboard') }}">
                                            Exit </a> </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ==========================================Activity Log============================================ -->
                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">
                                    Activity Log
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Submited by">Submited By</label>
                                        <div class="static"value=""></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Submited on">Submited On</label>
                                        <div class="static" value=""></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Submited Comment">Submited Comment </label>
                                        <div class="static"value=""></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Cancel by">Cancel By</label>
                                        <div class="static"value=""></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Cancel on">Cancel On</label>
                                        <div class="static" value=""></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Cancel by">Cancel Comment </label>
                                        <div class="static"value=""></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Execution Complete by">Execution Complete By</label>
                                        <div class="static"value=""></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Execution Complete on">Execution Complete On</label>
                                        <div class="static" value=""></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Execution Complete">Execution Complete Comment </label>
                                        <div class="static"value=""></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More Info request by">More Info request By</label>
                                        <div class="static"value=""></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More Info request on">More Info request On</label>
                                        <div class="static" value=""></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More Info request by">More Info request Comment </label>
                                        <div class="static"value=""></div>
                                    </div>
                                </div>
                            </div>

                            <div class="button-block">
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button"> <a class="text-white"
                                        href="{{ url('rcms/qms-dashboard') }}">Exit
                                    </a> </button>
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
        document.getElementById('initiator_group').addEventListener('change', function() {
            var selectedValue = this.value;
            document.getElementById('initiator_group_code').value = selectedValue;
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
        var maxLength = 255;
        $('#docname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);
        });
    </script>
@endsection
