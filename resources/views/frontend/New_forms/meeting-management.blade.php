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
            {{ Helpers::getDivisionName(session()->get('division')) }} / Meeting Management
        </div>
    </div>

    {{-- ! ========================================= --}}
    {{-- !               DATA FIELDS                 --}}
    {{-- ! ========================================= --}}
    <div id="change-control-fields">
        <div class="container-fluid">

            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Operational Planning & Control</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Meetings & Summary</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Closure</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Signatures</button>
            </div>

            <form action="{{ route('meeting_management_store') }}" method="POST" enctype="multipart/form-data">
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
                                    General Information
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="RLS Record Number"><b>Record Number</b></label>
                                            <input disabled type="text" name="record_number"
                                                value="{{ Helpers::getDivisionName(session()->get('division')) }}/MM/{{ date('Y') }}/{{ $record_number }}">
                                            {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Division Code"><b>Site/Location Code</b></label>
                                            <input disabled type="text" name="division_code"
                                                value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                            <input type="hidden" name="division_id"
                                                value="{{ session()->get('division') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Initiator">Initiator</label>
                                            <input disabled type="text" name="initiator"
                                                value="{{ Auth::user()->name }}" />
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-6">
                                        <div class="group-input ">
                                            <label for="Date Due"><b>Date of Initiation</b></label>
                                            <input disabled type="text" value="{{ date('d-M-Y') }}"
                                                name="intiation_date">
                                            <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                        </div>
                                    </div> --}}

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Date Opened">Date of Initiation</label>
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

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="If Others">Assigned To</label>
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

                                    {{-- <div class="col-md-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="due-date">Date Due</label>
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
                                    </div> --}}
                                    <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Date Due">Date Due</label>
                                            <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY"
                                                value="{{ \Carbon\Carbon::parse($due_date)->format('d-M-Y') }}" />
                                            <input type="hidden" name="due_date" id="due_date_input"
                                                value="{{ $due_date }}" />



                                            {{-- <input type="hidden" value="{{ $due_date }}" name="due_date">
                                        <input disabled type="text" value="{{ Helpers::getdateFormat($due_date) }}"> --}}
                                            {{-- <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            value="" name="due_date"> --}}
                                        </div>

                                    </div>
                                    {{-- <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Initiator Group"><b>Initiator Group</b></label>
                                            <select name="initiator_group" id="initiator_group">
                                                <option value="">-- Select --</option>
                                                <option value="CQA" @if (old('initiator_group') == 'CQA') selected @endif>
                                                    Corporate Quality Assurance</option>
                                                <option value="QAB" @if (old('initiator_group') == 'QAB') selected @endif>
                                                    Quality
                                                    Assurance Biopharma</option>
                                                <option value="CQC" @if (old('initiator_group') == 'CQA') selected @endif>
                                                    Central
                                                    Quality Control</option>
                                                <option value="MANU" @if (old('initiator_group') == 'MANU') selected @endif>
                                                    Manufacturing</option>
                                                <option value="PSG" @if (old('initiator_group') == 'PSG') selected @endif>
                                                    Plasma
                                                    Sourcing Group</option>
                                                <option value="CS" @if (old('initiator_group') == 'CS') selected @endif>
                                                    Central
                                                    Stores</option>
                                                <option value="ITG" @if (old('initiator_group') == 'ITG') selected @endif>
                                                    Information Technology Group</option>
                                                <option value="MM" @if (old('initiator_group') == 'MM') selected @endif>
                                                    Molecular Medicine</option>
                                                <option value="CL" @if (old('initiator_group') == 'CL') selected @endif>
                                                    Central
                                                    Laboratory</option>

                                                <option value="TT" @if (old('initiator_group') == 'TT') selected @endif>
                                                    Tech
                                                    team</option>
                                                <option value="QA" @if (old('initiator_group') == 'QA') selected @endif>
                                                    Quality Assurance</option>
                                                <option value="QM" @if (old('initiator_group') == 'QM') selected @endif>
                                                    Quality Management</option>
                                                <option value="IA" @if (old('initiator_group') == 'IA') selected @endif>
                                                    IT
                                                    Administration</option>
                                                <option value="ACC" @if (old('initiator_group') == 'ACC') selected @endif>
                                                    Accounting</option>
                                                <option value="LOG" @if (old('initiator_group') == 'LOG') selected @endif>
                                                    Logistics</option>
                                                <option value="SM" @if (old('initiator_group') == 'SM') selected @endif>
                                                    Senior Management</option>
                                                <option value="BA" @if (old('initiator_group') == 'BA') selected @endif>
                                                    Business Administration</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Initiator Group Code">Initiator Group Code</label>
                                            <input type="text" name="initiator_group_code" id="initiator_group_code"
                                                value="" readonly>
                                        </div>
                                    </div> --}}

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Initiator Group"><b>Initiator Department</b></label>
                                            <select name="initiator_group" id="initiator_group">
                                                <option value="" data-code="">-- Select --</option>
                                                <option value="Corporate Quality Assurance" data-code="CQA"
                                                    @if (old('initiator_group') == 'Corporate Quality Assurance') selected @endif>Corporate Quality
                                                    Assurance</option>
                                                <option value="Quality Assurance Biopharma" data-code="QAB"
                                                    @if (old('initiator_group') == 'Quality Assurance Biopharma') selected @endif>Quality Assurance
                                                    Biopharma</option>
                                                <option value="Central Quality Control" data-code="CQC"
                                                    @if (old('initiator_group') == 'Central Quality Control') selected @endif>Central Quality
                                                    Control
                                                </option>
                                                <option value="Manufacturing" data-code="MANU"
                                                    @if (old('initiator_group') == 'Manufacturing') selected @endif>Manufacturing</option>
                                                <option value="Plasma Sourcing Group" data-code="PSG"
                                                    @if (old('initiator_group') == 'Plasma Sourcing Group') selected @endif>Plasma Sourcing Group
                                                </option>
                                                <option value="Central Stores" data-code="CS"
                                                    @if (old('initiator_group') == 'Central Stores') selected @endif>Central Stores
                                                </option>
                                                <option value="Information Technology Group" data-code="ITG"
                                                    @if (old('initiator_group') == 'Information Technology Group') selected @endif>Information Technology
                                                    Group</option>
                                                <option value="Molecular Medicine" data-code="MM"
                                                    @if (old('initiator_group') == 'Molecular Medicine') selected @endif>Molecular Medicine
                                                </option>
                                                <option value="Central Laboratory" data-code="CL"
                                                    @if (old('initiator_group') == 'Central Laboratory') selected @endif>Central Laboratory
                                                </option>
                                                <option value="Tech team" data-code="TT"
                                                    @if (old('initiator_group') == 'Tech team') selected @endif>Tech team</option>
                                                <option value="Quality Assurance" data-code="QA"
                                                    @if (old('initiator_group') == 'Quality Assurance') selected @endif>Quality Assurance
                                                </option>
                                                <option value="Quality Management" data-code="QM"
                                                    @if (old('initiator_group') == 'Quality Management') selected @endif>Quality Management
                                                </option>
                                                <option value="IT Administration" data-code="IA"
                                                    @if (old('initiator_group') == 'IT Administration') selected @endif>IT Administration
                                                </option>
                                                <option value="Accounting" data-code="ACC"
                                                    @if (old('initiator_group') == 'Accounting') selected @endif>Accounting</option>
                                                <option value="Logistics" data-code="LOG"
                                                    @if (old('initiator_group') == 'Logistics') selected @endif>Logistics</option>
                                                <option value="Senior Management" data-code="SM"
                                                    @if (old('initiator_group') == 'Senior Management') selected @endif>Senior Management
                                                </option>
                                                <option value="Business Administration" data-code="BA"
                                                    @if (old('initiator_group') == 'Business Administration') selected @endif>Business
                                                    Administration
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Initiator Group Code">Department code</label>
                                            <input type="text" name="initiator_group_code" id="initiator_group_code"
                                                value="{{ old('initiator_group_code') }}" readonly>
                                        </div>
                                    </div>

                                    <script>
                                        document.getElementById('initiator_group').addEventListener('change', function() {
                                            var selectedOption = this.options[this.selectedIndex];
                                            var selectedCode = selectedOption.getAttribute('data-code');
                                            document.getElementById('initiator_group_code').value = selectedCode;
                                        });

                                        document.addEventListener('DOMContentLoaded', function() {
                                            var initiatorGroupElement = document.getElementById('initiator_group');
                                            if (initiatorGroupElement.value) {
                                                var selectedOption = initiatorGroupElement.options[initiatorGroupElement.selectedIndex];
                                                var selectedCode = selectedOption.getAttribute('data-code');
                                                document.getElementById('initiator_group_code').value = selectedCode;
                                            }
                                        });
                                    </script>
                                    {{-- <div class="col-12">
                                        <div class="group-input">
                                            <label for="Short Description">Short Description<span
                                                    class="text-danger">*</span></label><span
                                                id="initiator_group_code">255</span>
                                            characters remaining
                                            <input id="initiator_group_code" type="text" name="short_description"
                                                maxlength="255" required>
                                        </div>
                                    </div> --}}
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Short Description">Short Description<span
                                                    class="text-danger">*</span></label><span id="rchars">255</span>
                                            characters remaining
                                            <input id="docname" type="text" name="short_description"
                                                maxlength="255" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="type">Type</label>
                                            <select name="type">
                                                <option value="0">-- Select type --</option>
                                                <option>Other</option>
                                                <option>Training</option>
                                                <option>Finance</option>
                                                <option>Follow Up</option>
                                                <option>Marketing</option>
                                                <option>Sales</option>
                                                <option>Account Service</option>
                                                <option>Recent Product Launch</option>
                                                <option>IT</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Priority Level">Priority Level</label>
                                            <select name="priority_level">
                                                <option value="0">-- Select type --</option>
                                                <option>High</option>
                                                <option>Medium</option>
                                                <option>Low</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Scheduled Start Date">Scheduled Start Date</label>
                                            <div class="calenderauditee">
                                                <input type="text" id="start_date" readonly placeholder="DD-MMM-YYYY"
                                                    value="" />
                                                <input type="date" id="start_date_checkdate" value=""
                                                    name="start_date" min="" class="hide-input"
                                                    oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Audit End Date">Scheduled end date</label>
                                            <div class="calenderauditee">
                                                <input type="text" id="end_date" readonly placeholder="DD-MMM-YYYY"
                                                    value="" />
                                                <input type="date" id="end_date" value="" name="end_date"
                                                    min="" class="hide-input"
                                                    oninput="handleDateInput(this, 'end_date');checkDate('end_date','end_date')" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Attendees">Attendess</label>
                                            <textarea name="attendees"></textarea>
                                        </div>
                                    </div>

                                    <div class="group-input">
                                        <label for="audit-agenda-grid">
                                            Agenda
                                            <button type="button" name="audit-agenda-grid" id="agenda">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#observation-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="agenda-field-instruction-modal">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%">Row#</th>
                                                        <th style="width: 12%">Date</th>
                                                        <th style="width: 16%">Topic</th>
                                                        <th style="width: 16%">Responsible</th>
                                                        <th style="width: 16%">Shelf Life</th>
                                                        <th style="width: 15%">Time Start</th>
                                                        <th style="width: 15%">Time End</th>
                                                        <th style="width: 15%">Comments</th>
                                                        <th style="width: 15%">Remarks</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <td><input disabled type="text" name="agenda[0][serial_number]"
                                                            value="1">
                                                    </td>
                                                    <td>
                                                        <div class="new-date-data-field">
                                                            <div class="group-input input-date">
                                                                <div class="calenderauditee">
                                                                    <input class="click_date" id="date_0_mfg_date"
                                                                        type="text" name="agenda[0][info_mfg_date]"
                                                                        placeholder="DD-MMM-YYYY" />
                                                                    <input type="date" name="agenda[0][info_mfg_date]"
                                                                        min="" id="date_0_mfg_date"
                                                                        class="hide-input show_date"
                                                                        style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                        oninput="handleDateInput(this, 'date_0_mfg_date')" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><input type="text" name="agenda[0][Topic]"></td>
                                                    <td><input type="text" name="agenda[0][Responsible]">
                                                    </td>
                                                    <td><input type="text" name="agenda[0][Shelf_Life]"></td>
                                                    <td><input type="time" name="agenda[0][Time_Start]"
                                                            value=""></td>
                                                    <td><input type="time" name="agenda[0][Time_End]" value="">
                                                    </td>
                                                    <td><input type="text" name="agenda[0][Comments]"></td>
                                                    <td><input type="text" name="agenda[0][Remarker]"></td>
                                                    <td><button type="text" class="removeRowBtn">remove</button>
                                                    </td>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description">Description</label>
                                            characters remaining
                                            <textarea name="description" id="description" type="text"></textarea>
                                        </div>
                                    </div>

                                    <div class="group-input">
                                        <label for="audit-agenda-grid">
                                            Management Review Participants
                                            <button type="button" name="audit-agenda-grid"
                                                id="Management_Review_Participants">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#observation-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered"
                                                id="Management_Review_Participants-field-instruction-modal">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%">Row#</th>
                                                        <th style="width: 12%">Invite Person</th>
                                                        <th style="width: 16%">Designee</th>
                                                        <th style="width: 16%">Department</th>
                                                        <th style="width: 16%">Meeting Attended</th>
                                                        <th style="width: 15%">Designee Name</th>
                                                        <th style="width: 15%">Designee Department/Designation</th>
                                                        <th style="width: 15%">Remarks</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <td><input disabled type="text"
                                                            name="Management_Review_Participants[0][serial_number]"
                                                            value="1">
                                                    </td>
                                                    <td><input type="text"
                                                            name="Management_Review_Participants[0][Invite_Person]">
                                                    </td>
                                                    <td><input type="text"
                                                            name="Management_Review_Participants[0][Designee]">
                                                    </td>
                                                    <td><input type="text"
                                                            name="Management_Review_Participants[0][Department]">
                                                    </td>
                                                    <td><input type="text"
                                                            name="Management_Review_Participants[0][Meeting_Attended]">
                                                    </td>
                                                    <td><input type="text"
                                                            name="Management_Review_Participants[0][Designee_Name]">
                                                    </td>
                                                    <td><input type="text"
                                                            name="Management_Review_Participants[0][Designee_Department_Designation]">
                                                    </td>
                                                    <td><input type="text"
                                                            name="Management_Review_Participants[0][manage_remark]">
                                                    </td>
                                                    <td><button type="text" class="removeBtn">remove</button>
                                                    </td>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>

                                    {{-- <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="file_Attachment">File Attachment</label>
                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="Attached_File"></div>
                                                <div class="add-btn">
                                                    <div>Add</div>
                                                    <input type="file" id="myfile" name="Attached_File[]"
                                                        oninput="addMultipleFiles(this, 'file_attach')" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Inv Attachments">File Attachment</label>
                                            <div><small class="text-primary">Please Attach all relevant or supporting
                                                    documents</small></div>
                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="Attached_File"></div>
                                                <div class="add-btn">
                                                    <div>Add</div>
                                                    <input type="file" id="myfile" name="Attached_File[]"
                                                        oninput="addMultipleFiles(this, 'Attached_File')" multiple>
                                                </div>
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
                                        <label for="Operations">
                                            Operations
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#management-review-production_service_provision-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <textarea name="operations" id="" type="text"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label
                                            for="Requirements for Products
                                            and
                                            Services">
                                            Requirements for Products
                                            and
                                            Services
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#management-review-production_service_provision-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <textarea name="Requirements_for_Products" id="" type="text"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for=" Design and Development of Products and Services">
                                            Design and Development of Products and Services
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#management-review-production_service_provision-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <textarea name="Design_and_Development" id="" type="text"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Control of Externally Provided Processes, Products and Services">
                                            Control of Externally Provided Processes, Products and Services
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#management-review-control_externally_provide_services-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <textarea name="Control_of_Externally" id="" type="text"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Production and Service Provision">
                                            Production and Service Provision
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#management-review-production_service_provision-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <textarea name="Production_and_Service" id="" type="text"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Release of Products and Services">
                                            Release of Products and Services
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#management-review-release_product_services-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <textarea name="Release_of_Products" id="" type="text"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Control of Non-conforming Outputs ">
                                            Control of Non-conforming Outputs
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#management-review-control_nonconforming_outputs-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <textarea name="Control_of_Non" id="" type="text"></textarea>
                                    </div>
                                </div>

                                <div class="group-input">
                                    <label for="audit-agenda-grid">
                                        Performance Evaluation
                                        <button type="button" name="audit-agenda-grid"
                                            id="performance_evaluation">+</button>
                                        <span class="text-primary" data-bs-toggle="modal"
                                            data-bs-target="#observation-field-instruction-modal"
                                            style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered"
                                            id="performance_evaluation-field-instruction-modal">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%">Row#</th>
                                                    <th style="width: 12%">Monitoring</th>
                                                    <th style="width: 16%">Measurement</th>
                                                    <th style="width: 16%">Analysis</th>
                                                    <th style="width: 16%">Evalutaion</th>
                                                    <th style="width: 15%">Remarks</th>
                                                    <th style="width: 5%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <td><input disabled type="text"
                                                        name="performance_evaluation[0][serial]" value="1">
                                                </td>
                                                <td><input type="text" name="performance_evaluation[0][Monitoring]">
                                                </td>
                                                <td><input type="text" name="performance_evaluation[0][Measurement]">
                                                </td>
                                                <td><input type="text" name="performance_evaluation[0][Analysis]"></td>
                                                <td><input type="text" name="performance_evaluation[0][Evalutaion]">
                                                </td>
                                                <td><input type="text" name="performance_evaluation[0][Remarks]"></td>
                                                <td><button type="text" class="removeBtnpe">remove</button>
                                                </td>
                                            </tbody>

                                        </table>
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
                    <!-- ==========================================Meetings & Summary============================================ -->
                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Risk & Opportunities">Risk & Opportunities</label>
                                    <textarea name="Risk_Opportunities" id="" type="text" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="External Supplier Performance">External Supplier Performance</label>
                                    <textarea name="External_Supplier_Performance" id="" type="text" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Customer Satisfaction Level">Customer Satisfaction Level</label>
                                    <textarea name="Customer_Satisfaction_Level" id="" type="text" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Budget Estimates">Budget Estimates</label>
                                    <textarea name="Budget_Estimates" id="" type="text" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Completion of Previous Tasks">Completion of Previous Tasks</label>
                                    <textarea name="Completion_of_Previous_Tasks" id="" type="text" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Production">Production</label>
                                    <textarea name="Production" id="" type="text" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Plans">Plans</label>
                                    <textarea name="Plans" id="" type="text" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Forecast">Forecast</label>
                                    <textarea name="Forecast" id="" type="text" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Any Additional Support Required">Any Additional Support
                                        Required</label>
                                    <textarea name="Any_Additional_Support_Required" id="" type="text" rows="3"></textarea>
                                </div>
                            </div>
                            {{-- <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="File Attachment, if any">File Attachment, if any</label>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attach"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="File Attachment, if any"
                                                oninput="addMultipleFiles(this, 'file_attach')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Inv Attachments">File Attachment</label>
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
                <!-- ==========================================Closure============================================ -->
                <div id="CCForm4" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Action Item Details
                                    <button type="button" name="audit-agenda-grid" id="action_Item_Details">+</button>
                                    <span class="text-primary" data-bs-toggle="modal"
                                        data-bs-target="#observation-field-instruction-modal"
                                        style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="action_Item_Details-field-instruction-modal">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Short Description</th>
                                                <th style="width: 15%">Due Date</th>
                                                <th style="width: 15%">Site / Division</th>
                                                <th style="width: 15%"> Person Responsible</th>
                                                <th style="width: 15%">Current Status</th>
                                                <th style="width: 15%">Date Closed</th>
                                                <th style="width: 15%">Remarks</th>
                                                <th style="width: 5%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input disabled type="text" name="serial[]" value="1">
                                            </td>
                                            <td><input type="text" name="action_Item_Details[0][Short_Description]">
                                            </td>
                                            {{-- <td><input type="date" name="action_Item_Details[0][Due_Date]"></td> --}}
                                            <td>
                                                <div class="new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <div class="calenderauditee">
                                                            <input class="click_date" id="Due_Date" type="text"
                                                                name="action_Item_Details[0][Due_Date]"
                                                                placeholder="DD-MMM-YYYY" />
                                                            <input type="date" name="action_Item_Details[0][Due_Date]"
                                                                min="" id="Due_Date"
                                                                class="hide-input show_date"
                                                                style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                oninput="handleDateInput(this, 'Due_Date')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><input type="text" name="action_Item_Details[0][Site_Division]">
                                            </td>
                                            <td>
                                                <div class="group-input">

                                                    <select name="action_Item_Details[0][Person_Responsible]"
                                                        onchange="">

                                                        <option value="">Select a value</option>
                                                        @if ($users->isNotEmpty())
                                                            @foreach ($users as $value)
                                                                <option value='{{ $value->name }}'>
                                                                    {{ $value->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </td>
                                            <td><input type="time" name="action_Item_Details[0][current_status]">
                                            </td>
                                            <td>
                                                <div class="new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <div class="calenderauditee">
                                                            <input class="click_date" id="Date_Closed" type="text"
                                                                name="action_Item_Details[0][Date_Closed]"
                                                                placeholder="DD-MMM-YYYY" />
                                                            <input type="date"
                                                                name="action_Item_Details[0][Date_Closed]" min=""
                                                                id="Date_Closed" class="hide-input show_date"
                                                                style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                oninput="handleDateInput(this, 'Date_Closed')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><input type="text" name="action_Item_Details[0][Remarking]"></td>
                                            <td><button type="text" class="removeBtnaid">remove</button>
                                            </td>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    CAPA Details
                                    <button type="button" name="audit-agenda-grid" id="capa_Details">+</button>
                                    <span class="text-primary" data-bs-toggle="modal"
                                        data-bs-target="#observation-field-instruction-modal"
                                        style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="capa_Details-field-instruction-modal">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">CAPA Details</th>
                                                <th style="width: 15%">CAPA Type</th>
                                                <th style="width: 15%">Site / Division</th>
                                                <th style="width: 15%">Person Responsible</th>
                                                <th style="width: 15%">Current Status</th>
                                                <th style="width: 15%">Date Closed</th>
                                                <th style="width: 16%">Remarks</th>
                                                <th style="width: 5%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input disabled type="text" name="serial[]" value="1">
                                            </td>
                                            <td><input type="text" name="capa_Details[0][CAPA_Details]"></td>
                                            <td>
                                                <select id="" placeholder="Select..."
                                                    name="capa_Details[0][CAPA_Type]">
                                                    <option value="">Select a value</option>
                                                    <option value="corrective">Corrective Action</option>
                                                    <option value="preventive">Preventive Action</option>
                                                    <option value="corrective_preventive">Corrective &amp;
                                                        Preventive
                                                        Action</option>
                                                </select>
                                            </td>
                                            <td><input type="text" name="capa_Details[0][Site_Division]">
                                            </td>
                                            <td>
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <select name="Person_Responsible" onchange="">
                                                            <option value="">Select a value</option>
                                                            @if ($users->isNotEmpty())
                                                                @foreach ($users as $value)
                                                                    <option value='{{ $value->name }}'>
                                                                        {{ $value->name }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><input type="text" name="capa_Details[0][Current_Status]"></td>
                                            <td>
                                                <div class="new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <div class="calenderauditee">
                                                            <input class="click_date" id="date_Closed" type="text"
                                                                name="capa_Details[0][date_Closed]"
                                                                placeholder="DD-MMM-YYYY" />
                                                            <input type="date" name="capa_Details[0][date_Closed]"
                                                                min="" id="date_Closed"
                                                                class="hide-input show_date"
                                                                style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                oninput="handleDateInput(this, 'date_Closed')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><input type="text" name="capa_Details[0][Remarked]"></td>
                                            <td><button type="text" class="removeBtncd">remove</button>
                                            </td>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Next Management Review Date">Next Management Review Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="start_date_checkdate" name="start_date_checkdate"
                                                readonly placeholder="DD-MMM-YYYY" value="" />
                                            <input type="date" id="start_date_checkdate" value=""
                                                name="start_date_checkdate" min="" class="hide-input"
                                                oninput="handleDateInput(this, 'start_date_checkdate')checkDate('start_date_checkdate','start_date_checkdate')" />
                                        </div>
                                    </div>
                                </div> --}}
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Date Due</label>
                                    <div><small class="text-primary">Please mention expected date of
                                            completion</small>
                                    </div>
                                    <div class="calenderauditee">
                                        <input class="click_date" id="Date_Due" type="text" name="Date_Due"
                                            placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="Date_Due"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="Date_Due"
                                            class="hide-input show_date"
                                            style="position: absolute; top: 0; left: 0; opacity: 0;"
                                            oninput="handleDateInput(this, 'Date_Due')" />
                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Summary & Recommendation">Summary & Recommendation</label>
                                    <textarea name="Summary_Recommendation" id="" type="text" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Conclusion">Conclusion</label>
                                    <textarea name="Conclusion" id="" type="text" rows="3"></textarea>
                                </div>
                            </div>
                            {{-- <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Closure Attachments">Closure Attachments</label>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_Attachment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="file_Attachment[]"
                                                oninput="addMultipleFiles(this, 'file_Attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <div class="col-12">
                                <div class="group-input">
                                    <label for="Inv Attachments">Closure Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_Attachment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="file_Attachment[]"
                                                oninput="addMultipleFiles(this, 'file_Attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Inv Attachments">Closure Attachment</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_Attachment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="file_Attachment[]"
                                                oninput="addMultipleFiles(this, 'file_Attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="sub-head">
                            Extension Justification
                        </div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Due Date Extension Justification">Due Date Extension
                                    Justification</label>
                                <textarea name="Due_Date_Extension_Justification" id="" type="text" rows="3"></textarea>
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

        <!-- ==========================================Signatures============================================ -->
        <div id="CCForm5" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="row">
                    <div class="sub-head">
                        Signatures
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="Submited By">Submited By</label>
                                <div class="static"></div>

                            </div>
                        </div>
                        <div class="col-lg-4 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="Submited">Submited on </label>
                                <div class="static"></div>

                            </div>
                        </div>
                        <div class="col-lg-4 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="Comments">Comments </label>
                                <div class="static"></div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Cancel By">Completed By</label>
                                    <div class="static"></div>

                                </div>
                            </div>
                            <div class="col-lg-4 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Cancel">Completed on </label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Comments">Comments </label>
                                    <div class="static"></div>

                                </div>
                            </div>
                        </div>
                        <div class="button-block">
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            {{-- <button type="submit" class="saveButton">Save</button> --}}
                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                                </a> </button>
                        </div>

                    </div>
                </div>
                <div class="button-block">
                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                    {{-- <button type="submit" class="saveButton">Save</button> --}}
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
    {{-- <script>
        document.getElementById('initiator_group').addEventListener('change', function() {
            var selectedValue = this.value;
            document.getElementById('initiator_group_code').value = selectedValue;
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            $('#Management_Review_Participants').click(function(e) {
                function generateTableRow(serialNumber) {

                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="Management_Review_Participants[' + serialNumber +
                        '][Invite_Person]"></td>' +
                        '<td><input type="text" name="Management_Review_Participants[' + serialNumber +
                        '][Designee]"></td>' +
                        '<td><input type="text" name="Management_Review_Participants[' + serialNumber +
                        '][Department]"></td>' +
                        '<td><input type="text" name="Management_Review_Participants[' + serialNumber +
                        '][Meeting_Attended]"></td>' +
                        '<td><input type="text" name="Management_Review_Participants[' + serialNumber +
                        '][Designee_Name]"></td>' +
                        '<td><input type="text" name="Management_Review_Participants[' + serialNumber +
                        '][Designee_Department_Designation]"></td>' +
                        '<td><input type="text" name="Management_Review_Participants[' + serialNumber +
                        '][manage_remark]"></td>' +
                        '<td><button type="text" class="removeBtn">remove</button></td>' +
                        '</tr>';

                    return html;
                }

                var tableBody = $('#Management_Review_Participants-field-instruction-modal tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#agenda').click(function(e) {
                e.preventDefault();

                function generateTableRow(serialNumber) {
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td>' +
                        '<div class="new-date-data-field">' +
                        '<div class="group-input input-date">' +
                        '<div class="calenderauditee">' +
                        '<input class="click_date" id="date_' + serialNumber +
                        '_mfg_date" type="text" name="agenda[' + serialNumber +
                        '][info_mfg_date_display]" placeholder="DD-MMM-YYYY" readonly />' +
                        '<input type="date" name="agenda[' + serialNumber +
                        '][info_mfg_date]" min="" id="closed_input_' +
                        serialNumber +
                        '" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" onchange="handleDateInput(this, \'date_' +
                        serialNumber + '_mfg_date\')">' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '<td><input type="text" name="agenda[' + serialNumber + '][Topic]"></td>' +
                        '<td><input type="text" name="agenda[' + serialNumber + '][Responsible]"></td>' +
                        '<td><input type="text" name="agenda[' + serialNumber + '][Shelf_Life]"></td>' +
                        '<td><input type="time" name="agenda[' + serialNumber + '][Time_Start]"></td>' +
                        '<td><input type="time" name="agenda[' + serialNumber + '][Time_End]"></td>' +
                        '<td><input type="text" name="agenda[' + serialNumber + '][Comments]"></td>' +
                        '<td><input type="text" name="agenda[' + serialNumber + '][Remarker]"></td>' +
                        '<td><button type="text" class="removeRowBtn">remove</button></td>' +
                        '</tr>';

                    return html;
                }

                var tableBody = $('#agenda-field-instruction-modal tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);

                // Reattach date picker event listeners for newly added rows
                $('.click_date').off('click').on('click', function() {
                    $(this).siblings('.show_date').click();
                });
            });

            // Attach date picker event listeners for the initial row
            $('.click_date').off('click').on('click', function() {
                $(this).siblings('.show_date').click();
            });
        });

        function handleDateInput(input, displayId) {
            var dateValue = input.value;
            var displayInput = document.getElementById(displayId);
            if (displayInput) {
                displayInput.value = dateValue;
            }
        }
    </script>


    <script>
        $(document).ready(function() {
            $('#performance_evaluation').click(function(e) {
                function generateTableRow(serialNumber) {

                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="performance_evaluation[' + serialNumber +
                        '][Monitoring]"></td>' +
                        '<td><input type="text" name="performance_evaluation[' + serialNumber +
                        '][Measurement]"></td>' +
                        '<td><input type="text" name="performance_evaluation[' + serialNumber +
                        '][Analysis]"></td>' +
                        '<td><input type="text" name="performance_evaluation[' + serialNumber +
                        '][Evalutaion]"></td>' +
                        '<td><input type="text" name="performance_evaluation[' + serialNumber +
                        '][Remarks]"></td>' +
                        '<td><button type="text" class="removeBtnpe">remove</button></td>' +
                        '</tr>';

                    return html;
                }

                var tableBody = $('#performance_evaluation-field-instruction-modal tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#action_Item_Details').click(function(e) {
                e.preventDefault();

                function generateTableRow(serialNumber) {
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="action_Item_Details[' + serialNumber +
                        '][Short_Description]"></td>' +
                        '<td><div class="new-date-data-field">' +
                        '<div class="group-input input-date">' +
                        '<div class="calenderauditee">' +
                        '<input class="click_date" id="Due_Date_' + serialNumber +
                        '_display" type="text" name="action_Item_Details[' + serialNumber +
                        '][Due_Date_display]" placeholder="DD-MMM-YYYY" readonly />' +
                        '<input type="date" name="action_Item_Details[' + serialNumber +
                        '][Due_Date]" id="Due_Date_' +
                        serialNumber +
                        '" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" oninput="handleDateInput(this, \'Due_Date_' +
                        serialNumber + '_display\')" />' +
                        '</div>' +
                        '</div>' +
                        '</div></td>' +
                        '<td><input type="text" name="action_Item_Details[' + serialNumber +
                        '][Site_Division]"></td>' +
                        '<td><div class="group-input"><select name="action_Item_Details[' + serialNumber +
                        '][Person_Responsible]"><option value="">Select a value</option>@foreach ($users as $value)<option value="{{ $value->name }}">{{ $value->name }}</option>@endforeach</select></div></td>' +
                        '<td><input type="time" name="action_Item_Details[' + serialNumber +
                        '][current_status]"></td>' +
                        '<td><div class="new-date-data-field"><div class="group-input input-date"><div class="calenderauditee"><input class="click_date" id="date_closed_display_' +
                        serialNumber + '" type="text" name="action_Item_Details[' + serialNumber +
                        '][Date_Closed_display]" placeholder="DD-MMM-YYYY" readonly /><input type="date" name="action_Item_Details[' +
                        serialNumber +
                        '][Date_Closed]"  id="date_closed_input_' +
                        serialNumber +
                        '" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" onchange="handleDateInput(this, \'date_closed_display_' +
                        serialNumber + '\')"></div></div></div></td>' +
                        '<td><input type="text" name="action_Item_Details[' + serialNumber +
                        '][Remarking]"></td>' +
                        '<td><button type="text" class="removeBtnaid">remove</button></td>' +
                        '</tr>';

                    return html;
                }

                var tableBody = $('#action_Item_Details-field-instruction-modal tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);

                // Reattach date picker event listeners for newly added rows
                reattachDatePickers();
            });

            // Attach date picker event listeners for the initial row
            reattachDatePickers();

            function reattachDatePickers() {
                $('.click_date').off('click').on('click', function() {
                    $(this).siblings('.show_date').click();
                });
            }
        });

        function handleDateInput(input, displayId) {
            var dateValue = input.value;
            var displayInput = document.getElementById(displayId);
            if (displayInput) {
                displayInput.value = dateValue;
            }
        }
    </script>





    <script>
        // Pass users data to JavaScript
        var users = @json($users);

        $(document).ready(function() {
            $('#capa_Details').click(function(e) {
                e.preventDefault();

                function generateOptions(users) {
                    var options = '<option value="">Select a value</option>';
                    users.forEach(function(user) {
                        options += '<option value="' + user.id + '">' + user.name + '</option>';
                    });
                    return options;
                }

                function generateTableRow(serialNumber) {
                    var options = generateOptions(users);

                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="capa_Details[' + serialNumber +
                        '][CAPA_Details]"></td>' +
                        '<td>' +
                        '<select id="select-state" placeholder="Select..." name="capa_Details[' +
                        serialNumber + '][CAPA_Type]">' +
                        '<option value="">Select a value</option>' +
                        '<option value="corrective">Corrective Action</option>' +
                        '<option value="preventive">Preventive Action</option>' +
                        '<option value="corrective_preventive">Corrective &amp; Preventive Action</option>' +
                        '</select>' +
                        '</td>' +
                        '<td><input type="text" name="capa_Details[' + serialNumber +
                        '][Site_Division]"></td>' +
                        '<td>' +
                        '<select name="capa_Details[' + serialNumber + '][Person_Responsible]">' +
                        options +
                        '</select>' +
                        '</td>' +
                        '<td><input type="text" name="capa_Details[' + serialNumber +
                        '][Current_Status]"></td>' +
                        '<td>' +
                        '<div class="new-date-data-field">' +
                        '<div class="group-input input-date">' +
                        '<div class="calenderauditee">' +
                        '<input class="click_date" id="closed_display_' + serialNumber +
                        '" type="text" name="capa_Details[' + serialNumber +
                        '][date_Closed]" placeholder="DD-MMM-YYYY" readonly />' +
                        '<input type="date" name="capa_Details[' + serialNumber +
                        '][date_Closed]"  id="date_input_' +
                        serialNumber +
                        '" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" onchange="handleDateInput(this, \'closed_display_' +
                        serialNumber + '\')">' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +

                        '<td><input type="text" name="capa_Details[' + serialNumber + '][Remarked]"></td>' +
                        '<td><button type="text" class="removeBtncd">remove</button></td>' +
                        '</tr>';

                    return html;
                }

                var tableBody = $('#capa_Details-field-instruction-modal tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
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
        $(document).on('click', '.removeRowBtn', function() {
            $(this).closest('tr').remove();
        })
    </script>
    <script>
        $(document).on('click', '.removeBtn', function() {
            $(this).closest('tr').remove();
        })
    </script>
    <script>
        $(document).on('click', '.removeBtnpe', function() {
            $(this).closest('tr').remove();
        })
    </script>
    <script>
        $(document).on('click', '.removeBtnaid', function() {
            $(this).closest('tr').remove();
        })
    </script>
    <script>
        $(document).on('click', '.removeBtncd', function() {
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
