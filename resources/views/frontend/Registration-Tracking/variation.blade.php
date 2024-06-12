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
        / Variation
    </div>
</div>



{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Variation</button>
            <button class="cctablinks " onclick="openCity(event, 'CCForm2')">Variation Plan</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Product Details</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Registration Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Signatures</button>

        </div>

        <form action="{{ route('variation-store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div id="step-form">
                @if (!empty($parent_id))
                <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                @endif
                @php
                    $users = DB::table('users')->get();
                @endphp
                <!-- Tab-1 -->

                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">General Information</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="trade_name"><b>(Root Parent) Trade Name</b></label>
                                    <input type="text" name="trade_name" value="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="member_state">
                                        (Parent) Member State <span class="text-danger"></span>
                                    </label>
                                    <select id="member_state" placeholder="Select..." name="member_state">
                                        <option value="">Select a value</option>
                                        <option value="MP">MP</option>
                                        <option value="UP">UP</option>
                                        <option value="GJ">GJ</option>
                                    </select>

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="initiator"><b>Initiator</b></label>
                                    <input disabled type="text" name="initiator" value="{{ Auth::user()->name }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input ">
                                    <label for="date_of_initiationDue"><b>Date of Initiation</b></label>
                                    <input readonly type="text" value="{{ date('d-M-Y') }}" name="date_of_initiation">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" name="date_of_initiation">
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="group-input">
                                    <label for="short_description">Short Description<span class="text-danger">*</span></label>
                                    <p>255 characters remaining</p>
                                    <input id="docname" type="text" name="short_description" maxlength="255" required>
                                </div>
                            </div>

                            <div class="col-md-6 pt-3">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To <span class="text-danger">*</span>
                                    </label>
                                    <select required id="assigned_to" placeholder="Select..." name="assigned_to">
                                        <option value="">--Select--</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="date_due">Date Due <span class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please mention expected date of completion</small></div>

                                    <div class="calenderauditee">
                                        <input type="text" required id="date_due" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" required name="date_due" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'date_due')" />
                                    </div>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="type">Type</label>
                                    <select id="type" name="type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="T-1">T-1</option>
                                        <option value="T-2">T-2</option>
                                        <option value="T-3">T-3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="related_change_control"> Related Change Control</label>
                                    <select  id="related_change_control" name="related_change_control">
                                        <option value="">--Select---</option>
                                        <option value="RCC-1">RCC-1</option>
                                        <option value="RCC-2">RCC-2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments">Variation Description</label>
                                    <input type="text" name="variation_description" value="">
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="variation_code">Variation Code</label>
                                    <select name="variation_code">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="P-1">P-1</option>
                                        <option value="P-2">P-2</option>
                                        <option value="P-3">P-3</option>
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
                                        <div class="file-attachment-list" id="attached_files"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="attached_files[]" oninput="addMultipleFiles(this, 'attached_files')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="change_from"><b>Change From</b></label>
                                    <input type="text" name="change_from" value="">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="change_to"><b>Change To</b></label>
                                    <input type="text" name="change_to" value="">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="description">Description<span class="text-danger"></span></label>
                                    <textarea placeholder="" name="description"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="documents"><b>Documents</b></label>
                                    <input type="text" name="documents" value="">
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

                <!-- Tab-2 -->
                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">Registration Plan</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Registration Status </label>
                                    <select disabled name="Type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">Done</option>
                                        <option value="2">Progress</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Registration Number</label>
                                    <input disabled type="text">
                                </div>
                            </div>

                            <div class="sub-head">Important Date</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Planned Submission Date</label>
                                    <input disabled type="date" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Actual Submission Date</label>
                                    <input disabled type="date" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Planned Approval Date</label>
                                    <input disabled type="date" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Actual Approval Date</label>
                                    <input disabled type="date" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Actual Withdrawn Date</label>
                                    <input disabled type="date" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Actual Rejection Date</label>
                                    <input disabled type="date" />
                                </div>
                            </div>




                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Actions">Comments<span class="text-danger"></span></label>
                                    <textarea disabled placeholder="" name="description"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reference Recores"> Related Countries</label>
                                    <select disabled multiple id="reference_record" name="PhaseIIQCReviewProposedBy[]" id="">
                                        <option value="">--Select---</option>
                                        <option value="">India</option>
                                        <option value="">UsA</option>
                                    </select>
                                </div>
                            </div>

                            <div class="button-block">
                                <button disabled type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>

                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>

                                <button  type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                                    </a> </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tab-3 -->

                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">(Root Parent ) Trade Name</label>
                                    <input disabled type="text" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">(Parent) Local Trade Name</label>
                                    <input disabled type="text" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">(Parent) Manufacturer </label>
                                    <input disabled type="text" />
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Packaging Information (0)
                                    <button disabled type="button" name="audit-agenda-grid" id="PackagingAdd">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        Open
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Packaging-Table">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Primary Packaging</th>
                                                <th style="width: 14%">Material</th>
                                                <th style="width: 14%">Pack Size. </th>
                                                <th style="width: 14%">Shelf Life</th>
                                                <th style="width: 15%">Storage Condition</th>
                                                <th style="width: 15%">Secondary Packaging</th>
                                                <th style="width: 15%">Remarks</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input disabled type="text" name="packaging[0][serial]" value="1"></td>

                                            <td><input disabled type="text" name="packaging[0][PrimaryPackaging]"></td>
                                            <td><input disabled type="text" name="packaging[0][Material]"></td>
                                            <td><input disabled type="text" name="packaging[0][PackSize]"></td>
                                            <td><input disabled type="text" name="packaging[0][ShelfLife]"></td>
                                            <td><input disabled type="text" name="packaging[0][StorageCondition]"></td>
                                            <td><input disabled type="text" name="packaging[0]SecondaryPackaging]"></td>
                                            <td><input disabled type="text" name="packaging[0][Remarks]"></td>
                                            <td></td>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="button-block">
                                <button disabled type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>

                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>

                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                                    </a> </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tab-4 -->
                <div id="CCForm4" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="button-block">
                                <button disabled type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>

                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>

                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                                    </a> </button>
                            </div>


                            <!-- <div class="button-block">
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                                    </a> </button>
                            </div> -->
                        </div>
                    </div>
                </div>
                <!-- Tab-5 -->
                <div id="CCForm5" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Actual_Amount ">Started by :</label>
                                    <div class="static"></div>

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">

                                    <label for="Division Code"><b>Started on :</b></label>
                                    <div class="date"></div>



                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Actual_Amount ">Submitted by :</label>
                                    <div class="static"></div>

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">

                                    <label for="Division Code"><b>Submitted on :</b></label>
                                    <div class="date"></div>




                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Actual_Amount ">Approved by :</label>
                                    <div class="static"></div>

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">

                                    <label for="Division Code"><b>Approved on :</b></label>
                                    <div class="date"></div>

                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Actual_Amount ">Withdrawn by :</label>
                                    <div class="static"></div>

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">

                                    <label for="Division Code"><b>Withdrawn on :</b></label>
                                    <div class="date"></div>




                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Actual_Amount ">Refused by :</label>
                                    <div class="static"></div>

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">

                                    <label for="Division Code"><b>Refused on :</b></label>
                                    <div class="date"></div>




                                </div>
                            </div>



                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>

                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                    Exit </a> </button>
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
        $('#PackagingAdd').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="packaging[' + serialNumber +
                        '][serial]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="packaging[' + serialNumber +
                        '][PrimaryPackaging]"></td>' +
                    '<td><input type="text" name="packaging[' + serialNumber +
                        '][Material]"></td>' +
                    '<td><input type="text" name="packaging[' + serialNumber +
                        '][PackSize]"></td>' +
                    '<td><input type="text" name="packaging[' + serialNumber +
                        '][ShelfLife]"></td>' +
                    '<td><input type="text" name="packaging[' + serialNumber +
                        '][StorageCondition]"></td>' +
                    '<td><input type="text" name="packaging[' + serialNumber +
                        '][SecondaryPackaging]"></td>' +
                    '<td><input type="text" name="packaging[' + serialNumber +
                        '][Remarks]"></td>' +
                    '</tr>';
                '</tr>';

                return html;
            }

            var tableBody = $('#Packaging-Table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
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
    var maxLength = 255;
    $('#docname').keyup(function() {
        var textlen = maxLength - $(this).val().length;
        $('#rchars').text(textlen);
    });
</script>
@endsection
