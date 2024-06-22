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
            / Compliance Task
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
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Under Compliance Initiation</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Compliance Implementation</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Compliance Implementation Rev.</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm17')">Activity Log</button>
            </div>

            <form action="{{ route('actionItem.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div id="step-form">
                    @if (!empty($parent_id))
                        <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                        <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                    @endif
                    <!-- Tab content -->

                    <!-- ============Tab-1 start============ -->
                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">General Information</div>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label>Initiator</label>
                                        <input name="ProductMaterialName" disabled />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label>Date Opened</label>
                                        <input name="Grade/TypeOfWater" type="date" disabled />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label>Target Closure Date</label>
                                        <input name="SampleLocation/Point" type="date" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label>Responsible Department</label>
                                        <input name="Market" type="text" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label>Short Description</label>
                                        <input name="Customer" type="text" />
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label>Assignee<span class="text-danger"></span></label>
                                        <input type="text" />
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label>Supervisor<span class="text-danger"></span></label>
                                        <input type="text" />
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label>Quality Reviewer<span class="text-danger"></span></label>
                                        <input type="text" />
                                    </div>
                                </div>
                                <div class="sub-head">
                                    Parent Record Information
                                </div> <!-- RECORD NUMBER -->
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>(Parent) Date Opened</b></label>
                                        <input type="date" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Short Description">(Parent) Inspection Site/Location ID<span
                                                class="text-danger"></span></label>
                                        <input type="number" placeholder="Enter your selection here">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Short Description">(Parent) Inspected Site & Location ID <span
                                                class="text-danger"></span></label>
                                        <input type="number" placeholder="Enter your selection here">
                                    </div>
                                </div>

                                <div class="col-md-6 ">
                                    <div class="group-input ">
                                        <label for="due-date">(Parent) Regulatory/Customer Audit<span
                                                class="text-danger"></span></label>
                                        <input type="text" />
                                    </div>
                                </div>

                                <div class="col-md-6 ">
                                    <div class="group-input ">
                                        <label for="due-date">(Parent) Name of the Agency/Customer<span
                                                class="text-danger"></span></label>
                                        <input type="text" placeholder="Enter your selection here" />
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Short Description">(Parent) External Audit No. <span
                                                class="text-danger"></span></label>
                                        <input type="text" />
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>(Parent) Timeline For Response</b></label>
                                        <input type="date" disabled>
                                    </div>
                                </div>

                                <div class="sub-head">Observation Details</div>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label>Observation</label>
                                        <textarea name="" id="" cols="30" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label>Classification</label>
                                        <input name="Grade/TypeOfWater" type="text" placeholder="Enter your text" />
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label>Task Description </label>
                                        <textarea name="" id="" cols="30" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="closure attachment">Task Attachment </label>
                                        <div><small class="text-primary">
                                            </small>
                                        </div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="File_Attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="File_Attachment[]"
                                                    oninput="addMultipleFiles(this, 'File_Attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="sub-head">Cancellation</div>


                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label>Cancellation Remarks</label>
                                        <textarea name="" id="" cols="30" rows="3"></textarea>
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


                    <!-- ==============Tab-2 start=============== -->

                    <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="sub-head">
                                Task Execution Details
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="group-input">
                                        <label class="" for="Audit Comments">Task Execution Details</label>
                                        <textarea name="" id="" cols="30" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Short Description"> Root Cause Identified<span
                                                class="text-danger"></span></label>
                                                <textarea name="" id="" cols="30" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Reference Recores">Immediate Action Taken</label>
                                        <textarea name="" id="" cols="30" rows="3"></textarea>
                                    </div>
                                </div>



                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Short Description"> CAPA Taken/Proposed<span
                                                class="text-danger"></span></label>
                                                <textarea name="" id="" cols="30" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Reference Recores"> QMS Document Initiation Req?</label>
                                        <input type="text" name="" id="" placeholder="Enter here">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label class="mt-4" for="Audit Comments">Selection Of QMS Document</label>
                                        <select multiple id="reference_record" name="Reference_record[]" id="">
                                            <option value=""> Enter Your Selection Here</option>
                                            <option value="">1</option>
                                            <option value="">2</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Short Description">Refference QMS Document No.<span
                                                class="text-danger"></span></label>
                                        <input type="number" name="" id="">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Short Description">Action Task Required<span
                                                class="text-danger"></span></label>
                                        <input type="text" name="" id=""
                                            placeholder="Enter text here">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Reference Recores"> Action Task Refference No.</label>
                                        <input type="text" name="" id="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Short Description">Completion Effective Date<span
                                                class="text-danger"></span></label>
                                        <input type="date" name="date" id="date">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="closure attachment">Compliance Attachment </label>
                                        <div><small class="text-primary">
                                            </small>
                                        </div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="File_Attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="File_Attachment[]"
                                                    oninput="addMultipleFiles(this, 'File_Attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Reference Recores"> Proposed Timeline</label>
                                        <input type="date" name="" id="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Short Description">Delay Justification<span
                                                class="text-danger"></span></label>
                                                <textarea name="" id="" cols="30" rows="3"></textarea>
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

                    <!-- ==============Tab-3 start=============== -->
                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">

                                <div class="col-6">
                                    <div class="group-input">
                                        <label class="" for="Audit Comments">Implementation Comments</label>
                                        <textarea name="" id="" cols="30" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label>Identified Reasons/Root Cause <span class="text-danger"></span></label>
                                        <textarea name="" id="" cols="30" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label> CAPA Taken<span class="text-danger"></span></label>
                                        <textarea name="" id="" cols="30" rows="3"></textarea>
                                    </div>
                                </div>


                                <div class="col-6">
                                    <div class="group-input">
                                        <label class="" for="Audit Comments">Refference QMS Document No.</label>
                                        <input type="number" name="" id="">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="closure attachment">Implementation Attachment </label>
                                        <div><small class="text-primary">
                                            </small>
                                        </div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="File_Attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="File_Attachment[]"
                                                    oninput="addMultipleFiles(this, 'File_Attachment')" multiple>
                                            </div>
                                        </div>
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
                    <!-- ==============Tab-4 start=============== -->
                    <div id="CCForm4" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">

                                <div class="col-12">
                                    <div class="group-input">
                                        <label class="mt-4">Verification Comments</label>
                                        <textarea name="" id="" cols="30" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="closure attachment">Verification Attachment </label>
                                        <div><small class="text-primary">
                                            </small>
                                        </div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="File_Attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="File_Attachment[]"
                                                    oninput="addMultipleFiles(this, 'File_Attachment')" multiple>
                                            </div>
                                        </div>
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

                    <!-- ==============Tab-17 start=============== -->

                    <div id="CCForm17" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">General Information</div>
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
                                        <label for="Reviewed by">(Parent) Audit/Inspection Started On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Approved on">(Parent) Audit/Inspection Completed On</label>
                                        <div class="Date"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Reviewed by">Compliance Task Submit By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Approved on">Compliance Task Submit On</label>
                                        <div class="Date"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Reviewed by">Task Cancellation By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Approved on">Task Cancellation On</label>
                                        <div class="Date"></div>
                                    </div>
                                </div>

                                <div class="sub-head">Under Compliance Initiation</div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Approved on">Compliance Task Completed By</label>
                                        <div class="Date"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Approved on">Compliance Task Completed On</label>
                                        <div class="Date"></div>
                                    </div>
                                </div>

                                <div class="sub-head mt-3">Compliance Implementation</div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Reviewed by">Compliance Implementation By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Approved on">Compliance Implementation On</label>
                                        <div class="Date"></div>
                                    </div>
                                </div>

                                <div class="sub-head">Compliance Implementation Rev.</div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Reviewed by">Implementation Review Done By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Approved on">Implementation Review Done On</label>
                                        <div class="Date"></div>
                                    </div>
                                </div>


                                <div class="button-block">
                                    <button type="submit" class="saveButton">Save</button>
                                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                    <button type="button"> <a class="text-white"
                                            href="{{ url('rcms/qms-dashboard') }}">Exit
                                        </a> </button>
                                </div>
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
        $(document).ready(function() {
            $('#summaryadd').click(function(e) {
                function generateTableRow(serialNumber) {


                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="OOTNo[]"></td>' +
                        '<td><input type="text" name="OOTReportedDate[]"></td>' +
                        '<td><input type="text" name="DescriptionOfOOT[]"></td>' +
                        '<td><input type="text" name="previousIntervalDetails[]"></td>' +
                        '<td><input type="text" name="CAPA[]"></td>' +
                        '<td><input type="text" name="ClosureDateOfCAPA[]"></td>' +
                        '</tr>';
                    '</tr>';

                    return html;
                }

                var tableBody = $('#summary_table_details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#infoadd').click(function(e) {
                function generateTableRow(serialNumber) {


                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="Item/ProductCode[]"></td>' +
                        '<td><input type="text" name="Lot/BatchNo[]"></td>' +
                        ' <td><input type="text" name="A.R.Number[]"></td>' +
                        '<td><input type="text" name="MfgDate[]"></td>' +
                        '<td><input type="text" name="ExpiryDate[]"></td>' +
                        '<td><input type="text" name="LabelClaim[]"></td>' +
                        '</tr>';
                    '</tr>';

                    return html;
                }

                var tableBody = $('#info_details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#Details').click(function(e) {
                function generateTableRow(serialNumber) {


                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="ARNumber[]"></td>' +
                        '<td><input type="text" name="Condition:Temprature&RH[]"></td>' +
                        '<td><input type="text" name="Interval[]"></td>' +
                        '<td><input type="text" name="Orientation[]"></td>' +
                        '<td><input type="text" name="PackDetails[]"></td>' +
                        '</tr>';
                    '</tr>';

                    return html;
                }

                var tableBody = $('#Details-Table tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#ootadd').click(function(e) {
                function generateTableRow(serialNumber) {


                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        ' <td><input type="text" name="ARNumber[]"></td>' +
                        '   <td><input type="text" name="TestNameOfOOT[]"></td>' +
                        '<td><input type="text" name="ResultObtained[]"></td>' +
                        '<td><input type="text" name="InitialIntervalDetails[]"></td>' +
                        '<td><input type="text" name="previousIntervalDetails[]"></td>' +
                        '<td><input type="text" name="DifferenceOfResults[]"></td>' +
                        '<td><input type="text" name="TrendLimit[]"></td>' +
                        '</tr>';
                    '</tr>';

                    return html;
                }

                var tableBody = $('#oot_table_details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#sumarryOfOotAdd').click(function(e) {
                function generateTableRow(serialNumber) {


                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="InitialAnalysis[]"></td>' +
                        '<td><input type="text" name="ResultFromPhaseIInvestigation[]"></td>' +
                        '<td><input type="text" name="RetestingResultsAfterCorrectionOfAssignableCause[]"></td>' +
                        '<td><input type="text" name="Hypothesis/ExperimentationResults[]"></td>' +
                        '<td><input type="text" name="ResultOfadditionalTessting[]"></td>' +
                        '<td><input type="text" name="HypothesisExperimentReference/AdditionalTestingReferenceNo[]"></td>' +
                        '<td><input type="text" name="Results[]"></td>' +
                        '<td><input type="text" name="AnalystName[]"></td>' +
                        '<td><input type="text" name="Remarks[]"></td>' +
                        '</tr>';
                    '</tr>';

                    return html;
                }

                var tableBody = $('#sumarryOfOotAddDetails-Table tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#impactedAdd').click(function(e) {
                function generateTableRow(serialNumber) {


                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="Material/ProductName[]"></td>' +
                        '<td><input type="text" name="BatchNO[]"></td>' +
                        '<td><input type="text" name="AnyOtherInformation[]"></td>' +
                        '<td><input type="text" name="ActionTakenOnAffectedBatch[]"></td>' +
                        '</tr>';
                    '</tr>';

                    return html;
                }

                var tableBody = $('#impacted-Table tbody');
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
