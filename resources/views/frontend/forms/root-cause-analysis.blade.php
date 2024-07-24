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
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        {{ Helpers::getDivisionName(session()->get('division')) }} / Root Cause Analysis
        {{-- KSA / Root Cause Analysis   --}}
        {{-- EHS-North America --}}
    </div>
</div>

@php
$users = DB::table('users')->get();
@endphp

{{-- ======================================
                    DATA FIELDS
    ======================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">

            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Investigation</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Investigation & Root Cause</button>
            <button class="cctablinks " onclick="openCity(event, 'CCForm7')">CFT</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">QA Review</button>

            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Signatures</button>
        </div>

        <form action="{{ route('root_store')}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div id="step-form">
                <!--Investigation-->

                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Record Number</b></label>
                                    <input disabled type="text" name="record_number" value="{{ Helpers::getDivisionName(session()->get('division')) }}/RCA/{{ date('Y') }}/{{ $record_number }}">

                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Site/Location Code </b></label>
                                    <input readonly type="text" name="division_code" value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                    {{-- <div class="static">QMS-North America</div> --}}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="originator">Initiator</label>
                                    <input readonly type="text" name="originator_id" value="{{ Auth::user()->name }}" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input ">
                                    <label for="Date Due"><b>Date of Initiation</b></label>
                                    <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                    <input type="hidden" value="{{ date('d-m-Y') }}" name="intiation_date">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator Group"><b>Initiator Group</b></label>
                                    <select name="initiator_Group" id="initiator_group">
                                        <option value="">-- Select --</option>
                                        <option value="CQA" @if (old('initiator_Group')=='CQA' ) selected @endif>
                                            Corporate Quality Assurance</option>
                                        <option value="QAB" @if (old('initiator_Group')=='QAB' ) selected @endif>Quality
                                            Assurance Biopharma</option>
                                        <option value="CQC" @if (old('initiator_Group')=='CQA' ) selected @endif>Central
                                            Quality Control</option>
                                        <option value="MANU" @if (old('initiator_Group')=='MANU' ) selected @endif>
                                            Manufacturing</option>
                                        <option value="PSG" @if (old('initiator_Group')=='PSG' ) selected @endif>Plasma
                                            Sourcing Group</option>
                                        <option value="CS" @if (old('initiator_Group')=='CS' ) selected @endif>Central
                                            Stores</option>
                                        <option value="ITG" @if (old('initiator_Group')=='ITG' ) selected @endif>
                                            Information Technology Group</option>
                                        <option value="MM" @if (old('initiator_Group')=='MM' ) selected @endif>
                                            Molecular Medicine</option>
                                        <option value="CL" @if (old('initiator_Group')=='CL' ) selected @endif>
                                            Central Laboratory</option>

                                        <option value="TT" @if (old('initiator_Group')=='TT' ) selected @endif>Tech
                                            team</option>
                                        <option value="QA" @if (old('initiator_Group')=='QA' ) selected @endif>
                                            Quality Assurance</option>
                                        <option value="QM" @if (old('initiator_Group')=='QM' ) selected @endif>
                                            Quality Management</option>
                                        <option value="IA" @if (old('initiator_Group')=='IA' ) selected @endif>IT
                                            Administration</option>
                                        <option value="ACC" @if (old('initiator_Group')=='ACC' ) selected @endif>
                                            Accounting</option>
                                        <option value="LOG" @if (old('initiator_Group')=='LOG' ) selected @endif>
                                            Logistics</option>
                                        <option value="SM" @if (old('initiator_Group')=='SM' ) selected @endif>
                                            Senior Management</option>
                                        <option value="BA" @if (old('initiator_Group')=='BA' ) selected @endif>
                                            Business Administration</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator Group Code">Initiator Group Code</label>
                                    <input type="text" name="initiator_group_code" id="initiator_group_code" value="">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span></label><span id="rchars">255</span>
                                    characters remaining
                                    <input id="docname" type="text" name="short_description" maxlength="255" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="severity-level">Sevrity Level</label>
                                    <span class="text-primary">Severity levels in a QMS record gauge issue seriousness, guiding priority for corrective actions. Ranging from low to high, they ensure quality standards and mitigate critical risks.</span>
                                    <select name="severity_level">
                                        <option value="0">-- Select --</option>
                                        <option value="minor">Minor</option>
                                        <option value="major">Major</option>
                                        <option value="critical">Critical</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assign_to">
                                        <option value="">Select a value</option>
                                        @foreach ($users as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('assign_to')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Due Date"> Due Date </label>
                                    <div><small class="text-primary">If revising Due Date, kindly mention revision reason in "Due Date Extension Justification" data field.</small></div>
                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>

                                    {{-- <input type="hidden" value="{{ $due_date }}" name="due_date">
                                    <input disabled type="text" value="{{ Helpers::getdateFormat($due_date) }}"> --}}
                                    {{-- <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                    value="" name="due_date"> --}}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator Group">Initiated Through</label>
                                    <div><small class="text-primary">Please select related information</small></div>
                                    <select name="initiated_through" onchange="otherController(this.value, 'others', 'initiated_through_req')">
                                        <option value="">-- select --</option>
                                        <option value="recall">Recall</option>
                                        <option value="return">Return</option>
                                        <option value="deviation">Deviation</option>
                                        <option value="complaint">Complaint</option>
                                        <option value="regulatory">Regulatory</option>
                                        <option value="lab-incident">Lab Incident</option>
                                        <option value="improvement">Improvement</option>
                                        <option value="others">Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input" id="initiated_through_req">
                                    <label for="If Other">Others<span class="text-danger d-none">*</span></label>
                                    <textarea name="initiated_if_other"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Type</label>
                                    <select name="Type">
                                        <option value="0">-- Select --</option>
                                        <option value="1">Facillties</option>
                                        <option value="2">Other</option>
                                        <option value="3">Stabillity</option>
                                        <option value="4">Raw Material</option>
                                        <option value="5">Clinical Production</option>
                                        <option value="6">Commercial Production</option>
                                        <option value="7">Labellling</option>
                                        <option value="8">laboratory</option>
                                        <option value="9">Utillities</option>
                                        <option value="10">Validation</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="priority_level">Priority Level</label>
                                    <div><small class="text-primary">Choose high if Immidiate actions are
                                            required</small></div>
                                    <select name="priority_level">
                                        <option value="0">-- Select --</option>
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high">High</option>
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="col-lg-6"> --}}
                            {{-- <div class="group-input">
                                        <label for="investigators">Additional Investigators</label>
                                        <select  name="investigators" placeholder="Select Investigators"
                                            data-search="false" data-silent-initial-value-set="true" id="investigators">
                                            <option value="">Select Investigators</option>
                                            <option value="1">Amit Guru</option>
                                            <option value="2">Shaleen Mishra</option>
                                            <option value="3">Madhulika Mishra</option>
                                            <option value="4">Amit Patel</option>
                                            <option value="5">Harsh Mishra</option>
                                        </select>
                                    </div> --}}
                            {{-- </div> --}}
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="department">Department(s)</label>
                                    <select multiple name="department" placeholder="Select Department(s)" data-search="false" data-silent-initial-value-set="true" id="department">
                                        <option value="1">Work Instruction</option>
                                        <option value="2">Quality Assurance</option>
                                        <option value="3">Specifications</option>
                                        <option value="4">Production</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="sub-head">Investigatiom details</div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="description">Description</label>
                                    <textarea name="description"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="comments">Comments</label>
                                    <textarea name="comments"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Inv Attachments">Initial Attachment</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="root_cause_initial_attachment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="root_cause_initial_attachment[]" oninput="addMultipleFiles(this, 'root_cause_initial_attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="severity-level">Sevrity Level</label>
                                        <select name="severity-level">
                                            <option value="0">-- Select --</option>
                                            <option value="minor">Minor</option>
                                            <option value="major">Major</option>
                                            <option value="critical">Critical</option>
                                        </select>
                                    </div>
                                </div> --}}
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="related_url">Related URL</label>
                                    <input type="url" name="related_url" />
                                </div>
                            </div>
                        </div>
                        <div class="button-block">
                            <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                            <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
                        </div>
                    </div>
                </div>

                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="root-cause-methodology">Root Cause Methodology</label>
                                    <select name="root_cause_methodology[]" multiple placeholder="-- Select --" data-search="false" data-silent-initial-value-set="true" id="root-cause-methodology">
                                        <option value="1">Why-Why Chart</option>
                                        <option value="2">Failure Mode and Efect Analysis</option>
                                        <option value="3">Fishbone or Ishikawa Diagram</option>
                                        <option value="4">Is/Is Not Analysis</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="root_cause">
                                        Root Cause
                                        <button type="button" onclick="add4Input('root-cause-first-table')">+</button>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="root-cause-first-table">
                                            <thead>
                                                <tr>
                                                    <th>Row #</th>
                                                    <th>Root Cause Category</th>
                                                    <th>Root Cause Sub-Category</th>
                                                    <th>Probability</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <td><input disabled type="text" name="serial_number[]" value="1">
                                                </td>
                                                <td><input type="text" name="Root_Cause_Category[]"></td>
                                                <td><input type="text" name="Root_Cause_Sub_Category[]"></td>
                                                <td><input type="text" name="Probability[]"></td>
                                                <td><input type="text" name="Remarks[]"></td>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 sub-head"></div>
                            <div class="col-12 mb-4">
                                <div class="group-input">
                                    <label for="agenda">
                                        Failure Mode and Effect Analysis
                                        <button type="button" name="agenda" onclick="addRootCauseAnalysisRiskAssessment('risk-assessment-risk-management')">+</button>
                                        <span class="text-primary" style="font-size: 0.8rem; font-weight: 400;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" style="width: 200%" id="risk-assessment-risk-management">
                                            <thead>
                                                <tr>
                                                    <th>Row #</th>
                                                    <th>Risk Factor</th>
                                                    <th>Risk element </th>
                                                    <th>Probable cause of risk element</th>
                                                    <th>Existing Risk Controls</th>
                                                    <th>Initial Severity- H(3)/M(2)/L(1)</th>
                                                    <th>Initial Probability- H(3)/M(2)/L(1)</th>
                                                    <th>Initial Detectability- H(1)/M(2)/L(3)</th>
                                                    <th>Initial RPN</th>
                                                    <th>Risk Acceptance (Y/N)</th>
                                                    <th>Proposed Additional Risk control measure (Mandatory for Risk elements having RPN>4)</th>
                                                    <th>Residual Severity- H(3)/M(2)/L(1)</th>
                                                    <th>Residual Probability- H(3)/M(2)/L(1)</th>
                                                    <th>Residual Detectability- H(1)/M(2)/L(3)</th>
                                                    <th>Residual RPN</th>
                                                    <th>Risk Acceptance (Y/N)</th>
                                                    <th>Mitigation proposal (Mention either CAPA reference number, IQ,OQ or PQ)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 sub-head"></div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="fishbone">
                                        Fishbone or Ishikawa Diagram
                                        <button type="button" name="agenda" onclick="addFishBone('.top-field-group', '.bottom-field-group')">+</button>
                                        <button type="button" name="agenda" class="fishbone-del-btn" onclick="deleteFishBone('.top-field-group', '.bottom-field-group')">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#fishbone-instruction-modal" style="font-size: 0.8rem; font-weight: 400;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="fishbone-ishikawa-diagram">
                                        <div class="left-group">
                                            <div class="grid-field field-name">
                                                <div>Measurement</div>
                                                <div>Materials</div>
                                                <div>Methods</div>
                                            </div>
                                            <div class="top-field-group">
                                                <div class="grid-field fields top-field">
                                                    <div><input type="text" name="measurement[]"></div>
                                                    <div><input type="text" name="materials[]"></div>
                                                    <div><input type="text" name="methods[]"></div>
                                                </div>
                                            </div>
                                            <div class="mid"></div>
                                            <div class="bottom-field-group">
                                                <div class="grid-field fields bottom-field">
                                                    <div><input type="text" name="environment[]"></div>
                                                    <div><input type="text" name="manpower[]"></div>
                                                    <div><input type="text" name="machine[]"></div>
                                                </div>
                                            </div>
                                            <div class="grid-field field-name">
                                                <div>Environment</div>
                                                <div>Manpower</div>
                                                <div>Machine</div>
                                            </div>
                                        </div>
                                        <div class="right-group">
                                            <div class="field-name">
                                                Problem Statement
                                            </div>
                                            <div class="field">
                                                <textarea name="problem_statement"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 sub-head"></div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="why-why-chart">
                                        Why-Why Chart
                                        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#why_chart-instruction-modal" style="font-size: 0.8rem; font-weight: 400;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="why-why-chart">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr style="background: #f4bb22">
                                                    <th style="width:150px;">Problem Statement :</th>
                                                    <td>
                                                        <textarea name="why_problem_statement"></textarea>
                                                    </td>
                                                </tr>
                                                <tr class="why-row">
                                                    <th style="width:150px; color: #393cd4;">
                                                        Why 1 <span onclick="addWhyField('why_1_block', 'why_1[]')">+</span>
                                                    </th>
                                                    <td>
                                                        <div class="why_1_block">
                                                            <textarea name="why_1[]"></textarea>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="why-row">
                                                    <th style="width:150px; color: #393cd4;">
                                                        Why 2 <span onclick="addWhyField('why_2_block', 'why_2[]')">+</span>
                                                    </th>
                                                    <td>
                                                        <div class="why_2_block">
                                                            <textarea name="why_2[]"></textarea>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="why-row">
                                                    <th style="width:150px; color: #393cd4;">
                                                        Why 3 <span onclick="addWhyField('why_3_block', 'why_3[]')">+</span>
                                                    </th>
                                                    <td>
                                                        <div class="why_3_block">
                                                            <textarea name="why_3[]"></textarea>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="why-row">
                                                    <th style="width:150px; color: #393cd4;">
                                                        Why 4 <span onclick="addWhyField('why_4_block', 'why_4[]')">+</span>
                                                    </th>
                                                    <td>
                                                        <div class="why_4_block">
                                                            <textarea name="why_4[]"></textarea>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="why-row">
                                                    <th style="width:150px; color: #393cd4;">
                                                        Why 5 <span onclick="addWhyField('why_5_block', 'why_5[]')">+</span>
                                                    </th>
                                                    <td>
                                                        <div class="why_5_block">
                                                            <textarea name="why_5[]"></textarea>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr style="background: #0080006b;">
                                                    <th style="width:150px;">Root Cause :</th>
                                                    <td>
                                                        <textarea name="why_root_cause"></textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 sub-head"></div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="why-why-chart">
                                        Is/Is Not Analysis
                                        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#is_is_not-instruction-modal" style="font-size: 0.8rem; font-weight: 400;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="why-why-chart">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>&nbsp;</th>
                                                    <th>Will Be</th>
                                                    <th>Will Not Be</th>
                                                    <th>Rationale</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th style="background: #0039bd85">What</th>
                                                    <td>
                                                        <textarea name="what_will_be"></textarea>
                                                    </td>
                                                    <td>
                                                        <textarea name="what_will_not_be"></textarea>
                                                    </td>
                                                    <td>
                                                        <textarea name="what_rationable"></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="background: #0039bd85">Where</th>
                                                    <td>
                                                        <textarea name="where_will_be"></textarea>
                                                    </td>
                                                    <td>
                                                        <textarea name="where_will_not_be"></textarea>
                                                    </td>
                                                    <td>
                                                        <textarea name="where_rationable"></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="background: #0039bd85">When</th>
                                                    <td>
                                                        <textarea name="when_will_be"></textarea>
                                                    </td>
                                                    <td>
                                                        <textarea name="when_will_not_be"></textarea>
                                                    </td>
                                                    <td>
                                                        <textarea name="when_rationable"></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="background: #0039bd85">Coverage</th>
                                                    <td>
                                                        <textarea name="coverage_will_be"></textarea>
                                                    </td>
                                                    <td>
                                                        <textarea name="coverage_will_not_be"></textarea>
                                                    </td>
                                                    <td>
                                                        <textarea name="coverage_rationable"></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="background: #0039bd85">Who</th>
                                                    <td>
                                                        <textarea name="who_will_be"></textarea>
                                                    </td>
                                                    <td>
                                                        <textarea name="who_will_not_be"></textarea>
                                                    </td>
                                                    <td>
                                                        <textarea name="who_rationable"></textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 sub-head"></div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="root_cause_description">Root Cause Description</label>
                                    <textarea name="root_cause_description"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="investigation_summary">Investigation Summary</label>
                                    <textarea name="investigation_summary"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
                        </div>
                    </div>
                </div>

                <!-- =========================================================================================== -->
                <!-- CFT -->
                <div id="CCForm7" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                           <div class="row">
                                   <div class="sub-head">
                                   Production
                                  </div>
                                  <div class="col-lg-6">
                                           <div class="group-input">
                                               <label for="Production Review">Production Review Required ?</label>
                                               <select name="Production_Review" id="Production_Review">
                                                   <option value="0">-- Select --</option>
                                                   <option value="yes">Yes</option>
                                                   <option value="no">No</option>
                                                   <option value="na">NA</option>
       
                                               </select>
                                         
                                           </div>
                                       </div>
                                       @php
                                           $division = DB::table('q_m_s_divisions')->where('name', Helpers::getDivisionName(session()->get('division')))->first();
                                           $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 22, 'q_m_s_divisions_id' => $division->id])->get();
                                           $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                           $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                       @endphp
       
                                       <div class="col-lg-6">
                                           <div class="group-input">
                                               <label for="Production person">Production Person</label>
                                               <select name="Production_person" id="Production_person">
                                                   <option value="0">-- Select --</option>
                                                   @foreach ($users as $user)
                                                       <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                   @endforeach
                                               </select>
                                           </div>
                                       </div>
                                       <div class="col-md-12 mb-3">
                                           <div class="group-input">
                                               <label for="Production assessment">Impact Assessment (By Production)</label>
                                               <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                               <textarea class="summernote" name="Production_assessment" id="summernote-17">
                                           </textarea>
                                           </div>
                                       </div>
                                       <div class="col-md-12 mb-3">
                                           <div class="group-input">
                                               <label for="Production feedback">Production Feedback</label>
                                               <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                               <textarea class="summernote" name="Production_feedback" id="summernote-18">
                                           </textarea>
                                           </div>
                                       </div>
                                       
                                       <div class="col-lg-12">
                                           <div class="group-input">
                                               <label for="production attachment"> Production Attachments</label>
                                               <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                               <div class="file-attachment-field">
                                                   <div class="file-attachment-list" id="production_attachment"></div>
                                                   <div class="add-btn">
                                                       <div>Add</div>
                                                       <input type="file" id="myfile" name="production_attachment[]"
                                                           oninput="addMultipleFiles(this, 'production_attachment')" multiple>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                         <div class="col-md-6 mb-3"> 
                                           <div class="group-input">
                                               <label for="Production Review Completed By">Production Review Completed By</label>
                                               <input type="text" name="production_by" id="production_by" disabled>
                                           </div>
                                       </div>
                                       <div class="col-lg-6 new-date-data-field">
                                           <div class="group-input input-date">
                                               <label for="Production Review Completed On">Production Review Completed On</label>
                                               <div class="calenderauditee">
                                                   <input type="text" id="production_on" readonly placeholder="DD-MMM-YYYY" />
                                                   <input type="date"  name="production_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                       oninput="handleDateInput(this, 'production_on')" />
                                               </div>
                                           </div>
                                       </div>
                                       <div class="sub-head">
                                       Warehouse
                                  </div>
                                  <div class="col-lg-6">
                                           <div class="group-input">
                                               <label for="Warehouse Review Required">Warehouse Review Required ?</label>
                                               <select name="Warehouse_review" id="Warehouse_review">
                                                   <option value="0">-- Select --</option>
                                                   <option value="yes">Yes</option>
                                                   <option value="no">No</option>
                                                   <option value="na">NA</option>
       
                                               </select>
                                         
                                           </div>
                                       </div>
                                       @php
                                           $division = DB::table('q_m_s_divisions')->where('name', Helpers::getDivisionName(session()->get('division')))->first();
                                           $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 23, 'q_m_s_divisions_id' => $division->id])->get();
                                           $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                           $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                       @endphp
                                       <div class="col-lg-6">
                                           <div class="group-input">
                                               <label for="Customer notification">Warehouse Person</label>
                                               <select name="Warehouse_notification" id="Warehouse_person">
                                                   <option value="0">-- Select --</option>
                                                   @foreach ($users as $user)
                                                   <option value="{{ $user->id }}">{{ $user->name }}</option>
                                               @endforeach
                                               </select>
                                           </div>
                                       </div>
                                       <div class="col-md-12 mb-3">
                                           <div class="group-input">
                                               <label for="Impact Assessment1">Impact Assessment (By Warehouse)</label>
                                               <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                               <textarea class="summernote" name="Warehouse_assessment" id="summernote-19">
                                           </textarea>
                                           </div>
                                       </div>
                                       <div class="col-md-12 mb-3">
                                           <div class="group-input">
                                               <label for="productionfeedback">Warehouse Feedback</label>
                                               <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                               <textarea class="summernote" name="Warehouse_feedback" id="summernote-20">
                                           </textarea>
                                           </div>
                                       </div>
                                       <div class="col-lg-12">
                                           <div class="group-input">
                                               <label for="Warehouse attachment"> Warehouse Attachments</label>
                                               <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                               <div class="file-attachment-field">
                                                   <div class="file-attachment-list" id="Warehouse_attachment"></div>
                                                   <div class="add-btn">
                                                       <div>Add</div>
                                                       <input type="file" id="myfile" name="Warehouse_attachment[]"
                                                           oninput="addMultipleFiles(this, 'Warehouse_attachment')" multiple>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="col-md-6 mb-3">
                                           <div class="group-input">
                                               <label for="Warehousefeedback">Warehouse Review Completed By</label>
                                               <input type="text"  name="Warehouse_by" id="Warehouse_by" disabled>
                                           
                                           </div>
                                       </div>
                                       
                                       <div class="col-lg-6 new-date-data-field">
                                           <div class="group-input input-date">
                                               <label for="Warehouse Review Completed On">Warehouse Review Completed On</label>
                                               <div class="calenderauditee">
                                                   <input type="text" id="Warehouse_on" readonly placeholder="DD-MMM-YYYY" />
                                                   <input type="date"  name="Warehouse_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                       oninput="handleDateInput(this, 'Warehouse_on')" />
                                               </div>
                                           </div>
                                       </div>
                                       <div class="sub-head">
                                       Quality Control
                                  </div>
                                  <div class="col-lg-6">
                                           <div class="group-input">
                                               <label for="Quality Control Review Required">Quality Control Review Required ?</label>
                                               <select name="Quality_review" id="Quality_review">
                                                   <option value="0">-- Select --</option>
                                                   <option value="yes">Yes</option>
                                                   <option value="no">No</option>
                                                   <option value="na">NA</option>
       
                                               </select>
                                         
                                           </div>
                                       </div>
                                       @php
                                           $division = DB::table('q_m_s_divisions')->where('name', Helpers::getDivisionName(session()->get('division')))->first();
                                           $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 24, 'q_m_s_divisions_id' => $division->id])->get();
                                           $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                           $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                       @endphp
                                       <div class="col-lg-6">
                                           <div class="group-input">
                                               <label for="Quality Control Person">Quality Control Person</label>
                                               <select name="Quality_Control_Person" id="Quality_Control_Person">
                                                   <option value="0">-- Select --</option>
                                                   @foreach ($users as $user)
                                                   <option value="{{ $user->id }}">{{ $user->name }}</option>
                                               @endforeach
                                               </select>
                                         
                                           </div>
                                       </div>
                                       <div class="col-md-12 mb-3">
                                           <div class="group-input">
                                               <label for="Impact Assessment2">Impact Assessment (By Quality Control)</label>
                                               <textarea class="summernote" name="Quality_Control_assessment" id="summernote-21">
                                           </textarea>
                                           </div>
                                       </div>  
                                       <div class="col-md-12 mb-3">
                                           <div class="group-input">
                                               <label for="Quality Control Feedback">Quality Control Feedback</label>
                                               <textarea class="summernote" name="Quality_Control_feedback" id="summernote-22">
                                           </textarea>
                                           </div>
                                       </div>
                                       <div class="col-lg-12">
                                           <div class="group-input">
                                               <label for="Quality Control Attachments">Quality Control Attachments</label>
                                               <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                               <div class="file-attachment-field">
                                                   <div class="file-attachment-list" id="Quality_Control_attachment"></div>
                                                   <div class="add-btn">
                                                       <div>Add</div>
                                                       <input type="file" id="myfile" name="Quality_Control_attachment[]"
                                                           oninput="addMultipleFiles(this, 'Quality_Control_attachment')" multiple>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="col-md-6 mb-3">
                                           <div class="group-input">
                                               <label for="productionfeedback">Quality Control Review Completed By</label>
                                               <input type="text" name="Quality_Control_by" disabled>
                                           
                                           </div>
                                       </div>
                                       <div class="col-lg-6 new-date-data-field">
                                           <div class="group-input input-date">
                                               <label for="Quality Control Review Completed On">Quality Control Review Completed On</label>
                                               <div class="calenderauditee">
                                                   <input type="text" id="Quality_Control_on" readonly placeholder="DD-MMM-YYYY" />
                                                   <input type="date"  name="Quality_Control_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                       oninput="handleDateInput(this, 'Quality_Control_on')" />
                                               </div>
                                           </div>
                                       </div>
                                         <div class="sub-head">
                                         Quality Assurance
                                  </div>
                                  <div class="col-lg-6">
                                           <div class="group-input">
                                               <label for="Customer notification">Quality Assurance Review Required ?</label>
                                               <select name="Quality_Assurance" id="QualityAssurance_review">
                                                   <option value="0">-- Select --</option>
                                                   <option value="yes">Yes</option>
                                                   <option value="no">No</option>
                                                   <option value="na">NA</option>
       
                                               </select>
                                         
                                           </div>
                                       </div>
                                       @php
                                           $division = DB::table('q_m_s_divisions')->where('name', Helpers::getDivisionName(session()->get('division')))->first();
                                           $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 25, 'q_m_s_divisions_id' => $division->id])->get();
                                           $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                           $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                       @endphp
                                       <div class="col-lg-6">
                                           <div class="group-input">
                                               <label for="Quality Assurance Person">Quality Assurance Person</label>
                                               <select name="QualityAssurance_person" id="QualityAssurance_person">
                                                   <option value="0">-- Select --</option>
                                                   @foreach ($users as $user)
                                                   <option value="{{ $user->id }}">{{ $user->name }}</option>
                                               @endforeach
                                             </select>
                                         
                                           </div>
                                       </div>
                                       <div class="col-md-12 mb-3">
                                           <div class="group-input">
                                               <label for="Impact Assessment3">Impact Assessment (By Quality Assurance)</label>
                                               <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                               <textarea class="summernote" name="QualityAssurance_assessment" id="summernote-23">
                                           </textarea>
                                           </div>
                                       </div>  
                                       <div class="col-md-12 mb-3">
                                           <div class="group-input">
                                               <label for="Quality Assurance Feedback">Quality Assurance Feedback</label>
                                               <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                               <textarea class="summernote" name="QualityAssurance_feedback" id="summernote-24">
                                           </textarea>
                                           </div>
                                       </div>
                                       <div class="col-lg-12">
                                           <div class="group-input">
                                               <label for="Quality Assurance Attachments">Quality Assurance Attachments</label>
                                               <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                               <div class="file-attachment-field">
                                                   <div class="file-attachment-list" id="Quality_Assurance_attachment"></div>
                                                   <div class="add-btn">
                                                       <div>Add</div>
                                                       <input type="file" id="myfile" name="Quality_Assurance_attachment[]"
                                                           oninput="addMultipleFiles(this, 'Quality_Assurance_attachment')" multiple>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="col-md-6 mb-3">
                                           <div class="group-input">
                                               <label for="Quality Assurance Review Completed By">Quality Assurance Review Completed By</label>
                                               <input type="text" name="QualityAssurance_by" disabled>
                                           
                                           </div>
                                       </div>
                                       <div class="col-lg-6 new-date-data-field">
                                           <div class="group-input input-date">
                                               <label for="Quality Assurance Review Completed On">Quality Assurance Review Completed On</label>
                                               <div class="calenderauditee">
                                                   <input type="text" id="QualityAssurance_on" readonly placeholder="DD-MMM-YYYY" />
                                                   <input type="date"  name="QualityAssurance_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                       oninput="handleDateInput(this, 'QualityAssurance_on')" />
                                               </div>
                                           </div>
                                       </div>
                                       <div class="sub-head">
                                       Engineering
                                  </div>
                                  <div class="col-lg-6">
                                           <div class="group-input">
                                               <label for="Engineering Review Required">Engineering Review Required ?</label>
                                               <select name="Engineering_review" id="Engineering_review">
                                                   <option value="0">-- Select --</option>
                                                   <option value="yes">Yes</option>
                                                   <option value="no">No</option>
                                                   <option value="na">NA</option>
                                               </select>
                                         
                                           </div>
                                       </div>
                                       @php
                                           $division = DB::table('q_m_s_divisions')->where('name', Helpers::getDivisionName(session()->get('division')))->first();
                                           $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 26, 'q_m_s_divisions_id' => $division->id])->get();
                                           $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                           $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                       @endphp
                                       <div class="col-lg-6">
                                           <div class="group-input">
                                               <label for="Engineering Person">Engineering Person</label>
                                               <select name="Engineering_person" id="Engineering_person">
                                                   <option value="0">-- Select --</option>
                                                   @foreach ($users as $user)
                                                   <option value="{{ $user->id }}">{{ $user->name }}</option>
                                               @endforeach
                                               </select>
                                         
                                           </div>
                                       </div>
                                       <div class="col-md-12 mb-3">
                                           <div class="group-input">
                                               <label for="Impact Assessment4">Impact Assessment (By Engineering)</label>
                                               <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                               <textarea class="summernote" name="Engineering_assessment" id="summernote-25">
                                           </textarea>
                                           </div>
                                       </div>
                                       <div class="col-md-12 mb-3">
                                           <div class="group-input">
                                               <label for="productionfeedback">Engineering  Feedback</label>
                                               <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                               <textarea class="summernote" name="Engineering_feedback" id="summernote-26">
                                           </textarea>
                                           </div>
                                       </div>
                                       <div class="col-lg-12">
                                           <div class="group-input">
                                               <label for="Audit Attachments">Engineering  Attachments</label>
                                               <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                               <div class="file-attachment-field">
                                                   <div class="file-attachment-list" id="Engineering_attachment"></div>
                                                   <div class="add-btn">
                                                       <div>Add</div>
                                                       <input type="file" id="myfile" name="Engineering_attachment[]"
                                                           oninput="addMultipleFiles(this, 'Engineering_attachment')" multiple>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="col-md-6 mb-3">
                                           <div class="group-input">
                                               <label for="Engineering Review Completed By">Engineering Review Completed By</label>
                                               <input type="text" name="Engineering_by" id="Engineering_by" disabled>
                                           
                                           </div>
                                       </div>
                                       <div class="col-lg-6 new-date-data-field">
                                           <div class="group-input input-date">
                                               <label for="Engineering Review Completed On">Engineering Review Completed On</label>
                                               <div class="calenderauditee">
                                                   <input type="text" id="Engineering_on" readonly placeholder="DD-MMM-YYYY" />
                                                   <input type="date"  name="Engineering_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                       oninput="handleDateInput(this, 'Engineering_on')" />
                                               </div>
                                           </div>
                                       </div>
                                       <div class="sub-head">
                                       Analytical Development Laboratory
                                  </div>
                                  <div class="col-lg-6">
                                           <div class="group-input">
                                               <label for="Analytical Development Laboratory Review Required">Analytical Development Laboratory Review Required ?</label>
                                               <select name="Analytical_Development_review" id="Analytical_Development_review">
                                                   <option value="0">-- Select --</option>
                                                   <option value="yes">Yes</option>
                                                   <option value="no">No</option>
                                                   <option value="na">NA</option>
       
                                               </select>
                                         
                                           </div>
                                       </div>
                                       @php
                                       $division = DB::table('q_m_s_divisions')->where('name', Helpers::getDivisionName(session()->get('division')))->first();
                                       $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 27, 'q_m_s_divisions_id' => $division->id])->get();
                                       $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                       $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                   @endphp
                                       <div class="col-lg-6">
                                           <div class="group-input">
                                               <label for="Analytical Development Laboratory Person">Analytical Development Laboratory Person</label>
                                               <select name="Analytical_Development_person" id="Analytical_Development_person">
                                                   <option value="0">-- Select --</option>
                                                   @foreach ($users as $user)
                                                   <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                   @endforeach
                                               </select>
                                           </div>
                                       </div>
                                       <div class="col-md-12 mb-3">
                                           <div class="group-input">
                                               <label for="Impact Assessment5">Impact Assessment (By Analytical Development Laboratory)</label>
                                               <textarea class="summernote" name="Analytical_Development_assessment" id="summernote-27">
                                           </textarea>
                                           </div>
                                       </div>
                                       <div class="col-md-12 mb-3">
                                           <div class="group-input">
                                               <label for="Analytical Development Laboratory Feedback"> Analytical Development Laboratory Feedback</label>
                                               <textarea class="summernote" name="Analytical_Development_feedback" id="summernote-28">
                                           </textarea>
                                           </div>
                                       </div>
                                       <div class="col-lg-12">
                                           <div class="group-input">
                                               <label for="Audit Attachments"> Analytical Development Laboratory Attachments</label>
                                               <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                               <div class="file-attachment-field">
                                                   <div class="file-attachment-list" id="Analytical_Development_attachment"></div>
                                                   <div class="add-btn">
                                                       <div>Add</div>
                                                       <input type="file" id="myfile" name="Analytical_Development_attachment[]"
                                                           oninput="addMultipleFiles(this, 'Analytical_Development_attachment')" multiple>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="col-md-6 mb-3">
                                           <div class="group-input">
                                               <label for="Analytical Development Laboratory Review Completed By">Analytical Development Laboratory Review Completed By</label>
                                               <input type="text" name="Analytical_Development_by" id="Analytical_Development_by" disabled>
                                           
                                           </div>
                                       </div>
                                       {{-- <div class="col-md-6 mb-3">
                                           <div class="group-input">
                                               <label for="Analytical Development Laboratory Review Completed On">Analytical Development Laboratory Review Completed On</label>
                                               <input type="date" name="Analytical_Development_on" disabled>
                                           
                                           </div>
                                       </div> --}}
                                       <div class="col-lg-6 new-date-data-field">
                                           <div class="group-input input-date">
                                               <label for="Analytical Development Laboratory Review Completed On">Analytical Development Laboratory Review Completed On</label>
                                               <div class="calenderauditee">
                                                   <input type="text" id="Analytical_Development_on" readonly placeholder="DD-MMM-YYYY" />
                                                   <input type="date"  name="Analytical_Development_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                       oninput="handleDateInput(this, 'Analytical_Development_on')" />
                                               </div>
                                           </div>
                                       </div>
                                       <div class="sub-head">
                                       Process Development Laboratory / Kilo Lab
                                  </div>
                                  <div class="col-lg-6">
                                           <div class="group-input">
                                               <label for="Process Development Laboratory"> Process Development Laboratory / Kilo Lab Review Required ?</label>
                                               <select name="Kilo_Lab_review" id="Kilo_Lab_review">
                                                   <option value="0">-- Select --</option>
                                                   <option value="yes">Yes</option>
                                                   <option value="no">No</option>
                                                   <option value="na">NA</option>
       
                                               </select>
                                         
                                           </div>
                                       </div>
                                       @php
                                           $division = DB::table('q_m_s_divisions')->where('name', Helpers::getDivisionName(session()->get('division')))->first();
                                           $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 28, 'q_m_s_divisions_id' => $division->id])->get();
                                           $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                           $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                       @endphp
                                       <div class="col-lg-6">
                                           <div class="group-input">
                                               <label for="Process Development Laboratory"> Process Development Laboratory / Kilo Lab  Person</label>
                                               <select name="Kilo_Lab_person" id="Kilo_Lab_person">
                                                   <option value="0">-- Select --</option>
                                                   @foreach ($users as $user)
                                                   <option value="{{ $user->id }}">{{ $user->name }}</option>
                                               @endforeach
                                                  
       
                                               </select>
                                         
                                           </div>
                                       </div>
                                       <div class="col-md-12 mb-3">
                                           <div class="group-input">
                                               <label for="Impact Assessment6">Impact Assessment (By Process Development Laboratory / Kilo Lab)</label>
                                               <textarea class="summernote" name="Kilo_Lab_assessment" id="summernote-29">
                                           </textarea>
                                           </div>
                                       </div>  
                                       <div class="col-md-12 mb-3">
                                           <div class="group-input">
                                               <label for="Kilo Lab Feedback"> Process Development Laboratory / Kilo Lab  Feedback</label>
                                               <textarea class="summernote" name="Kilo_Lab_feedback" id="summernote-30">
                                           </textarea>
                                           </div>
                                       </div>
                                       <div class="col-lg-12">
                                           <div class="group-input">
                                               <label for="Audit Attachments"> Process Development Laboratory / Kilo Lab Attachments</label>
                                               <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                               <div class="file-attachment-field">
                                                   <div class="file-attachment-list" id="Kilo_Lab_attachment"></div>
                                                   <div class="add-btn">
                                                       <div>Add</div>
                                                       <input type="file" id="myfile" name="Kilo_Lab_attachment[]"
                                                           oninput="addMultipleFiles(this, 'Kilo_Lab_attachment')" multiple>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
       
                                       <div class="col-md-6 mb-3">
                                           <div class="group-input">
                                               <label for="Kilo Lab Review Completed By">Process Development Laboratory / Kilo Lab Review Completed By</label>
                                               <input type="text" name="Kilo_Lab_attachment_by" id="Kilo_Lab_attachment_by" disabled>
                                           
                                           </div>
                                       </div>
                                       <div class="col-lg-6 new-date-data-field">
                                           <div class="group-input input-date">
                                               <label for="Kilo Lab Review Completed On">Process Development Laboratory / Kilo Lab Review Completed On</label>
                                               <div class="calenderauditee">
                                                   <input type="text" id="Kilo_Lab_attachment_on" readonly placeholder="DD-MMM-YYYY" />
                                                   <input type="date"  name="Kilo_Lab_attachment_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                       oninput="handleDateInput(this, 'Kilo_Lab_attachment_on')" />
                                               </div>
                                           </div>
                                       </div>
                                       <div class="sub-head">
                                       Technology Transfer / Design
                                  </div>
                                  <div class="col-lg-6">
                                           <div class="group-input">
                                               <label for="Design Review Required">Technology Transfer / Design Review Required ?</label>
                                               <select name="Technology_transfer_review" id="Technology_transfer_review">
                                                   <option value="0">-- Select --</option>
                                                   <option value="yes">Yes</option>
                                                   <option value="no">No</option>
                                                   <option value="na">NA</option>
       
                                               </select>
                                         
                                           </div>
                                       </div>
                                       @php
                                           $division = DB::table('q_m_s_divisions')->where('name', Helpers::getDivisionName(session()->get('division')))->first();
                                           $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 29, 'q_m_s_divisions_id' => $division->id])->get();
                                           $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                           $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                       @endphp
                                       <div class="col-lg-6">
                                           <div class="group-input">
                                               <label for="Design Person"> Technology Transfer / Design  Person</label>
                                               <select name="Technology_transfer_person" id="Technology_transfer_person">
                                                   <option value="0">-- Select --</option>
                                                   @foreach ($users as $user)
                                                       <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                   @endforeach
                                                  
       
                                               </select>
                                         
                                           </div>
                                       </div>
                                       <div class="col-md-12 mb-3">
                                           <div class="group-input">
                                               <label for="Impact Assessment7">Impact Assessment (By Technology Transfer / Design)</label>
                                               <textarea class="summernote" name="Technology_transfer_assessment" id="summernote-31">
                                           </textarea>
                                           </div>
                                       </div>
                                       <div class="col-md-12 mb-3">
                                           <div class="group-input">
                                               <label for="Design Feedback"> Technology Transfer / Design  Feedback</label>
                                               <textarea class="summernote" name="Technology_transfer_feedback" id="summernote-32">
                                           </textarea>
                                           </div>
                                       </div>
                                       <div class="col-lg-12">
                                           <div class="group-input">
                                               <label for="Audit Attachments"> Technology Transfer / Design Attachments</label>
                                               <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                               <div class="file-attachment-field">
                                                   <div class="file-attachment-list" id="Technology_transfer_attachment"></div>
                                                   <div class="add-btn">
                                                       <div>Add</div>
                                                       <input type="file" id="myfile" name="Technology_transfer_attachment[]"
                                                           oninput="addMultipleFiles(this, 'Technology_transfer_attachment')" multiple>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="col-md-6 mb-3">
                                           <div class="group-input">
                                               <label for="Design Review Completed By">Technology Transfer / Design Review Completed By</label>
                                               <input type="text" name="Technology_transfer_by" disabled>
                                           
                                           </div>
                                       </div>
                                       <div class="col-lg-6 new-date-data-field">
                                           <div class="group-input input-date">
                                               <label for="Design Review Completed On">Technology Transfer / Design Review Completed On</label>
                                               <div class="calenderauditee">
                                                   <input type="text" id="Technology_transfer_on" readonly placeholder="DD-MMM-YYYY" />
                                                   <input type="date"  name="Technology_transfer_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                       oninput="handleDateInput(this, 'Technology_transfer_on')" />
                                               </div>
                                           </div>
                                       </div>
                                       <div class="sub-head">
                                       Environment, Health & Safety
                                  </div>
                                  <div class="col-lg-6">
                                           <div class="group-input">
                                               <label for="Safety Review Required">Environment, Health & Safety Review Required ?</label>
                                               <select name="Environment_Health_review" id="Environment_Health_review">
                                                   <option value="0">-- Select --</option>
                                                   <option value="yes">Yes</option>
                                                   <option value="no">No</option>
                                                   <option value="na">NA</option>
       
                                               </select>
                                         
                                           </div>
                                       </div>
                                       @php
                                           $division = DB::table('q_m_s_divisions')->where('name', Helpers::getDivisionName(session()->get('division')))->first();
                                           $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 30, 'q_m_s_divisions_id' => $division->id])->get();
                                           $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                           $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                       @endphp
                                       <div class="col-lg-6">
                                           <div class="group-input">
                                               <label for="Safety Person"> Environment, Health & Safety  Person</label>
                                               <select name="Environment_Health_Safety_person" id="Environment_Health_Safety_person">
                                                   <option value="0">-- Select --</option>
                                                   @foreach ($users as $user)
                                                   <option value="{{ $user->id }}">{{ $user->name }}</option>
                                               @endforeach
                                               </select>
                                         
                                           </div>
                                       </div>
                                       <div class="col-md-12 mb-3">
                                           <div class="group-input">
                                               <label for="Impact Assessment8">Impact Assessment (By Environment, Health & Safety)</label>
                                               <textarea class="summernote" name="Health_Safety_assessment" id="summernote-33">
                                           </textarea>
                                           </div>
                                       </div>
                                       <div class="col-md-12 mb-3">
                                           <div class="group-input">
                                               <label for="productionfeedback">Environment, Health & Safety  Feedback</label>
                                               <textarea class="summernote" name="Health_Safety_feedback" id="summernote-34">
                                           </textarea>
                                           </div>
                                       </div>
                                       <div class="col-lg-12">
                                           <div class="group-input">
                                               <label for="Audit Attachments"> Environment, Health & Safety Attachments</label>
                                               <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                               <div class="file-attachment-field">
                                                   <div class="file-attachment-list" id="Environment_Health_Safety_attachment"></div>
                                                   <div class="add-btn">
                                                       <div>Add</div>
                                                       <input type="file" id="myfile" name="Environment_Health_Safety_attachment[]"
                                                           oninput="addMultipleFiles(this, 'Environment_Health_Safety_attachment')" multiple>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
       
                                       <div class="col-md-6 mb-3">
                                           <div class="group-input">
                                               <label for="productionfeedback">Environment, Health & Safety Review Completed By</label>
                                               <input type="text" name="Environment_Health_Safety_by" id="Environment_Health_Safety_by"  disabled>
                                           
                                           </div>
                                       </div>
                                       <div class="col-lg-6 new-date-data-field">
                                           <div class="group-input input-date">
                                               <label for="Safety Review Completed On">Environment, Health & Safety Review Completed On</label>
                                               <div class="calenderauditee">
                                                   <input type="text" id="Environment_Health_Safety_on" readonly placeholder="DD-MMM-YYYY" />
                                                   <input type="date"  name="Environment_Health_Safety_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                       oninput="handleDateInput(this, 'Environment_Health_Safety_on')" />
                                               </div>
                                           </div>
                                       </div>
                                       <div class="sub-head">
                                       Human Resource & Administration
                                  </div>
                                  <div class="col-lg-6">
                                           <div class="group-input">
                                               <label for="Administration Review Required">Human Resource & Administration Review Required ?</label>
                                               <select name="Human_Resource_review" id="Human_Resource_review">
                                                   <option value="0">-- Select --</option>
                                                   <option value="yes">Yes</option>
                                                   <option value="no">No</option>
                                                   <option value="na">NA</option>
       
                                               </select>
                                         
                                           </div>
                                       </div>
                                       @php
                                           $division = DB::table('q_m_s_divisions')->where('name', Helpers::getDivisionName(session()->get('division')))->first();
                                           $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 31, 'q_m_s_divisions_id' => $division->id])->get();
                                           $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                           $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                       @endphp
                                       <div class="col-lg-6">
                                           <div class="group-input">
                                               <label for="Administration Person"> Human Resource & Administration Person</label>
                                               <select name="Human_Resource_person" id="Human_Resource_person">
                                                   <option value="0">-- Select --</option>
                                                   @foreach ($users as $user)
                                                   <option value="{{ $user->id }}">{{ $user->name }}</option>
                                               @endforeach
                                                  
       
                                               </select>
                                         
                                           </div>
                                       </div>
                                       <div class="col-md-12 mb-3">
                                           <div class="group-input">
                                               <label for="Impact Assessment9">Impact Assessment (By Human Resource & Administration )</label>
                                               <textarea class="summernote" name="Human_Resource_assessment" id="summernote-35">
                                           </textarea>
                                           </div>
                                       </div>
                                       <div class="col-md-12 mb-3">
                                           <div class="group-input">
                                               <label for="productionfeedback">Human Resource & Administration  Feedback</label>
                                               <textarea class="summernote" name="Human_Resource_feedback" id="summernote-36">
                                           </textarea>
                                           </div>
                                       </div>
                                       <div class="col-lg-12">
                                           <div class="group-input">
                                               <label for="Audit Attachments"> Human Resource & Administration Attachments</label>
                                               <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                               <div class="file-attachment-field">
                                                   <div class="file-attachment-list" id="Human_Resource_attachment"></div>
                                                   <div class="add-btn">
                                                       <div>Add</div>
                                                       <input type="file" id="myfile" name="Human_Resource_attachment[]"
                                                           oninput="addMultipleFiles(this, 'Human_Resource_attachment')" multiple>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="col-md-6 mb-3">
                                           <div class="group-input">
                                               <label for="Administration Review Completed By"> Human Resource & Administration Review Completed By</label>
                                               <input type="text" name="Human_Resource_by" id="Human_Resource_by" disabled>
                                           
                                           </div>
                                       </div>
                                       <div class="col-lg-6 new-date-data-field">
                                           <div class="group-input input-date">
                                               <label for="Administration Review Completed On">Human Resource & Administration Review Completed On</label>
                                               <div class="calenderauditee">
                                                   <input type="text" id="Human_Resource_on" readonly placeholder="DD-MMM-YYYY" />
                                                   <input type="date"  name="Human_Resource_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                       oninput="handleDateInput(this, 'Human_Resource_on')" />
                                               </div>
                                           </div>
                                       </div>
                                       <div class="sub-head">
                                       Information Technology
                                  </div>
                                  <div class="col-lg-6">
                                           <div class="group-input">
                                               <label for="Information Technology Review Required"> Information Technology Review Required ?</label>
                                               <select name=" Information_Technology_review" id=" Information_Technology_review">
                                                   <option value="0">-- Select --</option>
                                                   <option value="yes">Yes</option>
                                                   <option value="no">No</option>
                                                   <option value="na">NA</option>
       
                                               </select>
                                         
                                           </div>
                                       </div>
                                       @php
                                       $division = DB::table('q_m_s_divisions')->where('name', Helpers::getDivisionName(session()->get('division')))->first();
                                       $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 32, 'q_m_s_divisions_id' => $division->id])->get();
                                       $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                       $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                   @endphp
                                       <div class="col-lg-6">
                                           <div class="group-input">
                                               <label for="Information Technology Person"> Information Technology Person</label>
                                               <select name=" Information_Technology_person" id=" Information_Technology_person">
                                                   <option value="0">-- Select --</option> @foreach ($users as $user)
                                                   <option value="{{ $user->id }}">{{ $user->name }}</option>
                                               @endforeach
                                               </select>
                                         
                                           </div>
                                       </div>
                                       <div class="col-md-12 mb-3">
                                           <div class="group-input">
                                               <label for="Impact Assessment10">Impact Assessment (By Information Technology)</label>
                                               <textarea class="summernote" name="Information_Technology_assessment" id="summernote-37">
                                           </textarea>
                                           </div>
                                       </div>
                                       <div class="col-md-12 mb-3">
                                           <div class="group-input">
                                               <label for="Information Technology Feedback"> Information Technology Feedback</label>
                                               <textarea class="summernote" name="Information_Technology_feedback" id="summernote-38">
                                           </textarea>
                                           </div>
                                       </div>
                                       <div class="col-lg-12">
                                           <div class="group-input">
                                               <label for="Audit Attachments"> Information Technology Attachments</label>
                                               <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                               <div class="file-attachment-field">
                                                   <div class="file-attachment-list" id="Information_Technology_attachment"></div>
                                                   <div class="add-btn">
                                                       <div>Add</div>
                                                       <input type="file" id="myfile" name="Information_Technology_attachment[]"
                                                           oninput="addMultipleFiles(this, 'Information_Technology_attachment')" multiple>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="col-md-6 mb-3">
                                           <div class="group-input">
                                               <label for="Information Technology Review Completed By"> Information Technology Review Completed By</label>
                                               <input type="text" name="Information_Technology_by" disabled>
                                           
                                           </div>
                                       </div>
                                       <div class="col-lg-6 new-date-data-field">
                                           <div class="group-input input-date">
                                               <label for="Information Technology Review Completed On">Information Technology Review Completed On</label>
                                               <div class="calenderauditee">
                                                   <input type="text" id="Information_Technology_on" readonly placeholder="DD-MMM-YYYY" />
                                                   <input type="date"  name="Information_Technology_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                       oninput="handleDateInput(this, 'Information_Technology_on')" />
                                               </div>
                                           </div>
                                       </div>
                                       <div class="sub-head">
                                       Project Management
                                  </div>
                                  <div class="col-lg-6">
                                           <div class="group-input">
                                               <label for="Project management Review Required"> Project management Review Required ?</label>
                                               <select name="Project_management_review" id="Project_management_review">
                                                   <option value="0">-- Select --</option>
                                                   <option value="yes">Yes</option>
                                                   <option value="no">No</option>
                                                   <option value="na">NA</option>
       
                                               </select>
                                         
                                           </div>
                                       </div>
                                       @php
                                           $division = DB::table('q_m_s_divisions')->where('name', Helpers::getDivisionName(session()->get('division')))->first();
                                           $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 33, 'q_m_s_divisions_id' => $division->id])->get();
                                           $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                           $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                       @endphp
                                       <div class="col-lg-6">
                                           <div class="group-input">
                                               <label for="Project management Person"> Project management Person</label>
                                               <select name="Project_management_person" id="Project_management_person">
                                                   <option value="0">-- Select --</option>
                                                   @foreach ($users as $user)
                                                   <option value="{{ $user->id }}">{{ $user->name }}</option>
                                               @endforeach
                                                  
       
                                               </select>
                                         
                                           </div>
                                       </div>
                                       <div class="col-md-12 mb-3">
                                           <div class="group-input">
                                               <label for="Impact Assessment11">Impact Assessment (By  Project management )</label>
                                               <textarea class="summernote" name="Project_management_assessment" id="summernote-39">
                                           </textarea>
                                           </div>
                                       </div>
                                       <div class="col-md-12 mb-3">
                                           <div class="group-input">
                                               <label for="Project management Feedback"> Project management  Feedback</label>
                                               <textarea class="summernote" name="Project_management_feedback" id="summernote-40">
                                           </textarea>
                                           </div>
                                       </div>
                                       <div class="col-lg-12">
                                           <div class="group-input">
                                               <label for="Audit Attachments"> Project management Attachments</label>
                                               <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                               <div class="file-attachment-field">
                                                   <div class="file-attachment-list" id="Project_management_attachment"></div>
                                                   <div class="add-btn">
                                                       <div>Add</div>
                                                       <input type="file" id="myfile" name="Project_management_attachment[]"
                                                           oninput="addMultipleFiles(this, 'Project_management_attachment')" multiple>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
       
                                       <div class="col-md-6 mb-3">
                                           <div class="group-input">
                                               <label for="Project management Review Completed By"> Project management Review Completed By</label>
                                               <input type="text" name="Project_management_by"id="Project_management_by" disabled>
                                           
                                           </div>
                                       </div>
                                       <div class="col-lg-6 new-date-data-field">
                                           <div class="group-input input-date">
                                               <label for="Project management Review Completed On">Information Technology Review Completed On</label>
                                               <div class="calenderauditee">
                                                   <input type="text" id="Project_management_on" readonly placeholder="DD-MMM-YYYY" />
                                                   <input type="date"  name="Project_management_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                       oninput="handleDateInput(this, 'Project_management_on')" />
                                               </div>
                                           </div>
                                       </div>
                                       <div class="sub-head">
                                           Other's 1 ( Additional Person Review From Departments If Required)
                                      </div>
                                      <div class="col-lg-6">
                                               <div class="group-input">
                                                   <label for="Customer notification"> Other's 1 Review Required ?</label>
                                                   <select name="Other1_review" id="Other1_review">
                                                       <option value="0">-- Select --</option>
                                                       <option value="yes">Yes</option>
                                                       <option value="no">No</option>
                                                       <option value="na">NA</option>
           
                                                   </select>
                                             
                                               </div>
                                           </div>
                                           @php
                                           $division = DB::table('q_m_s_divisions')->where('name', Helpers::getDivisionName(session()->get('division')))->first();
                                           $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 33, 'q_m_s_divisions_id' => $division->id])->get();
                                           $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                           $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                       @endphp
                                           <div class="col-lg-6">
                                               <div class="group-input">
                                                   <label for="Customer notification"> Other's 1 Person</label>
                                                   <select name="Other1_person" id="Other1_person">
                                                       <option value="0">-- Select --</option>
                                                       @foreach ($users as $user)
                                                       <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                   @endforeach                                               
           
                                                   </select>
                                             
                                               </div>
                                           </div>
                                           <div class="col-lg-12">
                                               <div class="group-input">
                                                   <label for="Customer notification"> Other's 1 Department</label>
                                                   <select name="Other1_Department_person" id="Other1_Department_person">
                                                       <option value="0">-- Select --</option>
                                                       <option value="Production">Production</option>
                                                       <option value="Warehouse">Warehouse</option>
                                                       <option value="Quality_Control">Quality Control</option>
                                                       <option value="Quality_Assurance">Quality Assurance</option>
                                                       <option value="Engineering">Engineering</option>
                                                       <option value="Analytical_Development_Laboratory">Analytical Development Laboratory</option>
                                                       <option value="Process_Development_Lab">Process Development Laboratory / Kilo Lab</option>
                                                       <option value="Technology transfer/Design">Technology Transfer/Design</option>
                                                       <option value="Environment, Health & Safety">Environment, Health & Safety</option>
                                                       <option value="Human Resource & Administration">Human Resource & Administration</option>
                                                       <option value="Information Technology">Information Technology</option>
                                                       <option value="Project management">Project management</option>
                                                       
           
           
                                                   </select>
                                             
                                               </div>
                                           </div>
                                           <div class="col-md-12 mb-3">
                                               <div class="group-input">
                                                   <label for="productionfeedback">Impact Assessment (By  Other's 1)</label>
                                                   <textarea class="summernote" name="Other1_assessment" id="summernote-41">
                                               </textarea>
                                               </div>
                                           </div>
                                           <div class="col-md-12 mb-3">
                                               <div class="group-input">
                                                   <label for="productionfeedback"> Other's 1 Feedback</label>
                                                   <textarea class="summernote" name="Other1_feedback" id="summernote-42">
                                               </textarea>
                                               </div>
                                           </div>
                                           <div class="col-lg-12">
                                               <div class="group-input">
                                                   <label for="Audit Attachments"> Other's 1 Attachments</label>
                                                   <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                   <div class="file-attachment-field">
                                                       <div class="file-attachment-list" id="Other1_attachment"></div>
                                                       <div class="add-btn">
                                                           <div>Add</div>
                                                           <input type="file" id="myfile" name="Other1_attachment[]"
                                                               oninput="addMultipleFiles(this, 'Other1_attachment')" multiple>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="col-md-6 mb-3">
                                               <div class="group-input">
                                                   <label for="productionfeedback"> Other's 1 Review Completed By</label>
                                                   <input type="text" name="Other1_by" disabled>
                                               
                                               </div>
                                           </div>
                                           <div class="col-lg-6 new-date-data-field">
                                               <div class="group-input input-date">
                                                   <label for="Review Completed On1">Other's 1 Review Completed On</label>
                                                   <div class="calenderauditee">
                                                       <input type="text" id="Other1_on" readonly placeholder="DD-MMM-YYYY" />
                                                       <input type="date"  name="Other1_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                           oninput="handleDateInput(this, 'Other1_on')" />
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="sub-head">
                                           Other's 2 ( Additional Person Review From Departments If Required)
                                      </div>
                                      <div class="col-lg-6">
                                               <div class="group-input">
                                                   <label for="Customer notification"> Other's 2 Review Required ?</label>
                                                   <select name="Other2_review" id="Other2_review">
                                                       <option value="0">-- Select --</option>
                                                       <option value="yes">Yes</option>
                                                       <option value="no">No</option>
                                                       <option value="na">NA</option>
           
                                                   </select>
                                             
                                               </div>
                                           </div>
                                           @php
                                           $division = DB::table('q_m_s_divisions')->where('name', Helpers::getDivisionName(session()->get('division')))->first();
                                           $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 33, 'q_m_s_divisions_id' => $division->id])->get();
                                           $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                           $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                           @endphp
                                           <div class="col-lg-6">
                                               <div class="group-input">
                                                   <label for="Customer notification"> Other's 2 Person</label>
                                                   <select name="Other2_person" id="Other2_person">
                                                       <option value="0">-- Select --</option>
                                                       @foreach ($users as $user)
                                                       <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                   @endforeach                                               
           
                                                   </select>
                                             
                                               </div>
                                           </div>
                                           <div class="col-lg-12">
                                               <div class="group-input">
                                                   <label for="Customer notification"> Other's 2 Department</label>
                                                   <select name="Other2_Department_person" id="Other2_Department_person">
                                                       <option value="0">-- Select --</option>
                                                       <option value="Production">Production</option>
                                                       <option value="Warehouse">Warehouse</option>
                                                       <option value="Quality_Control">Quality Control</option>
                                                       <option value="Quality_Assurance">Quality Assurance</option>
                                                       <option value="Engineering">Engineering</option>
                                                       <option value="Analytical_Development_Laboratory">Analytical Development Laboratory</option>
                                                       <option value="Process_Development_Lab">Process Development Laboratory / Kilo Lab</option>
                                                       <option value="Technology transfer/Design">Technology Transfer/Design</option>
                                                       <option value="Environment, Health & Safety">Environment, Health & Safety</option>
                                                       <option value="Human Resource & Administration">Human Resource & Administration</option>
                                                       <option value="Information Technology">Information Technology</option>
                                                       <option value="Project management">Project management</option>
                                                       
           
           
                                                   </select>
                                             
                                               </div>
                                           </div>
                                           <div class="col-md-12 mb-3">
                                               <div class="group-input">
                                                   <label for="Impact Assessment13">Impact Assessment (By  Other's 2)</label>
                                                   <textarea class="summernote" name="Other2_Assessment" id="summernote-43">
                                               </textarea>
                                               </div>
                                           </div>
                                           <div class="col-md-12 mb-3">
                                               <div class="group-input">
                                                   <label for="Feedback2"> Other's 2 Feedback</label>
                                                   <textarea class="summernote" name="Other2_feedback" id="summernote-44">
                                               </textarea>
                                               </div>
                                           </div>
                                           <div class="col-lg-12">
                                               <div class="group-input">
                                                   <label for="Audit Attachments"> Other's 2 Attachments</label>
                                                   <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                   <div class="file-attachment-field">
                                                       <div class="file-attachment-list" id="Other2_attachment"></div>
                                                       <div class="add-btn">
                                                           <div>Add</div>
                                                           <input type="file" id="myfile" name="Other2_attachment[]"
                                                               oninput="addMultipleFiles(this, 'Other2_attachment')" multiple>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="col-md-6 mb-3">
                                               <div class="group-input">
                                                   <label for="Review Completed By2"> Other's 2 Review Completed By</label>
                                                   <input type="text" name="Other2_by" disabled>
                                               
                                               </div>
                                           </div>
                                           <div class="col-lg-6 new-date-data-field">
                                               <div class="group-input input-date">
                                                   <label for="Review Completed On2">Other's 2 Review Completed On</label>
                                                   <div class="calenderauditee">
                                                       <input type="text" id="Other2_on" readonly placeholder="DD-MMM-YYYY" />
                                                       <input type="date"  name="Other2_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                           oninput="handleDateInput(this, 'Other2_on')" />
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="sub-head">
                                           Other's 3 ( Additional Person Review From Departments If Required)
                                      </div>
                                      <div class="col-lg-6">
                                               <div class="group-input">
                                                   <label for="Customer notification"> Other's 3 Review Required ?</label>
                                                   <select name="Other3_review" id="Other3_review">
                                                       <option value="0">-- Select --</option>
                                                       <option value="yes">Yes</option>
                                                       <option value="no">No</option>
                                                       <option value="na">NA</option>
           
                                                   </select>
                                             
                                               </div>
                                           </div>
                                           @php
                                           $division = DB::table('q_m_s_divisions')->where('name', Helpers::getDivisionName(session()->get('division')))->first();
                                           $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 33, 'q_m_s_divisions_id' => $division->id])->get();
                                           $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                           $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                            @endphp
                                           <div class="col-lg-6">
                                               <div class="group-input">
                                                   <label for="Customer notification"> Other's 3 Person</label>
                                                   <select name="Other3_person" id="Other3_person">
                                                       <option value="0">-- Select --</option>
                                                       @foreach ($users as $user)
                                                       <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                   @endforeach                                               
           
                                                   </select>
                                             
                                               </div>
                                           </div>
                                           <div class="col-lg-12">
                                               <div class="group-input">
                                                   <label for="Customer notification"> Other's 3 Department</label>
                                                   <select name="Other3_Department_person" id="Other3_Department_person">
                                                       <option value="0">-- Select --</option>
                                                       <option value="Production">Production</option>
                                                       <option value="Warehouse">Warehouse</option>
                                                       <option value="Quality_Control">Quality Control</option>
                                                       <option value="Quality_Assurance">Quality Assurance</option>
                                                       <option value="Engineering">Engineering</option>
                                                       <option value="Analytical_Development_Laboratory">Analytical Development Laboratory</option>
                                                       <option value="Process_Development_Lab">Process Development Laboratory / Kilo Lab</option>
                                                       <option value="Technology transfer/Design">Technology Transfer/Design</option>
                                                       <option value="Environment, Health & Safety">Environment, Health & Safety</option>
                                                       <option value="Human Resource & Administration">Human Resource & Administration</option>
                                                       <option value="Information Technology">Information Technology</option>
                                                       <option value="Project management">Project management</option>
                                                       
           
           
                                                   </select>
                                             
                                               </div>
                                           </div>
                                           <div class="col-md-12 mb-3">
                                               <div class="group-input">
                                                   <label for="productionfeedback">Impact Assessment (By  Other's 3)</label>
                                                   <textarea class="summernote" name="Other3_Assessment" id="summernote-45">
                                               </textarea>
                                               </div>
                                           </div>
                                           <div class="col-md-12 mb-3">
                                               <div class="group-input">
                                                   <label for="productionfeedback"> Other's 3 Feedback</label>
                                                   <textarea class="summernote" name="Other3_feedback" id="summernote-46">
                                               </textarea>
                                               </div>
                                           </div>
                                           <div class="col-lg-12">
                                               <div class="group-input">
                                                   <label for="Audit Attachments"> Other's 3 Attachments</label>
                                                   <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                   <div class="file-attachment-field">
                                                       <div class="file-attachment-list" id="Other3_attachment"></div>
                                                       <div class="add-btn">
                                                           <div>Add</div>
                                                           <input type="file" id="myfile" name="Other3_attachment[]"
                                                               oninput="addMultipleFiles(this, 'Other3_attachment')" multiple>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="col-md-6 mb-3">
                                               <div class="group-input">
                                                   <label for="productionfeedback"> Other's 3 Review Completed By</label>
                                                   <input type="text" name="Other3_by" disabled>
                                               
                                               </div>
                                           </div>
                                           <div class="col-lg-6 new-date-data-field">
                                               <div class="group-input input-date">
                                                   <label for="Review Completed On3">Other's 3 Review Completed On</label>
                                                   <div class="calenderauditee">
                                                       <input type="text" id="Other3_on" readonly placeholder="DD-MMM-YYYY" />
                                                       <input type="date"  name="Other3_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                           oninput="handleDateInput(this, 'Other3_on')" />
                                                   </div>
                                               </div>
                                           </div>
           
                                           <div class="sub-head">
                                           Other's 4 ( Additional Person Review From Departments If Required)
                                      </div>
                                      <div class="col-lg-6">
                                               <div class="group-input">
                                                   <label for="review4"> Other's 4 Review Required ?</label>
                                                   <select name="Other4_review" id="Other4_review">
                                                       <option value="0">-- Select --</option>
                                                       <option value="yes">Yes</option>
                                                       <option value="no">No</option>
                                                       <option value="na">NA</option>
           
                                                   </select>
                                             
                                               </div>
                                           </div>
                                           @php
                                           $division = DB::table('q_m_s_divisions')->where('name', Helpers::getDivisionName(session()->get('division')))->first();
                                           $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 33, 'q_m_s_divisions_id' => $division->id])->get();
                                           $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                            $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                           @endphp
                                            <div class="col-lg-6">
                                               <div class="group-input">
                                                   <label for="Person4"> Other's 4 Person</label>
                                                   <select name="Other4_person" id="Other4_person">
                                                       <option value="0">-- Select --</option>
                                                       @foreach ($users as $user)
                                                       <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                   @endforeach                                               
           
                                                   </select>
                                             
                                               </div>
                                           </div>
                                           <div class="col-lg-12">
                                               <div class="group-input">
                                                   <label for="Department4"> Other's 4 Department</label>
                                                   <select name="Other4_Department_person" id="Other4_Department_person">
                                                       <option value="0">-- Select --</option>
                                                       <option value="Production">Production</option>
                                                       <option value="Warehouse">Warehouse</option>
                                                       <option value="Quality_Control">Quality Control</option>
                                                       <option value="Quality_Assurance">Quality Assurance</option>
                                                       <option value="Engineering">Engineering</option>
                                                       <option value="Analytical_Development_Laboratory">Analytical Development Laboratory</option>
                                                       <option value="Process_Development_Lab">Process Development Laboratory / Kilo Lab</option>
                                                       <option value="Technology transfer/Design">Technology Transfer/Design</option>
                                                       <option value="Environment, Health & Safety">Environment, Health & Safety</option>
                                                       <option value="Human Resource & Administration">Human Resource & Administration</option>
                                                       <option value="Information Technology">Information Technology</option>
                                                       <option value="Project management">Project management</option>
                                                       
           
           
                                                   </select>
                                             
                                               </div>
                                           </div>
                                           <div class="col-md-12 mb-3">
                                               <div class="group-input">
                                                   <label for="Impact Assessment15">Impact Assessment (By  Other's 4)</label>
                                                   <textarea class="summernote" name="Other4_Assessment" id="summernote-47">
                                               </textarea>
                                               </div>
                                           </div>
                                           <div class="col-md-12 mb-3">
                                               <div class="group-input">
                                                   <label for="feedback4"> Other's 4 Feedback</label>
                                                   <textarea class="summernote" name="Other4_feedback" id="summernote-48">
                                               </textarea>
                                               </div>
                                           </div>
                                           <div class="col-lg-12">
                                               <div class="group-input">
                                                   <label for="Audit Attachments"> Other's 4 Attachments</label>
                                                   <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                   <div class="file-attachment-field">
                                                       <div class="file-attachment-list" id="Other4_attachment"></div>
                                                       <div class="add-btn">
                                                           <div>Add</div>
                                                           <input type="file" id="myfile" name="Other4_attachment[]"
                                                               oninput="addMultipleFiles(this, 'Other4_attachment')" multiple>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="col-md-6 mb-3">
                                               <div class="group-input">
                                                   <label for="Review Completed By4"> Other's 4 Review Completed By</label>
                                                   <input type="text" name="Other4_by" disabled>
                                               
                                               </div>
                                           </div>
                                           <div class="col-lg-6 new-date-data-field">
                                               <div class="group-input input-date">
                                                   <label for="Review Completed On4">Other's 4 Review Completed On</label>
                                                   <div class="calenderauditee">
                                                       <input type="text" id="Other4_on" readonly placeholder="DD-MMM-YYYY" />
                                                       <input type="date"  name="Other4_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                           oninput="handleDateInput(this, 'Other4_on')" />
                                                   </div>
                                               </div>
                                           </div>
           
           
                                           <div class="sub-head">
                                           Other's 5 ( Additional Person Review From Departments If Required)
                                      </div>
                                      <div class="col-lg-6">
                                               <div class="group-input">
                                                   <label for="review5"> Other's 5 Review Required ?</label>
                                                   <select name="Other5_review" id="Other5_review">
                                                       <option value="0">-- Select --</option>
                                                       <option value="yes">Yes</option>
                                                       <option value="no">No</option>
                                                       <option value="na">NA</option>
           
                                                   </select>
                                             
                                               </div>
                                           </div>
                                           @php
                                           $division = DB::table('q_m_s_divisions')->where('name', Helpers::getDivisionName(session()->get('division')))->first();
                                           $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 33, 'q_m_s_divisions_id' => $division->id])->get();
                                           $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                           $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                           @endphp
                                           <div class="col-lg-6">
                                               <div class="group-input">
                                                   <label for="Person5">Other's 5 Person</label>
                                                   <select name="Other5_person" id="Other5_person">
                                                       <option value="0">-- Select --</option>
                                                       @foreach ($users as $user)
                                                       <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                   @endforeach                                               
           
                                                   </select>
                                             
                                               </div>
                                           </div>
                                           <div class="col-lg-12">
                                               <div class="group-input">
                                                   <label for="Department5"> Other's 5 Department</label>
                                                   <select name="Other5_Department_person" id="Other5_Department_person">
                                                       <option value="0">-- Select --</option>
                                                       <option value="Production">Production</option>
                                                       <option value="Warehouse">Warehouse</option>
                                                       <option value="Quality_Control">Quality Control</option>
                                                       <option value="Quality_Assurance">Quality Assurance</option>
                                                       <option value="Engineering">Engineering</option>
                                                       <option value="Analytical_Development_Laboratory">Analytical Development Laboratory</option>
                                                       <option value="Process_Development_Lab">Process Development Laboratory / Kilo Lab</option>
                                                       <option value="Technology transfer/Design">Technology Transfer/Design</option>
                                                       <option value="Environment, Health & Safety">Environment, Health & Safety</option>
                                                       <option value="Human Resource & Administration">Human Resource & Administration</option>
                                                       <option value="Information Technology">Information Technology</option>
                                                       <option value="Project management">Project management</option>
                                                       
           
           
                                                   </select>
                                             
                                               </div>
                                           </div>
                                           <div class="col-md-12 mb-3">
                                               <div class="group-input">
                                                   <label for="productionfeedback">Impact Assessment (By  Other's 5)</label>
                                                   <textarea class="summernote" name="Other5_Assessment" id="summernote-49">
                                               </textarea>
                                               </div>
                                           </div>
                                           <div class="col-md-12 mb-3">
                                               <div class="group-input">
                                                   <label for="productionfeedback"> Other's 5 Feedback</label>
                                                   <textarea class="summernote" name="Other5_feedback" id="summernote-50">
                                               </textarea>
                                               </div>
                                           </div>
                                           <div class="col-lg-12">
                                               <div class="group-input">
                                                   <label for="Audit Attachments"> Other's 5 Attachments</label>
                                                   <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                   <div class="file-attachment-field">
                                                       <div class="file-attachment-list" id="Other5_attachment"></div>
                                                       <div class="add-btn">
                                                           <div>Add</div>
                                                           <input type="file" id="myfile" name="Other5_attachment[]"
                                                               oninput="addMultipleFiles(this, 'Other5_attachment')" multiple>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="col-md-6 mb-3">
                                               <div class="group-input">
                                                   <label for="Review Completed By5"> Other's 5 Review Completed By</label>
                                                   <input type="text" name="Other5_by" disabled>
                                               
                                               </div>
                                           </div>
                                           <div class="col-lg-6 new-date-data-field">
                                               <div class="group-input input-date">
                                                   <label for="Review Completed On5">Other's 5 Review Completed On</label>
                                                   <div class="calenderauditee">
                                                       <input type="text" id="Other5_on" readonly placeholder="DD-MMM-YYYY" />
                                                       <input type="date"  name="Other5_on" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                           oninput="handleDateInput(this, 'Other5_on')" />
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="button-block">
                                           <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                                           <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                           <button type="button" id="ChangeNextButton" class="nextButton" onclick="nextStep()">Next</button>
                                           <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                                   Exit </a> </button>
                                       </div>
                                       {{-- <div class="col-12">
                  
                                      </div> --}}
                                    </div>
                                </div>
                            </div>
                       </div>
          
                <!--============================================================================================ -->

                <div id="CCForm4" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="comments">Final Comments</label>
                                    <textarea name="cft_comments_new"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Inv Attachments">Final Attachment</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="cft_attchament_new"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="cft_attchament_new[]" oninput="addMultipleFiles(this, 'cft_attchament_new')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="comments">Final Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="cft_attchament_new"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="cft_attchament_new[]"
                                                    oninput="addMultipleFiles(this, 'cft_attchament_new')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <div class="row">
                                <div class="sub-head">
                                    Concerned Group Feedback
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="comments">QA Comments</label>
                                        <textarea name="qa_comments_new"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="comments">QA Head Designee Comments</label>
                                        <textarea name="designee_comments_new"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="comments">Warehouse Comments</label>
                                        <textarea name="Warehouse_comments_new"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="comments">Engineering Comments</label>
                                        <textarea name="Engineering_comments_new"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="comments">Instrumentation Comments</label>
                                        <textarea name="Instrumentation_comments_new"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="comments">Validation Comments</label>
                                        <textarea name="Validation_comments_new"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="comments">Others Comments</label>
                                        <textarea name="Others_comments_new"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="comments">Group Comments</label>
                                        <textarea name="Group_comments_new"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="group-attachments">Group Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="group_attachments_new"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="group_attachments_new[]"
                                                    oninput="addMultipleFiles(this, 'group_attachments_new')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit </a> </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="completed_by">Submit By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="completed_on">Submit On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Acknowledge_By..">HOD Review Complete By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Acknowledge_On">HOD Review Complete On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Submit_By">Responsible Person Update By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Submit_On">SubmitResponsible Person Update On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="QA_Review_Complete_By">QA Review CompleteInitial QA Review By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="QA_Review_Complete_On">Initial QA Review On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled By">CFT Review By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled On">CFT Review On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled On">QA Approve Review BY</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled On">QA Approve Review On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled On">HOD Final Review By </label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled On">HOD Final Review On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled On">Child Closure By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled On">Child Closure On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled On">Close-Done By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled On">Close-Done On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled On">Re-open Addendum By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled On">Re-open Addendum On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled On">Addendum Approved By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled On"> Addendum Approved On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled On">Under Addendum Execution By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled On">Under Addendum Execution On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled On">Re-open Child Close By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled On">Re-open Child Close On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled On">Under Addendum Verification By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled On">Under Addendum Verification On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled On">Closed-Done By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled On">Closed-Done On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="submit">Submit</button>
                            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
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
        ele: '#investigators, #department, #root-cause-methodology'
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
    function addFishBone(top, bottom) {
        let mainBlock = document.querySelector('.fishbone-ishikawa-diagram');
        let topBlock = mainBlock.querySelector(top)
        let bottomBlock = mainBlock.querySelector(bottom)

        let topField = document.createElement('div')
        topField.className = 'grid-field fields top-field'

        let measurement = document.createElement('div')
        let measurementInput = document.createElement('input')
        measurementInput.setAttribute('type', 'text')
        measurementInput.setAttribute('name', 'measurement[]')
        measurement.append(measurementInput)
        topField.append(measurement)

        let materials = document.createElement('div')
        let materialsInput = document.createElement('input')
        materialsInput.setAttribute('type', 'text')
        materialsInput.setAttribute('name', 'materials[]')
        materials.append(materialsInput)
        topField.append(materials)

        let methods = document.createElement('div')
        let methodsInput = document.createElement('input')
        methodsInput.setAttribute('type', 'text')
        methodsInput.setAttribute('name', 'methods[]')
        methods.append(methodsInput)
        topField.append(methods)

        topBlock.prepend(topField)

        let bottomField = document.createElement('div')
        bottomField.className = 'grid-field fields bottom-field'

        let environment = document.createElement('div')
        let environmentInput = document.createElement('input')
        environmentInput.setAttribute('type', 'text')
        environmentInput.setAttribute('name', 'environment[]')
        environment.append(environmentInput)
        bottomField.append(environment)

        let manpower = document.createElement('div')
        let manpowerInput = document.createElement('input')
        manpowerInput.setAttribute('type', 'text')
        manpowerInput.setAttribute('name', 'manpower[]')
        manpower.append(manpowerInput)
        bottomField.append(manpower)

        let machine = document.createElement('div')
        let machineInput = document.createElement('input')
        machineInput.setAttribute('type', 'text')
        machineInput.setAttribute('name', 'machine[]')
        machine.append(machineInput)
        bottomField.append(machine)

        bottomBlock.append(bottomField)
    }

    function deleteFishBone(top, bottom) {
        let mainBlock = document.querySelector('.fishbone-ishikawa-diagram');
        let topBlock = mainBlock.querySelector(top)
        let bottomBlock = mainBlock.querySelector(bottom)
        if (topBlock.firstChild) {
            topBlock.removeChild(topBlock.firstChild);
        }
        if (bottomBlock.lastChild) {
            bottomBlock.removeChild(bottomBlock.lastChild);
        }
    }
</script>

<script>
    function addWhyField(con_class, name) {
        let mainBlock = document.querySelector('.why-why-chart')
        let container = mainBlock.querySelector(`.${con_class}`)
        let textarea = document.createElement('textarea')
        textarea.setAttribute('name', name);
        container.append(textarea)
    }
</script>

<script>
    function calculateInitialResult(selectElement) {
        let row = selectElement.closest('tr');
        let R = parseFloat(row.querySelector('.fieldR').value) || 0;
        let P = parseFloat(row.querySelector('.fieldP').value) || 0;
        let N = parseFloat(row.querySelector('.fieldN').value) || 0;
        let result = R * P * N;
        row.querySelector('.initial-rpn').value = result;
    }
</script>

<script>
    function calculateResidualResult(selectElement) {
        let row = selectElement.closest('tr');
        let R = parseFloat(row.querySelector('.residual-fieldR').value) || 0;
        let P = parseFloat(row.querySelector('.residual-fieldP').value) || 0;
        let N = parseFloat(row.querySelector('.residual-fieldN').value) || 0;
        let result = R * P * N;
        row.querySelector('.residual-rpn').value = result;
    }
</script>
<script>
    document.getElementById('initiator_group').addEventListener('change', function() {
        var selectedValue = this.value;
        document.getElementById('initiator_group_code').value = selectedValue;
    });

    function setCurrentDate(item) {
        if (item == 'yes') {
            $('#effect_check_date').val('{{ date('
                d - M - Y ')}}');
        } else {
            $('#effect_check_date').val('');
        }
    }
</script>
<script>
    document.getElementById('initiator_group').addEventListener('change', function() {
        var selectedValue = this.value;
        document.getElementById('initiator_group_code').value = selectedValue;
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const removeButtons = document.querySelectorAll('.remove-file');

        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const fileName = this.getAttribute('data-file-name');
                const fileContainer = this.closest('.file-container');

                // Hide the file container
                if (fileContainer) {
                    fileContainer.style.display = 'none';
                }
            });
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

<style>
    #step-form>div {
        display: none
    }

    #step-form>div:nth-child(1) {
        display: block;
    }
</style>
{{-- <script>
    document.getElementById('myfile').addEventListener('change', function() {
        var fileListDiv = document.querySelector('.file-list');
        fileListDiv.innerHTML = ''; // Clear previous entries

        for (var i = 0; i < this.files.length; i++) {
            var file = this.files[i];
            var listItem = document.createElement('div');
            listItem.textContent = file.name;
            fileListDiv.appendChild(listItem);
        }
    });
</script> --}}

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

@endsection