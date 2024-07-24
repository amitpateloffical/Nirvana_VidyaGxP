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

<script>
    $(document).ready(function() {
        $('#ReferenceDocument').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +


                    '<td><input type="date" name="Date[]"></td>' +



                    //     '</tr>';

                    // for (var i = 0; i < users.length; i++) {
                    //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    // }

                    // html += '</select></td>' + 

                    '</tr>';

                return html;
            }

            var tableBody = $('#ReferenceDocument_details tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>

<div class="form-field-head">
    {{-- <div class="pr-id">
            New Child
        </div> --}}
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        / RT-Dossier Documents
    </div>
</div>

{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">
    @include('frontend.Registration-Tracking.dosier-documents.stage')

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Dossier Documents</button>
            <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Local Information</button> -->
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Signatures</button>
            <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Signatures</button> -->

        </div>
        <form action="{{ route('dosierdocuments.update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div id="step-form">
                @if (!empty($parent_id))
                <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                @endif
                <!-- Dossier Documents-->
                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="sub-head">
                            General Information
                        </div> <!-- RECORD NUMBER -->
                        <div class="row">
                        <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator"> Record Number </label>
                            <input disabled type="text" name="record_number"
                            value="{{ Helpers::getDivisionName($data->division_id) }}/OOS Chemical/{{ Helpers::year($data->created_at) }}/{{ $data->record_number ? str_pad($data->record_number, 4, "0", STR_PAD_LEFT ) : '1' }}">
                                                    
                        </div>
                       </div>
                       <div class="col-lg-6">
                            <div class="group-input">
                                <label disabled for="Division Code">Division Code<span
                                        class="text-danger"></span></label>
                                <input disabled type="text" name="division_code"
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Short Description">Initiator <span class="text-danger"></span></label>
                                <input type="hidden" name="initiator_id" value="{{ Auth::user()->id }}">
                                <input disabled type="text" name="initiator"
                                        value="{{ Auth::user()->name }}">
                            </div>
                        </div>
                        <div class="col-md-6 ">
                        <div class="group-input ">
                            <label for="due-date"> Date Of Initiation<span class="text-danger"></span></label>
                            <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                            <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                            </div>
                        </div>
                        <div class="col-md-6 pt-3">
                            <div class="group-input">
                                <label for="Short Description">Short Description<span class="text-danger">*</span>
                                    <p>255 characters remaining </p>
                                    <textarea id="docname" maxlength="255" name="short_description" required>{{ $data->short_description }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="assign to"> Assigned To</label>
                                <select name="assign_to" >
                                    <option>Enter Your Selection Here</option>
                                    <option value="User1" {{ $data->assign_to == 'User1' ? 'selected' :
                                        '' }}>User1</option>
                                    <option value="User2" {{ $data->assign_to == 'User2' ? 'selected' :
                                        '' }}>User2</option>
                                    <option value="User3" {{ $data->assign_to == 'User3' ? 'selected' :
                                    '' }}>User3</option>
                                </select>
                            </div>
                            </div>
                            <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Initiator"> Due Date
                                </label>
                                <small class="text-primary">
                                    Please mention expected date of completion
                                </small>
                                <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" 
                                class="hide-input" oninput="handleDateInput(this, 'due_date')" value="{{ $data->due_date ?? '' }}"/>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Reference Recores">Dosier Documents Type</label>
                                <select id="dosier_documents_type" name="dosier_documents_type" id="">
                                    <option value="">--Select---</option>
                                    <option value="1" {{ $data->dosier_documents_type == '1' ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ $data->dosier_documents_type == '2' ? 'selected' : '' }}>2</option>
                                </select>
                            </div>
                        </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Document Language</b></label>
                                    <select id="select-state" name="document_language">
                                        <option value="">Select a value</option>
                                        <option value="1" {{ $data->document_language == '1' ? 'selected' : '' }}>1</option>
                                        <option value="2" {{ $data->document_language == '2' ? 'selected' : '' }}>2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 pt-3">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Documents</b></label>
                                    <input type="text" name="documents" value="{{$data->documents}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Initiator Group">File Attachment</label>
                                <small class="text-primary">
                                    Please Attach all relevant or supporting documents
                                </small>
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="file_attachments_pli">
                                        @if ($data->file_attachments_pli)
                                        @foreach (json_decode($data->file_attachments_pli) as $file)
                                        <h6 type="button" class="file-container text-dark"
                                            style="background-color: rgb(243, 242, 240);">
                                            <b>{{ $file }}</b>
                                <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                        class="fa fa-eye text-primary"
                                        style="font-size:20px; margin-right:-10px;"></i></a>
                                <a type="button" class="remove-file" data-file-name="{{ $file }}"><i
                                        class="fa-solid fa-circle-xmark"
                                        style="color:red; font-size:20px;"></i></a>
                            </h6>
                            @endforeach
                            @endif
                        </div>
                        <div class="add-btn">
                            <div>Add</div>
                            <input type="file" id="file_attachments_pli" name="file_attachments_pli[]" 
                            oninput="addMultipleFiles(this, 'file_attachments_pli')"
                                multiple>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="group-input">
                    <label for="Responsible Department">Dossier Parts</label>
                    <select name="dossier_parts">
                        <option value="">Enter Your Selection Here</option>
                        <option value="1" {{ $data->dossier_parts == '1' ? 'selected' : '' }}>1</option>
                        <option value="2" {{ $data->dossier_parts == '2' ? 'selected' : '' }}>2</option>
                    </select>
                </div>
            </div>
            <div class="sub-head pt-3 pb-2">Product Information</div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Responsible Department">(Root Parent) Manufacture</label>
                            <select name="root_parent_manufacture">
                                <option value="">Enter Your Selection Here</option>
                                <option value="1" {{ $data->root_parent_manufacture == '1' ? 'selected' : '' }}>1</option>
                                <option value="2" {{ $data->root_parent_manufacture == '2' ? 'selected' : '' }}>2</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="RLS Record Number">(Root Parent) Product Code</label>
                            <input type="text" name="root_parent_product_code" value="{{ $data->root_parent_product_code }}">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Responsible Department">(Root Parent) Trade Name</label>
                            <select name="root_parent_trade_name">
                                <option value="">Enter Your Selection Here</option>
                                <option value="1" {{ $data->root_parent_trade_name == '1' ? 'selected' : '' }}>1</option>
                                <option value="2" {{ $data->root_parent_trade_name == '2' ? 'selected' : '' }}>2</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Responsible Department">(Root Parent) Therapeutic Area</label>
                            <select name="root_parent_therapeutic_area">
                                <option value="">Enter Your Selection Here</option>
                                <option value="1" {{ $data->root_parent_therapeutic_area == '1' ? 'selected' : '' }}>1</option>
                                <option value="2" {{ $data->root_parent_therapeutic_area == '2' ? 'selected' : '' }}>2</option>
                            </select>
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
        <!-- Local Information -->
                  
                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <!-- <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="start_date">Scheduled start Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="start_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="start_date_checkdate" name="start_date" class="hide-input" oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="start_date">Scheduled end Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="start_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="start_date_checkdate" name="start_date" class="hide-input" oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Assigned To</b></label>
                                    <p class="text-primary">Person responsible</p>
                                    <input type="text" name="record_number" value="">

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label  for="RLS Record Number"><b>CRO/Vendor</b></label>

                                    <input type="text" name="record_number" value="">

                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="start_date">Date response due</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="start_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="start_date_checkdate" name="start_date" class="hide-input" oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>
                                </div>
                            </div> -->




                       




                        <!-- <div class="group-input">
                            <label for="audit-agenda-grid">
                                Financial Transaction (0)
                                <button type="button" name="audit-agenda-grid" id="ReferenceDocument">+</button>
                                <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                    (open)
                                </span>
                            </label>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="ReferenceDocument_details" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 4%">Row#</th>

                                            <th style="width: 16%">Date</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input disabled type="text" name="serial[]" value="1"></td>

                                            <td><input type="date" name="Date[]"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actions">Co-Auditors <span class="text-danger"></span></label>
                                    <textarea name="description"></textarea>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actions">Distribution List <span class="text-danger"></span></label>
                                    <textarea name="description"></textarea>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actions">Scope <span class="text-danger"></span></label>
                                    <textarea name="description"></textarea>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actions">Comments <span class="text-danger"></span></label>
                                    <textarea name="description"></textarea>
                                </div>
                            </div>

                        </div> -->

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




                






                    <!-- --------Signatures---------- -->


                    <div id="CCForm3" class="inner-block cctabcontent">
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
                                        <label for="cancelled by">Plan Approved By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="cancelled on">Plan Approved On</label>
                                        <div class="Date"></div>
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
        $('#Witness_details').click(function(e) {
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

            var tableBody = $('#Witness_details_details tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#MaterialsReleased').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '</tr>';

                return html;
            }

            var tableBody = $('#MaterialsReleased-field-table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#RootCause').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '</tr>';

                return html;
            }

            var tableBody = $('#RootCause-field-instruction-modal tbody');
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