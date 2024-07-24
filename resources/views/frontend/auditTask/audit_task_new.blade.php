@extends('frontend.layout.main')
@section('container')
    @php
        $users = DB::table('users')->get();
    @endphp
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }
    </style>


    <!-- --------------------------------------button--------------------- -->

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





    <div class="form-field-head">
        <!-- <div class="pr-id">
                                                                                                                                                                                                                                                                                                                                                        New Document
                                                                                                                                                                                                                                                                                                                                                    </div> -->
        <div class="division-bar pt-3">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName(session()->get('division')) }} / Audit Task
        </div>
        <!-- <div class="button-bar">
                                                                                                                                                                                                                                                                                                                                                            <button type="button">Save</button>
                                                                                                                                                                                                                                                                                                                                                            <button type="button">Cancel</button>
                                                                                                                                                                                                                                                                                                                                                            <button type="button">New</button>
                                                                                                                                                                                                                                                                                                                                                            <button type="button">Copy</button>
                                                                                                                                                                                                                                                                                                                                                            <button type="button">Child</button>
                                                                                                                                                                                                                                                                                                                                                            <button type="button">Check Spelling</button>
                                                                                                                                                                                                                                                                                                                                                            <button type="button">Change Project</button>
                                                                                                                                                                                                                                                                                                                                                        </div> -->
    </div>

    {{-- ======================================
                    DATA FIELDS
    ======================================= --}}
    <div id="change-control-fields">
        <div class="container-fluid">

            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Compliance Verification</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm17')">Signature</button>

            </div>

            <!-- General Information -->

            <form action="{{ route('audit_store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">

                        <div class="sub-head">Parent Record Information</div>
                        <div class="row">

                            {{-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"> (parent) Date Opened </label>
                                    <input type="date" name="open_date">
                                </div>
                            </div> --}}
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">(Parent) Date Opened</label>
                                    <div>
                                    </div>
                                    <div class="calenderauditee">
                                        <input type="text" id="open_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="open_date"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            class="hide-input" oninput="handleDateInput(this, 'open_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"> (parent) CTL Audit No. </label>
                                    <input type="text" name="audit_nu">
                                </div>
                            </div>

                            {{-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"> Record Number </label>
                                    <input disabled type="text" name="record" id="record"
                                        value="/AT/{{ date('y') }}/{{ $data }}">

                                </div>
                            </div> --}}

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"> (parent) Audit Report Ref. No. </label>
                                    <input type="text" name="audit_report_nu">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"> (parent) Name of Contract Testing Lab </label>
                                    <input type="text" name="name_contract_testing">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"> (parent) Final Responce Received on </label>
                                    <input type="text" name="final_responce_on">
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"> (parent) TCD For CAPA Implimention </label>
                                    <input type="text" name="tcd_capa_implimention">
                                </div>
                            </div>

                            <div class="sub-head">General Information</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Record Number</b></label>
                                    <input disabled type="text" name="record"
                                        value="{{ Helpers::getDivisionName(session()->get('division')) }}/CI/{{ date('Y') }}/{{ $record }}">
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

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Initiator Group Code"> Initiator </label>
                                    <input disabled type="text" name="initiator_id" value="{{ Auth::user()->name }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"> Date of Opened </label>
                                    <input disabled type="text" value="{{ date('d-M-Y') }}" name="date_opened">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" name="date_opened">
                                </div>
                            </div>

                            {{-- <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description</label>
                                    <textarea name="short_description" id="docname" type="text"  maxlength="255" ></textarea>
                                    <input type="text" name="short_description">
                                </div>
                            </div> --}}
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span
                                            class="text-danger">*</span></label><span id="rchars">255</span>
                                    characters remaining
                                    <input id="docname" type="text" name="short_description" maxlength="255"
                                        required>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Classification</label>
                                    <select name="classification" id="">
                                        <option value="">Select Classification</option>
                                        <option value="Classification 1">Classification 1</option>
                                        <option value="Classification 2">Classification 2</option>
                                    </select>
                                </div>
                            </div>

                            {{-- <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Initiator Group">TCD For Clouser Of Audit Task</label>
                                    <input type="text" name="closure_of_task">
                                </div>
                            </div> --}}
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="TCD For Clouser Of Audit Task"> TCD For Clouser Of Audit Task </label>
                                    <input type="text" id="closure_of_task" readonly placeholder="DD-MMM-YYYY"
                                        value="{{ \Carbon\Carbon::parse($closure_of_task)->format('d-M-Y') }}" />
                                    <input type="hidden" name="closure_of_task" id="closure_of_task_input"
                                        value="{{ $closure_of_task }}" />

                                    {{-- <input type="hidden" value="{{ $due_date }}" name="due_date">
                                        <input disabled type="text" value="{{ Helpers::getdateFormat($due_date) }}"> --}}
                                    {{-- <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            value="" name="due_date"> --}}
                                </div>

                            </div>



                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Initiator Group Code"> Assignee </label>
                                    <select id="select-state" placeholder="Select..." name="assignee">
                                        <option value="">Select a value</option>
                                        @foreach ($users as $value)
                                            <option value="{{ $value->name }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>


                            {{-- <div class="col-6">
                                <div class="group-input">
                                    <label for="Short Description">TimeLine Proposed By Auditee</label>
                                    <input type="date" name="timeline_by_auditee"></input>
                                </div>
                            </div> --}}
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">(Parent) Date Opened</label>
                                    <div>
                                    </div>
                                    <div class="calenderauditee">
                                        <input type="text" id="timeline_by_auditee" readonly
                                            placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="timeline_by_auditee"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            class="hide-input" oninput="handleDateInput(this, 'timeline_by_auditee')" />
                                    </div>
                                </div>
                            </div>



                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Initiator Group">Observation</label>
                                    <textarea class="summernote" name="observation"></textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Complience Details</label>
                                    <textarea class="summernote" name="complience_details"></textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Identified Reasons/ Root cause</label>
                                    <textarea class="summernote" name="identified_reasons"></textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Capa Taken/ Resposed</label>
                                    <textarea class="summernote" name="capa_respond"></textarea>
                                </div>
                            </div>


                            {{-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="closure attachment">Audit Attachment </label>
                                    <div><small class="text-primary">
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="audit_task_attach"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="audit_task_attach[]"
                                                oninput="addMultipleFiles(this, 'audit_task_attach')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Inv Attachments">Audit Attachment</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="audit_task_attach"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="audit_task_attach[]"
                                                oninput="addMultipleFiles(this, 'audit_task_attach')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <!-- <button type="button" class="backButton" onclick="previousStep()">Back</button> -->
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Compliance Verification -->
                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="sub-head">Compliance Verification </div>
                        <div class="row">

                            <div class="col-lg-12 mb-4">
                                <div class="group-input">
                                    <label for="Audit Schedule Start Date"> Compliance Execution Details </label>
                                    <div class="col-md-12 4">
                                        <div class="group-input">
                                            <!-- <label for="Description Deviation">Description of Deviation</label> -->
                                            <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                                            <textarea class="summernote" name="compliance_details" id="summernote-1">
                                    </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit Schedule End Date">Date Of Implementation</label>
                                    <input type="date" name="date_of_implemetation" id="">
                                </div>
                            </div> --}}
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Date Of Implementation</label>
                                    <div>
                                    </div>
                                    <div class="calenderauditee">
                                        <input type="text" id="date_of_implemetation" readonly
                                            placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="date_of_implemetation"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            class="hide-input" oninput="handleDateInput(this, 'date_of_implemetation')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <div class="group-input">
                                    <label for="Description Deviation">Verification Comments</label>
                                    <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                                    <textarea class="summernote" name="verification_comments" id="summernote-1">
                                    </textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="group-input">
                                    <label for="Description Deviation">Dealy Justification for Implementation</label>
                                    <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                                    <textarea class="summernote" name="dealy_justification_for_implementation" id="summernote-1">
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Product/Material Name">Delay Just For Task Closure</label>
                                    <textarea class="summernote" name="delay_just_closure" id="summernote-1">
                                </textarea>
                                </div>
                            </div>


                            {{-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="followUp ">Follow-Up Task Required</label>
                                    <select name="followup_task">
                                        <option>Enter Your Selection Here</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Follow-Up Task Required">Follow-Up Task Required</label>
                                    <select name="followup_task" onchange="">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="yes">yes</option>
                                        <option value="no">yes</option>

                                    </select>
                                </div>
                            </div>

                            {{-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Product/Material Name"> Ref. No. Of Follow-Up Task</label>
                                    <select name="ref_of_followup">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="Task 1">Task 1</option>
                                        <option value="Task 2">Task 2</option>

                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Ref. No. Of Follow-Up Task"> Ref. No. Of Follow-Up Task </label>
                                    <input type="text" name="ref_of_followup"value="">
                                </div>
                            </div>



                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Audit Attachments">Execution Attachments</label>
                                    <small class="text-primary">
                                        Please Attach all relevant or supporting documents
                                    </small>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="exe_attechment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="exe_attechment[]"
                                                oninput="addMultipleFiles(this, 'exe_attechment')" multiple>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Audit Attachments">Verification Attachments</label>
                                    <small class="text-primary">
                                        Please Attach all relevant or supporting documents
                                    </small>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="verification_attechment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="verification_attechment[]"
                                                oninput="addMultipleFiles(this, 'verification_attechment')" multiple>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" id="ChangeNextButton" class="nextButton"
                                    onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                </div>

        </div>


        <!----- Signature ----->

        <div id="CCForm17" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="sub-head">
                    Activity Log
                </div>
                <div class="row">

                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="Initiator Group">Submit By : </label>
                            <div class="static"></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="Initiator Group">static On : </label>
                            <div class="static"> </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="Initiator Group">Comments : </label>
                            <div class="static"> </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="cancelled by">More Info from Open By :</label>
                            <div class="static"> </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="cancelled on">More Info from Open On :</label>
                            <div class="static"></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="cancelled on">Comments :</label>
                            <div class="static"></div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="Initiator Group">Compliance Verification Complete By : </label>
                            <div class="static"></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="Initiator Group">Compliance Verification Complete On: </label>
                            <div class="static"> </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="cancelled on">Comments :</label>
                            <div class="static"></div>
                        </div>
                    </div>

                    <!-- ====================================================================== -->


                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="cancelled by">Cancelled By :</label>
                            <div class="static"> </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="cancelled on">Cancelled On :</label>
                            <div class="static"></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="group-input">
                            <label for="cancelled on">Comments :</label>
                            <div class="static"></div>
                        </div>
                    </div>

                </div>
                <div class="button-block">
                    {{-- <button type="submit" id="ChangesaveButton" class="saveButton">Save</button> --}}
                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                    {{-- <button type="button" id="ChangeNextButton" class="nextButton" onclick="nextStep()">Next</button> --}}
                    <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                            Exit </a> </button>
                </div>
            </div>
        </div>
        </form>
    </div>
    </div>


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
        VirtualSelect.init({
            ele: '#facility_name, #group_name, #auditee, #audit_team'
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
